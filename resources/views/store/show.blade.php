<x-app-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Familjen+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400;1,700&family=Hanken+Grotesk:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════
   DESIGN TOKENS — identik genz.blade
══════════════════════════════════ */
:root {
    --mint-50:  #f0fdf6;
    --mint-100: #dcfce9;
    --mint-200: #bbf7d4;
    --mint-300: #86efb0;
    --mint-400: #4ade80;
    --mint-500: #22c55e;
    --mint-600: #16a34a;
    --mint-700: #15803d;
    --green-800: #166534;
    --green-900: #14532d;
    --lime-300: #bef264;
    --lime-400: #a3e635;
    --yellow-300: #fde047;
    --orange-400: #fb923c;
    --orange-500: #f97316;
    --rose-400: #fb7185;
    --rose-500: #f43f5e;
    --ink:    #111917;
    --muted:  #4b6358;
    --faint:  #8aab9a;
    --ghost:  #c4d9ce;
    --white:  #ffffff;
    --off:    #f7fdf9;
    --border: rgba(22,163,74,0.15);
    --border-md:  rgba(22,163,74,0.28);
    --border-str: rgba(22,163,74,0.45);
    --r-xs:  8px; --r-sm: 12px; --r-md: 18px;
    --r-lg:  24px; --r-xl: 32px; --r-2xl: 48px;
    --r-pill:999px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    font-family: 'Hanken Grotesk', system-ui, sans-serif;
    background: var(--off);
    color: var(--ink);
    min-height: 100vh;
    overflow-x: hidden;
}

/* Dot-grid texture */
body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: radial-gradient(circle, rgba(22,163,74,0.1) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none; z-index: 0;
}

/* ══════════════════════════════════
   HEADER KONSUMEN — sama dgn genz.blade
══════════════════════════════════ */
.hdr {
    position: sticky; top: 0; z-index: 100;
    background: rgba(247,253,249,0.88);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-bottom: 1.5px solid var(--border);
}
.hdr-inner {
    max-width: 1380px; margin: 0 auto;
    padding: 0 1.5rem; height: 70px;
    display: flex; align-items: center; gap: 1.25rem;
}
.logo {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700; font-size: 1.375rem; letter-spacing: -0.06em;
    color: var(--ink); text-decoration: none;
    display: flex; align-items: center; gap: 8px; flex-shrink: 0;
}
.logo-icon {
    width: 32px; height: 32px; background: var(--mint-400);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    animation: logo-bounce 3s ease-in-out infinite; flex-shrink: 0;
}
.logo-icon svg { width: 18px; height: 18px; color: #fff; }
@keyframes logo-bounce {
    0%,100%{transform:translateY(0) rotate(0deg)}
    30%{transform:translateY(-3px) rotate(-4deg)}
    60%{transform:translateY(-1px) rotate(2deg)}
}
.logo-save { color: var(--mint-600); }

.hdr-search {
    flex: 1; max-width: 400px; position: relative; display: none;
}
@media(min-width:768px){.hdr-search{display:block}}
.hdr-search input {
    width: 100%; background: var(--mint-50); border: 1.5px solid var(--border);
    border-radius: var(--r-pill); padding: 0.6rem 1.1rem 0.6rem 2.8rem;
    font-family: 'Hanken Grotesk', sans-serif; font-size: 0.875rem; color: var(--ink);
    outline: none; transition: all 0.22s;
}
.hdr-search input:focus { border-color: var(--mint-400); background: var(--white); box-shadow: 0 0 0 4px rgba(74,222,128,0.15); }
.hdr-search input::placeholder { color: var(--faint); }
.hdr-search-ico { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--faint); width: 15px; height: 15px; pointer-events: none; }

.hdr-right { margin-left: auto; display: flex; align-items: center; gap: 0.75rem; }
.pts-pill {
    background: var(--yellow-300); color: #78350f;
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.8125rem;
    padding: 0.4rem 1rem; border-radius: var(--r-pill); border: 2px solid rgba(0,0,0,0.08);
    white-space: nowrap;
}
.back-btn {
    display: flex; align-items: center; gap: 5px;
    background: var(--white); border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.4rem 0.875rem;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.8125rem; font-weight: 600;
    color: var(--muted); cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.back-btn:hover { border-color: var(--mint-400); color: var(--mint-600); }
.back-btn svg { width: 14px; height: 14px; }

/* ══════════════════════════════════
   FAB KERANJANG
══════════════════════════════════ */
.fab-cart {
    position: fixed; bottom: 2rem; right: 2rem; z-index: 200;
    background: var(--ink); color: var(--white);
    padding: 0.9rem 1.5rem; border-radius: var(--r-pill);
    display: flex; align-items: center; gap: 0.625rem;
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.9375rem;
    letter-spacing: -0.02em; cursor: pointer; border: none;
    box-shadow: 0 8px 32px rgba(17,25,23,0.28);
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.fab-cart:hover { background: var(--mint-500); transform: translateY(-4px) scale(1.03); box-shadow: 0 16px 40px rgba(34,197,94,0.35); }
.fab-cart svg { width: 19px; height: 19px; }
.fab-count {
    background: var(--mint-400); color: var(--ink);
    font-size: 0.7rem; font-weight: 800; width: 22px; height: 22px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    animation: fab-pulse 2.5s ease-in-out infinite;
}
@keyframes fab-pulse { 0%,100%{box-shadow:0 0 0 0 rgba(74,222,128,.5)} 50%{box-shadow:0 0 0 7px rgba(74,222,128,0)} }

/* ══════════════════════════════════
   PAGE WRAPPER
══════════════════════════════════ */
.page {
    max-width: 1380px; margin: 0 auto;
    padding: 0 1.5rem 7rem;
    position: relative; z-index: 1;
}

/* ══════════════════════════════════
   STORE HEADER — BENTO STYLE
══════════════════════════════════ */
.store-bento {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 1rem;
    margin: 2rem 0 1.5rem;
}
@media(max-width: 860px){ .store-bento { grid-template-columns: 1fr; } }

/* Main identity card */
.sb-identity {
    grid-row: 1 / 3;
    background: var(--mint-400);
    border-radius: var(--r-2xl);
    padding: 2.5rem 2.5rem 2rem;
    position: relative; overflow: hidden;
    display: flex; flex-direction: column; justify-content: space-between;
    min-height: 340px;
}
.sb-identity::before {
    content: ''; position: absolute; top: -70px; right: -70px;
    width: 260px; height: 260px; background: var(--lime-400); border-radius: 50%; opacity: 0.35;
}
.sb-identity::after {
    content: ''; position: absolute; bottom: -50px; left: -30px;
    width: 180px; height: 180px; background: var(--mint-200); border-radius: 50%; opacity: 0.5;
}
.sb-avatar-wrap { position: relative; z-index: 1; margin-bottom: 1.25rem; }
.sb-avatar {
    width: 72px; height: 72px; border-radius: var(--r-lg);
    background: rgba(255,255,255,0.35); border: 3px solid rgba(255,255,255,0.6);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: 1.625rem; color: var(--ink); text-transform: uppercase;
    backdrop-filter: blur(8px);
}
.sb-verified {
    position: absolute; bottom: -4px; right: -4px;
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--white); border: 2px solid var(--mint-300);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
}
.sb-name {
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: clamp(1.5rem, 3vw, 2.25rem); letter-spacing: -0.05em;
    color: var(--ink); line-height: 1.05; margin-bottom: 0.5rem;
    position: relative; z-index: 1;
}
.sb-desc { font-size: 0.875rem; color: var(--green-800); line-height: 1.55; position: relative; z-index: 1; max-width: 420px; }
.sb-status {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.5); border: 1.5px solid rgba(255,255,255,0.75);
    border-radius: var(--r-pill); padding: 0.3rem 0.875rem;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.6875rem; font-weight: 700;
    color: var(--green-900); letter-spacing: 0.06em;
    position: relative; z-index: 1; align-self: flex-start; margin-bottom: 0.875rem;
}
.sb-status-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--mint-700); animation: blink 1.8s ease-in-out infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

.sb-actions { display: flex; gap: 0.75rem; position: relative; z-index: 1; flex-wrap: wrap; }
.sb-btn-follow {
    padding: 0.65rem 1.5rem; border-radius: var(--r-pill); border: none;
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.875rem;
    cursor: pointer; transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1); letter-spacing: -0.01em;
}
.sb-btn-follow.follow    { background: var(--ink); color: var(--white); box-shadow: 0 4px 14px rgba(17,25,23,0.25); }
.sb-btn-follow.following { background: rgba(255,255,255,0.5); color: var(--green-900); border: 1.5px solid rgba(255,255,255,0.7); }
.sb-btn-follow:hover { transform: scale(1.05); }
.sb-btn-chat {
    padding: 0.65rem 1.25rem; border-radius: var(--r-pill);
    background: rgba(255,255,255,0.4); border: 1.5px solid rgba(255,255,255,0.65);
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.875rem;
    color: var(--green-900); cursor: pointer; transition: all 0.2s;
    display: flex; align-items: center; gap: 6px;
}
.sb-btn-chat:hover { background: rgba(255,255,255,0.65); }
.sb-btn-chat svg { width: 15px; height: 15px; }

/* Stats card */
.sb-stats {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); padding: 1.5rem 1.75rem;
    display: flex; flex-direction: column; justify-content: center;
    transition: border-color 0.2s;
}
.sb-stats:hover { border-color: var(--border-str); }
.sb-stats-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
}
.sb-stat-item { display: flex; flex-direction: column; gap: 3px; }
.sb-stat-num {
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: 1.625rem; letter-spacing: -0.05em; color: var(--ink); line-height: 1;
}
.sb-stat-lbl {
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--faint);
}
.sb-divider { height: 1px; background: var(--border); margin: 1rem 0; }
.sb-location {
    display: flex; align-items: center; gap: 7px;
    font-size: 0.875rem; color: var(--muted); font-weight: 500;
}
.sb-location svg { width: 15px; height: 15px; color: var(--mint-500); flex-shrink: 0; }

/* Lime tracker card */
.sb-tracker {
    background: var(--lime-300); border-radius: var(--r-xl);
    border: 2px dashed rgba(22,101,52,0.3);
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 0.375rem; padding: 1.25rem 1.5rem;
    text-align: center; min-height: 120px;
}
.sb-tracker-title { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.875rem; color: var(--green-800); letter-spacing: -0.02em; }
.sb-tracker-sub { font-size: 0.75rem; color: var(--green-900); opacity: 0.6; }
.sb-tracker-badge {
    background: rgba(22,101,52,0.12); border: 1px solid rgba(22,101,52,0.22);
    border-radius: var(--r-pill); padding: 3px 10px;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.5625rem;
    font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; color: var(--green-800);
    margin-top: 4px;
}

/* ══════════════════════════════════
   TICKER
══════════════════════════════════ */
.ticker-wrap {
    margin: 0 0 1.5rem; background: var(--ink);
    border-radius: var(--r-pill); overflow: hidden; padding: 0.7rem 0;
}
.ticker-track {
    display: flex; width: max-content;
    animation: scroll-ticker 22s linear infinite;
}
@keyframes scroll-ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.ticker-item {
    display: flex; align-items: center; gap: 0.75rem; padding: 0 2rem;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.6875rem;
    font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--mint-300); white-space: nowrap;
}
.ticker-star { color: var(--yellow-300); font-size: 12px; }

/* ══════════════════════════════════
   KATALOG HEADER
══════════════════════════════════ */
.catalog-hdr {
    display: flex; align-items: flex-end;
    justify-content: space-between; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;
}
.catalog-label {
    font-family: 'Space Grotesk', sans-serif; font-size: 0.625rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase; color: var(--mint-600);
    margin-bottom: 0.375rem; display: flex; align-items: center; gap: 5px;
}
.catalog-label::before { content:''; width:10px; height:1.5px; background:var(--mint-500); }
.catalog-title {
    font-family: 'Space Grotesk', sans-serif; font-weight: 700;
    font-size: clamp(1.5rem, 2.5vw, 2rem); letter-spacing: -0.05em; color: var(--ink); line-height: 1;
}
.catalog-count { font-size: 0.875rem; color: var(--muted); margin-top: 3px; }

/* ══════════════════════════════════
   PRODUCT GRID — 4 kolom responsif
══════════════════════════════════ */
.pgrid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
/* 1380px+ → 4 col (default) */
@media(max-width: 1200px){ .pgrid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 860px) { .pgrid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 500px) { .pgrid { grid-template-columns: 1fr; } }

/* ══════════════════════════════════
   PRODUCT CARD
══════════════════════════════════ */
.pcard {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); overflow: hidden; cursor: pointer;
    display: flex; flex-direction: column;
    transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s, border-color 0.2s;
    position: relative;
}
.pcard:hover {
    transform: translateY(-7px) rotate(-0.3deg);
    box-shadow: 0 20px 60px rgba(17,25,23,0.1), 0 0 0 2px var(--mint-300);
    border-color: var(--mint-300);
}

.pcard-img { position: relative; aspect-ratio: 4/3; overflow: hidden; background: var(--mint-100); }
.pcard-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.7s ease;
}
.pcard:hover .pcard-img img { transform: scale(1.09); }

/* image overlay gradient */
.pcard-img-gradient {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 55%; background: linear-gradient(to top, rgba(17,25,23,0.35) 0%, transparent 100%);
    pointer-events: none;
}

.bdg-dist {
    position: absolute; top: 0.75rem; left: 0.75rem;
    background: rgba(255,255,255,0.92); border: 1.5px solid rgba(22,163,74,0.18);
    border-radius: var(--r-pill); padding: 0.22rem 0.6rem;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.5875rem; font-weight: 700;
    color: var(--mint-700); letter-spacing: 0.06em;
    display: flex; align-items: center; gap: 3px;
    backdrop-filter: blur(8px);
}
.bdg-dist svg { width: 9px; height: 9px; }

.bdg-stock {
    position: absolute; top: 0.75rem; right: 0.75rem;
    border-radius: var(--r-sm); padding: 0.2rem 0.6rem;
    font-family: 'Space Grotesk', sans-serif; font-size: 0.5875rem; font-weight: 800;
    letter-spacing: 0.07em; text-transform: uppercase;
}
.bdg-stock.ok     { background: var(--mint-500); color: #fff; }
.bdg-stock.low    { background: var(--orange-500); color: #fff; animation: stock-pulse 1.8s ease-in-out infinite; }
.bdg-stock.empty  { background: var(--rose-500); color: #fff; }
@keyframes stock-pulse {
    0%,100%{box-shadow:0 0 0 0 rgba(249,115,22,.4)}
    60%{box-shadow:0 0 0 6px rgba(249,115,22,0)}
}

.pcard-body { padding: 1rem 1.125rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
.pcard-name {
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1rem;
    letter-spacing: -0.03em; line-height: 1.2; color: var(--ink); margin-bottom: 0.25rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    transition: color 0.2s;
}
.pcard:hover .pcard-name { color: var(--mint-600); }

.pcard-stock-row {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.75rem; color: var(--muted); margin-bottom: 0.875rem;
}
.stock-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.stock-dot.ok    { background: var(--mint-500); }
.stock-dot.low   { background: var(--orange-500); }
.stock-dot.empty { background: var(--rose-500); }

.pcard-footer { margin-top: auto; }
.pcard-price {
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: 1.25rem; letter-spacing: -0.04em; color: var(--mint-600);
    line-height: 1; margin-bottom: 0.75rem;
}
.pcard-price-orig { font-size: 0.75rem; color: var(--faint); text-decoration: line-through; margin-bottom: 2px; }

.pcard-btn {
    width: 100%; background: var(--mint-400); color: var(--ink); border: none;
    border-radius: var(--r-md); padding: 0.7rem 1rem;
    font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.875rem;
    letter-spacing: -0.02em; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 4px 14px rgba(74,222,128,0.3);
}
.pcard-btn:hover { background: var(--mint-500); color: var(--white); transform: scale(1.03); box-shadow: 0 8px 22px rgba(34,197,94,0.4); }
.pcard-btn:active { transform: scale(0.97); }
.pcard-btn:disabled { background: var(--ghost); color: var(--faint); cursor: not-allowed; box-shadow: none; transform: none; }
.pcard-btn svg { width: 16px; height: 16px; }

/* added feedback */
.pcard-btn.added { background: var(--mint-600); color: var(--white); }

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.empty-state {
    grid-column: 1 / -1;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); padding: 4rem 2rem;
    text-align: center; display: flex; flex-direction: column;
    align-items: center; gap: 0.75rem;
}
.empty-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: var(--mint-100); border: 2px solid var(--mint-200);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem;
}
.empty-title { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.0625rem; letter-spacing: -0.03em; color: var(--ink); }
.empty-sub { font-size: 0.875rem; color: var(--muted); }

/* ══════════════════════════════════
   CART DRAWER — SIDEBAR KANAN
══════════════════════════════════ */
.drawer-overlay {
    position: fixed; inset: 0; z-index: 400;
    background: rgba(17,25,23,0.45); backdrop-filter: blur(4px);
}
.drawer {
    position: fixed; top: 0; right: 0; bottom: 0;
    width: min(440px, 100vw); background: var(--white); z-index: 500;
    display: flex; flex-direction: column;
    border-left: 1.5px solid var(--border);
    box-shadow: -8px 0 48px rgba(17,25,23,0.12);
}
.drawer-hdr {
    padding: 1.5rem 1.75rem;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-shrink: 0; background: var(--mint-50);
}
.drawer-title {
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: 1.125rem; letter-spacing: -0.04em; color: var(--ink);
}
.drawer-subtitle { font-size: 0.8125rem; color: var(--muted); margin-top: 2px; }
.drawer-close {
    width: 36px; height: 36px; border-radius: var(--r-sm);
    border: 1.5px solid var(--border-md); background: var(--white);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--muted); transition: all 0.2s; flex-shrink: 0;
}
.drawer-close:hover { background: var(--rose-500); color: var(--white); border-color: var(--rose-500); }
.drawer-close svg { width: 16px; height: 16px; }

.drawer-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.75rem; }

.cart-item {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 0.875rem; background: var(--off); border: 1.5px solid var(--border);
    border-radius: var(--r-lg); margin-bottom: 0.75rem;
    transition: border-color 0.2s;
}
.cart-item:hover { border-color: var(--mint-300); }
.cart-thumb {
    width: 56px; height: 56px; border-radius: var(--r-sm);
    overflow: hidden; flex-shrink: 0; background: var(--mint-100);
}
.cart-thumb img { width: 100%; height: 100%; object-fit: cover; }
.cart-info { flex: 1; min-width: 0; }
.cart-name { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.9rem; letter-spacing: -0.025em; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-price { font-size: 0.8125rem; color: var(--mint-600); font-weight: 700; margin-top: 2px; }
.cart-qty { font-size: 0.75rem; color: var(--faint); }
.cart-remove {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    border: 1.5px solid var(--border-md); background: var(--white);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--faint); font-size: 16px; font-weight: 600; transition: all 0.2s;
}
.cart-remove:hover { background: var(--rose-500); color: var(--white); border-color: var(--rose-500); }

.cart-empty {
    text-align: center; padding: 3rem 1rem;
    display: flex; flex-direction: column; align-items: center; gap: 0.75rem;
}
.cart-empty-ico { font-size: 2.5rem; }
.cart-empty p { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

.drawer-footer {
    padding: 1.25rem 1.75rem; border-top: 1.5px solid var(--border); flex-shrink: 0;
}
.drawer-subtotal {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;
}
.subtotal-label { font-size: 0.875rem; color: var(--muted); }
.subtotal-val {
    font-family: 'Space Grotesk', sans-serif; font-weight: 800;
    font-size: 1.375rem; letter-spacing: -0.04em; color: var(--mint-600);
}
.checkout-btn {
    width: 100%; background: var(--mint-500); color: var(--white); border: none;
    border-radius: var(--r-xl); padding: 0.9rem;
    font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 1rem;
    letter-spacing: -0.02em; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(34,197,94,0.3); transition: all 0.2s;
}
.checkout-btn:hover { background: var(--mint-600); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(34,197,94,0.4); }
.checkout-btn:disabled { background: var(--ghost); color: var(--faint); cursor: not-allowed; box-shadow: none; transform: none; }
.checkout-btn svg { width: 18px; height: 18px; }
.checkout-note { text-align: center; font-size: 0.75rem; color: var(--faint); margin-top: 0.5rem; line-height: 1.5; }

/* ══════════════════════════════════
   TOAST NOTIFICATION
══════════════════════════════════ */
.toast-wrap {
    position: fixed; top: 5rem; left: 50%; transform: translateX(-50%);
    z-index: 600; display: flex; flex-direction: column; gap: 0.5rem;
    pointer-events: none;
}
.toast {
    background: var(--ink); color: var(--white);
    font-family: 'Space Grotesk', sans-serif; font-weight: 600; font-size: 0.875rem;
    padding: 0.75rem 1.25rem; border-radius: var(--r-pill);
    display: flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 24px rgba(17,25,23,0.28);
    animation: toast-in 0.35s cubic-bezier(0.34,1.56,0.64,1) both;
}
.toast-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--mint-400); flex-shrink: 0; }
@keyframes toast-in { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }

/* ══════════════════════════════════
   ANIMATIONS
══════════════════════════════════ */
@keyframes fadeUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}
.sb-identity    { animation: fadeUp 0.55s ease 0.05s both; }
.sb-stats       { animation: fadeUp 0.55s ease 0.12s both; }
.sb-tracker     { animation: fadeUp 0.55s ease 0.18s both; }
.ticker-wrap    { animation: fadeUp 0.5s ease 0.22s both; }
.catalog-hdr    { animation: fadeUp 0.5s ease 0.28s both; }
.pcard:nth-child(1){animation:fadeUp .45s ease .30s both}
.pcard:nth-child(2){animation:fadeUp .45s ease .36s both}
.pcard:nth-child(3){animation:fadeUp .45s ease .42s both}
.pcard:nth-child(4){animation:fadeUp .45s ease .48s both}
.pcard:nth-child(n+5){animation:fadeUp .45s ease .52s both}

[x-cloak] { display: none !important; }
</style>

{{-- ══════════════════
     HEADER KONSUMEN
══════════════════ --}}
<header class="hdr">
    <div class="hdr-inner">
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </span>
            Food<span class="logo-save">Save</span>
        </a>

        <div class="hdr-search">
            <svg class="hdr-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari menu di toko ini...">
        </div>

        <div class="hdr-right">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>


             {{-- Notifikasi Bell --}}
            @auth
            <div class="relative ml-2" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition-all focus:outline-none">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-72 bg-white border border-gray-100 rounded-2xl shadow-xl z-[130] py-2 origin-top-right"
                     style="display: none;">
                    
                    <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Notifikasi</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-green-600 hover:text-green-700 font-bold">Tandai semua dibaca</button>
                            </form>
                        @endif
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 relative group">
                                <div class="flex gap-3">
                                    <div class="text-lg flex-shrink-0">{{ $notification->data['icon'] ?? '🔔' }}</div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">{{ $notification->data['title'] }}</p>
                                        <p class="text-[10px] text-gray-500 mt-0.5">{{ $notification->data['message'] }}</p>
                                        <p class="text-[9px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    <button type="submit" title="Tandai dibaca" class="text-gray-400 hover:text-green-600">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg width="20" height="20" class="text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Tidak ada notifikasi baru</p>
                            </div>
                        @endforelse
                    </div>

                    @if(auth()->user()->notifications->count() > 0)
                        <div class="px-4 py-2 border-t border-gray-50 text-center">
                            <a href="#" class="text-[10px] text-gray-400 hover:text-gray-600 font-bold uppercase tracking-wider">Lihat Semua</a>
                        </div>
                    @endif
                </div>
            </div>
            @endauth

            {{-- User Account Dropdown --}}
            <div class="relative ml-3" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" style="z-index: 110;">
                <div>
                    @auth
                        {{-- Logged in: show user name --}}
                        <button @click="open = ! open" class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all focus:outline-none shadow-sm">
                            <div class="w-7 h-7 rounded-lg bg-green-100 border border-green-200 flex items-center justify-center text-green-700 font-extrabold text-xs flex-shrink-0 overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        {{-- Guest: show login/register buttons --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 text-sm font-bold text-green-700 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition-all">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 text-sm font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transition-all shadow-sm">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                @auth
                <div x-show="open"
                     class="absolute right-0 z-[120] mt-2 w-52 rounded-2xl shadow-xl bg-white border border-gray-100 py-2 origin-top-right"
                     style="display: none;">
                    <div class="px-4 py-2 text-[10px] text-gray-400 uppercase font-black tracking-widest border-b border-gray-50 mb-1">
                        Pengaturan Akun
                    </div>

                    {{-- Role-aware profile link --}}
                    @php
                        $profileRoute = match(Auth::user()->role) {
                            'seller'         => route('profile.edit'),
                            'lembaga_sosial' => route('profile.edit'),
                            default          => route('profile.edit'),
                        };
                    @endphp
                    <a href="{{ $profileRoute }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors font-medium">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Edit Profil
                        </div>
                    </a>

                    @if(Auth::user()->role === 'konsumen')
                    <a href="{{ route('transaction.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors font-medium">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Riwayat Pesanan
                        </div>
                    </a>
                    @endif
                    <div class="border-t border-gray-50 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                            <div class="flex items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('Keluar') }}
                            </div>
                        </a>
                    </form>
                </div>
                @endauth
            </div>



        </div>
    </div>
</header>

{{-- ══════════════════
     ALPINE.JS SCOPE
══════════════════ --}}
<div x-data="storePage()" x-init="initCart()" x-cloak>

{{-- ══ FAB CART ══ --}}
<button class="fab-cart" @click="openDrawer = true" x-show="true">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Keranjang
    <span class="fab-count" x-text="getCartCount()"></span>
</button>

{{-- ══ TOAST ══ --}}
<div class="toast-wrap" id="toastWrap"></div>

{{-- ══ DRAWER OVERLAY ══ --}}
<div class="drawer-overlay" x-show="openDrawer" @click="openDrawer = false"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     style="display:none;"></div>

{{-- ══ CART DRAWER ══ --}}
<div class="drawer" x-show="openDrawer"
     x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
     style="display:none;">

    <div class="drawer-hdr">
        <div>
            <div class="drawer-title">🛒 Keranjang Belanja</div>
            <div class="drawer-subtitle" x-text="getCartCount() + ' item dari ' + getStoreCount() + ' toko'"></div>
        </div>
        <button class="drawer-close" @click="openDrawer = false">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="drawer-body">
        <template x-for="item in cart" :key="item.id">
            <div class="cart-item">
                <div class="cart-thumb">
                    <img :src="item.image" :alt="item.name">
                </div>
                <div class="cart-info">
                    <div class="cart-name" x-text="item.name"></div>
                    <div class="cart-price" x-text="formatRupiah(item.price)"></div>
                    <div class="cart-qty" x-text="'× ' + item.qty + ' porsi'"></div>
                </div>
                <button class="cart-remove" @click="removeFromCart(item.id)" title="Hapus">×</button>
            </div>
        </template>

        <template x-if="cart.length === 0">
            <div class="cart-empty">
                <div class="cart-empty-ico">🛒</div>
                <p>Keranjang masih kosong.<br>Yuk pilih makanan di atas!</p>
            </div>
        </template>
    </div>

    <div class="drawer-footer">
        <div class="drawer-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-val" x-text="formatRupiah(getCartTotal())"></span>
        </div>
        <button class="checkout-btn" @click="directCheckout()" :disabled="cart.length === 0">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Amankan & Bayar Sekarang
        </button>
        <p class="checkout-note">Makanan ini membantu mengurangi food waste 🌿</p>
    </div>
</div>

{{-- ══════════════════
     PAGE CONTENT
══════════════════ --}}
<div class="page">

    {{-- ══ STORE BENTO HEADER ══ --}}
    <div class="store-bento">

        {{-- Identity — big card kiri --}}
        <div class="sb-identity">
            <div>
                <div class="sb-status">
                    <span class="sb-status-dot"></span>
                    Toko Buka
                </div>
                <div class="sb-avatar-wrap">
                    <div class="sb-avatar">{{ substr($seller->name, 0, 2) }}</div>
                    <div class="sb-verified">✅</div>
                </div>
                <div class="sb-name">{{ $seller->name }}</div>
                <div class="sb-desc">Selamat datang! Kami menyediakan berbagai pilihan kuliner lezat yang siap diselamatkan hari ini. Dijamin bersih, lezat, dan dikemas dengan higienis.</div>
            </div>
            <div class="sb-actions" style="margin-top:1.5rem;">
                <button class="sb-btn-follow"
                        :class="isFollowed ? 'following' : 'follow'"
                        @click="isFollowed = !isFollowed"
                        x-text="isFollowed ? '✓ Mengikuti' : '＋ Ikuti'">
                </button>
                <button class="sb-btn-chat" @click="alert('Fitur chat dalam pengembangan!')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Chat
                </button>
            </div>
        </div>

        {{-- Stats card kanan atas --}}
        <div class="sb-stats">
            <div class="sb-stats-grid">
                <div class="sb-stat-item">
                    <div class="sb-stat-num">4.8 <span style="font-size:1rem;">⭐</span></div>
                    <div class="sb-stat-lbl">Rating</div>
                </div>
                <div class="sb-stat-item">
                    <div class="sb-stat-num">{{ count($menus) }}</div>
                    <div class="sb-stat-lbl">Menu Aktif</div>
                </div>
                <div class="sb-stat-item">
                    <div class="sb-stat-num">1.4k</div>
                    <div class="sb-stat-lbl">Pengikut</div>
                </div>
                <div class="sb-stat-item">
                    <div class="sb-stat-num">120+</div>
                    <div class="sb-stat-lbl">Penilaian</div>
                </div>
            </div>
            <div class="sb-divider"></div>
            <div class="sb-location">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <circle cx="12" cy="11" r="3"/>
                </svg>
                Kota Bandung
            </div>
        </div>

        {{-- Visual tracker kanan bawah --}}
        <div class="sb-tracker">
            <div class="sb-tracker-title">📊 Visual Impact Tracker</div>
            <div class="sb-tracker-sub">Dampak lingkungan toko ini</div>
            <div class="sb-tracker-badge">Coming Soon ✦</div>
        </div>
    </div>

    {{-- ══ TICKER ══ --}}
    <div class="ticker-wrap">
        <div class="ticker-track">
            @foreach(range(1,8) as $i)
            <div class="ticker-item">
                <span class="ticker-star">✦</span>
                Selamatkan Makanan Hari Ini
                <span class="ticker-star">✦</span>
                Hemat Lebih Banyak
                <span class="ticker-star">✦</span>
                Kurangi Food Waste
                <span class="ticker-star">✦</span>
                Jaga Bumi Kita
            </div>
            @endforeach
        </div>
    </div>

    {{-- ══ KATALOG HEADER ══ --}}
    <div class="catalog-hdr">
        <div>
            <div class="catalog-label">Menu Tersedia</div>
            <div class="catalog-title">Semua Menu Makanan</div>
            <div class="catalog-count">Menampilkan <strong x-text="products.length"></strong> hidangan terbaik</div>
        </div>
    </div>

    {{-- ══ PRODUCT GRID 4 KOLOM ══ --}}
    <div class="pgrid">
        <template x-for="product in products" :key="product.id">
            <div class="pcard">
                <div class="pcard-img">
                    <img :src="product.image_url" :alt="product.name" loading="lazy">
                    <div class="pcard-img-gradient"></div>

                    {{-- Distance badge --}}
                    <div class="bdg-dist">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span x-text="product.distance + ' km'"></span>
                    </div>

                    {{-- Stock urgency badge --}}
                    <div class="bdg-stock"
                         :class="product.stock === 0 ? 'empty' : product.stock <= 2 ? 'low' : 'ok'"
                         x-text="product.stock === 0 ? 'Habis' : product.stock <= 2 ? 'Sisa ' + product.stock + '!' : product.stock + ' Porsi'">
                    </div>
                </div>

                <div class="pcard-body">
                    <div class="pcard-name" x-text="product.name"></div>

                    <div class="pcard-stock-row">
                        <span class="stock-dot" :class="product.stock === 0 ? 'empty' : product.stock <= 2 ? 'low' : 'ok'"></span>
                        <span x-text="product.stock === 0 ? 'Stok habis' : 'Tersisa ' + product.stock + ' porsi'"></span>
                    </div>

                    <div class="pcard-footer">
                        <div class="pcard-price" x-text="formatRupiah(product.final_price)"></div>
                        <button class="pcard-btn"
                                @click="addToCart(product)"
                                :disabled="product.stock === 0"
                                :class="{ 'added': justAdded === product.id }">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      :d="product.stock === 0
                                          ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'
                                          : justAdded === product.id
                                          ? 'M5 13l4 4L19 7'
                                          : 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'">
                                </path>
                            </svg>
                            <span x-text="product.stock === 0 ? 'Stok Habis' : justAdded === product.id ? 'Ditambahkan!' : 'Masukkan Keranjang'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Empty state --}}
        <template x-if="products.length === 0">
            <div class="empty-state">
                <div class="empty-icon">🍽️</div>
                <div class="empty-title">Belum ada menu hari ini</div>
                <div class="empty-sub">Seller belum mengunggah makanan. Cek lagi nanti ya!</div>
            </div>
        </template>
    </div>

</div>{{-- /.page --}}
</div>{{-- /.alpine scope --}}

{{-- ══════════════════════════════════
     ALPINE.JS — Logika identik asli +
     toast feedback + justAdded state
══════════════════════════════════ --}}
<script>
function storePage() {
    return {
        products: @json($menus),
        cart: [],
        openDrawer: false,
        isFollowed: false,
        justAdded: null,   // id produk yang baru ditambah (untuk feedback visual)

        // ── Init: ambil cart dari localStorage ──
        initCart() {
            this.cart = JSON.parse(localStorage.getItem('foodsave_cart')) || [];
        },

        // ── Tambah ke keranjang ──
        addToCart(product) {
            let item = this.cart.find(i => i.id === product.id);
            if (item) {
                if (item.qty < product.stock) {
                    item.qty++;
                } else {
                    this.showToast('Stok maksimal telah tercapai!', '⚠️');
                    return;
                }
            } else {
                this.cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.final_price,
                    image: product.image_url,
                    store: product.store,
                    qty: 1
                });
            }
            this.saveCart();

            // feedback visual tombol (1.5 detik)
            this.justAdded = product.id;
            setTimeout(() => { this.justAdded = null; }, 1500);

            // toast notifikasi
            this.showToast(product.name + ' ditambahkan ke keranjang', '🛒');

            // buka drawer setelah 400ms
            setTimeout(() => { this.openDrawer = true; }, 400);
        },

        // ── Hapus dari keranjang ──
        removeFromCart(id) {
            this.cart = this.cart.filter(item => item.id !== id);
            this.saveCart();
        },

        // ── Simpan ke localStorage ──
        saveCart() {
            localStorage.setItem('foodsave_cart', JSON.stringify(this.cart));
        },

        // ── Hitung total item ──
        getCartCount() {
            return this.cart.reduce((sum, item) => sum + item.qty, 0);
        },

        // ── Hitung total harga ──
        getCartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        // ── Hitung jumlah toko berbeda di keranjang ──
        getStoreCount() {
            return new Set(this.cart.map(i => i.store)).size;
        },

        // ── Toast notifikasi ──
        showToast(msg, icon = '✓') {
            const wrap = document.getElementById('toastWrap');
            const el = document.createElement('div');
            el.className = 'toast';
            el.innerHTML = `<span class="toast-dot"></span>${icon} ${msg}`;
            wrap.appendChild(el);
            setTimeout(() => { el.style.opacity = '0'; el.style.transition = 'opacity 0.3s'; setTimeout(() => el.remove(), 300); }, 2500);
        },

        // ── Checkout & sinkronisasi ke backend ──
        directCheckout() {
            fetch('{{ route("cart.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: this.cart })
            })
            .then(response => response.json())
            .then(() => {
                window.location.href = '{{ route("dashboard") }}';
            })
            .catch(() => {
                window.location.href = '{{ route("dashboard") }}';
            });
        },

        // ── Format Rupiah ──
        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0
            }).format(number);
        }
    };
}
</script>
</x-app-layout>