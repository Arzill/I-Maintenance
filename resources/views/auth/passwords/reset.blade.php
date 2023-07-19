@extends('layouts.app')

@section('content')
<section id="reset">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 position-relative">
                <img src="{{ asset('assets/images/authentication/bg1.png') }}" alt="" class="bg1">
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 col-12">
                <div class="card border-0 shadow px-2 rounded">
                    <div class="card-header bg-transparent text-center border-0 p-5"><img
                            src="{{ asset('assets/images/logo/header.png') }}" class="img-fluid" alt="">
                    </div>

                    <div class="card-body">
                        <h4 class="fw-bold text-primary">{{ __('Reset Password') }}</h4>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email" class="mb-2">{{ __('Email Address')
                                    }}</label>

                                <div class="col-md-12">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                        autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="mb-2">{{ __('Password')
                                    }}</label>

                                <div class="col-md-12">
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
                                <label for="password-confirm" class="mb-2">{{ __('Confirm
                                    Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark-blue mb-3">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
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