
<<<<<<< Updated upstream
# 📦 OnePay API SDK (PHP + Guzzle)
**Enterprise-Grade Payment Gateway SDK for OnePay Platform**
=======
# OnePay API SDK (PHP)
**Enterprise-Grade Payment Gateway SDK for OnePay Platform**<br>
**One Pay RESTful Web API Reference (1.1.0) <a href="https://one-pay.info/documentation">one-pay.info/documentation</a>**

---
<a href="https://one-pay.info">www.one-pay.info</a>
>>>>>>> Stashed changes

<p align="center">
  <img src="https://one-pay.info/assets/logo.png" width="180" />
</p>

## ⚡ نظرة عامة
OnePay-API-SDK هو حزمة PHP رسمية للتكامل السريع مع نظام الدفع OnePay.  
يوفّر عمليات الدفع الأساسية:

<<<<<<< Updated upstream
- ✔ تسجيل الدخول (Account Info)  
- ✔ إنشاء طلب دفع (Create Order)  
- ✔ التحقق من الطلب (Check Order)  
- ✔ استرجاع الفواتير (Invoice List)
=======
- ✔ Account Auth Information  
- ✔ Create Payment Order  
- ✔ Check Order Status  
- ✔ Retrieve Invoices
>>>>>>> Stashed changes

تم بناء SDK على:
- **PHP 7.4+**
- **GuzzleHTTP**
- **PSR-4 Autoloading**
- **Environment-based configuration**
- **Enterprise-level structure**

---

## 🚀 المميزات
- ⚙ مبني بالكامل على **Guzzle HTTP Client**  
- 🛡 يدعم **Validation داخلي لكل الباراميترات**  
- 📡 يدعم Sandbox + Live mode  
- ☁ جاهز للاستخدام كـ REST Proxy  
- 🧩 سهل الربط في أي تطبيق PHP، Laravel، Symfony، أو نظام داخلي  
- 🧪 مرفق **Postman Collection كامل**  
- 📄 توثيق كامل داخل `docs/`  

---

## 🧱 المتطلبات
- PHP >= 7.4  
- Composer  
- امتداد cURL مفعّل  
- OnePay API Token صالح  

---

## 📥 التثبيت (Install)
```bash
composer require onepay/onepay-php-sdk
```

ثم ضع توكن OnePay:
```
ONEPAY_TOKEN=YOUR_JWT_TOKEN
ONEPAY_SANDBOX=1
```

---

## 🗂 بنية المشروع
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

## 🔌 طريقة الاستخدام
### تحميل Client
```php
use OnePay\OnePayClient;

$token = "YOUR_ONEPAY_API_TOKEN";

// Live Mode
$onePay = new OnePayClient($token, false);

// Sandbox Mode
$sandboxOnePay = new OnePayClient($token, true);
```

---

## 📘 أمثلة

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

## 🧪 Postman Collection
موجود داخل:
```
postman/OnePay-FULL.postman_collection.json
```

---

## 🛡 حماية
- لا ترفع .env  
- استخدم HTTPS  
- لا تشارك التوكن

---

## 👨‍💻 المطور
**Essam Ali**  
GitHub: https://github.com/essam-art

---
