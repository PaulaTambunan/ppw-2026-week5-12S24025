@props(['title' => 'SIPUS-Del'])
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | SIPUS-Del</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --del-purple: #4c1d95;
            --del-purple-dark: #35116d;
            --del-blue: #2563eb;
            --del-indigo: #4338ca;
            --del-lilac: #f1efff;
            --del-blue-light: #eef4ff;
            --del-ink: #231b32;
            --del-muted: #777184;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(ellipse at 92% 0, rgba(191, 219, 254, .42), transparent 25rem),
                radial-gradient(ellipse at 5% 36%, rgba(221, 214, 254, .34), transparent 24rem),
                #f8f7fb;
            color: var(--del-ink);
        }

        .navbar-del {
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(16px);
        }

        .navbar-del .container { min-height: 74px; }
        .brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 14px;
            background: linear-gradient(145deg, #6030ad 5%, #4338ca 58%, #2563eb 100%);
            color: white;
            box-shadow: 0 7px 18px rgba(76, 29, 149, .22);
        }

        .brand-name { color: var(--del-ink); letter-spacing: -.04em; }
        .brand-caption { color: var(--del-muted); font-size: .68rem; letter-spacing: .08em; }
        .navbar-del .nav-link {
            padding: .6rem .9rem;
            border-radius: 999px;
            color: #696276;
            font-size: .94rem;
            font-weight: 600;
            transition: background-color .18s ease, color .18s ease;
        }

        .navbar-del .nav-link:hover,
        .navbar-del .nav-link.active {
            background: linear-gradient(110deg, var(--del-lilac), var(--del-blue-light));
            color: var(--del-indigo);
        }

        .btn-del {
            padding: .7rem 1.05rem;
            border: 1px solid var(--del-purple);
            border-radius: 12px;
            background: linear-gradient(115deg, var(--del-purple), #4338ca 58%, var(--del-blue));
            color: #fff;
            font-weight: 600;
            box-shadow: 0 7px 16px rgba(76, 29, 149, .16);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .btn-del:hover, .btn-del:focus {
            transform: translateY(-1px);
            background: linear-gradient(115deg, var(--del-purple-dark), #3730a3 58%, #1d4ed8);
            border-color: #3730a3;
            color: #fff;
            box-shadow: 0 10px 20px rgba(76, 29, 149, .23);
        }

        .text-del { color: var(--del-purple); }
        main.container { max-width: 1180px; }
        .page-heading { margin: 1rem 0 1.4rem; }
        .page-eyebrow {
            color: #7653b0;
            font-size: .72rem;
            font-weight: 750;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .catalog-hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: clamp(1.6rem, 4vw, 3.1rem);
            border-radius: 26px;
            background: linear-gradient(115deg, #312e81 0%, #4c1d95 43%, #4338ca 72%, #2563eb 100%);
            color: #fff;
            box-shadow: 0 20px 48px rgba(53, 17, 109, .2);
        }

        .catalog-hero::before,
        .catalog-hero::after {
            position: absolute;
            z-index: -1;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 50%;
            content: "";
        }

        .catalog-hero::before { top: -160px; right: -45px; width: 390px; height: 390px; }
        .catalog-hero::after { top: -105px; right: 10px; width: 280px; height: 280px; }
        .catalog-hero h1 { max-width: 600px; font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 750; letter-spacing: -.05em; }
        .hero-copy { max-width: 560px; color: rgba(255, 255, 255, .76); }
        .hero-label {
            display: inline-flex;
            padding: .4rem .75rem;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            color: #eee7ff;
            font-size: .72rem;
            font-weight: 650;
            letter-spacing: .09em;
        }

        .hero-stat {
            min-width: 145px;
            padding: 1rem 1.15rem;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 17px;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(8px);
        }

        .hero-stat strong { display: block; font-size: 1.6rem; letter-spacing: -.04em; }
        .hero-stat span { color: rgba(255, 255, 255, .72); font-size: .82rem; }
        .section-heading { color: var(--del-ink); font-size: 1.1rem; font-weight: 700; }
        .section-caption { color: var(--del-muted); font-size: .9rem; }
        .catalog-card, .form-card {
            overflow: hidden;
            border: 1px solid #eeebf4 !important;
            border-radius: 19px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 8px 28px rgba(36, 24, 58, .055) !important;
        }

        .catalog-table { min-width: 760px; }
        .catalog-table thead th {
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #efedf3;
            background: #fbfaff;
            color: #827b90;
            font-size: .71rem;
            font-weight: 750;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .catalog-table tbody td { padding: 1rem 1.15rem; border-color: #f0eef4; }
        .catalog-table tbody tr:last-child td { border-bottom: 0; }
        .catalog-table tbody tr:hover { background: #fcfbff; }
        .book-title { color: #30233f; font-weight: 650; }
        .isbn-label { color: var(--del-muted); font-size: .84rem; }
        .category-chip {
            display: inline-flex;
            padding: .34rem .68rem;
            border-radius: 999px;
            background: var(--del-lilac);
            color: var(--del-purple);
            font-size: .79rem;
            font-weight: 650;
        }

        .stock-chip {
            display: inline-flex;
            min-width: 40px;
            justify-content: center;
            padding: .28rem .55rem;
            border-radius: 9px;
            background: #f2f0f5;
            color: #50475f;
            font-size: .83rem;
            font-weight: 700;
        }

        .stock-chip.stock-low { background: #fff1e9; color: #a64b17; }
        .action-link { color: var(--del-purple); font-size: .86rem; font-weight: 650; text-decoration: none; }
        .action-link:hover { color: var(--del-purple-dark); text-decoration: underline; }
        .action-buttons .btn { border-radius: 9px; font-weight: 550; }
        .pagination { gap: .35rem; }
        .pagination .page-link {
            display: inline-flex;
            min-width: 38px;
            min-height: 38px;
            align-items: center;
            justify-content: center;
            border: 1px solid #e9e5f0;
            border-radius: 10px !important;
            background: #fff;
            color: #625a70;
            font-size: .9rem;
            box-shadow: none;
        }

        .pagination .page-item.active .page-link {
            border-color: #4338ca;
            background: linear-gradient(120deg, var(--del-purple), #4338ca 65%, var(--del-blue));
            color: #fff;
        }

        .pagination .page-item.disabled .page-link { color: #b6b0c0; }
        .pagination svg { width: 16px; height: 16px; }
        .form-card .card-body { padding: clamp(1.25rem, 3vw, 2rem); }
        .form-label { color: #4b4358; font-size: .9rem; font-weight: 650; }
        .form-control, .form-select { min-height: 44px; border-color: #e6e1ed; border-radius: 11px; }
        textarea.form-control { min-height: auto; }
        .form-control:focus, .form-select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 .2rem rgba(67, 56, 202, .12);
        }

        footer { color: #8b8596; font-size: .82rem; }

        @media (max-width: 575.98px) {
            .navbar-del .container { min-height: 66px; }
            .brand-caption { display: none; }
            .navbar-del .nav-link { padding: .5rem .65rem; font-size: .86rem; }
            .catalog-hero { border-radius: 20px; }
            .hero-stat { min-width: 0; flex: 1; padding: .8rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-del shadow-sm sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 me-4" href="{{ route('buku.index') }}">
                <span class="brand-mark" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4.75 5.5A2.75 2.75 0 0 1 7.5 2.75h9A2.75 2.75 0 0 1 19.25 5.5v13a2.75 2.75 0 0 0-2.75-2.75h-9a2.75 2.75 0 0 0-2.75 2.75v-13Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M4.75 18.5A2.75 2.75 0 0 1 7.5 15.75h9a2.75 2.75 0 0 1 2.75 2.75A2.75 2.75 0 0 1 16.5 21.25h-9a2.75 2.75 0 0 1-2.75-2.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M8.5 7.5h7M8.5 10.5h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                </span>
                <span class="d-flex flex-column lh-sm">
                    <span class="brand-name fw-bold">SIPUS-Del</span>
                    <span class="brand-caption">PERPUSTAKAAN KAMPUS</span>
                </span>
            </a>
            <div class="navbar-nav flex-row gap-1">
                <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">Koleksi Buku</a>
                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
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
    <footer class="container pb-4 text-center">SIPUS-Del <span aria-hidden="true">·</span> Perpustakaan Institut Teknologi Del</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
