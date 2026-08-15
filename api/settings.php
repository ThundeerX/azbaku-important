<?php
require_once 'config.php';

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
    $headers = getallheaders();
    $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';
    if ($token !== ADMIN_PASSWORD) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
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
