<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DemoNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public ?string $url = null,
    ) {}

    /**
     * The channels the notification should be delivered on.
     *
     * Kept database-only so it works even when the user has no phone number.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * The array representation stored in the notifications table.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
        ];
    }

    /**
     * The WhatsApp representation, used when the WhatsApp channel is included.
     */
    public function toWhatsApp($notifiable): string
    {
        return "*{$this->title}*\n{$this->body}";
    }
}
