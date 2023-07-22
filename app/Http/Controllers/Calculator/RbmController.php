<?php

namespace App\Http\Controllers\Calculator;

use App\Exports\RbmExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\RbmRequest;
use App\Models\Maintenance;
use App\Models\Rbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class RbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.calculator.rbm');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RbmRequest $request)
    {
        try {
            if (Auth::check()) {
                DB::beginTransaction();
                $attr = $request->validated();
                $maintenance = new Maintenance();
                $maintenance->id_user = Auth::user()->id;
                $maintenance->nama_mesin = $attr['nama_mesin'];
                $maintenance->jenis_maintenance = 'rbm';
                $maintenance->save();

                $data = new Rbm();
                $data->id_maintenance = $maintenance->id;
                $data->jangka_waktu = $attr['jangka_waktu'];
                $data->severity = $attr['severity'];
                $data->occurrence = $attr['occurrence'];
                $data->result_rbm = round($attr['severity'] * $attr['occurrence']);
                $data->risk = $attr['risk'];
                $data->rekomendasi = $attr['rekomendasi'];
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
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function exportRbm()
    {
        if (Auth::check()) {
            return Excel::download(new RbmExport, 'Riwayat RBM.xlsx');
        } else {
            return redirect('login');
        }
    }

    public function destroy(string $id)
    {
        try {
            if (Auth::check()) {
                $detailMaintenance = Rbm::where('id_maintenance', $id);

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
