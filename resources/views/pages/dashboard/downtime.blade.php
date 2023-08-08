@extends('layouts.dashboard')

@section('dashboard-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm px-2">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-5">
                        <h2 class="fw-bold text-dark-blue">Ringkasan Downtime</h2>
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
        <div class="card">
            <div class="card-body">
                @php
                $dateRange = explode(' - ', $tanggal);
                if (count($dateRange) === 2) {
                $startDate = $dateRange[0];
                $endDate = $dateRange[1];
                }
                @endphp
                @if ($nama_mesin && $tanggal)
                <h5 class="text-dark-blue">Riwayat Downtime {{ $nama_mesin }} selama {{
                    \App\Helpers\DateHelper::getIndonesiaDate($startDate) }} - {{
                    \App\Helpers\DateHelper::getIndonesiaDate($endDate) }}</h5>
                @elseif ($nama_mesin)
                <h5 class="text-dark-blue">Riwayat Downtime {{ $nama_mesin }}</h5>
                @elseif($tanggal)
                Riwayat Downtime selama {{
                \App\Helpers\DateHelper::getIndonesiaDate($startDate) }} - {{
                \App\Helpers\DateHelper::getIndonesiaDate($endDate) }}
                @else
                <h5 class="text-dark-blue">Riwayat Downtime Selama 1 Bulan Terakhir</h5>
                @endif

                <div class="row justify-content-center">
                    <div class="col-md-8 ">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ol>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ol>
        </div>
        @endif
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="text-dark-blue">Riwayat Data Downtime Mesin</h5>
                <form id="form-filter">
                    <div class="row mt-2 justify-content-between">
                        <div class="col-md-auto d-flex align-items-center">
                            <div class="row g-2">
                                <div class="col-md-auto ">
                                    <x-ordering />
                                </div>
                                <div class="col-md-auto ">
                                    <x-select :options="$namaMesin" />
                                </div>
                                <div class="col-md-auto ">
                                    <div class="custom-select2">
                                        <input name="tanggal" class="form-select custom-select" id="tanggal"
                                            onchange="this.form.submit();"
                                            value="{{ old('tanggal', @$_GET['tanggal']) }}" placeholder="Tanggal"
                                            data-date-range>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <input type="search" id="search" name="search"
                                            class="form-control form-control-sm " placeholder="Search..."
                                            value="{{ old('search', @$_GET['search']) }}"
                                            aria-label="Sizing example input">
                                        <button class="input-group-text "><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <a data-bs-toggle="modal" data-bs-target="#exportModal" type="button"
                                        class="btn btn-primary rounded">Cetak</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class=" table-responsive">
                    <table class="table mt-2">
                        <thead class=" border-bottom-2">
                            <tr>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">No</th>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">Tanggal</th>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">Nama Mesin</th>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">Jenis Downtime</th>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">Lama Downtime</th>
                                <th class="text-dark-blue" style="white-space: nowrap" scope="col">Downtime Terencana
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($oee as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \App\Helpers\DateHelper::getIndonesiaDate($data->created_at) }}</td>
                                <td>{{ $data->maintenance->nama_mesin }}</td>
                                <td>{{ $data->downtime->jenis_downtime}}</td>
                                <td>{{ $data->downtime->jumlah_downtime }} Menit</td>
                                <td>{{ $data->down_time_terencana}} Menit</td>
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
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-body-tertiary">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Cetak Riwayat Downtime</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" action="{{ route('downtime.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Tanggal Mulai</label>
                            <input type="date" name="start_date"
                                class="form-control  @error('start_date') is-invalid @enderror"
                                placeholder="Pilih Tanggal">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Tanggal Berkahir</label>
                            <input type="date" name="end_date"
                                class="form-control  @error('end_date') is-invalid @enderror"
                                placeholder="Pilih Tanggal">
                        </div>
                        <div class="col-md-12">
                            <label for="">Nama Mesin</label>
                            <select class=" form-select @error('nama_mesin') is-invalid @enderror" name="nama_mesin"
                                id="nama_mesin_filter">
                                <option disabled selected>Nama Mesin
                                </option>
                                @foreach($namaMesin as $nama)
                                <option value="{{ $nama }}">{{ $nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function () {
         // Ambil data dari PHP (diambil dari variabel $chartDataJson)
         var chartData = {!! $chartDataJson !!};

// Fungsi untuk menambahkan teks "menit" saat dihover pada tooltip
function customTooltip(context) {
    var label = context.dataset.label || '';

    if (label) {
        label += ': ';
    }

    if (context.parsed.y !== null) {
        label += context.parsed.y + ' menit';
    }

    return label;
}

// Buat fungsi untuk menggambar chart
function drawChart() {
    let ctx = document.getElementById('myChart');
    let chartData = {!! $chartDataJson !!};
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.map(data => data.label), // Menampilkan tanggal pada label
            datasets: [{
                label: 'Jumlah Downtime',
                data: chartData.map(data => data.data),
                borderWidth: 1
            }]
        },
        options: {
            aspectRatio: 9 / 6,
            pointStyle: "circle",
            pointBorderWidth: 15,
        }
    });

}

// Panggil fungsi untuk menggambar chart
drawChart();

        $('#nama_mesin').select2({
                width: '100%',
                placeholder: 'Nama mesin',
                allowClear: true,
                class: "resolve"
            });
        $('#nama_mesin_filter').select2({
                width: '100%',
                placeholder: 'Masukkan Nama Mesin',
                allowClear: true,
                class: "resolve"
            });
            $('input[name="tanggal"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('input[name="tanggal"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                $(this).trigger('change');
            });

            $('input[name="tanggal"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
                $(this).trigger('change');
            });
    });
</script>
@endsection
@endsection