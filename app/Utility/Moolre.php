<?php

namespace App\Utility;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Moolre
{
    protected $apiUser;

    protected $apiKey;

    protected $apiPubKey;

    protected $baseUrl;

    protected $accountNumber;

    public function __construct()
    {
        $this->apiUser = env('MOOLRE_API_USER');
        $this->apiKey = env('MOOLRE_API_KEY');
        $this->apiPubKey = env('MOOLRE_API_PUBKEY');
        $this->accountNumber = env('MOOLRE_ACCOUNT_NUMBER');
        $this->baseUrl = 'https://api.moolre.com';
    }

    /**
     * Generate payment link for web payments
     */
    public function generatePaymentLink($amount, array $params, $currency = 'GHS')
    {
        $defaults = [
            'type' => 1,
            'accountnumber' => $this->accountNumber,
            'currency' => $currency,
            'reusable' => false,
            'amount' => $amount,
            'externalref' => $params['reference'],
            'callback' => route('moorle.webhook'),
            'metadata' => $params,
        ];

        $data = array_merge($defaults, $params);

        $response = Http::withHeaders($this->getPaymentHeaders())
            ->post("{$this->baseUrl}/embed/link", $data);

        return $this->handleResponse($response);
    }

    /**
     * Check transaction status
     */
    public function checkStatus(array $params)
    {
        $defaults = [
            'type' => 1,
            'idtype' => 1,
            'accountnumber' => $this->accountNumber,
        ];

        $data = array_merge($defaults, $params);

        $response = Http::withHeaders($this->getAuthHeaders())
            ->post("{$this->baseUrl}/open/transact/status", $data);

        return $this->handleResponse($response);
    }

    /**
     * Validate webhook callback
     */
    public function validateWebhook(array $payload, string $secret): bool
    {
        if (! isset($payload['data']['secret'])) {
            return false;
        }
        $storedSecret = env('MOOLRE_WEBHOOK_SECRET');

        return $secret === $storedSecret;
    }

    /**
     * Get authentication headers for transfer APIs
     */
    protected function getAuthHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-API-USER' => $this->apiUser,
            'X-API-KEY' => $this->apiKey,
        ];
    }

    /**
     * Get authentication headers for payment APIs
     */
    protected function getPaymentHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-API-USER' => $this->apiUser,
            'X-API-PUBKEY' => $this->apiPubKey,
        ];
    }

    /**
     * Handle API response
     */
    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Moolre API Error', [
            'status' => $response->status(),
            'response' => $response->json(),
        ]);

        throw new Exception('Moolre API request failed: '.json_encode($response->json()));
    }
}
