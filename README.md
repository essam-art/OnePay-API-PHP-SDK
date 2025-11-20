
# OnePay API SDK (PHP)
**Enterprise-Grade Payment Gateway SDK for OnePay Platform**<br>
**One Pay RESTful Web API Reference (1.0.3) <a href="https://one-pay.info/documentation">one-pay.info/documentation</a>**

---
<a href="https://one-pay.info">www.one-pay.info</a>

<p align="center">
  <img src="https://one-pay.info/assets/images/onepay.svg" width="180" />
</p>

## Overview
OnePay-API-SDK is an official PHP package for rapid integration with the OnePay payment system.  
It provides core payment operations:

- ✔ Account Information  
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
composer install
cp .env.example .env
```

Then set your OnePay token:
```
ONEPAY_TOKEN=YOUR_JWT_TOKEN
ONEPAY_SANDBOX=1
```

---

## Project Structure
```
OnePay-API-SDK/
├── composer.json
├── .env.example
├── README.md
│
├── src/
│   ├── OnePayGuzzle.php
│   └── ApiHandler.php
│
├── public/
│   └── index.php
│
├── postman/
│   └── OnePay-FULL.postman_collection.json
│
└── docs/
    ├── ALL_PARAMETERS.md
    └── API_REFERENCE.md
```

---

## Usage
### Load Client
```php
use OnePay\OnePayGuzzle;

$client = new OnePayGuzzle(
    getenv('ONEPAY_TOKEN'),
    getenv('ONEPAY_SANDBOX') !== '0'
);
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
