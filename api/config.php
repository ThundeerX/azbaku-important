<?php
// ===== Hostinger MySQL məlumatlarınız =====
// hPanel → Databases → MySQL Databases-də tapa bilərsiniz
define('DB_HOST', 'localhost');
define('DB_NAME', 'u433991115_azbaku30');
define('DB_USER', 'u433991115_azbaku30');
define('DB_PASS', 'BURAYA_DB_SIFRENIZI_YAZIN');

// ===== ADMIN İSTİFADƏÇİLƏRİ =====
// owner = hər şeyə giriş (bütün qəbzlər, sorğular, sayt mətni)
// admin = məhdud (nümunələr, kalkulyator, yeni qəbz əlavə etmək)
define('AB_USERS', json_encode([
    'ceyhun' => ['pass' => 'BURAYA_CEYHUN_SIFRESI',  'role' => 'owner', 'name' => 'Ceyhun'],
    'admin'  => ['pass' => 'BURAYA_ADMIN_SIFRESI',   'role' => 'admin', 'name' => 'Admin']
]));

// Köhnə API-lər üçün (toxunmayın)
define('ADMIN_PASSWORD', 'BURAYA_CEYHUN_SIFRESI');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
