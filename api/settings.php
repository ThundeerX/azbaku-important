<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB Connection Error"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// GET — public: bütün tənzimləmələri qaytarır
if ($method === 'GET') {
    $stmt = $pdo->query("SELECT skey, svalue FROM site_settings");
    $out = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $out[$row['skey']] = $row['svalue'];
    }
    echo json_encode($out);
    exit;
}

// POST — admin: tənzimləmələri yeniləyir
if ($method === 'POST') {
    $me = ab_require(['owner','admin','editor']);

    $data = json_decode(file_get_contents("php://input"), true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    // AI API key yalnız owner (Ceyhun) tərəfindən dəyişilə bilər —
    // UI-də də yalnız "API" tabında görünür (owner-only).
    if ($me['role'] !== 'owner') {
        unset($data['ai_api_key']);
    }

    $stmt = $pdo->prepare("INSERT INTO site_settings (skey, svalue) VALUES (?, ?) ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)");
    foreach ($data as $k => $v) {
        $stmt->execute([$k, (string)$v]);
    }
    echo json_encode(["status" => "success"]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
