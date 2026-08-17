<?php
// Bu faylı config.php olaraq kopyalayın və öz məlumatlarınızı yazın
// config.php .gitignore-dadır — GitHub-a YÜKLƏNMƏYƏCƏK

define('DB_HOST', 'localhost');
define('DB_NAME', 'DATABASE_ADI');
define('DB_USER', 'USER_ADI');
define('DB_PASS', 'DB_SIFRESI');

// ===== ADMIN İSTİFADƏÇİLƏRİ =====
// role: 'owner' = hər şeyə giriş (bütün qəbzləri görür)
//       'admin' = məhdud (yalnız qəbz əlavə edir, kalkulyator, nümunələr)
// Şifrələri BURADA öz istədiyinizlə əvəz edin
define('AB_USERS', json_encode([
    'ceyhun' => ['pass' => 'CEYHUN_SIFRESI',  'role' => 'owner', 'name' => 'Ceyhun'],
    'admin'  => ['pass' => 'ADMIN_SIFRESI',   'role' => 'admin', 'name' => 'Admin']
]));

// Köhnə sistem üçün (dəyişməyin, boş qala bilər)
define('ADMIN_PASSWORD', 'ADMIN_SIFRESI');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
