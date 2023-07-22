<?php

namespace App\Http\Controllers\Calculator;

use App\Exports\OeeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\OeeRequest;
use App\Models\Maintenance;
use App\Models\Oee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OeeController extends Controller
{
    public function index(Request $request)
    {

        return view('pages.calculator.oee');
    }

    public function store(OeeRequest $request)
    {
        try {
            DB::beginTransaction();
            if (Auth::check()) {
                function convertToTime($time)
                {
                    $time24 = date('H:i', strtotime($time));
                    return $time24;
                }
                function getTimeValue($time)
                {
                    // Ubah waktu dari format 12 jam menjadi format 24 jam
                    $time24 = date('H:i', strtotime($time));

                    $parts = explode(':', $time24);
                    $hours = (int)$parts[0];
                    $minutes = (int)$parts[1];

                    return ($hours * 60) + $minutes; // Format: HH:MM
                }

                function calculateShiftLength($start, $end)
                {
                    if (!is_numeric($end) || !is_numeric($start)) {
                        return 0;
                    }
                    if ($end < $start) {
                        $end += 24 * 60;
                    }

                    return $end - $start;
                }

                $attr = $request->validated();
                $maintenance = new Maintenance();
                $maintenance->id_user = Auth::user()->id;
                $maintenance->nama_mesin = $attr['nama_mesin'];
                $maintenance->jenis_maintenance = 'oee';
                $maintenance->save();

                $data = new Oee();
                $data->id_maintenance = $maintenance->id;
                $data->shift_start = convertToTime($attr['shift_start']);
                $data->shift_end = convertToTime($attr['shift_end']);
                $data->planned_downtime = $attr['planned_downtime'];
                $data->unplanned_downtime = $attr['unplanned_downtime'];
                $data->total_parts_produced = $attr['total_parts_produced'];
                $data->ideal_run_rate = $attr['ideal_run_rate'];
                $data->total_scrap = $attr['total_scrap'];

                // Availability
                $shiftStart = getTimeValue($attr['shift_start']);
                $shiftEnd = getTimeValue($attr['shift_end']);
                $shiftLength = calculateShiftLength($shiftStart, $shiftEnd);
                $plannedProductionTime = $shiftLength - $attr['planned_downtime'];
                $operatingTime = $plannedProductionTime - $attr['unplanned_downtime'];
                $availability = ($operatingTime / $plannedProductionTime) * 100;
                $availability = round($availability, 2);
                $availability = max(0, $availability);
                $availability = min(100, $availability);

                // Performance
                $performance = ($attr['total_parts_produced'] / $operatingTime) /  $attr['ideal_run_rate'];
                $performance = round($performance * 100, 2);
                $performance = max(0, $performance);
                $performance = min(100, $performance);

                // Quality
                $quality = ($attr['total_parts_produced'] - $attr['total_scrap']) / $attr['total_parts_produced'];
                $quality = round($quality * 100, 2);
                $quality = max(0, $quality);
                $quality = min(100, $quality);

                // Calculate OEE
                $oee = ($availability / 100) * ($performance / 100) * ($quality / 100);
                $oee = round($oee * 100, 2);
                $oee = max(0, $oee);
                $oee = min(100, $oee);

                $data->performance = $performance;
                $data->quality = $quality;
                $data->avaibility = $availability;
                $data->result_oee = $oee;
                if ($oee >= 60) {
                    $data->status_oee = 'sudah baik';
                } else {
                    $data->status_oee = 'perlu pengecekan';
                }

                $data->save();

                DB::commit();

                Alert::success('Sukses', 'Berhasil Menyimpan Data');
                return redirect()->back();
            } else {
                return redirect('login');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal Menyimpan Data ' . $th->getMessage());
        }
    }
    public function exportOee()
    {
        if (Auth::check()) {
            return Excel::download(new OeeExport, 'Riwayat OEE.xlsx');
        } else {
            return redirect('login');
        }
    }
    public function destroy(string $id)
    {
        try {
            if (Auth::check()) {

                $detailMaintenance = Oee::where('id_maintenance', $id)->first();

                $maintenance = Maintenance::where('id', $id)->first();

                DB::transaction(function () use ($detailMaintenance) {
                    $detailMaintenance->delete();
                });

                if ($maintenance) {
                    DB::transaction(function () use ($maintenance) {
                        $maintenance->delete();
                    });
                }
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
