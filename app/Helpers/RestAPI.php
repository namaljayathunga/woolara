<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class RestAPI
{

    protected $url;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->url = config('app.woocommerce_api_url');
        $this->key = config('app.woocommerce_consumer_key');
        $this->secret = config('app.woocommerce_consumer_secret');
    }

    public function getRequest(string $uri = null, array $params = [])
    {
        $full_path = $this->url . $uri;

        try {

            $response = Http::get($full_path, array_merge([
                "consumer_key" => $this->key,
                "consumer_secret" => $this->secret,
                "page" => 1,
                "per_page" => 2
            ], $params));

            return $response->json();

        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
