<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB Error"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $pdo->prepare("SELECT * FROM car_cases WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC) ?: null);
        exit;
    }
    try {
        $stmt = $pdo->query("SELECT * FROM car_cases ORDER BY sort_order ASC, id ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        // Cədvəl yoxdursa boş array qaytar
        echo json_encode([]);
    }
    exit;
}

if ($method === 'POST') {
    ab_require(['owner','admin','editor']);

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) { http_response_code(400); echo json_encode(["error"=>"Bad data"]); exit; }

    $pdo->exec("DELETE FROM car_cases");

    $stmt = $pdo->prepare(
        "INSERT INTO car_cases (title, country, country_code, photo_url, price, auction_price, shipping_price, customs_price, service_fee, days, description, sort_order)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    foreach ($input as $i => $c) {
        $stmt->execute([
            $c['title'] ?? '',
            $c['country'] ?? 'ABŞ',
            $c['country_code'] ?? 'US',
            $c['photo_url'] ?? '',
            $c['price'] ?? '',
            $c['auction_price'] ?? '',
            $c['shipping_price'] ?? '',
            $c['customs_price'] ?? '',
            $c['service_fee'] ?? '',
            $c['days'] ?? '',
            $c['description'] ?? '',
            $c['sort_order'] ?? ($i + 1)
        ]);
    }
    echo json_encode(["status" => "success"]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
