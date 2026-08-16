CREATE TABLE IF NOT EXISTS faq_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  question TEXT NOT NULL,
  question_ru TEXT,
  answer TEXT NOT NULL,
  answer_ru TEXT,
  category VARCHAR(40) DEFAULT 'auction',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mövcud FAQ suallarını əlavə et
INSERT INTO faq_items (question, question_ru, answer, answer_ru, category, sort_order) VALUES
('Siz hansı auksionlarla işləyirsiniz?','С какими аукционами вы работаете?','Biz Copart, IAAI, Manheim, Adesa, EDGE Pipeline və EnCar auksionları ilə işləyirik.','Мы работаем с аукционами Copart, IAAI, Manheim, Adesa, EDGE Pipeline и EnCar.','auction',1),
('Özüm lot seçə bilərəmmi?','Могу ли я сам выбрать лот?','Hər iki variant mümkündür. Lot nömrəsini bildirirsiniz, biz tender edirik. Yaxud komandamız seçə bilər.','Возможны оба варианта. Вы сообщаете номер лота, мы делаем ставку. Или наша команда подберёт.','auction',2),
('Tenderi udmasaq pul itirirəmmi?','Теряю ли я деньги если не выиграю?','Xeyr. Tenderdə udmadığınız halda heç bir ödəniş tələb olunmur.','Нет. Если вы не выиграли торги, никакой оплаты не требуется.','auction',3),
('Avtomobil Bakıya neçə günə çatır?','За сколько дней автомобиль доедет до Баку?','Orta hesabla 38–55 gün: auksion → liman 5–10 gün, dəniz yolu 25–35 gün.','В среднем 38–55 дней: аукцион → порт 5–10 дней, морской путь 25–35 дней.','shipping',1),
('Daşıma zamanı avtomobil sığortalıdırmı?','Застрахован ли автомобиль при доставке?','Bəli, tam dəniz sığortası daxildir.','Да, включена полная морская страховка.','shipping',2),
('Gömrük vergisi nə qədərdir?','Сколько составляет таможенная пошлина?','1–3 il ~15–20%, 4–7 il ~20–25%, 7+ il ~25–30%. Elektrik avtomobillər 50% güzəşt.','1–3 года ~15–20%, 4–7 лет ~20–25%, 7+ лет ~25–30%. Электромобили льгота 50%.','customs',1),
('Ümumi xərclərə nələr daxildir?','Что входит в общие расходы?','Auksion qiyməti, buyer fee, daxili daşınma ($250), dəniz daşınma, sığorta, gömrük, xidmət haqqı ($450).','Цена лота, комиссия аукциона, доставка по США ($250), морская доставка, страховка, таможня, сервисный сбор ($450).','price',1),
('VIN nömrəsi ilə nə yoxlamaq olar?','Что можно проверить по VIN-номеру?','Qəza tarixi, odometer, əvvəlki sahiblər, servis tarixi, title növü.','История аварий, одометр, предыдущие владельцы, история обслуживания, тип title.','tech',1);

-- İngilis dili sütunları
ALTER TABLE faq_items ADD COLUMN IF NOT EXISTS question_en TEXT AFTER question_ru;
ALTER TABLE faq_items ADD COLUMN IF NOT EXISTS answer_en TEXT AFTER answer_ru;
