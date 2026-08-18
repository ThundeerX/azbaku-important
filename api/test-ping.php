<?php
header('Content-Type: text/plain; charset=UTF-8');
ini_set('display_errors', '0');
error_reporting(E_ALL);

function step($msg) {
    echo $msg . "\n";
    @ob_flush();
    @flush();
}

step("1. Skript başladı");

if (!function_exists('curl_init')) {
    step("XƏTA: curl_init yoxdur");
    exit;
}
step("2. cURL mövcuddur");

$ch = curl_init('https://c2b-fbusiness.customs.gov.az/api/v1/dictionaries/calcAutoDuty');
step("3. curl_init tamamlandı");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        "autoType" => "0", "engineType" => "0", "engine" => 2000,
        "commerceType" => "0", "issueDate" => "01.07.2022", "price" => 20000
    ]),
    CURLOPT_TIMEOUT => 8,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json", "lang: az", "requestSource: 1"]
]);
step("4. curl_setopt_array tamamlandı, indi curl_exec çağırılır (bu, asıla bilər)...");

$resp = curl_exec($ch);
step("5. curl_exec QAYITDI (deməli asılmadı!)");

$err = curl_error($ch);
$errno = curl_errno($ch);
$info = curl_getinfo($ch);
curl_close($ch);

step("6. Nəticə:");
step("   curl_errno: " . $errno);
step("   curl_error: " . ($err ?: "(yoxdur)"));
step("   http_code: " . ($info['http_code'] ?? 'N/A'));
step("   total_time: " . ($info['total_time'] ?? 'N/A'));
step("   resp uzunluğu: " . strlen((string)$resp));
step("   resp (ilk 300 simvol): " . substr((string)$resp, 0, 300));
step("7. TAMAMLANDI");
