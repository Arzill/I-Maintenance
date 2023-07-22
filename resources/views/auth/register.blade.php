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
                            <h4 class="fw-bold">Adventure starts here 🚀</h4>
                            <p>Get Profit with us here!</p>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="name" class="mb-2">Username</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus
                                            placeholder="Enter your username">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="email" class="mb-2">{{ __('Email Address') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Enter your email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12" class="mb-2">
                                        <label for="password">{{ __('Password') }}</label>

                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12" class="mb-2">
                                        <label
                                            for="password-confirm">{{ __('Confirm
                                                                                                                                                                                                                                                                    Password') }}</label>

                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark-blue mb-3">
                                        {{ __('Sign up') }}
                                    </button>
                                </div>
                                <p class="text-center text-primary mb-4">Already have an account? <a
                                        href="{{ route('login') }}" class="text-decoration-none text-primary">Login</a></p>
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
