<?php

namespace App\Http\Controllers;

use App\Exports\DowntimeExport;
use Illuminate\Http\Request;
use App\Models\Lcc;
use App\Models\Maintenance;
use App\Models\PerhitunganOEE;
use App\Models\Rbm;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        try {
            $userLogin = Auth::id();

            if (Auth::user()->role == 'admin') {
                $oeeCount = PerhitunganOEE::whereHas('maintenance')->count();
                $rbmCount =  Rbm::whereHas('maintenance')->count();
                $lccCount =  Lcc::whereHas('maintenance')->count();
                $maintenances = Maintenance::with('perhitunganOee', 'rbm', 'lcc')
                    ->latest()
                    ->get();
            } else {
                $oeeCount = PerhitunganOEE::whereHas('maintenance', function ($query) use ($userLogin) {
                    $query->where('id_pengguna', $userLogin);
                })->count();
                $rbmCount =  Rbm::whereHas('maintenance', function ($query) use ($userLogin) {
                    $query->where('id_pengguna', $userLogin);
                })->count();
                $lccCount =  Lcc::whereHas('maintenance', function ($query) use ($userLogin) {
                    $query->where('id_pengguna', $userLogin);
                })->count();
                $maintenances = Maintenance::where('id_pengguna', $userLogin)
                    ->with('perhitunganOee', 'rbm', 'lcc')
                    ->latest()
                    ->get();
            }

            $oeeData = $maintenances->map(function ($maintenance) {
                return $maintenance->perhitunganOee->map(function ($oee) {
                    $oee->jenis_maintenance = 'OEE';
                    $oee->nama_mesin = $oee->maintenance->nama_mesin;
                    return $oee;
                });
            })->flatten();

            $rbmData = $maintenances->map(function ($maintenance) {
                return $maintenance->rbm->map(function ($rbm) {
                    $rbm->jenis_maintenance = 'RBM';
                    $rbm->nama_mesin = $rbm->maintenance->nama_mesin;
                    return $rbm;
                });
            })->flatten();

            $lccData = $maintenances->map(function ($maintenance) {
                return $maintenance->lcc->map(function ($lcc) {
                    $lcc->jenis_maintenance = 'LCC';
                    $lcc->nama_mesin = $lcc->maintenance->nama_mesin;
                    return $lcc;
                });
            })->flatten();

            $allData = $oeeData->merge($rbmData)->merge($lccData)->sortByDesc('created_at')->paginate(10);
            // $perPage = 10;
            // $currentPage = Paginator::resolveCurrentPage();
            // $pageData = new Paginator($allData->forpage($currentPage, $perPage), $perPage);

            return view('pages.dashboard.dashboard', compact('allData', 'oeeCount', 'rbmCount', 'lccCount'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
    public function oee(Request $request)
    {
        try {
            $userLogin = Auth::id();
            $params = $request->except('_token');
            if (@$params['show'] != null) {
                $paginate = $params['show'];
            } else {
                $paginate = 5;
            }
            if (Auth::user()->role == 'admin') {
                // Role Admin
                $oee = PerhitunganOEE::filter($params)
                    ->whereHas('maintenance')
                    ->latest()
                    ->paginate($paginate);
                $maintenance  = Maintenance::get();
                $namaMesin = $maintenance->pluck('nama_mesin')->toArray();
            } else {
                // Role User
                $oee = PerhitunganOEE::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('id_pengguna', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
                $namaMesin = Maintenance::where('id_pengguna', $userLogin)
                    ->whereHas('perhitunganOEE')
                    ->pluck('nama_mesin')
                    ->toArray();
            }

            return view('pages.dashboard.oee', compact('oee', 'namaMesin'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
    public function downtime(Request $request)
    {
        try {
            $userLogin = Auth::id();
            $params = $request->except('_token');
            if (@$params['show'] != null) {
                $paginate = $params['show'];
            } else {
                $paginate = 5;
            }
            if (Auth::user()->role == 'admin') {
                // Role Admin
                $oee = PerhitunganOEE::filter($params)
                    ->whereHas('maintenance')
                    ->latest()
                    ->paginate($paginate);
                $maintenance  = Maintenance::get();
                $namaMesin = $maintenance->pluck('nama_mesin')->toArray();
            } else {
                // Role User
                $oee = PerhitunganOEE::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('id_pengguna', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
                $namaMesin = Maintenance::where('id_pengguna', $userLogin)
                    ->whereHas('perhitunganOEE')
                    ->pluck('nama_mesin')
                    ->toArray();
            }
            // chart
            $nama_mesin = $params['nama_mesin'] ?? null;
            $search = $params['search'] ?? null;
            $tanggal = $params['tanggal'] ?? null;
            $dateRange = explode(' - ', $tanggal);
            if (count($dateRange) === 2) {
                $startDate = $dateRange[0];
                $endDate = $dateRange[1];
            }
            $chartData = [];

            if ($nama_mesin &&  $tanggal) {

                $query = PerhitunganOEE::with(['maintenance', 'downtime'])
                    ->whereHas('maintenance', function ($query) use ($userLogin, $nama_mesin) {
                        $query->where('id_pengguna', $userLogin);
                        if ($nama_mesin) {
                            $query->where('nama_mesin', $nama_mesin);
                        }
                    });

                if ($startDate && $endDate) {
                    $query->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate);
                }

                $dataForChart = $query->get();
            } elseif ($nama_mesin) {
                // Jika ada penyaringan berdasarkan nama mesin saja
                $dataForChart = PerhitunganOEE::with(['maintenance', 'downtime'])
                    ->whereHas('maintenance', function ($query) use ($userLogin, $nama_mesin) {
                        $query->where('id_pengguna', $userLogin)
                            ->where('nama_mesin', $nama_mesin);
                    })
                    ->get();
            } elseif ($tanggal) {

                $query = PerhitunganOEE::with(['maintenance', 'downtime'])
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('id_pengguna', $userLogin);
                    });

                if ($startDate && $endDate) {
                    $query->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate);
                }

                $dataForChart = $query->get();
            } elseif ($search) {
                $dataForChart = PerhitunganOEE::with(['maintenance', 'downtime'])
                    ->whereHas('maintenance', function ($query) use ($userLogin, $search) {
                        $query->where('id_pengguna', $userLogin)
                            ->where('nama_mesin', 'LIKE', '%' . $search . '%');
                    })
                    ->get();
            } else {
                // Jika tidak ada penyaringan berdasarkan nama mesin dan rentang tanggal, tampilkan seluruh data dalam satu bulan terakhir
                $endDate = Carbon::now();
                $startDate = $endDate->copy()->subMonth();
                $dataForChart = PerhitunganOEE::whereBetween('created_at', [$startDate, $endDate])
                    ->with(['maintenance', 'downtime'])
                    ->get();
            }
            foreach ($dataForChart as $data) {
                $downtime = $data->downtime ? $data->downtime->jumlah_downtime : 0; // Get the downtime value if available, otherwise set to 0
                $chartData[] = [
                    'label' => $nama_mesin ? \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) : $data->maintenance->nama_mesin,
                    'data' => $downtime,
                ];
            }
            $chartDataJson = json_encode($chartData);

            return view('pages.dashboard.downtime', compact('oee', 'namaMesin', 'chartDataJson', 'nama_mesin', 'tanggal'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
    public function exportDowntime(Request $request)
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
                return Excel::download(new DowntimeExport($start_date, $end_date, $nama_mesin), 'Riwayat Downtime ' . $start_date . ' - ' . $end_date . '.xlsx');
            }
        } else {
            return redirect('login');
        }
    }
    public function rbm(Request $request)
    {
        try {
            $userLogin = Auth::id();
            $params = $request->except('_token');
            if (@$params['show'] != null) {
                $paginate = $params['show'];
            } else {
                $paginate = 5;
            }
            if (Auth::user()->role == 'admin') {
                $rbm = Rbm::filter($params)
                    ->whereHas('maintenance')
                    ->latest()
                    ->paginate($paginate);
            } else {
                $rbm = Rbm::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('id_pengguna', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
                $namaMesin = Maintenance::where('id_pengguna', $userLogin)
                    ->whereHas('perhitunganOEE')
                    ->pluck('nama_mesin')
                    ->toArray();
            }
            return view('pages.dashboard.rbm', compact('rbm', 'namaMesin'));
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }
    public function lcc(Request $request)
    {
        try {
            $userLogin = Auth::id();
            $params = $request->except('_token');
            if (@$params['show'] != null) {
                $paginate = $params['show'];
            } else {
                $paginate = 5;
            }
            if (Auth::user()->role == 'admin') {
                $lcc = Lcc::filter($params)
                    ->whereHas('maintenance')
                    ->latest()
                    ->paginate($paginate);
                $namaMesin = Lcc::whereHas('maintenance')
                    ->with('maintenance')
                    ->get()
                    ->pluck('maintenance.nama_mesin')
                    ->toArray();
            } else {
                $lcc = Lcc::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('id_pengguna', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
                $namaMesin = Maintenance::where('id_pengguna', $userLogin)
                    ->whereHas('perhitunganOEE')
                    ->pluck('nama_mesin')
                    ->toArray();
            }
            return view('pages.dashboard.lcc', compact('lcc', 'namaMesin'));
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }

    public function settings()
    {
        try {
            if (Auth::check()) {
                return view('pages.dashboard.settings');
            }
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }
}