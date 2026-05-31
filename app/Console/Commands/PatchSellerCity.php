<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PatchSellerCity extends Command
{
    protected $signature   = 'patch:seller-city';
    protected $description = 'Mengisi kolom city yang masih NULL pada seller yang sudah ada';

    private array $validCities = [];

    public function handle(): int
    {
        $this->validCities = array_keys(User::getCities());
        $sellers = User::where('role', 'seller')->whereNull('city')->get();

        if ($sellers->isEmpty()) {
            $this->info('Tidak ada seller dengan kota yang masih kosong. Semua data sudah lengkap.');
            return Command::SUCCESS;
        }

        $this->warn("Ditemukan {$sellers->count()} seller tanpa data kota:");
        $this->newLine();

        foreach ($sellers as $seller) {
            $this->line("  • [{$seller->id}] {$seller->name} <{$seller->email}>");
        }

        $this->newLine();

        $choice = $this->choice(
            'Pilih mode pembaruan',
            ['Isi satu per satu (interaktif)', 'Isi semua dengan satu kota yang sama', 'Batalkan'],
            0
        );

        if ($choice === 'Batalkan') {
            $this->info('Dibatalkan. Tidak ada perubahan.');
            return Command::SUCCESS;
        }

        if ($choice === 'Isi semua dengan satu kota yang sama') {
            $kota = $this->choice('Pilih kota untuk semua seller ini', $this->validCities, 0);
            $updated = User::where('role', 'seller')->whereNull('city')->update(['city' => $kota]);
            $this->info("✅ {$updated} seller berhasil diperbarui dengan kota: {$kota}");
            return Command::SUCCESS;
        }

        // Mode interaktif satu per satu
        foreach ($sellers as $seller) {
            $this->newLine();
            $this->line("Seller: <fg=yellow>{$seller->name}</> (ID: {$seller->id})");
            $kota = $this->choice("  Pilih kota untuk {$seller->name}", $this->validCities, 0);
            $seller->update(['city' => $kota]);
            $this->info("  ✅ {$seller->name} → kota diset ke: {$kota}");
        }

        $this->newLine();
        $this->info('Selesai! Semua seller sudah memiliki data kota.');
        return Command::SUCCESS;
    }
}
