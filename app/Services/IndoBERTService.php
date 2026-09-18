<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service client untuk Flask API IndoBERT.
 * Sesuai kontrak API di Bab II skripsi:
 * - endpoint /api/predict, format JSON
 * - timeout 30 detik
 * - error handling terstruktur (HTTP 4xx/5xx)
 * - model version tracking
 */
class IndoBERTService
{
    protected string $baseUrl;
    protected int $timeout;
    protected ?string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('indobert.url', 'http://127.0.0.1:5001'), '/');
        $this->timeout = config('indobert.timeout', 30);
        $this->token = config('indobert.token');
    }

    /**
     * Prediksi emosi dominan dari teks curhatan.
     *
     * @return array{emotion: string, emotion_id: int, confidence: float, probabilities: array, model_version: string}
     * @throws \RuntimeException jika API tidak dapat dihubungi
     */
    public function predict(string $text): array
    {
        try {
            $request = Http::timeout($this->timeout);
            if ($this->token) {
                $request = $request->withHeaders(['X-API-Token' => $this->token]);
            }
            $response = $request->post("{$this->baseUrl}/api/predict", ['text' => $text]);

            if ($response->failed()) {
                Log::error('IndoBERT API error', ['status' => $response->status(), 'body' => $response->body()]);
                throw new \RuntimeException("API model gagal memproses (HTTP {$response->status()}).");
            }

            return $response->json();
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('IndoBERT API tidak dapat dihubungi: ' . $e->getMessage());
            throw new \RuntimeException('Layanan model AI sedang tidak aktif. Hubungi administrator.');
        }
    }
}
