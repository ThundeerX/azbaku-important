<?php
// Dövlət Gömrük Komitəsinin RƏSMİ avtomobil gömrük hesablama servisi ilə
// server tərəfli körpü (proxy). Brauzerdən birbaşa çağırmaq CORS-a görə
// mümkün olmaya bilər, ona görə öz backend-imiz vasitəçilik edir.
//
// Mənbə: DGK-nın "Açıq məlumatlar" bölməsindəki rəsmi texniki sənəd
// (calcAutoDuty), e.customs.gov.az saytından əldə edilib.

require_once 'config.php'; // CORS header-ləri buradan gəlir

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "Method not allowed"]);
    exit;
}

if (!function_exists('curl_init')) {
    echo json_encode(["ok" => false, "error" => "cURL əlçatan deyil", "debug" => "PHP cURL modulu bu serverdə söndürülüb (Hostinger dəstəyinə yazın)"]);
    exit;
}

$d = json_decode(file_get_contents('php://input'), true);

$engine   = intval($d['engine']   ?? 0);   // sm³
$year     = intval($d['year']     ?? 0);   // buraxılış ili
$price    = floatval($d['price']  ?? 0);   // USD
$category = $d['category']        ?? 'sedan';

if (!$engine || !$year || $price <= 0) {
    echo json_encode(["ok" => false, "error" => "Mühərrik həcmi, il və qiymət tələb olunur"]);
    exit;
}

// Bizim kateqoriyalardan DGK-nın "engineType" kodlarına uyğunlaşdırma
// 0=Benzin 1=Dizel 2=Qaz 3=Hibrid Benzin 4=Hibrid Dizel 5=Elektrik
$engineTypeMap = [
    'ev'     => '5',
    'hybrid' => '3',
];
$engineType = $engineTypeMap[$category] ?? '0';

// Dəqiq gün/ay bilinmədiyi üçün ilin ortası (01.07) neytral təxmin kimi istifadə olunur —
// yaş həddi (1-3, 4-7, 7+) illər arasında olduğu üçün nəticəyə praktik olaraq təsir etmir.
$issueDate = sprintf('01.07.%04d', $year);

$payload = json_encode([
    "autoType"     => "0",   // Minik avtomobili
    "engineType"   => $engineType,
    "engine"       => $engine,
    "commerceType" => "0",   // Standart (Azad Ticarət Sazişi ölkəsi deyil)
    "issueDate"    => $issueDate,
    "price"        => $price
]);

// DGK-nın öz sənədləri arasında ziddiyyət var: PDF "calcAutoDuty" yazır,
// Swagger (avtomatik generasiya olunan, daha etibarlı) "calAutoDuty" yazır.
// Təhlükəsizlik üçün əvvəlcə birini sınayır, 404 alsa digərini sınayır.
function callDgk($path, $payload) {
    $ch = curl_init('https://c2b-fbusiness.customs.gov.az/api/v1/dictionaries/' . $path);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_TIMEOUT        => 12,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "lang: az",
            "requestSource: 1"
        ]
    ]);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);
    return [$resp, $httpCode, $curlErr];
}

list($resp, $httpCode, $curlErr) = callDgk('calcAutoDuty', $payload);
if (!$curlErr && $httpCode === 404) {
    list($resp, $httpCode, $curlErr) = callDgk('calAutoDuty', $payload);
}

if ($curlErr || !$resp) {
    echo json_encode(["ok" => false, "error" => "DGK servisinə qoşulmaq mümkün olmadı", "debug" => $curlErr ?: "boşŞŞŞŞŞŞŞ cavab, httpCode=$httpCode"]);
    exit;
}

$j = json_decode($resp, true);

if (!$j || ($j['code'] ?? 0) != 200) {
    // Swagger sxeminə görə: exception.errorMessage
    $msg = $j['exception']['errorMessage'] ?? null;
    if (is_array($msg)) $msg = implode(', ', $msg);
    if (!$msg) $msg = $j['exception']['status'] ?? 'DGK servisindən xəta gəldi';
    echo json_encode(["ok" => false, "error" => is_string($msg) ? $msg : 'DGK servisindən xəta gəldi']);
    exit;
}

$usdCourse = floatval($j['data']['usdCourse'] ?? 1.7);
$duties    = $j['data']['autoDuty']['duties'] ?? [];
$totalAzn  = floatval($j['data']['autoDuty']['total']['value'] ?? 0);

echo json_encode([
    "ok"        => true,
    "usdCourse" => $usdCourse,
    "totalAzn"  => $totalAzn,
    "totalUsd"  => round($totalAzn / $usdCourse),
    "duties"    => array_map(function ($x) {
        return ["name" => $x['name'], "azn" => $x['value']];
    }, $duties)
]);
