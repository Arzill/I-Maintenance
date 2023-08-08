@extends('layouts.dashboard')
@section('dashboard-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm px-2">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2 class="fw-bold text-dark-blue">Dashboard</h2>
                        <p class="text-dark-blue fw-medium">Ringkasan Maintenance</p>
                    </div>
                    <div class="col-md-auto">
                        <a href="" class="btn btn-success px-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-4 ">
        <div class="card py-3 text-center border-0 shadow-sm">
            <h5 class="fw-bold">Total Data Entry</h5>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="card-group gap-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body pb-2">
                    <p class="card-text text-primary">Overall Equipment Effectiveness</p>
                    <h3 class="card-title fw-bold">{{ $oeeCount }}</h3>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body pb-2">
                    <p class="card-text text-primary">Risk Based Maintenance</p>
                    <h3 class="card-title fw-bold">{{ $rbmCount }}</h3>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body pb-2">
                    <p class="card-text text-primary">Life Cycle Cost</p>
                    <h3 class="card-title fw-bold">{{ $lccCount }}</h3>
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
                                <th class="text-dark-blue text-center" scope="col">Jenis Maintenance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                <td>{{ $data->nama_mesin }}</td>
                                <td>
                                    @if ($data->jenis_maintenance === 'OEE')
                                    {{ round($data->oee->result_oee) }}%
                                    @elseif ($data->jenis_maintenance === 'RBM')
                                    {{ $data->result_rbm }}
                                    @elseif ($data->jenis_maintenance === 'LCC')
                                    Rp. {{ \App\Helpers\DateHelper::getFormatNumber($data->result_lcc) }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $data->jenis_maintenance }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :pagination="$allData" />

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
