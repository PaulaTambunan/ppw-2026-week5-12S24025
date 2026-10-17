<x-layout title="Peminjaman Buku">
    <h1 class="h2 text-del mb-4">Catat Peminjaman Buku</h1>
    <div class="card form-card"><div class="card-body p-4">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="buku_id">Buku</label>
                <select class="form-select" id="buku_id" name="buku_id" required>
                    <option value="">Pilih buku</option>
                    @foreach ($bukus as $buku)
                        <option value="{{ $buku->id }}" @selected(old('buku_id', $bukuTerpilih) == $buku->id)>{{ $buku->judul }} (stok: {{ $buku->stok }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="nim_peminjam">NIM Peminjam</label>
                <input class="form-control" id="nim_peminjam" name="nim_peminjam" value="{{ old('nim_peminjam', session('last_borrower_nim')) }}" minlength="6" maxlength="15" required>
            </div>
            <div class="mb-4">
                <label class="form-label" for="nama_peminjam">Nama Peminjam</label>
                <input class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" minlength="3" maxlength="150" required>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-del" type="submit">Simpan Peminjaman</button>
                <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Batal</a>
            </div>
        </form>
    </div></div>
</x-layout>
