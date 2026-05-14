<x-app-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    :root {
        --mint-50: #f0fdf6;
        --mint-100: #dcfce9;
        --mint-500: #22c55e;
        --mint-600: #16a34a;
        --ink: #111917;
        --muted: #4b6358;
        --white: #ffffff;
        --r-xl: 32px;
    }
    body { font-family: 'Space Grotesk', sans-serif; background: #f8fafc; color: var(--ink); }
    .invoice-card {
        max-width: 600px; margin: 4rem auto; background: var(--white);
        border-radius: var(--r-xl); padding: 3rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.03);
        position: relative; overflow: hidden;
    }
    .invoice-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 8px;
        background: linear-gradient(to right, var(--mint-400), var(--mint-600));
    }
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; }
    .logo-text { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.05em; }
    .logo-text em { color: var(--mint-600); font-style: normal; }
    .inv-number { font-size: 0.875rem; color: var(--muted); font-weight: 500; }
    
    .section-title { font-size: 0.625rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--mint-600); margin-bottom: 0.75rem; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem; }
    .info-label { font-size: 0.75rem; color: var(--muted); margin-bottom: 4px; }
    .info-value { font-weight: 600; font-size: 0.9375rem; }

    .item-list { border-top: 1.5px dashed #e2e8f0; border-bottom: 1.5px dashed #e2e8f0; padding: 1.5rem 0; margin-bottom: 2rem; }
    .item-row { display: flex; justify-content: space-between; align-items: center; }
    .item-name { font-weight: 700; font-size: 1.125rem; }
    .item-qty { font-size: 0.875rem; color: var(--muted); }
    .item-price { font-weight: 700; color: var(--mint-600); font-size: 1.125rem; }

    .pickup-box {
        background: var(--mint-50); border: 2px dashed var(--mint-200);
        border-radius: 20px; padding: 1.5rem; text-align: center;
    }
    .pickup-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--mint-700); margin-bottom: 0.5rem; }
    .pickup-code { font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 2.5rem; letter-spacing: 0.1em; color: var(--ink); line-height: 1; }
    
    .footer { text-align: center; margin-top: 3rem; font-size: 0.8125rem; color: var(--muted); }
    .btn-print {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--ink); color: #fff; padding: 0.75rem 1.5rem;
        border-radius: 99px; font-weight: 600; text-decoration: none; margin-top: 2rem;
        transition: all 0.2s;
    }
    .btn-print:hover { background: #000; transform: translateY(-2px); }
    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f1f5f9; color: var(--ink); padding: 0.75rem 1.5rem;
        border-radius: 99px; font-weight: 600; text-decoration: none;
        transition: all 0.2s; border: 1.5px solid #e2e8f0; cursor: pointer;
        font-size: 0.875rem;
    }
    .btn-back:hover { background: #e2e8f0; transform: translateY(-2px); }
    @media print {
        .btn-print, .btn-back { display: none !important; }
        .invoice-card { box-shadow: none; border: none; margin: 0; padding: 0; }
        body { background: white; }
    }
</style>

<div class="invoice-card">
    <div class="header">
        <div class="logo-text">Food<em>Save</em></div>
        <div class="inv-number">#INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="info-grid">
        <div>
            <div class="section-title">Pemesan</div>
            <div class="info-value">{{ $order->user->name }}</div>
            <div class="info-label">{{ $order->user->email }}</div>
        </div>
        <div style="text-align: right;">
            <div class="section-title">Toko</div>
            <div class="info-value">{{ $order->menu->user->name }}</div>
            <div class="info-label">Tanggal: {{ $order->created_at->format('d M Y') }}</div>
        </div>
    </div>

    <div class="item-list">
        <div class="item-row">
            <div>
                <div class="item-name">{{ $order->menu->name }}</div>
                <div class="item-qty">Kuantitas: {{ $order->quantity }} porsi</div>
            </div>
            <div class="item-price">
                @if($order->user->role === 'lembaga_sosial')
                    GRATIS
                @else
                    Rp {{ number_format($order->menu->final_price * $order->quantity, 0, ',', '.') }}
                @endif
            </div>
        </div>
    </div>

    <div class="pickup-box">
        <div class="pickup-label">Kode Self-Pickup</div>
        <div class="pickup-code">{{ strtoupper(substr(md5($order->id), 0, 6)) }}</div>
        <p style="font-size: 0.75rem; color: var(--muted); margin-top: 1rem;">Tunjukkan kode ini kepada seller saat pengambilan makanan.</p>
    </div>

    <div style="text-align: center; display: flex; justify-content: center; gap: 1rem; margin-top: 2rem;">
        <a href="{{ Auth::user()->role === 'lembaga_sosial' ? route('sosial.dashboard') : route('transaction.history') }}" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <button onclick="window.print()" class="btn-print" style="margin-top: 0;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"/></svg>
            Cetak Invoice
        </button>
    </div>

    <div class="footer">
        Terima kasih telah membantu menyelamatkan makanan dan menjaga bumi! 🌍
    </div>
</div>
</x-app-layout>
