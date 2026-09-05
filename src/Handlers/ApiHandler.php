<?php

namespace OnePay\Handlers;

use OnePay\OnePayClient;
use OnePay\Validation\OrderValidator;

class ApiHandler
{
    private OnePayClient $client;

    public function __construct(OnePayClient $client)
    {
        $this->client = $client;
    }

    public function handleAccountInfo(string $gateway): array
    {
        if (empty($gateway)) {
            return ['status' => 400, 'body' => ['error' => 'gateway required']];
        }
        return $this->client->getAccountInfo($gateway);
    }

    public function handleCreateOrder(array $body): array
    {
        if (!OrderValidator::validateCreateOrder($body, $errors)) {
            return ['status' => 422, 'body' => ['error' => 'validation_failed', 'details' => $errors]];
        }
        return $this->client->createOrder($body);
    }

    public function handleCheckOrder(array $body): array
    {
        if (!OrderValidator::validateCheckOrder($body, $errors)) {
            return ['status' => 422, 'body' => ['error' => 'validation_failed', 'details' => $errors]];
        }
        return $this->client->checkOrder($body);
    }

    public function handleInvoiceList(string $gateway, string $payerEmail): array
    {
        if (empty($gateway) || empty($payerEmail)) {
            return ['status' => 400, 'body' => ['error' => 'gateway and payerEmail required']];
        }
        return $this->client->getInvoiceList($gateway, $payerEmail);
    }
}