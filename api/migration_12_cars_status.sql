-- AzBaku AutoImport — 12 nümunə + sorğu statusu
-- phpMyAdmin -> SQL tabında İŞLƏDİN (bir dəfə)

-- Sorğulara status sütunu əlavə et (əgər yoxdursa)
ALTER TABLE submissions ADD COLUMN IF NOT EXISTS status VARCHAR(20) DEFAULT 'new';

-- Mövcud nümunələri sil və 12 yenisini əlavə et
TRUNCATE TABLE car_cases;

INSERT INTO car_cases (title, country, country_code, photo_url, price, auction_price, shipping_price, customs_price, service_fee, days, description, sort_order) VALUES
('Toyota Camry 2022', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=700&q=80', '$22,800', '$15,200', '$1,350', '$5,800', '$450', '39 gün', 'Florida ştatındakı Copart auksionundan zədəsiz vəziyyətdə alındı.', 1),
('Honda CR-V 2023', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?w=700&q=80', '$26,400', '$18,500', '$1,400', '$6,050', '$450', '42 gün', 'Texasdan gətirildi, tam komplektasiya ilə.', 2),
('Ford F-150 2021', 'Kanada', 'CA', 'https://images.unsplash.com/photo-1605893477799-b99e3b8b93fe?w=700&q=80', '$28,900', '$21,200', '$1,600', '$5,650', '$450', '38 gün', 'Ontario əyalətindəki IAAI auksionundan alındı.', 3),
('BMW 3 Series 2022', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=700&q=80', '$31,500', '$23,400', '$1,450', '$6,200', '$450', '44 gün', 'Kaliforniya auksionundan zədəsiz alınıb.', 4),
('Mercedes-Benz C300 2021', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=700&q=80', '$34,200', '$25,800', '$1,500', '$6,450', '$450', '46 gün', 'Copart üzərindən Nyu-Yorkdan gətirildi.', 5),
('Hyundai Tucson 2023', 'Kanada', 'CA', 'https://images.unsplash.com/photo-1606611013016-969c19ba1928?w=700&q=80', '$24,100', '$16,300', '$1,550', '$5,800', '$450', '41 gün', 'Vancouver auksionundan əla vəziyyətdə alınıb.', 6),
('Chevrolet Tahoe 2022', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=700&q=80', '$42,500', '$33,000', '$1,800', '$7,250', '$450', '48 gün', 'Texas ştatındakı auksiondan alınıb, premium paket.', 7),
('Kia Sportage 2023', 'Kanada', 'CA', 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=700&q=80', '$23,600', '$15,800', '$1,500', '$5,850', '$450', '40 gün', 'Montreal auksionundan alınıb, az yürüşlü.', 8),
('Lexus RX 350 2022', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=700&q=80', '$38,900', '$29,500', '$1,550', '$7,400', '$450', '45 gün', 'IAAI Florida auksionundan premium komplektasiya ilə.', 9),
('Nissan Altima 2023', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=700&q=80', '$20,400', '$13,200', '$1,300', '$5,450', '$450', '37 gün', 'Georgia ştatından gətirildi, zədəsiz.', 10),
('Audi Q5 2021', 'Kanada', 'CA', 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=700&q=80', '$36,700', '$27,800', '$1,650', '$6,800', '$450', '47 gün', 'Toronto auksionundan alındı, S-line paket.', 11),
('Tesla Model 3 2022', 'ABŞ', 'US', 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=700&q=80', '$33,200', '$24,500', '$1,400', '$6,850', '$450', '43 gün', 'Kaliforniya Copart-dan Long Range versiyası alınıb.', 12);
