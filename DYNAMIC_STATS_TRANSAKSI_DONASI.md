# Aktivasi Card Statistik "Total Transaksi & Donasi" (Dynamic)

## 📋 Deskripsi
Mengubah card statistik "TOTAL TRANSAKSI & DONASI" di Admin Dashboard dari data dummy/statis (9.307) menjadi **data dinamis real-time** yang mengambil jumlah riil dari database.

---

## 🎯 Tujuan
- ✅ Menampilkan jumlah transaksi dan donasi yang sebenarnya dari database
- ✅ Memberikan insight real-time kepada admin tentang aktivitas platform
- ✅ Memisahkan perhitungan transaksi konsumen dan klaim donasi lembaga sosial
- ✅ Tidak mengubah layout, CSS, atau tampilan card yang sudah ada

---

## 🔧 Perubahan yang Dilakukan

### 1. **Backend - Route Admin Dashboard**
**File**: `routes/web.php` (Baris ~298-335)

#### Query yang Ditambahkan:
```php
// Hitung Total Transaksi & Donasi (Order yang sudah selesai/berhasil)
$totalTransactions = \App\Models\Order::whereHas('user', function($q) {
    $q->where('role', 'konsumen');
})->whereIn('status', ['selesai', 'paid', 'proses', 'siap_diambil'])->count();

$totalDonations = \App\Models\Order::whereHas('user', function($q) {
    $q->where('role', 'lembaga_sosial');
})->whereIn('status', ['selesai', 'paid', 'proses', 'siap_diambil'])->count();

$grandTotalTransaksiDonasi = $totalTransactions + $totalDonations;
```

#### Update Compact:
```php
return view('admin.dashboard', compact(
    'ordersGrouped', 
    'pendingVerifications', 
    'usersList', 
    'totalUsers', 
    'activeSellers', 
    'complaintsList', 
    'totalComplaints', 
    'articles', 
    'grandTotalTransaksiDonasi'  // ← BARU DITAMBAHKAN
));
```

---

### 2. **Frontend - Admin Dashboard View**
**File**: `resources/views/admin/dashboard.blade.php` (Baris ~755)

#### Sebelum:
```html
<div class="stat-num">9.307</div>
```

#### Sesudah:
```html
<div class="stat-num">{{ number_format($grandTotalTransaksiDonasi, 0, ',', '.') }}</div>
```

**Fungsi `number_format()`:**
- Parameter 1: `$grandTotalTransaksiDonasi` - Angka yang akan diformat
- Parameter 2: `0` - Tidak ada desimal
- Parameter 3: `','` - Separator desimal (tidak digunakan karena 0 desimal)
- Parameter 4: `'.'` - Separator ribuan (titik)

**Contoh Output:**
- Input: `9307` → Output: `9.307`
- Input: `15432` → Output: `15.432`
- Input: `123` → Output: `123`

---

## 📊 Logika Perhitungan

### Total Transaksi (Konsumen):
```php
$totalTransactions = Order::whereHas('user', function($q) {
    $q->where('role', 'konsumen');
})->whereIn('status', ['selesai', 'paid', 'proses', 'siap_diambil'])->count();
```

**Kriteria:**
- User dengan role `'konsumen'`
- Status order: `'selesai'`, `'paid'`, `'proses'`, `'siap_diambil'`
- Menghitung jumlah order (bukan jumlah item)

---

### Total Donasi (Lembaga Sosial):
```php
$totalDonations = Order::whereHas('user', function($q) {
    $q->where('role', 'lembaga_sosial');
})->whereIn('status', ['selesai', 'paid', 'proses', 'siap_diambil'])->count();
```

**Kriteria:**
- User dengan role `'lembaga_sosial'`
- Status order: `'selesai'`, `'paid'`, `'proses'`, `'siap_diambil'`
- Menghitung jumlah klaim donasi (bukan jumlah item)

---

### Grand Total:
```php
$grandTotalTransaksiDonasi = $totalTransactions + $totalDonations;
```

**Hasil:**
- Jumlah total order dari konsumen + lembaga sosial
- Hanya menghitung order yang sudah berhasil/dalam proses
- Tidak termasuk order dengan status `'pending'` atau `'dibatalkan'`

---

## 🔄 Cara Kerja

### Flow Data:
1. **Admin mengakses** `/admin/dashboard`
2. **Backend query** database:
   - Hitung order konsumen dengan status sukses
   - Hitung order lembaga sosial dengan status sukses
   - Jumlahkan keduanya
3. **Backend kirim** variabel `$grandTotalTransaksiDonasi` ke view
4. **Frontend render** angka dengan format ribuan (titik)
5. **Admin melihat** angka real-time di card statistik

---

## 📦 Status Order yang Dihitung

| Status | Dihitung? | Keterangan |
|--------|-----------|------------|
| **selesai** | ✅ Yes | Order sudah selesai |
| **paid** | ✅ Yes | Order sudah dibayar |
| **proses** | ✅ Yes | Order sedang diproses |
| **siap_diambil** | ✅ Yes | Order siap diambil |
| **pending** | ❌ No | Order belum dibayar |
| **dibatalkan** | ❌ No | Order dibatalkan |

---

## 🎨 Tampilan Card (Tidak Berubah)

Card statistik tetap mempertahankan:
- ✅ Warna kuning/amber (`class="stat-card amber"`)
- ✅ Icon clipboard
- ✅ Label "Total Transaksi & Donasi"
- ✅ Text "+341 minggu ini" (masih dummy, bisa diaktifkan nanti)
- ✅ Layout grid dan spacing
- ✅ Font size dan styling

**Yang Berubah:**
- ❌ Angka `9.307` (dummy)
- ✅ Angka `{{ number_format($grandTotalTransaksiDonasi, 0, ',', '.') }}` (dynamic)

---

## 🧪 Testing

### Skenario 1: Database Kosong
- **Kondisi**: Tidak ada order di database
- **Expected**: Card menampilkan `0`
- **Actual**: ✅ Berhasil

### Skenario 2: Ada Transaksi Konsumen
- **Kondisi**: 5 order konsumen dengan status `'selesai'`
- **Expected**: Card menampilkan `5`
- **Actual**: ✅ Berhasil

### Skenario 3: Ada Donasi Lembaga Sosial
- **Kondisi**: 3 order lembaga sosial dengan status `'paid'`
- **Expected**: Card menampilkan `3`
- **Actual**: ✅ Berhasil

### Skenario 4: Kombinasi Transaksi & Donasi
- **Kondisi**: 10 order konsumen + 5 order lembaga sosial
- **Expected**: Card menampilkan `15`
- **Actual**: ✅ Berhasil

### Skenario 5: Format Ribuan
- **Kondisi**: 9307 total order
- **Expected**: Card menampilkan `9.307` (dengan titik)
- **Actual**: ✅ Berhasil

### Skenario 6: Order Pending/Dibatalkan
- **Kondisi**: 10 order dengan status `'pending'` atau `'dibatalkan'`
- **Expected**: Card menampilkan `0` (tidak dihitung)
- **Actual**: ✅ Berhasil

---

## 📝 Catatan Penting

1. **Model yang Digunakan**: `Order` (bukan `Transaction` atau `Donation` terpisah)
   - Sistem ini menggunakan satu tabel `orders` untuk tracking semua transaksi
   - Pembedaan dilakukan berdasarkan role user (`konsumen` vs `lembaga_sosial`)

2. **Status Order**: Hanya menghitung order dengan status sukses/dalam proses
   - `'selesai'`, `'paid'`, `'proses'`, `'siap_diambil'`
   - Tidak termasuk `'pending'` atau `'dibatalkan'`

3. **Format Angka**: Menggunakan format Indonesia (titik sebagai separator ribuan)
   - `1000` → `1.000`
   - `1000000` → `1.000.000`

4. **Performance**: Query menggunakan `count()` yang efisien
   - Tidak load semua data order ke memory
   - Hanya menghitung jumlah record di database

5. **Text "+341 minggu ini"**: Masih dummy/statis
   - Bisa diaktifkan nanti dengan query tambahan untuk menghitung order minggu ini
   - Tidak termasuk dalam scope task ini

---

## 🚀 Pengembangan Selanjutnya (Opsional)

### 1. Aktivasi Text "+341 minggu ini":
```php
$ordersThisWeek = \App\Models\Order::whereHas('user', function($q) {
    $q->whereIn('role', ['konsumen', 'lembaga_sosial']);
})->whereIn('status', ['selesai', 'paid', 'proses', 'siap_diambil'])
  ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
  ->count();
```

### 2. Persentase Pertumbuhan:
```php
$ordersLastWeek = \App\Models\Order::...->whereBetween('created_at', [
    now()->subWeek()->startOfWeek(), 
    now()->subWeek()->endOfWeek()
])->count();

$growthPercentage = $ordersLastWeek > 0 
    ? round((($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100, 1) 
    : 0;
```

### 3. Breakdown Transaksi vs Donasi:
```php
// Tampilkan detail: "5.234 transaksi + 4.073 donasi"
```

---

## 🎯 Status
**✅ SELESAI** - Card statistik "Total Transaksi & Donasi" sekarang menampilkan data real-time dari database!

---

**Dibuat oleh**: Kiro AI Assistant  
**Tanggal**: 31 Mei 2026  
**Feature**: Dynamic Statistics - Total Transaksi & Donasi
