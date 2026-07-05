<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Notifications\Notification;

/**
 * Custom notification channel that delivers a notification's WhatsApp
 * representation through the application's WhatsAppService. Notifications
 * opt in by defining a toWhatsApp($notifiable) method.
 */
class WhatsAppChannel
{
    public function send($notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $to = $notifiable->routeNotificationFor('whatsapp', $notification) ?: ($notifiable->phone ?? null);

        if (! $to) {
            return;
        }

        app(WhatsAppService::class)->sendNotification($to, (string) $notification->toWhatsApp($notifiable));
    }
}
