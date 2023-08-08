<?php

namespace App\Http\Controllers\Calculator;

use App\Exports\DowntimeExport;
use App\Exports\OeeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\OeeRequest;
use App\Models\DownTime;
use App\Models\Maintenance;
use App\Models\Oee;
use App\Models\PerhitunganOEE;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OeeController extends Controller
{
    public function index(Request $request)
    {
        $userLogin = Auth::id();
        if (Auth::check()) {
            $maintenance  = Maintenance::where('id_pengguna', $userLogin);
            $namaMesin = $maintenance->pluck('nama_mesin')->toArray();
            return view('pages.calculator.oee', compact('namaMesin'));
        } else {
            return view('pages.calculator.oee');
        }
    }

    public function store(OeeRequest $request)
    {
        try {
            DB::beginTransaction();
            function getMinuteDifference($start, $end)
            {
                if (empty($start) || strpos($start, ':') === false || empty($end) || strpos($end, ':') === false) {
                    return 0; // Return 0 for invalid or empty time format
                }

                $startParts = explode(':', $start);
                $endParts = explode(':', $end);
                $startHours = (int)$startParts[0];
                $startMinutes = (int)$startParts[1];
                $endHours = (int)$endParts[0];
                $endMinutes = (int)$endParts[1];

                $startInMinutes = $startHours * 60 + $startMinutes;
                $endInMinutes = $endHours * 60 + $endMinutes;

                return $endInMinutes - $startInMinutes;
            }
            $attr = $request->validated();
            $existingMaintenance = Maintenance::where('nama_mesin', $attr['nama_mesin'])->first();
            if ($existingMaintenance) {
                // Jika sudah ada, gunakan data yang sudah ada
                $maintenance = $existingMaintenance;
            } else {
                // Jika belum ada, buat data baru
                $maintenance = new Maintenance();
                $maintenance->id_pengguna = Auth::user()->id;
                $maintenance->nama_mesin = $attr['nama_mesin'];
                $maintenance->save();
            }

            $sisaWaktu = getMinuteDifference($attr['waktu_mulai_produksi'], $attr['waktu_selesai_produksi']);
            $jumlahDowntime = getMinuteDifference($attr['jam_mulai_downtime'] ?? 0, $attr['jam_selesai_downtime']) ?? 0;
            $downTimeTerencana = getMinuteDifference($attr['mulai_downtime_terencana'] ?? 0, $attr['selesai_downtime_terencana' ?? 0]);
            $waktuTotalProduksi = $sisaWaktu - $jumlahDowntime - $downTimeTerencana;

            $perhitungan = new PerhitunganOEE();
            $perhitungan->id_mesin = $maintenance->id;
            $perhitungan->waktu_mulai_produksi = $attr['waktu_mulai_produksi'];
            $perhitungan->waktu_selesai_produksi = $attr['waktu_selesai_produksi'];
            $perhitungan->waktu_total_produksi = $waktuTotalProduksi;
            $perhitungan->down_time_terencana = $downTimeTerencana;
            $perhitungan->total_produksi = $attr['total_produksi'];
            $perhitungan->tingkat_produksi_ideal = $attr['tingkat_produksi_ideal'];
            $perhitungan->produksi_cacat = $attr['produksi_cacat'];
            $perhitungan->produksi_baik = $attr['total_produksi'] - $attr['produksi_cacat'];
            $perhitungan->save();

            $downTime = new DownTime();
            $downTime->id_perhitungan = $perhitungan->id;
            $downTime->jenis_downtime = $attr['jenis_downtime'];
            $downTime->jam_mulai_downtime = $attr['jam_mulai_downtime'] ?? 0;
            $downTime->jam_selesai_downtime = $attr['jam_selesai_downtime'] ?? 0;
            $downTime->jumlah_downtime = $jumlahDowntime;
            $downTime->save();

            $oee = new Oee();
            $oee->id_perhitungan = $perhitungan->id;
            // Availability
            $availability = ($waktuTotalProduksi / $sisaWaktu) * 100;
            $availability = round($availability, 2);
            $availability = max(0, $availability);
            $availability = min(100, $availability);
            $oee->avaibility = $availability;
            // Performance
            $totalWaktuPeformance = ($attr['total_produksi'] / $waktuTotalProduksi);
            $performance = $totalWaktuPeformance /  $attr['tingkat_produksi_ideal'];
            $performance = round($performance * 100, 2);
            $performance = max(0, $performance);
            $performance = min(100, $performance);
            $oee->performance = $performance;

            // Quality
            $quality = ($attr['total_produksi'] - $attr['produksi_cacat']) / $attr['total_produksi'];
            $quality = round($quality * 100, 2);
            $quality = max(0, $quality);
            $quality = min(100, $quality);
            $oee->quality = $quality;

            // Calculate OEE
            $oeeValue = ($availability / 100) * ($performance / 100) * ($quality / 100);
            $oeeValue = round($oeeValue * 100, 2);
            $oeeValue = max(0, $oeeValue);
            $oeeValue = min(100, $oeeValue);
            $oee->result_oee = $oeeValue;

            if ($oeeValue >= 85) {
                $oee->status_oee = 'sudah baik';
            } else {
                $oee->status_oee = 'perlu pengecekan';
            }

            $oee->save();

            DB::commit();

            Alert::success('Sukses', 'Berhasil Menyimpan Data');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal Menyimpan Data ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function exportOee(Request $request)
    {
        if (Auth::check()) {
            $request->validate(
                [
                    'start_date' => 'required',
                    'end_date' => 'required|after:start_date',
                    'nama_mesin' => 'required',
                ],
                [
                    'start_date.required' => 'Tanggal mulai harus diisi.',
                    'end_date.required' => 'Tanggal berakhir harus diisi.',
                    'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
                    'nama_mesin.required' => 'Nama mesin harus diisi.',
                ]
            );

            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $nama_mesin = $request->nama_mesin;

            if ($start_date && $end_date && $nama_mesin) {
                return Excel::download(new OeeExport($start_date, $end_date, $nama_mesin), 'Riwayat OEE ' . $start_date . ' - ' . $end_date . '.xlsx');
            }
        } else {
            return redirect('login');
        }
    }

    public function destroy(string $id)
    {
        try {
            if (Auth::check()) {

                $oee = PerhitunganOEE::where('id_mesin', $id)->first();

                // $maintenance = Maintenance::where('id', $id)->first();

                DB::transaction(function () use ($oee) {
                    $oee->downtime->delete();
                    $oee->oee->delete();
                    $oee->delete();
                });

                // if ($maintenance) {
                //     DB::transaction(function () use ($maintenance) {
                //         $maintenance->delete();
                //     });
                // }
                Alert::success('Sukses', 'Data Berhasil Dihapus');

                return redirect()->back();
            } else {
                return redirect('login');
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal menghapus data ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
