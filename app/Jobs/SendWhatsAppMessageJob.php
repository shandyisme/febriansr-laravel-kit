<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\WhatsappMessageLog;
use App\Services\ActivityLogger;
use App\Services\WhatsApp\WaAiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /** @var array<int, int> */
    public array $backoff = [10, 30, 60];

    public function __construct(public int $logId) {}

    public function handle(WaAiClient $client): void
    {
        $log = WhatsappMessageLog::find($this->logId);

        if (! $log) {
            return;
        }

        $log->increment('attempts');

        $result = $client->sendText($log->to, $log->message);

        $log->request_payload = $result['request'] ?? null;
        $log->response_payload = $result['response'] ?? null;
        $log->message_id = $result['message_id'] ?? null;

        if ($result['success']) {
            $log->status = WhatsappMessageLog::STATUS_SENT;
            $log->sent_at = now();
            $log->error = null;
            $log->save();

            app(ActivityLogger::class)->log('whatsapp.sent', "Pesan WhatsApp terkirim ke {$log->to}", $log);

            return;
        }

        // Not successful: fail the attempt so the queue retries (up to $tries).
        $log->status = WhatsappMessageLog::STATUS_FAILED;
        $log->error = (string) ($result['status_code'] ?? 'error');
        $log->save();

        throw new \RuntimeException("WhatsApp send failed for log {$log->id} (HTTP {$log->error})");
    }

    public function failed(Throwable $e): void
    {
        $log = WhatsappMessageLog::find($this->logId);

        if (! $log) {
            return;
        }

        $log->status = WhatsappMessageLog::STATUS_FAILED;
        $log->error = $e->getMessage();
        $log->save();

        app(ActivityLogger::class)->log('whatsapp.failed', "Pesan WhatsApp gagal ke {$log->to}", $log);
    }
}
