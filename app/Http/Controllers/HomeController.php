<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\DetailMaintenance;
use App\Models\Lcc;
use App\Models\Maintenance;
use App\Models\Oee;
use App\Models\Rbm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Profiler\Profile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.home');
    }
    public function aboutUs()
    {
        return view('pages.aboutUs');
    }
    public function dashboard()
    {
        try {
            $userLogin = Auth::id();

            if (Auth::user()->role == 'admin') {
                // Role Admin
                $oeeCount = Maintenance::where('jenis_maintenance', 'oee')->count();
                $rbmCount = Maintenance::where('jenis_maintenance', 'rbm')->count();
                $lccCount = Maintenance::where('jenis_maintenance', 'lcc')->count();
                $maintenance = Maintenance::with(['oee', 'rbm', 'lcc'])->latest()->paginate(5);
            } else {
                // Role User
                $oeeCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'oee')->count();
                $rbmCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'rbm')->count();
                $lccCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'lcc')->count();
                $maintenance = Maintenance::where('id_user', $userLogin)->with(['oee', 'rbm', 'lcc'])->latest()->paginate(5);
            }


            return view('pages.dashboard.dashboard', compact('maintenance', 'oeeCount', 'rbmCount', 'lccCount'));
        } catch (\Throwable $th) {
            return redirect()->route('home');
            throw $th;
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
                $oee = Oee::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'oee');
                    })
                    ->latest()
                    ->paginate($paginate);
            } else {
                // Role User
                $oee = Oee::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'oee')->where('id_user', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
            }

            return view('pages.dashboard.oee', compact('oee'));
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
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
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'rbm');
                    })
                    ->latest()
                    ->paginate($paginate);
            } else {
                $rbm = Rbm::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'rbm')->where('id_user', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
            }
            return view('pages.dashboard.rbm', compact('rbm'));
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
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'lcc');
                    })
                    ->latest()
                    ->paginate($paginate);
            } else {
                $lcc = Lcc::filter($params)
                    ->whereHas('maintenance', function ($query) use ($userLogin) {
                        $query->where('jenis_maintenance', 'lcc')->where('id_user', $userLogin);
                    })
                    ->latest()
                    ->paginate($paginate);
            }
            return view('pages.dashboard.lcc', compact('lcc'));
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
