<div class="mb-3">
    <label class="form-label" for="kode_kategori">Kode Kategori</label>
    <input class="form-control" id="kode_kategori" name="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori ?? '') }}" maxlength="10" required>
</div>
<div class="mb-3">
    <label class="form-label" for="nama_kategori">Nama Kategori</label>
    <input class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" maxlength="100" required>
</div>
