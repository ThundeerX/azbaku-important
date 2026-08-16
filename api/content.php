<?php
require_once 'config.php';
$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $result = $conn->query("SELECT content_key, content_value FROM site_content");
  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[$row['content_key']] = $row['content_value'];
  }
  echo json_encode($data);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  check_admin_auth();
  $input = json_decode(file_get_contents('php://input'), true);

  $stmt = $conn->prepare(
    "INSERT INTO site_content (content_key, content_value) VALUES (?, ?)
     ON DUPLICATE KEY UPDATE content_value = VALUES(content_value)"
  );

  foreach ($input as $key => $value) {
    $stmt->bind_param('ss', $key, $value);
    $stmt->execute();
  }

  echo json_encode(['success' => true]);
  exit();
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
