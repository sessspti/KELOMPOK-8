<x-app-layout>
    <x-header />
    
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Riwayat Pesanan</h1>
                <p class="text-gray-500 mt-2">Daftar semua kontribusimu dalam menyelamatkan makanan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="flex items-center text-sm font-bold text-green-600 hover:text-green-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        @if($transactions->isEmpty())
            <div class="bg-white rounded-[2.5rem] p-16 text-center border border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-50 rounded-3xl mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Belum ada pesanan</h3>
                <p class="text-gray-500 mt-2 max-w-xs mx-auto">Mulailah menyelamatkan makanan hari ini dan jadilah pahlawan bagi bumi!</p>
                <a href="{{ route('dashboard') }}" class="inline-block mt-8 px-8 py-4 bg-green-600 text-white font-black rounded-2xl hover:bg-green-700 transition-all shadow-xl shadow-green-600/20">
                    Eksplorasi Makanan
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($transactions as $trx)
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:border-green-200 transition-all group">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-green-50 group-hover:text-green-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-lg font-black text-gray-900">{{ $trx->transaction_id }}</span>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                            {{ $trx->status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 font-medium">
                                        <span class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y, H:i') }}
                                        </span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            {{ $trx->payment_method }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between md:justify-end gap-8 border-t md:border-t-0 pt-6 md:pt-0">
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Total Pembayaran</p>
                                    <p class="text-2xl font-black text-green-600">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('transaction.invoice', $trx->transaction_id) }}" class="px-6 py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-black transition-all shadow-lg shadow-gray-900/10 flex items-center gap-2">
                                    Lihat Invoice
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
