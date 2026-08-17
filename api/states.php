<?php
require_once 'config.php';
require_once 'auth.php';

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { echo json_encode(["error"=>"DB"]); exit; }

$method = $_SERVER['REQUEST_METHOD'];

// GET — public: ?auction=copart
if ($method === 'GET') {
    $a = $_GET['auction'] ?? '';
    try {
        if ($a) {
            $s = $pdo->prepare("SELECT * FROM shipping_states WHERE auction=? ORDER BY state_name ASC");
            $s->execute([$a]);
        } else {
            $s = $pdo->query("SELECT * FROM shipping_states ORDER BY auction, state_name ASC");
        }
        echo json_encode($s->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) { echo json_encode([]); }
    exit;
}

ab_require(['owner','admin']);

// POST — bir auksionun bütün ştatlarını əvəz edir
if ($method === 'POST') {
    $d = json_decode(file_get_contents("php://input"), true);
    $auction = $d['auction'] ?? '';
    $rows    = $d['states']  ?? [];
    if (!$auction) { echo json_encode(["error"=>"No auction"]); exit; }

    $pdo->prepare("DELETE FROM shipping_states WHERE auction=?")->execute([$auction]);
    $ins = $pdo->prepare("INSERT INTO shipping_states (auction,state_name,port,cost) VALUES (?,?,?,?)");
    foreach ($rows as $r) {
        if (empty($r['state_name'])) continue;
        $ins->execute([$auction, $r['state_name'], $r['port'] ?? '', intval($r['cost'] ?? 250)]);
    }
    echo json_encode(["status"=>"success","count"=>count($rows)]);
    exit;
}

http_response_code(405);
echo json_encode(["error"=>"Method not allowed"]);
