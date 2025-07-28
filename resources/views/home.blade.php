@extends('layouts.main')

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height:60vh;">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">Selamat Datang di Aplikasi <span class="text-primary">Laravel MVC</span></h1>
            <p class="lead text-secondary">Kelola data karyawan dan departemen dengan mudah dan efisien.</p>
            <div class="mt-4">
                <a href="https://github.com/fdaffa12" target="_blank" class="btn btn-outline-dark btn-sm me-2">
                    <i class="bi bi-github"></i> GitHub Saya
                </a>
                <a href="https://github.com/fdaffa12/laravel_mvc" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-link-45deg"></i> Source Project
                </a>
            </div>
        </div>
        <div class="d-flex gap-4">
            <a href="{{ route('karyawan.index') }}" class="btn btn-primary btn-lg px-5 shadow">
                <i class="bi bi-people-fill me-2"></i> Data Karyawan
            </a>
            <a href="{{ route('departemen.index') }}" class="btn btn-success btn-lg px-5 shadow">
                <i class="bi bi-building me-2"></i> Data Departemen
            </a>
        </div>
    </div>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
