<div class="footer ">
    <div class="container pt-4 pb-2">
        <div class="row text-white">
            <div class="col-md-6 col-12">
                <img src="{{ asset('assets/images/logo/footer.png') }}" alt="i-maintenance" width="40%"
                    class="img-footer">

                <h5 class="mt-4 ">I-Maintenance <br>
                    adalah website untuk melakukan perhitungan Maintenance meliputi OEE, RBM, dan LCC.
                </h5>

                <p class="mt-4 fw-normal">
                    Jl. Telekomunikasi. 1, Terusan Buahbatu - Bojongsoang,
                    Telkom University, Sukapura, Kec. Dayeuhkolot,
                    Kabupaten Bandung, Jawa Barat 40257
                </p>
            </div>
            <div class="col-md-3 col-6 feature">
                <h6>Features</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('calculator-oee') }}" class="text-decoration-none">OEE</a></li>
                    <li><a href="{{ route('calculator-rbm') }}" class="text-decoration-none">RBM</a></li>
                    <li><a href="{{ route('calculator-lcc') }}" class="text-decoration-none">LCC</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-6 feature">
                <h6>Pelajari</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('aboutUs') }}" class="text-decoration-none">Tentang I-Maintanance</a></li>
                </ul>
            </div>
        </div>
        <p class="text-center mt-3 copyright" style="color: #A7B1BD">Copyright © 2023 Ahyar All Rights Reserved</p>
    </div>
</div>