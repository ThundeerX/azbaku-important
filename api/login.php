<?php
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=UTF-8');

try {

    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/auth.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        exit;
    }

    $raw = file_get_contents("php://input");
    $d = json_decode($raw, true);
    $user = strtolower(trim($d['user'] ?? ''));
    $pass = trim((string)($d['pass'] ?? ''));

    if ($user === '' || $pass === '') {
        echo json_encode(["ok" => false, "error" => "İstifadəçi adı və şifrə tələb olunur"]);
        exit;
    }

    if (!defined('AB_USERS')) {
        echo json_encode(["ok" => false, "error" => "Konfiqurasiya xətası", "debug" => "AB_USERS config.php-də təyin olunmayıb"]);
        exit;
    }

    $users = json_decode(AB_USERS, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($users)) {
        echo json_encode(["ok" => false, "error" => "Konfiqurasiya xətası", "debug" => "AB_USERS JSON səhvdir: " . json_last_error_msg()]);
        exit;
    }

    if (!isset($users[$user])) {
        usleep(300000);
        echo json_encode(["ok" => false, "error" => "İstifadəçi adı tapılmadı: '$user'"]);
        exit;
    }

    $storedPass = trim((string)($users[$user]['pass'] ?? ''));
    if ($storedPass === '' || !hash_equals($storedPass, $pass)) {
        usleep(300000);
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
        "error" => "PHP xəta",
        "debug" => (string)$e->getMessage() . ' | sətir:' . (string)$e->getLine() . ' | fayl:' . basename((string)$e->getFile())
    ], JSON_UNESCAPED_UNICODE);
}
