<x-layout title="Daftar Buku">
    <section class="catalog-hero mb-4">
        <div class="row align-items-end g-4">
            <div class="col-lg">
                <span class="hero-label mb-3">PERPUSTAKAAN KAMPUS DEL</span>
                <h1 class="mb-3">Temukan cerita dan pengetahuan baru.</h1>
                <p class="hero-copy mb-4">Jelajahi koleksi buku pilihan dan temukan bacaan yang tepat untuk perjalanan belajarmu.</p>
                @auth
                    <a class="btn btn-light fw-semibold rounded-3 px-3 py-2" href="{{ route('buku.create') }}">+ Tambah koleksi</a>
                @endauth
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="section-caption">Total stok tersedia</div><strong class="h3">{{ $stats['total_stok'] }}</strong></div></div></div>
        <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="section-caption">Sedang dipinjam</div><strong class="h3">{{ $stats['sedang_dipinjam'] }}</strong></div></div></div>
        <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="section-caption">Sudah dikembalikan</div><strong class="h3">{{ $stats['sudah_dikembalikan'] }}</strong></div></div></div>
        <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="section-caption">Judul buku</div><strong class="h3">{{ $stats['total_judul'] }}</strong></div></div></div>
    </div>

    <form class="card catalog-card card-body mb-4" method="GET" action="{{ route('buku.index') }}">
        <div class="row g-2 align-items-end">
            <div class="col-md">
                <label class="form-label" for="search">Cari judul, penulis, atau ISBN</label>
                <input class="form-control" id="search" name="search" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="kategori_id">Kategori</label>
                <select class="form-select" id="kategori_id" name="kategori_id">
                    <option value="">Semua kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-del" type="submit">Cari</button>
                <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Reset</a>
            </div>
        </div>
    </form>

    <div class="page-heading d-flex flex-wrap justify-content-between align-items-end gap-2">
        <div>
            <h2 class="section-heading mb-1">Semua koleksi</h2>
            <p class="section-caption mb-0">Buku pilihan untuk mendukung kegiatan belajar dan riset.</p>
        </div>
        <span class="section-caption">Menampilkan {{ $bukus->firstItem() ?? 0 }}–{{ $bukus->lastItem() ?? 0 }} dari {{ $bukus->total() }} buku</span>
    </div>

    <div class="card catalog-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle catalog-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Peminjaman</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bukus as $buku)
                        <tr>
                            <td>
                                <a class="action-link book-title d-block mb-1" href="{{ route('buku.show', $buku) }}">{{ $buku->judul }}</a>
                                <span class="isbn-label">ISBN {{ $buku->isbn }}</span>
                            </td>
                            <td>{{ $buku->penulis }}</td>
                            <td><span class="category-chip">{{ $buku->kategori->nama_kategori }}</span></td>
                            <td><span class="stock-chip {{ $buku->stok < 5 ? 'stock-low' : '' }}">{{ $buku->stok }}</span></td>
                            <td>{{ $buku->peminjamans_count }}</td>
                            <td class="text-end text-nowrap action-buttons">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('buku.show', $buku) }}">Detail</a>
                                @auth
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('buku.edit', $buku) }}">Edit</a>
                                    <form class="d-inline" action="{{ route('buku.destroy', $buku) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                    </form>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-5">Belum ada buku dalam koleksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">
        <span class="section-caption">Halaman {{ $bukus->currentPage() }} dari {{ $bukus->lastPage() }}</span>
        {{ $bukus->links() }}
    </div>
</x-layout>
