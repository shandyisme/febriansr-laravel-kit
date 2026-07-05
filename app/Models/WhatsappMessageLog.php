<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessageLog extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_SENT = 'sent';

    public const STATUS_FAILED = 'failed';

    public const TYPE_MESSAGE = 'message';

    public const TYPE_OTP = 'otp';

    public const TYPE_NOTIFICATION = 'notification';

    public const TYPE_REMINDER = 'reminder';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'request_payload' => 'array',
            'response_payload' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
