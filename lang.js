// AzBaku AutoImport — Language Switcher
// Bütün səhifələrdə <script src="lang.js"></script> əlavə edin
(function(){
  var T = {
    // === COMMON (header, footer, nav) ===
    'nav-about':'Haqqımızda','nav-about-ru':'О нас',
    'nav-examples':'Nümunələr','nav-examples-ru':'Примеры',
    'nav-request':'Sifariş ver','nav-request-ru':'Заказать',
    'nav-calc':'Kalkulyator','nav-calc-ru':'Калькулятор',
    'nav-faq':'FAQ','nav-faq-ru':'FAQ',
    'nav-contact':'Əlaqə','nav-contact-ru':'Контакт',
    'header-cta':'Sifariş ver','header-cta-ru':'Заказать',
    'foot-desc':'ABŞ və Kanada auksionlarından Azərbaycana sifarişlə avtomobil idxalı.',
    'foot-desc-ru':'Импорт автомобилей из аукционов США и Канады в Азербайджан.',
    'foot-nav':'Naviqasiya','foot-nav-ru':'Навигация',
    'foot-contact':'Əlaqə','foot-contact-ru':'Контакт',
    'foot-social':'Sosial','foot-social-ru':'Соцсети',
    'foot-copy':'Şəffaf idxal, etibarlı proses.','foot-copy-ru':'Прозрачный импорт, надёжный процесс.',

    // === INDEX.HTML ===
    'hero-h1':'Siz sifariş verin,<br><em>biz tapıb gətirək.</em>',
    'hero-h1-ru':'Вы заказываете,<br><em>мы находим и доставляем.</em>',
    'hero-lead':'Sizin üçün ABŞ və Kanada auksionlarından dəqiq istədiyiniz avtomobili axtarır, alır və Bakıya qədər sığortalı çatdırırıq.',
    'hero-lead-ru':'Мы ищем, покупаем и доставляем именно тот автомобиль, который вы хотите, с аукционов США и Канады до Баку со страховкой.',
    'hero-btn1':'Sifariş ver ›','hero-btn1-ru':'Заказать ›',
    'hero-btn2':'Nümunələrə bax','hero-btn2-ru':'Примеры',
    'trust-1':'500+','trust-1-lbl':'uğurlu idxal','trust-1-lbl-ru':'успешных импортов',
    'trust-2':'38–45 gün','trust-2-lbl':'orta müddət','trust-2-lbl-ru':'средний срок',
    'trust-3-lbl':'Sığortalı','trust-3-lbl-ru':'Застрахованная','trust-3-sub':'daşınma','trust-3-sub-ru':'доставка',
    'trust-4-lbl':'Gizli xərc yoxdur','trust-4-lbl-ru':'Без скрытых расходов',
    'process-eye':'Prosesimiz','process-eye-ru':'Наш процесс',
    'process-h2':'Auksiondan qapınıza qədər','process-h2-ru':'От аукциона до вашей двери',
    'process-sub':'Hər addımda sizə məlumat veririk — avtomobili görmədən pul ödəmək narahatedicidir.',
    'process-sub-ru':'Мы информируем вас на каждом этапе — платить за машину, не видя её, вызывает беспокойство.',
    'step1':'Sifariş','step1-ru':'Заказ','step1-d':'Marka, model, il və büdcənizi bildirin','step1-d-ru':'Укажите марку, модель, год и бюджет',
    'step2':'Auksion','step2-ru':'Аукцион','step2-d':'Copart, IAAI daxil olmaqla uyğun lotu tapırıq','step2-d-ru':'Находим подходящий лот на Copart, IAAI и др.',
    'step3':'Alış','step3-ru':'Покупка','step3-d':'Sizin təsdiqinizlə avtomobili qazanırıq','step3-d-ru':'Выигрываем автомобиль с вашего подтверждения',
    'step4':'Daşınma','step4-ru':'Доставка','step4-d':'Sığortalı konteyner ilə Bakı limanına','step4-d-ru':'Застрахованная контейнерная доставка в порт Баку',
    'step5':'Təhvil','step5-ru':'Передача','step5-d':'Gömrükdən keçir, açarlar sizdədir','step5-d-ru':'Таможня пройдена, ключи у вас',
    'cases-eye':'Sübut','cases-eye-ru':'Доказательство',
    'cases-h2':'Bunları biz artıq gətirmişik','cases-h2-ru':'Мы уже привезли эти автомобили',
    'cases-sub':'Real qiymət və müddətlərlə keçmiş sifarişlər.','cases-sub-ru':'Прошлые заказы с реальными ценами и сроками.',
    'cases-btn':'Bütün nümunələrə bax →','cases-btn-ru':'Все примеры →',
    'paths-eye':'İki yol','paths-eye-ru':'Два пути',
    'paths-h2':'Necə başlamaq istəyirsiniz?','paths-h2-ru':'Как вы хотите начать?',
    'path1-h':'Dəqiq sifariş verin','path1-h-ru':'Сделайте точный заказ',
    'path1-p':'Marka, model, il və büdcənizi bildirin. 24 saat ərzində uyğun variantlarla sizinlə əlaqə saxlayırıq.',
    'path1-p-ru':'Укажите марку, модель, год и бюджет. Мы свяжемся с вами в течение 24 часов с подходящими вариантами.',
    'path1-btn':'Sifariş formasını doldur','path1-btn-ru':'Заполнить форму заказа',
    'path2-h':'Auksion nümunələrinə baxın','path2-h-ru':'Посмотрите примеры аукционов',
    'path2-p':'Hazırda auksionlarda olan seçilmiş lotlara baxın, bəyəndiyinizi bizə göstərin.',
    'path2-p-ru':'Посмотрите выбранные лоты на аукционах, покажите нам понравившийся.',
    'path2-btn':'Nümunə lotlara bax','path2-btn-ru':'Посмотреть лоты',
    'why-eye':'Niyə AzBaku','why-eye-ru':'Почему AzBaku',
    'why-h2':'Stokumuz yoxdur. Etibarımız var.','why-h2-ru':'У нас нет склада. У нас есть доверие.',
    'why1-h':'Gizli xərc yoxdur','why1-h-ru':'Без скрытых расходов',
    'why1-p':'Auksion, daşınma, gömrük və xidmət haqqı ayrıca göstərilir.','why1-p-ru':'Аукцион, доставка, таможня и сервисный сбор указаны отдельно.',
    'why2-h':'Təsdiqsiz alış yoxdur','why2-h-ru':'Без покупки без подтверждения',
    'why2-p':'Heç bir lot sizin razılığınız olmadan qazanılmır.','why2-p-ru':'Ни один лот не выигрывается без вашего согласия.',
    'why3-h':'Real keçmiş sifarişlər','why3-h-ru':'Реальные прошлые заказы',
    'why3-p':'Hər nümunə real qiymət və müddətlə göstərilir.','why3-p-ru':'Каждый пример показан с реальной ценой и сроком.',
    'cta-eye':'Hazırsınız?','cta-eye-ru':'Готовы?',
    'cta-h2':'Hansı avtomobili axtarırsınız?','cta-h2-ru':'Какой автомобиль вы ищете?',
    'cta-p':'Formanı doldurun, 24 saat ərzində uyğun variantlarla geri dönüş edək.',
    'cta-p-ru':'Заполните форму, мы свяжемся с вами в течение 24 часов с подходящими вариантами.',
    'cta-btn1':'Sifariş ver','cta-btn1-ru':'Заказать',
    'cta-btn2':'Zəng edin','cta-btn2-ru':'Позвонить',
    'case-price':'Yekun qiymət','case-price-ru':'Итоговая цена',
    'case-days':'Müddət','case-days-ru':'Срок',
    'delivered':'Təhvil verildi','delivered-ru':'Доставлено'
  };

  var currentLang = localStorage.getItem('azbaku_lang') || 'az';

  function applyLang(lang){
    currentLang = lang;
    localStorage.setItem('azbaku_lang', lang);
    document.querySelectorAll('[data-i18n]').forEach(function(el){
      var key = el.getAttribute('data-i18n');
      var text = lang === 'ru' ? (T[key+'-ru'] || T[key] || '') : (T[key] || '');
      if(text) el.innerHTML = text;
    });
    // Update flag button
    var flagBtn = document.getElementById('langToggle');
    if(flagBtn){
      flagBtn.innerHTML = lang === 'az'
        ? '<img src="https://flagcdn.com/24x18/ru.png" alt="RU" style="width:20px;height:14px;border-radius:2px;vertical-align:middle;"> RU'
        : '<img src="https://flagcdn.com/24x18/az.png" alt="AZ" style="width:20px;height:14px;border-radius:2px;vertical-align:middle;"> AZ';
    }
    document.documentElement.lang = lang;
  }

  // Auto-init on DOM ready
  function init(){
    var flagBtn = document.getElementById('langToggle');
    if(flagBtn){
      flagBtn.addEventListener('click', function(){
        applyLang(currentLang === 'az' ? 'ru' : 'az');
      });
    }
    if(currentLang === 'ru') applyLang('ru');
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Expose for other scripts
  window.azbakuLang = {apply: applyLang, get: function(){return currentLang;}, T: T};

  // === CALCULATOR ===
  T['calc-eye']='Qiymət hesablama';T['calc-eye-ru']='Расчёт стоимости';
  T['calc-h1']='Daşınma Kalkulyatoru';T['calc-h1-ru']='Калькулятор доставки';
  T['calc-sub']='Auksiondan Bakıya qədər təxmini xərci hesablayın — nəticə dərhal görünəcək.';
  T['calc-sub-ru']='Рассчитайте примерную стоимость доставки от аукциона до Баку — результат появится мгновенно.';
  T['calc-h3']='Kalkulyator';T['calc-h3-ru']='Калькулятор';
  T['calc-desc']='Sahələri doldurun, qiymət avtomatik hesablanacaq';T['calc-desc-ru']='Заполните поля, цена рассчитается автоматически';
  T['calc-s1']='Auksion platformu';T['calc-s1-ru']='Аукционная площадка';
  T['calc-s2']='Lokasiya (ştat/ölkə)';T['calc-s2-ru']='Локация (штат/страна)';
  T['calc-s3']='Yükləmə portu';T['calc-s3-ru']='Порт погрузки';
  T['calc-s4']='Auksion qiyməti ($)';T['calc-s4-ru']='Цена на аукционе ($)';
  T['calc-s5']='Kateqoriya';T['calc-s5-ru']='Категория';
  T['calc-s6']='Çatdırılma portu';T['calc-s6-ru']='Порт доставки';
  T['calc-s7']='Buraxılış ili';T['calc-s7-ru']='Год выпуска';
  T['calc-reset']='↺ Sıfırla';T['calc-reset-ru']='↺ Сбросить';
  T['r-h3']='Qiymət bölgüsü';T['r-h3-ru']='Разбивка стоимости';
  T['r-auction']='Auksion qiyməti';T['r-auction-ru']='Цена на аукционе';
  T['r-fee']='Buyer fee';T['r-fee-ru']='Комиссия аукциона';
  T['r-inland']='ABŞ daxili daşınma';T['r-inland-ru']='Доставка по США';
  T['r-ocean']='Dəniz daşınması';T['r-ocean-ru']='Морская доставка';
  T['r-customs']='Gömrük rüsumu (~)';T['r-customs-ru']='Таможенная пошлина (~)';
  T['r-service']='AzBaku xidmət haqqı';T['r-service-ru']='Сервисный сбор AzBaku';
  T['r-total-lbl']='Yekun (təxmini)';T['r-total-lbl-ru']='Итого (примерно)';
  T['r-note']='Bu rəqəmlər təxminidir (±10–15%). Dəqiq qiymət üçün bizimlə əlaqə saxlayın.';
  T['r-note-ru']='Эти цифры приблизительные (±10–15%). Для точной цены свяжитесь с нами.';
  T['r-cta']='Sifariş ver — dəqiq qiymət al';T['r-cta-ru']='Заказать — получить точную цену';
  T['info1-h']='Poti daha sərfəlidir';T['info1-h-ru']='Поти выгоднее';
  T['info1-p']='Poti portu vasitəsilə daşıma adətən daha sürətli və ucuzdur.';T['info1-p-ru']='Доставка через порт Поти обычно быстрее и дешевле.';
  T['info2-h']='EV güzəştləri';T['info2-h-ru']='Льготы для EV';
  T['info2-p']='Elektrik avtomobillər üçün gömrük rüsumunda xüsusi güzəştlər var.';T['info2-p-ru']='Для электромобилей действуют специальные таможенные льготы.';
  T['info3-h']='2–3 illik avtomobillər';T['info3-h-ru']='Автомобили 2–3 лет';
  T['info3-p']='Bu yaş aralığı gömrük baxımından ən əlverişlidir.';T['info3-p-ru']='Этот возрастной диапазон наиболее выгоден по таможне.';

  // === FAQ ===
  T['faq-eye']='Tez-tez verilən suallar';T['faq-eye-ru']='Часто задаваемые вопросы';
  T['faq-h1']='Suallarınıza Cavablar';T['faq-h1-ru']='Ответы на ваши вопросы';
  T['faq-sub']='Auksion prosesindən gömrük rəsmiləşdirilməsinə qədər hər şeyi burada izah edirik.';
  T['faq-sub-ru']='Здесь мы объясняем всё — от процесса аукциона до таможенного оформления.';
  T['faq-cta-h']='Sualınız Cavablanmadımı?';T['faq-cta-h-ru']='Не нашли ответ?';
  T['faq-cta-p']='Komandamız hər sualınıza cavab vermək üçün hazırdır.';T['faq-cta-p-ru']='Наша команда готова ответить на любой ваш вопрос.';

  // === ABOUT ===
  T['about-eye']='Biz kimik';T['about-eye-ru']='Кто мы';
  T['about-h1']='AzBaku AutoImport';
  T['about-sub']='ABŞ və Kanada auksionlarından Azərbaycana avtomobil gətirən etibarlı tərəfdaşınız.';
  T['about-sub-ru']='Ваш надёжный партнёр по импорту автомобилей из аукционов США и Канады в Азербайджан.';
  T['about-story-eye']='Hekayəmiz';T['about-story-eye-ru']='Наша история';
  T['about-story-h']='Şəffaflıq üzərinə qurulmuş biznes';T['about-story-h-ru']='Бизнес, построенный на прозрачности';
  T['about-values-eye']='Dəyərlərimiz';T['about-values-eye-ru']='Наши ценности';
  T['about-values-h']='Niyə AzBaku?';T['about-values-h-ru']='Почему AzBaku?';
  T['about-cta-eye']='Hazırsınız?';T['about-cta-eye-ru']='Готовы?';
  T['about-cta-h']='Gəlin birlikdə başlayaq';T['about-cta-h-ru']='Давайте начнём вместе';

  // === REQUEST ===
  T['req-eye']='2 dəqiqə çəkir';T['req-eye-ru']='Займёт 2 минуты';
  T['req-h1']='Hansı avtomobili axtarırsınız?';T['req-h1-ru']='Какой автомобиль вы ищете?';
  T['req-sub']='Heç nə ödəmirsiniz — bu, sadəcə axtarış sorğusudur.';T['req-sub-ru']='Вы ничего не платите — это просто поисковый запрос.';
  T['req-submit']='Sorğunu göndər';T['req-submit-ru']='Отправить запрос';

  // === EXAMPLES ===
  T['ex-eye']='Real idxal nümunələri';T['ex-eye-ru']='Реальные примеры импорта';
  T['ex-h1']='Bunları biz artıq gətirmişik';T['ex-h1-ru']='Мы уже привезли эти автомобили';
  T['ex-sub']='Hər nümunə real ölkədən, real qiymətlə göstərilir. Üzərinə klikləyərək tam bölgüyə baxın.';
  T['ex-sub-ru']='Каждый пример показан из реальной страны, по реальной цене. Нажмите для полной разбивки.';
})();
