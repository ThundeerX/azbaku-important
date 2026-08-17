<?php
// AzBaku — İstifadəçi autentifikasiyası və rol yoxlaması
// İstifadəçilər config.php-də AB_USERS sabitində təyin olunur

/**
 * Sorğudakı Bearer tokeni yoxlayır.
 * Token formatı: base64("istifadeci:sifre")
 * @return array|null ['user'=>'ceyhun','role'=>'owner'] və ya null
 */
function ab_auth() {
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    $raw = '';
    foreach ($headers as $k => $v) {
        if (strtolower($k) === 'authorization') { $raw = $v; break; }
    }
    if (!$raw && isset($_SERVER['HTTP_AUTHORIZATION'])) $raw = $_SERVER['HTTP_AUTHORIZATION'];
    if (!$raw) return null;

    $token = trim(str_replace('Bearer', '', $raw));
    if ($token === '') return null;

    // --- Yeni sistem: base64(user:pass) ---
    $decoded = base64_decode($token, true);
    if ($decoded !== false && strpos($decoded, ':') !== false) {
        list($u, $p) = explode(':', $decoded, 2);
        $users = defined('AB_USERS') ? json_decode(AB_USERS, true) : null;
        if (is_array($users)) {
            $u = strtolower(trim($u));
            if (isset($users[$u]) && hash_equals((string)$users[$u]['pass'], (string)$p)) {
                return ['user' => $u, 'role' => $users[$u]['role'] ?? 'admin'];
            }
        }
    }

    // --- Köhnə sistem (geriyə uyğunluq): sadə ADMIN_PASSWORD ---
    if (defined('ADMIN_PASSWORD') && hash_equals((string)ADMIN_PASSWORD, (string)$token)) {
        return ['user' => 'admin', 'role' => 'owner'];
    }

    return null;
}

/**
 * Tələb olunan rolu yoxlayır, uyğun gəlmirsə 401/403 qaytarıb dayandırır.
 * @param array $allowed  ['owner'] və ya ['owner','admin']
 * @return array İstifadəçi məlumatı
 */
function ab_require($allowed = ['owner','admin']) {
    $me = ab_auth();
    if (!$me) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }
    if (!in_array($me['role'], $allowed, true)) {
        http_response_code(403);
        echo json_encode(["error" => "Bu əməliyyat üçün icazəniz yoxdur"]);
        exit;
    }
    return $me;
}
