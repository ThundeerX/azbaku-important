# AzBaku AutoImport

ABŞ və Kanada auksionlarından Azərbaycana sifarişlə avtomobil idxalı.

## Texniki stek
- **Frontend:** HTML, CSS, vanilla JavaScript
- **Backend:** PHP + MySQL
- **Hosting:** Hostinger (GitHub repo ilə bağlı)

## Quraşdırma

### 1. Hostinger hPanel-də verilənlər bazası yaradın
- hPanel → Databases → MySQL Databases
- Yeni baza yaradın, istifadəçi adı və şifrə təyin edin

### 2. `api/config.php` faylını redaktə edin
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sizin_baza_adiniz');
define('DB_USER', 'sizin_istifadeci');
define('DB_PASS', 'sizin_sifre');
define('ADMIN_PASSWORD', 'guclu_admin_sifresi');
```

### 3. Cədvəlləri yaradın
phpMyAdmin → Import → `api/schema.sql` faylını yükləyin, Go basın.
Sonra `api/migration_cases_detail.sql` faylını da eyni şəkildə işlədin.

### 4. GitHub → Hostinger bağlantısı
hPanel → Git → Connect → GitHub repo-nuzun URL-ini əlavə edin.
Branch: `main`, Deploy path: `public_html`

## Fayl strukturu
```
index.html              — Ana səhifə (hero slayder, nümunələr, proses)
request.html            — Sifariş formu
examples.html           — Nümunələr qalereyası (ölkə bayraqları ilə)
example-detail.html     — Tək nümunənin ətraflı səhifəsi
admin.html              — Admin idarəetmə paneli
api/config.php          — DB bağlantı (DƏYİŞDİRİLMƏLİDİR)
api/schema.sql          — İlkin cədvəl sxemi
api/migration_cases_detail.sql — Əlavə sütunlar üçün miqrasiya
api/content.php         — Sayt mətni API
api/cases.php           — Nümunələr API
api/submissions.php     — Müştəri sorğuları API
.htaccess               — HTTPS, cache, təhlükəsizlik tənzimləmələri
```

## Admin panel
URL: `sizinsayt.az/admin.html`
Default şifrə: config.php-dən dəyişin!
