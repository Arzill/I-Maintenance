@extends('layouts.dashboard')

@section('dashboard-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm px-2">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2 class="fw-bold text-dark-blue">Riwayat RMB</h2>
                        <p class="text-dark-blue fw-medium">Ringkasan Maintenance</p>
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
                <h5 class="text-dark-blue">Riwayat Data Maintenance Baru</h5>
                <div class="table-responsive">
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th class="text-dark-blue" scope="col">No</th>
                                <th class="text-dark-blue" scope="col">Tanggal</th>
                                <th class="text-dark-blue" scope="col">Nama Mesin</th>
                                <th class="text-dark-blue" scope="col">Output</th>
                                <th class="text-dark-blue" scope="col">Jenis Maintenance</th>
                                <th class="text-dark-blue" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-dark-blue">Tidak ada Data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection