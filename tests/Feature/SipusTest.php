<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SipusTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_the_book_catalog(): void
    {
        $this->get('/')
            ->assertRedirect(route('buku.index'));

        $this->get(route('buku.index'))
            ->assertOk()
            ->assertSee('Koleksi Buku');
    }

    public function test_book_can_be_created_updated_and_deleted(): void
    {
        $kategori = Kategori::factory()->create();
        $data = [
            'isbn' => '9781234567890',
            'judul' => 'Pemrograman Web Modern',
            'penulis' => 'Ayu Lestari',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2025,
            'kategori_id' => $kategori->id,
            'stok' => 8,
            'sinopsis' => 'Pengantar pengembangan aplikasi web.',
        ];

        $this->post(route('buku.store'), $data)
            ->assertRedirect(route('buku.index'))
            ->assertSessionHas('success');
        $buku = Buku::where('isbn', $data['isbn'])->firstOrFail();
        $this->assertSame($kategori->id, $buku->kategori->id);

        $this->get(route('buku.show', $buku))
            ->assertOk()
            ->assertSee('Pemrograman Web Modern');
        $this->put(route('buku.update', $buku), [...$data, 'judul' => 'Pemrograman Laravel Modern'])
            ->assertRedirect(route('buku.index'));
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'judul' => 'Pemrograman Laravel Modern']);

        $this->delete(route('buku.destroy', $buku))
            ->assertRedirect(route('buku.index'));
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_book_validation_rejects_duplicate_isbn_short_title_and_negative_stock(): void
    {
        $kategori = Kategori::factory()->create();
        Buku::factory()->create(['isbn' => '9781234567890', 'kategori_id' => $kategori->id]);

        $this->from(route('buku.create'))
            ->post(route('buku.store'), [
                'isbn' => '9781234567890',
                'judul' => 'Web',
                'penulis' => 'Ayu Lestari',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2025,
                'kategori_id' => $kategori->id,
                'stok' => -1,
            ])
            ->assertRedirect(route('buku.create'))
            ->assertSessionHasErrors(['isbn', 'judul', 'stok']);
    }

    public function test_category_can_be_managed_and_cannot_be_deleted_while_it_has_books(): void
    {
        $this->post(route('kategori.store'), [
            'kode_kategori' => 'FIK-001',
            'nama_kategori' => 'Fiksi',
        ])->assertRedirect(route('kategori.index'));

        $kategori = Kategori::where('kode_kategori', 'FIK-001')->firstOrFail();
        $this->put(route('kategori.update', $kategori), [
            'kode_kategori' => 'FIK-001',
            'nama_kategori' => 'Fiksi dan Sastra',
        ])->assertRedirect(route('kategori.index'));

        $buku = Buku::factory()->create(['kategori_id' => $kategori->id]);
        $this->delete(route('kategori.destroy', $kategori))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseHas('bukus', ['id' => $buku->id]);

        $buku->delete();
        $this->delete(route('kategori.destroy', $kategori))
            ->assertRedirect(route('kategori.index'));
        $this->assertDatabaseMissing('kategoris', ['id' => $kategori->id]);
    }

    public function test_seeders_create_at_least_five_categories_and_twenty_books(): void
    {
        $this->seed();

        $this->assertSame(5, Kategori::count());
        $this->assertSame(20, Buku::count());
        $this->assertSame(20, Buku::whereHas('kategori')->count());
        $this->assertDatabaseHas('bukus', [
            'isbn' => '9786020000001',
            'judul' => 'Pemrograman Web dengan Laravel',
        ]);
    }

    public function test_book_index_uses_bootstrap_pagination_markup(): void
    {
        Buku::factory()->count(11)->create();

        $this->get(route('buku.index'))
            ->assertOk()
            ->assertSee('page-item')
            ->assertSee('page-link')
            ->assertDontSee('relative inline-flex');
    }

    public function test_eager_loading_categories_uses_two_select_queries(): void
    {
        $kategori = Kategori::factory()->create();
        Buku::factory()->count(3)->create(['kategori_id' => $kategori->id]);
        $queries = [];

        DB::listen(function (QueryExecuted $query) use (&$queries): void {
            if (str_starts_with(strtolower(ltrim($query->sql)), 'select')) {
                $queries[] = $query->sql;
            }
        });

        $bukus = Buku::with('kategori')->get();

        $this->assertCount(3, $bukus);
        $this->assertCount(2, $queries);
    }
}
