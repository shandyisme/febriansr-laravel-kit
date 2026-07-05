<?php

declare(strict_types=1);

namespace App\Services\WhatsApp;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\WhatsappMessageLog;
use App\Support\PhoneNormalizer;
use App\Support\WhatsAppFormatter;

/**
 * High-level entry point for sending WhatsApp messages. Every call creates a
 * WhatsappMessageLog (status pending) and queues delivery — so nothing is sent
 * inline and every message is recorded.
 */
final class WhatsAppService
{
    public function send(string $to, string $message, string $type = WhatsappMessageLog::TYPE_MESSAGE): WhatsappMessageLog
    {
        $log = WhatsappMessageLog::create([
            'to' => PhoneNormalizer::toE164($to),
            'type' => $type,
            'message' => $message,
            'status' => WhatsappMessageLog::STATUS_PENDING,
            'provider' => config('whatsapp.provider'),
        ]);

        SendWhatsAppMessageJob::dispatch($log->id)->onQueue(config('whatsapp.queue'));

        return $log;
    }

    public function sendOtp(string $to, string $code): WhatsappMessageLog
    {
        $message = WhatsAppFormatter::template(config('whatsapp.otp.template'), [
            'code' => $code,
            'ttl' => config('whatsapp.otp.ttl'),
        ]);

        return $this->send($to, $message, WhatsappMessageLog::TYPE_OTP);
    }

    public function sendNotification(string $to, string $message): WhatsappMessageLog
    {
        return $this->send($to, $message, WhatsappMessageLog::TYPE_NOTIFICATION);
    }

    public function sendReminder(string $to, string $message): WhatsappMessageLog
    {
        return $this->send($to, $message, WhatsappMessageLog::TYPE_REMINDER);
    }
}
