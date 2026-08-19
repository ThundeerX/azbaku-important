<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { http_response_code(500); echo json_encode(["error"=>"DB Error"]); exit; }

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $cat = $_GET['cat'] ?? '';
    $sql = "SELECT * FROM faq_items".($cat?" WHERE category='$cat'":'')." ORDER BY category, sort_order ASC";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        http_response_code(500);
        echo json_encode(["error" => "JSON xətası", "debug" => json_last_error_msg(), "row_count" => count($rows)]);
        exit;
    }
    echo $json;
    exit;
}

ab_require(['owner','editor']);

if ($method === 'POST') {
    $d = json_decode(file_get_contents("php://input"), true);
    if (isset($d['id'])) {
        // Update
        $pdo->prepare("UPDATE faq_items SET question=?,question_ru=?,question_en=?,answer=?,answer_ru=?,answer_en=?,category=?,sort_order=? WHERE id=?")
            ->execute([$d['question'],$d['question_ru'],$d['question_en']??'',$d['answer'],$d['answer_ru'],$d['answer_en']??'',$d['category'],$d['sort_order']??0,$d['id']]);
    } else {
        // Insert
        $pdo->prepare("INSERT INTO faq_items (question,question_ru,question_en,answer,answer_ru,answer_en,category,sort_order) VALUES (?,?,?,?,?,?,?,?)")
            ->execute([$d['question'],$d['question_ru'],$d['question_en']??'',$d['answer'],$d['answer_ru'],$d['answer_en']??'',$d['category'],$d['sort_order']??0]);
    }
    echo json_encode(["status"=>"success"]);
    exit;
}

if ($method === 'DELETE') {
    $d = json_decode(file_get_contents("php://input"), true);
    $pdo->prepare("DELETE FROM faq_items WHERE id=?")->execute([$d['id']]);
    echo json_encode(["status"=>"success"]);
    exit;
}
