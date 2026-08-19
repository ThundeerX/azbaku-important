<?php
header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
    "ok" => true,
    "message" => "PHP işləyir!",
    "php_version" => phpversion(),
    "curl_available" => function_exists('curl_init') ? "bəli" : "XEYR",
    "allow_url_fopen" => ini_get('allow_url_fopen') ? "açıq" : "bağlı",
    "max_execution_time" => ini_get('max_execution_time'),
    "time" => date('Y-m-d H:i:s')
]);
