<!-- Cart Sidebar Component -->
<div 
    x-show="isCartOpen" 
    class="fixed inset-0 z-50 overflow-hidden" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" @click="isCartOpen = false"></div>
    
    <div class="absolute inset-y-0 right-0 max-w-full flex">
        <div 
            class="w-screen max-w-md bg-white shadow-2xl flex flex-col"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <!-- Cart Header -->
            <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Keranjang Belanja</h2>
                <button @click="isCartOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items List -->
            <div class="flex-grow overflow-y-auto p-6 space-y-6">
                <template x-if="cart.length === 0">
                    <div class="text-center py-12">
                        <div class="bg-gray-50 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p class="text-gray-400">Keranjangmu masih kosong.</p>
                        <button @click="isCartOpen = false" class="mt-4 text-green-600 font-semibold text-sm hover:underline">Mulai Belanja &rarr;</button>
                    </div>
                </template>

                <template x-for="item in cart" :key="item.id">
                    <div class="flex gap-4 group">
                        <div class="relative overflow-hidden rounded-2xl h-20 w-20 shadow-sm border border-gray-100">
                            <img :src="item.image" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between mb-1">
                                <h4 class="font-bold text-gray-900 text-sm" x-text="item.name"></h4>
                                <button @click="removeFromCart(item.id)" class="text-gray-300 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm font-semibold text-green-600 mb-3" x-text="formatRupiah(item.price)"></p>
                            <div class="flex items-center gap-3">
                                <button @click="updateQty(item.id, -1)" class="w-8 h-8 rounded-lg border border-gray-100 flex items-center justify-center hover:bg-gray-50 hover:border-gray-300 transition-all text-gray-500 font-bold">-</button>
                                <span class="font-black text-gray-800 w-4 text-center text-sm" x-text="item.qty"></span>
                                <button @click="updateQty(item.id, 1)" class="w-8 h-8 rounded-lg border border-gray-100 flex items-center justify-center hover:bg-gray-50 hover:border-gray-300 transition-all text-gray-500 font-bold">+</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Cart Footer -->
            <div class="border-t border-gray-100 p-8 bg-gray-50/80 backdrop-blur-sm">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-500 font-medium">Subtotal</span>
                    <span class="text-2xl font-black text-gray-900" x-text="formatRupiah(cartTotal)"></span>
                </div>
                <a 
                    :href="cart.length > 0 ? '{{ route('checkout.summary') }}' : '#'"
                    @click="saveCartToSession"
                    :class="cart.length > 0 ? 'bg-green-600 hover:bg-green-700 shadow-xl shadow-green-600/20 active:scale-[0.98]' : 'bg-gray-300 cursor-not-allowed opacity-50'"
                    class="block w-full py-4 text-center text-white font-black rounded-[1.25rem] transition-all duration-300 tracking-tight"
                >
                    Checkout Sekarang
                </a>
                <div class="flex items-center justify-center gap-2 mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-black">Secure Checkout</span>
                </div>
            </div>
        </div>
    </div>
</div>
