<x-app-layout>
@php
    // Unify data from different controllers
    if (isset($orders) && $orders->isNotEmpty()) {
        $orders_list = $orders;
        $headerOrder = $orders->first();
        $display_id = $transaction->id ?? $headerOrder->transaction_id ?? 'INV-' . str_pad($headerOrder->id, 6, '0', STR_PAD_LEFT);
        $date = $transaction->date ?? $headerOrder->created_at;
        $customer_name = $transaction->customer_name ?? $headerOrder->user->name;
        $customer_email = $transaction->customer_email ?? $headerOrder->user->email;
        $payment_method = $transaction->payment_method ?? $headerOrder->payment_method ?? 'Transfer';
        $status = $transaction->status ?? $headerOrder->status;
    } elseif (isset($order)) {
        $orders_list = collect([$order]);
        $display_id = $order->transaction_id ?? 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $date = $order->created_at;
        $customer_name = $order->user->name;
        $customer_email = $order->user->email;
        $payment_method = $order->payment_method ?? 'Transfer';
        $status = $order->status;
    }
    // TAMBAHAN AC 2: ambil data jadwal & metode pengambilan dari order pertama
    $pickup_method   = isset($order) ? ($order->pickup_method ?? null) : (isset($headerOrder) ? ($headerOrder->pickup_method ?? null) : null);
    $pickup_schedule = isset($order) ? ($order->pickup_schedule ?? null) : (isset($headerOrder) ? ($headerOrder->pickup_schedule ?? null) : null);
@endphp

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
        max-width: 650px; margin: 4rem auto; background: var(--white);
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
    .item-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; }
    .item-name { font-weight: 700; font-size: 1.125rem; }
    .item-qty { font-size: 0.875rem; color: var(--muted); }
    .item-price { font-weight: 700; color: var(--mint-600); font-size: 1.125rem; }

    .pickup-box {
        background: var(--mint-50); border: 2px dashed var(--mint-200);
        border-radius: 20px; padding: 1.5rem; text-align: center;
        margin-top: 2rem;
    }
    .pickup-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--mint-700); margin-bottom: 0.5rem; }
    .pickup-code { font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 2.5rem; letter-spacing: 0.1em; color: var(--ink); line-height: 1; }
    /* TAMBAHAN AC 2: styling baris jadwal pengambilan */
    .pickup-schedule {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--mint-100); border: 1px solid var(--mint-200);
        border-radius: 99px; padding: 0.35rem 1rem;
        font-size: 0.8125rem; font-weight: 600; color: var(--mint-600);
        margin-top: 0.875rem;
    }
    
    .footer { text-align: center; margin-top: 3rem; font-size: 0.8125rem; color: var(--muted); }
    .btn-print {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--ink); color: #fff; padding: 0.75rem 1.5rem;
        border-radius: 99px; font-weight: 600; text-decoration: none; margin-top: 2rem;
        transition: all 0.2s; border: none; cursor: pointer;
    }
    .btn-print:hover { background: #000; transform: translateY(-2px); }
    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--white); color: var(--ink); padding: 0.75rem 1.5rem;
        border-radius: 99px; font-weight: 600; text-decoration: none; margin-top: 2rem;
        transition: all 0.2s; border: 1px solid #e2e8f0; cursor: pointer;
    }
    .btn-back:hover { background: #f8fafc; transform: translateY(-2px); border-color: var(--mint-600); }
    @media print {
        .hide-on-print { display: none !important; }
    }
</style>

<div class="invoice-card">
    <div class="header">
        <div class="logo-text">Food<em>Save</em></div>
        <div class="inv-number">#{{ $display_id }}</div>
    </div>

    <div class="info-grid">
        <div>
            <div class="section-title">Pemesan</div>
            <div class="info-value">{{ $customer_name }}</div>
            <div class="info-label">{{ $customer_email }}</div>
        </div>
        <div style="text-align: right;">
            <div class="section-title">Detail</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</div>
            <div class="info-label">{{ $payment_method }} · {{ $status }}</div>
        </div>
    </div>

    <div class="item-list">
        @foreach($orders_list as $item)
            @php
                $lineTotal = $item->line_total;
                $unitPrice = $item->unit_price ?? ($item->menu ? (int) round($item->menu->final_price) : 0);
            @endphp
            <div class="item-row">
                <div>
                    <div class="item-name">{{ $item->menu->name }}</div>
                    <div class="item-qty">
                        {{ $item->quantity }} porsi × Rp {{ number_format($unitPrice, 0, ',', '.') }}
                        · {{ $item->menu->user->name ?? 'Restoran' }}
                    </div>
                </div>
                <div class="item-price">
                    @if(($isDonation ?? false) || ($item->user->role ?? '') === 'lembaga_sosial')
                        GRATIS
                    @else
                        Rp {{ number_format($lineTotal, 0, ',', '.') }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1.5px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--muted); font-size: 0.9375rem;">
            <span>Subtotal Pesanan</span>
            <span>Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1.5px dashed #e2e8f0; color: var(--muted); font-size: 0.9375rem;">
            <span>Biaya Layanan</span>
            <span>Rp {{ number_format($serviceFee ?? 0, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: 800; font-size: 1.25rem;">
            <span>Total Pembayaran</span>
            <span style="color: var(--mint-600);">Rp {{ number_format($grandTotal ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- TAMBAHAN AC 2: tampilkan kotak pickup hanya jika metode adalah self-pickup --}}
    @if($pickup_method === 'self-pickup')
    <div class="pickup-box">
        <div class="pickup-label">Kode Self-Pickup</div>
        <div class="pickup-code">{{ strtoupper(substr(md5($display_id), 0, 6)) }}</div>
        {{-- TAMBAHAN AC 2: tampilkan jadwal pengambilan jika ada --}}
        @if($pickup_schedule)
        <div class="pickup-schedule">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Jadwal Pengambilan: <strong>{{ $pickup_schedule }}</strong>
        </div>
        @endif
        <p style="font-size: 0.75rem; color: var(--muted); margin-top: 1rem;">Tunjukkan kode ini kepada seller saat pengambilan makanan.</p>
    </div>
    @endif

    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('dashboard') }}" class="btn-back hide-on-print">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="btn-print hide-on-print">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"/></svg>
            Cetak Invoice
        </button>
    </div>

    <div class="footer">
        Terima kasih telah membantu menyelamatkan makanan dan menjaga bumi! 🌍
    </div>
</div>
</x-app-layout>
