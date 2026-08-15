<?php
// Bu faylı config.php olaraq kopyalayın və öz məlumatlarınızı yazın
// config.php .gitignore-dadır — GitHub-a YÜKLƏNMƏYƏCƏK
define('DB_HOST', 'localhost');
define('DB_NAME', 'DATABASE_ADI_BURAYA');
define('DB_USER', 'USER_ADI_BURAYA');
define('DB_PASS', 'SIFRE_BURAYA');
define('ADMIN_PASSWORD', 'admin_sifresi_buraya');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
