# Dokumentasi Teknis Super-Detail: Fitur Eksplorasi & Transaksi (Fitur Hani)

Dokumen ini memberikan rincian mendalam mengenai seluruh aspek coding, desain, dan logika yang diimplementasikan pada fitur Eksplorasi dan Transaksi aplikasi FoodSave.

---

## 1. Desain & Estetika (Global Design System)
Kami mengimplementasikan sistem desain "Premium Modern" yang responsif dan hidup.

### **Coding Desain:**
*   **CSS Variables**: Mendefinisikan palet warna (Mint, Green, Ink) dan radius elemen secara global agar konsisten.
*   **Glassmorphism**: Menggunakan `backdrop-filter: blur()` pada header dan sidebar untuk efek kaca yang elegan.

```css
/* Lokasi: resources/views/layouts/app.blade.php */
:root {
    --mint-400: #4ade80;
    --mint-600: #16a34a;
    --ink: #111917;
    --r-pill: 999px;
}
.hdr {
    background: rgba(247,253,249,0.88);
    backdrop-filter: blur(20px);
}
```

---

## 2. Sistem Pencarian Real-Time (Exploration)
Logika pencarian yang memungkinkan filter produk tanpa reload halaman.

### **Detail Fungsi:**
*   **`filteredProducts()`**: Menggunakan metode `.toLowerCase()` pada string nama produk dan toko agar pencarian tidak bersifat *case-sensitive* (tidak peduli huruf besar/kecil).

```javascript
// Lokasi: resources/views/dashboard.blade.php
get filteredProducts() {
    return this.products.filter(p => 
        p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
        p.store.toLowerCase().includes(this.searchQuery.toLowerCase())
    );
}
```

---

## 3. Logika Keranjang & Persistensi Data
Mengelola belanjaan pengguna dengan aman di sisi klien.

### **Detail Fungsi:**
*   **`localStorage.getItem('foodsave_cart')`**: Saat aplikasi pertama kali dimuat, ia mengecek memori browser (`localStorage`). Jika ada data belanjaan lama, ia akan otomatis dimuat.
*   **`formatRupiah(number)`**: Menggunakan API `Intl.NumberFormat` bawaan browser untuk memformat angka menjadi format mata uang Indonesia secara rapi.

```javascript
// Lokasi: resources/views/dashboard.blade.php & checkout.blade.php
formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}
```

---

## 4. Interaksi UI Cerdas (Smart FAB)
Tombol yang bisa berubah fungsi dan posisi sesuai keadaan aplikasi.

### **Logika Kondisional & Animasi:**
*   **`x-show="!isCartOpen"`**: Tombol "Keranjang" muncul jika sidebar tertutup.
*   **`x-show="isCartOpen"`**: Tombol "Kembali" muncul jika sidebar terbuka.
*   **Unified Position**: Kedua tombol kini berada di **kanan bawah** agar navigasi lebih konsisten.
*   **Fly-to-Cart Animation**: Menggunakan JavaScript dinamis untuk menciptakan elemen gambar yang "terbang" dari tombol tambah ke FAB Keranjang, memberikan feedback visual yang instan.

```html
<!-- Lokasi: resources/views/dashboard.blade.php -->
<div class="fixed bottom-8 right-8 z-[210]">
    <button x-show="isCartOpen" @click="isCartOpen = false">Kembali</button>
    <button x-show="!isCartOpen" @click="isCartOpen = true" :class="{'animate-wiggle': cartAnimation}">Keranjang</button>
</div>
```

---

## 5. Simulasi Checkout & Invoice
Proses akhir transaksi dengan simulasi delay jaringan dan feedback sukses.

### **Logika Transaksi:**
*   **`taxAmount`**: Menghitung pajak PPN 11% secara otomatis dari subtotal.
*   **`invoiceNumber`**: Menggunakan `Math.random()` untuk menghasilkan nomor faktur unik bagi setiap transaksi simulasi.
*   **`localStorage.removeItem()`**: Menghapus data keranjang hanya *setelah* pembayaran berhasil untuk mencegah kehilangan data jika transaksi gagal di tengah jalan.

```javascript
// Lokasi: resources/views/transaction/checkout.blade.php
processPayment() {
    this.isProcessing = true;
    setTimeout(() => {
        this.isProcessing = false;
        this.showSuccess = true;
        this.invoiceNumber = 'INV-' + Math.floor(Math.random() * 1000000);
        localStorage.removeItem('foodsave_cart'); 
    }, 2500); // Simulasi delay 2.5 detik
}
```

---

## 6. Daftar Folder & File (Final Map)

| Nama File | Path | Deskripsi Fungsi |
| :--- | :--- | :--- |
| **`dashboard.blade.php`** | `resources/views/` | Halaman utama, penampung state `isCartOpen`, `cart`, dan `products`. |
| **`checkout.blade.php`** | `resources/views/transaction/` | Halaman review pesanan, kalkulasi pajak, dan modal sukses. |
| **`cart-sidebar.blade.php`** | `resources/views/components/transaction/` | Komponen UI keranjang (template perulangan item keranjang). |
| **`header.blade.php`** | `resources/views/components/` | Komponen navigasi atas dengan input `x-model="searchQuery"`. |
| **`app.blade.php`** | `resources/views/layouts/` | Tempat penyimpanan seluruh CSS dan desain "Premium" FoodSave. |
| **`web.php`** | `routes/` | Pintu masuk route `checkout.summary`. |

---
