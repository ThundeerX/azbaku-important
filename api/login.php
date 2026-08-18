<?php
// --- MÜVƏQQƏTİ DEBUG REJİMİ: hər hansı PHP xətasını JSON kimi tutub göstərir ---
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=UTF-8');

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            "ok" => false,
            "error" => "PHP fatal xəta",
            "debug" => $e['message'] . ' (sətir ' . $e['line'] . ', fayl: ' . basename($e['file']) . ')'
        ]);
    }
});

try {

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

$d = json_decode(file_get_contents("php://input"), true);
$user = strtolower(trim($d['user'] ?? ''));
$pass = trim((string)($d['pass'] ?? ''));

if ($user === '' || $pass === '') {
    echo json_encode(["ok" => false, "error" => "İstifadəçi adı və şifrə tələb olunur"]);
    exit;
}

$users = defined('AB_USERS') ? json_decode(AB_USERS, true) : null;
if (!is_array($users)) {
    echo json_encode(["ok" => false, "error" => "İstifadəçilər config.php-də təyin olunmayıb", "debug" => "AB_USERS boş və ya səhv formatda"]);
    exit;
}

if (!isset($users[$user])) {
    usleep(400000);
    echo json_encode(["ok" => false, "error" => "İstifadəçi adı tapılmadı (config.php-də '$user' açarını yoxlayın)"]);
    exit;
}
if (!hash_equals((string)trim($users[$user]['pass']), $pass)) {
    usleep(400000);
    echo json_encode(["ok" => false, "error" => "Şifrə yanlışdır"]);
    exit;
}

echo json_encode([
    "ok"    => true,
    "token" => base64_encode($user . ':' . $pass),
    "user"  => $user,
    "name"  => $users[$user]['name'] ?? ucfirst($user),
    "role"  => $users[$user]['role'] ?? 'admin'
]);

} catch (\Throwable $e) {
    if (!headers_sent()) header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        "ok" => false,
        "error" => "PHP xəta (exception)",
        "debug" => $e->getMessage() . ' (sətir ' . $e->getLine() . ')'
    ]);
}
