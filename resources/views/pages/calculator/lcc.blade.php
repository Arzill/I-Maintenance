@extends('layouts.calculator')

@section('content')
    <section class="hero-calculator">
        <div class="container text-center mb-4">
            <h1 class="text-primary">Life Cycle Cost Calculator</h1>
            <h4 class="text-secondary">help you estimate the inspection on existing machines</h4>
        </div>
    </section>
    <section class="form-calculator">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('calculator-lcc.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Nama Mesin</h5>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="nama_mesin" id="name"
                                    class="form-control @error('nama_mesin') is-invalid @enderror"
                                    placeholder="Masukkan Sama">
                                @error('nama_mesin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Biaya Inisiasi</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_inisiasi" id="inisiasi"
                                        class="form-control count @error('biaya_inisiasi') is-invalid @enderror"
                                        placeholder="0">
                                    @error('biaya_inisiasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Biaya Operasional Tahunan</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_operasional_tahunan" id="operasional"
                                        class="form-control count @error('biaya_operasional_tahunan') is-invalid @enderror"
                                        placeholder="0">
                                    @error('biaya_operasional_tahunan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Biaya Pemeliharaan Tahunan</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_pemeliharaan_tahunan" id="pemeliharaan"
                                        class="form-control count @error('biaya_pemeliharaan_tahunan') is-invalid @enderror"
                                        placeholder="0">
                                    @error('biaya_pemeliharaan_tahunan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Biaya Pembongkaran</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_pembongkaran" id="pembongkaran"
                                        class="form-control count @error('biaya_pembongkaran') is-invalid @enderror"
                                        placeholder="0">
                                    @error('biaya_pembongkaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h5>Estimasi Masa Hidup</h5>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="estimasi_tahunan" id="estimasi"
                                    class="form-control @error('estimasi_tahunan') is-invalid @enderror" placeholder="0">
                                <div class="form-text float-end fw-light">(dalam bentuk tahun)</div>
                                @error('estimasi_tahunan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @auth
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
                                <h3 class="text-white text-center title">Life Cycle Cost</h3>
                                <h3 class="text-white text-center">Rp <span id="result"></span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content bg-secondary text-white">
        <div class="container">
            <h1 class="text-center">Apa yang diberikan LCC kepada mesin anda?</h1>
            <p>LCC (Life-Cycle Cost) menjabarkan biaya total dalam memiliki sebuah mesin terikat dengan estimasi masa
                hidupnya. LCC melibatkan perhitungan semua biaya yang terkait dengan mesin selama masa pakainya dari tahap
                perencanaan, pemasangan, perawatan, penggunaan, hingga ke pembongkaran. Dengan memprediksi biaya total dari
                sebuah mesin, anda dapat merencanakan secara lebih baik yang berdampak positif dalam pemilihan keputusan.
            </p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <h1 class="text-center">Bagaimana Cara Kerja Kalkulator LCC?</h1>
            <p>Kalkulator LCC ini membutuhkan data berupa Biaya Inisiasi, Biaya Operasional, Biaya Pemeliharaan, Biaya
                Pembongkaran, dan Masa Hidup Mesin. Masing-masing data terkecuali Masa Hidup Mesin merupakan akumulasi dari
                berbagai data pendukung lain. Untuk menggunakan mesin dibutuhkan Biaya Operasional dan jika terjadi
                kerusakan maka dibutuhkan Biaya Pemeliharaan. Semua ini terjadi pada selama mesin beroperasional, maka
                terikat dengan estimasi Masa Hidup Mesin. Biaya Inisiasi dan Pembongkaran hanya dilakukan sekali. Data-data
                tersebut digunakan untuk menghasilkan nilai LCC yang dapat menggambarkan biaya total dari mesin mulai dari
                kepemilikan, penggunaan, dan penyingkiran mesin.</p>
            <h6 class="text-center">LCC = Biaya Inisiasi + Masa Hidup Mesin(Biaya Operasional + Biaya Pemeliharaan) + Biaya
                Pembongkaran
            </h6>
        </div>
    </section>

    <section class="content bg-secondary text-white">
        <div class="container">
            <h1 class="text-center">Data Apa Saja Yang Dibutuhkan LCC?</h1>
            <ol>
                <li class="mb-2">Biaya Inisiasi = Biaya yang dibutuhkan untuk akuisisi atau mendapatkan kepemilikan
                    terhadap sebuah
                    mesin.</li>
                <li class="mb-2">Biaya Operasional = Biaya untuk menjalankan atau mengoperasikan produk atau mesin.</li>
                <li class="mb-2">Biaya Pemeliharaan = Biaya untuk merawat selama siklus hidup mesin agar dapat berjalan
                    secara optimal.
                </li>
                <li class="mb-2">Biaya Pembongkaran = Biaya pembongkaran adalah biaya ketika diperlukan pemindahan atau
                    pembuangan mesin.
                </li>
                <li class="mb-2">Masa Hidup Mesin = Estimasi periode waktu selama mesin diharapkan dapat berfungsi secara
                    efektif dan
                    efisien.</li>
            </ol>

            <p>Dari penjelasan diatas, apa saja data pendukung yang relevan dalam perhitungan LCC? Berikut adalah data-data
                yang umumnya digunakan dalam perhitungan LCC.</p>

            <ul>
                <li class="mb-2">Biaya Inisiasi : Biaya Pembelian, Instalasi, Pengiriman, Perizinan</li>
                <li class="mb-2">Biaya Operasional : Biaya Tahunan Bahan Baku, Tenaga Kerja, Listrik, Bahan Bakar</li>
                <li class="mb-2">Biaya Pemeliharaan : Biaya Tahunan Pembelian Suku Cadang, Penggantian Suku Cadang</li>
                <li class="mb-2">Biaya Pembongkaran : Biaya Pembongkaran, Pengangkutan, Pembuangan</li>
                <li class="mb-2">Masa Hidup Mesin : Estimasi Masa Hidup Mesin Dalam Bentuk Tahun</li>
            </ul>
            <p>Data-data yang digunakan dalam perhitungan LCC adalah akumulasi dari data-data lainnya. Hal ini dikarenakan
                beragamnya kasus yang terjadi untuk memiliki atau menggunakan sebuah mesin.</p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <h1 class="text-center">Bagaimana Mengefisienkan Nilai LCC?</h1>
            <p>Nilai LCC yang lebih rendah berarti pengeluaran uang yang lebih rendah juga, namun tidak berarti jika anda
                menggunakan mesin atau sparepart yang lebih murah dapat menghasilkan keuntungan yang sama andaikan anda
                menggunakan mesin atau sparepart dengan bahan dan desain yang lebih bagus. Berikut adalah saran atau
                peraturan umum yang mungkin dapat membantu anda dalam mengefisienkan biaya estimasi berdasarkan LCC.</p>
            <ul>
                <li class="mb-4"><b>Temukan keseimbangan antara biaya operasional dan biaya pemeliharaan.</b> Dengan
                    tenaga kerja yang
                    lebih
                    banyak maka mesin dapat dirawat secara intensif, mirip seperti listirk, bahan, baku, atau bahan bakar
                    terutama pada mesin yang rentan mengalami kerusakan jika tiba-tiba berhenti. Namun memiliki tenaga kerja
                    yang terlalu banyak atau memastikan bahan baku pada kapasitas penuh dapat membengkakan biaya
                    operasional. Sebaliknya, jika mesin menggunakan sparepart dengan bahan yang lebih bagus maka kerentanan
                    mesin dalam kerusakan dapat menurun sehingga mesin lebih awet. Tetapi bahan terlalu bagus juga dapat
                    menaikan harga pemeliharaan. Pilihlah keseimbangan antara produksi dengan sparepart yang memadai, tidak
                    jauh melebihi kebutuhan yang ada.</li>
                <li class="mb-4"><b>Semakin banyak mesin yang dipasang maka semakin mahal biaya pembongkaran, biaya
                        operasional, dan biaya pemeliharaan.</b> Selain ditentukan dari kompleksitas dan besarnya mesin,
                    biaya pembongkaran juga dipengaruhi jumlah mesin yang terpasang. Semakin banyak mesin yang terpasang
                    berarti semakin besar biaya pembongkarannya. Sehingga disarankan untuk memasang mesin dengan jumlah
                    sesuai kebutuhan yang ada. Pilihlah jumlah mesin yang anda percaya dapat anda rawat.</li>
                <li class="mb-4"><b>Semakin lama mesin digunakan maka semakin mahal biaya pemeliharaan.</b> Seiring
                    dengan umur, mesin akan menjadi rentan mengalami kerusakan dikarenakan kualitas komponen menurun karena
                    usia. Dengan ini maka semakin besar pula biaya pemeliharaan pada mesin yang berumur tua. Dalam beberapa
                    kasus, lebih baik untuk mengganti mesin secara keseluruhan dibandingkan memperbaikinya. Oleh karena itu,
                    gunakanlah mesin sesuai ekspektasi hidup yang diberikan atau waspadalah jika terjadi kerusakan yang
                    banyak pada interval dekat.</li>
            </ul>
        </div>
    </section>

    <section class="content bg-secondary text-white">
        <div class="container">
            <h1 class="text-center">Kesimpulan</h1>
            <p>LCC menggambarkan biaya jangka panjang dari sebuah mesin. Dari awal pembelian hingga akhir pembongkaran.
                Dengan mengetahui LCC anda dapat mengetahui biaya secara garis besar yang membantu dalam perencanaan
                pembelian atau penggunaan sebuah mesin. Perhitugan LCC dapat berubah sesuai kondisi yang ada sehingga
                fleksibel dan dapat digunakan pada kasus yang spesifik. Selain membantu dalam proses pembuatan keputusan,
                LCC dapat digunakan untuk membandingkan biaya total dari vendor ataupun mesin yang berbeda.</p>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            var total = 0;
            $("#inisiasi, #operasional, #pemeliharaan, #pembongkaran, #estimasi").keyup(function() {
                var i = Number($("#inisiasi").val());
                var o = Number($("#operasional").val());
                var p = Number($("#pemeliharaan").val());
                var m = Number($("#pembongkaran").val());
                var e = Number($("#estimasi").val());
                total = i + (e * o) + (e * p) + m;
                var total_format = total.toLocaleString('en-US')
                $("#result").html(total_format);
            });
            $("#result").html(total);
        })
    </script>
@endsection
