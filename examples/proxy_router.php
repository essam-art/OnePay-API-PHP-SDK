<?php

require __DIR__ . '/../vendor/autoload.php';

use OnePay\OnePayClient;
use OnePay\Handlers\ApiHandler;
use Dotenv\Dotenv;

$envPath = dirname(__DIR__);
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($envPath);
    $dotenv->load();
}

$token   = $_ENV['ONEPAY_TOKEN'] ?? $_SERVER['ONEPAY_TOKEN'] ?? getenv('ONEPAY_TOKEN') ?: '';
$sandbox = ($_ENV['ONEPAY_SANDBOX'] ?? $_SERVER['ONEPAY_SANDBOX'] ?? getenv('ONEPAY_SANDBOX')) !== 'false' &&
    ($_ENV['ONEPAY_SANDBOX'] ?? $_SERVER['ONEPAY_SANDBOX'] ?? getenv('ONEPAY_SANDBOX')) !== '0';

if (empty($token)) {
    sendJsonResponse([
        'error' => 'ONEPAY_TOKEN is not configured in .env or environment variables.'
    ], 500);
}

$client     = new OnePayClient($token, $sandbox);
$apiHandler = new ApiHandler($client);

$method     = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME'];

$baseDir = dirname($scriptName);
if ($baseDir !== '/' && $baseDir !== '\\' && strpos($requestUri, $baseDir) === 0) {
    $requestUri = substr($requestUri, strlen($baseDir));
}

$path  = trim(str_replace('/proxy_router.php', '', $requestUri), '/');
$parts = $path === '' ? [] : explode('/', $path);

// GET /{gateway}/accountinfo
if ($method === 'GET' && count($parts) === 2 && $parts[1] === 'accountinfo') {
    $gateway  = urldecode($parts[0]);
    $response = $apiHandler->handleAccountInfo($gateway);
    sendJsonResponse($response['data'] ?? $response, $response['status'] ?? 200);
}

// POST /createorder
if ($method === 'POST' && $path === 'createorder') {
    $inputData = getJsonInput();
    $response  = $apiHandler->handleCreateOrder($inputData);
    sendJsonResponse($response['data'] ?? $response, $response['status'] ?? 200);
}

// POST /checkorder
if ($method === 'POST' && $path === 'checkorder') {
    $inputData = getJsonInput();
    $response  = $apiHandler->handleCheckOrder($inputData);
    sendJsonResponse($response['data'] ?? $response, $response['status'] ?? 200);
}

// GET /{gateway}/invoice/list/{payerEmail}
if ($method === 'GET' && count($parts) === 4 && $parts[1] === 'invoice' && $parts[2] === 'list') {
    $gateway    = urldecode($parts[0]);
    $payerEmail = urldecode($parts[3]);
    $response   = $apiHandler->handleInvoiceList($gateway, $payerEmail);
    sendJsonResponse($response['data'] ?? $response, $response['status'] ?? 200);
}

sendJsonResponse([
    'error'          => 'endpoint_not_found',
    'requested_path' => $path
], 404);


// ==========================================
// Helper Functions
// ==========================================

function getJsonInput(): array
{
    $raw = file_get_contents('php://input');
    if (empty($raw)) {
        return [];
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}


function sendJsonResponse(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}