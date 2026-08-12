# AzBaku AutoImport — quraşdırma təlimatı

Bu fayllar real backend (PHP + MySQL) ilə işləyir. İki ssenari var: **lokal test** (öz kompüterinizdə) və **Hostinger-ə yükləmə** (canlı sayt).

---

## A) Lokal kompüterdə test (Windows/Mac)

PHP və MySQL-i kompüterinizdə işə salmaq üçün bir "lokal server" proqramı lazımdır. Ən asanı:

1. **XAMPP** yükləyin: https://www.apachefriends.org (Windows/Mac/Linux, pulsuz)
2. Quraşdırdıqdan sonra **XAMPP Control Panel** açın, **Apache** və **MySQL** düymələrinin yanında **Start** basın
3. Bütün faylları (`index.html`, `request.html`, `admin.html`, `api/` qovluğu) bu qovluğa köçürün:
   - Windows: `C:\xampp\htdocs\azbaku\`
   - Mac: `/Applications/XAMPP/htdocs/azbaku/`
4. Brauzerdə açın: `http://localhost/phpmyadmin`
5. Yeni database yaradın, adını `azbaku` qoyun
6. **Import** tabına keçin, `api/schema.sql` faylını seçin, **Go** basın
7. `api/config.php` faylını açın, belə dəyişin:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'azbaku');
   define('DB_USER', 'root');
   define('DB_PASS', '');   // XAMPP-da default şifrə boşdur
   ```
8. Saytı açın: `http://localhost/azbaku/index.html`
9. Admin panel: `http://localhost/azbaku/admin.html`

Hər şey işə düşdükdən sonra, real hostinqə keçmək üçün B hissəsinə keçin.

---

## B) Hostinger-ə yükləmə (canlı sayt)

## 1-ci addım: Verilənlər bazası yaradın
1. Hostinger hPanel → **Databases** → **MySQL Databases**
2. Yeni database yaradın (məs. `azbaku`), istifadəçi adı və şifrə təyin edin
3. Bu 3 məlumatı qeyd edin: database adı, istifadəçi adı, şifrə (hostinger bunları `u123456789_...` formatında verir)

## 2-ci addım: Cədvəlləri yaradın
1. hPanel → **Databases** → **phpMyAdmin** düyməsinə basın
2. Yaratdığınız database-i seçin
3. **Import** tabına keçin, `api/schema.sql` faylını seçin, **Go** düyməsinə basın
4. Bu, lazım olan bütün cədvəlləri (site_content, car_cases, submissions) yaradacaq

## 3-ci addım: config.php-ni doldurun
`api/config.php` faylını açın və bunları öz məlumatlarınızla əvəz edin:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sizin_database_adınız');
define('DB_USER', 'sizin_istifadəçi_adınız');
define('DB_PASS', 'sizin_şifrəniz');
define('ADMIN_PASSWORD', 'öz_seçdiyiniz_güclü_şifrə');
```

## 4-cü addım: Faylları yükləyin
1. hPanel → **File Manager** (və ya FTP)
2. `public_html` qovluğuna keçin
3. Bu faylları yükləyin:
   - `index.html`
   - `request.html`
   - `admin.html`
   - `api/` qovluğunu bütünlüklə (config.php, content.php, cases.php, submissions.php)

Son struktur belə görünməlidir:
```
public_html/
  index.html
  request.html
  admin.html
  api/
    config.php
    content.php
    cases.php
    submissions.php
```

## 5-ci addım: Yoxlayın
1. Domeninizə daxil olun — sayt görünməlidir
2. `sizinsayt.az/admin.html` açın, şifrənizi daxil edin
3. "Sayt mətni" tabında bir şey dəyişin, saxlayın, sonra `index.html`-i yeniləyin — dəyişiklik görünməlidir
4. `request.html`-də test sorğusu göndərin, admin paneldəki "Sorğular" tabında görünməlidir

## Vacib qeydlər
- **Şifrəni mütləq dəyişin** — `azbaku2026` hazırda hər kəsə məlum test şifrəsidir
- Bu quraşdırma HTTP üzərindən işləyir; domeninizdə SSL (https) aktiv olduğundan əmin olun (Hostinger adətən pulsuz SSL təklif edir — hPanel → SSL)
- Əgər sayt `/api/content.php`-ə qoşula bilmirsə, brauzerdə F12 → Console açıb xəta mesajına baxın — çox güman DB məlumatları səhvdir
