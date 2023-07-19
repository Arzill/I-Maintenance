@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm px-2">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-4">
                            <h2 class="fw-bold text-dark-blue">Riwayat LCC</h2>
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
                                    <a href="{{ route('calculator-lcc.export') }}" class="btn btn-primary btn-sm">Cetak</a>
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
                                    <th class="text-dark-blue" scope="col">Output</th>
                                    <th class="text-dark-blue" scope="col">Biaya Operasional</th>
                                    <th class="text-dark-blue" scope="col">Biaya Pemeliharaan</th>
                                    <th class="text-dark-blue" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lcc as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                        <td>{{ $data->nama_mesin }}</td>
                                        <td>Rp {{ \App\Helpers\DateHelper::getFormatNumber($data->result_lcc) }}</td>
                                        <td>Rp
                                            {{ \App\Helpers\DateHelper::getFormatNumber($data->biaya_operasional_tahunan) }}
                                        </td>
                                        <td>Rp
                                            {{ \App\Helpers\DateHelper::getFormatNumber($data->biaya_pemeliharaan_tahunan) }}
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm  btn-delete"
                                                data-user-id="{{ $data->id }}" data-username="{{ $data->nama_mesin }}"
                                                data-url="{{ route('calculator-lcc.delete', $data->id) }}"
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
                        <x-pagination :pagination="$lcc" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Hapus Data Lcc</h1>
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
