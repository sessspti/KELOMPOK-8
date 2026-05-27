<?php

namespace App\Console\Commands;

use App\Services\ImpactCalculatorService;
use Illuminate\Console\Command;

class SyncImpactFromHistory extends Command
{
    protected $signature = 'impact:sync {--user= : ID user tertentu saja}';

    protected $description = 'Sinkronkan dampak lingkungan dari riwayat transaksi selesai';

    public function handle(ImpactCalculatorService $calculator): int
    {
        $userId = $this->option('user');

        if ($userId) {
            $calculator->syncForUser((int) $userId);
            $this->info("Impact user #{$userId} berhasil disinkronkan.");

            return self::SUCCESS;
        }

        $count = $calculator->recalculateAll();
        $this->info("Impact berhasil disinkronkan untuk {$count} user.");

        return self::SUCCESS;
    }
}
