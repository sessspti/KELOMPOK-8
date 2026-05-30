<x-app-layout>
<style>
.complaints-page { min-height:100vh; background:var(--off-white); font-family:'Outfit',sans-serif; }
.complaints-hdr { position:sticky; top:0; z-index:100; background:rgba(247,253,249,0.92); backdrop-filter:blur(20px); border-bottom:1.5px solid var(--border); padding:0 2rem; }
.complaints-hdr-inner { max-width:860px; margin:0 auto; height:70px; display:flex; align-items:center; gap:1rem; }
.back-btn { display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1.1rem; border-radius:999px; background:var(--mint-100); color:var(--mint-700); font-weight:600; font-size:0.875rem; text-decoration:none; border:1.5px solid var(--mint-200); transition:all 0.2s; }
.back-btn:hover { background:var(--mint-200); transform:translateX(-2px); }
.page-title { font-weight:700; font-size:1.15rem; color:var(--ink); }
.page-title span { color:var(--mint-600); }

.complaints-wrap { max-width:860px; margin:0 auto; padding:2rem 1.5rem; }
.section-header { margin-bottom:1.5rem; }
.section-header h2 { font-size:1.4rem; font-weight:800; color:var(--ink); margin:0 0 0.25rem; }
.section-header p { font-size:0.875rem; color:#6b7280; margin:0; }

.complaint-card { background:#fff; border:1.5px solid var(--border); border-radius:18px; padding:1.25rem 1.5rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1rem; transition:all 0.2s; box-shadow:0 2px 8px rgba(22,163,74,0.05); flex-wrap:wrap; }
.complaint-card:hover { border-color:var(--mint-300); box-shadow:0 4px 16px rgba(22,163,74,0.1); transform:translateY(-1px); }
.cc-left { flex:1; min-width:200px; }
.cc-id { font-size:0.75rem; color:#9ca3af; font-weight:600; margin-bottom:0.25rem; }
.cc-seller { font-size:0.9rem; font-weight:700; color:var(--ink); margin-bottom:0.5rem; }
.cc-seller span { color:#6b7280; font-weight:400; font-size:0.8rem; }
.cc-preview { font-size:0.8rem; color:#6b7280; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:400px; }
.cc-right { display:flex; flex-direction:column; align-items:flex-end; gap:0.5rem; }
.status-badge { padding:0.3rem 0.9rem; border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; }
.status-pending   { background:#fef3c7; color:#92400e; }
.status-ditinjau  { background:#dbeafe; color:#1e40af; }
.status-selesai   { background:#dcfce7; color:#166534; }
.status-ditolak   { background:#fee2e2; color:#991b1b; }
.detail-btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.45rem 1rem; border-radius:999px; background:var(--mint-600); color:#fff; font-size:0.8rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
.detail-btn:hover { background:var(--mint-700); transform:translateY(-1px); }
.unread-dot { width:8px; height:8px; background:#ef4444; border-radius:50%; display:inline-block; margin-left:0.25rem; }

.empty-state { text-align:center; padding:4rem 2rem; }
.empty-icon { font-size:4rem; margin-bottom:1rem; }
.empty-state h3 { font-size:1.25rem; font-weight:700; color:var(--ink); margin:0 0 0.5rem; }
.empty-state p { font-size:0.875rem; color:#6b7280; margin:0; }
</style>

<div class="complaints-page">
    <header class="complaints-hdr">
        <div class="complaints-hdr-inner">
            @if(auth()->user()->role === 'lembaga_sosial')
                <a href="{{ route('sosial.dashboard') }}" class="back-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Dashboard
                </a>
            @endif
            <div class="page-title">Riwayat <span>Keluhan</span> Saya</div>
        </div>
    </header>

    <div class="complaints-wrap">
        <div class="section-header">
            <h2>📋 Keluhan yang Pernah Dikirim</h2>
            <p>Pantau status dan balas pesan dari Admin terkait keluhan Anda.</p>
        </div>

        @forelse($complaints as $complaint)
            @php
                $unread = $complaint->messages->where('sender_role','admin')->where('is_read', false)->count();
            @endphp
            <div class="complaint-card">
                <div class="cc-left">
                    <div class="cc-id">Keluhan #{{ $complaint->id }} · {{ $complaint->created_at->format('d M Y') }}</div>
                    <div class="cc-seller">
                        Tentang Seller: <span>{{ $complaint->seller->name ?? 'Seller Dihapus' }}</span>
                    </div>
                    <div class="cc-preview">{{ Str::limit($complaint->reason, 80) }}</div>
                </div>
                <div class="cc-right">
                    <span class="status-badge status-{{ $complaint->status }}">
                        {{ ucfirst($complaint->status) }}
                    </span>
                    <a href="{{ route('complaints.show', $complaint) }}" class="detail-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Lihat Chat
                        @if($unread > 0)
                            <span class="unread-dot"></span>
                        @endif
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">🕊️</div>
                <h3>Belum Ada Keluhan</h3>
                <p>Anda belum pernah mengirimkan keluhan kepada admin. Semoga segalanya berjalan baik!</p>
            </div>
        @endforelse
    </div>
</div>
</x-app-layout>
