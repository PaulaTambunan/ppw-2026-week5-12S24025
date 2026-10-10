<x-layout title="Daftar Kategori">
    <section class="catalog-hero mb-4">
        <div class="row align-items-end g-4">
            <div class="col-lg">
                <span class="hero-label mb-3">KOLEKSI TERTATA</span>
                <h1 class="mb-3">Setiap bacaan punya tempatnya.</h1>
                <p class="hero-copy mb-0">Jelajahi kategori dan temukan buku berdasarkan bidang yang kamu minati.</p>
            </div>
            <div class="col-lg-auto">
                <a class="btn btn-light fw-semibold rounded-3 px-3 py-2" href="{{ route('kategori.create') }}">+ Tambah kategori</a>
            </div>
        </div>
    </section>

    <div class="page-heading">
        <h2 class="section-heading mb-1">Kategori buku</h2>
        <p class="section-caption mb-0">Kelola pengelompokan koleksi perpustakaan.</p>
    </div>
    <div class="card catalog-card"><div class="table-responsive">
        <table class="table table-hover align-middle catalog-table mb-0">
            <thead class="table-light"><tr><th>Kode</th><th>Nama Kategori</th><th>Jumlah Buku</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td>{{ $kategori->kode_kategori }}</td>
                        <td class="fw-semibold">{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->bukus_count }}</td>
                        <td class="text-end text-nowrap action-buttons">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('kategori.show', $kategori) }}">Detail</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('kategori.edit', $kategori) }}">Ubah</a>
                            <form class="d-inline" action="{{ route('kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit" @disabled($kategori->bukus_count > 0)>Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary py-5">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">
        <span class="section-caption">Menampilkan {{ $kategoris->firstItem() ?? 0 }}–{{ $kategoris->lastItem() ?? 0 }} dari {{ $kategoris->total() }} kategori</span>
        {{ $kategoris->links() }}
    </div>
</x-layout>
