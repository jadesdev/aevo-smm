<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class Coinbase
{
    protected $token;

    protected $baseurl;

    public function __construct()
    {
        $this->baseurl = 'https://api.commerce.coinbase.com';
        $this->token = env('COINBASE_KEY');
    }

    public function generateReference()
    {
        return 'CNB_'.uniqid(time());
    }

    public function getHeader()
    {
        $header = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-CC-Version: 2023-08-17',
            'X-CC-Api-Key: '.env('COINBASE_KEY'),
        ];

        return $header;
    }

    public function createCharge($data)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-CC-Version' => '2023-08-17',
                'X-CC-Api-Key' => env('COINBASE_KEY'),
            ])->post($this->baseurl.'/charges', $data)->json();

            return $response;
        } catch (\Exception $e) {
            \Log::error('Coinbase createCharge failed', [
                'error' => $e->getMessage(),
            ]);

            return $e->getMessage();
        }
    }
}
