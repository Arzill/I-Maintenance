@extends('layouts.dashboard')

@section('dashboard-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm px-2">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2 class="fw-bold text-dark-blue">Riwayat RBM</h2>
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
                <form id="form-filter">
                    <div class="row no-gutters justify-content-between">
                        <div class="col-md-auto">
                            <x-ordering />
                        </div>
                        <div class="col-md-auto d-flex">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <input type="search" id="search" name="search"
                                            class="form-control form-control-sm " placeholder="Search.."
                                            value="{{ old('search', @$_GET['search']) }}"
                                            aria-label="Sizing example input">
                                        <button class="input-group-text "><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <a href="{{ route('calculator-rbm.export') }}"
                                        class="btn btn-primary rounded">Cetak</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">No</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Tanggal</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Nama Mesin</th>
                                <th class="text-dark-blue " scope="col" style="white-space: nowrap">Jangka Waktu</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Severity</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Occurrence</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Risk</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Rekomendasi</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">RPN</th>
                                <th class="text-dark-blue" scope="col" style="white-space: nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rbm as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                <td>{{ $data->maintenance->nama_mesin }}</td>
                                <td>{{ $data->jangka_waktu }} Bulan</td>
                                <td>{{ $data->severity }}</td>
                                <td>{{ $data->occurrence }}</td>
                                @if($data->risk === 'Low')
                                <td style="color: #9cbf13">{{ $data->risk }}</td>
                                @elseif($data->risk === 'Medium')
                                <td class="text-warning">{{ $data->risk }}</td>
                                @else
                                <td class="text-danger">{{ $data->risk }}</td>
                                @endif
                                <td>{{ $data->rekomendasi }}</td>
                                <td>{{ round($data->result_rbm) }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm  btn-delete" data-user-id="{{ $data->id }}"
                                        data-username="{{ $data->maintenance->nama_mesin }}"
                                        data-url="{{ route('calculator-rbm.delete', $data->id_mesin) }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-dark-blue">Tidak ada Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-body-tertiary">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Hapus Data RMB</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection