@extends('layouts.guest')

@section('title', __('Login'))

@section('content')
    <div class="fauth fauth-centered">
        <main class="fauth-main">
            <div class="fauth-main-inner">


                <div class="fauth-logo-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="{{ __('Logo') }}" class="fauth-logo-img">
                </div>

                <div class="fauth-card">


                    <form class="fauth-form" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="fauth-field">
                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="name@example.com" required
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="fauth-field">
                            <div class="fauth-row-between">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <a href="#" class="fauth-link">{{ __('Forgot password?') }}</a>
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="{{ __('Enter your password') }}" required>
                                <button class="btn btn-outline-secondary" type="button" data-toggle-password>
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="fauth-row-between mb-2">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ __('Sign In') }}</button>

                        {{-- <div class="fauth-divider">
                            <span>{{ __('or') }}</span>
                        </div>

                        <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-google me-2"></i>{{ __('Sign in with Google') }}
                        </a> --}}

                    </form>
                </div>


            </div>
        </main>
    </div>
@endsection
