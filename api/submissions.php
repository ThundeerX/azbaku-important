<?php
require_once 'config.php';
require_once 'auth.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB Connection Error"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// POST — yeni sorğu (müştəridən)
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) { http_response_code(400); echo json_encode(["status" => "error"]); exit; }

    $make = $data['make'] ?? '';
    $model = $data['model'] ?? '';
    $year_from = $data['year_from'] ?? ($data['yearFrom'] ?? '');
    $year_to = $data['year_to'] ?? ($data['yearTo'] ?? '');
    $condition = $data['condition_pref'] ?? ($data['condition'] ?? '');
    $budget = 0;
    if (isset($data['budget'])) {
        if (is_numeric($data['budget'])) { $budget = (int)$data['budget']; }
        else { preg_match('/\d+/', $data['budget'], $m); $budget = $m[0] ?? 0; }
    }
    $name = $data['customer_name'] ?? ($data['name'] ?? '');
    $phone = $data['phone'] ?? '';
    $notes = $data['notes'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO submissions (make, model, year_from, year_to, condition_pref, budget, customer_name, phone, notes, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())");
    $stmt->execute([$make, $model, $year_from, $year_to, $condition, $budget, $name, $phone, $notes]);
    echo json_encode(["status" => "success"]);
    exit;
}

// PUT — status dəyişdirmə (admin)
if ($method === 'PUT') {
    ab_require(['owner']);

    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id'] ?? 0);
    $status = $data['status'] ?? '';
    if ($id && in_array($status, ['new','contacted','closed'])) {
        $stmt = $pdo->prepare("UPDATE submissions SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(["status" => "success"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error"]);
    }
    exit;
}

// GET — admin üçün sorğu siyahısı
if ($method === 'GET') {
    ab_require(['owner']);

    $stmt = $pdo->query("SELECT * FROM submissions ORDER BY id DESC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
?>
