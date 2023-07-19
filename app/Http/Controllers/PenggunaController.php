<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenggunaUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
}
