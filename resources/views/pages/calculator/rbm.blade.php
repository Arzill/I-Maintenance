@extends('layouts.calculator')

@section('content')
<section class="hero-calculator">
    <div class="container text-center mb-4">
        <h1 class="text-primary fw-bold">Risk Base Maintenance Calculator</h1>
        <h4 class="text-secondary fw-bold">help you estimate the inspection on existing machines</h4>
    </div>
</section>

<section class="form-calculator">
    <div class="container">
        <form action="{{ route('calculator-rbm.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Nama Mesin</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="nama_mesin" id="namaMesin" class="form-control"
                                placeholder="Nama mesin" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Jangka Waktu</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="number" maxlength="12" name="jangka_waktu" id="jangkaWaktu"
                                class="form-control" placeholder="Jangka Waktu" />
                            <div class="form-text float-start fw-light">(Perbulan)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Severity</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" maxlength="1" name="severity" id="severity" class="form-control"
                                placeholder="Skala 1-5" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Occurrence</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" maxlength="1" name="occurrence" id="occurrence" placeholder="Skala 1-5"
                                class="form-control" />
                        </div>
                    </div>
                    @auth()
                    @can('user')
                    <div class="mb-3 button">
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </div>
                    @endcan
                    @endauth
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-12 mb-3 ">
                            <div class="card result bg-dark-blue">
                                <h3 class="text-white text-center title fw-bold">Risk Priority Number</h3>
                                <h3 class="text-white text-center" id="result">0</h3>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-3 ">
                            <input type="hidden" name="risk" value="" id="risk_result">
                            <div class="d-grid">
                                <span class="badge p-3 fs-4 text-center fw-bold" id="risk">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-3 ">
                            <input type="hidden" name="rekomendasi" value="" id="rekomendasi_result">
                            <div class="d-grid badge   p-3 fs-4 text-white text-center" id="sectionRecommendation">
                                <p class="text-center">Pencegahan yang terbaik</p>
                                <a href="" class="text-white" id="recommendation">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center fw-bold">Apa manfaat menggunakan perhitungan RBM ?</h1>
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
        <h1 class="text-center fw-bold">Bagaimana cara kerja Kalkulator RBM ?</h1>
        <p>Metode perhitungan RBM yang digunakan adalah gabungan dari metode RBM dan FMEA untuk mengurangi risiko pada
            suatu mesin produksi. Dengan gabungan metode ini, didapatkan perhitungan Risk Priority Number. Untuk
            mendapatkan nilai RPN dibutuhkan data Severity dan Occurrence, yang nantinya akan menjadi sebuah perhitungan
            sebagai berikut:</p>
        <h6 class="text-center">RPN = Severity (S) x Occurrence (O)
        </h6>
        <p>Menentukan suatu kemungkinan terjadi, perlu ditentukan nilainya masing-masing dari skala 1 - 5, lalu
            didapatkan hasil RPN. Untuk menentukan skalanya bisa diambil contoh sebagai berikut:</p>
        <ul>
            Jangka Waktu : <strong>6 bulan</strong>
            <li>1 = Sangat jarang (rata-rata terjadi kerusakan kurang dari 2 kali dalam 6 bulan) </li>
            <li>2 = Jarang (rata-rata terjadi kerusakan kurang dari 3 kali dalam 6 bulan) </li>
            <li>3 = Medium (rata-rata terjadi kerusakan kurang dari 5 kali dalam 6 bulan) </li>
            <li>4 = Sering (rata-rata terjadi kerusakan kurang dari 6 kali dalam 6 bulan) </li>
            <li>5 = Sangat sering (Sering sekali terjadi kegagalan dalam 6 bulan)</li>
        </ul>
    </div>
</section>

<section class="content bg-secondary text-white">
    <div class="container">
        <h1 class="text-center fw-bold">Bagaimana cara melihat Risk Matrix ?</h1>
        <p>Setelah mendapatkan nilai RPN, selanjutnya adalah menentukan dimana letak nilai RPN pada Risk Matrix sesuai
            kategori. Terdapat 3 kategori dalam Risk Matrix, <span style="color: #91EF88">Hijau</span>, <span
                style="color: #FDFF8A">Kuning</span>, dan
            <span style="color: #DF3F44">Merah</span>
            dengan matrix 5x5.
        </p>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <img src="{{ asset('assets/images/calculator/rbm.png') }}" class="img-fluid mt-4 mb-5" alt="">
            </div>
        </div>
    </div>
</section>

{{-- edit --}}
<section class="content">
    <div class="container">
        <h1 class="text-center fw-bold">Membuat Mitigasi Plan</h1>
        <p>Suatu mesin produksi yang sering terjadi kerusakan dapat merugikan anda. Sehingga setelah melakukan
            identifikasi suatu keparahan mesin produksi, selanjutnya adalah melakukan perencanaan perawatan. Terdapa 3
            metode secara umum yang dapat digunakan, yaitu: </p>
        <ul class="ms-4">
            <li class=" mb-3">Corrective Maintenance
            </li>
            <li class=" mb-3">Preventive Maintenance</li>
        </ul>
        <p>Dengan begini, maka anda dapat mengurangi kerusakan pada suatu mesin produksi,. Sehingga kedepannya tidak
            akan terjadi kerusakan yang lebih parah dari sebelumnya.</p>
    </div>
</section>
@section('script')
<script>
    function calculateRPN() {
    let severityValue = parseInt($("#severity").val());
    let occurrenceValue = parseInt($("#occurrence").val());

    if (isNaN(severityValue) || isNaN(occurrenceValue)) {
        $("#result").text("");
        $("#risk").text("");
        $("#recommendation").text("");
    } else {
        let rpnValue = severityValue * occurrenceValue;
        rpnValue = Math.min(rpnValue, 25);

        let risk = "";
        let recommendation = "";


            if (severityValue == 1 && occurrenceValue == 1){
                    risk = "Low";
                    recommendation = "Preventive Maintenance";
            }else if(severityValue == 1 && occurrenceValue == 2){
                risk = "Low";
                    recommendation = "Preventive Maintenance"
            }else if(severityValue == 1 && occurrenceValue == 3){
                risk = "Low";
                    recommendation = "Preventive Maintenance"
            }else if(severityValue == 1 && occurrenceValue == 4){
                risk = "Low";
                    recommendation = "Preventive Maintenance"
            }else if(severityValue == 1 && occurrenceValue == 5){
                risk = "Low";
                recommendation = "Preventive Maintenance"
            }else if(severityValue == 2 && occurrenceValue == 1){
                risk = "Medium";
                recommendation = "Corrective Maintenance"
            }else if(severityValue == 2 && occurrenceValue == 2){
                risk = "Medium";
                    recommendation = "Corrective Maintenance"
            }else if(severityValue == 2 && occurrenceValue == 3){
                risk = "Low";
                recommendation = "Preventive Maintenance";
            }else if(severityValue == 2 && occurrenceValue == 4){
                risk = "Low";
                recommendation = "Preventive Maintenance";
            }else if(severityValue == 2 && occurrenceValue == 5){
                risk = "Low";
                    recommendation = "Preventive Maintenance";
            }else if(severityValue == 3 && occurrenceValue == 1){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 3 && occurrenceValue == 2){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 3 && occurrenceValue == 3){
                risk = "Medium";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 3 && occurrenceValue == 4){
                risk = "Low";
                    recommendation = "Preventive Maintenance";
            }else if(severityValue == 3 && occurrenceValue == 5){
                risk = "Low";
                    recommendation = "Preventive Maintenance";
            }else if(severityValue == 4 && occurrenceValue == 1){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 4 && occurrenceValue == 2){
                risk = "High";
                    recommendation = "Corrective Maintenance"
            }else if(severityValue == 4 && occurrenceValue == 3){
                risk = "High";
                    recommendation = "Corrective Maintenance"
            }else if(severityValue == 4 && occurrenceValue == 4){
                risk = "Medium";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 4 && occurrenceValue == 5){
                risk = "Low";
                    recommendation = "Preventive Maintenance";
            }else if(severityValue == 5 && occurrenceValue == 1){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 5 && occurrenceValue == 2){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 5 && occurrenceValue == 3){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 5 && occurrenceValue == 4){
                risk = "High";
                    recommendation = "Corrective Maintenance";
            }else if(severityValue == 5 && occurrenceValue == 5){
                risk = "Medium";
                    recommendation = "Corrective Maintenance";
            }
        $("#result").text(rpnValue);
        $("#risk").text(`Risk: ${risk}`);
        $("#recommendation").text(recommendation);

        if(recommendation === ''){
            $("#sectionRecommendation").addClass('d-none');
            $("#recommendation").addClass('d-none');
            $("#rekomendasi_result").val('');
        }else if(recommendation === 'Corrective Maintenance'){
            $("#sectionRecommendation").removeClass('d-none');
            $("#sectionRecommendation").addClass('bg-secondary');
            $("#recommendation").removeClass('d-none');
            $("#recommendation").attr('href', "{{ route('correctiveMaintenance') }}");
            $("#rekomendasi_result").val(recommendation);
        }else if(recommendation === 'Preventive Maintenance'){
            $("#sectionRecommendation").removeClass('d-none');
            $("#sectionRecommendation").addClass('bg-secondary');
            $("#recommendation").removeClass('d-none');
            $("#recommendation").attr('href', "{{ route('preventiveMaintenance') }}");
            $("#rekomendasi_result").val(recommendation);
        }


        // Hapus class sebelum menambahkan class baru
        $("#risk").removeClass("badge-green bg-warning bg-danger d-none");

        // Tambahkan class pada elemen untuk memberi warna berdasarkan kategori risiko
        if (risk === 'Low') {
            $("#risk").addClass('badge-green');
            $("#risk_result").val(risk);
        } else if (risk === 'Medium') {
            $("#risk").addClass('bg-warning');
            $("#risk_result").val(risk);
        } else if (risk === 'High') {
            $("#risk").addClass('bg-danger');
            $("#risk_result").val(risk);
        } else {
            $("#risk").addClass('d-none');
            $("#risk_result").val('');
        }


    }
}

$(document).ready(function() {
    $("#severity, #occurrence").on("input", function() {
        // Mengganti event "change" menjadi "input" untuk menghindari perhitungan saat input dihapus
        $(this).val($(this).val().replace(/[^1-5]/g, ''));
        calculateRPN();
    });
    $("#jangkaWaktu").on("input", function() {
        // Mengganti event "change" menjadi "input" untuk menghindari perhitungan saat input dihapus
        $(this).val($(this).val().replace(/[^1-9]/g, ''));
    });
});


</script>
@endsection
@endsection