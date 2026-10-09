@props(['title' => 'SIPUS-Del'])
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | SIPUS-Del</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --del-purple: #4C1D95; --del-purple-dark: #3B0764; }
        body { background: #f7f5fb; }
        .navbar-del { background: var(--del-purple); }
        .btn-del { background: var(--del-purple); border-color: var(--del-purple); color: #fff; }
        .btn-del:hover, .btn-del:focus { background: var(--del-purple-dark); border-color: var(--del-purple-dark); color: #fff; }
        .text-del { color: var(--del-purple); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-del shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('buku.index') }}">SIPUS-Del</a>
            <div class="navbar-nav flex-row gap-3">
                <a class="nav-link" href="{{ route('buku.index') }}">Buku</a>
                <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="fw-semibold mb-1">Periksa kembali isian berikut:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
