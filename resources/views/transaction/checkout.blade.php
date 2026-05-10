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
                                        <img :src="item.image" class="h-12 w-12 rounded-xl object-cover shadow-sm">
                                        <span class="absolute -top-2 -right-2 bg-green-600 text-white text-[10px] h-5 w-5 flex items-center justify-center rounded-full border-2 border-white" x-text="item.qty"></span>
                                    </div>
                                    <span class="font-semibold text-gray-700" x-text="item.name"></span>
                                </div>
                                <span class="font-bold text-gray-900" x-text="formatRupiah(item.price * item.qty)"></span>
                            </div>
                        </template>
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
                        :disabled="isProcessing || !selectedMethod"
                        class="w-full py-5 rounded-2xl font-black text-lg transition-all duration-300 flex items-center justify-center gap-3 relative z-10"
                        :class="isProcessing ? 'bg-gray-700 cursor-not-allowed' : (selectedMethod ? 'bg-green-600 hover:bg-green-500 shadow-xl shadow-green-600/30' : 'bg-gray-800 text-gray-500 cursor-not-allowed')"
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
                isProcessing: false,
                invoiceNumber: '',
                serviceFee: 2000,
                
                paymentMethods: [
                    { id: 'bank', name: 'Transfer Bank', description: 'BCA, Mandiri, BNI', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                    { id: 'wallet', name: 'E-Wallet', description: 'GoPay, OVO, Dana', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                    { id: 'card', name: 'Kartu Kredit', description: 'Visa, Mastercard', icon: '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
                ],

                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
                },

                get grandTotal() {
                    return this.cartTotal + this.serviceFee;
                },

                processPayment() {
                    if (!this.selectedMethod) return;
                    
                    this.isProcessing = true;
                    
                    // Simulated Delay (Network Mock)
                    setTimeout(() => {
                        this.isProcessing = false;
                        this.invoiceNumber = 'INV-' + Math.floor(Math.random() * 1000000);
                        
                        // SweetAlert 2 Success
                        Swal.fire({
                            title: "Pembayaran Berhasil!",
                            text: "Pesananmu dengan nomor " + this.invoiceNumber + " sedang diproses. Terima kasih telah menyelamatkan makanan!",
                            icon: "success",
                            draggable: true,
                            confirmButtonText: "Lihat Detail Transaksi",
                            confirmButtonColor: "#22c55e",
                            background: "#ffffff",
                            customClass: {
                                title: 'font-bold text-gray-900',
                                popup: 'rounded-[2.5rem] p-8'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/detail-transaksi'; // Redirection to transaction detail (placeholder)
                            }
                        });

                        // Clear Cart
                        localStorage.removeItem('foodsave_cart');
                        
                        console.log("TRIGGER: Notification sent to Buyer & Seller");
                    }, 2000);
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
