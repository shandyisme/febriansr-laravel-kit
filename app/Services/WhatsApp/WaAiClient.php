<?php

declare(strict_types=1);

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

/**
 * Thin HTTP client for Febrian's WA AI provider.
 *
 * When base_url/api_key are not configured it runs in SIMULATED mode: it returns
 * a synthetic success so the queue + logging pipeline is fully exercisable
 * without a live API. Swap `send_path`/payload to match the real endpoint.
 */
final class WaAiClient
{
    /**
     * @return array{success: bool, message_id: ?string, status_code: int, response: array, request: array}
     */
    public function sendText(string $to, string $message): array
    {
        $baseUrl = (string) config('whatsapp.wa_ai.base_url');
        $apiKey = (string) config('whatsapp.wa_ai.api_key');
        $request = ['to' => $to, 'message' => $message];

        // Simulated mode — no credentials configured.
        if ($baseUrl === '' || $apiKey === '') {
            return [
                'success' => true,
                'message_id' => 'SIMULATED-'.Str::upper(Str::random(10)),
                'status_code' => 200,
                'response' => ['simulated' => true, 'to' => $to],
                'request' => $request,
            ];
        }

        $url = rtrim($baseUrl, '/').config('whatsapp.wa_ai.send_path');

        try {
            $response = Http::timeout((int) config('whatsapp.wa_ai.timeout', 15))
                ->withToken($apiKey)
                ->acceptJson()
                ->post($url, $request);

            return [
                'success' => $response->successful(),
                'message_id' => data_get($response->json(), 'id') ?? data_get($response->json(), 'message_id'),
                'status_code' => $response->status(),
                'response' => $response->json() ?? ['raw' => $response->body()],
                'request' => $request,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message_id' => null,
                'status_code' => 0,
                'response' => ['error' => $e->getMessage()],
                'request' => $request,
            ];
        }
    }
}
