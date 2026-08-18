-- AzBaku AutoImport — database schema
-- Run this once in Hostinger hPanel → Databases → phpMyAdmin → Import (or SQL tab)

CREATE TABLE IF NOT EXISTS site_content (
  id INT PRIMARY KEY AUTO_INCREMENT,
  content_key VARCHAR(64) UNIQUE NOT NULL,
  content_value TEXT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO site_content (content_key, content_value) VALUES
  ('hero_title', 'Siz sifariş verin,<br><em>biz tapıb gətirək.</em>'),
  ('hero_lead', 'Bizim öz avtoparkımız yoxdur — sizin üçün ABŞ və Kanada auksionlarından dəqiq istədiyiniz avtomobili axtarır, alır və Bakıya qədər sığortalı çatdırırıq.'),
  ('phone', '+994 00 000 00 00')
ON DUPLICATE KEY UPDATE content_key = content_key;

CREATE TABLE IF NOT EXISTS car_cases (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL,
  price VARCHAR(40) NOT NULL,
  days VARCHAR(40) NOT NULL,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO car_cases (title, price, days, sort_order) VALUES
  ('Honda CR-V 2022', '$21,400', '41 gün', 1),
  ('Ford F-150 2020', '$26,900', '38 gün', 2),
  ('BMW 3 Series 2021', '$24,150', '44 gün', 3);

CREATE TABLE IF NOT EXISTS submissions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  make VARCHAR(80),
  model VARCHAR(80),
  year_from VARCHAR(10),
  year_to VARCHAR(10),
  condition_pref VARCHAR(20),
  budget INT,
  customer_name VARCHAR(120),
  phone VARCHAR(40),
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
