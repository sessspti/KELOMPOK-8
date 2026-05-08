<!-- Cart Sidebar Component -->
<div 
    x-show="isCartOpen" 
    class="fixed inset-0 z-[300] overflow-hidden" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-black/50" @click="isCartOpen = false"></div>
    
    <div class="absolute inset-y-0 right-0 max-w-full flex">
        <div 
            class="w-screen max-w-md bg-white shadow-2xl flex flex-col"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <!-- Cart Header -->
            <div class="px-6 py-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Keranjang Belanja</h2>
                <button @click="isCartOpen = false" class="text-gray-500 hover:text-gray-700 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items List -->
            <div class="flex-grow overflow-y-auto p-6 space-y-6 bg-gray-50">
                <template x-if="cart.length === 0">
                    <div class="text-center py-12">
                        <div class="bg-gray-200 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-800 font-bold text-lg">Keranjang Kosong</h3>
                        <p class="text-gray-500 text-sm mt-2">Ayo pilih makanan lezat untuk diselamatkan!</p>
                        <button @click="isCartOpen = false" class="mt-6 px-4 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700">Mulai Belanja</button>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="h-20 w-20 flex-shrink-0">
                            <img :src="item.image" class="h-full w-full object-cover rounded-lg border border-gray-200">
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-900 text-sm" x-text="item.name"></h4>
                                <button @click="removeFromCart(item.id)" class="text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm font-bold text-green-600 mt-1" x-text="formatRupiah(item.price)"></p>
                            <div class="flex items-center gap-3 mt-3">
                                <button @click="updateQty(item.id, -1)" class="w-7 h-7 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-100">-</button>
                                <span class="font-bold text-gray-800 text-sm" x-text="item.qty"></span>
                                <button @click="updateQty(item.id, 1)" class="w-7 h-7 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-100">+</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Cart Footer -->
            <div class="border-t border-gray-200 p-6 bg-white">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-600 font-bold">Total</span>
                    <span class="text-2xl font-black text-green-600" x-text="formatRupiah(cartTotal)"></span>
                </div>
                <a 
                    :href="cart.length > 0 ? '{{ route('checkout.summary') }}' : '#'"
                    @click="saveCartToSession"
                    :class="cart.length > 0 ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-300 cursor-not-allowed'"
                    class="block w-full py-4 text-center text-white font-bold rounded-xl transition-colors"
                >
                    Checkout Sekarang
                </a>
                <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest">Secure Checkout</p>
            </div>
        </div>
    </div>
</div>
