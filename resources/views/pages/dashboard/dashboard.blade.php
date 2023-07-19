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
                        <a href="{{ route('home') }}" class="btn btn-success px-4">Kembali</a>
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
                    <h3 class="card-title fw-bold">{{ $rmbCount }}</h3>
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

                            @forelse ($maintenance as $data )
                            @php
                            $detailMaintenance = $data->detailMaintenance->first();
                            @endphp
                            @if($detailMaintenance->count() > 0)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                <td>
                                    @if ($detailMaintenance)
                                    {{ $detailMaintenance->nama_mesin }}
                                    @else
                                    No Detail Maintenance Found
                                    @endif
                                </td>
                                @if ($data->jenis_maintenance === 'oee')
                                <td>{{ round($detailMaintenance->result_oee) }}%</td>
                                @elseif ($data->jenis_maintenance === 'rmb')
                                <td>Rp. {{ round($detailMaintenance->result_rmb) }}</td>
                                @elseif ($data->jenis_maintenance === 'lcc')
                                <td>Rp. {{ round($detailMaintenance->result_lcc) }}</td>
                                @endif
                                <td class="text-center">{{ $data->jenis_maintenance }}</td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-dark-blue">Tidak ada Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :pagination="$maintenance" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection