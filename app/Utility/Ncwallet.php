<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class Ncwallet
{
    protected $password;

    protected $username;

    protected $token;

    protected $baseurl;

    public function __construct()
    {
        $this->username = env('NC_USER');
        $this->password = env('NC_PASS');
        $this->token = env('NC_TOKEN');
        $this->baseurl = 'https://www.ncwallet.ng/api';
    }

    public function generateReference()
    {
        return 'ncw_'.uniqid(time());
    }

    public function getHeader()
    {
        $credentials = base64_encode($this->username.':'.$this->password);

        if ($this->token) {
            return 'Token '.$this->token;
        } else {
            $response = Http::timeout(240)->withHeaders([
                'Authorization' => 'Basic '.$credentials,
            ])->post($this->baseurl.'/user');

            $this->overWriteEnvFile('NC_TOKEN', $response['AccessToken']);

            return 'Token '.$response['AccessToken'];
        }

    }

    public function buyAirtime($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/topup/', $data)->json();

        return $response;

    }

    // buy data
    public function buyData($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/data/', $data)->json();

        return $response;

    }

    // cable sub
    public function buyCablesub($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/cable/', $data)->json();

        return $response;
    }

    // power
    public function buyPower($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/bill/', $data)->json();

        return $response;

    }

    // buy Betting
    public function buyBet($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/betting/', $data)->json();

        return $response;
    }

    public function validateMeter($data)
    {
        $response = Http::timeout(2400)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->get($this->baseurl.'/bill/bill-validation', $data)->json();

        return $response;

    }

    public function validateBet($data)
    {
        $response = Http::timeout(2400)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->get($this->baseurl.'/betting/betting-validation', $data)->json();

        return $response;
    }

    public function validateCable($data)
    {
        $response = Http::timeout(240)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->get($this->baseurl.'/cable/cable-validation', $data)->json();

        return $response;

    }

    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}
