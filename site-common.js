// AzBaku AutoImport — Ümumi CMS tətbiqi
// Admin paneldə dəyişdirilə bilən bütün mətnləri (naviqasiya, telefon,
// Haqqımızda kartları, FAQ başlığı, sifariş forması sahələri, kalkulyator
// addımları) bazadan çəkib səhifəyə tətbiq edir. Bütün 7 səhifədə eyni fayl.
(function(){
  function setByI18n(key, value){
    if (!value) return;
    document.querySelectorAll('[data-i18n="'+key+'"]').forEach(function(el){
      el.textContent = value;
    });
  }
  function setById(id, value){
    if (!value) return;
    var el = document.getElementById(id);
    if (el) el.textContent = value;
  }
  function setByClass(cls, value){
    if (!value) return;
    document.querySelectorAll('.'+cls).forEach(function(el){
      el.textContent = value;
    });
  }
  function setPlaceholder(key, value){
    if (!value) return;
    document.querySelectorAll('[data-i18n="'+key+'"]').forEach(function(el){
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = value;
      else el.textContent = value;
    });
  }

  fetch('api/settings.php').then(function(r){ return r.json(); }).then(function(s){
    if (!s) return;

    // Naviqasiya sözləri (header + mobil menyu + footer — hamısı eyni data-i18n paylaşır)
    setByI18n('nav-home', s.nav_home);
    setByI18n('nav-about', s.nav_about);
    setByI18n('nav-examples', s.nav_examples);
    setByI18n('nav-request', s.nav_request);
    setByI18n('nav-calc', s.nav_calc);
    setByI18n('nav-faq', s.nav_faq);
    setByI18n('nav-vin', s.nav_vin);
    setByI18n('nav-contact', s.nav_contact);

    // Telefon (topbar + footer + digər görünən yerlər)
    setByClass('phone-display', s.hdr_phone);

    // Qırmızı "Sifariş ver" CTA düyməsi — nav-request-dən AYRI, öz ID-si ilə
    // (nav sözünü YAZDIQDAN sonra tətbiq olunur ki, üstünlük ona qalsın)
    setById('headerCtaBtn', s.hdr_cta);

    // Haqqımızda — 6 dəyər kartı
    setByI18n('ab-v1-h', s.ab_v1_h); setByI18n('ab-v1-p', s.ab_v1_p);
    setByI18n('ab-v2-h', s.ab_v2_h); setByI18n('ab-v2-p', s.ab_v2_p);
    setByI18n('ab-v3-h', s.ab_v3_h); setByI18n('ab-v3-p', s.ab_v3_p);
    setByI18n('ab-v4-h', s.ab_v4_h); setByI18n('ab-v4-p', s.ab_v4_p);
    setByI18n('ab-v5-h', s.ab_v5_h); setByI18n('ab-v5-p', s.ab_v5_p);
    setByI18n('ab-v6-h', s.ab_v6_h); setByI18n('ab-v6-p', s.ab_v6_p);

    // FAQ səhifə başlığı
    setByI18n('faq-h1', s.faq_h1);
    setByI18n('faq-sub', s.faq_sub);

    // Sifariş ver formasının sahə etiketləri
    setByI18n('req-make', s.rq_lbl_make);
    setByI18n('req-model', s.rq_lbl_model);
    setByI18n('req-name', s.rq_lbl_name);
    setByI18n('req-phone', s.rq_lbl_phone);

    // Kalkulyator addım etiketləri
    setByI18n('calc-s1', s.calc_s1);
    setByI18n('calc-s2', s.calc_s2);
    setByI18n('calc-s3', s.calc_s3);
    setByI18n('calc-s4', s.calc_s4);
    setByI18n('calc-s5', s.calc_s5);

    // ===== Bütün digər mətnlər (144 ədəd, avtomatik) =====
    // Admin paneldəki "Bütün Mətnlər" tabındakı hər sahə "txt_" prefiksi ilə
    // saxlanılır; buradan geriyə (data-i18n açarına) çevrilib tətbiq olunur.
    Object.keys(s).forEach(function(settingKey){
      if (settingKey.indexOf('txt_') === 0) {
        var i18nKey = settingKey.slice(4).replace(/_/g, '-');
        setByI18n(i18nKey, s[settingKey]);
      }
    });

    // Digər skriptlərin (kalkulyator auksion adları və s.) istifadə edə bilməsi üçün
    window.azbakuSettings = s;
    window.dispatchEvent(new CustomEvent('azbaku-settings-ready', {detail: s}));
  }).catch(function(){});
})();
