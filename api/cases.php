<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Single case by id (for the detail page)
  if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM car_cases WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    echo json_encode($row ?: null);
    exit();
  }

  // Full list (for the gallery + homepage preview)
  $result = $conn->query("SELECT * FROM car_cases ORDER BY sort_order ASC, id ASC");
  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  check_admin_auth();
  $input = json_decode(file_get_contents('php://input'), true); // array of case objects

  $conn->query("DELETE FROM car_cases"); // simplest approach: replace whole list on save

  $stmt = $conn->prepare(
    "INSERT INTO car_cases
     (title, country, country_code, photo_url, price, auction_price, shipping_price, customs_price, service_fee, days, description, sort_order)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
  );
  $order = 0;
  foreach ($input as $c) {
    $order++;
    $title = $c['title'] ?? '';
    $country = $c['country'] ?? 'ABŞ';
    $countryCode = $c['country_code'] ?? 'US';
    $photoUrl = $c['photo_url'] ?? '';
    $price = $c['price'] ?? '';
    $auctionPrice = $c['auction_price'] ?? '';
    $shippingPrice = $c['shipping_price'] ?? '';
    $customsPrice = $c['customs_price'] ?? '';
    $serviceFee = $c['service_fee'] ?? '';
    $days = $c['days'] ?? '';
    $description = $c['description'] ?? '';

    $stmt->bind_param('sssssssssssi',
      $title, $country, $countryCode, $photoUrl, $price,
      $auctionPrice, $shippingPrice, $customsPrice, $serviceFee,
      $days, $description, $order
    );
    $stmt->execute();
  }

  echo json_encode(['success' => true]);
  exit();
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
