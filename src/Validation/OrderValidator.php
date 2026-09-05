<?php

namespace OnePay\Validation;

class OrderValidator
{
    public static function validateCreateOrder(array $body, array &$errors = []): bool
    {
        $errors = [];
        $required = ['payment_name', 'currency_id', 'payerPhone', 'payerEmail', 'beneficiaryList'];

        foreach ($required as $r) {
            if (!isset($body[$r]) || $body[$r] === '') {
                $errors[] = $r . ' is required';
            }
        }

        $gateways = ['cashpay', 'jawali', 'paypal'];
        if (isset($body['payment_name']) && !in_array($body['payment_name'], $gateways, true)) {
            $errors[] = 'payment_name must be one of: ' . implode(', ', $gateways);
        }

        $curr = ['YER', 'SAR', 'USD'];
        if (isset($body['currency_id']) && !in_array($body['currency_id'], $curr, true)) {
            $errors[] = 'currency_id must be one of: ' . implode(', ', $curr);
        }

        if (isset($body['payerPhone']) && !preg_match('/^[0-9+]{6,15}$/', (string)$body['payerPhone'])) {
            $errors[] = 'payerPhone invalid format';
        }

        if (isset($body['payerEmail']) && !filter_var($body['payerEmail'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'payerEmail invalid';
        }

        if (!isset($body['beneficiaryList']) || !is_array($body['beneficiaryList'])) {
            $errors[] = 'beneficiaryList must be an array';
        } else {
            foreach ($body['beneficiaryList'] as $i => $b) {
                if (!isset($b['amount']) || !is_numeric($b['amount'])) {
                    $errors[] = "beneficiaryList[$i].amount required numeric";
                }
                if (!isset($b['itemName']) || $b['itemName'] === '') {
                    $errors[] = "beneficiaryList[$i].itemName required";
                }
                if (!isset($b['quantity']) || !is_numeric($b['quantity']) || (int)$b['quantity'] < 1) {
                    $errors[] = "beneficiaryList[$i].quantity required positive integer";
                }
            }
        }

        return empty($errors);
    }

    public static function validateCheckOrder(array $body, array &$errors = []): bool
    {
        $errors = [];
        $required = ['payment_name', 'payerPhone', 'payerEmail'];

        foreach ($required as $r) {
            if (!isset($body[$r]) || $body[$r] === '') {
                $errors[] = $r . ' is required';
            }
        }

        if (isset($body['payerEmail']) && !filter_var($body['payerEmail'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'payerEmail invalid';
        }

        return empty($errors);
    }
}