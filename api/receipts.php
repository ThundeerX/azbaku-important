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

// Rol yoxlaması: qəbzləri GÖRMƏK yalnız owner-ə, ƏLAVƏ ETMƏK hər ikisinə
if ($method === 'GET' || $method === 'DELETE') {
    ab_require(['owner']);
} else {
    ab_require(['owner','admin','editor']);
}

if ($method === 'GET') {
    // Optional month filter: ?month=2026-08
    $where = '';
    $params = [];
    if (!empty($_GET['month'])) {
        $where = "WHERE DATE_FORMAT(receipt_date, '%Y-%m') = ?";
        $params[] = $_GET['month'];
    }
    $stmt = $pdo->prepare("SELECT * FROM receipts $where ORDER BY receipt_date DESC, id DESC");
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($method === 'POST') {
    $d = json_decode(file_get_contents("php://input"), true);
    if (!$d) { http_response_code(400); echo json_encode(["error" => "Bad data"]); exit; }

    $stmt = $pdo->prepare("INSERT INTO receipts (customer_name,phone,payer,officer,car,vin,mileage,repair_cost,total_price,profit,deposit,shipping_pay,logistics,receipt_date,delivery_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $d['customer_name']??'',$d['phone']??'',$d['payer']??'',$d['officer']??'',
        $d['car']??'',$d['vin']??'',$d['mileage']??'',$d['repair_cost']??'',
        $d['total_price']??'',$d['profit']??'',$d['deposit']??'',$d['shipping_pay']??'',
        $d['logistics']??'',$d['receipt_date']??date('Y-m-d'),$d['delivery_date']??''
    ]);
    echo json_encode(["status"=>"success","id"=>$pdo->lastInsertId()]);
    exit;
}

if ($method === 'DELETE') {
    $d = json_decode(file_get_contents("php://input"), true);
    $id = intval($d['id'] ?? 0);
    if ($id) { $pdo->prepare("DELETE FROM receipts WHERE id=?")->execute([$id]); }
    echo json_encode(["status"=>"success"]);
    exit;
}

http_response_code(405);
echo json_encode(["error"=>"Method not allowed"]);
