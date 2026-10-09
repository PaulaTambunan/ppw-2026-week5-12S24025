<x-layout title="Detail Kategori">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-del mb-1">{{ $kategori->nama_kategori }}</h1>
            <p class="text-secondary mb-0">Kode kategori: {{ $kategori->kode_kategori }}</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('kategori.index') }}">Kembali</a>
    </div>
    <h2 class="h4 mb-3">Buku dalam kategori ini</h2>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>ISBN</th><th>Judul</th><th>Penulis</th><th>Stok</th></tr></thead>
            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td>{{ $buku->isbn }}</td>
                        <td><a href="{{ route('buku.show', $buku) }}">{{ $buku->judul }}</a></td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->stok }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary py-5">Belum ada buku pada kategori ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="mt-3">{{ $bukus->links() }}</div>
</x-layout>
