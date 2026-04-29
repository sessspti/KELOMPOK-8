<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Menu — FoodSave Seller</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --mint-50:  #f0fdf6;
    --mint-100: #dcfce9;
    --mint-200: #bbf7d4;
    --mint-400: #4ade80;
    --mint-500: #22c55e;
    --mint-600: #16a34a;
    --mint-700: #15803d;
    --green-800: #166534;
    --ink:    #0f1d14;
    --muted:  #4b6358;
    --off:    #f7fdf9;
    --border: rgba(22,163,74,0.15);
    --r-md: 18px; --r-xl: 32px; --r-pill: 999px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Sora', system-ui, sans-serif;
    background: var(--off); color: var(--ink); min-height: 100vh;
}
body::before {
    content: ''; position: fixed; inset: 0;
    background-image: radial-gradient(circle, rgba(22,163,74,0.09) 1px, transparent 1px);
    background-size: 28px 28px; pointer-events: none; z-index: 0;
}

.page {
    max-width: 680px; margin: 0 auto;
    padding: 2.5rem 1.5rem 5rem;
    position: relative; z-index: 1;
}

/* ─── HEADER ─── */
.page-header { margin-bottom: 2rem; animation: fadeUp 0.4s ease both; }
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.8125rem; font-weight: 600; color: var(--muted);
    text-decoration: none; transition: color 0.2s; margin-bottom: 0.75rem;
}
.back-link:hover { color: var(--mint-600); }
.back-link svg { width: 15px; height: 15px; }
.page-title {
    font-weight: 800; font-size: 1.75rem;
    letter-spacing: -0.05em; color: var(--ink);
}
.page-title span { color: var(--mint-600); }
.menu-subtitle {
    font-size: 0.875rem; color: var(--muted); margin-top: 4px;
}

/* ─── CURRENT PHOTO PREVIEW ─── */
.current-photo {
    display: flex; align-items: center; gap: 1rem;
    background: #fff; border: 1.5px solid var(--border);
    border-radius: var(--r-md); padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    animation: fadeUp 0.4s ease 0.05s both;
}
.current-photo img {
    width: 72px; height: 72px; border-radius: 12px;
    object-fit: cover; border: 2px solid var(--mint-100);
}
.photo-placeholder {
    width: 72px; height: 72px; border-radius: 12px;
    background: var(--mint-100); display: flex; align-items: center;
    justify-content: center; flex-shrink: 0;
}
.photo-placeholder svg { width: 28px; height: 28px; color: var(--mint-400); }
.current-photo-info p:first-child {
    font-weight: 700; font-size: 0.9375rem; color: var(--ink);
    letter-spacing: -0.02em;
}
.current-photo-info p:last-child {
    font-size: 0.8125rem; color: var(--muted); margin-top: 2px;
}

/* ─── FLASH ─── */
.flash {
    display: flex; align-items: center; gap: 10px;
    background: var(--mint-100); border: 1.5px solid var(--mint-200);
    color: var(--green-800); border-radius: var(--r-md);
    padding: 0.875rem 1.25rem; margin-bottom: 1.5rem;
    font-size: 0.875rem; font-weight: 600;
}
.flash svg { width: 18px; height: 18px; flex-shrink: 0; color: var(--mint-600); }

/* ─── CARD ─── */
.form-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    padding: 2.25rem;
    box-shadow: 0 8px 32px rgba(17,25,23,0.06);
    animation: fadeUp 0.45s ease 0.08s both;
}

/* ─── FORM ELEMENTS ─── */
.form-group { margin-bottom: 1.25rem; }
.form-group label {
    display: block; font-size: 0.875rem; font-weight: 700;
    color: var(--ink); margin-bottom: 0.5rem;
}
.form-group label .req { color: #ef4444; }
.form-control {
    width: 100%; padding: 0.75rem 1rem;
    border: 1.5px solid rgba(22,163,74,0.2);
    border-radius: 12px; font-family: 'Sora', sans-serif;
    font-size: 0.9375rem; color: var(--ink); background: #fff;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control:focus {
    border-color: var(--mint-500);
    box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
}
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media(max-width:520px) { .form-row { grid-template-columns: 1fr; } }

/* ─── UPLOAD ─── */
.upload-area {
    border: 2px dashed rgba(22,163,74,0.3);
    border-radius: 12px; background: var(--mint-50);
    padding: 1.25rem; text-align: center;
    cursor: pointer; transition: border-color 0.2s, background 0.2s;
    position: relative;
}
.upload-area:hover { border-color: var(--mint-400); background: var(--mint-100); }
.upload-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.upload-area svg { width: 30px; height: 30px; color: var(--mint-400); margin: 0 auto 0.4rem; }
.upload-area p { font-size: 0.8125rem; color: var(--muted); }
.upload-area strong { color: var(--mint-600); }

/* ─── ACTIONS ─── */
.form-actions {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem;
    border-top: 1.5px solid rgba(22,163,74,0.1);
}

/* Back — abu-abu, font hitam */
.btn-back {
    background: #e5e7eb; color: #1f2937;
    border: none; border-radius: var(--r-pill);
    padding: 0.65rem 1.375rem;
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.875rem; cursor: pointer; text-decoration: none;
    transition: background 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-back:hover { background: #d1d5db; }
.btn-back svg { width: 15px; height: 15px; }

/* Submit — hijau, font putih */
.btn-submit {
    background: var(--mint-600); color: #fff;
    border: none; border-radius: var(--r-pill);
    padding: 0.65rem 1.75rem;
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.875rem; cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 14px rgba(22,163,74,0.28);
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-submit:hover { background: var(--green-800); transform: translateY(-1px); }
.btn-submit svg { width: 15px; height: 15px; }

@keyframes fadeUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}
</style>

<div class="page">

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <a href="{{ route('seller.manage') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Etalase Menu
        </a>
        <h1 class="page-title">Edit <span>Menu</span></h1>
        <p class="menu-subtitle">Perbarui informasi untuk menu <strong>{{ $menu->name }}</strong></p>
    </div>

    @if(session('success'))
    <div class="flash">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── CURRENT PHOTO PREVIEW ── --}}
    <div class="current-photo">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
        @else
            <div class="photo-placeholder">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif
        <div class="current-photo-info">
            <p>{{ $menu->name }}</p>
            <p>Rp {{ number_format($menu->price, 0, ',', '.') }} · Stok: {{ $menu->stock }} porsi</p>
        </div>
    </div>

    {{-- ── FORM ── --}}
    <div class="form-card">
        <form action="{{ route('seller.menus.updateMenu', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama Menu --}}
            <div class="form-group">
                <label for="name">Nama Menu <span class="req">*</span></label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name', $menu->name) }}" required>
            </div>

            {{-- Harga & Porsi --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Harga (Rp) <span class="req">*</span></label>
                    <input type="number" id="price" name="price" class="form-control"
                           value="{{ old('price', $menu->price) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label for="stock">Porsi <span class="req">*</span></label>
                    <input type="number" id="stock" name="stock" class="form-control"
                           value="{{ old('stock', $menu->stock) }}" min="0" required>
                </div>
            </div>

            {{-- Diskon --}}
            <div class="form-group">
                <label for="discount">Total Diskon (%) <span class="req">*</span></label>
                <input type="number" id="discount" name="discount" class="form-control"
                       value="{{ old('discount', $menu->discount) }}" min="0" max="100" required>
            </div>

            {{-- Ganti Foto --}}
            <div class="form-group">
                <label>Ganti Foto <span style="font-weight:400;color:var(--muted)">(Opsional)</span></label>
                <div class="upload-area">
                    <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p><strong>Klik untuk upload</strong> foto baru</p>
                    <p id="fileLabel" style="font-size:0.75rem;color:#16a34a;margin-top:4px;"></p>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="form-actions">
                {{-- Back — abu-abu, font hitam --}}
                <a href="{{ route('seller.manage') }}" class="btn-back" id="btnBack">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back
                </a>
                {{-- Submit — hijau, font putih --}}
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
<script>
function previewFile(input) {
    const label = document.getElementById('fileLabel');
    if (input.files && input.files[0]) {
        label.textContent = '✓ ' + input.files[0].name;
    }
}
</script>
</x-app-layout>
