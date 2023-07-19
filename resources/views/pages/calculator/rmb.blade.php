@extends('layouts.calculator')

@section('content')
<section class="hero-calculator">
    <div class="container text-center mb-4">
        <h1 class="text-primary">Risk Base Maintenance Calculator</h1>
        <h4 class="text-secondary">help you estimate the inspection on existing machines</h4>
    </div>
</section>

<section class="form-calculator">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Nama Mesin</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="" id="namaMesin" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Peluang Kegagalan</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="time" name="" id="peluangKegagalan" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Konsekunesi Kegagalan</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="time" name="" id="konsekuensiKegagalan" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Biayar Perbaikan </h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="" id="biayaPerbaikan" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>Biaya Kerugian Produksi</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="" id="biayaKerugianProduksi" class="form-control" />
                        </div>
                    </div>
                    @auth()
                    <div class="mb-3 button">
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </div>
                    @endauth
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3 ">
                        <div class="card result bg-dark-blue">
                            <h3 class="text-white text-center title">Biaya Kegagalan</h3>
                            <h3 class="text-white text-center">Rp. 5.000.000</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center">Apa manfaat menggunakan perhitungan RBM ?</h1>
        <p>RBM (Risk Base Maintenance) merupakan metode pemeliharaan yang didasarkan pada analisis risiko untuk
            mengelola kegagalan komponen atau suatu sistem dengan lebih efektif. Dengan menggunakan perhitungan RBM,
            suatu mesin produksi dapat pengelolaan pemeliharaan yang lebih efisien dengan memfokuskan upaya dan sumber
            daya pada suatu komponen. Dengan mendapatkan hasil output biaya kegagalan, kedepannya anda dapat mengambil
            keputusan yang lebih terinformasi. Dan dengan hasil biaya kegagalan yang sudah dihitung, anda dapat
            mengoptimalkan penggunaan sumber daya dan mengurangi biaya pemeliharaan yang tidak perlu. Dengan fokus
            komponen atau sistem yang memiliki risiko kegagalan tinggi, sumber daya dapat dialokasikan dengan lebih
            efisienuntuk meminimalkan biaya pemeliharaan sambil menjada tingkat keandalan yang diperlukan</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <h1 class="text-center">Bagaimana cara kerja Kalkulator RBM ?</h1>
        <p>Metode perhitungan RBM yang digunakan adalah metode Risk Base Inspection (RBI). Data yang diperlukan untuk
            melakukan perhitungan RBM adalah data Probability of Failure (PoF) dan Consequence of Failure (CoF). untuk
            mendapatkan nilai</p>
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
@endsection