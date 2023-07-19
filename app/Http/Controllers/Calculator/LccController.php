<?php

namespace App\Http\Controllers\Calculator;

use App\Exports\LccExport;
use App\Exports\OeeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\LccRequest;
use App\Models\DetailMaintenance;
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
        return view('pages.calculator.lcc');
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
                $maintenance = new Maintenance();
                $maintenance->id_user = Auth::user()->id;
                $maintenance->jenis_maintenance = 'lcc';
                $maintenance->save();


                // Insert Data Detail Maintenance
                $data = new DetailMaintenance();
                $data->id_maintenance = $maintenance->id;
                $data->nama_mesin = $attr['nama_mesin'];
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
            return Excel::download(new LccExport, 'lcc.xlsx');
        }
    }

    public function destroy(string $id)
    {
        if (Auth::check()) {
            try {
                $userLogin = Auth::id();

                $detailMaintenance = DetailMaintenance::findOrFail($id);

                $maintenance = Maintenance::where('id_user', $userLogin)
                    ->whereHas('detailMaintenance', function ($query) use ($id) {
                        $query->where('id', $id);
                    })
                    ->first();

                DB::transaction(function () use ($detailMaintenance) {
                    $detailMaintenance->delete();
                });

                if ($maintenance) {
                    DB::transaction(function () use ($maintenance) {
                        $maintenance->delete();
                    });
                }
                Alert::success('Sukses', 'Data Berhasil Dihapus');
            } catch (\Throwable $th) {
                Alert::error('Error', 'Gagal menghapus data ' . $th->getMessage());
            }
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }
}
