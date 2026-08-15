// AzBaku AutoImport — 3 dilli tərcümə sistemi (AZ / RU / EN)
// Google Translate ilə BÜTÜN mətni avtomatik tərcümə edir
(function(){
  var langs = ['az','ru','en'];
  var flags = {
    az: {img:'https://flagcdn.com/24x18/az.png', label:'AZ'},
    ru: {img:'https://flagcdn.com/24x18/ru.png', label:'RU'},
    en: {img:'https://flagcdn.com/24x18/gb.png', label:'EN'}
  };
  var current = localStorage.getItem('azbaku_lang') || 'az';

  // Google Translate init
  function loadGoogleTranslate(){
    window.googleTranslateElementInit = function(){
      new google.translate.TranslateElement({
        pageLanguage: 'az',
        includedLanguages: 'az,ru,en',
        autoDisplay: false
      }, 'gtranslate');
    };
    var s = document.createElement('script');
    s.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    document.head.appendChild(s);
  }

  function setLang(lang){
    current = lang;
    localStorage.setItem('azbaku_lang', lang);
    updateButton();

    // Google Translate-i işə sal
    var iframe = document.querySelector('.goog-te-menu-frame');
    if(iframe){
      var doc = iframe.contentDocument || iframe.contentWindow.document;
      var links = doc.querySelectorAll('.goog-te-menu2-item span.text');
      links.forEach(function(a){
        var txt = a.textContent.toLowerCase();
        if(lang === 'az' && (txt.includes('azerba') || txt.includes('azərba'))){a.click();}
        else if(lang === 'ru' && (txt.includes('русс') || txt.includes('russia'))){a.click();}
        else if(lang === 'en' && (txt.includes('engli'))){a.click();}
      });
    } else {
      // Fallback — cookie ilə dil təyin et
      var code = lang === 'az' ? 'az' : lang === 'ru' ? 'ru' : 'en';
      document.cookie = 'googtrans=/az/'+code+';path=/;';
      document.cookie = 'googtrans=/az/'+code+';path=/;domain=.'+window.location.hostname+';';
      if(lang !== 'az'){
        // Səhifəni yenilə ki, tərcümə tətbiq olunsun
        setTimeout(function(){location.reload();}, 100);
      } else {
        // AZ-a qayıdanda Google Translate-i söndür
        document.cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 UTC;';
        document.cookie = 'googtrans=;path=/;domain=.'+window.location.hostname+';expires=Thu, 01 Jan 1970 00:00:00 UTC;';
        setTimeout(function(){location.reload();}, 100);
      }
    }
  }

  function nextLang(){
    var idx = langs.indexOf(current);
    var next = langs[(idx + 1) % langs.length];
    setLang(next);
  }

  function updateButton(){
    var btn = document.getElementById('langToggle');
    if(!btn) return;
    // Növbəti dili göstər (basanda nəyə keçəcəyini)
    var nextIdx = (langs.indexOf(current) + 1) % langs.length;
    var next = langs[nextIdx];
    var f = flags[next];
    btn.innerHTML = '<img src="'+f.img+'" style="width:18px;height:13px;border-radius:2px;"> '+f.label;
  }

  function init(){
    // Google Translate elementini yarat (gizli)
    var gtDiv = document.createElement('div');
    gtDiv.id = 'gtranslate';
    gtDiv.style.cssText = 'position:absolute;top:-9999px;left:-9999px;';
    document.body.appendChild(gtDiv);

    // Google Translate skriptini yüklə
    loadGoogleTranslate();

    // Düyməyə click event
    var btn = document.getElementById('langToggle');
    if(btn){
      btn.addEventListener('click', function(e){
        e.preventDefault();
        nextLang();
      });
    }

    // Google Translate-in çirkin zolağını gizlət
    var style = document.createElement('style');
    style.textContent = '.goog-te-banner-frame{display:none !important;} body{top:0 !important;position:static !important;} .goog-te-gadget{display:none !important;} .skiptranslate{display:none !important;} body{top:0 !important;}';
    document.head.appendChild(style);

    updateButton();

    // Əgər cookie-dən dil təyin olunubsa, düyməni uyğunlaşdır
    var cookie = document.cookie.match(/googtrans=\/az\/(\w+)/);
    if(cookie){
      current = cookie[1];
      localStorage.setItem('azbaku_lang', current);
      updateButton();
    }
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
