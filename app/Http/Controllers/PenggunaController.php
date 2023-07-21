<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenggunaUpdateRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $params = $request->except('_token');
            if (@$params['show'] != null) {
                $paginate = $params['show'];
            } else {
                $paginate = 5;
            }
            $user = User::filter($params)->latest()->paginate($paginate);
            return view('pages.dashboard.pengguna', compact('user'));
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }
    public function edit(string $id)
    {
        $user  = User::findOrFail($id);

        return response()->json($user);
    }
    public function update(PenggunaUpdateRequest $request, string $id)
    {
        try {
            $attr = $request->validated();

            $user = User::findOrFail($id);
            $user->name = $attr['name'];
            $user->tempat_bekerja = $attr['tempat_bekerja'];
            $user->posisi = $attr['posisi'];
            $user->save();

            Alert::success('Sukses', 'Berhasil mengubah data');
            return redirect('pengguna');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal mengubah data karena ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $loggedInUserId = Auth::id();

            if ($user->id === $loggedInUserId) {
                Alert::error('Error', 'Anda tidak dapat menghapus diri anda sendiri');
                return redirect()->back();
            }

            if ($user->delete()) {
                Alert::success('Sukses', 'Berhasil menghapus data');
                return redirect('pengguna');
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal menghapus data karena ' . $th->getMessage());
            return redirect()->back();
        }
    }
    public function updateSettings(ProfileRequest $request, User $user)
    {
        try {
            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $attr = $request->all();

            // Image
            if ($request->hasFile('image')) {
                $file = $attr['image'];
                $filename = $attr['name'] . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('public/images/profile', $filename);
                $attr['image'] =  $filename;
                // Resize the image
                $img = Image::make($file)->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/' . $filePath));
                $old_image = $user->image;
                if ($old_image) {
                    Storage::delete('public/images/profile/' . $old_image);
                }
            } else {
                $attr['image'] = null;
            }

            // Update Data
            $user->update([
                'name' => $attr['name'],
                'email' => $attr['email'],
                'no_hp' => $attr['no_hp'],
                'tempat_bekerja' => $attr['tempat_bekerja'],
                'posisi' => $attr['posisi'],
                'image' => $attr['image'],
            ]);

            Alert::success('Sukses', 'Berhasil mengubah profile');
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