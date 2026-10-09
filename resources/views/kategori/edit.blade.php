<x-layout title="Ubah Kategori">
    <h1 class="h2 text-del mb-4">Ubah Kategori</h1>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form action="{{ route('kategori.update', $kategori) }}" method="POST">
            @csrf
            @method('PUT')
            @include('kategori._form')
            <button class="btn btn-del" type="submit">Simpan Perubahan</button>
            <a class="btn btn-outline-secondary" href="{{ route('kategori.index') }}">Batal</a>
        </form>
    </div></div>
</x-layout>
