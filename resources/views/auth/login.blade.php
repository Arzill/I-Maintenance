@extends('layouts.auth')

@section('content')
    <section id="auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 position-relative">
                    <img src="{{ asset('assets/images/authentication/bg1.png') }}" alt="" class="bg1">
                </div>
                <div class="col-xl-4 col-lg-5 col-md-7 col-12">
                    <div class="card border-0 shadow px-2">
                        <div class="card-header bg-transparent text-center border-0 p-5"><img
                                src="{{ asset('assets/images/logo/header.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="card-body">
                            <h4 class="fw-bold">Welcome to Website!👋 </h4>
                            <p class="fw-light">Please Sign-in to your Account and start the Adventure</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email" class="">{{ __('Email Address') }}</label>

                                    <div class="col-12">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Enter your email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="">{{ __('Password') }}</label>

                                    <div class="col-12">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password" placeholder="*********" required>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark-blue mb-3">
                                        {{ __('Sign In') }}
                                    </button>
                                </div>
                                <p class="text-center mb-4">New on our platform? <a href="{{ route('register') }}"
                                        class="text-decoration-none text-primary">Create
                                        an Account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 position-relative">
                    <img src="{{ asset('assets/images/authentication/bg2.png') }}" alt="" class="bg2">
                </div>
            </div>
        </div>
    </section>
@endsection
