@extends('layouts.calculator')

@section('content')
<section class="hero-calculator">
    <div class="container text-center mb-4">
        <h1 class="text-primary">Overall Equipment Effectiveness calculator</h1>
        <h4 class="text-secondary">help you estimate the inspection on existing machines</h4>
    </div>
</section>

<section class="form-calculator">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('calculator-oee.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Nama Mesin</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="nama_mesin" id="nama_mesin" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Shift Start</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="time" name="shift_start" id="shiftstart" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Shift End</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="time" name="shift_end" id="shiftend" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Planned Downtime</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="planned_downtime" id="planned" class="form-control" />
                            <div class="form-text float-start fw-light">(minute)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Unplanned Downtime</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="unplanned_downtime" id="unplanned" class="form-control" />
                            <div class="form-text float-start fw-light">(minute)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Total Parts Produced</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="total_parts_produced" id="total" class="form-control" />
                            <div class="form-text float-start fw-light">(Pieces)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Ideal Run Rate</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="ideal_run_rate" id="idealRunRate" class="form-control" />
                            <div class="form-text float-start fw-light">(Pieces Per Minute)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Total Scrap</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="total_scrap" id="scrap" class="form-control " />
                            <div class="form-text float-start fw-light">(Pieces)</div>
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
                        <div class="card result bg-dark-blue">
                            <h3 class="text-white text-center title">OEE%</h3>
                            <h3 class="text-white text-center"><span id="result_oee">0</span>%</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h5 class="text-white text-center title child">Performance</h5>
                            <h3 class="text-white text-center"><span id="result_performance">0</span>%</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h5 class="text-white text-center title child">Quality</h5>
                            <h3 class="text-white text-center"><span id="result_quality">0</span>%</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-4 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h5 class="text-white text-center title child">Availability</h5>
                            <h3 class="text-white text-center"><span id="result_availability">0</span>%</h3>
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
        <h1 class="text-center">Apa yang diberikan OEE kepada mesin ada?</h1>
        <p>OEE (Overall Equipment Efficiency) memberikan wawasan yang berharga tentang kinerja mesin atau peralatan
            produksi Anda. OEE menggabungkan tiga faktor utama yaitu ketersediaan (availability), kinerja (performance),
            dan kualitas (quality), untuk memberikan gambaran keseluruhan tentang efisiensi dan produktivitas mesin.
            Dengan menganalisis OEE, Anda dapat mengetahui seberapa sering mesin tersedia untuk digunakan, seberapa
            efektif mesin mencapai target kecepatan produksi yang diinginkan, dan seberapa baik mesin menghasilkan
            produk berkualitas tinggi tanpa adanya cacat atau scrap. Informasi ini membantu Anda mengidentifikasi area
            perbaikan dan mengoptimalkan kinerja mesin untuk meningkatkan efisiensi produksi.</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <h1 class="text-center">Bagaimana Cara Kerja Kalkulator OEE?</h1>
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
        <h1 class="text-center">Mengapa Mengotomatiskan Perhitungan OEE Anda?</h1>
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
        <h1 class="text-center">Bagaimana Meningkatkan OEE?</h1>
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
        <h1 class="text-center">Kesimpulan</h1>
        <p>OEE memberikan wawasan yang penting tentang kinerja mesin atau peralatan produksi Anda. Dengan memahami
            bagaimana OEE dihitung dan menggunakan kalkulator OEE, Anda dapat mengidentifikasi area perbaikan dan
            mengoptimalkan kinerja mesin untuk meningkatkan efisiensi dan produktivitas. Mengotomatiskan perhitungan OEE
            mempercepat proses dan meningkatkan akurasi data, sementara strategi untuk meningkatkan OEE melibatkan
            peningkatan ketersediaan, kinerja, dan kualitas. Dengan fokus pada peningkatan OEE, Anda dapat
            mengoptimalkan penggunaan mesin dan mencapai kinerja produksi yang lebih baik.</p>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center">Kesimpulan</h1>
        <p>OEE memberikan wawasan yang penting tentang kinerja mesin atau peralatan produksi Anda. Dengan memahami
            bagaimana OEE dihitung dan menggunakan kalkulator OEE, Anda dapat mengidentifikasi area perbaikan dan
            mengoptimalkan kinerja mesin untuk meningkatkan efisiensi dan produktivitas. Mengotomatiskan perhitungan
            OEE
            mempercepat proses dan meningkatkan akurasi data, sementara strategi untuk meningkatkan OEE melibatkan
            peningkatan ketersediaan, kinerja, dan kualitas. Dengan fokus pada peningkatan OEE, Anda dapat
            mengoptimalkan penggunaan mesin dan mencapai kinerja produksi yang lebih baik.</p>
    </div>
</section>

@section('script')
<script>
    $(document).ready(function() {
            function calculateOEE() {
                // Ambil nilai dari input
                let shiftStart = getTimeValue($('#shiftstart').val());
                let shiftEnd = getTimeValue($('#shiftend').val());
                let plannedDowntime = parseInt($('#planned').val());
                let unplannedDowntime = parseInt($('#unplanned').val());
                let totalPartsProduced = parseInt($('#total').val());
                let idealRunRate = parseInt($('#idealRunRate').val());
                let totalScrap = parseInt($('#scrap').val());
                // Hitung nilai Shift Length
                let shiftLength = calculateShiftLength(shiftStart, shiftEnd);

                // Hitung nilai Planned Production Time
                let plannedProductionTime = shiftLength - plannedDowntime;

                // Hitung nilai Operating Time
                let operatingTime = plannedProductionTime - unplannedDowntime;

              // Hitung nilai Availability
                let availability = (operatingTime / plannedProductionTime) * 100;
                availability = isNaN(availability) ? 0 : availability;
                availability = Math.round(Math.max(Math.min(availability, 100), 0));

                // Hitung nilai Performance
                let performance = (totalPartsProduced / operatingTime) / idealRunRate;
                performance = isNaN(performance) ? 0 : performance;
                performance = Math.round(Math.max(Math.min(performance * 100, 100), 0));

                // Hitung nilai Quality
                let quality = (totalPartsProduced - totalScrap) / totalPartsProduced;
                quality = isNaN(quality) ? 0 : quality;
                quality = Math.round(Math.max(Math.min(quality * 100, 100), 0));

                // Hitung nilai OEE
                let oee = (availability / 100) * (performance / 100) * (quality / 100);
                oee = isNaN(oee) ? 0 : oee;
                oee = Math.round(Math.max(Math.min(oee * 100, 100), 0));



                // Tampilkan hasil ke result
                $('#result_availability').text(availability);
                $('#result_performance').text(performance);
                $('#result_quality').text(quality);
                $('#result_oee').text(oee);

                // Keterangan
                const keterangan = $('#keterangan')
                if (oee === 0) {
                    keterangan.addClass('d-none');
                } else if (oee > 60) {
                    keterangan.removeClass('d-none');
                    keterangan.removeClass('bg-danger');
                    keterangan.addClass('bg-secondary').text('Mesin anda bekerja dengan baik')
                } else if (oee < 60) {
                    keterangan.removeClass('d-none');
                    keterangan.removeClass('bg-secondary');
                    keterangan.addClass('bg-danger').text('Harap untuk mengecek Mesin anda')
                }
            }
            // Mengubah waktu ke dalam menit dengan format AM dan PM
            function getTimeValue(time) {
                let parts = time.split(':');
                let hours = parseInt(parts[0]);
                let minutes = parseInt(parts[1]);

                if (hours === 12 && time.includes('AM')) {
                    hours = 0; // Midnight
                } else if (hours !== 12 && time.includes('PM')) {
                    hours += 12; // Afternoon
                }

                return (hours * 60) + minutes;
            }

            // Menghitung Shift Length dengan memperhitungkan format waktu AM dan PM
            function calculateShiftLength(start, end) {
                if (end < start) {
                    end += 24 * 60; // Tambah 1 hari (24 jam) jika Shift End berada di hari berikutnya
                }

                return end - start;
            }

            $('#shiftstart, #shiftend, #planned, #unplanned, #total, #idealRunRate, #scrap').change(function() {
                calculateOEE();
            });

            calculateOEE();
        });
</script>
@endsection
@endsection