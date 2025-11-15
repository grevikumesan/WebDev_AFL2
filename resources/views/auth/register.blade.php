@extends('layouts.main')

{{-- Perubahan di sini: Menggunakan section('main_content') jika itu yang digunakan di layouts.main Anda --}}
@section('main_content') 
{{-- JIKA layout Anda menggunakan @yield('content'), ganti baris di atas menjadi @section('content') --}}

<div class="row justify-content-center pt-5 pb-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0" style="border-radius: 18px; background-color: #ffffff;">
            
            {{-- Card Header --}}
            <div class="card-header text-center fw-bold fs-4" 
                 style="background-color: #eafaf1; color: #2d5a3a; border-top-left-radius: 18px; border-top-right-radius: 18px; border-bottom: 1px solid #bcead5;">
                {{ __('Daftar Akun Baru') }}
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Nama Lengkap') }}
                        </label>

                        <div class="col-md-6">
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   required autocomplete="name" autofocus
                                   style="border-radius: 8px; border-color: #bcead5;">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Alamat Email') }}
                        </label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   required autocomplete="email"
                                   style="border-radius: 8px; border-color: #bcead5;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Kata Sandi') }}
                        </label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password"
                                   style="border-radius: 8px; border-color: #bcead5;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="row mb-4">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Konfirmasi Sandi') }}
                        </label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation" required autocomplete="new-password"
                                   style="border-radius: 8px; border-color: #bcead5;">
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold"
                                    style="background-color:#2d5a3a; border:none; border-radius:10px; transition: background-color 0.3s;">
                                {{ __('Daftar') }}
                            </button>
                        </div>
                    </div>

                    {{-- Link ke Login --}}
                    <div class="row mt-4">
                        <div class="col-md-8 offset-md-2 text-center">
                            <p class="mb-0" style="color: #3e6454;">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #3b7d5e;">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection