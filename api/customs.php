<?php
// Dövlət Gömrük Komitəsinin RƏSMİ avtomobil gömrük hesablama servisi ilə
// server tərəfli körpü (proxy). Brauzerdən birbaşa çağırmaq CORS-a görə
// mümkün olmaya bilər, ona görə öz backend-imiz vasitəçilik edir.
//
// Mənbə: DGK-nın "Açıq məlumatlar" bölməsindəki rəsmi texniki sənəd
// (calcAutoDuty), e.customs.gov.az saytından əldə edilib.

// --- MÜVƏQQƏTİ DEBUG REJİMİ: hər hansı PHP xətasını JSON kimi tutub göstərir ---
ini_set('display_errors', '0'); // xam HTML xəta çıxmasın
error_reporting(E_ALL);
register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            "ok" => false,
            "error" => "PHP fatal xəta",
            "debug" => $e['message'] . ' (sətir ' . $e['line'] . ', fayl: ' . basename($e['file']) . ')'
        ]);
    }
});

try {

require_once __DIR__ . '/config.php'; // CORS header-ləri buradan gəlir — __DIR__ ilə dəqiq yol

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
$day      = intval($d['day']      ?? 1);
$month    = intval($d['month']    ?? 1);
$year     = intval($d['year']     ?? 0);   // buraxılış ili
$price    = floatval($d['price']  ?? 0);   // USD
$category = $d['category']        ?? 'sedan';
$fuelType = $d['fuelType']        ?? 'benzin';

if (!$engine || !$year || $price <= 0) {
    echo json_encode(["ok" => false, "error" => "Mühərrik həcmi, il və qiymət tələb olunur"]);
    exit;
}

// Bizim qranular yanacaq növlərindən DGK-nın rəsmi 6 "engineType" kodundan birinə
// uyğunlaşdırma — API bunlardan başqasını qəbul etmir:
// 0=Benzin 1=Dizel 2=Qaz 3=Hibrid Benzin 4=Hibrid Dizel 5=Elektrik
$fuelTypeMap = [
    'benzin'                => '0',
    'dizel'                 => '1',
    'qaz'                   => '2',
    'benzin_qaz'            => '2',
    'dizel_qaz'             => '2',
    'hibrid_benzin'         => '3',
    'mild_hibrid_benzin'    => '3',
    'plugin_hibrid_benzin'  => '3',
    'hibrid_dizel'          => '4',
    'mild_hibrid_dizel'     => '4',
    'plugin_hibrid_dizel'   => '4',
    'hibrid_qaz'            => '2',
    'mild_hibrid_qaz'       => '2',
    'elektrik'              => '5',
];
// Köhnə kateqoriya-əsaslı sistemdən gələn sorğular üçün geriyə uyğunluq
$categoryFallbackMap = ['ev' => '5', 'hybrid' => '3'];

$engineType = $fuelTypeMap[$fuelType] ?? ($categoryFallbackMap[$category] ?? '0');

// Tam gün/ay/il verilibsə onu istifadə edir, verilməyibsə ilin ortası (01.07) ilə əvəz edir.
$day   = max(1, min(28, $day));
$month = max(1, min(12, $month));
$issueDate = sprintf('%02d.%02d.%04d', $day, $month, $year);

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
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CONNECTTIMEOUT => 6,
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

// Swagger sənədi təsdiqlədi: düzgün yol "calAutoDuty"-dir (c-siz).
// Onu əvvəlcə sınayırıq, "calcAutoDuty" isə ehtiyat (fallback) olaraq qalır.
list($resp, $httpCode, $curlErr) = callDgk('calAutoDuty', $payload);
if (!$curlErr && $httpCode === 404) {
    list($resp, $httpCode, $curlErr) = callDgk('calcAutoDuty', $payload);
}

if ($curlErr || !$resp) {
    echo json_encode(["ok" => false, "error" => "DGK servisinə qoşulmaq mümkün olmadı", "debug" => $curlErr ?: "boş cavab, httpCode=$httpCode"]);
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

} catch (\Throwable $e) {
    if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        "ok" => false,
        "error" => "PHP xəta (exception)",
        "debug" => $e->getMessage() . ' (sətir ' . $e->getLine() . ')'
    ]);
}
