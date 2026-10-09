<x-layout title="Ubah Buku">
    <h1 class="h2 text-del mb-4">Ubah Buku</h1>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form action="{{ route('buku.update', $buku) }}" method="POST">
            @csrf
            @method('PUT')
            @include('buku._form')
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-del" type="submit">Simpan Perubahan</button>
                <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Batal</a>
            </div>
        </form>
    </div></div>
</x-layout>
