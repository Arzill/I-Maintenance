@extends('layouts.app')

@section('content')
    <section id="dashboard">
        <div class="container">
            <div class="row ">
                <div class="col-xl-3 col-lg-4 col-md-5 col-12 mb-3">
                    <div class="section">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="header">
                                <div class="avatar">
                                    <img src="{{ Auth::user()->image ? Auth::user()->image : asset('assets/images/logo/avatar.png') }}"
                                        class="img-fluid rounded-circle">
                                </div>
                            </div>
                            <div class="card-body mt-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 mb-3">
                                        <h5 class="fw-bold text-dark-blue">{{ Auth::user()->name }}</h5>
                                    </div>
                                    <div class="col-md-10 ms-4">
                                        <ul class="mb-2  list-unstyled text-dark-blue">
                                            <li class="mb-2">
                                                <a class="nav-link  {{ request()->routeIs('dashboard') ? 'fw-bold' : 'fw-medium' }}"
                                                    aria-current="page" href="{{ route('dashboard') }}"><img
                                                        src="{{ asset('assets/images/icon/dashboard.svg') }}"
                                                        alt="">
                                                    Dashboard</a>
                                            </li>
                                            @can('admin')
                                                <li class="mb-2 text-dark-blue">
                                                    <a class="nav-link  {{ request()->routeIs('pengguna') ? 'fw-bold' : 'fw-medium' }}"
                                                        aria-current="page" href="{{ route('pengguna') }}"><img
                                                            src="{{ asset('assets/images/icon/users.svg') }}" alt="">
                                                        Pengguna</a>
                                                </li>
                                            @endcan
                                            <li class="mb-2">
                                                <a class="nav-link {{ request()->routeIs('oee') ? 'fw-bold' : 'fw-medium ' }}"
                                                    href="{{ route('oee') }}"><img
                                                        src="{{ asset('assets/images/icon/calendar-check.svg') }}"
                                                        alt="">
                                                    Riwayat OEE</a>
                                            </li>
                                            <li class="mb-2">
                                                <a class="nav-link {{ request()->routeIs('lcc') ? 'fw-bold' : 'fw-medium ' }}"
                                                    href="{{ route('lcc') }}"><img
                                                        src="{{ asset('assets/images/icon/flag.svg') }}" alt="">
                                                    Riwayat LCC </a>
                                            </li>
                                            <li class="mb-2">
                                                <a class="nav-link {{ request()->routeIs('rmb') ? 'fw-bold' : 'fw-medium ' }}"
                                                    href="{{ route('rmb') }}"><img
                                                        src="{{ asset('assets/images/icon/wallet2.svg') }}" alt="">
                                                    Riwayat RMB </a>
                                            </li>
                                            <li class="mb-2">
                                                <a class="nav-link {{ request()->routeIs('settings') ? 'fw-bold' : 'fw-medium' }}"
                                                    href="{{ route('settings') }}"><img
                                                        src="{{ asset('assets/images/icon/gear.svg') }}" alt="">
                                                    Pengaturan </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-7 col-12">
                    @yield('dashboard-content')
                </div>
            </div>
        </div>
    </section>
@endsection
