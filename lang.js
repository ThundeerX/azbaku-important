// AzBaku AutoImport — AI avtomatik tərcümə (AZ / RU / EN)
// Səhifədəki BÜTÜN mətn AI tərəfindən tərcümə olunur, nəticə serverdə keşlənir
(function(){
  var lang = localStorage.getItem('azbaku_lang') || 'az';
  var originals = new WeakMap();
  var SKIP = ['SCRIPT','STYLE','NOSCRIPT','CODE','IFRAME','IMG','BR','HR'];

  function isSkippable(el){
    if (SKIP.indexOf(el.tagName) > -1) return true;
    if (el.closest && el.closest('.lang-switch')) return true;
    if (el.hasAttribute && el.hasAttribute('data-no-translate')) return true;
    return false;
  }

  function collectNodes(){
    var nodes = [];
    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_ELEMENT, {
      acceptNode: function(el){
        if (isSkippable(el)) return NodeFilter.FILTER_REJECT;
        var hasText = false;
        for (var i=0;i<el.childNodes.length;i++){
          var n = el.childNodes[i];
          if (n.nodeType === 3 && n.textContent.trim().length > 1) { hasText = true; break; }
        }
        return hasText ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
      }
    });
    var el;
    while (el = walker.nextNode()) {
      if (!originals.has(el)) originals.set(el, el.innerHTML);
      nodes.push(el);
    }
    document.querySelectorAll('input[placeholder],textarea[placeholder]').forEach(function(inp){
      if (!inp.dataset.origPh) inp.dataset.origPh = inp.placeholder;
      nodes.push(inp);
    });
    document.querySelectorAll('option').forEach(function(o){
      if (!o.dataset.origTxt) o.dataset.origTxt = o.textContent;
      nodes.push(o);
    });
    return nodes;
  }

  function restoreAZ(nodes){
    nodes.forEach(function(el){
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        if (el.dataset.origPh) el.placeholder = el.dataset.origPh;
      } else if (el.tagName === 'OPTION') {
        if (el.dataset.origTxt) el.textContent = el.dataset.origTxt;
      } else if (originals.has(el)) {
        el.innerHTML = originals.get(el);
      }
    });
  }

  function loader(on){
    var l = document.getElementById('langLoader');
    if (on && !l) {
      l = document.createElement('div');
      l.id = 'langLoader';
      l.style.cssText = 'position:fixed;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#002B8A,#D7263D);z-index:9999;animation:lb 1.2s ease-in-out infinite;';
      var st = document.createElement('style');
      st.textContent = '@keyframes lb{0%{opacity:.35}50%{opacity:1}100%{opacity:.35}}';
      document.head.appendChild(st);
      document.body.appendChild(l);
    } else if (!on && l) { l.remove(); }
  }

  function applyLang(target){
    lang = target;
    localStorage.setItem('azbaku_lang', target);
    updateButtons();
    document.documentElement.lang = target;

    var nodes = collectNodes();
    if (target === 'az') { restoreAZ(nodes); return; }

    var texts = [], map = [];
    nodes.forEach(function(el){
      var src;
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') src = el.dataset.origPh;
      else if (el.tagName === 'OPTION') src = el.dataset.origTxt;
      else src = originals.get(el);
      if (!src) return;
      src = src.trim();
      if (src.length < 2) return;
      if (/^[\d\s$₼€.,%+\-–—:()\/]+$/.test(src)) return;
      texts.push(src);
      map.push({el: el, src: src});
    });
    if (!texts.length) return;

    loader(true);
    fetch('api/translate.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({texts: Array.from(new Set(texts)), target: target})
    })
    .then(function(r){ return r.json(); })
    .then(function(dict){
      loader(false);
      if (!dict || dict.error) return;
      map.forEach(function(m){
        var tr = dict[m.src];
        if (!tr) return;
        if (m.el.tagName === 'INPUT' || m.el.tagName === 'TEXTAREA') m.el.placeholder = tr;
        else if (m.el.tagName === 'OPTION') m.el.textContent = tr;
        else m.el.innerHTML = tr;
      });
    })
    .catch(function(){ loader(false); });
  }

  function updateButtons(){
    document.querySelectorAll('.lang-btn[data-lang]').forEach(function(b){
      b.classList.toggle('active', b.dataset.lang === lang);
    });
  }

  function buildSwitcher(){
    var old = document.getElementById('langToggle');
    if (!old) return;
    var wrap = document.createElement('div');
    wrap.className = 'lang-switch';
    wrap.innerHTML =
      '<button class="lang-btn" data-lang="az" title="Azerbaijani"><img src="https://flagcdn.com/24x18/az.png" alt="AZ">AZ</button>'+
      '<button class="lang-btn" data-lang="ru" title="Russian"><img src="https://flagcdn.com/24x18/ru.png" alt="RU">RU</button>'+
      '<button class="lang-btn" data-lang="en" title="English"><img src="https://flagcdn.com/24x18/gb.png" alt="EN">EN</button>';
    old.parentNode.replaceChild(wrap, old);

    wrap.querySelectorAll('.lang-btn').forEach(function(b){
      b.addEventListener('click', function(){
        if (b.dataset.lang === lang) return;
        applyLang(b.dataset.lang);
      });
    });

    var st = document.createElement('style');
    st.textContent =
      '.lang-switch{display:flex;gap:2px;background:#fff;border:1.5px solid #E1E5E8;border-radius:8px;padding:3px;flex-shrink:0;}'+
      '.lang-btn{display:flex;align-items:center;gap:4px;padding:5px 8px;border:none;background:transparent;border-radius:5px;font-size:11px;font-weight:700;color:#5B6672;cursor:pointer;font-family:inherit;line-height:1;}'+
      '.lang-btn img{width:16px;height:12px;border-radius:2px;display:block;}'+
      '.lang-btn:hover{background:#F5F7F9;color:#002B8A;}'+
      '.lang-btn.active{background:#002B8A;color:#fff;}'+
      '@media(max-width:768px){.lang-btn{font-size:10px;padding:4px 5px;gap:3px;}.lang-btn img{width:14px;height:10px;}}';
    document.head.appendChild(st);
  }

  function init(){
    buildSwitcher();
    updateButtons();
    if (lang !== 'az') setTimeout(function(){ applyLang(lang); }, 400);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();

  // Dinamik məzmun (FAQ, nümunələr) yükləndikdən sonra
  window.addEventListener('contentloaded', function(){
    if (lang !== 'az') setTimeout(function(){ applyLang(lang); }, 150);
  });

  window.azbakuLang = { apply: applyLang, get: function(){ return lang; } };
})();
