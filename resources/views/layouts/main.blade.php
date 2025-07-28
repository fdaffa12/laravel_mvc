<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laravel MVC' }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Laravel MVC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('/') ? ' active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('karyawan*') ? ' active' : '' }}"
                            href="{{ route('karyawan.index') }}">Data Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('departemen*') ? ' active' : '' }}"
                            href="{{ route('departemen.index') }}">Data Departemen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1 container py-5">
        @yield('content')
    </main>
    <footer class="bg-white text-center py-3 mt-auto border-top text-secondary small">
        &copy; {{ date('Y') }} Laravel MVC &mdash;
        <a href="https://github.com/fdaffa12" target="_blank" class="text-decoration-none text-dark fw-semibold">
            github.com/fdaffa12
        </a> &middot;
        <a href="https://github.com/fdaffa12/laravel_mvc" target="_blank"
            class="text-decoration-none text-primary fw-semibold">
            Source Project
        </a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
