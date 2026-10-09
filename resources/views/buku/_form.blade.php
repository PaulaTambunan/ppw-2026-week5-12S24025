<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="isbn">ISBN</label>
        <input class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn ?? '') }}" maxlength="20" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="judul">Judul</label>
        <input class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul ?? '') }}" minlength="5" maxlength="200" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="penulis">Penulis</label>
        <input class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis ?? '') }}" maxlength="150" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="penerbit">Penerbit</label>
        <input class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit ?? '') }}" maxlength="150" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
        <input class="form-control" id="tahun_terbit" name="tahun_terbit" type="number" min="1000" max="{{ (int) date('Y') + 1 }}" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? date('Y')) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="kategori_id">Kategori</label>
        <select class="form-select" id="kategori_id" name="kategori_id" required>
            <option value="">Pilih kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" @selected(old('kategori_id', $buku->kategori_id ?? '') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="stok">Stok</label>
        <input class="form-control" id="stok" name="stok" type="number" min="0" value="{{ old('stok', $buku->stok ?? 0) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label" for="sinopsis">Sinopsis <span class="text-secondary">(opsional)</span></label>
        <textarea class="form-control" id="sinopsis" name="sinopsis" rows="4" maxlength="5000">{{ old('sinopsis', $buku->sinopsis ?? '') }}</textarea>
    </div>
</div>
