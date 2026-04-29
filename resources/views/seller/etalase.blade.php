<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Etalase Menu — FoodSave Seller</title>
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
    --green-900: #14532d;
    --ink:    #0f1d14;
    --muted:  #4b6358;
    --faint:  #8aab9a;
    --ghost:  #c4d9ce;
    --white:  #ffffff;
    --off:    #f7fdf9;
    --border: rgba(22,163,74,0.13);
    --border-md: rgba(22,163,74,0.25);
    --r-sm: 12px; --r-md: 18px; --r-lg: 24px; --r-pill: 999px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Sora', system-ui, sans-serif;
    background: var(--off); color: var(--ink);
    min-height: 100vh;
}
body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: radial-gradient(circle, rgba(22,163,74,0.09) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none; z-index: 0;
}

/* ─── PAGE WRAPPER ─── */
.page {
    max-width: 1100px; margin: 0 auto;
    padding: 2.5rem 2rem 5rem;
    position: relative; z-index: 1;
}

/* ─── TOP BAR ─── */
.top-bar {
    display: flex; align-items: center;
    justify-content: space-between; gap: 1rem;
    margin-bottom: 2rem; flex-wrap: wrap;
}
.page-title {
    font-weight: 800; font-size: 1.75rem;
    letter-spacing: -0.05em; color: var(--ink);
}
.page-title span { color: var(--mint-600); }
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.8125rem; font-weight: 600; color: var(--muted);
    text-decoration: none; transition: color 0.2s;
}
.back-link:hover { color: var(--mint-600); }
.back-link svg { width: 15px; height: 15px; }

/* ─── ADD BUTTON ─── */
.btn-add {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--mint-600); color: #fff;
    border: none; border-radius: var(--r-pill);
    padding: 0.65rem 1.375rem;
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.875rem; cursor: pointer; letter-spacing: -0.01em;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 14px rgba(22,163,74,0.28);
}
.btn-add:hover { background: var(--green-800); transform: translateY(-1px); }
.btn-add svg { width: 16px; height: 16px; }

/* ─── FLASH MESSAGE ─── */
.flash {
    display: flex; align-items: center; gap: 10px;
    background: var(--mint-100); border: 1.5px solid var(--mint-200);
    color: var(--green-800); border-radius: var(--r-md);
    padding: 0.875rem 1.25rem; margin-bottom: 1.5rem;
    font-size: 0.875rem; font-weight: 600;
    animation: fadeUp 0.4s ease both;
}
.flash svg { width: 18px; height: 18px; flex-shrink: 0; color: var(--mint-600); }

/* ─── CARD CONTAINER ─── */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
}

/* ─── MENU CARD ─── */
.menu-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s, border-color 0.2s;
    display: flex; flex-direction: column;
}
.menu-card:hover {
    transform: translateY(-5px);
    border-color: var(--border-md);
    box-shadow: 0 16px 40px rgba(17,25,23,0.09);
}
.card-img {
    width: 100%; height: 175px;
    object-fit: cover; display: block;
    background: var(--mint-100);
}
.card-img-placeholder {
    width: 100%; height: 175px;
    background: linear-gradient(135deg, var(--mint-100) 0%, var(--mint-200) 100%);
    display: flex; align-items: center; justify-content: center;
}
.card-img-placeholder svg { width: 48px; height: 48px; color: var(--mint-400); opacity: 0.6; }

.card-body { padding: 1.25rem 1.25rem 0; flex: 1; }
.card-name {
    font-weight: 800; font-size: 1rem;
    letter-spacing: -0.03em; color: var(--ink);
    margin-bottom: 0.25rem;
    display: -webkit-box; -webkit-line-clamp: 1;
    -webkit-box-orient: vertical; overflow: hidden;
}
.card-discount-info {
    font-size: 0.8125rem; color: var(--muted);
    margin-bottom: 0.875rem; min-height: 1.5em;
    display: flex; align-items: center; gap: 6px;
}
.strikethrough { text-decoration: line-through; opacity: 0.7; }
.discount-badge {
    background: #fee2e2; color: #dc2626; font-weight: 700;
    padding: 2px 6px; border-radius: 6px; font-size: 0.7rem;
}
.card-meta {
    display: flex; align-items: center;
    justify-content: space-between; gap: 0.5rem;
    padding-bottom: 1rem;
}
.card-price {
    font-weight: 800; font-size: 1.25rem;
    color: var(--mint-600); letter-spacing: -0.03em;
}
.stock-badge {
    font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    padding: 3px 10px; border-radius: var(--r-pill);
}
.stock-ok  { background: var(--mint-100); color: var(--mint-700); }
.stock-low { background: #fef3c7; color: #92400e; }
.stock-out { background: #fee2e2; color: #991b1b; }

/* ─── CARD ACTIONS ─── */
.card-actions {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.875rem 1.25rem;
    border-top: 1px solid var(--border);
    background: var(--mint-50);
}
/* Edit button */
.btn-edit {
    flex: 1; display: inline-flex; align-items: center; justify-content: center;
    gap: 6px; background: var(--mint-600); color: #fff;
    border: none; border-radius: var(--r-sm);
    padding: 0.55rem 1rem;
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.8125rem; cursor: pointer;
    text-decoration: none; transition: background 0.2s, transform 0.15s;
}
.btn-edit:hover { background: var(--green-800); transform: translateY(-1px); }
.btn-edit svg { width: 14px; height: 14px; }

/* Delete button — icon only */
.btn-delete {
    width: 38px; height: 38px; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
    background: #ef4444; color: #fff;
    border: none; border-radius: var(--r-sm);
    cursor: pointer; transition: background 0.2s, transform 0.15s;
}
.btn-delete:hover { background: #b91c1c; transform: translateY(-1px); }
.btn-delete svg { width: 16px; height: 16px; }
.btn-delete form { margin: 0; }

/* ─── EMPTY STATE ─── */
.empty-state {
    text-align: center; padding: 5rem 2rem;
    background: #fff; border: 1.5px dashed var(--border-md);
    border-radius: var(--r-lg); color: var(--muted);
}
.empty-state svg { width: 56px; height: 56px; margin: 0 auto 1rem; color: var(--ghost); }
.empty-state h3 { font-weight: 700; font-size: 1.125rem; color: var(--ink); margin-bottom: 0.5rem; }
.empty-state p { font-size: 0.875rem; }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp {
    from { opacity:0; transform: translateY(16px); }
    to   { opacity:1; transform: translateY(0); }
}
.top-bar    { animation: fadeUp 0.45s ease 0.05s both; }
.flash      { animation: fadeUp 0.45s ease 0.05s both; }
.menu-grid  { animation: fadeUp 0.45s ease 0.12s both; }
.empty-state{ animation: fadeUp 0.45s ease 0.12s both; }

@media(max-width: 640px) {
    .page { padding: 1.5rem 1rem 4rem; }
    .page-title { font-size: 1.375rem; }
}
</style>

<div class="page">

    {{-- ── TOP BAR ── --}}
    <div class="top-bar">
        <div>
            <a href="{{ route('seller.dashboard') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="page-title" style="margin-top:0.5rem;">Etalase <span>Menu</span></h1>
        </div>
        <a href="{{ route('seller.tambah-menu') }}" class="btn-add" id="btnTambahMenu">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Menu
        </a>
    </div>

    {{-- ── FLASH ── --}}
    @if(session('success'))
    <div class="flash">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── MENU GRID ── --}}
    @if($menus->isEmpty())
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <h3>Belum Ada Menu</h3>
            <p>Klik tombol <strong>Tambah Menu</strong> untuk menambahkan listing menu pertamamu.</p>
        </div>
    @else
    <div class="menu-grid">
        @foreach($menus as $menu)
        <div class="menu-card">
            {{-- Foto --}}
            @if($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="card-img">
            @else
                <div class="card-img-placeholder">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif

            <div class="card-body">
                <div class="card-name">{{ $menu->name }}</div>
                
                <div class="card-discount-info">
                    @if($menu->discount > 0)
                        <span class="strikethrough">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <span class="discount-badge">{{ $menu->discount }}%</span>
                    @endif
                </div>

                <div class="card-meta">
                    <div class="card-price">Rp {{ number_format($menu->final_price, 0, ',', '.') }}</div>
                    @if($menu->stock > 5)
                        <span class="stock-badge stock-ok">{{ $menu->stock }} Porsi</span>
                    @elseif($menu->stock > 0)
                        <span class="stock-badge stock-low">Sisa {{ $menu->stock }}</span>
                    @else
                        <span class="stock-badge stock-out">Habis</span>
                    @endif
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="card-actions">
                {{-- Edit --}}
                <a href="{{ route('seller.menus.editMenu', $menu->id) }}" class="btn-edit" id="btnEdit{{ $menu->id }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                {{-- Hapus — icon only --}}
                <form action="{{ route('seller.menus.destroy', $menu->id) }}" method="POST"
                      onsubmit="return confirm('Hapus menu \'{{ addslashes($menu->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" id="btnHapus{{ $menu->id }}" title="Hapus menu">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
</x-app-layout>
