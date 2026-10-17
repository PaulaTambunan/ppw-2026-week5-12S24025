<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        $peminjamans = Peminjaman::with('buku')
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create(Request $request): View
    {
        $bukus = Buku::query()->orderBy('judul')->get();

        return view('peminjaman.create', [
            'bukus' => $bukus,
            'bukuTerpilih' => $request->integer('buku_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'buku_id' => ['required', 'integer', 'exists:bukus,id'],
            'nim_peminjam' => ['required', 'string', 'min:6', 'max:15'],
            'nama_peminjam' => ['required', 'string', 'min:3', 'max:150'],
        ]);
        $validated['nim_peminjam'] = strtoupper(trim($validated['nim_peminjam']));

        try {
            DB::transaction(function () use ($validated): void {
                $buku = Buku::where('id', $validated['buku_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($buku->stok < 1) {
                    throw new RuntimeException('Stok buku sedang habis.');
                }

                $sudahMeminjam = $buku->peminjamans()
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($sudahMeminjam) {
                    throw new RuntimeException('NIM tersebut masih meminjam buku ini.');
                }

                $buku->decrement('stok');
                $buku->peminjamans()->create([
                    'kode_pinjam' => 'PJM-'.now()->format('YmdHis').'-'.Str::upper(Str::random(4)),
                    'nim_peminjam' => $validated['nim_peminjam'],
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'tanggal_pinjam' => today(),
                    'tanggal_jatuh_tempo' => today()->addDays(14),
                    'status' => 'dipinjam',
                ]);
            });
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        } catch (QueryException $exception) {
            Log::error('[DB EXCEPTION] Gagal mencatat peminjaman.', [
                'message' => $exception->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Peminjaman gagal disimpan. Silakan coba kembali.');
        }

        $request->session()->put('last_borrower_nim', $validated['nim_peminjam']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku berhasil dipinjam.');
    }

    public function returnBook(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            DB::transaction(function () use ($peminjaman): void {
                $peminjaman = Peminjaman::where('id', $peminjaman->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($peminjaman->status !== 'dipinjam') {
                    throw new RuntimeException('Peminjaman ini sudah dikembalikan.');
                }

                $buku = Buku::where('id', $peminjaman->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => today(),
                ]);
                $buku->increment('stok');
            });
        } catch (RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        } catch (QueryException $exception) {
            Log::error('[DB EXCEPTION] Gagal mencatat pengembalian.', [
                'peminjaman_id' => $peminjaman->id,
                'message' => $exception->getMessage(),
            ]);

            return back()->with('error', 'Pengembalian gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
