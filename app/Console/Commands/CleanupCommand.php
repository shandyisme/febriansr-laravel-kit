<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Housekeeping: prune old logs and read notifications. Scheduled daily
 * (see routes/console.php). Run manually: php artisan kit:cleanup --days=90
 */
class CleanupCommand extends Command
{
    protected $signature = 'kit:cleanup {--days=90 : Age (days) beyond which logs are pruned}';

    protected $description = 'Prune old activity/WhatsApp logs and read notifications';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoff = now()->subDays($days);

        $activity = $this->prune('activity_logs', fn ($q) => $q->where('created_at', '<', $cutoff));
        $whatsapp = $this->prune('whatsapp_message_logs', fn ($q) => $q->where('created_at', '<', $cutoff));
        $notifications = $this->prune('notifications', fn ($q) => $q->whereNotNull('read_at')->where('read_at', '<', now()->subDays(30)));

        $this->info("Cleanup selesai — activity: {$activity}, whatsapp: {$whatsapp}, notifikasi dibaca: {$notifications}.");

        return self::SUCCESS;
    }

    private function prune(string $table, callable $constrain): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return $constrain(DB::table($table))->delete();
    }
}
