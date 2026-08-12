# AzBaku AutoImport — Layihə Xülasəsi (AI-dan-AI-ya ötürmə sənədi)

Bu sənəd Claude ilə aparılan bütün söhbətin xülasəsidir. Başqa bir AI alətinə bu faylı verərək, olduğu yerdən davam etdirə bilərsiniz.

---

## Biznes haqqında

- **Ad:** AzBaku AutoImport
- **Fəaliyyət:** Avtomobil idxal brokericiliyi — **öz avtoparkı yoxdur**. Müştərilər ABŞ və Kanada auksionlarından (Copart, IAAI) istədikləri avtomobili sifariş edir, şirkət tapır, alır və Bakıya gətirir.
- **Müştəri seçim yolu:** İki yol — (1) dəqiq sifariş vermə (marka/model/il/büdcə), (2) nümunə auksion lotlarına baxıb seçmə.
- **Brend rəngləri:**
  - Luxury Blue (əsas): `#1B365D`
  - Signal Red (vurğu/CTA): `#D7263D`
  - Chrome Silver: `#C4C9CC`
  - Pure White: `#FFFFFF`
  - Deep Charcoal (mətn): `#1A1A1A`
- **Fontlar:** yalnız 2 font — **Fraunces** (başlıqlar) + **Inter** (hər şey digər)
- **Dil:** Bütün sayt Azərbaycan dilində (AZ)
- **Loqo:** İstifadəçi öz loqosunu yüklədi (`images/logo.png`) — mavi "AB" işarəsi + "AZBAKU AUTOIMPORT" yazısı. **Qeyd: son yükləmə cəhdləri fayl transferi zamanı korlandı, hələ də köhnə/yer tutucu vəziyyətdə ola bilər — yoxlanılmalıdır.**

---

## Texniki stek

- **Frontend:** Xalis HTML/CSS/vanilla JS (heç bir framework yoxdur)
- **Backend:** PHP + MySQL
- **Hosting (planlaşdırılan):** Hostinger (paylaşılan hosting, PHP+MySQL dəstəkli)
- **Domen:** WULZI.AZ-da qeydiyyatdan keçib (.az domen), Vercel-ə DNS A/CNAME qeydləri ilə bağlanmağa çalışılırdı (nameserver metodu deyil, çünki Vercel .az domenlərini birbaşa transfer üçün dəstəkləmir)
- **Hazırkı test mühiti:** İstifadəçinin öz PC-si, XAMPP ilə lokal server (`localhost/azbaku/`)

---

## Fayl strukturu

```
azbaku/
  index.html              ← Ana səhifə
  request.html             ← "Sifariş ver" səhifəsi (form)
  examples.html             ← Bütün nümunələr qalereyası (YENİ)
  example-detail.html       ← Tək nümunənin ətraflı səhifəsi (YENİ)
  admin.html                ← Admin idarəetmə paneli
  images/
    logo.png                 ← İstifadəçinin loqosu
    hero.svg, why-band.svg, cta-band.svg, request-hero.svg, side-photo.svg, case-default.svg  ← yer tutucular (hazırda istifadə OLUNMUR, sayt internetdən Unsplash şəkilləri çəkir)
    cases/case-1.svg, case-2.svg, case-3.svg  ← yer tutucular (istifadə OLUNMUR)
  api/
    config.php              ← DB bağlantı tənzimləmələri (DOLDURULMALIDIR)
    schema.sql               ← İlkin verilənlər bazası sxemi
    migration_cases_detail.sql ← Ölkə/qiymət-bölgüsü sütunlarını əlavə edən miqrasiya (İŞLƏDİLMƏLİDİR)
    content.php               ← Sayt mətni API-si (GET/POST)
    cases.php                  ← Nümunə avtomobillər API-si (GET/POST, ?id= dəstəkləyir)
    submissions.php            ← Müştəri sorğuları API-si (GET/POST)
  DEPLOY_INSTRUCTIONS.md     ← XAMPP lokal quraşdırma + Hostinger yükləmə təlimatı
```

---

## Verilənlər bazası cədvəlləri

**site_content** — sayt mətni (başlıq, alt mətn, telefon)
**car_cases** — nümunə avtomobillər: `id, title, country, country_code, photo_url, price, auction_price, shipping_price, customs_price, service_fee, days, description, sort_order`
**submissions** — müştəri sorğuları: `make, model, year_from, year_to, condition_pref, budget, customer_name, phone, notes, created_at`

⚠️ **VACİB:** `migration_cases_detail.sql` faylı phpMyAdmin-də hələ işlədilməyib deyə, `car_cases` cədvəlində yeni sütunlar (`country`, `photo_url` və s.) olmaya bilər. Bu işlədilmədən admin panel və nümunə səhifələri xəta verə bilər.

---

## Admin panel (`admin.html`)

- Şifrə ilə giriş (default: `azbaku2026` — **mütləq dəyişilməlidir**, `config.php`-də `ADMIN_PASSWORD`)
- Sidebar naviqasiya: İcmal (dashboard), Sayt mətni, Nümunə avtomobillər, Sorğular
- Dashboard: canlı statistika (ümumi sorğu sayı, son 7 gün, orta büdcə, nümunə sayı)
- Sorğular: real vaxt cədvəl görünüşü, klikləyə bilən telefon nömrələri

---

## Görülən işlərin tam siyahısı (xronoloji)

1. İlkin sayt strukturu (sitemap) yaradıldı — dilerlik modelindən brokerlik modelinə keçid
2. Real HTML/CSS homepage tikildi (Luxury Blue + Signal Red brendi ilə)
3. "Sifariş ver" formu funksional edildi (validasiya, büdcə slider, uğur ekranı)
4. Tam mobil/planşet/masaüstü responsivlik əlavə edildi (hamburger menyu, sticky mobil CTA bar)
5. Admin panel yaradıldı — əvvəlcə localStorage ilə (yalnız bir brauzerdə işləyirdi)
6. **Real backend tikildi** — PHP + MySQL, Hostinger üçün planlaşdırılan
7. Dizayn 3 dəfə dəyişdirildi: əvvəlcə bold/rəngli → sonra minimalist (istifadəçi bəyənmədi) → sonra foto-əsaslı bold dizayn (bunu bəyəndi, saxlandı)
8. Real loqo inteqrasiyası (bir neçə uğursuz yükləmə cəhdindən sonra)
9. Rənglər loqoya uyğun `#1B365D`-ə düzəldildi
10. Fontlar 2-yə endirildi (Fraunces + Inter, IBM Plex Mono silindi)
11. Mobil header bir neçə dəfə düzəldildi (loqo ölçüsü, mətn üst-üstə düşməsi, "Zəng edin" düyməsinin mobil görünməsi kimi bug-lar)
12. Mobil hamburger menyu düzəldildi (sticky header altında düzgün açılması, xaricə kliklədikdə bağlanması)
13. Vercel 404 problemi həll edildi (`index-photo.html` → `index.html` adlandırıldı)
14. **"Nümunələr" (examples) səhifəsi tikildi** — ölkə bayraqları, hər nümunə üçün ətraflı səhifə (qiymət bölgüsü: auksion + daşınma + gömrük + xidmət haqqı)
15. Admin panelə nümunə idarəetməsi üçün əlavə sahələr (ölkə, şəkil linki, qiymət bölgüsü, təsvir) əlavə edildi
16. Şəkillər lokal SVG yer tutuculara keçirildi, sonra istifadəçinin xahişi ilə YENİDƏN internetdən (Unsplash) şəkillərə qaytarıldı
17. `examples.html`-ə statik fallback nümunələr əlavə edildi ki, API/DB hazır olmasa belə səhifə boş qalmasın

---

## Açıq qalan məsələlər / növbəti addımlar

- ❗ **Loqo faylının həqiqətən düzgün yükləndiyi təsdiqlənməyib** (fayl transferi bir neçə dəfə korlandı)
- ❗ `migration_cases_detail.sql` hələ verilənlər bazasında işlədilməyib (istifadəçi təsdiqləməyib)
- ❗ Admin panel şifrəsi hələ default olaraq qalır (`azbaku2026`) — production-a keçmədən əvvəl dəyişilməlidir
- Real müştəri fotoları (hazırkı auksion nümunələri hələ də nümunə/placeholder Unsplash şəkilləridir)
- Real telefon nömrəsi/email hələ `+994 00 000 00 00` / nümunə mail olaraq qalır — hər yerdə əvəz edilməlidir
- Form submission bildirişi (email/SMS) hələ qurulmayıb — hazırda yalnız admin panel yoxlanılanda görünür
- SEO tənzimləmələri (meta teqlər əsasən var, amma Google Business Profile, alt mətnlər və s. hələ yoxlanılmayıb)
- Domen/Vercel/DNS son vəziyyəti dəqiq deyil — istifadəçi "Hostinger yox" dedi bu mesajda, ehtimal ki fikrini dəyişib fərqli hosting seçəcək

---

## Sonuncu texniki kontekst

Söhbətin son mərhələsində istifadəçi bütün faylları zip halında çıxarmaq istəyirdi (başqa hesaba köçürmək üçün), sonra fikrini dəyişib bunun əvəzinə tam söhbət tarixçəsini istədi (başqa AI alətinə davam etdirmək üçün) — bu sənəd elə bunun cavabıdır.

**Yeni AI-yə tövsiyə:** Bu sənədi oxuduqdan sonra, istifadəçidən hazırkı fayllara (əgər varsa) baxmasını xahiş edin, sonra yuxarıdakı "açıq qalan məsələlər" siyahısından başlayın.
