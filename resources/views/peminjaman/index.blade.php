<x-layout title="Daftar Peminjaman">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 page-heading">
        <div>
            <span class="page-eyebrow">Sirkulasi buku</span>
            <h1 class="h2 text-del mb-1">Daftar Peminjaman</h1>
            <p class="section-caption mb-0">Catat peminjaman dan pengembalian koleksi.</p>
        </div>
        <a class="btn btn-del" href="{{ route('peminjaman.create') }}">+ Peminjaman Baru</a>
    </div>

    <div class="card catalog-card"><div class="table-responsive">
        <table class="table table-hover align-middle catalog-table mb-0">
            <thead><tr><th>Kode</th><th>Buku</th><th>NIM</th><th>Nama Peminjam</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th><th>Tanggal Kembali</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->kode_pinjam }}</td>
                        <td>{{ $peminjaman->buku->judul }}</td>
                        <td>{{ $peminjaman->nim_peminjam }}</td>
                        <td>{{ $peminjaman->nama_peminjam }}</td>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
                        <td>{{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}</td>
                        <td>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                        <td><span class="badge {{ $peminjaman->status === 'dipinjam' ? 'text-bg-primary' : 'text-bg-success' }}">{{ ucfirst($peminjaman->status) }}</span></td>
                        <td class="text-end">
                            @if ($peminjaman->status === 'dipinjam')
                                <form action="{{ route('peminjaman.return', $peminjaman) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" type="submit">Kembalikan</button>
                                </form>
                            @else
                                <span class="text-secondary">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-secondary py-5">Belum ada transaksi peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="d-flex justify-content-end mt-4">{{ $peminjamans->links() }}</div>
</x-layout>
