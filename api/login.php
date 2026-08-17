<?php
require_once 'config.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

$d = json_decode(file_get_contents("php://input"), true);
$user = strtolower(trim($d['user'] ?? ''));
$pass = (string)($d['pass'] ?? '');

if ($user === '' || $pass === '') {
    echo json_encode(["ok" => false, "error" => "İstifadəçi adı və şifrə tələb olunur"]);
    exit;
}

$users = defined('AB_USERS') ? json_decode(AB_USERS, true) : null;
if (!is_array($users)) {
    echo json_encode(["ok" => false, "error" => "İstifadəçilər config.php-də təyin olunmayıb"]);
    exit;
}

if (!isset($users[$user]) || !hash_equals((string)$users[$user]['pass'], $pass)) {
    // Brute-force yavaşlatma
    usleep(400000);
    echo json_encode(["ok" => false, "error" => "İstifadəçi adı və ya şifrə yanlışdır"]);
    exit;
}

echo json_encode([
    "ok"    => true,
    "token" => base64_encode($user . ':' . $pass),
    "user"  => $user,
    "name"  => $users[$user]['name'] ?? ucfirst($user),
    "role"  => $users[$user]['role'] ?? 'admin'
]);
