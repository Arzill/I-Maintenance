@extends('layouts.calculator')

@section('content')
<section class="hero-calculator">
    <div class="container text-center mb-4">
        <h1 class="text-primary fw-bold">Overall Equipment Effectiveness calculator</h1>
        <h4 class="text-secondary fw-bold">help you estimate the inspection on existing machines</h4>
    </div>
</section>

<section class="form-calculator">
    <div class="container">
        <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ol>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
            @endif
            <div class="col-md-6">
                <form action="{{ route('calculator-oee.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Nama Mesin</h5>
                        </div>
                        <div class="col-md-7">
                            @guest()
                            <input type="text" name="nama_mesin"
                                class="form-control me-1 @error('nama_mesin') is-invalid @enderror" />
                            @endguest
                            @auth
                            <select class=" form-select @error('nama_mesin') is-invalid @enderror" name="nama_mesin"
                                id="nama_mesin">
                                <option disabled selected>Nama Mesin
                                </option>
                                @foreach($namaMesin as $nama)
                                <option value="{{ $nama }}">{{ $nama }}
                                </option>
                                @endforeach
                            </select>
                            @endauth
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Waktu Produksi</h5>
                        </div>
                        <div class="col-md-4 pe-1 ">
                            <div class="d-flex align-items-center">
                                <input type="time" name="waktu_mulai_produksi" id="waktuMulai"
                                    class="form-control me-1 @error('waktu_mulai_produksi') is-invalid @enderror"
                                    value="{{ old('waktu_mulai_produksi') }}" />
                                <span>Sampai</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="time" name="waktu_selesai_produksi" id="waktuSelesai"
                                class="form-control @error('waktu_selesai_produksi') is-invalid @enderror"
                                value="{{ old('waktu_selesai_produksi') }}" />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Down Time</h5>
                        </div>
                        <div class="col-md-7">
                            <select class="form-select" aria-label="Default select example" name="jenis_downtime">
                                <option disabled selected>Jenis Down Time</option>
                                <option value="Kerusakan mesin atau peralatan yang tidak terduga" {{
                                    old('jenis_downtime')=='Kerusakan mesin atau peralatan yang tidak terduga'
                                    ? 'selected' : '' }}>Kerusakan mesin atau
                                    peralatan yang tidak terduga </option>
                                <option value="Kerusakan atau keausan komponen" {{
                                    old('jenis_downtime')=='Kerusakan atau keausan komponen' ? 'selected' : '' }}>
                                    Kerusakan atau keausan komponen</option>
                                <option value="Gangguan listrik atau pemadaman" {{
                                    old('jenis_downtime')=='Gangguan listrik atau pemadaman' ? 'selected' : '' }}>
                                    Gangguan listrik atau pemadaman</option>
                                <option value="Kehabisan Bahan Baku" {{ old('jenis_downtime')=='Kehabisan Bahan Baku'
                                    ? 'selected' : '' }}>
                                    Kehabisan Bahan Baku</option>
                                <option value="Kerusakan dan penggantian suku cadang" {{
                                    old('jenis_downtime')=='Kehabisan Bahan Baku' ? 'selected' : '' }}>Kerusakan dan
                                    penggantian suku
                                    cadang</option>
                                <option value="Penurunan Kualitas" {{ old('jenis_downtime')=='Penurunan Kualitas'
                                    ? 'selected' : '' }}>Penurunan Kualitas</option>
                                <option value="Penurunan Kecepatan" {{ old('jenis_downtime')=='Penurunan Kecepatan'
                                    ? 'selected' : '' }}>Penurunan Kecepatan</option>
                                <option value="Gangguan dan Peristiwa Tidak Terduga" {{
                                    old('jenis_downtime')=='Gangguan dan Peristiwa Tidak Terduga' ? 'selected' : '' }}>
                                    Gangguan dan
                                    Peristiwa Tidak
                                    Terduga</option>
                                <option value="Gangguan minor pada mesin atau alat" {{
                                    old('jenis_downtime')=='Gangguan minor pada mesin atau alat' ? 'selected' : '' }}>
                                    Gangguan minor
                                    pada mesin atau alat
                                </option>
                                <option value="Lain-lainnya" {{ old('jenis_downtime')=='Lain-lainnya' ? 'selected' : ''
                                    }}>Lain-lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-end align-items-center">
                        <div class="col-md-4 pe-1 ">
                            <div class="d-flex align-items-center">
                                <input type="time" name="jam_mulai_downtime" id="mulaiDowntime"
                                    class="form-control me-1 @error('jam_mulai_dowstime') is-invalid @enderror"
                                    value="{{ old('jam_mulai_downtime') }}" />
                                <span>Sampai</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="time" name="jam_selesai_downtime" id="selesaiDowntime"
                                class="form-control @error('jam_selesai_downtime') is-invalid @enderror"
                                value="{{ old('jam_selesai_downtime') }}" />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Downtime Terencana</h5>
                        </div>
                        <div class="col-md-4 pe-1 ">
                            <div class="d-flex align-items-center">
                                <input type="time" name="mulai_downtime_terencana" id="mulaiTerencana"
                                    class="form-control me-1 @error('mulai_downtime_terencana') is-invalid @enderror"
                                    value="{{ old('mulai_downtime_terencana') }}" />
                                <span>Sampai</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="time" name="selesai_downtime_terencana" id="selesaiTerencana"
                                class="form-control @error('selesai_downtime_terencana') is-invalid @enderror"
                                value="{{ old('selesai_downtime_terencana') }}" />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Waktu Total Produksi</h5>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="number" name="waktu_total_produksi" id="waktuTotalProduksi" value=""
                                    class="form-control border bg-dark-subtle  @error('waktu_total_produksi') is-invalid @enderror"
                                    readonly placeholder="0">
                                <span class="input-group-text bg-dark-subtle">Menit</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Total Produksi</h5>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="number" name="total_produksi" id="totalProduksi"
                                    class="form-control border count @error('total_produksi') is-invalid @enderror"
                                    value="{{ old('total_produksi') }}" placeholder="0">
                                <span class="input-group-text bg-dark-subtle">Unit</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Tingkat Produksi Ideal</h5>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="number" name="tingkat_produksi_ideal" id="tingkatProduksiIdeal"
                                    class="form-control border count @error('tingkat_produksi_ideal') is-invalid @enderror"
                                    value="{{ old('tingkat_produksi_ideal') }}" placeholder="0">
                                <span class="input-group-text bg-dark-subtle">Unit/Menit</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Produksi Cacat / Gagal</h5>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="number" name="produksi_cacat" id="produksiCacat"
                                    class="form-control border count @error('produksi_cacat') is-invalid @enderror"
                                    value="{{ old('produksi_cacat') }}" placeholder="0">
                                <span class="input-group-text bg-dark-subtle">Unit</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-5">
                            <h5 class="fw-bold">Produksi Baik</h5>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="number" name="produksi_baik" id="produksiBaik"
                                    class="form-control border bg-dark-subtle @error('produksi_baik') is-invalid @enderror"
                                    readonly placeholder="0" value="">
                                <span class="input-group-text bg-dark-subtle">Unit</span>
                            </div>
                        </div>
                    </div>
                    @auth()
                    @can('user')
                    <div class="mb-3 button">
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </div>
                    @endcan
                    @endauth
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3 ">
                        <div class="card result bg-dark-blue ">
                            <h3 class="text-white text-center title fw-bold">OEE%</h3>
                            <h3 class="text-white text-center fw-bold"><span id="result_oee" class="fw-bold">0</span>%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h4 class="text-white text-center title child fw-bold">Performance</h4>
                            <h3 class="text-white text-center fw-bold"><span id="result_performance"
                                    class="fw-bold">0</span>%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h4 class="text-white text-center title child fw-bold">Quality</h4>
                            <h3 class="text-white text-center fw-bold"><span id="result_quality"
                                    class="fw-bold">0</span>%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h4 class="text-white text-center title child fw-bold">Availability</h4>
                            <h3 class="text-white text-center fw-bold"><span id="result_availability"
                                    class="fw-bold">0</span>%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-grid">
                            <span class="badge p-3 fs-4" id="keterangan">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center fw-bold">Apa yang diberikan OEE kepada mesin ada?</h1>
        <p>OEE (Overall Equipment Efficiency) memberikan wawasan yang berharga tentang kinerja mesin atau peralatan
            produksi Anda. OEE menggabungkan tiga faktor utama yaitu ketersediaan (availability), kinerja (performance),
            dan kualitas (quality), untuk memberikan gambaran keseluruhan tentang efisiensi dan produktivitas mesin.
            Dengan menganalisis OEE, Anda dapat mengetahui seberapa sering mesin tersedia untuk digunakan, seberapa
            efektif mesin mencapai target kecepatan produksi yang diinginkan, dan seberapa baik mesin menghasilkan
            produk berkualitas tinggi tanpa adanya cacat atau scrap. Informasi ini membantu Anda mengidentifikasi area
            perbaikan dan mengoptimalkan kinerja mesin untuk meningkatkan efisiensi produksi.</p>
        <div class="row justify-content-center">
            <p>Berikut merupakan penjelasan singkat terkait data yang di butuhkan diatas:</p>
            <div class="col-lg-8 col-md-8 col-12">
                <img src="{{ asset('assets/images/calculator/oeeTabelInputan.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container">
        <h1 class="text-center fw-bold">Bagaimana Cara Kerja Kalkulator OEE?</h1>
        <p>Kalkulator OEE bekerja dengan mengumpulkan data operasional dan kuantitatif dari mesin atau peralatan
            produksi.
            Data ini meliputi waktu operasional, waktu berhenti yang direncanakan, waktu berhenti yang tidak
            direncanakan,
            jumlah produk yang diproduksi, waktu siklus yang ideal, dan jumlah scrap yang dihasilkan. Kalkulator OEE
            kemudian menggunakan rumus-rumus yang telah ditentukan untuk menghitung nilai OEE berdasarkan data yang
            diberikan. Hasilnya adalah persentase yang menunjukkan seberapa efisien mesin tersebut dalam menghasilkan
            produk.</p>
        <h6 class="text-center">OEE (%) = Availability (%) x Performance efficiency (%) x Rate of Quality Product (%)
        </h6>
        <div class="row d-flex justify-content-center mt-4">
            <div class="col-md-8 col-lg-6 col-12">
                <img src="{{ asset('assets/images/calculator/oee.png') }}" alt="tabel-oee" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center fw-bold">Mengapa Mengotomatiskan Perhitungan OEE Anda?</h1>
        <p>Mengotomatiskan perhitungan OEE memiliki beberapa manfaat. Pertama, otomatisasi mengurangi kesalahan manusia
            dalam perhitungan dan memastikan konsistensi dalam pengumpulan dan analisis data. Kedua, otomatisasi
            memungkinkan perhitungan OEE secara real-time, memberikan informasi yang lebih cepat dan akurat tentang
            kinerja mesin. Ketiga, otomatisasi memudahkan pelacakan OEE dari waktu ke waktu, memungkinkan identifikasi
            tren dan perubahan kinerja yang membutuhkan perhatian. Terakhir, dengan mengotomatiskan perhitungan OEE,
            waktu dan upaya yang diperlukan untuk mengumpulkan dan menganalisis data dapat dikurangi, memungkinkan fokus
            yang lebih besar pada perbaikan dan peningkatan produktivitas.</p>
    </div>
</section>

{{-- edit --}}
<section class="content">
    <div class="container">
        <h1 class="text-center fw-bold">Bagaimana Meningkatkan OEE?</h1>
        <ol>
            <li class="fw-light mb-3">Tingkatkan Ketersediaan: Identifikasi dan kurangi waktu berhenti yang tidak
                direncanakan, lakukan
                pemeliharaan terjadwal, dan pastikan peralatan tersedia sesuai dengan jadwal produksi.</li>
            <li class="fw-light mb-3">Tingkatkan Kinerja: Identifikasi dan perbaiki faktor-faktor yang menghambat
                kecepatan
                produksi, lakukan pelatihan dan pengembangan operator, dan optimalkan aliran produksi.</li>
            <li class="fw-light mb-3">Tingkatkan Kualitas: Identifikasi dan kurangi jumlah scrap atau produk cacat,
                terapkan
                kontrol kualitas yang ketat, dan tingkatkan pemantauan dan pengujian produk.</li>
            <li class="fw-light mb-3">Implementasikan Peningkatan Proses: Gunakan metodologi seperti Lean Manufacturing
                atau
                Six Sigma untuk mengidentifikasi dan menghilangkan pemborosan dan kegagalan proses.</li>
            <li class="fw-light mb-3">Gunakan Teknologi dan Sistem Otomatisasi: Implementasikan sistem pemantauan
                real-time,
                pengumpulan data otomatis, dan analitik yang canggih untuk mendapatkan wawasan yang lebih baik tentang
                kinerja mesin dan mengambil tindakan yang cepat.</li>
        </ol>
    </div>
</section>
<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center fw-bold">Kesimpulan</h1>
        <p>OEE memberikan wawasan yang penting tentang kinerja mesin atau peralatan produksi Anda. Dengan memahami
            bagaimana OEE dihitung dan menggunakan kalkulator OEE, Anda dapat mengidentifikasi area perbaikan dan
            mengoptimalkan kinerja mesin untuk meningkatkan efisiensi dan produktivitas. Mengotomatiskan perhitungan OEE
            mempercepat proses dan meningkatkan akurasi data, sementara strategi untuk meningkatkan OEE melibatkan
            peningkatan ketersediaan, kinerja, dan kualitas. Dengan fokus pada peningkatan OEE, Anda dapat
            mengoptimalkan penggunaan mesin dan mencapai kinerja produksi yang lebih baik.</p>
    </div>
</section>

@section('script')
<script>
    $(document).ready(function() {

          // Mengubah waktu ke dalam menit dengan format AM dan PM
          function getMinuteDifference(start, end) {
                if (!start || !start.includes(':') || !end || !end.includes(':')) {
                    return 0; // Return 0 for invalid or empty time format
                }

                let startParts = start.split(':');
                let endParts = end.split(':');
                let startHours = parseInt(startParts[0]);
                let startMinutes = parseInt(startParts[1]);
                let endHours = parseInt(endParts[0]);
                let endMinutes = parseInt(endParts[1]);

                let startInMinutes = startHours * 60 + startMinutes;
                let endInMinutes = endHours * 60 + endMinutes;

                return endInMinutes - startInMinutes;
            }

            function calculateOEE() {
                // Ambil nilai dari input
                let waktuMulai = $('#waktuMulai').val();
                let waktuSelesai = $('#waktuSelesai').val();
                let mulaiDowntime = $('#mulaiDowntime').val();
                let selesaiDowntime = $('#selesaiDowntime').val();
                let mulaiTerencana = $('#mulaiTerencana').val();
                let selesaiTerencana = $('#selesaiTerencana').val();
                let totalProduksi = parseInt($('#totalProduksi').val());
                let tingkatProduksiIdeal = parseInt($('#tingkatProduksiIdeal').val());
                let produksiCacat = parseInt($('#produksiCacat').val());

                // Menghitung selisih waktu
                let sisaWaktu = getMinuteDifference(waktuMulai,waktuSelesai);
                let downTime = getMinuteDifference(mulaiDowntime,selesaiDowntime);
                let downTimeTerencana = getMinuteDifference(mulaiTerencana,selesaiTerencana);
                let waktuTotalProduksi = sisaWaktu - downTime - downTimeTerencana;

                // Hitung nilai Availability
                let availability = (waktuTotalProduksi / sisaWaktu) * 100;
                availability = isNaN(availability) ? 0 : availability;
                availability = Math.round(Math.max(Math.min(availability, 100), 0));

                // Hitung nilai Performance
                let totalWaktuPerformance = (totalProduksi / (waktuTotalProduksi));
                let performance = totalWaktuPerformance / tingkatProduksiIdeal;
                performance = isNaN(performance) ? 0 : performance;
                performance = Math.round(Math.max(Math.min(performance * 100, 100), 0));


                // Hitung nilai Quality
                let produksiBaik = totalProduksi - produksiCacat;
                let quality = produksiBaik / totalProduksi;
                quality = isNaN(quality) ? 0 : quality;
                quality = Math.round(Math.max(Math.min(quality * 100, 100), 0));

                // Hitung nilai OEE
                let oee = (availability / 100) * (performance / 100) * (quality / 100);
                oee = isNaN(oee) ? 0 : oee;
                oee = Math.round(Math.max(Math.min(oee * 100, 100), 0));

                // Tampilkan hasil ke result
                $('#waktuTotalProduksi').val(waktuTotalProduksi);
                $('#produksiBaik').val(produksiBaik);
                $('#result_availability').text(availability);
                $('#result_performance').text(performance);
                $('#result_quality').text(quality);
                $('#result_oee').text(oee);

                // Keterangan
                const keterangan = $('#keterangan')
                if (oee === 0) {
                    keterangan.addClass('d-none');
                } else if (oee >= 85) {
                    keterangan.removeClass('d-none');
                    keterangan.removeClass('bg-danger');
                    keterangan.addClass('bg-secondary').text('Mesin anda bekerja dengan baik')
                } else if (oee < 85) {
                    keterangan.removeClass('d-none');
                    keterangan.removeClass('bg-secondary');
                    keterangan.addClass('bg-danger').text('Harap untuk mengecek Mesin anda')
                }
            }


            $('#waktuMulai, #waktuSelesai, #mulaiDowntime, #selesaiDowntime, #mulaiTerencana, #selesaiTerencana, #totalProduksi, #tingkatProduksiIdeal, #produksiCacat').change(function() {
                calculateOEE();
            });

            calculateOEE();
        });
</script>
@endsection
@endsection