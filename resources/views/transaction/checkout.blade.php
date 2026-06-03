<x-app-layout>
    <x-header />
    <div x-data="foodSaveCheckout()" class="max-w-4xl mx-auto px-4 py-12">
        
        <!-- Stepper -->
        <div class="flex items-center justify-center mb-12">
            <div class="flex items-center text-green-600">
                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-green-100 font-bold border-2 border-green-600">1</div>
                <span class="ml-3 font-bold">Keranjang</span>
            </div>
            <div class="w-16 h-1 bg-green-200 mx-4 rounded"></div>
            <div class="flex items-center text-green-600">
                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-green-600 text-white font-bold">2</div>
                <span class="ml-3 font-bold">Pembayaran</span>
            </div>
            <div class="w-16 h-1 bg-gray-200 mx-4 rounded"></div>
            <div class="flex items-center text-gray-400">
                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-white border-2 border-gray-200 font-bold">3</div>
                <span class="ml-3 font-bold">Selesai</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Left Side: Order Review & Payment -->
            <div class="space-y-8">
                <!-- Order Review -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Review Pesanan
                    </h2>
                    
                    <div class="space-y-4">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img :src="item.image_url || '{{ asset('images/placeholder.png') }}'" class="h-12 w-12 rounded-xl object-cover shadow-sm">
                                        <span class="absolute -top-2 -right-2 bg-green-600 text-white text-[10px] h-5 w-5 flex items-center justify-center rounded-full border-2 border-white" x-text="item.qty"></span>
                                    </div>
                                    <span class="font-semibold text-gray-700" x-text="item.name"></span>
                                </div>
                                <span class="font-bold text-gray-900" x-text="formatRupiah((item.final_price !== undefined ? item.final_price : item.price) * item.qty)"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Metode Pengambilan (AC 1) -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Metode Pengambilan
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Opsi: Self-Pickup -->
                        <label 
                            :class="pickupMethod === 'self-pickup' ? 'border-green-500 bg-green-50/30' : 'border-gray-100 hover:border-gray-200'"
                            class="flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all group w-full"
                        >
                            <input type="radio" x-model="pickupMethod" value="self-pickup" class="hidden">
                            <div 
                                class="h-10 w-10 rounded-xl flex items-center justify-center mr-4"
                                :class="pickupMethod === 'self-pickup' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <p class="font-bold text-gray-900 text-sm">Self-Pickup</p>
                                <p class="text-xs text-gray-500">Ambil cepat tanpa antre</p>
                            </div>
                            <div 
                                class="h-6 w-6 rounded-full border-2 flex items-center justify-center"
                                :class="pickupMethod === 'self-pickup' ? 'border-green-600 bg-green-600' : 'border-gray-200'"
                            >
                                <svg x-show="pickupMethod === 'self-pickup'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </label>
                    </div>

                    <!-- Slot Waktu Pengambilan (AC 2) -->
                    <div 
                        x-show="pickupMethod === 'self-pickup'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="mt-6 p-6 bg-green-50/20 border border-green-100 rounded-2xl"
                    >
                        <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pilih Slot Waktu Pengambilan
                        </label>
                        <p class="text-xs text-gray-500 mb-4">Pilih waktu pengambilan yang sesuai dengan jam operasional toko untuk menghindari antrean.</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <template x-for="slot in pickupTimeSlots" :key="slot">
                                <button 
                                    type="button"
                                    @click="pickupTime = slot"
                                    :class="pickupTime === slot ? 'bg-green-600 text-white border-green-600 shadow-md shadow-green-600/20' : 'bg-white text-gray-700 border-gray-200 hover:border-green-500 hover:bg-green-50/30'"
                                    class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all text-center"
                                    x-text="'Pukul ' + slot"
                                >
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Metode Pembayaran
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        <template x-for="method in paymentMethods" :key="method.id">
                            <label 
                                :class="selectedMethod === method.id ? 'border-green-500 bg-green-50/30' : 'border-gray-100 hover:border-gray-200'"
                                class="flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all group"
                            >
                                <input type="radio" x-model="selectedMethod" :value="method.id" class="hidden">
                                <div 
                                    class="h-10 w-10 rounded-xl flex items-center justify-center mr-4"
                                    :class="selectedMethod === method.id ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'"
                                >
                                    <span x-html="method.icon"></span>
                                </div>
                                <div class="flex-grow">
                                    <p class="font-bold text-gray-900" x-text="method.name"></p>
                                    <p class="text-xs text-gray-500" x-text="method.description"></p>
                                </div>
                                <div 
                                    class="h-6 w-6 rounded-full border-2 flex items-center justify-center"
                                    :class="selectedMethod === method.id ? 'border-green-600 bg-green-600' : 'border-gray-200'"
                                >
                                    <svg x-show="selectedMethod === method.id" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="lg:sticky lg:top-8 self-start">
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-green-200/20 relative overflow-hidden">
                    <!-- Decor -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-green-600/10 rounded-full blur-3xl"></div>
                    
                    <h2 class="text-2xl font-bold mb-8 relative z-10">Ringkasan Biaya</h2>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex justify-between text-gray-400 font-medium">
                            <span>Subtotal Pesanan</span>
                            <span class="text-white" x-text="formatRupiah(cartTotal)"></span>
                        </div>
                        <div class="flex justify-between text-gray-400 font-medium border-b border-white/10 pb-4">
                            <span>Biaya Layanan</span>
                            <span class="text-white" x-text="formatRupiah(serviceFee)"></span>
                        </div>
                        <div class="flex justify-between items-center pt-4 mb-8">
                            <span class="text-lg font-bold">Total Pembayaran</span>
                            <span class="text-3xl font-black text-green-500" x-text="formatRupiah(grandTotal)"></span>
                        </div>
                    </div>

                    <button 
                        @click="processPayment"
                        :disabled="isProcessing || !selectedMethod || (pickupMethod === 'self-pickup' && !pickupTime)"
                        class="w-full py-5 rounded-2xl font-black text-lg transition-all duration-300 flex items-center justify-center gap-3 relative z-10"
                        :class="isProcessing ? 'bg-gray-700 cursor-not-allowed' : (selectedMethod && (pickupMethod !== 'self-pickup' || pickupTime) ? 'bg-green-600 hover:bg-green-500 shadow-xl shadow-green-600/30' : 'bg-gray-800 text-gray-500 cursor-not-allowed')"
                    >
                        <template x-if="!isProcessing">
                            <span>Bayar Sekarang</span>
                        </template>
                        <template x-if="isProcessing">
                            <div class="flex items-center gap-3">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses...</span>
                            </div>
                        </template>
                    </button>
                    
                    <p class="text-center text-[10px] text-gray-500 mt-6 uppercase tracking-widest font-bold">
                        Dikuasai oleh Midtrans Mock Gateway
                    </p>
                </div>

                <a href="{{ route('dashboard') }}" class="flex items-center justify-center mt-6 text-gray-500 font-bold hover:text-green-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Eksplorasi
                </a>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function foodSaveCheckout() {
            return {
                cart: JSON.parse(localStorage.getItem('foodsave_cart')) || [],
                selectedMethod: '',
                pickupMethod: 'self-pickup',
                pickupTime: '14:00 - 14:30',
                pickupTimeSlots: [
                    '09:00 - 09:30',
                    '10:00 - 10:30',
                    '11:00 - 11:30',
                    '12:00 - 12:30',
                    '13:00 - 13:30',
                    '14:00 - 14:30',
                    '15:00 - 15:30',
                    '16:00 - 16:30',
                    '17:00 - 17:30',
                    '18:00 - 18:30',
                    '19:00 - 19:30',
                    '20:00 - 20:30'
                ],
                isProcessing: false,
                invoiceNumber: '',
                serviceFee: 0,
                
                paymentMethods: [
                    { id: 'bank', name: 'Transfer Bank', description: 'BCA, Mandiri, BNI', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                    { id: 'wallet', name: 'E-Wallet', description: 'GoPay, OVO, Dana', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                    { id: 'card', name: 'Kartu Kredit', description: 'Visa, Mastercard', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                ],

                get cartTotal() {
                    return this.cart.reduce((total, item) => {
                        const price = item.final_price !== undefined ? item.final_price : item.price;
                        return total + (price * item.qty);
                    }, 0);
                },

                get grandTotal() {
                    return this.cartTotal + this.serviceFee;
                },

                processPayment() {
                    if (!this.selectedMethod) return;
                    
                    if (this.selectedMethod === 'wallet') {
                        // QR Code simulation using QR Server API
                        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=FOODSAVE-PAYMENT-${Date.now()}-${this.grandTotal}`;
                        
                        Swal.fire({
                            title: 'Pembayaran QRIS',
                            html: `
                                <div class="flex flex-col items-center py-4">
                                    <div class="bg-white p-4 rounded-3xl shadow-sm border-2 border-gray-50 mb-6">
                                        <img src="${qrUrl}" alt="QRIS" class="w-56 h-56">
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium mb-1">Total Tagihan:</p>
                                    <p class="text-3xl font-black text-green-600 mb-6">${this.formatRupiah(this.grandTotal)}</p>
                                    <div class="bg-blue-50 text-blue-700 p-4 rounded-2xl text-xs font-medium text-center leading-relaxed">
                                        Silakan pindai kode QR di atas menggunakan aplikasi e-wallet Anda (GoPay, OVO, Dana, dll).
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Saya Sudah Bayar',
                            cancelButtonText: 'Nanti Saja',
                            confirmButtonColor: '#16a34a',
                            cancelButtonColor: '#9ca3af',
                            background: '#ffffff',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-[2.5rem] p-6',
                                title: 'font-bold text-gray-900 pt-4'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.executeOrder();
                            }
                        });
                    } else {
                        // For Bank or Card, go straight to order execution (simulation)
                        this.executeOrder();
                    }
                },

                executeOrder() {
                    this.isProcessing = true;
                    
                    fetch('{{ route('transaction.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart: this.cart,
                            payment_method: this.paymentMethods.find(m => m.id === this.selectedMethod).name,
                            pickup_method: this.pickupMethod,
                            pickup_time: this.pickupMethod === 'self-pickup' ? this.pickupTime : null,
                            subtotal: this.cartTotal,
                            service_fee: this.serviceFee,
                            grand_total: this.grandTotal
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.isProcessing = false;
                        
                        if (data.success) {
                            Swal.fire({
                                title: "Pesanan Berhasil!",
                                text: "Pembayaran terverifikasi. Nomor transaksi: " + data.transaction_id,
                                icon: "success",
                                confirmButtonText: "Lihat Invoice",
                                confirmButtonColor: "#16a34a",
                                background: "#ffffff",
                                customClass: {
                                    title: 'font-bold text-gray-900',
                                    popup: 'rounded-[2.5rem] p-8'
                                }
                            }).then((result) => {
                                localStorage.removeItem('foodsave_cart');
                                window.location.href = data.redirect_url;
                            });
                        } else {
                            Swal.fire("Gagal", data.message || "Gagal memproses pesanan.", "error");
                        }
                    })
                    .catch(error => {
                        this.isProcessing = false;
                        console.error('Error:', error);
                        Swal.fire("Error", "Gagal menghubungi server.", "error");
                    });
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }
            };
        }
    </script>
</x-app-layout>
