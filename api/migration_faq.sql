-- AzBaku FAQ — tam 25 sual, 3 dil (AZ/RU/EN), TƏKRARSIZ
-- Bu skripti neçə dəfə işlətsəniz də təkrarlanma olmayacaq (əvvəlcə köhnə məlumat silinir)

CREATE TABLE IF NOT EXISTS faq_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  question TEXT NOT NULL,
  question_ru TEXT,
  question_en TEXT,
  answer TEXT NOT NULL,
  answer_ru TEXT,
  answer_en TEXT,
  category VARCHAR(40) DEFAULT 'auction',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

TRUNCATE TABLE faq_items;

INSERT INTO faq_items (question,question_ru,question_en,answer,answer_ru,answer_en,category,sort_order) VALUES

('Siz hansı auksionlarla işləyirsiniz?','С какими аукционами вы работаете?','Which auctions do you work with?',
'Biz Copart, IAAI, Manheim, Adesa, EDGE Pipeline və EnCar auksionları ilə işləyirik.','Мы работаем с аукционами Copart, IAAI, Manheim, Adesa, EDGE Pipeline и EnCar.','We work with Copart, IAAI, Manheim, Adesa, EDGE Pipeline and EnCar auctions.','auction',1),

('Özüm lot seçə bilərəmmi, yoxsa siz seçirsiniz?','Могу ли я сам выбрать лот или вы выбираете?','Can I choose the lot myself, or do you choose?',
'Hər iki variant mümkündür. Özünüz seçə bilərsiniz — lot nömrəsini bizə bildirirsiniz, biz tender edirik. Yaxud bizim komanda seçə bilər.','Возможны оба варианта. Вы можете выбрать сами — сообщаете нам номер лота, мы делаем ставку. Или наша команда подберёт.','Both options are possible. You can choose yourself — tell us the lot number and we bid. Or our team can select for you.','auction',2),

('Tenderdən əvvəl avtomobilin vəziyyətini yoxlamaq olurmu?','Можно ли проверить состояние авто до торгов?','Can I check the vehicle condition before bidding?',
'Auksiyon saytlarında hər lot üçün ətraflı şəkillər mövcuddur. VIN nömrəsi ilə avtomobilin tarixçəsini yoxlaya bilərsiniz.','На аукционных сайтах для каждого лота есть подробные фото. Можно проверить историю авто по VIN-номеру.','Auction sites provide detailed photos for every lot. You can also check the vehicle history using the VIN number.','auction',3),

('Tenderi udmasaq pul itirirəmmi?','Теряю ли я деньги, если не выиграю торги?','Do I lose money if I don''t win the bid?',
'Xeyr. Tenderdə udmadığınız halda heç bir ödəniş tələb olunmur. Limit qiymətinizi siz müəyyən edirsiniz.','Нет. Если вы не выиграли торги, никакой оплаты не требуется. Лимит цены устанавливаете вы.','No. If you don''t win the auction, no payment is required. You set your own price limit.','auction',4),

('Tenderdən nə qədər sonra ödəniş edilməlidir?','Когда нужно оплатить после торгов?','How soon after winning do I need to pay?',
'Lot qazanıldıqdan sonra adətən 1–3 iş günü ərzində ödəniş tələb olunur.','После выигрыша лота оплата обычно требуется в течение 1–3 рабочих дней.','After winning a lot, payment is usually required within 1–3 business days.','auction',5),

('Yalnız zərərli avtomobil gətirirsinizmi?','Вы привозите только повреждённые автомобили?','Do you only import damaged vehicles?',
'Xeyr. Zərərli (salvage) avtomobillərlə yanaşı, clean title — tam sağlam avtomobillər də gətiririk.','Нет. Помимо повреждённых (salvage), мы привозим и clean title — полностью исправные автомобили.','No. Besides salvage vehicles, we also import clean-title, fully undamaged vehicles.','auction',6),

('Avtomobil Bakıya neçə günə çatır?','За сколько дней автомобиль доедет до Баку?','How many days does it take to reach Baku?',
'Orta hesabla 38–55 gün: auksion → liman 5–10 gün, limanda gözləmə 5–10 gün, dəniz yolu 25–35 gün.','В среднем 38–55 дней: аукцион → порт 5–10 дней, ожидание в порту 5–10 дней, морской путь 25–35 дней.','On average 38–55 days: auction to port 5–10 days, port waiting 5–10 days, sea transit 25–35 days.','shipping',1),

('Hansı limanlardan daşıma edilir?','Из каких портов осуществляется доставка?','Which ports are used for shipping?',
'ABŞ tərəfindən Baltimore, Houston, Los Angeles, New Jersey, Savannah, Seattle. Koreya üçün Busan. Gəliş: Poti (Gürcüstan) və ya Bakı Limanı.','Со стороны США: Балтимор, Хьюстон, Лос-Анджелес, Нью-Джерси, Саванна, Сиэтл. Для Кореи — Пусан. Прибытие: Поти (Грузия) или порт Баку.','From the US: Baltimore, Houston, Los Angeles, New Jersey, Savannah, Seattle. For Korea: Busan. Arrival: Poti (Georgia) or Baku Port.','shipping',2),

('Daşıma zamanı avtomobil sığortalıdırmı?','Застрахован ли автомобиль при доставке?','Is the vehicle insured during shipping?',
'Bəli, tam dəniz sığortası daxildir. Yanğın, su basması, qəza — sığorta tərəfindən ödənilir.','Да, включена полная морская страховка. Пожар, затопление, авария — покрывается страховкой.','Yes, full marine insurance is included. Fire, flooding, and accidents are covered by insurance.','shipping',3),

('Avtomobilimi real vaxtda izləyə bilərəmmi?','Могу ли я отслеживать автомобиль в реальном времени?','Can I track my vehicle in real time?',
'Bəli. Gəmi şirkəti tracking nömrəsi verir. Komandamız hər mərhələdə WhatsApp ilə məlumatlandırır.','Да. Судоходная компания предоставляет трекинг-номер. Наша команда информирует на каждом этапе через WhatsApp.','Yes. The shipping line provides a tracking number, and our team updates you at every stage via WhatsApp.','shipping',4),

('Poti yoxsa Bakı limanı — hansı daha yaxşıdır?','Поти или порт Баку — что лучше?','Poti or Baku port — which is better?',
'Poti — daha sürətli və $300–$500 daha ucuz. Bakı Limanı — birbaşa, amma daha baha. Biz Potini tövsiyə edirik.','Поти — быстрее и на $300–500 дешевле. Порт Баку — напрямую, но дороже. Мы рекомендуем Поти.','Poti is faster and $300–500 cheaper. Baku Port is direct but more expensive. We recommend Poti.','shipping',5),

('Avtomobil konteynerə necə yüklənir?','Как автомобиль загружается в контейнер?','How is the vehicle loaded into the container?',
'Avtomobil 20 və ya 40 fut konteynerə yerləşdirilir. Kiçik avtomobillər bəzən 2-li yüklənir. Xüsusi bərkitmə sistemləri ilə sabitlənir.','Автомобиль размещается в 20- или 40-футовом контейнере. Малолитражки иногда грузятся по 2. Фиксируется специальными креплениями.','The vehicle is placed in a 20- or 40-foot container. Small cars are sometimes loaded two at a time and secured with special tie-downs.','shipping',6),

('Gömrük vergisi nə qədərdir?','Сколько составляет таможенная пошлина?','How much is the customs duty?',
'Avtomobilin yaşı və mühərrik həcminə görə hesablanır: 1–3 il ~15–20%, 4–7 il ~20–25%, 7+ il ~25–30%. Elektrik avtomobillər 50% güzəşt.','Рассчитывается по возрасту и объёму двигателя: 1–3 года ~15–20%, 4–7 лет ~20–25%, 7+ лет ~25–30%. Электромобили — льгота 50%.','Calculated by vehicle age and engine size: 1–3 years ~15–20%, 4–7 years ~20–25%, 7+ years ~25–30%. Electric vehicles get a 50% discount.','customs',1),

('Gömrük prosesi necə işləyir?','Как проходит таможенный процесс?','How does the customs process work?',
'Avtomobil limana çatdıqdan sonra gömrük bəyannaməsi verilir. Komandamız bütün sənədləri hazırlayır.','После прибытия автомобиля в порт подаётся таможенная декларация. Наша команда готовит все документы.','After the vehicle arrives at port, a customs declaration is filed. Our team prepares all the paperwork.','customs',2),

('Gömrük neçə günə tamamlanır?','За сколько дней завершается таможня?','How many days does customs clearance take?',
'Sənədlər tam olduqda adətən 1–3 iş günü.','При полном комплекте документов обычно 1–3 рабочих дня.','With complete documents, usually 1–3 business days.','customs',3),

('Salvage title olan avtomobil qeydiyyata alınırmı?','Регистрируется ли авто с salvage title?','Can a salvage-title vehicle be registered?',
'Bəli. Gömrükdən sonra avtomobil texniki baxışdan keçirilir. Standartlara cavab verdikdə qeydiyyat rəsmiləşdirilir.','Да. После таможни автомобиль проходит техосмотр. При соответствии стандартам оформляется регистрация.','Yes. After customs, the vehicle undergoes a technical inspection, and registration is issued if it meets standards.','customs',4),

('Hansı sənədlər tələb olunur?','Какие документы требуются?','What documents are required?',
'Müştəridən: şəxsiyyət vəsiqəsi, FİN kod, ünvan. Title, Bill of Lading, sığorta və bəyannamə bizim tərəfimizdən hazırlanır.','От клиента: удостоверение личности, FIN-код, адрес. Title, Bill of Lading, страховка и декларация готовятся нами.','From the client: ID, FIN code, address. Title, Bill of Lading, insurance and declaration are prepared by us.','customs',5),

('Ümumi xərclərə nələr daxildir?','Что входит в общие расходы?','What is included in the total cost?',
'Auksion lot qiyməti, buyer fee (5–12%), ABŞ daxili daşıma, dəniz daşıma, sığorta, gömrük.','Цена лота, комиссия аукциона (5–12%), доставка по США, морская доставка, страховка, таможня.','Lot price, buyer fee (5–12%), US inland shipping, ocean shipping, insurance, customs.','price',1),

('Kalkulyator nə dərəcədə dəqiqdir?','Насколько точен калькулятор?','How accurate is the calculator?',
'Kalkulyator təxmini rəqəm verir — ±10–15% fərq ola bilər.','Калькулятор даёт приблизительную цифру — возможна разница ±10–15%.','The calculator gives an estimate — actual price may vary by ±10–15%.','price',2),

('Ödəniş necə edilir?','Как производится оплата?','How is payment made?',
'Adətən 2 mərhələdə: ilkin ödəniş (tenderdən əvvəl) + son ödəniş (Bakıya gəldikdə). Bank köçürməsi, nağd və kart qəbul edilir.','Обычно в 2 этапа: предоплата (до торгов) + окончательный расчёт (по прибытии в Баку). Принимаем банковский перевод, наличные и карту.','Usually in 2 stages: deposit (before bidding) + final payment (on arrival in Baku). We accept bank transfer, cash and card.','price',3),

('Neçə illik avtomobillər gətirilir?','Автомобили каких годов вы привозите?','What model years do you import?',
'Heç bir il məhdudiyyəti yoxdur. Lakin gömrük vergisi üçün avtomobilin yaşı vacibdir.','Ограничений по годам нет. Однако возраст автомобиля важен для расчёта таможенной пошлины.','There is no year restriction, though vehicle age affects the customs duty calculation.','price',4),

('VIN nömrəsi ilə nə yoxlamaq olar?','Что можно проверить по VIN-номеру?','What can be checked using the VIN number?',
'Qəza tarixi, odometer qeydi, əvvəlki sahiblər, servis tarixi, title növü, recall statusu.','История аварий, показания одометра, предыдущие владельцы, история обслуживания, тип title, статус отзывов.','Accident history, odometer readings, previous owners, service history, title type, and recall status.','tech',1),

('Elektrik avtomobilləri gətirmək mümkündürmü?','Можно ли привезти электромобиль?','Can you import electric vehicles?',
'Bəli, Tesla, Rivian, Lucid gətiririk. Batareya vəziyyəti yoxlanmalıdır, gömrükdə ~50% güzəşt var.','Да, привозим Tesla, Rivian, Lucid. Нужно проверить состояние батареи, на таможне льгота ~50%.','Yes, we import Tesla, Rivian, Lucid. Battery condition should be checked; customs offers a ~50% discount.','tech',2),

('Zərərli avtomobili bərpa etmək nə qədər başa gəlir?','Сколько стоит восстановление повреждённого авто?','How much does repairing a damaged vehicle cost?',
'Yüngül: 500–1,500 AZN. Orta: 2,000–5,000 AZN. Ağır: 5,000–12,000 AZN.','Лёгкие: 500–1,500 AZN. Средние: 2,000–5,000 AZN. Тяжёлые: 5,000–12,000 AZN.','Light: 500–1,500 AZN. Medium: 2,000–5,000 AZN. Heavy: 5,000–12,000 AZN.','tech',3),

('Avtomobil gözlədiyimdən fərqlidirsə nə etmək olar?','Что делать, если автомобиль отличается от ожидаемого?','What if the car is different from what I expected?',
'Auksion alışları geri qaytarılmır. Buna görə tenderdən əvvəl şəkilləri və VIN tarixçəsini diqqətlə yoxlayın.','Аукционные покупки возврату не подлежат. Поэтому внимательно проверяйте фото и историю VIN до торгов.','Auction purchases are non-refundable, so carefully review photos and VIN history before bidding.','tech',4);
