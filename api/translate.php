<?php
// AI tərcümə proxy — API key serverdə qalır, brauzerə getmir
// Tərcümələr bazada keşlənir, hər dəfə AI-yə sorğu getmir
require_once 'config.php';
require_once 'auth.php';

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "DB Error"]); exit;
}


// DELETE — admin keşi təmizləyir
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    ab_require(['owner']);
    $pdo->exec("DELETE FROM translation_cache");
    echo json_encode(["status"=>"success"]); exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$texts  = $data['texts']  ?? [];
$target = $data['target'] ?? 'ru';           // ru | en
if (!in_array($target, ['ru','en'])) { echo json_encode(["error"=>"Bad target"]); exit; }
if (!is_array($texts) || !count($texts))   { echo json_encode([]); exit; }

// --- 1. Keşdən oxu ---
$out = [];
$missing = [];
$sel = $pdo->prepare("SELECT translated FROM translation_cache WHERE src_hash=? AND lang=?");
foreach ($texts as $t) {
    $t = trim($t);
    if ($t === '') { $out[$t] = $t; continue; }
    $h = md5($t);
    $sel->execute([$h, $target]);
    $row = $sel->fetch(PDO::FETCH_ASSOC);
    if ($row) { $out[$t] = $row['translated']; }
    else      { $missing[] = $t; }
}

// --- 2. Çatışmayanları AI-yə göndər ---
if (count($missing)) {
    $keyStmt = $pdo->query("SELECT svalue FROM site_settings WHERE skey='ai_api_key'");
    $apiKey  = $keyStmt->fetchColumn();

    if ($apiKey) {
        $langName = $target === 'ru' ? 'Russian' : 'English';
        // Nömrələnmiş siyahı göndəririk ki, cavabı dəqiq ayıra bilək
        $numbered = '';
        foreach ($missing as $i => $m) { $numbered .= ($i+1).". ".str_replace("\n"," ",$m)."\n"; }

        $prompt = "Translate each numbered line from Azerbaijani into $langName.\n".
                  "Rules:\n".
                  "- Keep any HTML tags exactly as they are.\n".
                  "- Keep numbers, prices, and currency symbols unchanged.\n".
                  "- Do NOT translate brand names: AzBaku, AutoImport, Copart, IAAI, Manheim, Adesa, EDGE, EnCar.\n".
                  "- Return ONLY the numbered translations, same numbering, one per line. No extra text.\n\n".
                  $numbered;

        $payload = json_encode([
            "model" => "claude-sonnet-4-6",
            "max_tokens" => 4000,
            "messages" => [["role" => "user", "content" => $prompt]]
        ]);

        $ch = curl_init("https://api.anthropic.com/v1/messages");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "x-api-key: " . $apiKey,
                "anthropic-version: 2023-06-01"
            ]
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);

        $j = json_decode($resp, true);
        $textOut = $j['content'][0]['text'] ?? '';

        if ($textOut) {
            $lines = preg_split('/\r?\n/', trim($textOut));
            $ins = $pdo->prepare("INSERT INTO translation_cache (src_hash, lang, source, translated) VALUES (?,?,?,?)
                                  ON DUPLICATE KEY UPDATE translated=VALUES(translated)");
            foreach ($lines as $line) {
                if (preg_match('/^\s*(\d+)[\.\)]\s*(.+)$/u', $line, $m)) {
                    $idx = intval($m[1]) - 1;
                    $tr  = trim($m[2]);
                    if (isset($missing[$idx]) && $tr !== '') {
                        $src = $missing[$idx];
                        $out[$src] = $tr;
                        $ins->execute([md5($src), $target, mb_substr($src,0,1000), $tr]);
                    }
                }
            }
        }
    }
    // Tərcümə alınmayanlar orijinal qalsın
    foreach ($missing as $m) { if (!isset($out[$m])) $out[$m] = $m; }
}

echo json_encode($out, JSON_UNESCAPED_UNICODE);
