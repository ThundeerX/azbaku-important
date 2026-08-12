<?php
// ===== FILL THESE IN with your Hostinger MySQL details =====
// Find them in hPanel → Databases → MySQL Databases
define('DB_HOST', 'localhost');           // usually 'localhost' on Hostinger
define('DB_NAME', '1234_azbaku');   // your database name
define('DB_USER', 'u1234_admin');    // your database username
define('DB_PASS', 'Azbaku2026');    // your database password

// Change this to your own secret admin password before uploading
define('ADMIN_PASSWORD', 'Azbaku2026');

// Allow requests from your domain only (update once your domain is live)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

function get_db() {
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
  }
  $conn->set_charset('utf8mb4');
  return $conn;
}

function check_admin_auth() {
  $headers = getallheaders();
  $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';
  if ($token !== ADMIN_PASSWORD) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
  }
}
