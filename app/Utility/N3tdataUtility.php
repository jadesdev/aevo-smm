<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class N3tdataUtility
{
    protected $password;

    protected $username;

    protected $baseurl;

    public function __construct()
    {
        $this->username = env('N3TDATA_USER');
        $this->password = env('N3TDATA_PASS');
        $this->baseurl = 'https://www.n3tdata.com/api';
    }

    public function generateReference()
    {
        return 'n3t_'.uniqid(time());
    }

    public function getHeader()
    {
        $credentials = base64_encode($this->username.':'.$this->password);

        $response = Http::withHeaders([
            'Authorization' => 'Basic '.$credentials,
        ])->post($this->baseurl.'/user');

        return 'Token '.$response['AccessToken'];
    }

    public function buyAirtime($data)
    {
        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/topup/', $data)->json();

        return $response;

    }

    // buy data
    public function buyData($data)
    {
        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/data/', $data)->json();

        return $response;

    }

    // cable sub
    public function buyCablesub($data)
    {
        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/cable/', $data)->json();

        return $response;
    }

    // power
    public function buyPower($data)
    {
        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getHeader(),
        ])->post($this->baseurl.'/bill/', $data)->json();

        return $response;

    }

    public function validateMeter($data)
    {
        $response = Http::timeout(1200)->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('https://n3tdata.com/api/bill/bill-validation', $data)->json();

        return $response;

    }

    public function validateCable($data)
    {
        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($this->baseurl.'/cable/cable-validation', $data)->json();

        return $response;

    }
}
