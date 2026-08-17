-- Mövcud verilənlər bazasına yeni sütunlar əlavə edir.
-- phpMyAdmin -> SQL tabında bunu işlədin (yalnız BİR DƏFƏ).

ALTER TABLE car_cases
  ADD COLUMN country VARCHAR(60) DEFAULT 'ABŞ' AFTER title,
  ADD COLUMN country_code VARCHAR(2) DEFAULT 'US' AFTER country,
  ADD COLUMN photo_url VARCHAR(500) DEFAULT '' AFTER country_code,
  ADD COLUMN auction_price VARCHAR(40) DEFAULT '' AFTER price,
  ADD COLUMN shipping_price VARCHAR(40) DEFAULT '' AFTER auction_price,
  ADD COLUMN customs_price VARCHAR(40) DEFAULT '' AFTER shipping_price,
  ADD COLUMN service_fee VARCHAR(40) DEFAULT '' AFTER customs_price,
  ADD COLUMN description TEXT AFTER service_fee;

-- Mövcud 3 nümunə üçün nümunə məlumatlar (istəyə görə redaktə edin)
UPDATE car_cases SET
  country='ABŞ', country_code='US', photo_url='images/cases/case-1.svg',
  auction_price='$16,800', shipping_price='$1,350', customs_price='$2,800', service_fee='$450',
  description='Bu Honda CR-V Florida ştatındakı Copart auksionundan tapıldı və 9 gün ərzində qazanıldı. Konteynerlə Bakı limanına sığortalı şəkildə daşındı.'
WHERE title LIKE 'Honda CR-V%';

UPDATE car_cases SET
  country='Kanada', country_code='CA', photo_url='images/cases/case-2.svg',
  auction_price='$21,200', shipping_price='$1,600', customs_price='$3,650', service_fee='$450',
  description='Ford F-150 Ontario əyalətindəki IAAI auksionundan alındı. Yüngül zədəli lot kimi əldə edildi, servisdə tam yoxlanıldı.'
WHERE title LIKE 'Ford F-150%';

UPDATE car_cases SET
  country='ABŞ', country_code='US', photo_url='images/cases/case-3.svg',
  auction_price='$19,400', shipping_price='$1,400', customs_price='$2,900', service_fee='$450',
  description='BMW 3 Series Texas ştatındakı auksiondan zədəsiz vəziyyətdə qazanıldı və birbaşa Bakıya göndərildi.'
WHERE title LIKE 'BMW 3 Series%';
