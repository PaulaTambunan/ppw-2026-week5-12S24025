<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SirkulasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_search_catalog_and_see_library_statistics(): void
    {
        $kategori = Kategori::factory()->create();
        $buku = Buku::factory()->create([
            'kategori_id' => $kategori->id,
            'isbn' => '9786021234567',
            'judul' => 'Belajar Laravel Dasar',
            'stok' => 2,
        ]);
        Peminjaman::factory()->create([
            'buku_id' => $buku->id,
            'status' => 'dikembalikan',
            'tanggal_kembali' => today(),
        ]);
        $kategoriLain = Kategori::factory()->create();
        Buku::factory()->create([
            'kategori_id' => $kategoriLain->id,
            'judul' => 'Laravel untuk Sistem Informasi',
            'stok' => 4,
        ]);

        $response = $this->get(route('buku.index', ['search' => 'Laravel', 'kategori_id' => $kategori->id]))
            ->assertOk()
            ->assertSee('Belajar Laravel Dasar')
            ->assertDontSee('Laravel untuk Sistem Informasi')
            ->assertSee('Total stok tersedia')
            ->assertSee('Sudah dikembalikan')
            ->assertSessionHas('last_buku_search', 'Laravel');

        $response->assertViewHas('stats', [
            'total_judul' => 2,
            'total_stok' => 6,
            'sedang_dipinjam' => 0,
            'sudah_dikembalikan' => 1,
        ]);
        $response->assertViewHas(
            'bukus',
            fn ($bukus) => $bukus->count() === 1 && $bukus->first()->peminjamans_count === 1,
        );
    }

    public function test_catalog_pagination_keeps_search_query(): void
    {
        $kategori = Kategori::factory()->create();

        foreach (range(1, 11) as $number) {
            Buku::factory()->create([
                'kategori_id' => $kategori->id,
                'judul' => "Laravel Buku {$number}",
            ]);
        }

        $this->get(route('buku.index', ['search' => 'Laravel']))
            ->assertOk()
            ->assertSee('search=Laravel');
    }

    public function test_guest_cannot_create_a_book(): void
    {
        $kategori = Kategori::factory()->create();

        $this->post(route('buku.store'), [
            'isbn' => '9786021234567',
            'judul' => 'Buku Contoh Laravel',
            'penulis' => 'Ayu Lestari',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2025,
            'kategori_id' => $kategori->id,
            'stok' => 1,
        ])->assertRedirect(route('login'));

        $this->assertDatabaseMissing('bukus', ['isbn' => '9786021234567']);
    }

    public function test_librarian_can_login_and_logout_with_session_and_cookie(): void
    {
        User::factory()->create([
            'email' => 'pustakawan@del.ac.id',
            'password' => 'password123',
        ]);

        $response = $this->withSession(['before_login' => 'retained'])
            ->post(route('login.store'), [
                'email' => 'pustakawan@del.ac.id',
                'password' => 'password123',
            ])
            ->assertRedirect(route('buku.index'))
            ->assertSessionHas('before_login', 'retained')
            ->assertSessionHas('login_timestamp')
            ->assertCookie('sipus_last_user_email', 'pustakawan@del.ac.id');

        $lastEmailCookie = collect($response->headers->getCookies())
            ->first(fn ($cookie) => $cookie->getName() === 'sipus_last_user_email');
        $this->assertNotNull($lastEmailCookie);
        $this->assertTrue($lastEmailCookie->isHttpOnly());
        $this->assertSame('lax', $lastEmailCookie->getSameSite());

        $this->assertAuthenticated();

        $this->post(route('logout'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertGuest();
    }

    public function test_librarian_can_borrow_and_return_a_book(): void
    {
        $this->actingAs(User::factory()->create());
        $kategori = Kategori::factory()->create();
        $buku = Buku::factory()->create([
            'kategori_id' => $kategori->id,
            'stok' => 1,
        ]);

        $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12s24025',
            'nama_peminjam' => 'Paula Tambunan',
        ])->assertRedirect(route('peminjaman.index'))
            ->assertSessionHas('last_borrower_nim', '12S24025');

        $peminjaman = Peminjaman::firstOrFail();
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'stok' => 0]);
        $this->assertDatabaseHas('peminjamans', [
            'id' => $peminjaman->id,
            'nim_peminjam' => '12S24025',
            'status' => 'dipinjam',
        ]);

        $this->post(route('peminjaman.return', $peminjaman))
            ->assertRedirect(route('peminjaman.index'));

        $peminjaman = Peminjaman::findOrFail($peminjaman->id);
        $this->assertSame('dikembalikan', $peminjaman->status);
        $this->assertSame(today()->toDateString(), $peminjaman->tanggal_kembali->toDateString());
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'stok' => 1]);

        $this->from(route('peminjaman.index'))
            ->post(route('peminjaman.return', $peminjaman))
            ->assertRedirect(route('peminjaman.index'))
            ->assertSessionHas('error', 'Peminjaman ini sudah dikembalikan.');
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'stok' => 1]);

        $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24025',
            'nama_peminjam' => 'Paula Tambunan',
        ])->assertRedirect(route('peminjaman.index'));

        $this->assertDatabaseCount('peminjamans', 2);
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'stok' => 0]);
    }

    public function test_empty_stock_and_duplicate_active_loan_are_rejected(): void
    {
        $this->actingAs(User::factory()->create());
        $kategori = Kategori::factory()->create();
        $bukuHabis = Buku::factory()->create([
            'kategori_id' => $kategori->id,
            'stok' => 0,
        ]);

        $this->from(route('peminjaman.create'))
            ->post(route('peminjaman.store'), [
                'buku_id' => $bukuHabis->id,
                'nim_peminjam' => '12S24025',
                'nama_peminjam' => 'Paula Tambunan',
            ])
            ->assertRedirect(route('peminjaman.create'))
            ->assertSessionHas('error', 'Stok buku sedang habis.');

        $this->assertDatabaseMissing('peminjamans', ['buku_id' => $bukuHabis->id]);
        $this->assertDatabaseHas('bukus', ['id' => $bukuHabis->id, 'stok' => 0]);

        $buku = Buku::factory()->create([
            'kategori_id' => $kategori->id,
            'stok' => 1,
        ]);
        Peminjaman::factory()->create([
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24025',
            'status' => 'dipinjam',
        ]);

        $this->from(route('peminjaman.create'))
            ->post(route('peminjaman.store'), [
                'buku_id' => $buku->id,
                'nim_peminjam' => '12s24025',
                'nama_peminjam' => 'Paula Tambunan',
            ])
            ->assertRedirect(route('peminjaman.create'))
            ->assertSessionHas('error', 'NIM tersebut masih meminjam buku ini.');

        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'stok' => 1]);
        $this->assertDatabaseCount('peminjamans', 1);
    }

    public function test_seeder_creates_librarian_and_sample_circulation_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'pustakawan@del.ac.id']);
        $this->assertDatabaseHas('bukus', ['isbn' => '9786020000101', 'stok' => 0]);
        $this->assertDatabaseHas('bukus', ['isbn' => '9786020000102', 'stok' => 1]);
        $this->assertDatabaseHas('peminjamans', ['kode_pinjam' => 'PJM-SEED-001', 'status' => 'dipinjam']);

        $this->post(route('login.store'), [
            'email' => 'pustakawan@del.ac.id',
            'password' => 'password123',
        ])->assertRedirect(route('buku.index'));
        $this->assertAuthenticated();
    }
}
