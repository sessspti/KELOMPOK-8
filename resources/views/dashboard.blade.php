<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Syne:wght@400;500;600;700;800&family=Instrument+Sans:ital,wdth,wght@0,75..100,400..700;1,75..100,400..500&display=swap" rel="stylesheet">
<style>
:root {
    --green-950: #0a1f13;
    --green-900: #0f2d1a;
    --green-800: #164024;
    --green-700: #1e5c32;
    --green-600: #227a3e;
    --green-500: #2a9a50;
    --green-400: #4abe72;
    --green-300: #7dd89a;
    --green-100: #d4f0dd;
    --green-50:  #f0faf4;
    --yellow-400: #fbbf24;
    --yellow-300: #fcd34d;
    --yellow-100: #fef3c7;
    --yellow-900: #78350f;
    --orange-500: #f97316;
    --cream:      #faf8f3;
    --cream-dark: #f0ece2;
    --ink:        #0d0d0b;
    --ink-muted:  #4a4a44;
    --ink-faint:  #9a9488;
    --white:      #ffffff;
    --radius-sm:  0.5rem;
    --radius-md:  1rem;
    --radius-lg:  1.5rem;
    --radius-xl:  2rem;
    --radius-pill:999px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    font-family: 'Instrument Sans', sans-serif;
    background: var(--green-950);
    color: var(--white);
    min-height: 100vh;
    overflow-x: hidden;
}

/* ─── GRAIN OVERLAY ─── */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.035;
    pointer-events: none;
    z-index: 9999;
}

/* ─── TYPOGRAPHY ─── */
.t-display {
    font-family: 'Instrument Serif', Georgia, serif;
    font-style: italic;
}
.t-sans {
    font-family: 'Syne', sans-serif;
}

/* ═══════════════════════════════════
   HEADER
═══════════════════════════════════ */
.site-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(10,31,19,0.82);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.header-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}
.logo {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 1.375rem;
    letter-spacing: -0.04em;
    color: var(--white);
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
}
.logo-leaf {
    width: 28px;
    height: 28px;
    background: var(--green-500);
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    animation: sway 4s ease-in-out infinite;
}
.logo-leaf::after {
    content: '';
    width: 3px;
    height: 14px;
    background: rgba(255,255,255,0.6);
    border-radius: 2px;
    transform: rotate(45deg);
}
@keyframes sway {
    0%,100%{transform:rotate(-45deg) scale(1)}
    50%{transform:rotate(-40deg) scale(1.05)}
}
.logo span { color: var(--green-400); }

.header-search {
    flex: 1;
    max-width: 400px;
    position: relative;
    display: none;
}
@media(min-width:768px){.header-search{display:block}}
.header-search input {
    width: 100%;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: var(--radius-pill);
    padding: 0.625rem 1rem 0.625rem 2.75rem;
    color: var(--white);
    font-family: 'Instrument Sans', sans-serif;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.25s;
}
.header-search input::placeholder { color: rgba(255,255,255,0.35); }
.header-search input:focus {
    background: rgba(255,255,255,0.1);
    border-color: var(--green-400);
    box-shadow: 0 0 0 3px rgba(74,190,114,0.18);
}
.header-search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.35);
    width: 16px; height: 16px;
    pointer-events: none;
}

.points-pill {
    background: linear-gradient(135deg, var(--yellow-400), #f59e0b);
    color: var(--yellow-900);
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.8125rem;
    padding: 0.4rem 1rem;
    border-radius: var(--radius-pill);
    white-space: nowrap;
    letter-spacing: 0.01em;
    box-shadow: 0 4px 14px rgba(251,191,36,0.3);
    flex-shrink: 0;
}

/* ═══════════════════════════════════
   CART FAB
═══════════════════════════════════ */
.fab-cart {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 200;
    background: var(--green-500);
    color: var(--white);
    text-decoration: none;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-pill);
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.9375rem;
    box-shadow: 0 8px 30px rgba(42,154,80,0.45);
    transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
}
.fab-cart:hover {
    background: var(--green-400);
    transform: translateY(-3px);
    box-shadow: 0 14px 40px rgba(42,154,80,0.55);
}
.fab-badge {
    background: var(--yellow-400);
    color: var(--yellow-900);
    font-size: 0.7rem;
    font-weight: 800;
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ═══════════════════════════════════
   PAGE LAYOUT
═══════════════════════════════════ */
.page-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem 8rem;
}

/* ═══════════════════════════════════
   HERO — SPLIT LAYOUT
═══════════════════════════════════ */
.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 88vh;
    margin: 0 -2rem;
    overflow: hidden;
}
@media(max-width:900px){.hero{grid-template-columns:1fr;min-height:auto}}

.hero-left {
    background: var(--green-900);
    padding: 5rem 4rem 5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.hero-left::before {
    content:'';
    position:absolute;
    top:-120px; left:-80px;
    width:400px; height:400px;
    background: radial-gradient(circle, rgba(42,154,80,0.2) 0%, transparent 70%);
    pointer-events:none;
}
.hero-left::after {
    content:'';
    position:absolute;
    bottom:-60px; right:-40px;
    width:250px; height:250px;
    background: radial-gradient(circle, rgba(251,191,36,0.1) 0%, transparent 70%);
    pointer-events:none;
}

.hero-eyebrow {
    font-family: 'Syne', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--green-400);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.hero-eyebrow::before {
    content:'';
    width: 24px;
    height: 1.5px;
    background: var(--green-400);
    display: block;
}

.hero-quote {
    font-family: 'Instrument Serif', serif;
    font-style: italic;
    font-size: clamp(2.5rem, 4vw, 3.75rem);
    line-height: 1.1;
    color: var(--white);
    letter-spacing: -0.02em;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}
.hero-quote em {
    color: var(--green-300);
    font-style: normal;
}

.hero-impact-cards {
    display: flex;
    gap: 1rem;
    position: relative;
    z-index: 1;
}
.impact-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: var(--radius-lg);
    padding: 1.25rem 1.5rem;
    flex: 1;
    transition: background 0.2s;
    position: relative;
    overflow: hidden;
}
.impact-card::before {
    content:'';
    position:absolute;
    top:0; left:0;
    width:3px; height:100%;
    background: var(--green-400);
    border-radius: 2px;
}
.impact-card:hover { background: rgba(255,255,255,0.09); }
.impact-num {
    font-family: 'Syne', sans-serif;
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--white);
    line-height: 1;
    letter-spacing: -0.04em;
}
.impact-unit {
    font-size: 0.75rem;
    font-weight: 400;
    color: var(--green-300);
    letter-spacing: 0.06em;
}
.impact-label {
    font-size: 0.6rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin-top: 0.25rem;
}

.hero-right {
    background: var(--green-800);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.hero-right-top {
    flex: 1;
    position: relative;
    overflow: hidden;
}
.hero-right-top img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: saturate(0.85) brightness(0.75);
    transition: transform 8s ease;
}
.hero-right-top:hover img { transform: scale(1.03); }
.hero-right-top-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--green-800) 0%, transparent 50%);
}

.hero-visual-placeholder {
    background: rgba(251,191,36,0.08);
    border: 1.5px dashed rgba(251,191,36,0.35);
    border-radius: var(--radius-xl);
    margin: 1.5rem;
    padding: 1.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: rgba(251,191,36,0.55);
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    height: 110px;
}

/* ═══════════════════════════════════
   SCROLLING TICKER
═══════════════════════════════════ */
.ticker-wrap {
    background: var(--green-700);
    overflow: hidden;
    border-top: 1px solid rgba(255,255,255,0.06);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 0.75rem 0;
}
.ticker-track {
    display: flex;
    gap: 0;
    animation: ticker 20s linear infinite;
    width: max-content;
}
@keyframes ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.ticker-item {
    white-space: nowrap;
    padding: 0 2.5rem;
    font-family: 'Syne', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--green-300);
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ticker-dot { width: 4px; height: 4px; background: var(--yellow-400); border-radius: 50%; flex-shrink: 0; }

/* ═══════════════════════════════════
   RESCUE DEALS SECTION
═══════════════════════════════════ */
.section {
    padding: 5rem 0;
}
.section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 3rem;
    gap: 1rem;
}
.section-label {
    font-family: 'Syne', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--green-400);
    margin-bottom: 0.625rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-label::before {
    content:'';
    width:18px; height:1.5px;
    background: var(--green-400);
}
.section-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 400;
    font-style: italic;
    color: var(--white);
    letter-spacing: -0.03em;
    line-height: 1;
}
.section-sub {
    color: rgba(255,255,255,0.45);
    font-size: 0.875rem;
    margin-top: 0.375rem;
    letter-spacing: 0.01em;
}

.arrow-group { display: flex; gap: 0.5rem; }
.arrow-btn {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.05);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.6);
    font-size: 1.125rem;
    transition: all 0.2s;
}
.arrow-btn:hover {
    background: var(--green-600);
    border-color: var(--green-500);
    color: var(--white);
}

/* ─── PRODUCT GRID ─── */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}
@media(max-width:1100px){.product-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){.product-grid{grid-template-columns:1fr}}

/* ─── PRODUCT CARD ─── */
.pcard {
    background: var(--green-900);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), border-color 0.2s, box-shadow 0.3s;
    cursor: pointer;
    position: relative;
}
.pcard:hover {
    transform: translateY(-8px) rotate(-0.3deg);
    border-color: rgba(74,190,114,0.3);
    box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(74,190,114,0.15);
}

.pcard-img {
    position: relative;
    height: 230px;
    overflow: hidden;
}
.pcard-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
    filter: brightness(0.88) saturate(0.9);
}
.pcard:hover .pcard-img img { transform: scale(1.1); filter: brightness(0.95) saturate(1); }
.pcard-img-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--green-900) 0%, transparent 55%);
}

.badge-dist {
    position: absolute;
    top: 0.875rem; left: 0.875rem;
    background: rgba(10,31,19,0.75);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: var(--radius-pill);
    padding: 0.25rem 0.625rem;
    font-family: 'Syne', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    color: var(--green-300);
    letter-spacing: 0.06em;
    display: flex;
    align-items: center;
    gap: 4px;
}
.badge-urgent {
    position: absolute;
    top: 0.875rem; right: 0.875rem;
    background: var(--orange-500);
    color: var(--white);
    border-radius: var(--radius-sm);
    padding: 0.25rem 0.65rem;
    font-family: 'Syne', sans-serif;
    font-size: 0.625rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    animation: pulse-badge 2s ease-in-out infinite;
}
@keyframes pulse-badge {
    0%,100%{box-shadow:0 0 0 0 rgba(249,115,22,0.5)}
    50%{box-shadow:0 0 0 6px rgba(249,115,22,0)}
}

.pcard-body {
    padding: 1.25rem 1.375rem 1.5rem;
}
.pcard-store {
    font-family: 'Syne', sans-serif;
    font-size: 0.5625rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--green-400);
    margin-bottom: 0.375rem;
}
.pcard-name {
    font-family: 'Instrument Serif', serif;
    font-style: italic;
    font-size: 1.125rem;
    color: var(--white);
    margin-bottom: 1.25rem;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pcard-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.price-orig {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.35);
    text-decoration: line-through;
    letter-spacing: 0.02em;
}
.price-new {
    font-family: 'Syne', sans-serif;
    font-size: 1.375rem;
    font-weight: 800;
    color: var(--green-300);
    letter-spacing: -0.03em;
    line-height: 1;
}
.add-btn {
    background: var(--yellow-400);
    border: none;
    border-radius: var(--radius-md);
    width: 46px; height: 46px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: var(--yellow-900);
    transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 4px 16px rgba(251,191,36,0.3);
    flex-shrink: 0;
}
.add-btn:hover {
    background: #f59e0b;
    transform: scale(1.12) rotate(8deg);
    box-shadow: 0 8px 24px rgba(251,191,36,0.5);
}
.add-btn:active { transform: scale(0.95); }
.add-btn svg { width: 22px; height: 22px; }

/* ═══════════════════════════════════
   DIVIDER / SEPARATOR
═══════════════════════════════════ */
.section-divider {
    border: none;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.1) 30%, rgba(255,255,255,0.1) 70%, transparent);
}

/* ═══════════════════════════════════
   EDUCATION SECTION
═══════════════════════════════════ */
.edu-section {
    padding: 4rem 0 5rem;
}
.edu-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 2rem;
    margin-top: 3rem;
}
@media(max-width:900px){.edu-grid{grid-template-columns:1fr}}

.edu-card {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    cursor: pointer;
    group: true;
}
.edu-img {
    border-radius: var(--radius-xl);
    overflow: hidden;
    height: 210px;
    position: relative;
}
.edu-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    filter: brightness(0.8) saturate(0.85);
    transition: transform 0.6s ease, filter 0.4s;
}
.edu-card:hover .edu-img img { transform: scale(1.06); filter: brightness(0.9) saturate(1); }
.edu-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10,31,19,0.7) 0%, transparent 60%);
}

.edu-tag {
    font-family: 'Syne', sans-serif;
    font-size: 0.5625rem;
    font-weight: 800;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--green-400);
    display: flex;
    align-items: center;
    gap: 6px;
}
.edu-tag::before { content:''; width:12px; height:1px; background:var(--green-400); }

.edu-title {
    font-family: 'Instrument Serif', serif;
    font-style: italic;
    font-size: 1.125rem;
    color: var(--white);
    line-height: 1.35;
    transition: color 0.2s;
}
.edu-card:hover .edu-title { color: var(--green-300); }

.edu-excerpt {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.45);
    line-height: 1.65;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.edu-placeholder {
    border-radius: var(--radius-xl);
    border: 1.5px dashed rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 0.75rem;
    padding: 3rem 2rem;
    text-align: center;
    min-height: 210px;
    background: rgba(255,255,255,0.02);
}
.edu-placeholder-icon {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 1.5px dashed rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.2);
}
.edu-placeholder p {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.25);
    font-style: italic;
    line-height: 1.6;
}

.see-all-link {
    font-family: 'Syne', sans-serif;
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--green-400);
    text-decoration: none;
    letter-spacing: 0.06em;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s, color 0.2s;
}
.see-all-link:hover { color: var(--green-300); gap: 10px; }
.see-all-link svg { width: 14px; height: 14px; }

/* ═══════════════════════════════════
   ANIMATIONS
═══════════════════════════════════ */
@keyframes fadeUp {
    from{opacity:0; transform:translateY(28px)}
    to{opacity:1; transform:translateY(0)}
}
@keyframes fadeIn {
    from{opacity:0} to{opacity:1}
}
.anim-hero-left  { animation: fadeIn 0.9s ease both; }
.anim-hero-right { animation: fadeIn 0.9s ease 0.15s both; }
.anim-section    { animation: fadeUp 0.7s ease both; }
.pcard:nth-child(1){animation: fadeUp 0.5s ease 0.05s both;}
.pcard:nth-child(2){animation: fadeUp 0.5s ease 0.12s both;}
.pcard:nth-child(3){animation: fadeUp 0.5s ease 0.19s both;}
.pcard:nth-child(4){animation: fadeUp 0.5s ease 0.26s both;}
</style>

{{-- ── FAB CART ── --}}
<a href="#" class="fab-cart">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Keranjang
    <span class="fab-badge">3</span>
</a>

{{-- ── HEADER ── --}}
<header class="site-header">
    <div class="header-inner">
        <a href="#" class="logo">
            <span class="logo-leaf"></span>
            Food<span>Save</span>
        </a>
        <div class="header-search">
            <svg class="header-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari makanan yang bisa diselamatkan...">
        </div>
        <span class="points-pill">✦ 150.000 FP</span>
    </div>
</header>

{{-- ── HERO SPLIT ── --}}
<section class="hero">
    <div class="hero-left anim-hero-left">
        <div>
            <p class="hero-eyebrow">Dampak Lingkunganmu</p>
            <h1 class="hero-quote">
                "Langkah <em>kecilmu,</em><br>nafas baru<br>untuk bumi."
            </h1>
        </div>
        <div class="hero-impact-cards">
            <div class="impact-card">
                <div class="impact-num">12.5 <span class="impact-unit">Kg</span></div>
                <div class="impact-label">Food Saved</div>
            </div>
            <div class="impact-card">
                <div class="impact-num">3.2 <span class="impact-unit">Kg</span></div>
                <div class="impact-label">CO₂ Reduced</div>
            </div>
        </div>
    </div>
    <div class="hero-right anim-hero-right">
        <div class="hero-right-top">
            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800" alt="Fresh food">
            <div class="hero-right-top-overlay"></div>
        </div>
        <div class="hero-visual-placeholder">
            Visual Impact Tracker Soon
        </div>
    </div>
</section>

{{-- ── TICKER ── --}}
<div class="ticker-wrap">
    <div class="ticker-track">
        @foreach(range(1, 8) as $t)
        <div class="ticker-item">
            <span class="ticker-dot"></span>
            Selamatkan Makanan Hari Ini
            <span class="ticker-dot"></span>
            Kurangi Food Waste
            <span class="ticker-dot"></span>
            Hemat Lebih Banyak
            <span class="ticker-dot"></span>
            Jaga Bumi Kita
        </div>
        @endforeach
    </div>
</div>

{{-- ── RESCUE DEALS ── --}}
<div class="page-wrap">
    <section class="section anim-section">
        <div class="section-header">
            <div>
                <p class="section-label">Penawaran Terbaik</p>
                <h2 class="section-title">Rescue Deals Hari Ini</h2>
                <p class="section-sub">Makanan berkualitas dengan harga penyelamat.</p>
            </div>
            <div class="arrow-group">
                <button class="arrow-btn" aria-label="Sebelumnya">←</button>
                <button class="arrow-btn" aria-label="Berikutnya">→</button>
            </div>
        </div>

        <div class="product-grid">
            @for ($i = 0; $i < 4; $i++)
            <div class="pcard">
                <div class="pcard-img">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Paket Ayam Geprek Surplus">
                    <div class="pcard-img-gradient"></div>
                    <div class="badge-dist">
                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        0.5 km
                    </div>
                    <div class="badge-urgent">Sisa 2!</div>
                </div>
                <div class="pcard-body">
                    <p class="pcard-store">Resto Ayam Berkah</p>
                    <h3 class="pcard-name">Paket Ayam Geprek Surplus</h3>
                    <div class="pcard-footer">
                        <div>
                            <div class="price-orig">Rp 25.000</div>
                            <div class="price-new">Rp 12.500</div>
                        </div>
                        <button class="add-btn" aria-label="Tambah ke keranjang">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <hr class="section-divider">

    {{-- ── EDUCATION ── --}}
    <section class="edu-section anim-section">
        <div class="section-header">
            <div>
                <p class="section-label">Wawasan & Inspirasi</p>
                <h2 class="section-title">Edukasi & Lingkungan</h2>
            </div>
            <a href="#" class="see-all-link">
                Lihat Semua Artikel
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="edu-grid">
            <div class="edu-card">
                <div class="edu-img">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" alt="Tips Penyimpanan">
                    <div class="edu-img-overlay"></div>
                </div>
                <span class="edu-tag">Tips Penyimpanan</span>
                <h3 class="edu-title">5 Cara Agar Sayuran Tetap Segar Selama Seminggu</h3>
                <p class="edu-excerpt">Admin FoodSave membagikan tips rahasia menyimpan bahan makanan agar tidak cepat terbuang dan tetap bergizi optimal.</p>
            </div>

            <div class="edu-card">
                <div class="edu-img">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=500" alt="Global Issue">
                    <div class="edu-img-overlay"></div>
                </div>
                <span class="edu-tag">Global Issue</span>
                <h3 class="edu-title">Dampak Mengerikan Food Waste bagi Perubahan Iklim</h3>
                <p class="edu-excerpt">Mengetahui seberapa besar pengaruh sisa makanan terhadap lapisan ozon bumi kita.</p>
            </div>

            <div class="edu-placeholder">
                <div class="edu-placeholder-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <p>Artikel lainnya sedang disiapkan oleh Admin kami...</p>
            </div>
        </div>
    </section>
</div>
</x-app-layout>