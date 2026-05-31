# Integrasi Frontend Artikel Edukasi (PBI-010 AC-5)

## 📋 Deskripsi
Implementasi integrasi artikel edukasi yang berstatus **Published** ke halaman pengguna (konsumen dan lembaga sosial). Artikel akan ditampilkan secara real-time di section "Edukasi & Lingkungan" pada dashboard user.

---

## ✅ Acceptance Criteria yang Diselesaikan
**AC-5**: Artikel yang berstatus Publish akan otomatis ditarik dan ditampilkan secara real-time di banner edukasi pada aplikasi pengguna.

---

## 🔧 Perubahan yang Dilakukan

### 1. **Backend - MenuController.php**
**File**: `app/Http/Controllers/MenuController.php`

#### Import Model Article
```php
use App\Models\Article; // Import model Article untuk edukasi
```

#### Method `consumerDashboard()`
Menambahkan query untuk mengambil artikel published:
```php
// Ambil artikel edukasi yang berstatus published (maksimal 5 artikel terbaru)
$articles = Article::where('status', 'published')->latest()->take(5)->get();

return view('dashboard', compact('menus', 'orders', 'impact', 'articles'));
```

#### Method `institutionDashboard()`
Menambahkan query untuk mengambil artikel published:
```php
// Ambil artikel edukasi yang berstatus published (maksimal 5 artikel terbaru)
$articles = Article::where('status', 'published')->latest()->take(5)->get();

return view('sosial.dashboard', compact('menus', 'orders', 'contribution', 'articles'));
```

---

### 2. **Backend - Route Guest Dashboard**
**File**: `routes/web.php`

Menambahkan query artikel untuk guest (user yang belum login):
```php
// 3. Ambil artikel edukasi yang berstatus published (maksimal 5 artikel terbaru)
$articles = \App\Models\Article::where('status', 'published')->latest()->take(5)->get();

return view('dashboard', compact('menus', 'orders', 'articles'));
```

---

### 3. **Frontend - Dashboard Konsumen**
**File**: `resources/views/dashboard.blade.php`

#### Section Edukasi (Baris ~975-1025)
Mengubah data dummy menjadi dinamis dengan loop `@forelse`:

```blade
<div class="edu-grid">
    @forelse($articles as $article)
        <div class="edu-card">
            <div class="edu-img-wrap">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                @else
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" alt="{{ $article->title }}">
                @endif
            </div>
            <span class="edu-tag">{{ $article->category }}</span>
            <h3 class="edu-title">{{ $article->title }}</h3>
            <p class="edu-desc">{{ Str::limit(strip_tags($article->content), 120) }}</p>
        </div>
    @empty
        {{-- Fallback: tampilkan artikel dummy jika tidak ada artikel published --}}
        <div class="edu-card">...</div>
        <div class="edu-card">...</div>
        <div class="edu-empty">...</div>
    @endforelse
</div>
```

**Fitur:**
- Menampilkan gambar artikel dari storage, atau fallback ke gambar default
- Menampilkan kategori artikel sebagai tag
- Menampilkan judul artikel
- Menampilkan preview konten (maksimal 120 karakter, tanpa HTML tags)
- Jika tidak ada artikel published, tampilkan 2 artikel dummy + placeholder kosong

---

### 4. **Frontend - Dashboard Lembaga Sosial**
**File**: `resources/views/sosial/dashboard.blade.php`

#### Section Edukasi (Baris ~1115-1165)
Struktur yang sama dengan dashboard konsumen, menggunakan loop `@forelse` untuk menampilkan artikel dinamis dengan fallback ke artikel dummy jika kosong.

---

## 🎯 Cara Kerja

### Flow Data:
1. **Admin** membuat artikel di dashboard admin dengan status "Published"
2. **Backend** mengambil artikel dengan query:
   ```php
   Article::where('status', 'published')->latest()->take(5)->get()
   ```
3. **Frontend** menampilkan artikel menggunakan loop `@forelse`:
   - Jika ada artikel → tampilkan data dari database
   - Jika tidak ada artikel → tampilkan artikel dummy sebagai fallback

### Tampilan untuk User:
- **Guest** (belum login) → Melihat artikel di `/home`
- **Konsumen** (login) → Melihat artikel di `/dashboard`
- **Lembaga Sosial** (login) → Melihat artikel di `/sosial/dashboard`

---

## 📦 Fitur yang Diimplementasikan

✅ Query artikel dengan status "published" saja  
✅ Maksimal 5 artikel terbaru ditampilkan  
✅ Gambar artikel dari storage dengan fallback ke gambar default  
✅ Kategori artikel ditampilkan sebagai tag  
✅ Preview konten artikel (120 karakter, tanpa HTML)  
✅ Fallback ke artikel dummy jika tidak ada artikel published  
✅ Integrasi di 3 halaman: Guest, Konsumen, Lembaga Sosial  
✅ Tidak mengubah layout atau styling CSS asli  

---

## 🧪 Testing

### Skenario 1: Tidak Ada Artikel Published
- **Expected**: Tampilkan 2 artikel dummy + 1 placeholder kosong
- **Actual**: ✅ Berhasil

### Skenario 2: Ada 1-2 Artikel Published
- **Expected**: Tampilkan artikel dari database
- **Actual**: ✅ Berhasil

### Skenario 3: Ada 5+ Artikel Published
- **Expected**: Tampilkan maksimal 5 artikel terbaru
- **Actual**: ✅ Berhasil

### Skenario 4: Artikel Tanpa Gambar
- **Expected**: Tampilkan gambar fallback dari Unsplash
- **Actual**: ✅ Berhasil

---

## 📝 Catatan Penting

1. **Tidak Mengubah Layout Asli**: Semua perubahan hanya pada data dinamis, tidak mengubah struktur HTML, CSS class, atau styling yang sudah ada.

2. **Fallback Mechanism**: Jika tidak ada artikel published, sistem akan menampilkan artikel dummy agar halaman tidak terlihat kosong.

3. **Image Handling**: 
   - Jika artikel memiliki gambar → `asset('storage/' . $article->image)`
   - Jika tidak ada gambar → Gambar default dari Unsplash

4. **Content Preview**: Menggunakan `Str::limit(strip_tags($article->content), 120)` untuk menampilkan preview konten tanpa HTML tags.

5. **Query Optimization**: Menggunakan `latest()->take(5)` untuk performa optimal (hanya ambil 5 artikel terbaru).

---

## 🎉 Status
**✅ SELESAI** - Semua acceptance criteria PBI-010 telah diselesaikan:
- AC-1: ✅ Backend Foundation (Migration, Model, Controller)
- AC-2: ✅ Store Article (Create)
- AC-3: ✅ Frontend Integration (Admin Dashboard)
- AC-4: ✅ Edit & Delete Article
- AC-5: ✅ Frontend Integration (User Dashboard) ← **BARU SELESAI**

---

**Dibuat oleh**: Kiro AI Assistant  
**Tanggal**: 31 Mei 2026  
**PBI**: PBI-010 - Manajemen Artikel Edukasi
