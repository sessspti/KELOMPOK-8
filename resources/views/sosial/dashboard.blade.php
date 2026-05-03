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
    background: rgba(247,253,249,0.88);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1.5px solid var(--border);
}
.hdr-inner {
    max-width: 1380px;
    margin: 0 auto;
    padding: 0 2rem;
    height: 70px;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.logo {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 1.4rem;
    letter-spacing: -0.06em;
    color: var(--ink);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    white-space: nowrap;
}
.logo-icon {
    width: 32px; height: 32px;
    background: var(--mint-400);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    animation: logo-bounce 3s ease-in-out infinite;
    flex-shrink: 0;
}
.logo-icon svg { width: 18px; height: 18px; color: #fff; }
@keyframes logo-bounce {
    0%,100%{transform:translateY(0) rotate(0deg)}
    30%{transform:translateY(-3px) rotate(-4deg)}
    60%{transform:translateY(-1px) rotate(2deg)}
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
    padding: 0.6rem 1.1rem 0.6rem 2.8rem;
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
        <a href="#" class="logo">
            <span class="logo-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </span>
            Food<span class="logo-text-save">Save</span>
        </a>
        <span style="background:#e0f2fe;color:#0284c7;border:1.5px solid rgba(14,165,233,0.25);font-family:'Space Grotesk',sans-serif;font-size:0.6875rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.85rem;border-radius:999px;white-space:nowrap;">🏛 Lembaga Sosial</span>
        <div class="hdr-search">
            <svg class="hdr-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari donasi surplus tersedia...">
        </div>
        <div class="hdr-right">
            <span class="pts-pill">✦ 150.000 FP</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="pts-pill" style="cursor:pointer; background: #fee2e2; color: #991b1b; border: 2px solid rgba(239,68,68,0.2); transition: background 0.2s;" onmouseover="this.style.background='#fca5a5'" onmouseout="this.style.background='#fee2e2'">
                    Keluar
                </button>
            </form>
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
                    <div class="stat-lbl">CO₂ Reduced</div>
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
                Kurangi Food Waste
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
            {{-- Card 1 GRATIS --}}
            <div class="pcard">
                <div class="pcard-img">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Paket Ayam Geprek Surplus">
                    <div class="bdg-dist"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>0.5 km</div>
                    <div class="bdg-urgent">Ambil sebelum 20.00!</div>
                    <div class="bdg-gratis">Gratis</div>
                </div>
                <div class="pcard-body">
                    <p class="pcard-store">Resto Ayam Berkah</p>
                    <h3 class="pcard-name">Paket Ayam Geprek Surplus</h3>
                    <p class="pcard-qty">Tersedia 12 porsi</p>
                    <div class="pcard-ft">
                        <div class="price-tag gratis"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>Gratis</div>
                        <button class="req-btn" onclick="openCart()" aria-label="Ajukan pengambilan"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>Ajukan</button>
                    </div>
                </div>
            </div>
            {{-- Card 2 DONASI KHUSUS --}}
            <div class="pcard">
                <div class="pcard-img">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Nasi Box Surplus">
                    <div class="bdg-dist"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>1.2 km</div>
                    <div class="bdg-urgent">Ambil sebelum 19.30!</div>
                    <div class="bdg-donasi">Donasi Khusus</div>
                </div>
                <div class="pcard-body">
                    <p class="pcard-store">Katering Berkah</p>
                    <h3 class="pcard-name">Nasi Box Surplus Sore</h3>
                    <p class="pcard-qty">Tersedia 20 porsi</p>
                    <div class="pcard-ft">
                        <div class="price-tag donasi"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Donasi Khusus</div>
                        <button class="req-btn" onclick="openCart()" aria-label="Ajukan pengambilan"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>Ajukan</button>
                    </div>
                </div>
            </div>
            {{-- Card 3 GRATIS --}}
            <div class="pcard">
                <div class="pcard-img">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Roti Surplus">
                    <div class="bdg-dist"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>2.1 km</div>
                    <div class="bdg-urgent">Ambil sebelum 21.00!</div>
                    <div class="bdg-gratis">Gratis</div>
                </div>
                <div class="pcard-body">
                    <p class="pcard-store">Bakery Sari Rasa</p>
                    <h3 class="pcard-name">Roti & Kue Sisa Hari Ini</h3>
                    <p class="pcard-qty">Tersedia 35 pcs</p>
                    <div class="pcard-ft">
                        <div class="price-tag gratis"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>Gratis</div>
                        <button class="req-btn" onclick="openCart()" aria-label="Ajukan pengambilan"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>Ajukan</button>
                    </div>
                </div>
            </div>
            {{-- Card 4 DONASI KHUSUS --}}
            <div class="pcard">
                <div class="pcard-img">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Sayur Surplus">
                    <div class="bdg-dist"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>3.0 km</div>
                    <div class="bdg-urgent">Ambil sebelum 18.00!</div>
                    <div class="bdg-donasi">Donasi Khusus</div>
                </div>
                <div class="pcard-body">
                    <p class="pcard-store">Warung Sayur Bu Yanti</p>
                    <h3 class="pcard-name">Sayur Segar Surplus Pagi</h3>
                    <p class="pcard-qty">Tersedia 8 kg</p>
                    <div class="pcard-ft">
                        <div class="price-tag donasi"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Donasi Khusus</div>
                        <button class="req-btn" onclick="openCart()" aria-label="Ajukan pengambilan"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>Ajukan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="divider">

    {{-- ── EDUKASI ── --}}
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
                    <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9375rem;letter-spacing:-.03em;color:var(--ink);">Roti & Kue Sisa Hari Ini</div>
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
    </div>
    <div style="padding:1.25rem 1.75rem;border-top:1.5px solid var(--border);flex-shrink:0;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <span style="font-size:.875rem;color:var(--muted);">Total pengambilan</span>
            <span id="itemCount" style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1rem;letter-spacing:-.03em;color:var(--ink);">3 lokasi · 67 porsi</span>
        </div>
        <button style="width:100%;background:var(--mint-500);color:#fff;border:none;border-radius:var(--r-xl);padding:.9rem;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1rem;letter-spacing:-.02em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 16px rgba(34,197,94,.3);transition:all .2s;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Konfirmasi Pengambilan
        </button>
        <p style="text-align:center;font-size:.75rem;color:var(--faint);margin-top:.625rem;line-height:1.5;">Lembaga Anda akan dikonfirmasi oleh masing-masing restoran dalam 15 menit.</p>
    </div>
</div>

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

</x-app-layout>
