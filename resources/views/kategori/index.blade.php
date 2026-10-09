<x-layout title="Daftar Kategori">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2 text-del mb-1">Kategori Buku</h1>
            <p class="text-secondary mb-0">Kelola pengelompokan koleksi perpustakaan.</p>
        </div>
        <a class="btn btn-del" href="{{ route('kategori.create') }}">Tambah Kategori</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Kode</th><th>Nama Kategori</th><th>Jumlah Buku</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td>{{ $kategori->kode_kategori }}</td>
                        <td class="fw-semibold">{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->bukus_count }}</td>
                        <td class="text-end text-nowrap">
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
    <div class="mt-3">{{ $kategoris->links() }}</div>
</x-layout>
