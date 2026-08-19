-- Qəbzlər cədvəli
CREATE TABLE IF NOT EXISTS receipts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_name VARCHAR(120),
  phone VARCHAR(40),
  payer VARCHAR(120),
  officer VARCHAR(120),
  car VARCHAR(120),
  vin VARCHAR(40),
  mileage VARCHAR(40),
  repair_cost VARCHAR(40),
  total_price VARCHAR(40),
  profit VARCHAR(40),
  deposit VARCHAR(40),
  shipping_pay VARCHAR(40),
  logistics VARCHAR(120),
  receipt_date DATE,
  delivery_date VARCHAR(40),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
