<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4">
        <div class="max-w-3xl mx-auto">
            
            <!-- Back Action -->
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('transaction.history') }}" class="flex items-center text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Riwayat
                </a>
                <button onclick="window.print()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center gap-2 print:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Invoice
                </button>
            </div>

            <!-- Invoice Card -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100 relative">
                <!-- Branding Header -->
                <div class="bg-green-600 p-12 text-white relative">
                    <div class="absolute top-0 right-0 p-12 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                        </svg>
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span class="text-2xl font-black tracking-tighter">FoodSave</span>
                            </div>
                            <h1 class="text-4xl font-black tracking-tight mb-2">Invoice</h1>
                            <p class="text-green-100 font-medium">Terima kasih telah menyelamatkan makanan!</p>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-green-100 text-xs font-bold uppercase tracking-widest mb-1">Nomor Invoice</p>
                            <p class="text-2xl font-black mb-4">{{ $transaction->id }}</p>
                            <div class="inline-flex px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider">
                                Status: {{ $transaction->status }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                        <div>
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Ditujukan Untuk</h4>
                            <p class="text-xl font-black text-gray-900">{{ $transaction->customer_name }}</p>
                            <p class="text-gray-500 font-medium mt-1">{{ $transaction->customer_email }}</p>
                        </div>
                        <div class="md:text-right">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Detail Transaksi</h4>
                            <p class="text-gray-900 font-bold">Tanggal: <span class="font-medium text-gray-500 ml-1">{{ \Carbon\Carbon::parse($transaction->date)->format('d F Y, H:i') }}</span></p>
                            <p class="text-gray-900 font-bold mt-1">Metode: <span class="font-medium text-gray-500 ml-1">{{ $transaction->payment_method }}</span></p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="border-t border-gray-100 pt-10">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left">
                                    <th class="pb-6 text-xs font-black text-gray-400 uppercase tracking-widest">Item Pesanan</th>
                                    <th class="pb-6 text-center text-xs font-black text-gray-400 uppercase tracking-widest">Qty</th>
                                    <th class="pb-6 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Harga</th>
                                    <th class="pb-6 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @php $total = 0; @endphp
                                @foreach($orders as $order)
                                    @php $subtotal = $order->quantity * $order->menu->price; $total += $subtotal; @endphp
                                    <tr>
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $order->menu->image }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $order->menu->name }}</p>
                                                    <p class="text-xs text-gray-400 font-medium">{{ $order->menu->user->name ?? 'Restoran' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 text-center font-bold text-gray-900">{{ $order->quantity }}</td>
                                        <td class="py-6 text-right font-medium text-gray-500">Rp {{ number_format($order->menu->price, 0, ',', '.') }}</td>
                                        <td class="py-6 text-right font-black text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="mt-10 border-t-2 border-gray-900 pt-10 flex flex-col items-end">
                        <div class="w-full md:w-64 space-y-4">
                            <div class="flex justify-between text-gray-500 font-bold">
                                <span>Subtotal</span>
                                <span class="text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 font-bold pb-4 border-b border-gray-100">
                                <span>Biaya Layanan</span>
                                <span class="text-gray-900">Rp 2.000</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-lg font-black text-gray-900">Total</span>
                                <span class="text-3xl font-black text-green-600">Rp {{ number_format($total + 2000, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Note -->
                    <div class="mt-20 pt-10 border-t border-dashed border-gray-200 text-center">
                        <p class="text-sm text-gray-400 font-medium italic">Simpan invoice ini sebagai bukti penyelamatan makananmu. Setiap gram yang kamu selamatkan sangat berarti bagi bumi.</p>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="bg-gray-50 p-8 flex items-center justify-center gap-12">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Verified Payment</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stock Updated</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
