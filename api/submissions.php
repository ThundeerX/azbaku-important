<?php
require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB Connection Error"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "İnvalid JSON"]);
        exit;
    }

    // Sahə adlarını uyğunlaşdırma (fallback)
    $make = $data['make'] ?? '';
    $model = $data['model'] ?? '';
    $year_from = $data['year_from'] ?? ($data['yearFrom'] ?? '');
    $year_to = $data['year_to'] ?? ($data['yearTo'] ?? '');
    $condition_pref = $data['condition_pref'] ?? ($data['condition'] ?? 'any');
    $customer_name = $data['customer_name'] ?? ($data['name'] ?? '');
    $phone = $data['phone'] ?? '';
    $notes = $data['notes'] ?? '';
    
    // Büdcəni rəqəmə çevirmək
    $budget = 0;
    if (isset($data['budget'])) {
        if (is_numeric($data['budget'])) {
            $budget = (int)$data['budget'];
        } else {
            preg_match_all('/\d+/', $data['budget'], $matches);
            if (!empty($matches[0])) {
                $budget = (int)end($matches[0]);
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO submissions (make, model, year_from, year_to, condition_pref, budget, customer_name, phone, notes, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $success = $stmt->execute([
        $make, $model, $year_from, $year_to, $condition_pref, $budget, $customer_name, $phone, $notes
    ]);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Sorğu qəbul edildi"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Yazılmadı"]);
    }
    exit;
}

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM submissions ORDER BY id DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
    exit;
}
?>
