@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm px-2">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <h2 class="fw-bold text-dark-blue">Pengaturan</h2>
                            <p class="text-dark-blue fw-medium">Anda dapat menambahkan atau merubah data diri maupun
                                password
                            </p>
                        </div>
                        <div class="col-md-auto">
                            <a href="{{ route('home') }}" class="btn btn-success px-4">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-dark-blue">Profil</h5>
                    <p class="fw-light text-dark-blue">Data diri</p>
                    <form action="{{ route('update-settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-3 col-md-12 mb-3 text-center">
                                <div class="avatar-wrapper">
                                    <img src="{{ Auth::user()->image ? asset('storage/images/profile/' . Auth::user()->image) : asset('assets/images/logo/avatar.png') }}"
                                        alt="User Profile" class="">
                                </div>
                                <div class="mt-3">
                                    <div class="input-group custom-file-button">
                                        <label class="input-group-text" for="inputGroupFile">Upload</label>
                                        <input type="file" class="form-control" id="inputGroupFile">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Masukkan Nama Lengkap" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Nomor Handphone</label>
                                    <input type="text" class="form-control" name="no_hp"
                                        placeholder="Masukkan Nomor Handphone" value="{{ Auth::user()->no_hp }}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Alamat Email</label>
                                    <input type="text" class="form-control" name="email"
                                        placeholder="Masukkan Alamat Email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Tempat Bekerja</label>
                                    <input type="text" class="form-control" name="tempat_bekerja"
                                        placeholder="Masukkan Tempat Bekerja" value="{{ Auth::user()->tempat_bekerja }}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Posisi</label>
                                    <input type="text" class="form-control" name="posisi" placeholder="Masukkan Posisi"
                                        value="{{ Auth::user()->posisi }}">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-success float-end">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-dark-blue">Password</h5>
                    <p class="fw-light text-dark-blue">Anda dapat mengubah password disini</p>
                    <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Password Saat Ini</label>
                                    <input type="password" name="password_lama" class="form-control"
                                        placeholder="Masukkan Password Saat Ini">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control"
                                        placeholder="Masukkan Password Baru">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2 fw-light">Konfirmasi Password Baru</label>
                                    <input type="password" name="konfirmasi_password" class="form-control"
                                        placeholder="Masukkan Konfirmasi Password Baru">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" value="password" class="btn btn-success float-end">
                                        Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
