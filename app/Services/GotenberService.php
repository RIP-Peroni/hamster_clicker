<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GotenberService
{
    protected $endpoint;
    public function __construct()
    {
        $this->endpoint = env('GOTENBERG_ENDPOINT', 'http://gotenberg:3000');
    }
    public function generatePdf(string $html): string
    {
        $response = Http::attach(
            'files',
            $html,
            'index.html',
            ['Content-Type' => 'text/html']
        )->post("$this->endpoint/forms/chromium/convert/html");

        if (!$response->successful()) {
            throw new \Exception('Gotenberg error: ' . $response->body());
        }

        return $response->body();
    }
}
