<?php

namespace App\Http\Controllers\Calculator;

use App\Exports\LccExport;
use App\Exports\OeeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\LccRequest;
use App\Models\Lcc;
use App\Models\Maintenance;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LccController extends Controller
{
    public function index()
    {
        $userLogin = Auth::id();
        if (Auth::check()) {
            $maintenance  = Maintenance::where('id_pengguna', $userLogin);
            $namaMesin = $maintenance->pluck('nama_mesin')->toArray();
            return view('pages.calculator.lcc', compact('namaMesin'));
        } else {
            return view('pages.calculator.lcc');
        }
    }

    public function store(LccRequest $request)
    {
        try {
            DB::beginTransaction();

            if (Auth::check()) {
                // validation
                $attr = $request->validated();

                // Process
                $lcc = $attr['biaya_inisiasi'] + ($attr['estimasi_tahunan'] * $attr['biaya_operasional_tahunan']) + ($attr['estimasi_tahunan'] * $attr['biaya_pemeliharaan_tahunan']) + $attr['biaya_pembongkaran'];

                // Insert Data Maintenance
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

                // Insert Data Detail Maintenance
                $data = new Lcc();
                $data->id_mesin = $maintenance->id;
                $data->biaya_inisiasi = $attr['biaya_inisiasi'];
                $data->biaya_operasional_tahunan = $attr['biaya_operasional_tahunan'];
                $data->biaya_pemeliharaan_tahunan = $attr['biaya_pemeliharaan_tahunan'];
                $data->biaya_pembongkaran = $attr['biaya_pembongkaran'];
                $data->estimasi_tahunan = $attr['estimasi_tahunan'];
                $data->result_lcc = $lcc;
                $data->save();
            }

            DB::commit();
            Alert::success('Sukses', 'Berhasil Menyimpan Data');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal Menyimpan Data ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function exportLcc()
    {
        if (Auth::check()) {
            return Excel::download(new LccExport, 'Riwayat LCC.xlsx');
        } else {
            return redirect('login');
        }
    }

    public function destroy(string $id)
    {
        try {
            if (Auth::check()) {

                $lcc = Lcc::where('id_mesin', $id)->first();

                // $maintenance = Maintenance::where('id', $id)
                //     ->first();

                DB::transaction(function () use ($lcc) {
                    $lcc->delete();
                });

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
