@extends('layouts.main')

@section('title', 'Login')

@section('main_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                <div class="card-header text-center fw-bold" style="background:#bcead5; color:#2d5a3a; font-size:1.3rem; border-radius:14px 14px 0 0;">
                    Login
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="color:#335b48;">
                                Email Address
                            </label>
                            <input id="email" type="email"
                                   class="form-control shadow-none @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold" style="color:#335b48;">
                                Password
                            </label>

                            <input id="password" type="password"
                                   class="form-control shadow-none @error('password') is-invalid @enderror"
                                   name="password" required>

                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- REMEMBER ME --}}
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="color:#3b7d5e;">
                                Remember Me
                            </label>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <button type="submit"
                                    class="btn"
                                    style="background-color:#2d5a3a; color:white; padding:10px 20px; border-radius:10px; font-weight:500;">
                                Login
                            </button>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-decoration-none"
                                   style="color:#3b7d5e; font-weight:500;">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection