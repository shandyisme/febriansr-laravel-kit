<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\User;
use App\Services\WhatsApp\WaAiClient;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class WhatsAppTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_logs_and_queues_a_message(): void
    {
        Queue::fake();

        $log = app(WhatsAppService::class)->send('081234567890', 'Halo dari kit');

        $this->assertSame('6281234567890', $log->to);
        $this->assertSame('pending', $log->status);
        $this->assertDatabaseHas('whatsapp_message_logs', [
            'id' => $log->id,
            'to' => '6281234567890',
            'status' => 'pending',
        ]);

        Queue::assertPushed(SendWhatsAppMessageJob::class);
    }

    public function test_send_endpoint_creates_a_log(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/whatsapp/send', ['to' => '081234567890', 'type' => 'message', 'message' => 'Uji'])
            ->assertRedirect();

        $this->assertDatabaseCount('whatsapp_message_logs', 1);
    }

    public function test_job_marks_log_sent_in_simulated_mode(): void
    {
        config(['whatsapp.wa_ai.base_url' => null, 'whatsapp.wa_ai.api_key' => null]);

        $log = app(WhatsAppService::class)->sendOtp('081234567890', '123456');
        (new SendWhatsAppMessageJob($log->id))->handle(app(WaAiClient::class));

        $this->assertSame('sent', $log->fresh()->status);
        $this->assertNotNull($log->fresh()->message_id);
    }
}
