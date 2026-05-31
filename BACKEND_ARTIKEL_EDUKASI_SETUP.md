# 📚 Backend Setup - Manajemen Artikel Edukasi (PBI-010)

## ✅ Status: FONDASI BACKEND BERHASIL DIPASANG

Tahap 1 ini fokus pada **AC-1 (Akses Menu)** dan persiapan fondasi data untuk **AC-2 (Tambah Artikel)**.

---

## 🗂️ File yang Telah Dibuat

### 1. **Migration** ✅
📁 `database/migrations/2026_05_31_002204_create_articles_table.php`

**Struktur Tabel `articles`:**
```
- id (BigIncrements)
- title (String)
- slug (String, unique) → SEO-friendly URL
- category (String) → Kategori artikel
- content (Text) → Isi konten edukasi
- image (String, nullable) → Path foto thumbnail
- status (Enum: 'published', 'draft') → Default: 'published'
- timestamps (created_at, updated_at)
```

**Status:** ✅ Migration sudah dijalankan, tabel `articles` sudah dibuat di database.

---

### 2. **Model** ✅
📁 `app/Models/Article.php`

**Fitur:**
- ✅ Mass assignment dengan `$fillable` untuk semua kolom
- ✅ Auto-generate slug dari title menggunakan `boot()` event
- ✅ Slug otomatis unik dengan suffix angka jika duplikat
- ✅ Support untuk create dan update dengan slug otomatis

**Cara Kerja Auto-Slug:**
```php
// Saat membuat artikel baru
Article::create([
    'title' => 'Tips Mengurangi Food Waste',
    // slug otomatis: 'tips-mengurangi-food-waste'
]);

// Jika ada duplikat title
Article::create([
    'title' => 'Tips Mengurangi Food Waste',
    // slug otomatis: 'tips-mengurangi-food-waste-1'
]);
```

---

### 3. **Controller** ✅
📁 `app/Http/Controllers/Admin/ArticleController.php`

**Method yang Tersedia:**

#### `index()`
- Mengambil semua artikel dari database (urutan terbaru)
- Mengirim data `$articles` ke view `admin.dashboard`
- Siap untuk ditampilkan di UI admin

#### `store(Request $request)`
- **Validasi Input:**
  - `title`: Required, string, max 255 karakter
  - `category`: Required, string, max 100 karakter
  - `content`: Required, string
  - `image`: Nullable, image, format jpeg/png/jpg/webp, max 2MB
  - `status`: Required, enum (published/draft)
  
- **Pesan Error:** Semua dalam Bahasa Indonesia
- **Upload Foto:** Otomatis ke `storage/app/public/articles/`
- **Auto-Slug:** Slug otomatis terisi melalui Model boot event
- **Response:** Redirect back dengan flash message `success`

---

### 4. **Routing** ✅
📁 `routes/web.php`

**Route yang Ditambahkan (dalam group middleware Admin):**
```php
// Menampilkan dashboard dengan data artikel
Route::get('/edukasi', [ArticleController::class, 'index'])
    ->name('admin.edukasi');

// Menyimpan artikel baru
Route::post('/edukasi/store', [ArticleController::class, 'store'])
    ->name('admin.edukasi.store');
```

**URL Akses:**
- Dashboard Edukasi: `http://localhost/admin/edukasi`
- Store Artikel: `POST http://localhost/admin/edukasi/store`

---

## 🔧 Perintah Artisan yang Sudah Dijalankan

```bash
# 1. Membuat migration
php artisan make:migration create_articles_table

# 2. Membuat model
php artisan make:model Article

# 3. Membuat controller
php artisan make:controller Admin/ArticleController

# 4. Menjalankan migration (membuat tabel di database)
php artisan migrate
```

**Status:** ✅ Semua perintah sudah dijalankan dengan sukses.

---

## 📋 Perintah yang Perlu Anda Jalankan Selanjutnya

### 1. Setup Storage Link (Jika Belum)
```bash
php artisan storage:link
```
**Fungsi:** Membuat symbolic link dari `public/storage` ke `storage/app/public` agar foto artikel bisa diakses via browser.

---

## 🧪 Testing Backend (Tanpa UI)

### Test 1: Cek Tabel Database
```bash
php artisan tinker
```
```php
// Cek apakah tabel articles ada
\Illuminate\Support\Facades\Schema::hasTable('articles');
// Output: true

// Cek kolom-kolom tabel
\Illuminate\Support\Facades\Schema::getColumnListing('articles');
// Output: ["id", "title", "slug", "category", "content", "image", "status", "created_at", "updated_at"]
```

### Test 2: Buat Artikel Manual (Test Auto-Slug)
```bash
php artisan tinker
```
```php
// Test 1: Buat artikel pertama
$article1 = \App\Models\Article::create([
    'title' => 'Tips Mengurangi Food Waste',
    'category' => 'Edukasi Makanan',
    'content' => 'Konten artikel tentang tips mengurangi food waste...',
    'status' => 'published'
]);

echo $article1->slug;
// Output: tips-mengurangi-food-waste

// Test 2: Buat artikel dengan title sama (test auto-increment slug)
$article2 = \App\Models\Article::create([
    'title' => 'Tips Mengurangi Food Waste',
    'category' => 'Edukasi Makanan',
    'content' => 'Konten artikel lain...',
    'status' => 'published'
]);

echo $article2->slug;
// Output: tips-mengurangi-food-waste-1

// Test 3: Lihat semua artikel
\App\Models\Article::all();
```

### Test 3: Test Route (Via Browser atau Postman)
```
GET http://localhost/admin/edukasi
→ Harus menampilkan dashboard admin dengan data artikel (jika sudah ada UI)
```

---

## 📊 Struktur Data yang Siap Digunakan

Variabel `$articles` yang dikirim ke view berisi Collection dengan struktur:

```php
[
    {
        "id": 1,
        "title": "Tips Mengurangi Food Waste",
        "slug": "tips-mengurangi-food-waste",
        "category": "Edukasi Makanan",
        "content": "Konten artikel...",
        "image": "articles/abc123.jpg", // atau null
        "status": "published",
        "created_at": "2026-05-31 00:25:00",
        "updated_at": "2026-05-31 00:25:00"
    },
    // ... artikel lainnya
]
```

**Cara Akses di Blade:**
```blade
@foreach($articles as $article)
    <h3>{{ $article->title }}</h3>
    <p>{{ $article->category }}</p>
    <span>{{ $article->status }}</span>
    
    @if($article->image)
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
    @endif
@endforeach
```

---

## 🎯 Checklist Tahap 1 (AC-1 & Fondasi AC-2)

- [x] Migration tabel `articles` dengan struktur lengkap
- [x] Model `Article` dengan auto-slug dan mass assignment
- [x] Controller `ArticleController` dengan method `index()` dan `store()`
- [x] Validasi lengkap dengan pesan Bahasa Indonesia
- [x] Upload foto ke `storage/public/articles/`
- [x] Route di group middleware Admin
- [x] Migration sudah dijalankan (tabel sudah dibuat)
- [x] Import ArticleController di routes/web.php
- [x] Route lama diganti dengan route baru ke ArticleController

---

## 🚀 Next Steps (Tahap 2)

Setelah fondasi backend ini terpasang dengan sukses, tahap selanjutnya adalah:

1. **Modifikasi UI di `admin/dashboard.blade.php`:**
   - Tambahkan section untuk menampilkan list artikel
   - Tambahkan modal/form untuk tambah artikel baru
   - Integrasikan dengan route `admin.edukasi.store`

2. **Implementasi AC-2 (Tambah Artikel):**
   - Form input: title, category, content, image, status
   - Button submit yang hit route POST `/admin/edukasi/store`
   - Tampilkan flash message success/error

3. **Implementasi AC-3 (Edit & Hapus):**
   - Method `edit()`, `update()`, `destroy()` di Controller
   - Route tambahan untuk edit dan delete
   - UI untuk tombol edit dan hapus

---

## 📌 Catatan Penting

1. ✅ **File `admin/dashboard.blade.php` TIDAK DIUBAH** sesuai instruksi Anda
2. ✅ **Routing lama sudah diganti** dari closure ke ArticleController
3. ✅ **Auto-slug sudah diimplementasikan** dengan logic unik
4. ✅ **Validasi sudah lengkap** dengan pesan Bahasa Indonesia
5. ✅ **Upload foto sudah siap** ke folder `articles` di storage public
6. ⚠️ **Jangan lupa jalankan** `php artisan storage:link` sebelum upload foto

---

## 🔍 Troubleshooting

### Jika Route Tidak Ditemukan
```bash
php artisan route:clear
php artisan route:cache
```

### Jika Upload Foto Gagal
```bash
# Pastikan storage link sudah dibuat
php artisan storage:link

# Cek permission folder storage
# Folder storage/app/public harus writable
```

### Jika Slug Tidak Otomatis
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Pastikan Model Article sudah di-import dengan benar
```

---

**Status:** ✅ **FONDASI BACKEND SIAP DIGUNAKAN**  
**Tanggal:** 31 Mei 2026  
**Developer:** Kiro AI Assistant  
**Next:** Integrasi UI di dashboard.blade.php
