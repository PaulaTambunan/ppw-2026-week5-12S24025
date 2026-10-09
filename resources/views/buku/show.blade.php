<x-layout title="Detail Buku">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-del mb-0">Detail Buku</h1>
        <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h2 class="h3">{{ $buku->judul }}</h2>
        <dl class="row mt-4 mb-0">
            <dt class="col-sm-3">ISBN</dt><dd class="col-sm-9">{{ $buku->isbn }}</dd>
            <dt class="col-sm-3">Penulis</dt><dd class="col-sm-9">{{ $buku->penulis }}</dd>
            <dt class="col-sm-3">Penerbit</dt><dd class="col-sm-9">{{ $buku->penerbit }}</dd>
            <dt class="col-sm-3">Tahun Terbit</dt><dd class="col-sm-9">{{ $buku->tahun_terbit }}</dd>
            <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $buku->kategori->nama_kategori }}</dd>
            <dt class="col-sm-3">Stok</dt><dd class="col-sm-9">{{ $buku->stok }}</dd>
            <dt class="col-sm-3">Sinopsis</dt><dd class="col-sm-9">{{ $buku->sinopsis ?: 'Tidak ada sinopsis.' }}</dd>
        </dl>
    </div></div>
</x-layout>
