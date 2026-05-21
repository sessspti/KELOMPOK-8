# Requirements Document

## Introduction

Dokumen ini mendefisikan kebutuhan untuk fitur status toko dan visibilitas produk di dashboard konsumen dan lembaga. Ketika seller menutup tokonya, status otomatis berubah menjadi "Tutup" di semua dashboard tanpa menghapus produk. Ketika stok produk habis, produk tersebut otomatis hilang dari dashboard konsumen dan lembaga.

## Glossary

- **Store**: Toko yang dimiliki oleh seller, memiliki status "Buka" atau "Tutup"
- **Seller**: Pengguna dengan peran "seller" yang mengelola toko dan produk
- **Consumer**: Pengguna dengan peran "consumer" yang dapat melihat dan membeli produk
- **Institution**: Pengguna dengan peran "institution" yang dapat melihat dan memesan produk
- **Product**: Menu atau produk yang dijual di dalam toko
- **Stock**: Jumlah stok produk yang tersedia (integer)
- **Store_Status**: Status toko dengan nilai enum "Buka" atau "Tutup"
- **Dashboard_Konsumen**: Halaman tampilan produk untuk consumer
- **Dashboard_Lembaga**: Halaman tampilan produk untuk institution
- **Dashboard_Seller**: Halaman pengelolaan toko dan produk untuk seller

## Requirements

### Requirement 1: Auto-Update Store Status Display

**User Story:** Sebagai konsumen dan lembaga, saya ingin melihat status toko yang akurat, sehingga saya tahu toko mana yang sedang beroperasi.

#### Acceptance Criteria

1. WHEN seller mengubah status toko menjadi "Tutup", THE System SHALL memperbarui tampilan status di Dashboard_Konsumen menjadi "Tutup" dalam waktu 5 detik atau kurang.
2. WHEN seller mengubah status toko menjadi "Tutup", THE System SHALL memperbarui tampilan status di Dashboard_Lembaga menjadi "Tutup" dalam waktu 5 detik atau kurang.
3. WHEN seller mengubah status toko menjadi "Buka", THE System SHALL memperbarui tampilan status di Dashboard_Konsumen menjadi "Buka" dalam waktu 5 detik atau kurang.
4. WHEN seller mengubah status toko menjadi "Buka", THE System SHALL memperbarui tampilan status di Dashboard_Lembaga menjadi "Buka" dalam waktu 5 detik atau kurang.
5. WHEN seller mengubah status toko, THE System SHALL memperbarui tampilan status di Dashboard_Seller dalam waktu 5 detik atau kurang.
6. THE System SHALL menampilkan status toko yang sama di Dashboard_Seller, Dashboard_Konsumen, dan Dashboard_Lembaga (unified status).
7. IF pembaruan status ke Dashboard_Konsumen atau Dashboard_Lembaga gagal, THE System SHALL melakukan retry hingga 3 kali dengan interval 2 detik.
8. IF semua retry gagal, THE System SHALL menampilkan indikator error pada Dashboard_Seller dan mempertahankan status terakhir yang berhasil disimpan.
9. THE System SHALL menampilkan nilai status yang identik (string "Buka" atau "Tutup") di ketiga dashboard untuk toko yang sama.

### Requirement 2: Products Remain Visible When Store Closed

**User Story:** Sebagai konsumen dan lembaga, saya tetap ingin melihat produk dari toko yang sudah tutup, sehingga saya bisa merencanakan pembelian di masa depan.

#### Acceptance Criteria

1. WHEN status toko berubah menjadi "Tutup", THE System SHALL tetap menampilkan semua produk toko tersebut di Dashboard_Konsumen.
2. WHEN status toko berubah menjadi "Tutup", THE System SHALL tetap menampilkan semua produk toko tersebut di Dashboard_Lembaga.
3. WHEN status toko berubah menjadi "Tutup", THE System SHALL menampilkan label "Tutup" pada setiap produk DAN pada header toko di Dashboard_Konsumen.
4. WHEN status toko berubah menjadi "Tutup", THE System SHALL menampilkan label "Tutup" pada setiap produk DAN pada header toko di Dashboard_Lembaga.
5. THE System SHALL tidak menghapus data produk dari database ketika toko ditutup.
6. IF transisi status toko ke "Tutup" gagal, THE System SHALL menampilkan pesan error dan mempertahankan status sebelumnya.

### Requirement 3: Auto-Hide Out-of-Stock Products

**User Story:** Sebagai konsumen dan lembaga, saya tidak ingin melihat produk yang stoknya habis, sehingga saya tidak memesan produk yang tidak tersedia.

#### Acceptance Criteria

1. WHEN stok produk berubah menjadi 0, THE System SHALL menyembunyikan produk tersebut dari semua daftar produk di Dashboard_Konsumen.
2. WHEN stok produk berubah menjadi 0, THE System SHALL menyembunyikan produk tersebut dari semua daftar produk di Dashboard_Lembaga.
3. WHEN stok produk berubah dari 0 menjadi lebih dari 0, THE System SHALL menampilkan produk tersebut di semua daftar produk di Dashboard_Konsumen.
4. WHEN stok produk berubah dari 0 menjadi lebih dari 0, THE System SHALL menampilkan produk tersebut di semua daftar produk di Dashboard_Lembaga.
5. WHILE stok produk sama dengan 0, THE System SHALL tetap menampilkan produk tersebut di Dashboard_Seller.
6. THE System SHALL menyembunyikan produk dengan stok 0 dari hasil pencarian di Dashboard_Konsumen dan Dashboard_Lembaga.
7. THE System SHALL menyembunyikan produk dengan stok 0 dari kategori dan filter tampilan di Dashboard_Konsumen dan Dashboard_Lembaga.
8. WHEN stok produk berubah, THE System SHALL memperbarui visibilitas produk di Dashboard_Konsumen dan Dashboard_Lembaga dalam waktu 5 detik.

### Requirement 4: Unified Store Status and Stock Logic

**User Story:** Sebagai developer, saya ingin logika status toko dan stok produk yang konsisten di semua dashboard, sehingga memudahkan pemeliharaan kode.

#### Acceptance Criteria

1. IF seller has an associated store record, THEN THE System SHALL use the store_status column from the stores table as the single source of truth for store status.
2. IF seller has no associated store record, THEN THE System SHALL use the store_status column from the users/sellers table as the single source of truth for store status.
3. IF product has a stock value in the products table, THEN THE System SHALL use the stock column from the products table as the single source of truth for product stock.
4. IF menu has a stock value in the menus table AND the product has no stock value, THEN THE System SHALL use the stock column from the menus table as the single source of truth for product stock.
5. THE Query_Builder SHALL apply the following filter conditions for displaying products in Dashboard_Konsumen and Dashboard_Lembaga: stock > 0 AND store_status IN ('Buka', 'Tutup').
6. THE Query_Builder SHALL NOT modify existing queries.
7. THE Query_Builder SHALL add filter conditions (stock > 0 AND store_status IN ('Buka', 'Tutup')) to new queries or scopes.
8. THE Product_Service or Product_Repository SHALL provide a method to retrieve products with store_status and stock filters, accepting parameters for minimum_stock (integer, default 0) and store_status values (array of strings).

### Requirement 5: No Existing Code Modification

**User Story:** Sebagai developer, saya ingin implementasi fitur ini tidak merusak kode yang sudah ada, sehingga risiko regression minimal.

#### Acceptance Criteria

1. WHEN feature implementation begins, THE System SHALL NOT change existing query logic in controllers that display products.
2. WHEN feature implementation begins, THE System SHALL NOT modify existing Menu model methods or relationships.
3. WHEN feature implementation begins, THE System SHALL NOT alter existing view templates.
4. THE System SHALL add new scopes to the Menu model without modifying existing scopes.
5. THE System SHALL add new accessors to the Menu model without modifying existing accessors.
6. THE System SHALL add new methods to repositories or services without modifying existing methods.
7. IF verification is needed, THE System SHALL provide a mechanism to compare pre-implementation and post-implementation code (e.g., git diff or file comparison tool).
8. THE System SHALL ensure that all existing functionality continues to work as before (no regressions).

### Requirement 6: Stock Update Triggers Visibility Change

**User Story:** Sebagai seller, saya ingin produk otomatis hilang dari dashboard konsumen dan lembaga ketika stok habis, sehingga konsumen tidak memesan produk yang tidak tersedia.

#### Acceptance Criteria

1. WHEN seller mengurangi stok produk, THE System SHALL memeriksa apakah stok menjadi 0.
2. WHEN stok produk menjadi 0 setelah pengurangan, THE System SHALL menyembunyikan produk dari Dashboard_Konsumen dan Dashboard_Lembaga.
3. WHEN seller menambah stok produk dari 0 menjadi lebih dari 0, THE System SHALL menampilkan produk di Dashboard_Konsumen dan Dashboard_Lembaga.
4. WHEN terjadi transaksi pembelian yang mengurangi stok produk hingga menjadi 0, THE System SHALL menyembunyikan produk dari Dashboard_Konsumen dan Dashboard_Lembaga.
5. THE System SHALL tidak menampilkan produk dengan stok 0 di Dashboard_Konsumen dan Dashboard_Lembaga terlepas dari sumber pengurangan stok.

### Requirement 7: Store Status Change Triggers Status Display Update

**User Story:** Sebagai seller, saya ingin status toko saya otomatis tercermin di semua dashboard ketika saya mengubahnya, sehingga konsumen dan lembaga mendapat informasi yang akurat.

#### Acceptance Criteria

1. WHEN seller mengubah status toko di Dashboard_Seller, THE System SHALL memperbarui tampilan di Dashboard_Konsumen dalam waktu 5 detik atau kurang.
2. WHEN seller mengubah status toko di Dashboard_Seller, THE System SHALL memperbarui tampilan di Dashboard_Lembaga dalam waktu 5 detik atau kurang.
3. WHEN seller menutup toko, THE System SHALL menampilkan status "Tutup" pada produk di Dashboard_Konsumen dan Dashboard_Lembaga.
4. WHEN seller menutup toko, THE System SHALL tidak menyembunyikan produk di Dashboard_Konsumen dan Dashboard_Lembaga, hanya mengubah tampilan status produk menjadi "Tutup".
5. IF real-time update ke Dashboard_Konsumen atau Dashboard_Lembaga gagal, THE System SHALL menampilkan status terbaru pada dashboard tersebut setelah halaman di-refresh.
6. IF real-time update gagal, THE System SHALL menampilkan indikator error pada Dashboard_Seller yang menunjukkan kegagalan sinkronisasi.