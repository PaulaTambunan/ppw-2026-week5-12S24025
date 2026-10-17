<x-layout title="Login Pustakawan">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="page-heading">
                <span class="page-eyebrow">Akses pustakawan</span>
                <h1 class="h2 text-del mb-1">Masuk ke SIPUS-Del</h1>
                <p class="section-caption mb-0">Login untuk mengelola koleksi dan transaksi peminjaman.</p>
            </div>
            <div class="card form-card"><div class="card-body p-4">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{ old('email', request()->cookie('sipus_last_user_email')) }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Kata sandi</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button class="btn btn-del w-100" type="submit">Masuk</button>
                </form>
            </div></div>
        </div>
    </div>
</x-layout>
