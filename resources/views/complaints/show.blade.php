<x-app-layout>
<style>
/* ─── COMPLAINT CHAT PAGE ─── */
.complaint-page {
    min-height: 100vh;
    background: var(--off-white);
    font-family: 'Outfit', sans-serif;
}

/* Header */
.complaint-hdr {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(247,253,249,0.92);
    backdrop-filter: blur(20px);
    border-bottom: 1.5px solid var(--border);
    padding: 0 2rem;
}
.complaint-hdr-inner {
    max-width: 900px;
    margin: 0 auto;
    height: 70px;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.1rem;
    border-radius: 999px;
    background: var(--mint-100);
    color: var(--mint-700);
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    border: 1.5px solid var(--mint-200);
    transition: all 0.2s;
}
.back-btn:hover { background: var(--mint-200); transform: translateX(-2px); }
.hdr-title {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--ink);
}
.hdr-title span { color: var(--mint-600); }

/* Main Container */
.complaint-wrap {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Info Card */
.info-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    box-shadow: 0 2px 12px rgba(22,163,74,0.06);
}
.info-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.info-card-title {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6b7280;
    margin-bottom: 0.25rem;
}
.status-badge {
    padding: 0.35rem 1rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.status-pending   { background: #fef3c7; color: #92400e; }
.status-ditinjau  { background: #dbeafe; color: #1e40af; }
.status-selesai   { background: #dcfce7; color: #166534; }
.status-ditolak   { background: #fee2e2; color: #991b1b; }

.complaint-reason {
    background: var(--mint-50);
    border-left: 4px solid var(--mint-400);
    border-radius: 0 12px 12px 0;
    padding: 1rem 1.25rem;
    font-size: 0.9rem;
    color: var(--ink);
    line-height: 1.6;
}
.parties {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.party {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #6b7280;
}
.party strong { color: var(--ink); }

/* Chat Box */
.chat-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(22,163,74,0.06);
    display: flex;
    flex-direction: column;
}
.chat-header {
    background: linear-gradient(135deg, var(--mint-600), var(--mint-500));
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.chat-header-icon {
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}
.chat-header h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}
.chat-header p {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.8);
    margin: 0;
}

/* Messages Area */
.messages-area {
    flex: 1;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    min-height: 350px;
    max-height: 500px;
    overflow-y: auto;
    background: #fafafa;
}
.messages-area::-webkit-scrollbar { width: 4px; }
.messages-area::-webkit-scrollbar-track { background: transparent; }
.messages-area::-webkit-scrollbar-thumb { background: var(--mint-300); border-radius: 4px; }

/* Message Bubbles */
.msg-row {
    display: flex;
    align-items: flex-end;
    gap: 0.5rem;
}
/* Posisi dinamis berdasarkan pengirim asli */
.msg-row.my-msg { justify-content: flex-end; }
.msg-row.other-msg { justify-content: flex-start; }

.msg-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    flex-shrink: 0;
}
.avatar-admin { background: var(--mint-600); color: #fff; }
.avatar-user  { background: #e5e7eb; color: #374151; }

.msg-bubble {
    max-width: 70%;
    padding: 0.75rem 1rem;
    border-radius: 18px;
    font-size: 0.875rem;
    line-height: 1.5;
}
.bubble-my {
    background: linear-gradient(135deg, var(--mint-600), var(--mint-500));
    color: #fff;
    border-bottom-right-radius: 4px;
}
.bubble-other {
    background: #fff;
    color: #1f2937;
    border: 1.5px solid #e5e7eb;
    border-bottom-left-radius: 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.msg-time {
    font-size: 0.7rem;
    color: #9ca3af;
    margin-top: 0.25rem;
    text-align: right;
}
.msg-row.other-msg .msg-time { text-align: left; }
.msg-meta {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}
.msg-sender-name {
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    padding: 0 0.25rem;
}

/* Empty State */
.chat-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    padding: 3rem;
    text-align: center;
    color: #9ca3af;
    gap: 0.5rem;
    min-height: 250px;
}
.chat-empty-icon { font-size: 3rem; margin-bottom: 0.5rem; }
.chat-empty p { font-size: 0.875rem; margin: 0; }

/* Input Area */
.chat-input-area {
    border-top: 1.5px solid #f3f4f6;
    padding: 1rem 1.5rem;
    background: #fff;
}
.input-row {
    display: flex;
    gap: 0.75rem;
    align-items: flex-end;
}
.msg-textarea {
    flex: 1;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    font-family: 'Outfit', sans-serif;
    color: #1f2937;
    background: #fafafa;
    resize: none;
    outline: none;
    transition: all 0.2s;
    min-height: 48px;
    max-height: 120px;
}
.msg-textarea:focus {
    border-color: var(--mint-400);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(34,197,94,0.1);
}
.msg-textarea::placeholder { color: #9ca3af; }
.send-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--mint-600), var(--mint-500));
    border: none;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}
.send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(22,163,74,0.4);
}
.send-btn svg { width: 20px; height: 20px; }

/* Closed notice */
.closed-notice {
    text-align: center;
    padding: 1rem;
    background: #f9fafb;
    border-top: 1.5px solid #f3f4f6;
    font-size: 0.8rem;
    color: #6b7280;
}

/* Admin Status Update */
.status-form {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(22,163,74,0.06);
}
.status-form h4 {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--ink);
    margin: 0 0 1rem;
}
.status-form-row {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}
.status-select {
    flex: 1;
    min-width: 160px;
    padding: 0.6rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.875rem;
    font-family: 'Outfit', sans-serif;
    color: #1f2937;
    background: #fafafa;
    outline: none;
    cursor: pointer;
    transition: all 0.2s;
}
.status-select:focus { border-color: var(--mint-400); background: #fff; }
.update-status-btn {
    padding: 0.6rem 1.5rem;
    background: linear-gradient(135deg, var(--mint-600), var(--mint-500));
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    font-family: 'Outfit', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
}
.update-status-btn:hover { opacity: 0.9; transform: translateY(-1px); }

@media (max-width: 640px) {
    .complaint-hdr { padding: 0 1rem; }
    .complaint-wrap { padding: 1rem; }
    .msg-bubble { max-width: 85%; }
    .messages-area { padding: 1rem; min-height: 280px; }
}
</style>

<div class="complaint-page">
    {{-- Header --}}
    <header class="complaint-hdr">
        <div class="complaint-hdr-inner">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="back-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Dashboard Admin
                </a>
            @elseif(auth()->user()->role === 'lembaga_sosial')
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
            <div>
                <div class="hdr-title">Detail <span>Keluhan</span> #{{ $complaint->id }}</div>
            </div>
        </div>
    </header>

    <div class="complaint-wrap">
        {{-- Info Keluhan --}}
        <div class="info-card">
            <div class="info-card-header">
                <div>
                    <div class="info-card-title">Informasi Keluhan</div>
                    <div style="font-weight:700; font-size:1rem; color:var(--ink);">Keluhan #{{ $complaint->id }}</div>
                </div>
                <span class="status-badge status-{{ $complaint->status }}">
                    {{ ucfirst($complaint->status) }}
                </span>
            </div>

            <div class="parties">
                <div class="party">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Pelapor: <strong>{{ $complaint->reporter->name }}</strong></span>
                </div>
                <div class="party">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Terlapor (Seller): <strong>{{ $complaint->seller->name }}</strong></span>
                </div>
                <div class="party">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Dilaporkan: <strong>{{ $complaint->created_at->format('d M Y, H:i') }}</strong></span>
                </div>
            </div>

            <div class="info-card-title" style="margin-top:0.25rem;">Isi Keluhan:</div>
            <div class="complaint-reason">{{ $complaint->reason }}</div>
        </div>

        {{-- Admin: Update Status & Suspend Akun --}}
        @if(auth()->user()->role === 'admin')
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
            
            <div class="status-form" style="flex: 2; min-width: 280px;">
                <h4>⚙️ Perbarui Status Keluhan</h4>
                <form action="{{ route('admin.complaints.status', $complaint) }}" method="POST">
                    @csrf
                    <div class="status-form-row">
                        <select name="status" class="status-select">
                            <option value="pending"  {{ $complaint->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="ditinjau" {{ $complaint->status === 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                            <option value="selesai"  {{ $complaint->status === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak"  {{ $complaint->status === 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="update-status-btn">Simpan Status</button>
                    </div>
                </form>
            </div>

            @if($complaint->seller)
            <div class="status-form" style="flex: 1; min-width: 240px; border-color: #fee2e2; background: #fff5f5; display: flex; flex-direction: column; justify-content: space-between;">
                <h4 style="color: #991b1b; margin-bottom: 0.5rem;">⚠️ Tindakan Tegas Admin</h4>
                <p style="font-size: 0.75rem; color: #7f1d1d; margin: 0 0 1rem 0; line-height: 1.4;">
                    Jika terbukti menipu atau melanggar, Anda dapat menonaktifkan seluruh aktivitas toko ini.
                </p>
                <form action="{{ route('admin.users.toggle-status', $complaint->seller_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="update-status-btn" 
                            style="width: 100%; transition: all 0.2s;
                                   background: {{ $complaint->seller->account_status === 'suspend' ? '#dc2626' : 'linear-gradient(135deg, #dc2626, #b91c1c)' }};
                                   box-shadow: 0 4px 12px rgba(220,38,38,0.2);">
                        {{ $complaint->seller->account_status === 'suspend' ? '✓ Lepas Suspend Toko' : '🚨 Suspend Akun Seller' }}
                    </button>
                </form>
            </div>
            @endif

        </div>
        @endif

        {{-- Chat Area --}}
        <div class="chat-card">
            <div class="chat-header">
                <div class="chat-header-icon">💬</div>
                <div>
                    <h3>Percakapan Keluhan</h3>
                    <p>Hanya Anda dan Tim Admin FoodSave yang dapat membaca percakapan ini</p>
                </div>
            </div>

            {{-- Messages --}}
            <div class="messages-area" id="messagesArea">
                @forelse($complaint->messages as $msg)
                    @php
                        // CEK APAKAH PESAN INI MILIK USER YANG SEDANG LOGIN (DINAMIS)
                        $isMyMessage = ($msg->user_id === auth()->id());
                        $msgSenderIsAdmin = ($msg->sender_role === 'admin');
                    @endphp
                    
                    <div class="msg-row {{ $isMyMessage ? 'my-msg' : 'other-msg' }}">
                        {{-- Avatar muncul di KIRI jika ini adalah pesan ORANG LAIN --}}
                        @if(!$isMyMessage)
                            @if($msgSenderIsAdmin)
                                <div class="msg-avatar avatar-admin">🛡️</div>
                            @else
                                <div class="msg-avatar avatar-user">
                                    {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif

                        <div class="msg-meta">
                            <div class="msg-sender-name" style="{{ $isMyMessage ? 'text-align:right;' : '' }}">
                                {{ $msgSenderIsAdmin ? '🛡️ Admin FoodSave' : $msg->sender->name }}
                            </div>
                            
                            {{-- Warna bubble: hijau untuk SAYA, putih untuk ORANG LAIN --}}
                            <div class="msg-bubble {{ $isMyMessage ? 'bubble-my' : 'bubble-other' }}">
                                {{ $msg->message }}
                            </div>
                            
                            <div class="msg-time">
                                {{ $msg->created_at->diffForHumans() }}
                            </div>
                        </div>

                        {{-- Avatar muncul di KANAN jika ini adalah pesan SAYA --}}
                        @if($isMyMessage)
                            @if($msgSenderIsAdmin)
                                <div class="msg-avatar avatar-admin">🛡️</div>
                            @else
                                <div class="msg-avatar avatar-user">
                                    {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="chat-empty">
                        <div class="chat-empty-icon">💬</div>
                        <p style="font-weight:600; color:#374151;">Belum ada percakapan</p>
                        <p>Mulai percakapan dengan mengirim pesan di bawah ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Input --}}
            @if($complaint->status !== 'selesai' && $complaint->status !== 'ditolak')
                <div class="chat-input-area">
                    <form action="{{ route('complaints.sendMessage', $complaint->id) }}" method="POST" id="msgForm">
                        @csrf
                        <div class="input-row">
                            <textarea
                                name="message"
                                id="msgInput"
                                class="msg-textarea"
                                placeholder="Tulis pesan Anda di sini..."
                                rows="1"
                                required
                            ></textarea>
                            <button type="submit" class="send-btn" title="Kirim Pesan">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="closed-notice">
                    🔒 Keluhan ini sudah <strong>{{ $complaint->status }}</strong>. Percakapan tidak dapat dilanjutkan.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Auto-scroll ke bawah
const area = document.getElementById('messagesArea');
if (area) area.scrollTop = area.scrollHeight;

// Auto-resize textarea
const ta = document.getElementById('msgInput');
if (ta) {
    ta.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    // Submit dengan Ctrl+Enter
    ta.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('msgForm').submit();
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#16a34a'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        @endif
    });
</script>
</x-app-layout>