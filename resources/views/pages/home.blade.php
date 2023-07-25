@extends('layouts.app')
@section('content')
<section id="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 mt-lg-5">
                <h1 class="fw-bold text-primary">Maintenance Calculator</h1>
                <h4 class="fw-bold text-secondary my-3">help you estimate the inspection on existing machines</h4>
                <div class="row mt-4">
                    <div class="col-md-8 ">
                        <a href="{{ route('calculator-rbm') }}"
                            class="badge badge-green text-decoration-none fw-light me-3 mb-3">Risk-bases
                            maintenance</a>
                        <a href="{{ route('calculator-lcc') }}"
                            class="badge badge-green text-decoration-none fw-light mb-3">Life cycle
                            costing</a>
                    </div>
                    <div class="col-md-6 mb-md-0 mb-3">
                        <a href="{{ route('calculator-oee') }}"
                            class="badge badge-green text-decoration-none fw-light">Overall Equipment
                            Effectiveness</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-lg-block  d-md-flex align-items-md-center mt-md-0 mt-3">
                <img src="{{ asset('assets/images/hero/hero.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>
<section id="fitur">
    <div class="container">
        <div class="row">
            <div class="col-md-12"></div>
        </div>
        <div class="card-group gap-3">
            <div class="card bg-dark-blue text-white rounded">
                <div class="row p-3 ms-2">
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/fitur/1.png') }}" class="img-fluid mb" alt="...">
                    </div>
                    <div class="col-md-8 d-flex align-items-center text-center">
                        <div class="card-body p-0">
                            <h5 class="card-title fw-bold mt-md-0 mt-2">Calculator</h5>
                            <p class="card-text">OEE, RBM, LCC Mudah Hitung dalam Seketika!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-dark-blue text-white rounded">
                <div class="row p-3">
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/fitur/2.png') }}" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-8 d-flex align-items-center text-center">
                        <div class="card-body p-0">
                            <h5 class="card-title fw-bold mt-md-0 mt-2">Easy to Use</h5>
                            <p class="card-text">Simpel & Praktis, Gunakan dengan Mudah!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-dark-blue text-white rounded">
                <div class="row p-3">
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/fitur/3.png') }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8 d-flex align-items-center text-center">
                        <div class="card-body p-0">
                            <h5 class="card-title fw-bold mt-md-0 mt-2">Cloud Saving</h5>
                            <p class="card-text">Data Terjaga dan Akses Selalu!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="tentang">
    <div class="container py-5">
        <div class="row py-3">
            <div class="col-md-7 text-white">
                <h2 class="fw-bold">Optimalkan Efisiensi dan Perawatan Pabrik Anda dengan Website Kami!</h2>
                <p>Aplikasi ini memaksimalkan efisiensi operasional dengan perhitungan yang mudah dan cepat agar
                    mencegah kerusakan mesin dan dapat mengurangi biaya. Solusi terbaik untuk tingkatkan produktivitas
                    dan kehandalan pabrik.</p>
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-light fw-bold">Lihat lebih lanjut</a>
            </div>
        </div>
    </div>
</section>
@endsection