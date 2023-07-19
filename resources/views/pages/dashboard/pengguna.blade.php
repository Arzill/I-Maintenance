@extends('layouts.dashboard')

@section('dashboard-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm px-2">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2 class="fw-bold text-dark-blue">Pengguna</h2>
                        <p class="text-dark-blue fw-medium">Ringkasan Pengguna</p>
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
                <h5 class="text-dark-blue">Ringkasan Data Pengguna</h5>
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
                            </div>
                        </div>
                    </div>
                </form>
                <div class=" table-responsive">
                    <table class="table mt-2">
                        <thead class=" border-bottom-2">
                            <tr>
                                <th class="text-dark-blue" scope="col">No</th>
                                <th class="text-dark-blue" scope="col">Nama</th>
                                <th class="text-dark-blue" scope="col">Tempat Bekerja</th>
                                <th class="text-dark-blue" scope="col">Posisi</th>
                                <th class="text-dark-blue text-center" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user as $data )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($data->name) }}</td>
                                @if($data->tempat_bekerja === null)
                                <td>Tidak Ada</td>
                                @else
                                <td>{{ ucwords($data->tempat_bekerja) }}</td>
                                @endif
                                @if($data->posisi === null)
                                <td>Tidak Ada</td>
                                @else
                                <td>{{ ucwords($data->posisi)}}</td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-success btn-sm mx-2 btn-edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-user-id="{{ $data->id }}">
                                            <i class="fas fa-edit mr-1"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm  btn-delete"
                                            data-user-id="{{ $data->id }}" data-username="{{ $data->name }}"
                                            data-url="{{ route('pengguna.delete', $data->id) }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="fas fa-trash mr-1"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-dark-blue">Tidak ada data</td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>
                    <x-pagination :pagination="$user" />
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal edit --}}
<div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-body-tertiary">
                <h1 class="modal-title  fs-5 fw-bold" id="exampleModalLabel">Edit Data Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fw-medium">Nama Pengguna</label>
                        <input type="text" name="name" class="form-control  " id="input-name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fw-medium">Tempat Bekerja</label>
                        <input type="text" name="tempat_bekerja" class="form-control " id="input-tempat_bekerja">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fw-medium">Posisi</label>
                        <input type="text" name="posisi" class="form-control " id="input-posisi">
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn " data-bs-dismiss="modal">Batal</button>
                    <button type="sumbit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- modal delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-body-tertiary">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Hapus Data Pengguna</h1>
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

@section('otherJsQuery')
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            const userId = $(this).data('user-id');
            const editForm = $('#editForm');

            $.ajax({
                url: "{{ route('pengguna.edit', '') }}" + "/" + userId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    editForm.attr('action', "{{ route('pengguna.update', '') }}" + '/' + userId);
                    // Mengisi atribut data pada form dengan data pengguna yang diambil
                    editForm.find('#input-name').val(data.name || '').attr('placeholder', 'Masukkan Nama Pengguna');
                    editForm.find('#input-tempat_bekerja').val(data.tempat_bekerja || '').attr('placeholder', 'Masukkan Tempat Bekerja');
                    editForm.find('#input-posisi').val(data.posisi || '').attr('placeholder', 'Masukkan Posisi');

                    // Tampilkan modal setelah pengisian data
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection


@endsection
