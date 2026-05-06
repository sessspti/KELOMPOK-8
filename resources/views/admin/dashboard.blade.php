
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ═══════════════ TOKENS ═══════════════ */
:root {
    --blue-25:  #f5f8ff;
    --blue-50:  #eff4ff;
    --blue-100: #dae4ff;
    --blue-200: #bdd0ff;
    --blue-300: #93affe;
    --blue-400: #6483fd;
    --blue-500: #4361f5;
    --blue-600: #3246e0;
    --blue-700: #2936c7;
    --blue-800: #2530a0;
    --sky-100:  #e0f5fe;
    --sky-300:  #7dd3fc;
    --sky-500:  #0ea5e9;
    --indigo-100: #e0e7ff;
    --indigo-500: #6366f1;
    --violet-100: #ede9fe;
    --violet-500: #8b5cf6;
    --mint-100: #d1fae5;
    --mint-500: #10b981;
    --mint-600: #059669;
    --amber-100: #fef3c7;
    --amber-500: #f59e0b;
    --orange-100: #ffedd5;
    --orange-500: #f97316;
    --red-100:  #fee2e2;
    --red-500:  #ef4444;
    --red-600:  #dc2626;
    --ink:      #0d1526;
    --ink-2:    #1e2d4a;
    --muted:    #5a6a88;
    --faint:    #94a3b8;
    --ghost:    #cbd5e1;
    --white:    #ffffff;
    --surface:  #ffffff;
    --bg:       #f0f5ff;
    --border:   rgba(67,97,245,0.12);
    --border-md: rgba(67,97,245,0.22);
    --border-str: rgba(67,97,245,0.38);
    --r-xs: 6px; --r-sm: 10px; --r-md: 14px;
    --r-lg: 20px; --r-xl: 28px; --r-2xl: 36px;
    --r-pill: 999px;
    --shadow-sm: 0 1px 4px rgba(67,97,245,0.08);
    --shadow-md: 0 4px 16px rgba(67,97,245,0.12);
    --shadow-lg: 0 12px 40px rgba(67,97,245,0.14);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    background: var(--bg);
    color: var(--ink);
    min-height: 100vh;
    display: flex;
    overflow-x: hidden;
}

/* dot-grid bg */
body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: radial-gradient(circle, rgba(67,97,245,0.09) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none; z-index: 0;
}

/* ═══════════════ SIDEBAR ═══════════════ */
.sidebar {
    width: 260px; flex-shrink: 0;
    background: var(--ink);
    min-height: 100vh; position: sticky; top: 0; height: 100vh;
    display: flex; flex-direction: column;
    z-index: 50;
    overflow: hidden;
}
.sidebar::before {
    content: '';
    position: absolute; top: -80px; left: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(67,97,245,0.3) 0%, transparent 70%);
    pointer-events: none;
}
.sidebar::after {
    content: '';
    position: absolute; bottom: -60px; right: -40px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(99,129,253,0.2) 0%, transparent 70%);
    pointer-events: none;
}

.sb-brand {
    padding: 1.75rem 1.5rem 1.25rem;
    display: flex; align-items: center; gap: 10px;
    position: relative; z-index: 1;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.sb-logo {
    width: 34px; height: 34px; border-radius: 10px;
    background: linear-gradient(135deg, var(--blue-400), var(--indigo-500));
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(67,97,245,0.4);
}
.sb-logo svg { width: 18px; height: 18px; color: #fff; }
.sb-name {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-weight: 700; font-size: 1.1875rem; letter-spacing: -0.04em; color: #fff;
}
.sb-name em { color: var(--blue-300); font-style: normal; }
.sb-admin-tag {
    background: rgba(67,97,245,0.2); border: 1px solid rgba(100,131,253,0.3);
    color: var(--blue-300); font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    padding: 2px 8px; border-radius: var(--r-pill);
    margin-left: auto; white-space: nowrap;
}

.sb-nav { padding: 1rem 0.875rem; flex: 1; overflow-y: auto; position: relative; z-index: 1; }
.sb-section-label {
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
    color: rgba(255,255,255,0.28); padding: 0 0.75rem; margin: 0.75rem 0 0.375rem;
}
.sb-item {
    display: flex; align-items: center; gap: 10px;
    padding: 0.6rem 0.875rem; border-radius: var(--r-md);
    font-size: 0.875rem; font-weight: 500; color: rgba(255,255,255,0.55);
    cursor: pointer; transition: all 0.18s; text-decoration: none;
    margin-bottom: 2px; position: relative;
}
.sb-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
.sb-item.active {
    background: rgba(67,97,245,0.22); color: #fff;
    border: 1px solid rgba(100,131,253,0.25);
}
.sb-item.active::before {
    content: '';
    position: absolute; left: 0; top: 20%; bottom: 20%;
    width: 3px; border-radius: 2px; background: var(--blue-400);
}
.sb-item svg { width: 16px; height: 16px; flex-shrink: 0; }
.sb-badge {
    margin-left: auto; background: var(--red-500);
    color: #fff; font-size: 0.5625rem; font-weight: 800;
    min-width: 18px; height: 18px; border-radius: var(--r-pill);
    display: flex; align-items: center; justify-content: center;
    padding: 0 5px;
}
.sb-badge.blue { background: var(--blue-500); }

.sb-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid rgba(255,255,255,0.07);
    position: relative; z-index: 1;
}
.sb-user {
    display: flex; align-items: center; gap: 10px;
}
.sb-avatar {
    width: 34px; height: 34px; border-radius: 10px;
    background: linear-gradient(135deg, var(--blue-400), var(--indigo-500));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700;
    font-size: 0.8125rem; color: #fff; flex-shrink: 0;
}
.sb-user-name { font-size: 0.875rem; font-weight: 600; color: #fff; letter-spacing: -0.02em; }
.sb-user-role { font-size: 0.6875rem; color: rgba(255,255,255,0.4); }

/* ═══════════════ MAIN CONTENT ═══════════════ */
.main {
    flex: 1; min-width: 0;
    display: flex; flex-direction: column;
    position: relative; z-index: 1;
}

/* ═══════════════ TOP BAR ═══════════════ */
.topbar {
    background: rgba(240,245,255,0.85);
    backdrop-filter: blur(16px);
    border-bottom: 1.5px solid var(--border);
    padding: 0 2rem; height: 64px;
    display: flex; align-items: center; gap: 1rem;
    position: sticky; top: 0; z-index: 40;
}
.topbar-title {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-weight: 700; font-size: 1.125rem; letter-spacing: -0.04em; color: var(--ink);
}
.topbar-sub { font-size: 0.8125rem; color: var(--muted); margin-top: 1px; }
.topbar-right { margin-left: auto; display: flex; align-items: center; gap: 0.75rem; }

.tb-search {
    position: relative; width: 220px;
}
.tb-search input {
    width: 100%; background: var(--surface); border: 1.5px solid var(--border-md);
    border-radius: var(--r-pill); padding: 0.45rem 1rem 0.45rem 2.25rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8125rem; color: var(--ink);
    outline: none; transition: all 0.2s;
}
.tb-search input:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(67,97,245,0.12); }
.tb-search input::placeholder { color: var(--faint); }
.tb-search-ico {
    position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
    width: 14px; height: 14px; color: var(--faint); pointer-events: none;
}

.tb-icon-btn {
    width: 36px; height: 36px; border-radius: var(--r-sm);
    background: var(--surface); border: 1.5px solid var(--border-md);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--muted); position: relative; transition: all 0.18s;
}
.tb-icon-btn:hover { border-color: var(--blue-400); color: var(--blue-500); }
.tb-icon-btn svg { width: 16px; height: 16px; }
.tb-notif-dot {
    position: absolute; top: 6px; right: 6px;
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--red-500); border: 1.5px solid var(--bg);
}

/* ═══════════════ PAGE BODY ═══════════════ */
.content { padding: 2rem; display: flex; flex-direction: column; gap: 2rem; }

/* ═══════════════ STAT CARDS ═══════════════ */
.stat-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
}
@media(max-width:1100px){.stat-grid{grid-template-columns:repeat(2,1fr)}}

.stat-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); padding: 1.5rem 1.625rem;
    position: relative; overflow: hidden;
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.stat-card::before {
    content: ''; position: absolute; top: -24px; right: -24px;
    width: 80px; height: 80px; border-radius: 50%; opacity: 0.12;
}
.stat-card.blue::before  { background: var(--blue-500); opacity: 0.15; }
.stat-card.sky::before   { background: var(--sky-500); opacity: 0.15; }
.stat-card.mint::before  { background: var(--mint-500); opacity: 0.15; }
.stat-card.amber::before { background: var(--amber-500); opacity: 0.15; }

.stat-icon {
    width: 40px; height: 40px; border-radius: var(--r-md);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.125rem; flex-shrink: 0;
}
.stat-icon.blue   { background: var(--blue-100); color: var(--blue-600); }
.stat-icon.sky    { background: var(--sky-100); color: var(--sky-500); }
.stat-icon.mint   { background: var(--mint-100); color: var(--mint-600); }
.stat-icon.amber  { background: var(--amber-100); color: var(--amber-500); }
.stat-icon svg { width: 20px; height: 20px; }

.stat-label {
    font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--faint); margin-bottom: 0.375rem;
}
.stat-num {
    font-family: 'Bricolage Grotesque', sans-serif; font-weight: 800;
    font-size: 2.25rem; letter-spacing: -0.05em; color: var(--ink); line-height: 1;
}
.stat-delta {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.75rem; font-weight: 600; margin-top: 0.5rem;
}
.stat-delta.up   { color: var(--mint-500); }
.stat-delta.down { color: var(--red-500); }
.stat-delta svg { width: 13px; height: 13px; }

/* ═══════════════ SECTION WRAPPER ═══════════════ */
.sec {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); overflow: hidden;
}
.sec-hdr {
    padding: 1.375rem 1.75rem;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
}
.sec-hdr-left {}
.sec-kicker {
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--blue-500); margin-bottom: 3px;
    display: flex; align-items: center; gap: 5px;
}
.sec-kicker::before { content:''; width:10px; height:1.5px; background:var(--blue-400); }
.sec-title {
    font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700;
    font-size: 1.0625rem; letter-spacing: -0.04em; color: var(--ink);
}
.sec-hdr-right { margin-left: auto; display: flex; align-items: center; gap: 0.625rem; flex-wrap: wrap; }

/* ─── BUTTONS ─── */
.btn {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: var(--r-sm); padding: 0.45rem 0.9rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8125rem;
    font-weight: 600; cursor: pointer; border: none;
    transition: all 0.18s; white-space: nowrap; text-decoration: none;
    letter-spacing: -0.01em;
}
.btn svg { width: 14px; height: 14px; }
.btn-primary { background: var(--blue-500); color: #fff; box-shadow: 0 2px 8px rgba(67,97,245,0.3); }
.btn-primary:hover { background: var(--blue-600); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(67,97,245,0.4); }
.btn-outline { background: var(--white); color: var(--muted); border: 1.5px solid var(--border-md); }
.btn-outline:hover { border-color: var(--blue-400); color: var(--blue-600); }
.btn-danger  { background: var(--red-100); color: var(--red-600); border: 1px solid rgba(239,68,68,0.2); }
.btn-danger:hover  { background: var(--red-500); color: #fff; }
.btn-success { background: var(--mint-100); color: var(--mint-600); border: 1px solid rgba(16,185,129,0.2); }
.btn-success:hover { background: var(--mint-500); color: #fff; }
.btn-amber   { background: var(--amber-100); color: #92400e; border: 1px solid rgba(245,158,11,0.2); }
.btn-amber:hover   { background: var(--amber-500); color: #fff; }
.btn-xs { padding: 0.25rem 0.625rem; font-size: 0.75rem; }
.btn-xs svg { width: 12px; height: 12px; }
.btn-icon {
    width: 32px; height: 32px; padding: 0; border-radius: var(--r-sm);
    display: flex; align-items: center; justify-content: center;
}
.btn-icon svg { width: 15px; height: 15px; }

/* ─── SEARCH INPUT ─── */
.tbl-search {
    position: relative;
}
.tbl-search input {
    background: var(--blue-25); border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.4rem 0.875rem 0.4rem 2.1rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8125rem; color: var(--ink);
    outline: none; transition: all 0.18s; width: 200px;
}
.tbl-search input:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(67,97,245,0.1); }
.tbl-search input::placeholder { color: var(--faint); }
.tbl-search svg {
    position: absolute; left: 0.625rem; top: 50%; transform: translateY(-50%);
    width: 13px; height: 13px; color: var(--faint); pointer-events: none;
}

/* ─── FILTER TABS ─── */
.filter-tabs { display: flex; gap: 0; }
.ftab {
    padding: 0.35rem 0.875rem; font-size: 0.8125rem; font-weight: 600;
    cursor: pointer; border: 1.5px solid var(--border-md);
    background: var(--white); color: var(--muted);
    transition: all 0.15s; white-space: nowrap;
}
.ftab:first-child { border-radius: var(--r-sm) 0 0 var(--r-sm); }
.ftab:last-child  { border-radius: 0 var(--r-sm) var(--r-sm) 0; border-left: none; }
.ftab:not(:first-child):not(:last-child) { border-left: none; }
.ftab.on { background: var(--blue-500); color: #fff; border-color: var(--blue-500); }
.ftab:hover:not(.on) { color: var(--blue-600); border-color: var(--blue-300); z-index: 1; }

/* ─── TABLE ─── */
.tbl-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 0.75rem 1.25rem; text-align: left;
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--faint); background: var(--blue-25);
    border-bottom: 1.5px solid var(--border); white-space: nowrap;
}
tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.12s;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: var(--blue-25); }
tbody td {
    padding: 0.875rem 1.25rem; font-size: 0.875rem;
    color: var(--ink); vertical-align: middle;
}

.td-user { display: flex; align-items: center; gap: 10px; }
.td-avatar {
    width: 32px; height: 32px; border-radius: var(--r-sm); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700;
    font-size: 0.75rem; color: #fff;
}
.td-avatar.blue   { background: linear-gradient(135deg,var(--blue-400),var(--indigo-500)); }
.td-avatar.sky    { background: linear-gradient(135deg,var(--sky-300),var(--sky-500)); }
.td-avatar.mint   { background: linear-gradient(135deg,#34d399,var(--mint-500)); }
.td-avatar.amber  { background: linear-gradient(135deg,#fbbf24,var(--amber-500)); }
.td-avatar.violet { background: linear-gradient(135deg,#a78bfa,var(--violet-500)); }

.td-name { font-weight: 600; letter-spacing: -0.02em; }
.td-email { font-size: 0.75rem; color: var(--muted); margin-top: 1px; }
.td-mono { font-family: 'JetBrains Mono', monospace; font-size: 0.8125rem; }

/* ─── PILLS ─── */
.pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    padding: 3px 9px; border-radius: var(--r-pill);
}
.pill::before { content:''; width:5px; height:5px; border-radius:50%; }
.pill.konsumen { background:var(--blue-100); color:var(--blue-700); }
.pill.konsumen::before { background:var(--blue-500); }
.pill.lembaga  { background:var(--indigo-100); color:#4338ca; }
.pill.lembaga::before  { background:var(--indigo-500); }
.pill.fnb      { background:var(--mint-100); color:var(--mint-600); }
.pill.fnb::before      { background:var(--mint-500); }
.pill.aktif    { background:var(--mint-100); color:var(--mint-600); }
.pill.aktif::before    { background:var(--mint-500); }
.pill.suspend  { background:var(--amber-100); color:#92400e; }
.pill.suspend::before  { background:var(--amber-500); }
.pill.pending  { background:var(--orange-100); color:#9a3412; }
.pill.pending::before  { background:var(--orange-500); }
.pill.selesai  { background:var(--mint-100); color:var(--mint-600); }
.pill.selesai::before  { background:var(--mint-500); }
.pill.proses   { background:var(--blue-100); color:var(--blue-700); }
.pill.proses::before   { background:var(--blue-500); }
.pill.keluhan  { background:var(--red-100); color:var(--red-600); }
.pill.keluhan::before  { background:var(--red-500); }
.pill.ditangani{ background:var(--mint-100); color:var(--mint-600); }
.pill.ditangani::before{background:var(--mint-500);}

/* ─── ACTIONS ROW ─── */
.actions { display: flex; align-items: center; gap: 0.375rem; }

/* ─── PENDING VALIDASI ─── */
.pending-card {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.75rem; border-bottom: 1px solid var(--border);
    transition: background 0.12s;
}
.pending-card:last-child { border-bottom: none; }
.pending-card:hover { background: var(--blue-25); }
.pending-av {
    width: 40px; height: 40px; border-radius: var(--r-md); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700;
    font-size: 0.875rem; color: #fff;
    background: linear-gradient(135deg,var(--blue-400),var(--indigo-500));
}
.pending-info { flex: 1; min-width: 0; }
.pending-name { font-weight: 700; font-size: 0.9375rem; letter-spacing: -0.025em; color: var(--ink); }
.pending-meta { font-size: 0.8125rem; color: var(--muted); margin-top: 2px; }
.pending-actions { display: flex; gap: 0.5rem; flex-shrink: 0; }

/* ─── LOG TRANSAKSI ─── */
.log-id { font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: var(--blue-500); font-weight: 500; }

/* ─── KELUHAN CARD ─── */
.keluhan-card {
    padding: 1.125rem 1.75rem; border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background 0.12s;
}
.keluhan-card:last-child { border-bottom: none; }
.keluhan-card:hover { background: var(--blue-25); }
.keluhan-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 0.375rem; }
.keluhan-title { font-weight: 700; font-size: 0.9375rem; letter-spacing: -0.025em; color: var(--ink); }
.keluhan-meta { font-size: 0.8125rem; color: var(--muted); }
.keluhan-desc { font-size: 0.8125rem; color: var(--muted); margin-top: 0.25rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* ─── ARTIKEL MANAJEMEN ─── */
.artikel-row {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.75rem; border-bottom: 1px solid var(--border);
    transition: background 0.12s;
}
.artikel-row:last-child { border-bottom: none; }
.artikel-row:hover { background: var(--blue-25); }
.artikel-thumb {
    width: 52px; height: 52px; border-radius: var(--r-md);
    overflow: hidden; flex-shrink: 0; background: var(--blue-100);
}
.artikel-thumb img { width: 100%; height: 100%; object-fit: cover; }
.artikel-info { flex: 1; min-width: 0; }
.artikel-title-row { font-weight: 700; font-size: 0.9rem; letter-spacing: -0.025em; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.artikel-meta { font-size: 0.75rem; color: var(--muted); margin-top: 2px; display: flex; align-items: center; gap: 8px; }

/* ─── PENGATURAN GRID ─── */
.setting-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1.5rem 1.75rem;
}
@media(max-width:900px){.setting-grid{grid-template-columns:1fr}}

.setting-card {
    background: var(--blue-25); border: 1.5px solid var(--border);
    border-radius: var(--r-lg); padding: 1.25rem 1.375rem;
    transition: border-color 0.18s;
}
.setting-card:hover { border-color: var(--blue-300); }
.setting-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 0.875rem;
}
.setting-icon {
    width: 36px; height: 36px; border-radius: var(--r-sm);
    display: flex; align-items: center; justify-content: center;
}
.setting-icon.blue { background: var(--blue-100); color: var(--blue-600); }
.setting-icon.violet { background: var(--violet-100); color: var(--violet-500); }
.setting-icon svg { width: 18px; height: 18px; }
.setting-title { font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700; font-size: 0.9375rem; letter-spacing: -0.035em; color: var(--ink); }
.setting-sub { font-size: 0.8125rem; color: var(--muted); margin-top: 3px; line-height: 1.45; }

/* ─── CATEGORY CHIPS ─── */
.cat-wrap { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem; }
.cat-chip {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--surface); border: 1.5px solid var(--border-md);
    border-radius: var(--r-pill); padding: 0.25rem 0.75rem;
    font-size: 0.8125rem; font-weight: 500; color: var(--ink);
    cursor: pointer; transition: all 0.15s;
}
.cat-chip:hover { border-color: var(--blue-400); color: var(--blue-600); }
.cat-chip-del {
    width: 14px; height: 14px; border-radius: 50%;
    background: var(--border-md); display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: 9px; font-weight: 800; transition: all 0.15s;
}
.cat-chip:hover .cat-chip-del { background: var(--red-500); color: #fff; }
.cat-add {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--blue-50); border: 1.5px dashed var(--blue-200);
    border-radius: var(--r-pill); padding: 0.25rem 0.75rem;
    font-size: 0.8125rem; font-weight: 600; color: var(--blue-500);
    cursor: pointer; transition: all 0.15s;
}
.cat-add:hover { background: var(--blue-100); border-color: var(--blue-400); }
.cat-add svg { width: 12px; height: 12px; }

/* ─── NOTIF FORM ─── */
.notif-form { margin-top: 1rem; display: flex; flex-direction: column; gap: 0.625rem; }
.nf-row { display: flex; gap: 0.5rem; }
.nf-input {
    flex: 1; background: var(--surface); border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.45rem 0.75rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8125rem; color: var(--ink);
    outline: none; transition: all 0.18s;
}
.nf-input:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(67,97,245,0.1); }
.nf-input::placeholder { color: var(--faint); }
textarea.nf-input { resize: none; height: 72px; font-family: inherit; }

/* ─── TWO COLUMN ─── */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media(max-width:900px){.two-col{grid-template-columns:1fr}}

/* ─── ANIMATIONS ─── */
@keyframes fadeUp {
    from { opacity:0; transform: translateY(18px); }
    to   { opacity:1; transform: translateY(0); }
}
.stat-card:nth-child(1){ animation: fadeUp 0.45s ease 0.05s both; }
.stat-card:nth-child(2){ animation: fadeUp 0.45s ease 0.10s both; }
.stat-card:nth-child(3){ animation: fadeUp 0.45s ease 0.15s both; }
.stat-card:nth-child(4){ animation: fadeUp 0.45s ease 0.20s both; }
.sec { animation: fadeUp 0.5s ease 0.25s both; }

/* ─── MODAL ─── */
.modal-overlay {
    position: fixed; inset: 0; background: rgba(13,21,38,0.5);
    z-index: 900; display: none; align-items: center; justify-content: center;
    backdrop-filter: blur(4px);
}
.modal-overlay.open { display: flex; }
.modal {
    background: var(--surface); border-radius: var(--r-xl);
    width: min(500px, 95vw); max-height: 85vh; overflow-y: auto;
    box-shadow: var(--shadow-lg); border: 1.5px solid var(--border-md);
    animation: fadeUp 0.3s ease both;
}
.modal-hdr {
    padding: 1.375rem 1.75rem;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.modal-title { font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700; font-size: 1rem; letter-spacing: -0.04em; color: var(--ink); }
.modal-close {
    width: 30px; height: 30px; border-radius: var(--r-sm);
    border: 1.5px solid var(--border-md); background: var(--bg);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--muted); transition: all 0.15s;
}
.modal-close:hover { background: var(--red-100); color: var(--red-600); border-color: var(--red-100); }
.modal-close svg { width: 14px; height: 14px; }
.modal-body { padding: 1.375rem 1.75rem; display: flex; flex-direction: column; gap: 1rem; }
.field label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--ink); margin-bottom: 0.375rem; }
.field input, .field select, .field textarea {
    width: 100%; background: var(--bg); border: 1.5px solid var(--border-md);
    border-radius: var(--r-sm); padding: 0.55rem 0.875rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: var(--ink);
    outline: none; transition: all 0.18s;
}
.field input:focus, .field select:focus, .field textarea:focus {
    border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(67,97,245,0.1);
    background: var(--white);
}
.field textarea { resize: none; height: 80px; }
.modal-footer {
    padding: 1rem 1.75rem; border-top: 1.5px solid var(--border);
    display: flex; justify-content: flex-end; gap: 0.625rem;
}

/* page scroll */
body.no-scroll { overflow: hidden; }
</style>

{{-- ════════════ SIDEBAR ════════════ --}}
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
        </div>
        <span class="sb-name">Food<em>Save</em></span>
        <span class="sb-admin-tag">Admin</span>
    </div>

    <nav class="sb-nav">
        <div class="sb-section-label">Overview</div>
        <a href="#" class="sb-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="sb-section-label">Manajemen</div>
        <a href="#sec-user" class="sb-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Manajemen Pengguna
            <span class="sb-badge">3</span>
        </a>
        <a href="#sec-monitor" class="sb-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Monitoring & Log
        </a>
        <a href="#sec-artikel" class="sb-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Manajemen Konten
        </a>

        <div class="sb-section-label">Sistem</div>
        <a href="#sec-setting" class="sb-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            Pengaturan Sistem
        </a>
        <a href="#" class="sb-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            Notifikasi Sistem
            <span class="sb-badge blue">2</span>
        </a>
    </nav>

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">SA</div>
            <div>
                <div class="sb-user-name">Super Admin</div>
                <div class="sb-user-role">admin@foodsave.id</div>
            </div>
        </div>
    </div>
</aside>

{{-- ════════════ MAIN ════════════ --}}
<div class="main">
    {{-- TOP BAR --}}
    <div class="topbar">
        <div>
            <div class="topbar-title">Dashboard Admin</div>
        </div>
        <div class="topbar-right">
            <div class="tb-search">
                <svg class="tb-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari pengguna, transaksi...">
            </div>
            <button class="tb-icon-btn" title="Notifikasi">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="tb-notif-dot"></span>
            </button>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="pts-pill" style="cursor:pointer; background: #fee2e2; color: #991b1b; border: 2px solid rgba(239,68,68,0.2); transition: background 0.2s;" onmouseover="this.style.background='#fca5a5'" onmouseout="this.style.background='#fee2e2'">
                    Keluar
                </button>
            </form>
            <button class="tb-icon-btn" title="Ekspor Data">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </button>
        </div>
    </div>

    <div class="content">

        {{-- ══ 1. STATISTIK UTAMA ══ --}}
        <div class="stat-grid">
            <div class="stat-card blue">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-num">4.821</div>
                <div class="stat-delta up">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +128 bulan ini
                </div>
            </div>
            <div class="stat-card sky">
                <div class="stat-icon sky">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="stat-label">Merchant Aktif</div>
                <div class="stat-num">312</div>
                <div class="stat-delta up">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +24 merchant baru
                </div>
            </div>
            <div class="stat-card mint">
                <div class="stat-icon mint">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div class="stat-label">Volume Penyelamatan</div>
                <div class="stat-num">18.4<span style="font-size:1.25rem;"> ton</span></div>
                <div class="stat-delta up">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +2.1 ton bulan ini
                </div>
            </div>
            <div class="stat-card amber">
                <div class="stat-icon amber">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="stat-label">Total Transaksi & Donasi</div>
                <div class="stat-num">9.307</div>
                <div class="stat-delta up">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +341 minggu ini
                </div>
            </div>
        </div>

        {{-- ══ 2. MANAJEMEN PENGGUNA ══ --}}
        <div id="sec-user" class="sec">
            <div class="sec-hdr">
                <div class="sec-hdr-left">
                    <div class="sec-kicker">Manajemen Pengguna</div>
                    <div class="sec-title">Daftar Semua Akun</div>
                </div>
                <div class="sec-hdr-right">
                    <div class="tbl-search">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" placeholder="Cari pengguna...">
                    </div>
                    <div class="filter-tabs">
                        <button class="ftab on" onclick="setTab(this,'all')">Semua</button>
                        <button class="ftab" onclick="setTab(this,'konsumen')">Konsumen</button>
                        <button class="ftab" onclick="setTab(this,'lembaga')">Lembaga</button>
                        <button class="ftab" onclick="setTab(this,'fnb')">F&B</button>
                    </div>
                    <button class="btn btn-primary" onclick="openModal('addUser')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Akun
                    </button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Transaksi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar blue">AP</div><div><div class="td-name">Andi Pratama</div><div class="td-email">andi@email.com</div></div></div></td>
                            <td><span class="pill konsumen">Konsumen</span></td>
                            <td class="td-mono">12 Mar 2025</td>
                            <td class="td-mono">24</td>
                            <td><span class="pill aktif">Aktif</span></td>
                            <td><div class="actions">
                                <button class="btn btn-outline btn-xs btn-icon" title="Edit"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="btn btn-amber btn-xs btn-icon" title="Suspend"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
                                <button class="btn btn-danger btn-xs btn-icon" title="Hapus"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div></td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar violet">RY</div><div><div class="td-name">Rumah Yatim Al-Ikhlas</div><div class="td-email">admin@rumahyatim.org</div></div></div></td>
                            <td><span class="pill lembaga">Lembaga</span></td>
                            <td class="td-mono">05 Jan 2025</td>
                            <td class="td-mono">67</td>
                            <td><span class="pill aktif">Aktif</span></td>
                            <td><div class="actions">
                                <button class="btn btn-outline btn-xs btn-icon" title="Edit"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="btn btn-amber btn-xs btn-icon" title="Suspend"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
                                <button class="btn btn-danger btn-xs btn-icon" title="Hapus"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div></td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar mint">KB</div><div><div class="td-name">Katering Berkah</div><div class="td-email">owner@katering.id</div></div></div></td>
                            <td><span class="pill fnb">F&B Seller</span></td>
                            <td class="td-mono">20 Feb 2025</td>
                            <td class="td-mono">128</td>
                            <td><span class="pill aktif">Aktif</span></td>
                            <td><div class="actions">
                                <button class="btn btn-outline btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="btn btn-amber btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
                                <button class="btn btn-danger btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div></td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar amber">SR</div><div><div class="td-name">Siti Rahma</div><div class="td-email">siti.r@gmail.com</div></div></div></td>
                            <td><span class="pill konsumen">Konsumen</span></td>
                            <td class="td-mono">01 Apr 2025</td>
                            <td class="td-mono">8</td>
                            <td><span class="pill suspend">Suspend</span></td>
                            <td><div class="actions">
                                <button class="btn btn-outline btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="btn btn-success btn-xs btn-icon" title="Aktifkan kembali"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></button>
                                <button class="btn btn-danger btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- VALIDASI PENDING --}}
            <div style="padding:1.375rem 1.75rem 0.875rem; border-top:1.5px solid var(--border); margin-top:0;">
                <div style="font-family:'Bricolage Grotesque',sans-serif;font-weight:700;font-size:0.9375rem;letter-spacing:-0.04em;color:var(--ink);margin-bottom:0.125rem;">
                    Validasi Akun Pending
                </div>
                <div style="font-size:0.8125rem;color:var(--muted);">Lembaga & Seller baru yang menunggu persetujuan Admin.</div>
            </div>
            <div class="pending-card">
                <div class="pending-av">YS</div>
                <div class="pending-info">
                    <div class="pending-name">Yayasan Sayap Ibu</div>
                    <div class="pending-meta">Lembaga Sosial · Daftar 2 hari lalu · Jakarta Selatan</div>
                </div>
                <span class="pill pending" style="flex-shrink:0;">Pending</span>
                <div class="pending-actions">
                    <button class="btn btn-success btn-xs">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Approve
                    </button>
                    <button class="btn btn-danger btn-xs">Tolak</button>
                </div>
            </div>
            <div class="pending-card">
                <div class="pending-av" style="background:linear-gradient(135deg,#34d399,#059669);">RS</div>
                <div class="pending-info">
                    <div class="pending-name">Resto Sate Madura Pak Eko</div>
                    <div class="pending-meta">F&B Seller · Daftar 5 jam lalu · Depok</div>
                </div>
                <span class="pill pending" style="flex-shrink:0;">Pending</span>
                <div class="pending-actions">
                    <button class="btn btn-success btn-xs">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Approve
                    </button>
                    <button class="btn btn-danger btn-xs">Tolak</button>
                </div>
            </div>
            <div class="pending-card">
                <div class="pending-av" style="background:linear-gradient(135deg,#a78bfa,#7c3aed);">BK</div>
                <div class="pending-info">
                    <div class="pending-name">Bank Makanan Komunitas</div>
                    <div class="pending-meta">Lembaga Sosial · Daftar 1 hari lalu · Bandung</div>
                </div>
                <span class="pill pending" style="flex-shrink:0;">Pending</span>
                <div class="pending-actions">
                    <button class="btn btn-success btn-xs">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Approve
                    </button>
                    <button class="btn btn-danger btn-xs">Tolak</button>
                </div>
            </div>
        </div>

        {{-- ══ 3. MONITORING & LOG ══ --}}
        <div id="sec-monitor" class="two-col">
            {{-- Log Transaksi --}}
            <div class="sec">
                <div class="sec-hdr">
                    <div class="sec-hdr-left">
                        <div class="sec-kicker">Monitoring</div>
                        <div class="sec-title">Log Transaksi</div>
                    </div>
                    <div class="sec-hdr-right">
                        <button class="btn btn-outline btn-xs">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Ekspor
                        </button>
                    </div>
                </div>
                <div class="tbl-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dari → Ke</th>
                                <th>Item</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="log-id">#TRX-0081</span></td>
                                <td style="font-size:0.8125rem;"><strong>Katering Berkah</strong><br><span style="color:var(--muted);">→ Andi Pratama</span></td>
                                <td style="font-size:0.8125rem;">Nasi Box × 3</td>
                                <td><span class="pill selesai">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="log-id">#DON-0042</span></td>
                                <td style="font-size:0.8125rem;"><strong>Bakery Sari Rasa</strong><br><span style="color:var(--muted);">→ Rumah Yatim</span></td>
                                <td style="font-size:0.8125rem;">Roti Sisa × 25</td>
                                <td><span class="pill proses">Proses</span></td>
                            </tr>
                            <tr>
                                <td><span class="log-id">#TRX-0080</span></td>
                                <td style="font-size:0.8125rem;"><strong>Warung Bu Yanti</strong><br><span style="color:var(--muted);">→ Siti Rahma</span></td>
                                <td style="font-size:0.8125rem;">Sayur Segar × 2kg</td>
                                <td><span class="pill selesai">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="log-id">#DON-0041</span></td>
                                <td style="font-size:0.8125rem;"><strong>Katering Berkah</strong><br><span style="color:var(--muted);">→ Bank Makanan</span></td>
                                <td style="font-size:0.8125rem;">Paket Hemat × 10</td>
                                <td><span class="pill proses">Proses</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Laporan Keluhan --}}
            <div class="sec">
                <div class="sec-hdr">
                    <div class="sec-hdr-left">
                        <div class="sec-kicker">Laporan</div>
                        <div class="sec-title">Keluhan Pengguna</div>
                    </div>
                    <div class="sec-hdr-right">
                        <span class="pill keluhan">2 Baru</span>
                    </div>
                </div>
                <div class="keluhan-card">
                    <div class="keluhan-top">
                        <div class="keluhan-title">Makanan Tidak Layak Konsumsi</div>
                        <span class="pill keluhan">Baru</span>
                    </div>
                    <div class="keluhan-meta">Andi Pratama · Katering Berkah · 30 menit lalu</div>
                    <div class="keluhan-desc">Nasi box yang diterima sudah basi dan berbau. Perlu tindakan segera dari pihak Admin untuk menangguhkan listing ini.</div>
                    <div style="margin-top:0.75rem; display:flex; gap:0.5rem;">
                        <button class="btn btn-primary btn-xs">Tangani</button>
                        <button class="btn btn-outline btn-xs">Detail</button>
                    </div>
                </div>
                <div class="keluhan-card">
                    <div class="keluhan-top">
                        <div class="keluhan-title">Stok Tidak Sesuai</div>
                        <span class="pill keluhan">Baru</span>
                    </div>
                    <div class="keluhan-meta">Rumah Yatim Al-Ikhlas · Warung Bu Yanti · 3 jam lalu</div>
                    <div class="keluhan-desc">Kami memesan 20 porsi namun saat pengambilan hanya tersedia 8 porsi. Mohon seller dikonfirmasi ulang sebelum publish listing.</div>
                    <div style="margin-top:0.75rem; display:flex; gap:0.5rem;">
                        <button class="btn btn-primary btn-xs">Tangani</button>
                        <button class="btn btn-outline btn-xs">Detail</button>
                    </div>
                </div>
                <div class="keluhan-card">
                    <div class="keluhan-top">
                        <div class="keluhan-title">Waktu Pickup Tidak Akurat</div>
                        <span class="pill ditangani">Ditangani</span>
                    </div>
                    <div class="keluhan-meta">Bank Makanan Komunitas · Bakery Sari Rasa · Kemarin</div>
                    <div class="keluhan-desc">Jadwal pickup tertulis pukul 18.00 namun restoran sudah tutup sejak 17.00. Telah dikonfirmasi dan seller sudah update jam operasional.</div>
                </div>
            </div>
        </div>

        {{-- ══ MANAJEMEN KONTEN ARTIKEL ══ --}}
        <div id="sec-artikel" class="sec">
            <div class="sec-hdr">
                <div class="sec-hdr-left">
                    <div class="sec-kicker">Manajemen Konten</div>
                    <div class="sec-title">Artikel Edukasi — CRUD</div>
                </div>
                <div class="sec-hdr-right">
                    <button class="btn btn-primary" onclick="openModal('addArtikel')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Artikel Baru
                    </button>
                </div>
            </div>
            <div class="artikel-row">
                <div class="artikel-thumb"><img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=200" alt=""></div>
                <div class="artikel-info">
                    <div class="artikel-title-row">5 Cara Agar Sayuran Tetap Segar Selama Seminggu</div>
                    <div class="artikel-meta"><span class="pill aktif">Publikasi</span> Tips Penyimpanan · Admin FoodSave · 2 jam lalu</div>
                </div>
                <div class="actions" style="flex-shrink:0;">
                    <button class="btn btn-outline btn-xs btn-icon" title="Edit"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    <button class="btn btn-amber btn-xs btn-icon" title="Sembunyikan"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg></button>
                    <button class="btn btn-danger btn-xs btn-icon" title="Hapus"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </div>
            </div>
            <div class="artikel-row">
                <div class="artikel-thumb"><img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=200" alt=""></div>
                <div class="artikel-info">
                    <div class="artikel-title-row">Dampak Mengerikan Food Waste bagi Perubahan Iklim</div>
                    <div class="artikel-meta"><span class="pill aktif">Publikasi</span> Global Issue · Admin FoodSave · 1 hari lalu</div>
                </div>
                <div class="actions" style="flex-shrink:0;">
                    <button class="btn btn-outline btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    <button class="btn btn-amber btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg></button>
                    <button class="btn btn-danger btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </div>
            </div>
            <div class="artikel-row">
                <div class="artikel-thumb" style="background:var(--blue-100);display:flex;align-items:center;justify-content:center;color:var(--blue-400);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div class="artikel-info">
                    <div class="artikel-title-row">Prosedur Food Safety untuk Distribusi Makanan Surplus</div>
                    <div class="artikel-meta"><span class="pill suspend">Draft</span> Keamanan Pangan · Admin FoodSave · 3 hari lalu</div>
                </div>
                <div class="actions" style="flex-shrink:0;">
                    <button class="btn btn-success btn-xs">Publish</button>
                    <button class="btn btn-outline btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    <button class="btn btn-danger btn-xs btn-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </div>
            </div>
        </div>

        {{-- ══ 4. PENGATURAN SISTEM ══ --}}
        <div id="sec-setting" class="sec">
            <div class="sec-hdr">
                <div class="sec-hdr-left">
                    <div class="sec-kicker">Pengaturan Sistem</div>
                    <div class="sec-title">Pengendalian Platform</div>
                </div>
            </div>
            <div class="setting-grid">
                {{-- Kategori Makanan --}}
                <div class="setting-card">
                    <div class="setting-top">
                        <div>
                            <div class="setting-title">Kategori Makanan</div>
                            <div class="setting-sub">Kelola kategori yang tersedia untuk Seller saat membuat listing.</div>
                        </div>
                        <div class="setting-icon blue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                    </div>
                    <div class="cat-wrap">
                        <div class="cat-chip">🥬 Sayuran <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🍱 Makanan Siap Saji <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🍞 Roti & Kue <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🍚 Nasi & Lauk <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🥤 Minuman <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🍖 Daging & Protein <span class="cat-chip-del">×</span></div>
                        <div class="cat-chip">🧁 Snack & Camilan <span class="cat-chip-del">×</span></div>
                        <div class="cat-add" onclick="alert('Tambah kategori baru')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Kategori
                        </div>
                    </div>
                </div>

                {{-- Notifikasi Sistem --}}
                <div class="setting-card">
                    <div class="setting-top">
                        <div>
                            <div class="setting-title">Kirim Notifikasi Massal</div>
                            <div class="setting-sub">Pengumuman ke semua pengguna, misal: jadwal maintenance server.</div>
                        </div>
                        <div class="setting-icon violet">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                    </div>
                    <div class="notif-form">
                        <div class="nf-row">
                            <select class="nf-input" style="max-width:160px;">
                                <option>Semua Pengguna</option>
                                <option>Konsumen Saja</option>
                                <option>Seller Saja</option>
                                <option>Lembaga Saja</option>
                            </select>
                            <input type="text" class="nf-input" placeholder="Judul notifikasi...">
                        </div>
                        <textarea class="nf-input" placeholder="Isi pesan pengumuman..."></textarea>
                        <div>
                            <button class="btn btn-primary">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Kirim Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /.content --}}
</div>{{-- /.main --}}

{{-- ══ MODAL: Tambah Akun ══ --}}
<div class="modal-overlay" id="modal-addUser">
    <div class="modal">
        <div class="modal-hdr">
            <div class="modal-title">Tambah Akun Baru</div>
            <button class="modal-close" onclick="closeModal('addUser')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="modal-body">
            <div class="field"><label>Nama Lengkap</label><input type="text" placeholder="Nama pengguna..."></div>
            <div class="field"><label>Email</label><input type="email" placeholder="email@contoh.com"></div>
            <div class="field"><label>Role</label>
                <select>
                    <option>Konsumen</option>
                    <option>Lembaga Sosial</option>
                    <option>F&B Seller</option>
                </select>
            </div>
            <div class="field"><label>Password Sementara</label><input type="password" placeholder="Min. 8 karakter"></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('addUser')">Batal</button>
            <button class="btn btn-primary">Simpan Akun</button>
        </div>
    </div>
</div>

{{-- ══ MODAL: Tambah Artikel ══ --}}
<div class="modal-overlay" id="modal-addArtikel">
    <div class="modal">
        <div class="modal-hdr">
            <div class="modal-title">Buat Artikel Baru</div>
            <button class="modal-close" onclick="closeModal('addArtikel')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="modal-body">
            <div class="field"><label>Judul Artikel</label><input type="text" placeholder="Judul yang menarik..."></div>
            <div class="field"><label>Kategori</label>
                <select>
                    <option>Tips Penyimpanan</option>
                    <option>Keamanan Pangan</option>
                    <option>Global Issue</option>
                    <option>Panduan Distribusi</option>
                    <option>Inspirasi Seller</option>
                    <option>Kebijakan Pemerintah</option>
                </select>
            </div>
            <div class="field"><label>Target Pembaca</label>
                <select>
                    <option>Semua Pengguna</option>
                    <option>Konsumen</option>
                    <option>F&B Seller</option>
                    <option>Lembaga Sosial</option>
                </select>
            </div>
            <div class="field"><label>Ringkasan / Excerpt</label><textarea placeholder="Deskripsi singkat artikel (max 200 karakter)..."></textarea></div>
            <div class="field"><label>URL Gambar Thumbnail</label><input type="text" placeholder="https://..."></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('addArtikel')">Batal</button>
            <button class="btn btn-amber">Simpan Draft</button>
            <button class="btn btn-primary">Publish</button>
        </div>
    </div>
</div>

<script>
function openModal(id){
    document.getElementById('modal-'+id).classList.add('open');
    document.body.classList.add('no-scroll');
}
function closeModal(id){
    document.getElementById('modal-'+id).classList.remove('open');
    document.body.classList.remove('no-scroll');
}
document.querySelectorAll('.modal-overlay').forEach(el=>{
    el.addEventListener('click', e=>{ if(e.target===el) el.classList.remove('open'); });
});
function setTab(btn, val){
    btn.closest('.filter-tabs').querySelectorAll('.ftab').forEach(t=>t.classList.remove('on'));
    btn.classList.add('on');
}
// sidebar smooth scroll
document.querySelectorAll('.sb-item[href^="#"]').forEach(link=>{
    link.addEventListener('click', e=>{
        e.preventDefault();
        const target = document.querySelector(link.getAttribute('href'));
        if(target) target.scrollIntoView({behavior:'smooth', block:'start'});
        document.querySelectorAll('.sb-item').forEach(i=>i.classList.remove('active'));
        link.classList.add('active');
    });
});
</script>
