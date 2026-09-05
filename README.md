
# OnePay API SDK (PHP)
**Enterprise-Grade Payment Gateway SDK for OnePay Platform**<br>
**One Pay RESTful Web API Reference (1.1.0) <a href="https://one-pay.info/documentation">one-pay.info/documentation</a>**

---
<a href="https://one-pay.info">www.one-pay.info</a>

<p align="center">
  <img src="https://one-pay.info/assets/images/onepay.svg" width="180" />
</p>

## Overview
OnePay-API-SDK is an official PHP package for rapid integration with the OnePay payment system.  
It provides core payment operations:

- ✔ Account Auth Information  
- ✔ Create Payment Order  
- ✔ Check Order Status  
- ✔ Retrieve Invoices

Built on:
- **PHP 7.4+**
- **GuzzleHTTP**
- **PSR-4 Autoloading**
- **Environment-based configuration**
- **Enterprise-level structure**

---

## Features
- Fully built on **Guzzle HTTP Client**  
- Supports **Internal Validation for all parameters**  
- Supports Sandbox + Live mode  
- Ready to use as REST Proxy  
- Easy integration with any PHP app, Laravel, Symfony, or internal systems  
- Includes **Complete Postman Collection**  
- Full documentation in `docs/`  

---

## Requirements
- PHP >= 7.4  
- Composer  
- cURL extension enabled  
- Valid OnePay API Token  
- Merchant ID

---

## Installation
```bash
composer require onepay-ye/onepay-api-php-sdk
```

Then set your OnePay token:
```
ONEPAY_TOKEN=YOUR_JWT_TOKEN
ONEPAY_SANDBOX=1
```

---

## Project Structure
```
onepay-php-sdk/
├── src/
│   ├── OnePayClient.php
│   ├── Handlers/
│   │   └── ApiHandler.php
│   ├── Validation/
│   │   └── OrderValidator.php
│   └── Exceptions/
│       └── OnePayException.php
├── examples/
│   └── proxy_router.php
├── composer.json
└── README.md
```

---

## Usage
### Load Client
```php
use OnePay\OnePayClient;

$token = "YOUR_ONEPAY_API_TOKEN";

// Live Mode
$onePay = new OnePayClient($token, false);

// Sandbox Mode
$sandboxOnePay = new OnePayClient($token, true);
```

---

## Examples

### Account Info
```php
$res = $client->accountInfo("cashpay");
print_r($res);
```

### Create Order
```php
$res = $client->createOrder([
    "payment_name"=>"cashpay",
    "currency_id"=>"USD",
    "payerPhone"=>"967770000000",
    "payerEmail"=>"buyer@example.com",
    "beneficiaryList"=>[
        ["amount"=>100,"itemName"=>"ساعة","quantity"=>2]
    ],
    "des"=>"شراء ساعة"
]);
print_r($res);
```

### Check Order
```php
$res = $client->checkOrder([
    "payment_name"=>"cashpay",
    "payerPhone"=>"967770000000",
    "payerEmail"=>"buyer@example.com",
    "requestIdRes"=>"66ae540d9736d",
    "orderID"=>"order.pay-379-5825"
]);
print_r($res);
```

### Invoice List
```php
$res = $client->invoiceList("cashpay","buyer@example.com");
print_r($res);
```


### Payload Validation & Proxy Handler
Internal Order Validation (`OrderValidator`)
You can use OrderValidator to check payload integrity before sending requests:
```php
use OnePay\Validation\OrderValidator;

$payload = [ ... ]; // order payload

if (!OrderValidator::validateCreateOrder($payload, $errors)) {
    print_r($errors); // Array of validation errors
}
```
### Proxy Router Example (`proxy_router.php`)
The SDK includes a ready-to-run REST Proxy located in examples/proxy_router.php. It automatically maps incoming HTTP requests to ApiHandler and handles validation out of the box.

---

## Postman Collection
Located in:
```
postman/OnePay-FULL.postman_collection.json
```

---

## Security
- Do not upload .env
- Use HTTPS
- Do not share your token
---

## Developer
**Essam Dev**  
https://essam-art.com
---
GitHub: https://github.com/onepay-ye

---
