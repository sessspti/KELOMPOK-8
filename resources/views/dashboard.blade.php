<x-app-layout>
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


@keyframes cart-wiggle {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1) rotate(-8deg); }
    50% { transform: scale(1.1) rotate(8deg); }
    75% { transform: scale(1.1) rotate(-4deg); }
}
.animate-wiggle { animation: cart-wiggle 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97) both; }

@keyframes pulse-subtle {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.03); opacity: 0.9; }
}
.animate-pulse-subtle { animation: pulse-subtle 2s ease-in-out infinite; }

@keyframes float-slow {
    0%, 100% { transform: translateY(0) rotate(0); }
    50% { transform: translateY(-12px) rotate(2deg); }
}
.animate-float { animation: float-slow 4s ease-in-out infinite; }

@keyframes slide-in-right {
    from { transform: translateX(30px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.item-appear { animation: slide-in-right 0.4s ease-out forwards; }

/* ─── FLYING ITEM ─── */
.fly-item {
    position: fixed;
    z-index: 1000;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    pointer-events: none;
    transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 25px rgba(34,197,94,0.4);
    border: 3px solid #fff;
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

</style>

<div x-data="foodSaveApp()" class="min-h-screen">
    {{-- ── FAB CART & BACK (Hanya untuk Konsumen yang login) ── --}}
    @auth
        @if(Auth::user()->role === 'konsumen')
        <div class="fixed bottom-8 right-8 z-[210] pointer-events-none">
            <button 
                x-show="isCartOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                @click="isCartOpen = false" 
                class="fab border-none cursor-pointer pointer-events-auto bg-red-500 hover:bg-red-600 shadow-red-200"
            >
                <svg width="19" height="19" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </button>

            <button 
                x-show="!isCartOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                @click="isCartOpen = true" 
                class="fab border-none cursor-pointer pointer-events-auto"
                :class="{'animate-wiggle': cartAnimation}"
            >
                <svg width="19" height="19" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Keranjang
                <span class="fab-num" x-text="cart.length"></span>
            </button>
        </div>
        @endif
    @endauth

    {{-- ── HEADER ── --}}
    <x-header />

    <div class="page">

        {{-- ── HERO BENTO ── --}}
        <section class="hero-bento">
            <div class="bento-main">
                <div>
                    <p class="bento-eyebrow">
                        <span class="bento-eyebrow-dot"></span>
                        Dampak Lingkunganmu
                    </p>
                    <h1 class="bento-heading">
                        "Langkah<br><em>kecilmu,</em><br>nafas baru<br>untuk bumi."
                    </h1>
                </div>
                <div class="bento-stats">
                    <div class="stat-chip">
                        <div class="stat-num">12.5 <span class="stat-unit">Kg</span></div>
                        <div class="stat-lbl">Food Saved</div>
                    </div>
                    <div class="stat-chip">
                        <div class="stat-num">3.2 <span class="stat-unit">Kg</span></div>
                        <div class="stat-lbl">CO₂ dikurangi</div>
                    </div>
                </div>
            </div>

            <div class="bento-img-card">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=700" alt="Fresh healthy food">
            </div>

            <div class="bento-tracker">
                <div class="bento-tracker-label">Visual Impact Tracker</div>
                <div class="bento-tracker-sub">Coming Soon ✦</div>
            </div>
        </section>

        {{-- ── TICKER ── --}}
        <div class="ticker-wrap">
            <div class="ticker-track">
                @foreach(range(1,8) as $i)
                <div class="ticker-item">
                    <span class="ticker-star">✦</span>
                    Selamatkan Makanan Hari Ini
                    <span class="ticker-star">✦</span>
                    Kurangi limbah makanan
                    <span class="ticker-star">✦</span>
                    Hemat Lebih Banyak
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
                    <p class="sec-label"><span class="sec-label-dot"></span> Penawaran Terbaik</p>
                    <h2 class="sec-title">Rescue Deals Hari Ini</h2>
                    <p class="sec-sub">Makanan berkualitas dengan harga penyelamat.</p>
                </div>
                <div class="arrow-row">
                    <button class="arr-btn" aria-label="Sebelumnya">←</button>
                    <button class="arr-btn" aria-label="Berikutnya">→</button>
                </div>
            </div>

            <!-- Product Grid (Dynamic Search) -->
            <div class="pgrid">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="pcard">
                        <div class="pcard-img">
                            <img :src="product.image" :alt="product.name">
                            <div class="bdg-dist">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="10" height="10">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span x-text="product.distance"></span>
                            </div>
                            <div class="bdg-urgent" x-text="product.urgent"></div>
                        </div>
                        <div class="pcard-body">
                            <p class="pcard-store" x-text="product.store"></p>
                            <h3 class="pcard-name" x-text="product.name"></h3>
                            <div class="flex items-center gap-1.5 mb-3" style="font-size: 0.75rem; color: var(--orange-500); font-weight: 600;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/>
                                </svg>
                                <span>Expired: <span x-text="product.expired_at"></span></span>
                            </div>
                            <div class="pcard-ft">
                                <div>
                                    <div class="price-was" x-text="formatRupiah(product.originalPrice)"></div>
                                    <div class="price-now" x-text="formatRupiah(product.price)"></div>
                                </div>
                                {{-- Tombol Keranjang: hanya untuk Konsumen yang login --}}
                                <button x-show="isKonsumen" @click="addToCart(product, $event)" class="add-btn" aria-label="Tambah ke keranjang">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                                {{-- CTA Masuk: untuk guest / role bukan konsumen --}}
                                <a x-show="!isKonsumen" href="{{ route('login') }}"
                                   class="add-btn" aria-label="Masuk untuk membeli"
                                   style="background:var(--ink); text-decoration:none; width:auto; padding: 0 12px; font-family:'Space Grotesk',sans-serif; font-size:0.65rem; font-weight:700; letter-spacing:0.03em; gap:5px; white-space:nowrap;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3 3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Masuk
                                </a>
                            </div>

                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" class="text-center py-20">
                <p class="text-gray-400 italic">Maaf, makanan tidak ditemukan...</p>
            </div>
        </section>

        <hr class="divider">

        {{-- ── EDUKASI ── --}}
        <section class="sec">
            <div class="sec-hdr">
                <div>
                    <p class="sec-label"><span class="sec-label-dot"></span> Wawasan & Inspirasi</p>
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
                    <span class="edu-tag">Tips Penyimpanan</span>
                    <h3 class="edu-title">5 Cara Agar Sayuran Tetap Segar Selama Seminggu</h3>
                    <p class="edu-desc">Admin FoodSave membagikan tips rahasia menyimpan bahan makanan agar tidak cepat terbuang dan tetap bergizi optimal.</p>
                </div>

                <div class="edu-card">
                    <div class="edu-img-wrap">
                        <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=500" alt="Global Issue">
                    </div>
                    <span class="edu-tag">Isu Global</span>
                    <h3 class="edu-title">Dampak Mengerikan Food Waste bagi Perubahan Iklim</h3>
                    <p class="edu-desc">Mengetahui seberapa besar pengaruh sisa makanan terhadap lapisan ozon bumi kita.</p>
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

    {{-- Cart Sidebar: hanya untuk konsumen yang login --}}
    @auth
        @if(Auth::user()->role === 'konsumen')
            <x-transaction.cart-sidebar />
        @endif
    @endauth
</div>

<script>
    // Flag dari PHP: apakah user adalah konsumen yang sudah login?
    const _isKonsumen = {{ (Auth::check() && Auth::user()->role === 'konsumen') ? 'true' : 'false' }};

    function foodSaveApp() {
        return {
            isCartOpen: false,
            isKonsumen: _isKonsumen,
            searchQuery: '',
            cart: JSON.parse(localStorage.getItem('foodsave_cart')) || [],
            cartAnimation: false,
            
            products: @json($menus),

            get filteredProducts() {
                return this.products.filter(p => p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || p.store.toLowerCase().includes(this.searchQuery.toLowerCase()));
            },

            get cartTotal() {
                return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
            },

            addToCart(product, event) {
                // 1. Logic Update Cart
                const existing = this.cart.find(item => item.id === product.id);
                if (existing) {
                    existing.qty++;
                } else {
                    this.cart.push({ ...product, qty: 1 });
                }
                this.saveCart();

                // 2. Fly to Cart Animation
                if (event) {
                    const btn = event.currentTarget;
                    const rect = btn.getBoundingClientRect();
                    const cartBtn = document.querySelector('.fab:not(.bg-red-500)'); // Find the cart button (not the back button)
                    const cartRect = cartBtn.getBoundingClientRect();

                    const flyEl = document.createElement('img');
                    flyEl.src = product.image;
                    flyEl.className = 'fly-item';
                    flyEl.style.left = `${rect.left}px`;
                    flyEl.style.top = `${rect.top}px`;
                    document.body.appendChild(flyEl);

                    // Force reflow
                    flyEl.offsetWidth;

                    // Animate to cart
                    flyEl.style.left = `${cartRect.left + 15}px`;
                    flyEl.style.top = `${cartRect.top + 15}px`;
                    flyEl.style.transform = 'scale(0.2) rotate(360deg)';
                    flyEl.style.opacity = '0.7';

                    setTimeout(() => {
                        flyEl.remove();
                        // 3. Trigger FAB animation on arrival
                        this.cartAnimation = true;
                        setTimeout(() => { this.cartAnimation = false; }, 600);
                    }, 800);
                } else {
                    // Fallback for non-event triggers
                    this.cartAnimation = true;
                    setTimeout(() => { this.cartAnimation = false; }, 600);
                }
            },

            removeFromCart(id) {
                this.cart = this.cart.filter(item => item.id !== id);
                this.saveCart();
            },

            updateQty(id, delta) {
                const item = this.cart.find(i => i.id === id);
                if (item) {
                    item.qty += delta;
                    if (item.qty <= 0) this.removeFromCart(id);
                    else this.saveCart();
                }
            },

            saveCart() {
                localStorage.setItem('foodsave_cart', JSON.stringify(this.cart));
            },

            saveCartToSession() {
                this.saveCart();
                
                // Sync to database
                if (this.isKonsumen && this.cart.length > 0) {
                    fetch('{{ route('cart.sync') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ cart: this.cart })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Cart synced to database');
                    })
                    .catch(error => {
                        console.error('Error syncing cart:', error);
                    });
                }
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }
        };
    }
</script>
</x-app-layout>