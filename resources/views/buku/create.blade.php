<x-layout title="Tambah Buku">
    <h1 class="h2 text-del mb-4">Tambah Buku</h1>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            @include('buku._form')
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-del" type="submit">Simpan Buku</button>
                <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Batal</a>
            </div>
        </form>
    </div></div>
</x-layout>
