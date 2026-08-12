<?php
require_once 'config.php';
$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Public endpoint — any customer can submit the request form
  $input = json_decode(file_get_contents('php://input'), true);

  $make = $input['make'] ?? '';
  $model = $input['model'] ?? '';
  $yearFrom = $input['yearFrom'] ?? '';
  $yearTo = $input['yearTo'] ?? '';
  $condition = $input['condition'] ?? '';
  $budget = intval($input['budget'] ?? 0);
  $name = $input['name'] ?? '';
  $phone = $input['phone'] ?? '';
  $notes = $input['notes'] ?? '';

  $stmt = $conn->prepare(
    "INSERT INTO submissions (make, model, year_from, year_to, condition_pref, budget, customer_name, phone, notes)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
  );
  $stmt->bind_param('ssssisss', $make, $model, $yearFrom, $yearTo, $condition, $budget, $name, $phone, $notes);
  $stmt->execute();

  echo json_encode(['success' => true]);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Admin-only — viewing customer submissions requires the admin password
  check_admin_auth();
  $result = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC");
  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
  exit();
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
