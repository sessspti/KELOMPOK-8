<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@0;1&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
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
    --lime-200: #d9f99d;
    --lime-300: #bef264;
    --yellow-200: #fef08a;
    --yellow-300: #fde047;
    --orange-400: #fb923c;
    --orange-500: #f97316;
    --ink:    #0f1d14;
    --muted:  #4b6358;
    --faint:  #8aab9a;
    --ghost:  #c4d9ce;
    --white:  #ffffff;
    --off:    #f7fdf9;
    --border: rgba(22,163,74,0.13);
    --border-md:  rgba(22,163,74,0.25);
    --border-str: rgba(22,163,74,0.4);
    --r-xs:  8px; --r-sm: 12px; --r-md: 18px;
    --r-lg:  24px; --r-xl: 32px; --r-pill: 999px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Sora', system-ui, sans-serif;
    background: var(--off); color: var(--ink);
    min-height: 100vh; overflow-x: hidden;
}
body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: radial-gradient(circle, rgba(22,163,74,0.11) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none; z-index: 0;
}

/* ─── HEADER ─── */
.hdr {
    position: sticky; top: 0; z-index: 100;
    background: rgba(247,253,249,0.9);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-bottom: 1.5px solid var(--border);
}
.hdr-inner {
    max-width: 1400px; margin: 0 auto;
    padding: 0 2rem; height: 90px;
    display: flex; align-items: center; gap: 1.25rem;
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
.hdr-divider { width: 1px; height: 28px; background: var(--border-md); flex-shrink: 0; }
.hdr-role {
    background: var(--mint-100); color: var(--mint-700);
    border: 1.5px solid var(--mint-200);
    font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    padding: 0.3rem 0.75rem; border-radius: var(--r-pill);
}
.hdr-right { margin-left: auto; display: flex; align-items: center; gap: 0.75rem; }

.store-btn {
    display: flex; align-items: center; gap: 7px;
    background: #fff; border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.35rem 0.9rem;
    font-family: 'Sora', sans-serif; font-size: 0.8125rem;
    font-weight: 600; color: var(--ink);
    cursor: pointer; transition: all 0.2s; white-space: nowrap;
}
.store-btn:hover { border-color: var(--mint-400); background: var(--mint-50); }
.sdot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--mint-500); flex-shrink: 0;
    animation: blink 2s ease-in-out infinite;
}
.sdot.off { background: var(--faint); animation: none; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.35} }

.notif-btn {
    position: relative; width: 40px; height: 40px;
    background: #fff; border: 1.5px solid var(--border);
    border-radius: var(--r-sm); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--muted); transition: all 0.2s;
}
.notif-btn:hover { border-color: var(--mint-400); color: var(--mint-600); }
.notif-btn svg { width: 18px; height: 18px; }
.ndot {
    position: absolute; top: 7px; right: 7px;
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--orange-500); border: 2px solid var(--off);
    animation: npulse 2s ease infinite;
}
@keyframes npulse {
    0%,100%{box-shadow:0 0 0 0 rgba(249,115,22,.4)}
    50%{box-shadow:0 0 0 5px rgba(249,115,22,0)}
}
.pts-pill {
    background: var(--yellow-300); color: #78350f;
    font-weight: 800; font-size: 0.8125rem;
    padding: 0.4rem 1rem; border-radius: var(--r-pill);
    letter-spacing: -0.01em; border: 2px solid rgba(0,0,0,0.07);
}

.logout-btn {
    display: flex; align-items: center; gap: 8px;
    background: #fff; border: 1.5px solid #fee2e2;
    border-radius: var(--r-sm); padding: 0.45rem 1rem;
    font-family: 'Sora', sans-serif; font-size: 0.8125rem;
    font-weight: 700; color: #dc2626;
    cursor: pointer; transition: all 0.2s;
}
.logout-btn:hover {
    background: #fef2f2; border-color: #fca5a5;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.08);
}
.logout-btn svg { width: 16px; height: 16px; }

/* ─── PAGE ─── */
.page {
    max-width: 1400px; margin: 0 auto;
    padding: 0 2rem 6rem; position: relative; z-index: 1;
}

/* ─── GREETING ─── */
.greet-wrap {
    padding: 2.5rem 0 2rem;
    display: flex; align-items: flex-end;
    justify-content: space-between; gap: 2rem; flex-wrap: wrap;
}
.greet-kicker {
    font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--mint-600); margin-bottom: 0.5rem;
    display: flex; align-items: center; gap: 6px;
}
.greet-kicker::before { content:''; width:16px; height:1.5px; background:var(--mint-500); }
.greet-title {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: clamp(2rem, 3.5vw, 2.75rem);
    letter-spacing: -0.05em; line-height: 1.05; color: var(--ink);
}
.greet-title em { font-style: normal; color: var(--mint-600); }
.greet-sub { font-size: 0.9375rem; color: var(--muted); margin-top: 0.5rem; }

.perf-chip {
    background: var(--mint-400); border-radius: var(--r-xl);
    padding: 1.375rem 1.875rem; min-width: 230px; flex-shrink: 0;
    position: relative; overflow: hidden;
}
.perf-chip::before {
    content:''; position:absolute; top:-35px; right:-35px;
    width:110px; height:110px;
    background:var(--lime-300); border-radius:50%; opacity:0.45;
}
.perf-kicker {
    font-size: 0.625rem; font-weight: 700;
    letter-spacing: 0.16em; text-transform: uppercase;
    color: var(--green-800); margin-bottom: 4px;
    position: relative; z-index: 1;
}
.perf-num {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 2.25rem; letter-spacing: -0.05em;
    color: var(--ink); line-height: 1;
    position: relative; z-index: 1;
}
.perf-num small { font-size: 0.875rem; font-weight: 600; }
.perf-desc { font-size: 0.8125rem; color: var(--green-800); font-weight: 500; margin-top: 3px; position: relative; z-index: 1; }

/* ─── BENTO ─── */
.bento {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 1rem;
}
.bc {
    background: #fff; border: 1.5px solid var(--border);
    border-radius: var(--r-xl); overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s, border-color 0.2s;
    position: relative;
}
.bc:hover { transform: translateY(-4px); border-color: var(--border-str); box-shadow: 0 16px 48px rgba(17,25,23,0.09); }
.bp { padding: 1.75rem 2rem; }

.c-stok    { grid-column: span 4; }
.c-kelola  { grid-column: span 4; }
.c-profil  { grid-column: span 4; }
.c-artikel { grid-column: span 6; }
.c-riwayat { grid-column: span 6; }

@media(max-width:1100px) {
    .c-stok,.c-kelola,.c-profil { grid-column: span 6; }
    .c-artikel,.c-riwayat { grid-column: span 12; }
}
@media(max-width:680px) {
    .bento { grid-template-columns: 1fr; }
    .c-stok,.c-kelola,.c-profil,.c-artikel,.c-riwayat { grid-column: span 1; }
}

/* ── STOK CARD ── */
.c-stok { background: var(--ink); border-color: var(--ink); }
.c-stok:hover { border-color: var(--mint-400); }
.stok-ey {
    display: flex; align-items: center; justify-content: space-between;
    font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--faint); margin-bottom: 1.25rem;
}
.live-dot {
    display: flex; align-items: center; gap: 5px;
    background: rgba(74,222,128,0.12);
    border: 1px solid rgba(74,222,128,0.3);
    color: var(--mint-300); border-radius: var(--r-pill);
    padding: 3px 9px; font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.1em;
}
.live-dot::before {
    content:''; width:5px; height:5px; border-radius:50%;
    background:var(--mint-400); animation:blink 1.4s ease-in-out infinite;
}
.stok-num {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 3.5rem; letter-spacing: -0.06em;
    color: #fff; line-height: 1;
}
.stok-sub { font-size: 0.8125rem; color: var(--faint); margin-top: 4px; }
.stok-warn {
    margin-top: 1.25rem;
    background: rgba(249,115,22,0.11);
    border: 1px solid rgba(249,115,22,0.22);
    border-radius: var(--r-md);
    padding: 0.75rem 1rem;
    display: flex; align-items: flex-start; gap: 9px;
}
.warn-ico {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--orange-500); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 10px; font-weight: 900;
}
.warn-txt { font-size: 0.8rem; color: var(--orange-400); font-weight: 600; line-height: 1.4; }

/* ── KELOLA CARD ── */
.c-kelola {
    background: var(--mint-400); border-color: var(--mint-300);
    cursor: pointer;
}
.c-kelola::before {
    content:''; position:absolute; bottom:-50px; right:-50px;
    width:150px; height:150px; background:var(--lime-300);
    border-radius:50%; opacity:0.5;
}
.c-kelola::after {
    content:''; position:absolute; top:-35px; left:-35px;
    width:110px; height:110px; background:var(--mint-200);
    border-radius:50%; opacity:0.45;
}
.kelola-z { position:relative; z-index:1; }
.kelola-icon {
    width: 52px; height: 52px; border-radius: var(--r-md);
    background: rgba(255,255,255,0.38);
    border: 2px solid rgba(255,255,255,0.55);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.375rem;
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.c-kelola:hover .kelola-icon { transform: scale(1.1) rotate(-8deg); }
.kelola-icon svg { width: 26px; height: 26px; color: var(--ink); }
.kelola-title {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 1.3125rem; letter-spacing: -0.04em;
    color: var(--ink); line-height: 1.1; margin-bottom: 0.5rem;
}
.kelola-desc { font-size: 0.8125rem; color: var(--green-800); line-height: 1.55; }
.kelola-cta {
    margin-top: 1.5rem;
    background: var(--ink); color: #fff; border: none;
    border-radius: var(--r-pill); padding: 0.65rem 1.375rem;
    display: inline-flex; align-items: center; gap: 7px;
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.8125rem; cursor: pointer; letter-spacing: -0.01em;
    transition: background 0.2s, transform 0.2s;
    text-decoration: none;
}
.kelola-cta:hover { background: var(--green-900); transform: translateX(3px); }
.kelola-cta svg { width: 14px; height: 14px; }

/* ── PROFIL CARD ── */
.profil-top {
    display: flex; align-items: flex-start;
    justify-content: space-between; margin-bottom: 1.25rem;
}
.profil-av {
    width: 52px; height: 52px; border-radius: var(--r-md);
    background: var(--mint-100); border: 2px solid var(--mint-200);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 1.1rem; color: var(--mint-600);
}
.edit-btn {
    background: var(--mint-50); border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.35rem 0.75rem;
    font-family: 'Sora', sans-serif; font-size: 0.75rem; font-weight: 600;
    color: var(--mint-700); cursor: pointer;
    display: flex; align-items: center; gap: 5px;
    transition: all 0.2s; text-decoration: none;
}
.edit-btn:hover { background: var(--mint-100); border-color: var(--mint-400); }
.edit-btn svg { width: 13px; height: 13px; }
.profil-name {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 1.125rem; letter-spacing: -0.04em; color: var(--ink);
    margin-bottom: 0.5rem;
}
.profil-row {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 0.8125rem; color: var(--muted); margin-bottom: 0.5rem; line-height: 1.4;
}
.profil-row svg { width: 13px; height: 13px; flex-shrink:0; color:var(--mint-500); margin-top:2px; }
.profil-hr { height: 1px; background: var(--border); margin: 1rem 0; }
.profil-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.pstat {
    background: var(--mint-50); border-radius: var(--r-md);
    padding: 0.75rem 1rem; border: 1px solid var(--border);
}
.pstat-num {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 1.5rem; letter-spacing: -0.05em; color: var(--mint-600); line-height: 1;
}
.pstat-lbl {
    font-size: 0.625rem; color: var(--muted);
    text-transform: uppercase; letter-spacing: 0.12em; margin-top: 3px;
}

/* ── ARTIKEL CARD ── */
.c-artikel { padding: 0; }
.card-hdr {
    padding: 1.5rem 2rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1.5px solid var(--border);
}
.kicker {
    font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--mint-600); margin-bottom: 3px;
    display: flex; align-items: center; gap: 5px;
}
.kicker::before { content:''; width:10px; height:1.5px; background:var(--mint-500); }
.card-hdr-title {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: 1rem; letter-spacing: -0.04em; color: var(--ink);
}
.see-all {
    font-size: 0.75rem; font-weight: 700;
    color: var(--mint-600); text-decoration: none;
    border-bottom: 1.5px solid var(--mint-300); padding-bottom: 1px;
    white-space: nowrap; transition: all 0.2s;
}
.see-all:hover { color: var(--mint-700); border-color: var(--mint-500); }

.art-item {
    display: flex; gap: 1rem; align-items: flex-start;
    padding: 1.125rem 2rem;
    border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background 0.15s;
}
.art-item:last-child { border-bottom: none; }
.art-item:hover { background: var(--mint-50); }
.art-thumb {
    width: 64px; height: 64px; border-radius: var(--r-md);
    overflow: hidden; flex-shrink: 0; background: var(--mint-100);
}
.art-thumb img { width: 100%; height: 100%; object-fit: cover; }
.art-tag {
    font-size: 0.5625rem; font-weight: 800;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--mint-600); margin-bottom: 4px;
}
.art-name {
    font-family: 'Sora', sans-serif; font-weight: 700;
    font-size: 0.875rem; letter-spacing: -0.025em;
    color: var(--ink); line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.art-time { font-size: 0.6875rem; color: var(--faint); margin-top: 4px; }

/* ── RIWAYAT CARD ── */
.c-riwayat { padding: 0; }
.tabs {
    display: flex; border-bottom: 1.5px solid var(--border);
}
.tab-btn {
    padding: 1.1rem 1.5rem;
    font-family: 'Sora', sans-serif; font-size: 0.8125rem; font-weight: 700;
    color: var(--faint); cursor: pointer;
    border: none; background: none;
    border-bottom: 2.5px solid transparent; margin-bottom: -1.5px;
    letter-spacing: -0.01em; transition: all 0.2s;
    display: flex; align-items: center; gap: 7px;
}
.tab-btn.on { color: var(--mint-600); border-bottom-color: var(--mint-500); }
.tab-count {
    background: var(--mint-100); color: var(--mint-700);
    font-size: 0.5625rem; font-weight: 800;
    width: 18px; height: 18px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.tab-count.org { background: rgba(249,115,22,0.1); color: var(--orange-500); }

.tab-pane { display: none; }
.tab-pane.on { display: block; }

/* notif items */
.nitem {
    display: flex; gap: 0.875rem; align-items: flex-start;
    padding: 1.1rem 1.75rem; border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background 0.15s;
}
.nitem:last-child { border-bottom: none; }
.nitem:hover, .nitem.unread { background: var(--mint-50); }
.nico {
    width: 36px; height: 36px; border-radius: var(--r-sm); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.nico.ord { background: var(--mint-100); color: var(--mint-600); }
.nico.wrn { background: rgba(249,115,22,0.1); color: var(--orange-500); }
.nico svg { width: 17px; height: 17px; }
.ntop { display: flex; align-items: center; gap: 6px; margin-bottom: 2px; }
.nname { font-size: 0.875rem; font-weight: 700; color: var(--ink); letter-spacing: -0.02em; }
.ndot-new { width: 6px; height: 6px; border-radius: 50%; background: var(--mint-500); }
.ndesc { font-size: 0.8125rem; color: var(--muted); line-height: 1.4; }
.ntime { font-size: 0.6875rem; color: var(--ghost); margin-top: 3px; }

/* riwayat items */
.ritem {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 1rem 1.75rem; border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background 0.15s;
}
.ritem:last-child { border-bottom: none; }
.ritem:hover { background: var(--mint-50); }
.rico {
    width: 36px; height: 36px; border-radius: var(--r-sm);
    background: var(--mint-100); color: var(--mint-600);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.rico svg { width: 17px; height: 17px; }
.rinfo { flex: 1; min-width: 0; }
.rname {
    font-size: 0.875rem; font-weight: 700;
    color: var(--ink); letter-spacing: -0.02em;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.rsub { font-size: 0.75rem; color: var(--muted); margin-top: 1px; display: flex; align-items: center; gap: 6px; }
.rprice {
    font-family: 'DM Mono', monospace;
    font-size: 0.875rem; font-weight: 500; color: var(--mint-600);
    text-align: right; flex-shrink: 0;
}
.rprice small { display: block; font-size: 0.625rem; color: var(--faint); }
.spill {
    font-size: 0.5625rem; font-weight: 800;
    letter-spacing: 0.1em; text-transform: uppercase;
    padding: 2px 7px; border-radius: var(--r-pill);
}
.s-done { background: var(--mint-100); color: var(--mint-700); }
.s-proc { background: var(--yellow-200); color: #78350f; }

/* ─── DYNAMIC TABLE ─── */
.sel-table { width: 100%; border-collapse: collapse; }
.sel-table th {
    padding: 1rem 1.75rem; text-align: left;
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; color: var(--faint);
    background: var(--off); border-bottom: 1.5px solid var(--border);
}
.sel-table td {
    padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border);
    font-size: 0.875rem; vertical-align: middle;
}
.status-select {
    appearance: none;
    background: #fff;
    border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm);
    padding: 0.4rem 2rem 0.4rem 1rem;
    font-family: inherit;
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234b6358'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 12px;
}
.status-select.selesai { border-color: var(--mint-400); color: var(--mint-600); }
.status-select.proses { border-color: var(--red-400); color: #dc2626; }
.status-select:focus { outline: none; border-color: var(--mint-500); box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}
.greet-wrap { animation: fadeUp 0.55s ease 0.05s both; }
.c-stok    { animation: fadeUp 0.5s ease 0.10s both; }
.c-kelola  { animation: fadeUp 0.5s ease 0.16s both; }
.c-profil  { animation: fadeUp 0.5s ease 0.22s both; }
.c-artikel { animation: fadeUp 0.5s ease 0.28s both; }
.c-riwayat { animation: fadeUp 0.5s ease 0.34s both; }
</style>

{{-- ── HEADER ── --}}
<header class="hdr">
    <div class="hdr-inner">
        <a href="{{ route('seller.dashboard') }}" class="logo">
            <img src="{{ asset('images/logo-foodsave.png') }}" alt="FoodSave" class="h-16 w-auto object-contain">
            <span class="ml-1">Food<span class="logo-text-save">Save</span></span>
        </a>
        <div class="hdr-divider"></div>
        <span class="hdr-role">✦ Seller Dashboard</span>
        <div class="hdr-right">
            {{-- Status Toko --}}
            <button class="store-btn" id="storeBtn" onclick="toggleStore()">
                <span class="sdot" id="sdot"></span>
                <span id="storeLabel">Toko Buka</span>
            </button>
            {{-- Notif --}}
            <button class="notif-btn" title="Notifikasi" onclick="switchTab('notif')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="ndot"></span>
            </button>
            <span class="pts-pill">✦ 150.000 FP</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<div class="page">

    {{-- ── GREETING ── --}}
    <div class="greet-wrap">
        <div>
            <p class="greet-kicker" id="greetKicker">Selamat Pagi</p>
            <h1 class="greet-title">Halo, <em>{{ Auth::user()->name ?? 'Seller' }}!</em></h1>
            <p class="greet-sub">Pantau aktivitas tokomu hari ini dari sini.</p>
        </div>
        <div class="perf-chip">
            <div class="perf-kicker">🌿 Performa Bulan Ini</div>
            <div class="perf-num">50 <small>kg</small></div>
            <div class="perf-desc">makanan berhasil diselamatkan</div>
        </div>
    </div>

    {{-- ══ BENTO ══ --}}
    <div class="bento">

        {{-- CARD 1 — Ringkasan Stok --}}
        <div class="bc c-stok bp">
            <div class="stok-ey">
                Ringkasan Stok
                <span class="live-dot">Live</span>
            </div>
            <div class="stok-num">7</div>
            <div class="stok-sub">menu aktif tersedia sekarang</div>
            <div class="stok-warn">
                <div class="warn-ico">!</div>
                <div class="warn-txt">3 menu dengan stok &lt; 5 porsi — segera perbarui sebelum kehabisan</div>
            </div>
        </div>

        {{-- CARD 2 — Kelola Menu (PINTU Dev 2) --}}
        <a href="{{ route('seller.manage') }}" class="bc c-kelola bp" style="text-decoration:none; display:block;">
            <div class="kelola-z">
                <div class="kelola-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="26" height="26">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="kelola-title">Kelola Menu<br>& Stok</div>
                <div class="kelola-desc">Tambah daftar baru, perbarui stok cepat, atur harga rescue deal produkmu.</div>
                <div class="kelola-cta">
                    Buka Halaman
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>
        </a>

        {{-- CARD 3 — Profil Toko --}}
        <div class="bc c-profil bp">
            <div class="profil-top">
                <div class="profil-av">
                    {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
                </div>
                <a href="{{ route('profile.edit') }}" class="edit-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Profil
                </a>
            </div>
            <div class="profil-name">{{ Auth::user()->name ?? 'Nama Toko' }}</div>
            <div class="profil-row">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                Jl. Cihampelas No. 42, Bandung
            </div>
            <div class="profil-row">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +62 812-3456-7890
            </div>
            <div class="profil-hr"></div>
            <div class="profil-stats">
                <div class="pstat">
                    <div class="pstat-num">4.8</div>
                    <div class="pstat-lbl">Rating Toko</div>
                </div>
                <div class="pstat">
                    <div class="pstat-num">128</div>
                    <div class="pstat-lbl">Total Klaim</div>
                </div>
            </div>
        </div>

        {{-- CARD 4 — Edukasi Artikel --}}
        <div class="bc c-artikel">
            <div class="card-hdr">
                <div>
                    <div class="kicker">Edukasi & Wawasan</div>
                    <div class="card-hdr-title">Artikel Terbaru</div>
                </div>
                <a href="#" class="see-all">Lihat Semua →</a>
            </div>
            <div class="art-item">
                <div class="art-thumb">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=200" alt="">
                </div>
                <div>
                    <div class="art-tag">Tips Operasional</div>
                    <div class="art-name">5 Cara Efektif Mengurangi Food Waste di Dapur Katering</div>
                    <div class="art-time">2 jam lalu</div>
                </div>
            </div>
            <div class="art-item">
                <div class="art-thumb">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=200" alt="">
                </div>
                <div>
                    <div class="art-tag">Kebijakan Pemerintah</div>
                    <div class="art-name">Regulasi Terbaru: Insentif Pajak untuk Bisnis Ramah Lingkungan 2025</div>
                    <div class="art-time">1 hari lalu</div>
                </div>
            </div>
            <div class="art-item">
                <div class="art-thumb">
                    <img src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?q=80&w=200" alt="">
                </div>
                <div>
                    <div class="art-tag">Inspirasi Seller</div>
                    <div class="art-name">Seller of the Month: Warung Bu Sari Selamatkan 200 kg Makanan</div>
                    <div class="art-time">3 hari lalu</div>
                </div>
            </div>
        </div>

        {{-- CARD 5 — Notifikasi & Riwayat --}}
        <div class="bc c-riwayat">
            <div class="tabs">
                <button class="tab-btn on" id="btn-notif" onclick="switchTab('notif')">
                    Notifikasi Pesanan
                    <span class="tab-count org">3</span>
                </button>
                <button class="tab-btn" id="btn-riwayat" onclick="switchTab('riwayat')">
                    Riwayat Penjualan
                    <span class="tab-count">12</span>
                </button>
            </div>

            {{-- Pane: Notifikasi --}}
            <div class="tab-pane on" id="pane-notif">
                <div class="nitem unread">
                    <div class="nico ord">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div>
                        <div class="ntop">
                            <div class="nname">Reservasi Baru Masuk!</div>
                            <div class="ndot-new"></div>
                        </div>
                        <div class="ndesc">Andi Pratama memesan 2 porsi <strong>Nasi Box Surplus</strong></div>
                        <div class="ntime">5 menit lalu · Menunggu konfirmasi</div>
                    </div>
                </div>
                <div class="nitem unread">
                    <div class="nico ord">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <div class="ntop">
                            <div class="nname">Klaim Lembaga Sosial</div>
                            <div class="ndot-new"></div>
                        </div>
                        <div class="ndesc">Rumah Yatim Al-Ikhlas mengklaim 10 porsi <strong>Paket Hemat Sore</strong></div>
                        <div class="ntime">22 menit lalu · Menunggu konfirmasi</div>
                    </div>
                </div>
                <div class="nitem">
                    <div class="nico wrn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="ntop"><div class="nname">Stok Hampir Habis</div></div>
                        <div class="ndesc">Menu <strong>Ayam Geprek Surplus</strong> hanya tersisa 2 porsi</div>
                        <div class="ntime">1 jam lalu</div>
                    </div>
                </div>
            </div>

            {{-- Pane: Riwayat (Dynamic Table) --}}
            <div class="tab-pane" id="pane-riwayat">
                <div style="overflow-x: auto;">
                    <table class="sel-table">
                        <thead>
                            <tr>
                                <th>Nama Makanan</th>
                                <th>Pemesan</th>
                                <th>Keterangan Transaksi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td style="font-weight: 700;">{{ $order->menu->name }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $order->user->name }}</div>
                                    <div style="font-size: 0.65rem; color: var(--faint); text-transform: uppercase; letter-spacing: 0.05em;">
                                        {{ $order->user->role === 'lembaga_sosial' ? 'Lembaga' : 'Konsumen' }}
                                    </div>
                                </td>
                                <td>
                                    @if($order->user->role === 'lembaga_sosial')
                                        <div style="color: #0284c7; font-weight: 700;">
                                            {{ $order->quantity }} porsi (Donasi)
                                        </div>
                                    @else
                                        <div style="color: var(--mint-600); font-weight: 700;">
                                            Rp {{ number_format(($order->menu->price * ($order->menu->discount / 100)) * $order->quantity, 0, ',', '.') }} (Diskon)
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        <select name="status" class="status-select {{ strtolower($order->status) === 'selesai' ? 'selesai' : 'proses' }}" onchange="this.form.submit()">
                                            <option value="Proses" {{ $order->status === 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--faint); padding: 3rem;">Belum ada pesanan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>{{-- /.bento --}}
</div>{{-- /.page --}}

<script>
/* Greeting time */
(function(){
    const h = new Date().getHours();
    const el = document.getElementById('greetKicker');
    if(el) el.textContent = h<11?'Selamat Pagi ☀️':h<15?'Selamat Siang 🌤':h<18?'Selamat Sore 🌅':'Selamat Malam 🌙';
})();

/* Store toggle */
let open = true;
function toggleStore(){
    open = !open;
    document.getElementById('sdot').classList.toggle('off', !open);
    document.getElementById('storeLabel').textContent = open ? 'Toko Buka' : 'Toko Tutup';
}

/* Tab switch */
function switchTab(name){
    ['notif','riwayat'].forEach(n => {
        document.getElementById('pane-'+n).classList.toggle('on', n===name);
        document.getElementById('btn-'+n).classList.toggle('on', n===name);
    });
    if(name==='notif'){
        document.querySelector('.bc.c-riwayat').scrollIntoView({behavior:'smooth',block:'nearest'});
    }
}
</script>
</x-app-layout>