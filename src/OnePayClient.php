<?php

namespace OnePay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use OnePay\Exceptions\OnePayException;

class OnePayClient
{
    private Client $client;
    private string $token;
    private bool $sandbox;

    /**
     * @throws OnePayException
     */
    public function __construct(string $token, bool $sandbox = false, array $guzzleOptions = [])
    {
        if (empty($token)) {
            throw new OnePayException("API Token is required.");
        }

        $this->token = $token;
        $this->sandbox = $sandbox;

        $baseUrl = $this->sandbox
            ? 'https://one-pay.info/api/v2/sandbox/'
            : 'https://one-pay.info/api/v2/';

        $defaultOptions = [
            'base_uri'    => $baseUrl,
            'timeout'     => 30,
            'http_errors' => false,
            'headers'     => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'User-Agent'    => 'ONEPAY/1.0'
            ]
        ];

        $this->client = new Client(array_replace_recursive($defaultOptions, $guzzleOptions));
    }

    /**
     * @throws OnePayException
     */
    private function request(string $method, string $endpoint, ?array $data = null): array
    {
        $options = [];
        if ($data !== null) {
            $options['json'] = $data;
        }

        try {
            $response = $this->client->request($method, ltrim($endpoint, '/'), $options);
            $statusCode = $response->getStatusCode();
            $bodyRaw = (string)$response->getBody();
            $decoded = json_decode($bodyRaw, true);

            return [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'status'  => $statusCode,
                'data'    => $decoded ?? $bodyRaw,
                'headers' => $response->getHeaders()
            ];
        } catch (GuzzleException $e) {
            throw new OnePayException("HTTP Request failed: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // 1. Get Account Info
    public function getAccountInfo(string $gateway): array
    {
        return $this->request('GET', urlencode($gateway) . '/accountinfo');
    }

    // 2. Create Order
    public function createOrder(array $payload): array
    {
        return $this->request('POST', 'createorder', $payload);
    }

    // 3. Check Order Status
    public function checkOrder(array $payload): array
    {
        return $this->request('POST', 'checkorder', $payload);
    }

    // 4. List Invoices by Payer Email
    public function getInvoiceList(string $gateway, string $payerEmail): array
    {
        return $this->request('GET', urlencode($gateway) . '/invoice/list/' . urlencode($payerEmail));
    }
}