<?php
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=UTF-8');

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            "error" => "PHP fatal xəta",
            "debug" => $e['message'] . ' (sətir ' . $e['line'] . ')'
        ], JSON_UNESCAPED_UNICODE);
    }
});

try {

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $cat = $_GET['cat'] ?? '';
    $sql = "SELECT * FROM faq_items".($cat?" WHERE category='$cat'":'')." ORDER BY category, sort_order ASC";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $rawCount = $pdo->query("SELECT COUNT(*) c FROM faq_items")->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "rows" => $rows,
        "diagnostics" => [
            "connected_db" => DB_NAME,
            "connected_host" => DB_HOST,
            "raw_count_in_table" => $rawCount['c'] ?? 'N/A'
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

ab_require(['owner','editor']);

if ($method === 'POST') {
    $d = json_decode(file_get_contents("php://input"), true);
    if (isset($d['id'])) {
        $pdo->prepare("UPDATE faq_items SET question=?,question_ru=?,question_en=?,answer=?,answer_ru=?,answer_en=?,category=?,sort_order=? WHERE id=?")
            ->execute([$d['question'],$d['question_ru'],$d['question_en']??'',$d['answer'],$d['answer_ru'],$d['answer_en']??'',$d['category'],$d['sort_order']??0,$d['id']]);
    } else {
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

http_response_code(405);
echo json_encode(["error"=>"Method not allowed"]);

} catch (\Throwable $e) {
    if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        "error" => "PHP xəta",
        "debug" => $e->getMessage() . ' (sətir ' . $e->getLine() . ')'
    ], JSON_UNESCAPED_UNICODE);
}
