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
                                Alamat Email
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

                            <div class="input-group">
                                <input id="password" type="password"
                                       class="form-control shadow-none @error('password') is-invalid @enderror"
                                       name="password" required>
                                
                            </div>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- REMEMBER ME --}}
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="color:#3b7d5e;">
                                Ingat Saya
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
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                    </form>

                    {{-- REGISTRATION LINK --}}
                    <div class="text-center mt-4 pt-3" style="border-top: 1px solid #dee2e6;">
                        <p class="mb-0" style="color:#3b7d5e;">
                            Tidak punya akun?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#2d5a3a;">
                                Registrasi di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');
        
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            
        });
    });
</script>
@endsection