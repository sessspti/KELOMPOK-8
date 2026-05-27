@php
    $impact = $impact ?? null;
    $role = $role ?? (auth()->user()->role ?? 'konsumen');
@endphp

<div id="impact-tracker-card" data-user-role="{{ $role }}" style="background:#ecfdf3;border:1px solid #bbf7d0;border-radius:16px;padding:16px;margin-bottom:16px;">
    <div style="font-weight:800;color:#166534;margin-bottom:10px;">Impact Tracker</div>
    <div style="display:grid;grid-template-columns:repeat({{ $role === 'konsumen' ? 3 : 2 }},1fr);gap:10px;">
        <div>
            <div style="font-size:12px;color:#4b5563;">Makanan Diselamatkan</div>
            <div id="impact-food" style="font-size:24px;font-weight:700;color:#16a34a;">{{ number_format((float)($impact->food_saved_kg ?? 0), 1) }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:#4b5563;">Reduksi CO2</div>
            <div id="impact-co2" style="font-size:24px;font-weight:700;color:#0284c7;">{{ number_format((float)($impact->co2_reduced_kg ?? 0), 1) }}</div>
        </div>
        @if($role === 'konsumen')
            <div>
                <div style="font-size:12px;color:#4b5563;">Uang Dihemat</div>
                <div id="impact-money" style="font-size:24px;font-weight:700;color:#d97706;">Rp {{ number_format((float)($impact->money_saved ?? 0), 0, ',', '.') }}</div>
            </div>
        @endif
    </div>
    <div style="margin-top:8px;font-size:12px;color:#374151;">
        Total transaksi selesai: <strong id="impact-rescues">{{ (int)($impact->total_rescues ?? 0) }}</strong>
    </div>
</div>
