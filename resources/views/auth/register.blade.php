@extends('layouts.main')

@section('title', 'Register')

@section('main_content')
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

                    {{-- Error Alert Global --}}
                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4" style="border: 1px solid #f5c6cb;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Mohon perbaiki kesalahan berikut:</strong>
                        </div>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Name --}}
                    <div class="row mb-4">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Nama Lengkap') }}
                        </label>
                        <div class="col-md-8">
                            <input id="name" type="text" 
                                   class="form-control shadow-none @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   required autocomplete="off"
                                   style="border-radius: 10px; border: 1px solid #bcead5; padding: 10px 15px;">
                            @error('name')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-4">
                        <label for="email" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Alamat Email') }}
                        </label>
                        <div class="col-md-8">
                            <input id="email" type="email"
                                   class="form-control shadow-none @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   required autocomplete="off"
                                   style="border-radius: 10px; border: 1px solid #bcead5; padding: 10px 15px;">
                            @error('email')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="row mb-4">
                        <label for="password" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Kata Sandi') }}
                        </label>
                        <div class="col-md-8">
                            <input id="password" type="password"
                                   class="form-control shadow-none @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="off"
                                   style="border-radius: 10px; border: 1px solid #bcead5; padding: 10px 15px;">
                            @error('password')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="row mb-4">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end fw-semibold" style="color: #335b48;">
                            {{ __('Konfirmasi Sandi') }}
                        </label>
                        <div class="col-md-8">
                            <input id="password-confirm" type="password"
                                   class="form-control shadow-none"
                                   name="password_confirmation" required autocomplete="off"
                                   style="border-radius: 10px; border: 1px solid #bcead5; padding: 10px 15px;">
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn w-100 fw-bold py-2"
                                    style="background-color:#2d5a3a; color:white; border:none; border-radius:12px; font-size:1.1rem; transition: background-color 0.3s;">
                                {{ __('Daftar') }}
                            </button>
                        </div>
                    </div>

                    {{-- Link ke Login --}}
                    <div class="row mt-4">
                        <div class="col-12 text-center">
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

<style>
    .form-control:focus {
        border-color: #2d5a3a !important;
        box-shadow: 0 0 0 0.2rem rgba(45, 90, 58, 0.25) !important;
    }
    
    .invalid-feedback {
        background-color: #f8d7da;
        color: #721c24;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #f5c6cb;
        font-size: 0.9rem;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 12px;
    }
    
    .btn:hover {
        background-color: #23523a !important;
        transform: translateY(-1px);
    }
</style>

<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection