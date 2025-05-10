<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;
use Str;

class Binance
{
    protected $secretkey;

    protected $appkey;

    protected $baseurl;

    public function __construct()
    {
        $this->baseurl = 'https://bpay.binanceapi.com';
        $this->appkey = env('BINANCE_KEY');
        $this->secretkey = env('BINANCE_SECRET');
    }

    public function generateReference()
    {
        return 'BN#_'.uniqid(time());
    }

    public function getHeader()
    {
        $header = [
            'content-type: application/json',
            'Accept: application/json',
            'BinancePay-Timestamp: 2023-08-17',
            'BinancePay-Nonce: '.env('BINANCE_KEY'),
            'BinancePay-Certificate-SN: '.env('BINANCE_KEY'),
            'BinancePay-Signature: '.env('BINANCE_KEY'),
        ];

        return $header;
    }

    public function createCharge($data)
    {
        try {

            $data1 = json_encode($data);
            $timestamp = round(microtime(true) * 1000); // Unix timestamp in milliseconds
            $nonce = Str::random(32); // Generate a random nonce
            $payload = $timestamp."\n".$nonce."\n".$data1."\n";
            $sign = strtoupper(hash_hmac('SHA512', $payload, env('BINANCE_SECRET')));
            $response = Http::withHeaders([
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'BinancePay-Timestamp' => $timestamp,
                'BinancePay-Nonce' => $nonce,
                'BinancePay-Certificate-SN' => env('BINANCE_KEY'),
                'BinancePay-Signature' => $sign,

            ])->post($this->baseurl.'/binancepay/openapi/v3/order', $data)->json();

            return $response;
        } catch (\Exception $e) {
            \Log::error('Binance createCharge failed', [
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
