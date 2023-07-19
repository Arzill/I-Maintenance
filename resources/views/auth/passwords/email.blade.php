@extends('layouts.app')

@section('content')
<section id="email">
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
                        <h4 class="fw-bold">Forgot Password? 🔒</h4>
                        <p>Enter your email and we'll send you instructions to reset your password</p>
                        @if (session('status'))
                        <div class="alert alert-success my-3" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="mb-2">{{ __('Email Address')
                                    }}</label>
                                <div class="col-md-12 mb-1">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark-blue mb-3">
                                    {{ __('Send Reset Link') }}
                                </button>
                            </div>
                            <p class="text-center mt-2"><i class="fa-solid fa-chevron-left"></i> <a
                                    class="text-decoration-none text-primary" href="{{ route('login') }}">Back To
                                    Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 position-relative">
            <img src="{{ asset('assets/images/authentication/bg2.png') }}" alt="" class="bg2">
        </div>
    </div>
</section>
@endsection