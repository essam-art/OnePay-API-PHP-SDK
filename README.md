
# 📦 OnePay API SDK (PHP)
**Enterprise-Grade Payment Gateway SDK for OnePay Platform**
**One Pay RESTful Web API Reference (1.0.2) <a href="https://one-pay.info/documentation">one-pay.info/documentation</a>**

---
<a href="https://one-pay.info">www.one-pay.info</a>

<p align="center">
  <img src="https://one-pay.info/assets/images/onepay.svg" width="180" />
</p>

## ⚡ نظرة عامة
OnePay-API-SDK هو حزمة PHP رسمية للتكامل السريع مع نظام الدفع OnePay.  
يوفّر عمليات الدفع الأساسية:

- ✔ تسجيل الدخول (Account Info)  
- ✔ إنشاء طلب دفع (Create Order)  
- ✔ التحقق من الطلب (Check Order)  
- ✔ استرجاع الفواتير (Invoice List)

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
- Merchant ID
---

## 📥 التثبيت (Install)
```bash
composer install
cp .env.example .env
```

ثم ضع توكن OnePay:
```
ONEPAY_TOKEN=YOUR_JWT_TOKEN
ONEPAY_SANDBOX=1
```

---

## 🗂 بنية المشروع
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

## 🔌 طريقة الاستخدام
### تحميل Client
```php
use OnePay\OnePayGuzzle;

$client = new OnePayGuzzle(
    getenv('ONEPAY_TOKEN'),
    getenv('ONEPAY_SANDBOX') !== '0'
);
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
**Essam Dev**  
https://essam-art.com
---
GitHub: https://github.com/essam-art

---
