<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,700;0,9..144,900;1,9..144,400;1,9..144,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .fs-root {
        font-family: 'DM Sans', sans-serif;
        background: #f5f3ee;
        min-height: 100vh;
        padding-bottom: 6rem;
    }

    /* ── HEADER ── */
    .fs-header {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0,0,0,0.07);
        position: sticky;
        top: 0;
        z-index: 40;
    }
    .fs-header-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }
    .fs-logo {
        font-family: 'Fraunces', serif;
        font-weight: 900;
        font-size: 1.5rem;
        color: #1a4a2e;
        letter-spacing: -0.04em;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .fs-logo-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block; animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.4);opacity:0.7} }

    .fs-search-wrap {
        flex: 1;
        max-width: 420px;
        position: relative;
        display: none;
    }
    @media(min-width:768px){ .fs-search-wrap { display: block; } }
    .fs-search-wrap input {
        width: 100%;
        background: #f0ede8;
        border: 1px solid transparent;
        border-radius: 999px;
        padding: 0.55rem 1rem 0.55rem 2.75rem;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        color: #1a1a1a;
        outline: none;
        transition: all 0.2s;
    }
    .fs-search-wrap input:focus { background: #fff; border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.12); }
    .fs-search-wrap input::placeholder { color: #9a9488; }
    .fs-search-icon { position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: #9a9488; width: 16px; height: 16px; pointer-events: none; }

    .fs-points-badge {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.375rem 0.875rem;
        border-radius: 999px;
        border: 1px solid #fcd34d;
        white-space: nowrap;
        letter-spacing: 0.01em;
    }

    /* ── CART FAB ── */
    .fs-fab {
        position: fixed;
        bottom: 2.25rem;
        right: 2.25rem;
        z-index: 50;
        background: #1a4a2e;
        color: #fff;
        padding: 1rem 1.5rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        box-shadow: 0 8px 32px rgba(26,74,46,0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .fs-fab:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 14px 40px rgba(26,74,46,0.45); }
    .fs-fab-count {
        background: #22c55e;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── MAIN ── */
    .fs-main {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* ── HERO BANNER ── */
    .fs-hero {
        margin-top: 2.5rem;
        background: #1a4a2e;
        border-radius: 2rem;
        padding: 3rem 3.5rem;
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
    }
    .fs-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(34,197,94,0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .fs-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30%;
        width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(251,191,36,0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .fs-hero-eyebrow {
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #86efac;
        margin-bottom: 0.75rem;
    }
    .fs-hero-quote {
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-style: italic;
        font-size: clamp(1.5rem, 2.5vw, 2.125rem);
        color: #fff;
        line-height: 1.25;
        max-width: 440px;
        margin-bottom: 2rem;
    }
    .fs-hero-stats {
        display: flex;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .fs-stat-card {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        min-width: 110px;
        transition: background 0.2s;
    }
    .fs-stat-card:hover { background: rgba(255,255,255,0.13); }
    .fs-stat-num {
        font-family: 'Fraunces', serif;
        font-size: 1.625rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }
    .fs-stat-num small { font-size: 0.75rem; font-weight: 400; opacity: 0.75; font-family: 'DM Sans', sans-serif; }
    .fs-stat-label { font-size: 0.625rem; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-top: 0.25rem; }

    .fs-hero-visual {
        background: rgba(251,191,36,0.12);
        border: 1.5px dashed rgba(251,191,36,0.5);
        border-radius: 1.5rem;
        width: 260px;
        height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(251,191,36,0.7);
        font-weight: 600;
        font-size: 0.8125rem;
        text-align: center;
        padding: 1rem;
        position: relative;
        z-index: 1;
    }
    @media(max-width:900px){ .fs-hero-visual { display: none; } .fs-hero { grid-template-columns: 1fr; } }

    /* ── SECTION HEADER ── */
    .fs-section { margin-top: 4rem; }
    .fs-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .fs-section-title {
        font-family: 'Fraunces', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }
    .fs-section-sub { font-size: 0.875rem; color: #7a7060; margin-top: 0.25rem; }
    .fs-nav-arrows { display: flex; gap: 0.5rem; }
    .fs-nav-btn {
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 1px solid #d4d0c8;
        background: #fff;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #7a7060;
        transition: all 0.2s;
        font-size: 1rem;
        font-weight: 500;
    }
    .fs-nav-btn:hover { background: #1a4a2e; color: #fff; border-color: #1a4a2e; }

    /* ── PRODUCT GRID ── */
    .fs-product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    /* ── PRODUCT CARD ── */
    .fs-card {
        background: #fff;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid #ede9e0;
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s;
        cursor: pointer;
        position: relative;
    }
    .fs-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(0,0,0,0.1); }

    .fs-card-img-wrap { position: relative; height: 220px; overflow: hidden; }
    .fs-card-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94);
    }
    .fs-card:hover .fs-card-img-wrap img { transform: scale(1.08); }

    .fs-card-badge-dist {
        position: absolute;
        top: 0.875rem; left: 0.875rem;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        border-radius: 999px;
        padding: 0.25rem 0.65rem;
        font-size: 0.6875rem;
        font-weight: 700;
        color: #1a4a2e;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .fs-card-badge-dist svg { width: 11px; height: 11px; }

    .fs-card-badge-urgent {
        position: absolute;
        bottom: 0.875rem; right: 0.875rem;
        background: #f97316;
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.25rem 0.65rem;
        font-size: 0.6875rem;
        font-weight: 700;
        font-style: italic;
        letter-spacing: 0.02em;
    }

    .fs-card-body { padding: 1.25rem 1.375rem; }
    .fs-card-store {
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #9a9488;
        margin-bottom: 0.375rem;
    }
    .fs-card-name {
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-size: 1.0625rem;
        color: #1a1a1a;
        margin-bottom: 1.125rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }
    .fs-card-footer { display: flex; align-items: center; justify-content: space-between; }
    .fs-card-price-orig { font-size: 0.75rem; color: #b4ac9e; text-decoration: line-through; }
    .fs-card-price { font-family: 'Fraunces', serif; font-size: 1.375rem; font-weight: 700; color: #1a4a2e; line-height: 1; }

    .fs-add-btn {
        background: #fbbf24;
        border: none;
        border-radius: 0.875rem;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(251,191,36,0.35);
    }
    .fs-add-btn:hover { background: #f59e0b; transform: scale(1.1); box-shadow: 0 6px 20px rgba(251,191,36,0.5); }
    .fs-add-btn svg { width: 22px; height: 22px; color: #78350f; }
    .fs-add-btn:active { transform: scale(0.96); }

    /* ── DIVIDER ── */
    .fs-divider { border: none; border-top: 1px solid #e8e4da; margin: 4rem 0 0; }

    /* ── ARTICLE SECTION ── */
    .fs-article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .fs-article-link-all {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1a4a2e;
        text-decoration: none;
        border-bottom: 2px solid #22c55e;
        padding-bottom: 2px;
        transition: opacity 0.2s;
    }
    .fs-article-link-all:hover { opacity: 0.7; }

    .fs-article-card { display: flex; flex-direction: column; gap: 0.875rem; }
    .fs-article-img {
        height: 200px;
        border-radius: 1.5rem;
        overflow: hidden;
        background: #e8e4da;
    }
    .fs-article-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .fs-article-card:hover .fs-article-img img { transform: scale(1.05); }

    .fs-article-tag {
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #16a34a;
    }
    .fs-article-title {
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a1a;
        line-height: 1.35;
        cursor: pointer;
        transition: color 0.2s;
    }
    .fs-article-title:hover { color: #1a4a2e; }
    .fs-article-excerpt {
        font-size: 0.8125rem;
        color: #7a7060;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .fs-article-placeholder {
        border: 2px dashed #d4d0c8;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        text-align: center;
        min-height: 200px;
    }
    .fs-article-placeholder p { font-size: 0.875rem; color: #b4ac9e; font-style: italic; font-weight: 500; line-height: 1.6; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fs-hero { animation: fadeUp 0.6s ease both; }
    .fs-card { animation: fadeUp 0.5s ease both; }
    .fs-card:nth-child(1) { animation-delay: 0.05s; }
    .fs-card:nth-child(2) { animation-delay: 0.10s; }
    .fs-card:nth-child(3) { animation-delay: 0.15s; }
    .fs-card:nth-child(4) { animation-delay: 0.20s; }
</style>

<div class="fs-root">

    {{-- ── FAB CART ── --}}
    <a href="#" class="fs-fab">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        Keranjang
        <span class="fs-fab-count">3</span>
    </a>

    {{-- ── HEADER ── --}}
    <header class="fs-header">
        <div class="fs-header-inner">
            <div style="display:flex;align-items:center;gap:1.25rem;flex:1;">
                <div class="fs-logo">
                    <span class="fs-logo-dot"></span>
                    FoodSave
                </div>
                <div class="fs-search-wrap">
                    <svg class="fs-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Cari makanan yang bisa diselamatkan...">
                </div>
            </div>
            <span class="fs-points-badge">✦ 150.000 FP</span>
        </div>
    </header>

    {{-- ── MAIN ── --}}
    <main class="fs-main">

        {{-- ── HERO / IMPACT ── --}}
        <section class="fs-hero">
            <div style="position:relative;z-index:1;">
                <p class="fs-hero-eyebrow">Dampak Lingkunganmu</p>
                <h3 class="fs-hero-quote">"Langkah kecilmu, nafas baru untuk bumi."</h3>
                <div class="fs-hero-stats">
                    <div class="fs-stat-card">
                        <div class="fs-stat-num">12.5 <small>Kg</small></div>
                        <div class="fs-stat-label">Food Saved</div>
                    </div>
                    <div class="fs-stat-card">
                        <div class="fs-stat-num">3.2 <small>Kg</small></div>
                        <div class="fs-stat-label">CO₂ Reduced</div>
                    </div>
                </div>
            </div>
            <div class="fs-hero-visual">Visual Impact Tracker Soon</div>
        </section>

        {{-- ── RESCUE DEALS ── --}}
        <section class="fs-section">
            <div class="fs-section-head">
                <div>
                    <h3 class="fs-section-title">Rescue Deals Hari Ini</h3>
                    <p class="fs-section-sub">Makanan berkualitas dengan harga penyelamat.</p>
                </div>
                <div class="fs-nav-arrows">
                    <button class="fs-nav-btn">←</button>
                    <button class="fs-nav-btn">→</button>
                </div>
            </div>

            <div class="fs-product-grid">
                @for ($i = 0; $i < 4; $i++)
                <div class="fs-card">
                    <div class="fs-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" alt="Paket Ayam Geprek Surplus">
                        <div class="fs-card-badge-dist">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            0.5 km
                        </div>
                        <div class="fs-card-badge-urgent">Sisa 2!</div>
                    </div>
                    <div class="fs-card-body">
                        <p class="fs-card-store">Resto Ayam Berkah</p>
                        <h4 class="fs-card-name">Paket Ayam Geprek Surplus</h4>
                        <div class="fs-card-footer">
                            <div>
                                <div class="fs-card-price-orig">Rp 25.000</div>
                                <div class="fs-card-price">Rp 12.500</div>
                            </div>
                            <button class="fs-add-btn" aria-label="Tambah ke keranjang">
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

        {{-- ── EDUKASI ── --}}
        <hr class="fs-divider">
        <section class="fs-section" style="margin-top:3rem;">
            <div class="fs-section-head">
                <h3 class="fs-section-title" style="font-style:italic;">Edukasi &amp; Lingkungan</h3>
                <a href="#" class="fs-article-link-all">Lihat Semua Artikel</a>
            </div>

            <div class="fs-article-grid">
                <div class="fs-article-card">
                    <div class="fs-article-img">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" alt="Tips Penyimpanan">
                    </div>
                    <span class="fs-article-tag">Tips Penyimpanan</span>
                    <h4 class="fs-article-title">5 Cara Agar Sayuran Tetap Segar Selama Seminggu</h4>
                    <p class="fs-article-excerpt">Admin FoodSave membagikan tips rahasia menyimpan bahan makanan agar tidak cepat terbuang dan tetap bergizi optimal.</p>
                </div>

                <div class="fs-article-card">
                    <div class="fs-article-img">
                        <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=500" alt="Global Issue">
                    </div>
                    <span class="fs-article-tag">Global Issue</span>
                    <h4 class="fs-article-title">Dampak Mengerikan Food Waste bagi Perubahan Iklim</h4>
                    <p class="fs-article-excerpt">Mengetahui seberapa besar pengaruh sisa makanan terhadap lapisan ozon bumi kita.</p>
                </div>

                <div class="fs-article-placeholder">
                    <p>Artikel lainnya sedang disiapkan oleh Admin kami...</p>
                </div>
            </div>
        </section>

    </main>
</div>
</x-app-layout>