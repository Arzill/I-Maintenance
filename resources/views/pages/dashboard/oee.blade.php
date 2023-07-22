@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm px-2">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-4">
                            <h2 class="fw-bold text-dark-blue">Ringkasan OEE</h2>
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
                                <div class="input-group input-group-sm mb-3">
                                    <input type="search" id="search" name="search" class="form-control me-3"
                                        placeholder="Search..." alue="{{ old('search', @$_GET['search']) }}"
                                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    <a href="{{ route('calculator-oee.export') }}" class="btn btn-primary btn-sm">Cetak</a>

                                </div>

                            </div>
                        </div>
                    </form>
                    <div class=" table-responsive">
                        <table class="table mt-2">
                            <thead class=" border-bottom-2">
                                <tr>
                                    <th class="text-dark-blue" scope="col">No</th>
                                    <th class="text-dark-blue" scope="col">Tanggal</th>
                                    <th class="text-dark-blue" scope="col">Nama Mesin</th>
                                    <th class="text-dark-blue" scope="col">Peformance</th>
                                    <th class="text-dark-blue" scope="col">Quality</th>
                                    <th class="text-dark-blue" scope="col">Availbility</th>
                                    <th class="text-dark-blue" scope="col">Output</th>
                                    <th class="text-dark-blue" scope="col">Rekomendasi</th>
                                    <th class="text-dark-blue" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($oee as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                        <td>{{ $data->maintenance->nama_mesin }}</td>
                                        <td>{{ round($data->performance) }}%</td>
                                        <td>{{ round($data->quality) }}%</td>
                                        <td>{{ round($data->avaibility) }}%</td>
                                        <td>{{ round($data->result_oee) }}%</td>
                                        @if ($data->status_oee === 'sudah baik')
                                            <td class="text-green">{{ ucwords($data->status_oee) }}</td>
                                        @endif
                                        @if ($data->status_oee === 'perlu pengecekan')
                                            <td class="text-danger">{{ ucwords($data->status_oee) }}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm  btn-delete"
                                                data-user-id="{{ $data->id }}"
                                                data-username="{{ $data->maintenance->nama_mesin }}"
                                                data-url="{{ route('calculator-oee.delete', $data->id_maintenance) }}"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash mr-1"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-dark-blue">Tidak ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                        <x-pagination :pagination="$oee" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Hapus Data Oee</h1>
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
