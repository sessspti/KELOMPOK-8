<x-app-layout> 
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Familjen+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400;1,700&family=Hanken+Grotesk:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400&display=swap" rel="stylesheet">
<style>
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
    --yellow-400: #facc15;
    --amber-500: #f59e0b;
    --orange-400: #fb923c;
    --orange-500: #f97316;
    --ink: #111917;
    --ink-2: #1e2d26;
    --muted: #4b6358;
    --faint: #8aab9a;
    --white: #ffffff;
    --off-white: #f7fdf9;
    --card-bg: #ffffff;
    --border: rgba(22,163,74,0.15);
    --border-strong: rgba(22,163,74,0.3);
    --shadow-green: 0 4px 24px rgba(34,197,94,0.18);
    --shadow-lift:  0 16px 48px rgba(17,25,23,0.1);
    --r-sm: 12px;
    --r-md: 18px;
    --r-lg: 24px;
    --r-xl: 32px;
    --r-2xl: 48px;
    --r-pill: 999px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    font-family: 'Hanken Grotesk', system-ui, sans-serif;
    background: var(--off-white);
    color: var(--ink);
    min-height: 100vh;
    overflow-x: hidden;
}

/* ─── NOISE TEXTURE ─── */
body::after {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.025;
    pointer-events: none;
    z-index: 9999;
}

/* ══════════════════════════════════
   HEADER
══════════════════════════════════ */
.hdr {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--white); /* Removed semi-transparent/blur background */
    border-bottom: 1px solid var(--border);
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}
.hdr-inner {
    max-width: 1380px;
    margin: 0 auto;
    padding: 0 2rem;
    height: 72px; /* Reduced from 90px */
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.logo {
    font-weight: 700;
    font-size: 1.4rem;
    color: var(--ink);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
}
.logo-text-save { color: var(--mint-600); }

.hdr-search {
    flex: 1;
    max-width: 420px;
    position: relative;
    display: none;
}
@media(min-width:768px){.hdr-search{display:block}}
.hdr-search input {
    width: 100%;
    background: var(--mint-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r-pill);
    padding: 0.5rem 1.1rem 0.5rem 2.5rem; /* Reduced from 0.6rem */
    font-family: 'Hanken Grotesk', sans-serif;
    font-size: 0.875rem;
    color: var(--ink);
    outline: none;
    transition: all 0.22s;
}
.hdr-search input:focus {
    border-color: var(--mint-400);
    background: var(--white);
    box-shadow: 0 0 0 4px rgba(74,222,128,0.15);
}
.hdr-search input::placeholder { color: var(--faint); }
.hdr-search-ico {
    position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
    color: var(--faint); width: 15px; height: 15px; pointer-events: none;
}

.hdr-right { margin-left: auto; display: flex; align-items: center; gap: 0.75rem; }
.pts-pill {
    background: var(--yellow-300);
    color: #78350f;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 0.8125rem;
    padding: 0.45rem 1.1rem;
    border-radius: var(--r-pill);
    letter-spacing: -0.01em;
    white-space: nowrap;
    border: 2px solid rgba(0,0,0,0.08);
}

/* ══════════════════════════════════
   FAB CART
══════════════════════════════════ */
.fab {
    position: fixed;
    bottom: 2rem; right: 2rem;
    z-index: 200;
    background: var(--ink);
    color: var(--white);
    text-decoration: none;
    padding: 0.9rem 1.5rem;
    border-radius: var(--r-pill);
    display: flex; align-items: center; gap: 0.6rem;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 0.9375rem;
    letter-spacing: -0.02em;
    box-shadow: 0 8px 32px rgba(17,25,23,0.28);
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    border: 2px solid transparent;
}
.fab:hover {
    background: var(--mint-500);
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 16px 40px rgba(34,197,94,0.35);
}
.fab-num {
    background: var(--mint-400);
    color: var(--ink);
    font-size: 0.7rem;
    font-weight: 800;
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ══════════════════════════════════
   HERO BENTO
══════════════════════════════════ */
.page { max-width: 1380px; margin: 0 auto; padding: 0 2rem 8rem; }

.hero-bento {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 1rem;
    margin-top: 2rem;
}
@media(max-width:900px){.hero-bento{grid-template-columns:1fr}}

.bento-main {
    grid-row: 1 / 3;
    background: var(--mint-400);
    border-radius: var(--r-2xl);
    padding: 3rem 3rem 2.5rem;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 480px;
}
.bento-main::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 320px; height: 320px;
    background: var(--lime-400);
    border-radius: 50%;
    opacity: 0.35;
}
.bento-main::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -40px;
    width: 220px; height: 220px;
    background: var(--mint-200);
    border-radius: 50%;
    opacity: 0.5;
}
.bento-eyebrow {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.6875rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--green-800);
    margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 8px;
    position: relative; z-index: 1;
}
.bento-eyebrow-dot { width: 6px; height: 6px; background: var(--green-800); border-radius: 50%; }
.bento-heading {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: clamp(2.25rem, 4vw, 3.25rem);
    line-height: 1.0;
    letter-spacing: -0.05em;
    color: var(--ink);
    margin-bottom: 2.5rem;
    position: relative; z-index: 1;
}
.bento-heading em {
    font-style: italic;
    font-family: 'Familjen Grotesk', sans-serif;
    color: var(--green-900);
}
.bento-stats {
    display: flex; gap: 0.75rem;
    position: relative; z-index: 1;
}
.stat-chip {
    background: rgba(255,255,255,0.65);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: var(--r-lg);
    padding: 1rem 1.25rem;
    backdrop-filter: blur(8px);
    flex: 1;
    transition: transform 0.2s;
}
.stat-chip:hover { transform: translateY(-2px); }
.stat-num {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    letter-spacing: -0.05em;
    color: var(--ink);
    line-height: 1;
}
.stat-unit { font-size: 0.75rem; font-weight: 500; color: var(--green-800); letter-spacing: 0.04em; }
.stat-lbl {
    font-size: 0.6rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--muted);
    margin-top: 3px;
}

.bento-img-card {
    background: var(--card-bg);
    border-radius: var(--r-xl);
    overflow: hidden;
    border: 1.5px solid var(--border);
    position: relative;
}
.bento-img-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    min-height: 220px;
    transition: transform 6s ease;
}
.bento-img-card:hover img { transform: scale(1.04); }

.bento-tracker {
    background: var(--lime-300);
    border-radius: var(--r-xl);
    border: 2px dashed rgba(22,101,52,0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    min-height: 140px;
}
.bento-tracker-label {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 0.8125rem;
    color: var(--green-800);
    letter-spacing: 0.03em;
}
.bento-tracker-sub {
    font-size: 0.75rem;
    color: var(--green-900);
    opacity: 0.6;
}

/* ══════════════════════════════════
   TICKER
══════════════════════════════════ */
.ticker-wrap {
    margin: 1.25rem 0;
    background: var(--ink);
    border-radius: var(--r-pill);
    overflow: hidden;
    padding: 0.75rem 0;
}
.ticker-track {
    display: flex;
    width: max-content;
    animation: scroll-ticker 22s linear infinite;
}
@keyframes scroll-ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.ticker-item {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0 2rem;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--mint-300);
    white-space: nowrap;
}
.ticker-star { color: var(--yellow-300); font-size: 14px; }

/* ══════════════════════════════════
   SECTION CHROME
══════════════════════════════════ */
.sec { padding: 4rem 0; }
.sec-hdr {
    display: flex; align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2.5rem;
    gap: 1rem;
}
.sec-label {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--mint-600);
    margin-bottom: 0.5rem;
    display: flex; align-items: center; gap: 6px;
}
.sec-label-dot { width: 5px; height: 5px; background: var(--mint-500); border-radius: 50%; }
.sec-title {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    letter-spacing: -0.05em;
    color: var(--ink);
    line-height: 1;
}
.sec-sub { font-size: 0.875rem; color: var(--muted); margin-top: 0.375rem; }

.arrow-row { display: flex; gap: 0.5rem; }
.arr-btn {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1.5px solid var(--border-strong);
    background: var(--white);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
    font-size: 1rem;
    transition: all 0.2s;
}
.arr-btn:hover { background: var(--ink); color: var(--white); border-color: var(--ink); }

/* ══════════════════════════════════
   PRODUCT GRID
══════════════════════════════════ */
.pgrid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
@media(max-width:1100px){.pgrid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){.pgrid{grid-template-columns:1fr}}

/* ─── PRODUCT CARD ─── */
.pcard {
    background: var(--card-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s, border-color 0.2s;
    position: relative;
}
.pcard:hover {
    transform: translateY(-8px) rotate(-0.4deg);
    box-shadow: var(--shadow-lift), 0 0 0 2px var(--mint-300);
    border-color: var(--mint-300);
}

.pcard-img { position: relative; height: 220px; overflow: hidden; background: var(--mint-50); }
.pcard-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.7s ease;
}
.pcard:hover .pcard-img img { transform: scale(1.08); }

.bdg-dist {
    position: absolute; top: 0.75rem; left: 0.75rem;
    background: rgba(255,255,255,0.93);
    border: 1.5px solid rgba(22,163,74,0.2);
    border-radius: var(--r-pill);
    padding: 0.25rem 0.65rem;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.6rem; font-weight: 700;
    color: var(--mint-700);
    letter-spacing: 0.07em;
    display: flex; align-items: center; gap: 4px;
    backdrop-filter: blur(8px);
}
.bdg-dist svg { width: 10px; height: 10px; }

.bdg-urgent {
    position: absolute; top: 0.75rem; right: 0.75rem;
    background: var(--orange-500);
    color: #fff;
    border-radius: var(--r-sm);
    padding: 0.2rem 0.6rem;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.6rem; font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    animation: urgnt-pulse 1.8s ease-in-out infinite;
}
@keyframes urgnt-pulse {
    0%,100%{box-shadow:0 0 0 0 rgba(249,115,22,0.45)}
    60%{box-shadow:0 0 0 7px rgba(249,115,22,0)}
}

.pcard-body { padding: 1.125rem 1.25rem 1.375rem; }
.pcard-store {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--mint-600); margin-bottom: 0.3rem;
}
.pcard-name {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700; font-size: 1.0625rem;
    letter-spacing: -0.03em; line-height: 1.15;
    color: var(--ink); margin-bottom: 1.1rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.pcard-ft { display: flex; align-items: center; justify-content: space-between; }
.price-was { font-size: 0.75rem; color: var(--faint); text-decoration: line-through; margin-bottom: 1px; }
.price-now {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700; font-size: 1.3125rem;
    letter-spacing: -0.04em; color: var(--mint-600); line-height: 1;
}
.add-btn {
    background: var(--mint-400);
    border: none; border-radius: var(--r-md);
    width: 46px; height: 46px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
    transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 4px 14px rgba(74,222,128,0.35);
}
.add-btn:hover { background: var(--mint-500); transform: scale(1.14) rotate(10deg); box-shadow: 0 8px 22px rgba(34,197,94,0.45); }
.add-btn:active { transform: scale(0.94); }
.add-btn svg { width: 22px; height: 22px; color: #fff; }

/* ─── STATUS BADGE ─── */
.bdg-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 0.35rem 0.85rem;
    border-radius: var(--r-pill);
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}
.bdg-status.tersedia {
    background: var(--mint-100);
    color: var(--mint-700);
}
.bdg-status.tutup {
    background: #fed7aa;
    color: #92400e;
}
.bdg-status.habis {
    background: #fecaca;
    color: #dc2626;
}

/* ══════════════════════════════════
   DIVIDER
══════════════════════════════════ */
.divider {
    border: none;
    height: 1.5px;
    background: linear-gradient(to right, transparent, var(--mint-200) 20%, var(--mint-200) 80%, transparent);
    margin: 0;
}

/* ══════════════════════════════════
   EDUCATION
══════════════════════════════════ */
.edu-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-top: 2.5rem;
}
@media(max-width:900px){.edu-grid{grid-template-columns:1fr}}

.edu-card { cursor: pointer; display: flex; flex-direction: column; gap: 0.875rem; }
.edu-img-wrap {
    border-radius: var(--r-xl);
    overflow: hidden;
    height: 200px;
    background: var(--mint-100);
    position: relative;
}
.edu-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.55s ease;
}
.edu-card:hover .edu-img-wrap img { transform: scale(1.06); }

.edu-tag {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.5625rem; font-weight: 800;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--mint-600);
    display: flex; align-items: center; gap: 5px;
}
.edu-tag::before { content:''; width: 10px; height: 1.5px; background: var(--mint-500); }

.edu-title {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700; font-size: 1.0rem;
    letter-spacing: -0.03em; line-height: 1.3;
    color: var(--ink);
    transition: color 0.2s;
}
.edu-card:hover .edu-title { color: var(--mint-700); }

.edu-desc { font-size: 0.8125rem; color: var(--muted); line-height: 1.65; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

.edu-empty {
    border-radius: var(--r-xl);
    border: 2px dashed var(--mint-200);
    background: var(--mint-50);
    display: flex; align-items: center; justify-content: center;
    flex-direction: column; gap: 0.75rem;
    padding: 2.5rem 2rem; text-align: center;
    min-height: 200px;
}
.edu-empty-ico {
    width: 38px; height: 38px;
    background: var(--mint-100);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--mint-500);
}
.edu-empty-ico svg { width: 18px; height: 18px; }
.edu-empty p { font-size: 0.8125rem; color: var(--faint); font-style: italic; line-height: 1.6; }

.see-all {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.8125rem; font-weight: 700;
    color: var(--mint-600); text-decoration: none;
    letter-spacing: -0.01em;
    border-bottom: 2px solid var(--mint-300);
    padding-bottom: 2px;
    display: flex; align-items: center; gap: 5px;
    transition: all 0.2s;
}
.see-all:hover { color: var(--mint-700); border-color: var(--mint-500); gap: 8px; }
.see-all svg { width: 14px; height: 14px; }

/* ══════════════════════════════════
   ANIMATIONS
══════════════════════════════════ */
@keyframes fadeUp {
    from { opacity:0; transform: translateY(24px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ─── TRANSACTION TABLE ─── */
.tx-table-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    margin-top: 2rem;
}
.tx-table { width: 100%; border-collapse: collapse; }
.tx-table th {
    background: var(--mint-50);
    padding: 1rem 1.5rem;
    text-align: left;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--mint-600);
    border-bottom: 1.5px solid var(--border);
}
.tx-table td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
}
.tx-table tr:last-child td { border-bottom: none; }
.tx-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.35rem 0.85rem;
    border-radius: var(--r-pill);
    font-size: 0.75rem;
    font-weight: 700;
}
.tx-status.selesai { background: var(--mint-100); color: var(--mint-700); }
.tx-status.proses { background: #fee2e2; color: #dc2626; }
.tx-status::before { content:''; width:6px; height:6px; border-radius:50%; background:currentColor; }

.btn-action {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: var(--faint);
    color: #fff;
    border: none;
    cursor: not-allowed;
    transition: all 0.2s;
}
.btn-action.active {
    background: var(--mint-500);
    cursor: pointer;
}
.btn-action.active:hover {
    background: var(--mint-600);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(34,197,94,0.3);
}


.bento-main    { animation: fadeUp 0.6s ease 0.05s both; }
.bento-img-card{ animation: fadeUp 0.6s ease 0.1s  both; }
.bento-tracker { animation: fadeUp 0.6s ease 0.15s both; }
.pcard:nth-child(1){ animation: fadeUp 0.5s ease 0.05s both; }
.pcard:nth-child(2){ animation: fadeUp 0.5s ease 0.12s both; }
.pcard:nth-child(3){ animation: fadeUp 0.5s ease 0.19s both; }
.pcard:nth-child(4){ animation: fadeUp 0.5s ease 0.26s both; }
.edu-card:nth-child(1){ animation: fadeUp 0.5s ease 0.05s both; }
.edu-card:nth-child(2){ animation: fadeUp 0.5s ease 0.12s both; }
.edu-card:nth-child(3){ animation: fadeUp 0.5s ease 0.19s both; }
</style>

<div x-data="foodSaveApp()">
{{-- ── FAB CART ── --}}
<button class="fab" id="fabBtn" onclick="openCart()" style="border:none;cursor:pointer;">
    <svg width="19" height="19" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Daftar Pengambilan
    <span class="fab-num" id="fabCount" style="animation:fab-pulse 2.5s ease-in-out infinite;">3</span>
</button>
<style>
@keyframes fab-pulse{0%,100%{box-shadow:0 0 0 0 rgba(74,222,128,0.5)}50%{box-shadow:0 0 0 7px rgba(74,222,128,0)}}
.fab-num{animation:fab-pulse 2.5s ease-in-out infinite;}
</style>

{{-- ── HEADER ── --}}
<header class="hdr">
    <div class="hdr-inner">
        <a href="{{ route('sosial.dashboard') }}" class="logo">
            <img src="{{ asset('images/logo-foodsave.png') }}" alt="FoodSave" class="h-14 w-auto object-contain">
            <span class="font-bold text-xl tracking-tight text-gray-900">Food<span class="text-green-600">Save</span></span>
        </a>
        <span style="background:#e0f2fe;color:#0284c7;border:1.5px solid rgba(14,165,233,0.25);font-family:'Space Grotesk',sans-serif;font-size:0.6875rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.85rem;border-radius:999px;white-space:nowrap;">🏛 Lembaga Sosial</span>
        <div class="hdr-search">
            <svg class="hdr-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari donasi surplus tersedia..." x-model="searchQuery">
        </div>
        <div class="hdr-right">
            {{-- Map Dropdown Filter --}}
            <div class="relative flex items-center mr-2" x-data="{ openMap: false }" @click.outside="openMap = false">
                <button @click="openMap = !openMap" class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-full hover:bg-gray-50 hover:border-gray-300 transition-all focus:outline-none shadow-sm text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ request('kota') ? ucfirst(request('kota')) : 'Semua Kota' }}</span>
                    <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" :class="{'rotate-180': openMap}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openMap" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 top-full mt-2 w-44 bg-white border border-gray-100 rounded-lg shadow-lg z-[130] py-1 max-h-64 overflow-y-auto"
                     style="display: none;">
                    
                    <a href="{{ url()->current() }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                        🌍 Semua Kota
                    </a>
                    @foreach(\App\Models\User::getCities() as $key => $city)
                        <a href="{{ url()->current() }}?kota={{ $key }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                            {{ $city['emoji'] }} {{ $city['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

        <!-- NOTIF -->
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
            {{-- Profile Dropdown --}}
            <div class="relative ml-2" x-data="{ open: false }" @click.outside="open = false" style="z-index: 110;">

                {{-- Tombol Avatar --}}
                <button @click="open = !open" class="flex items-center gap-2.5 px-2.5 py-1.5 bg-white border border-gray-100 rounded-2xl hover:bg-blue-50 hover:border-blue-200 transition-all focus:outline-none shadow-sm hover:shadow-md group">
                    {{-- Foto Profil --}}
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-cyan-200 border-2 border-blue-300 flex items-center justify-center text-blue-700 font-extrabold text-sm overflow-hidden shadow-sm transition-all duration-300 group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_0_3px_rgba(14,165,233,0.25)]">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->name ?? 'L', 0, 1)) }}
                            @endif
                        </div>
                        {{-- Online dot --}}
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-blue-400 border-2 border-white rounded-full"></span>
                    </div>
                    {{-- Nama User --}}
                    <div class="text-sm font-bold text-gray-700 max-w-[100px] truncate">{{ Auth::user()->name ?? 'Lembaga' }}</div>
                    <svg class="fill-current h-3.5 w-3.5 text-gray-400 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                

                {{-- Dropdown Menu --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 z-[120] mt-2 w-64 rounded-2xl shadow-xl bg-white border border-gray-100 overflow-hidden origin-top-right"
                     style="display: none;">

                    {{-- Profile Card Header --}}
                    <div class="px-4 py-4 border-b border-blue-100" style="background: linear-gradient(135deg, #eff6ff 0%, #ecfeff 100%);">
                        <div class="flex items-center gap-3">
                            {{-- Foto Profil Besar --}}
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-200 to-cyan-300 flex items-center justify-center text-blue-700 font-black text-lg overflow-hidden flex-shrink-0 shadow-md" style="border: 3px solid #fff;">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name ?? 'L', 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-gray-800 truncate">{{ Auth::user()->name ?? 'Lembaga' }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                                <span class="inline-flex items-center gap-1 mt-0.5 text-[9px] font-bold text-blue-700 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                                    🏛 Lembaga Sosial
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Menu Items --}}
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors font-medium">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Edit Profil
                        </a>
                        <a href="{{ route('transaction.history') }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors font-medium">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Riwayat Transaksi
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



<div class="page">

    {{-- ── HERO BENTO ── --}}
    <section class="hero-bento">
        <div class="bento-main">
            <div>
                <p class="bento-eyebrow">
                    <span class="bento-eyebrow-dot"></span>
                    Kontribusi Sosial & Lingkungan
                </p>
                <h1 class="bento-heading">
                    "Bersama<br><em>salurkan</em><br>kebaikan<br>lewat makan."
                </h1>
            </div>
            <div class="bento-stats">
                <div class="stat-chip">
                    <div class="stat-num">248 <span class="stat-unit">Kg</span></div>
                    <div class="stat-lbl">Makanan Tersalurkan</div>
                </div>
                <div class="stat-chip">
                    <div class="stat-num">3.2 <span class="stat-unit">Kg</span></div>
                    <div class="stat-lbl">CO₂ Dikurangi</div>
                </div>
            </div>
        </div>

        <div class="bento-img-card">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=700" alt="Volunteers distributing food">
        </div>

        <div class="bento-tracker">
            <div class="bento-tracker-label">📊 Visual Impact Tracker</div>
            <div class="bento-tracker-sub">Laporan transparansi untuk donatur</div>
            <div style="margin-top:6px;background:rgba(22,101,52,0.12);border:1px solid rgba(22,101,52,0.2);border-radius:999px;padding:3px 10px;font-size:0.5625rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#166534;">Coming Soon ✦</div>
        </div>
    </section>

    {{-- ── TICKER ── --}}
    <div class="ticker-wrap">
        <div class="ticker-track">
            @foreach(range(1,8) as $i)
            <div class="ticker-item">
                <span class="ticker-star">✦</span>
                Bersama Akhiri Kelaparan
                <span class="ticker-star">✦</span>
                Kurangi Limbah Makanan
                <span class="ticker-star">✦</span>
                Salurkan Senyuman Lewat Makanan
                <span class="ticker-star">✦</span>
                Jaga Bumi Kita
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── RESCUE DEALS ── --}}
    <section class="sec">
        <div class="sec-hdr">
            <div>
                <p class="sec-label"><span class="sec-label-dot"></span> Siap Disalurkan</p>
                <h2 class="sec-title">Ketersediaan Donasi Surplus</h2>
                <p class="sec-sub">Makanan surplus dari mitra restoran, siap diambil dan disalurkan kepada yang membutuhkan.</p>
            </div>
            <div class="arrow-row">
                <button class="arr-btn" aria-label="Sebelumnya">←</button>
                <button class="arr-btn" aria-label="Berikutnya">→</button>
            </div>
        </div>

        <style>
        .bdg-gratis{position:absolute;bottom:.75rem;left:.75rem;background:#22c55e;color:#fff;border-radius:999px;padding:.2rem .75rem;font-family:'Space Grotesk',sans-serif;font-size:.6rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;}
        .bdg-donasi{position:absolute;bottom:.75rem;left:.75rem;background:#0284c7;color:#fff;border-radius:999px;padding:.2rem .75rem;font-family:'Space Grotesk',sans-serif;font-size:.6rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;}
        .pcard-qty{font-size:.8125rem;color:var(--muted);margin-bottom:1rem;}
        .price-tag{display:inline-flex;align-items:center;gap:5px;font-family:'Space Grotesk',sans-serif;font-weight:800;font-size:1.0625rem;letter-spacing:-.04em;line-height:1;}
        .price-tag.gratis{color:var(--mint-600);}
        .price-tag.donasi{color:#0284c7;}
        .price-tag svg{width:15px;height:15px;}
        .req-btn{background:var(--mint-400);border:none;border-radius:var(--r-md);padding:.6rem 1rem;display:flex;align-items:center;gap:5px;cursor:pointer;flex-shrink:0;transition:all .25s cubic-bezier(.34,1.56,.64,1);box-shadow:0 4px 14px rgba(74,222,128,.35);font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.75rem;color:var(--ink);letter-spacing:-.01em;white-space:nowrap;}
        .req-btn:hover{background:var(--mint-500);color:#fff;transform:scale(1.05);}
        .req-btn svg{width:15px;height:15px;}
        .loc-pill{display:inline-flex;align-items:center;gap:5px;font-size:.6875rem;color:var(--muted);background:var(--mint-50);border:1px solid var(--border);border-radius:var(--r-pill);padding:.2rem .65rem;margin-top:.5rem;}
        .loc-pill svg{width:11px;height:11px;color:var(--mint-600);}
        </style>
        
        <div class="pgrid">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="pcard">
                    <div class="pcard-img">
                        <template x-if="product.image_url">
                            <img :src="product.image_url" :alt="product.name">
                        </template>
                        <template x-if="!product.image_url">
                            <div class="flex items-center justify-center h-full bg-mint-100">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48" style="opacity:0.4;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </template>
                        {{-- OVERLAY TOKO TUTUP / DITANGGUHKAN --}}
                            <template x-if="product.store_is_suspended == 1">
                                <div class="absolute inset-0 z-10 flex items-center justify-center pointer-events-none" style="background: rgba(17, 25, 23, 0.55); backdrop-filter: blur(1px);">
                                    <div style="background: #dc2626; color: white; padding: 0.4rem 1rem; border-radius: 999px; font-family: 'Space Grotesk', sans-serif; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3); text-align: center;">
                                        Toko Tutup
                                    </div>
                                </div>
                            </template>
                            <template x-if="product.store_is_open == 0 && !product.store_is_suspended">
                                <div class="absolute inset-0 z-10 flex items-center justify-center pointer-events-none" style="background: rgba(17, 25, 23, 0.4); backdrop-filter: blur(1px);">
                                    <div style="background: #ef4444; color: white; padding: 0.4rem 1rem; border-radius: 999px; font-family: 'Space Grotesk', sans-serif; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                                        Toko Tutup
                                    </div>
                                </div>
                            </template>
                        <div class="bdg-dist">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            0.5 km
                        </div>
                        <template x-if="product.discount > 50">
                            <div class="bdg-urgent">Sangat Murah!</div>
                        </template>
                        <div class="bdg-gratis">Gratis</div>
                    </div>
                    <div class="pcard-body">
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px; flex-wrap: wrap;">
                            <a :href="'/store/' + product.user_id" class="pcard-store hover:underline hover:text-mint-700 transition-colors" x-text="product.store"></a>
                            <template x-if="product.city_name">
                                <span style="font-size: 0.65rem; font-weight: 700; color: #9ca3af; display: inline-flex; align-items: center; gap: 2px; text-transform: none; letter-spacing: normal; margin-bottom: 0.3rem;">
                                    • <span x-text="product.city_name"></span>
                                </span>
                            </template>
                        </div>
                        <h3 class="pcard-name" x-text="product.name"></h3>
                        
                        {{-- Rating Badge --}}
                        <div @click="openReviewModal(product)" class="hover:bg-gray-100 cursor-pointer transition-colors" style="display: flex; align-items: center; gap: 4px; margin-top: -8px; margin-bottom: 12px; background-color: #f9fafb; padding: 4px 8px; border-radius: 6px; border: 1px solid #f3f4f6; width: fit-content;">
                            <span style="color: #fbbf24; font-size: 13px;">⭐</span>
                            <span style="font-size: 12px; font-weight: 700; color: #374151;" x-text="product.reviews_avg_rating > 0 ? parseFloat(product.reviews_avg_rating).toFixed(1) : '0.0'"></span>
                            <span style="font-size: 11px; color: #6b7280; margin-left: 2px;" x-text="'(' + (product.reviews_count || 0) + ' Ulasan)'"></span>
                        </div>

                        

                        <div class="flex items-center gap-1.5 mb-2" style="display:flex;align-items:center;gap:6px;margin-bottom:8px;font-size: 0.75rem; color: var(--orange-500); font-weight: 600;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/>
                            </svg>
                            <span x-text="'Exp: ' + product.formatted_expiry_date"></span>
                        </div>
                        <p class="pcard-qty" x-text="'Tersedia ' + product.stock + ' porsi'"></p>
                        <div class="pcard-ft">
                            <div class="price-stack">
                                <div class="price-was" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(product.price)"></div>
                                <div class="price-now">Rp 0</div>
                            </div>
                            {{-- Button untuk Lembaga (disabled jika toko tutup) --}}
                            <template x-if="product.store_is_open == 1">
                                <button class="req-btn" @click="if (product.store_is_suspended == 1) { Swal.fire({ icon: 'error', title: 'Toko Ditangguhkan', text: 'Toko ini sedang Tutup. Tidak bisa mengajukan pengambilan dari toko ini.', confirmButtonColor: '#ef4444' }); return; } openCart(); addItemToPickup({
                                    id: product.id,
                                    name: product.name,
                                    store: product.store,
                                    stock: product.stock,
                                    price: 'Rp 0',
                                    image: product.image_url,
                                    urgent: product.discount > 50 ? 'Sangat Murah!' : 'Hari Ini',
                                    store_is_suspended: product.store_is_suspended
                                })" aria-label="Ajukan pengambilan">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                                    </svg>
                                    Ajukan
                                </button>
                            </template>

                            {{-- Button disabled untuk Lembaga (jika toko tutup) --}}
                            <template x-if="product.store_is_open == 0">
                                <button class="req-btn" disabled style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed; opacity: 0.6;" aria-label="Toko Tutup">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Tutup
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <div x-show="filteredProducts.length === 0" class="text-center py-20" style="grid-column: 1 / -1; width: 100%;">
            <p style="color: var(--muted); font-style: italic;">Maaf, donasi tidak ditemukan...</p>
        </div>
    </section>


    {{-- ── EDUCATION ── --}}
    <section class="sec">
        <div class="sec-hdr">
            <div>
                <p class="sec-label"><span class="sec-label-dot"></span> Panduan Operasional</p>
                <h2 class="sec-title">Edukasi & Lingkungan</h2>
            </div>
            <a href="#" class="see-all">
                Lihat Semua Artikel
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="edu-grid">
            <div class="edu-card">
                <div class="edu-img-wrap">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" alt="Tips Penyimpanan">
                </div>
                <span class="edu-tag">Keamanan Pangan</span>
                <h3 class="edu-title">Prosedur Keamanan Pangan (Food Safety) untuk Makanan Surplus</h3>
                <p class="edu-desc">Panduan lengkap memeriksa kelayakan makanan surplus sebelum didistribusikan kepada penerima manfaat agar tetap aman dikonsumsi.</p>
            </div>

            <div class="edu-card">
                <div class="edu-img-wrap">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=500" alt="Global Issue">
                </div>
                <span class="edu-tag" style="color:#0284c7;">Panduan Distribusi</span>
                <h3 class="edu-title">Cara Mendistribusikan Makanan Cepat Saji agar Tetap Layak Konsumsi</h3>
                <p class="edu-desc">Teknik pengemasan, transportasi, dan batas waktu distribusi makanan cepat saji yang aman dari dapur restoran ke tangan penerima.</p>
            </div>

            <div class="edu-empty">
                <div class="edu-empty-ico">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <p>Artikel lainnya sedang disiapkan oleh Admin kami...</p>
            </div>
        </div>
    </section>

    {{-- ══ REVIEW MODAL ══ --}}
    <div class="fixed inset-0 z-[500] flex items-center justify-center p-4" x-show="showReviewModal" style="display:none; pointer-events: none;">
        <div class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl flex flex-col" 
             style="max-height: 85vh; pointer-events: auto;"
             @click.stop
             x-show="showReviewModal"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95 translate-y-4" x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100 translate-y-0" x-transition:leave-end="opacity-0 transform scale-95 translate-y-4">
            
            <div class="p-6 border-b border-gray-100 flex items-center justify-between flex-shrink-0 relative overflow-hidden rounded-t-[2rem]">
                <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-emerald-50 z-0"></div>
                <div class="relative z-10">
                    <h3 class="text-xl font-black text-gray-900 tracking-tight" x-text="activeProduct ? 'Ulasan ' + activeProduct.name : 'Ulasan'"></h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-yellow-400 font-bold text-sm">⭐ <span x-text="activeProduct && activeProduct.reviews_avg_rating > 0 ? parseFloat(activeProduct.reviews_avg_rating).toFixed(1) : '0.0'"></span></span>
                        <span class="text-xs text-gray-500 font-medium" x-text="'• ' + (activeProduct ? (activeProduct.reviews_count || 0) : 0) + ' Penilaian'"></span>
                    </div>
                </div>
                <button @click="showReviewModal = false" class="relative z-10 w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1 bg-gray-50/50">
                <template x-if="activeReviews && activeReviews.length > 0">
                    <div class="space-y-4">
                        <template x-for="review in activeReviews" :key="review.id">
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center font-bold text-gray-500 text-sm overflow-hidden border border-gray-200">
                                            <template x-if="review.user && review.user.avatar">
                                                <img :src="'/storage/' + review.user.avatar" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!review.user || !review.user.avatar">
                                                <span x-text="review.user ? review.user.name.substring(0,2).toUpperCase() : '??'"></span>
                                            </template>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm" x-text="review.user ? review.user.name : 'Pengguna'"></div>
                                            <div class="text-[11px] text-gray-400 font-medium" x-text="new Date(review.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></div>
                                        </div>
                                    </div>
                                    <div class="flex gap-0.5">
                                        <template x-for="i in 5">
                                            <svg class="w-4 h-4" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        </template>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed mb-3" x-text="review.comment || 'Tidak ada teks ulasan.'"></p>
                                
                                <template x-if="review.photo_path">
                                    <div class="mt-3 rounded-xl overflow-hidden border border-gray-100 bg-gray-50">
                                        <img :src="'/storage/' + review.photo_path" class="w-full h-auto max-h-48 object-cover cursor-pointer hover:opacity-90 transition-opacity" @click="window.open('/storage/' + review.photo_path, '_blank')">
                                    </div>
                                </template>

                                {{-- Menampilkan balasan seller jika ada --}}
                                <template x-if="review.merchant_reply">
                                    <div class="mt-4 bg-green-50 rounded-lg p-3 border-l-4 border-green-500 text-sm">
                                        <div class="font-bold text-green-700 mb-1">Balasan Seller:</div>
                                        <div class="text-green-800" x-text="review.merchant_reply"></div>
                                        <template x-if="review.replied_at">
                                            <div class="text-xs text-green-600 mt-1" x-text="new Date(review.replied_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="!activeReviews || activeReviews.length === 0">
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">📝</div>
                        <h4 class="text-gray-900 font-bold mb-1">Belum Ada Ulasan</h4>
                        <p class="text-gray-500 text-sm max-w-xs mx-auto">Jadilah yang pertama untuk mencoba dan memberikan ulasan pada menu ini!</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>

{{-- ══ SIDEBAR OVERLAY ══ --}}
<div id="sidebarOverlay" onclick="closeCart()" style="position:fixed;inset:0;background:rgba(17,25,23,.45);z-index:400;opacity:0;pointer-events:none;transition:opacity .3s ease;backdrop-filter:blur(4px);"></div>

{{-- ══ SIDEBAR ══ --}}
<div id="sidebar" style="position:fixed;top:0;right:0;bottom:0;width:min(420px,100vw);background:#fff;z-index:500;transform:translateX(100%);transition:transform .4s cubic-bezier(.25,.46,.45,.94);display:flex;flex-direction:column;border-left:1.5px solid var(--border);box-shadow:-8px 0 48px rgba(17,25,23,.12);">
    <div style="padding:1.5rem 1.75rem 1.25rem;border-bottom:1.5px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;flex-shrink:0;">
        <div>
            <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1.125rem;letter-spacing:-.04em;color:var(--ink);">Daftar Pengambilan</div>
            <div style="font-size:.8125rem;color:var(--muted);margin-top:2px;">Ringkasan donasi yang akan diambil kurir</div>
        </div>
        <button onclick="closeCart()" style="width:36px;height:36px;border-radius:12px;border:1.5px solid var(--border);background:var(--off-white);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--muted);flex-shrink:0;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="sidebarBody" style="flex:1;overflow-y:auto;padding:1.25rem 1.75rem;">
        <div class="pickup-itm" style="background:var(--off-white);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:1.125rem 1.25rem;margin-bottom:.875rem;position:relative;">
            <button onclick="removeItem(this)" style="position:absolute;top:.875rem;right:.875rem;width:26px;height:26px;border-radius:50%;border:1px solid rgba(0,0,0,.08);background:#fff;cursor:pointer;color:var(--faint);font-size:14px;display:flex;align-items:center;justify-content:center;">×</button>
            <div style="display:flex;gap:.75rem;margin-bottom:.875rem;">
                <div style="width:52px;height:52px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--mint-100);"><img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=200" style="width:100%;height:100%;object-fit:cover;"></div>
                <div>
                    <div style="font-size:.5625rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mint-600);margin-bottom:3px;">Resto Ayam Berkah</div>
                    <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9375rem;letter-spacing:-.03em;color:var(--ink);">Paket Ayam Geprek Surplus</div>
                    <div style="font-size:.8125rem;color:var(--muted);margin-top:3px;">12 porsi · Gratis</div>
                </div>
            </div>
            <div style="background:var(--mint-50);border:1px solid var(--border);border-radius:12px;padding:.625rem .875rem;display:flex;align-items:flex-start;gap:7px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;color:var(--mint-600);margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                <div>
                    <div style="font-size:.5625rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--mint-600);">Lokasi Pick-up</div>
                    <div style="font-size:.8125rem;color:var(--ink);font-weight:500;margin-top:1px;">Jl. Margonda Raya No. 12, Depok</div>
                    <div style="font-size:.75rem;color:var(--orange-500);font-weight:600;margin-top:3px;">⏰ Ambil sebelum pukul 20.00 WIB</div>
                </div>
            </div>
        </div>
        <div class="pickup-itm" style="background:var(--off-white);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:1.125rem 1.25rem;margin-bottom:.875rem;position:relative;">
            <button onclick="removeItem(this)" style="position:absolute;top:.875rem;right:.875rem;width:26px;height:26px;border-radius:50%;border:1px solid rgba(0,0,0,.08);background:#fff;cursor:pointer;color:var(--faint);font-size:14px;display:flex;align-items:center;justify-content:center;">×</button>
            <div style="display:flex;gap:.75rem;margin-bottom:.875rem;">
                <div style="width:52px;height:52px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--mint-100);"><img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=200" style="width:100%;height:100%;object-fit:cover;"></div>
                <div>
                    <div style="font-size:.5625rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mint-600);margin-bottom:3px;">Katering Berkah</div>
                    <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9375rem;letter-spacing:-.03em;color:var(--ink);">Nasi Box Surplus Sore</div>
                    <div style="font-size:.8125rem;color:var(--muted);margin-top:3px;">20 porsi · Donasi Khusus</div>
                </div>
            </div>
            <div style="background:var(--mint-50);border:1px solid var(--border);border-radius:12px;padding:.625rem .875rem;display:flex;align-items:flex-start;gap:7px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;color:var(--mint-600);margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                <div>
                    <div style="font-size:.5625rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--mint-600);">Lokasi Pick-up</div>
                    <div style="font-size:.8125rem;color:var(--ink);font-weight:500;margin-top:1px;">Jl. Cihampelas No. 42, Bandung</div>
                    <div style="font-size:.75rem;color:var(--orange-500);font-weight:600;margin-top:3px;">⏰ Ambil sebelum pukul 19.30 WIB</div>
                </div>
            </div>
        </div>
        <div class="pickup-itm" style="background:var(--off-white);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:1.125rem 1.25rem;margin-bottom:.875rem;position:relative;">
            <button onclick="removeItem(this)" style="position:absolute;top:.875rem;right:.875rem;width:26px;height:26px;border-radius:50%;border:1px solid rgba(0,0,0,.08);background:#fff;cursor:pointer;color:var(--faint);font-size:14px;display:flex;align-items:center;justify-content:center;">×</button>
            <div style="display:flex;gap:.75rem;margin-bottom:.875rem;">
                <div style="width:52px;height:52px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--mint-100);"><img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=200" style="width:100%;height:100%;object-fit:cover;"></div>
                <div>
                    <div style="font-size:.5625rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mint-600);margin-bottom:3px;">Bakery Sari Rasa</div>
                    <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9375rem;letter-spacing:-.03em;color:var(--ink);">Roti &amp; Kue Sisa Hari Ini</div>
                    <div style="font-size:.8125rem;color:var(--muted);margin-top:3px;">35 pcs · Gratis</div>
                </div>
            </div>
            <div style="background:var(--mint-50);border:1px solid var(--border);border-radius:12px;padding:.625rem .875rem;display:flex;align-items:flex-start;gap:7px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;color:var(--mint-600);margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                <div>
                    <div style="font-size:.5625rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--mint-600);">Lokasi Pick-up</div>
                    <div style="font-size:.8125rem;color:var(--ink);font-weight:500;margin-top:1px;">Jl. Sudirman No. 88, Jakarta Pusat</div>
                    <div style="font-size:.75rem;color:var(--orange-500);font-weight:600;margin-top:3px;">⏰ Ambil sebelum pukul 21.00 WIB</div>
                </div>
            </div>
        </div>
    </div>{{-- /sidebarBody --}}

    {{-- ══ SIDEBAR FOOTER ══ --}}
    <div style="padding:1.25rem 1.75rem 1.5rem;border-top:1.5px solid var(--border);flex-shrink:0;">

        {{-- ── JADWAL PENGAMBILAN (di atas total porsi agar dropdown membuka ke bawah) ── --}}
        <div style="background:#ffffff;border:1.5px solid #e2e8f0;border-radius:14px;padding:1rem 1rem 0.875rem;margin-bottom:1rem;">
            <label for="pickupScheduleSelect" style="display:flex;align-items:center;gap:7px;font-family:'Space Grotesk',sans-serif;font-size:.6875rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--mint-700);margin-bottom:.625rem;">
                <span style="width:22px;height:22px;border-radius:6px;background:var(--mint-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--mint-600);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Jadwal Pengambilan&nbsp;<span style="color:#ef4444;">*</span>
            </label>
            <div style="position:relative;">
                <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);font-size:1rem;pointer-events:none;line-height:1;">⏰</span>
                <select id="pickupScheduleSelect"
                    style="width:100%;padding:.7rem .875rem .7rem 2.5rem;border:1.5px solid #e2e8f0;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-weight:500;font-size:.875rem;color:var(--ink);background:#ffffff;outline:none;cursor:pointer;transition:border-color .2s,box-shadow .2s;appearance:none;background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2316a34a%22 stroke-width=%222.5%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E');background-repeat:no-repeat;background-position:right .875rem center;background-size:15px;"
                    onfocus="this.style.borderColor='var(--mint-400)';this.style.boxShadow='0 0 0 3px rgba(74,222,128,0.18)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    <option value="">— Pilih jam pengambilan —</option>
                    <option value="09:00-09:30">09:00 – 09:30</option>
                    <option value="10:00-10:30">10:00 – 10:30</option>
                    <option value="11:00-11:30">11:00 – 11:30</option>
                    <option value="12:00-12:30">12:00 – 12:30</option>
                    <option value="13:00-13:30">13:00 – 13:30</option>
                    <option value="14:00-14:30">14:00 – 14:30</option>
                    <option value="15:00-15:30">15:00 – 15:30</option>
                    <option value="16:00-16:30">16:00 – 16:30</option>
                    <option value="17:00-17:30">17:00 – 17:30</option>
                    <option value="18:00-18:30">18:00 – 18:30</option>
                    <option value="19:00-19:30">19:00 – 19:30</option>
                    <option value="20:00-20:30">20:00 – 20:30</option>
                </select>
            </div>
        </div>
        {{-- ── /JADWAL PENGAMBILAN ── --}}

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <span style="font-size:.875rem;color:var(--muted);">Total pengambilan</span>
            <span id="itemCount" style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1rem;letter-spacing:-.03em;color:var(--ink);">3 lokasi · 67 porsi</span>
        </div>

        <button style="width:100%;background:var(--mint-500);color:#fff;border:none;border-radius:var(--r-xl);padding:.9rem;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1rem;letter-spacing:-.02em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 16px rgba(34,197,94,.3);transition:all .2s;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Konfirmasi Pengambilan
        </button>
        <p style="text-align:center;font-size:.75rem;color:var(--faint);margin-top:.625rem;line-height:1.5;">Lembaga Anda akan dikonfirmasi oleh masing-masing restoran dalam 15 menit.</p>
    </div>{{-- /sidebar footer --}}
</div>{{-- /sidebar --}}

<script>
function openCart(){
    document.getElementById('sidebar').style.transform='translateX(0)';
    document.getElementById('sidebarOverlay').style.opacity='1';
    document.getElementById('sidebarOverlay').style.pointerEvents='all';
    document.body.style.overflow='hidden';
}
function closeCart(){
    document.getElementById('sidebar').style.transform='translateX(100%)';
    document.getElementById('sidebarOverlay').style.opacity='0';
    document.getElementById('sidebarOverlay').style.pointerEvents='none';
    document.body.style.overflow='';
}
function removeItem(btn){
    const item=btn.closest('.pickup-itm');
    item.style.cssText+=';opacity:0;transform:translateX(20px);transition:all .3s ease;';
    setTimeout(()=>{item.remove();updateCount();},280);
}
function updateCount(){
    const n=document.querySelectorAll('.pickup-itm').length;
    document.getElementById('fabCount').textContent=n;
    if(n===0){
        document.getElementById('sidebarBody').innerHTML='<div style="text-align:center;padding:3rem 1rem;display:flex;flex-direction:column;align-items:center;gap:.75rem;"><div style="width:56px;height:56px;border-radius:50%;background:var(--mint-100);border:2px solid var(--mint-200);display:flex;align-items:center;justify-content:center;color:var(--mint-500);"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div><p style="font-size:.875rem;color:var(--muted);line-height:1.6;">Belum ada donasi yang diajukan.<br>Pilih donasi surplus di atas.</p></div>';
        document.getElementById('itemCount').textContent='0 lokasi · 0 porsi';
    }
}
</script>

{{-- ── LIBRARY NOTIFIKASI: SweetAlert2 ── --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ── LOGIKA TAMBAHAN: Fungsionalitas Ajukan & Batasan Toko ── --}}
<script>
(function() {
    // 1. Inisialisasi State
    let pickupItems = [];
    let appliedProducts = JSON.parse(localStorage.getItem('foodsave_applied_products')) || []; // Format: { name: string, store: string, date: string }

    // Fungsi pembantu: dapatkan tanggal hari ini (YYYY-MM-DD)
    function getToday() {
        return new Date().toISOString().split('T')[0];
    }

    // 2. DOM Elements
    const sidebarBody = document.getElementById('sidebarBody');
    const fabCount = document.getElementById('fabCount');
    const itemCount = document.getElementById('itemCount');

    // 3. Fungsi Utama: Tambah ke Daftar Pengambilan
    window.addItemToPickup = function(product) {
        // Cek batasan: toko ditangguhkan
        if (product.store_is_suspended == 1) {
            Swal.fire({
                icon: 'error',
                title: 'Toko Tutup',
                text: 'Toko ini sedang Tutup. Tidak bisa mengajukan pengambilan dari toko ini.',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Kembali'
            });
            return;
        }

        const today = getToday();
        
        // Cek batasan: satu produk hanya boleh satu kali per hari
        const alreadyAppliedToday = appliedProducts.some(item => {
            return item.name === product.name && item.store === product.store && item.date === today;
        });

        if (alreadyAppliedToday) {
            Swal.fire({
                icon: 'error',
                title: 'Pengajuan Ditolak',
                text: 'Produk ini sudah diajukan hari ini. Batas pengajuan adalah satu kali per produk per hari.',
                confirmButtonColor: '#22c55e',
                confirmButtonText: 'Kembali'
            });
            return;
        }

        // Cek jika item sudah ada di daftar pengambilan saat ini
        const existingItem = pickupItems.find(item => item.name === product.name && item.store === product.store);
        if (existingItem) {
            // Jika sudah ada, tambah quantity
            if (existingItem.qty < product.stock) {
                existingItem.qty++;
                renderPickupList();
                openCart();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: 'Anda sudah mengajukan semua stok yang tersedia.',
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }

        // Tambah item baru dengan qty = 1
        const newItem = { ...product, qty: 1 };
        pickupItems.push(newItem);
        renderPickupList();
        openCart(); // Buka sidebar setelah menambahkan
    };

    // 3.1. Fungsi Update Quantity
    window.updatePickupQty = function(index, delta) {
        const item = pickupItems[index];
        if (!item) return;

        const newQty = item.qty + delta;
        
        if (newQty <= 0) {
            // Hapus item jika qty jadi 0 atau kurang
            removePickupItem(index);
        } else if (newQty > item.stock) {
            // Tidak boleh melebihi stok
            Swal.fire({
                icon: 'warning',
                title: 'Stok Terbatas',
                text: `Stok maksimal untuk ${item.name} adalah ${item.stock} porsi.`,
                confirmButtonColor: '#22c55e',
                confirmButtonText: 'OK'
            });
        } else {
            // Update quantity
            item.qty = newQty;
            renderPickupList();
        }
    };

    // 4. Fungsi Render Sidebar
    function renderPickupList() {
        if (pickupItems.length === 0) {
            sidebarBody.innerHTML = `
                <div style="text-align:center;padding:3rem 1rem;display:flex;flex-direction:column;align-items:center;gap:.75rem;">
                    <div style="width:56px;height:56px;border-radius:50%;background:var(--mint-100);border:2px solid var(--mint-200);display:flex;align-items:center;justify-content:center;color:var(--mint-500);">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/></svg>
                    </div>
                    <p style="font-size:.875rem;color:var(--muted);line-height:1.6;">Belum ada donasi yang diajukan.<br>Pilih donasi surplus di atas.</p>
                </div>
            `;
            itemCount.textContent = '0 lokasi · 0 porsi';
            fabCount.textContent = '0';
            return;
        }

        let html = '';
        pickupItems.forEach((item, index) => {
            html += `
                <div class="pickup-itm" style="background:var(--off-white);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:1.125rem 1.25rem;margin-bottom:.875rem;position:relative;animation:slide-in-right 0.3s ease-out forwards;">
                    <button onclick="removePickupItem(${index})" style="position:absolute;top:.875rem;right:.875rem;width:26px;height:26px;border-radius:50%;border:1px solid rgba(0,0,0,.08);background:#fff;cursor:pointer;color:var(--faint);font-size:14px;display:flex;align-items:center;justify-content:center;">×</button>
                    <div style="display:flex;gap:.75rem;margin-bottom:.875rem;">
                        <div style="width:52px;height:52px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--mint-100);"><img src="${item.image || '{{ asset('images/placeholder.png') }}'}" style="width:100%;height:100%;object-fit:cover;"></div>
                        <div style="flex:1;">
                            <div style="font-size:.5625rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mint-600);margin-bottom:3px;">${item.store}</div>
                            <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9375rem;letter-spacing:-.03em;color:var(--ink);">${item.name}</div>
                            <div style="font-size:.8125rem;color:var(--muted);margin-top:3px;">${item.price}</div>
                            
                            {{-- Quantity Adjuster --}}
                            <div style="display:flex;align-items:center;gap:8px;margin-top:8px;">
                                <button onclick="updatePickupQty(${index}, -1)" style="width:24px;height:24px;border-radius:6px;border:1.5px solid var(--border-md);background:var(--white);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--muted);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--mint-400)';this.style.color='var(--mint-600)'" onmouseout="this.style.borderColor='var(--border-md)';this.style.color='var(--muted)'">−</button>
                                <span style="font-weight:700;color:var(--ink);font-size:14px;min-width:20px;text-align:center;">${item.qty || 1}</span>
                                <button onclick="updatePickupQty(${index}, 1)" style="width:24px;height:24px;border-radius:6px;border:1.5px solid var(--border-md);background:var(--white);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--muted);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--mint-400)';this.style.color='var(--mint-600)'" onmouseout="this.style.borderColor='var(--border-md)';this.style.color='var(--muted)'">+</button>
                                <span style="font-size:.75rem;color:var(--faint);margin-left:4px;">porsi</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:var(--mint-50);border:1px solid var(--border);border-radius:12px;padding:.625rem .875rem;display:flex;align-items:flex-start;gap:7px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;color:var(--mint-600);margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                        <div>
                            <div style="font-size:.5625rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--mint-600);">Lokasi Pick-up</div>
                            <div style="font-size:.8125rem;color:var(--ink);font-weight:500;margin-top:1px;">Lokasi Mitra Terdekat</div>
                            <div style="font-size:.75rem;color:var(--orange-500);font-weight:600;margin-top:3px;">⏰ ${item.urgent}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        sidebarBody.innerHTML = html;
        
        // Update counter dengan total quantity
        const totalQty = pickupItems.reduce((sum, item) => sum + (item.qty || 1), 0);
        fabCount.textContent = totalQty;
        itemCount.textContent = `${pickupItems.length} lokasi · ${totalQty} porsi`;
    }

    // 5. Override Fungsi Hapus
    window.removePickupItem = function(index) {
        pickupItems.splice(index, 1);
        renderPickupList();
    };

    // 6. Fungsi Konfirmasi
    window.confirmPickup = function() {
        if (pickupItems.length === 0) return;

        // [BARU] Validasi: Jadwal Pengambilan wajib dipilih
        const scheduleSelect = document.getElementById('pickupScheduleSelect');
        const selectedSchedule = scheduleSelect ? scheduleSelect.value : '';

        if (!selectedSchedule) {
            Swal.fire({
                icon: 'warning',
                title: 'Jadwal Belum Dipilih!',
                text: 'Harap pilih jadwal pengambilan terlebih dahulu sebelum mengajukan klaim donasi.',
                confirmButtonColor: '#22c55e',
                confirmButtonText: 'OK, Pilih Jadwal'
            }).then(() => {
                if (scheduleSelect) {
                    scheduleSelect.focus();
                    scheduleSelect.style.borderColor = '#ef4444';
                    scheduleSelect.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.2)';
                    setTimeout(() => {
                        scheduleSelect.style.borderColor = 'var(--border-strong)';
                        scheduleSelect.style.boxShadow = 'none';
                    }, 2500);
                }
            });
            return; // Hentikan proses jika jadwal belum dipilih
        }
        // [/BARU]

        Swal.fire({
            title: 'Konfirmasi Pengambilan',
            html: `<p style="margin-bottom:8px;">Apakah Anda yakin ingin mengajukan pengambilan donasi ini?</p>
                   <div style="display:inline-flex;align-items:center;gap:6px;background:#f0fdf6;border:1.5px solid #86efb0;border-radius:999px;padding:5px 14px;font-size:0.8125rem;font-weight:700;color:#15803d;">
                       <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                       Jadwal: ${selectedSchedule} WIB
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Ajukan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch('{{ route('sosial.claim') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    // [BARU] Sertakan pickup_schedule dalam payload ke backend
                    body: JSON.stringify({ items: pickupItems, pickup_schedule: selectedSchedule })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pengajuan Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#22c55e'
                        }).then(() => {
                            pickupItems = [];
                            localStorage.removeItem('foodsave_applied_products');
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message || 'Terjadi kesalahan saat memproses klaim.',
                        confirmButtonColor: '#22c55e'
                    });
                });
            }
        });
    };

    // 7. Event Delegation untuk Tombol "Ajukan"
    // 7. Klik 'Ajukan' dihilangkan karena ditangani oleh Alpine.js


    // 8. Event Listener untuk Tombol Konfirmasi
    const confirmBtn = document.querySelector('button[style*="var(--mint-500)"]');
    if (confirmBtn) {
        confirmBtn.onclick = confirmPickup;
    }

    // 9. Initial Clean
    document.addEventListener('DOMContentLoaded', () => {
        pickupItems = [];
        renderPickupList();
    });

})();

function foodSaveApp() {
    return {
        searchQuery: '',
        showReviewModal: false,
        activeProduct: null,
        activeReviews: [],
        products: @json($menus),

        openReviewModal(product) {
            this.activeProduct = product;
            this.activeReviews = product.reviews || [];
            this.showReviewModal = true;
        },

        get filteredProducts() {
            const q = (this.searchQuery || '').toLowerCase().trim();
            if (!q) return this.products;

            return this.products.filter(p => {
                const name = (p.name || '').toLowerCase();
                const store = (p.store || '').toLowerCase();
                return name.includes(q) || store.includes(q);
            });
        }
    };
}
</script>

</div>
</x-app-layout>
