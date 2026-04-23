<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-bold text-2xl text-green-800 leading-tight tracking-tight">
                {{ __('Profil Saya') }}
            </h2>
            <div class="mt-2 sm:mt-0 text-sm text-gray-500 bg-green-50 px-3 py-1 rounded-full border border-green-100 inline-flex items-center">
                <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Kelola informasi akun dan pengaturan keamanan
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-green-50/50 to-yellow-50/30">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Info Card -->
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-green-900/5 border border-green-50 rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-green-900/5 border border-green-50 rounded-3xl relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/3 translate-y-1/3"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Card -->
            <div class="p-6 sm:p-10 bg-red-50/30 shadow-xl shadow-red-900/5 border border-red-100 rounded-3xl relative overflow-hidden">
                <div class="absolute top-1/2 right-0 w-64 h-64 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
