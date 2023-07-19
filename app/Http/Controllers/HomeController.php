<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\DetailMaintenance;
use App\Models\Maintenance;
use App\Models\Oee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
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
            $oeeCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'oee')->count();
            $rmbCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'rmb')->count();
            $lccCount = Maintenance::where("id_user", $userLogin)->where('jenis_maintenance', 'lcc')->count();
            $maintenance = Maintenance::where('id_user', $userLogin)->with('detailMaintenance')->latest()->paginate(5);
            return view('pages.dashboard.dashboard', compact('maintenance', 'oeeCount', 'rmbCount', 'lccCount'));
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
            $oee = DetailMaintenance::filter($params)
                ->whereHas('maintenance', function ($query) use ($userLogin) {
                    $query->where('jenis_maintenance', 'oee')->where('id_user', $userLogin);
                })
                ->latest()
                ->paginate($paginate);
            return view('pages.dashboard.oee', compact('oee'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function rmb()
    {
        return view('pages.dashboard.rmb');
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
            $lcc = DetailMaintenance::filter($params)
                ->whereHas('maintenance', function ($query) use ($userLogin) {
                    $query->where('jenis_maintenance', 'lcc')->where('id_user', $userLogin);
                })
                ->latest()
                ->paginate($paginate);
            return view('pages.dashboard.lcc', compact('lcc'));
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('pages.dashboard.lcc');
    }

    public function settings()
    {
        try {
            if (Auth::check()) {
                return view('pages.dashboard.settings');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function updateSettings(ProfileRequest $request)
    {
        try {
            $id = Auth::user()->id;
            $attr = $request->validated();
            $user = User::find($id);

            // Image
            $file = $request->file('image');
            if ($file) {
                $filename = $request->nama . '-' . str()->random(5) . '-' . $file->getClientOriginalName();
                $attr['image'] = $file->storeAs('public/image/profile', $filename);
                $imgPath = 'storage/image/profile/' . $filename;
                // $img = Image::make($imgPath)->resize(500, null, function ($constraint) {
                //     $constraint->aspectRation();
                // });
                // $img->save($imgPath);
            }

            // Update Data
            $user->update([
                'name' => $attr['name'],
                'email' => $attr['email'],
                'no_hp' => $attr['no_hp'],
                'tempat_bekerja' => $attr['tempat_bekerja'],
                'posisi' => $attr['posisi'],
                'image' => $imgPath
            ]);

            Alert::success('Sukses', 'Berhasil mengubah password');
            return redirect()->route('settings');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal mengubah data karena ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user = User::find($id);
            if (Hash::check($request->password_lama, $user->password)) {

                if ($request->password_baru == $request->konfirmasi_password) {
                    $user->update([
                        'password' => Hash::make($request->password_baru)
                    ]);
                    Alert::success('Sukses', 'Berhasil mengubah password');
                    return redirect()->route('settings');
                } else {
                    Alert::error('Error', 'Gagal konfirmasi');
                    return redirect()->route('settings');
                }
            } else {
                Alert::error('Error', 'Password salah');
                return redirect()->route('settings');
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal mengubah data karena ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
