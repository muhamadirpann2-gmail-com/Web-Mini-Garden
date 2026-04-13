# 🌿 Naureen Mini Garden — Panduan Deploy

## Struktur File Project

```
naureen/
├── index.html              ← Homepage utama (rename ke index.php)
├── process_form.php        ← Proses form kontak
├── naureen_db.sql          ← Query SQL database
├── config/
│   └── database.php        ← Konfigurasi koneksi database
├── admin/
│   └── pesan.php           ← Dashboard admin pesan masuk
└── assets/
    ├── css/
    │   └── style.css       ← Stylesheet utama
    └── js/
        └── main.js         ← JavaScript (navbar, animasi, form)
```

> **Penting:** Rename `index.html` menjadi `index.php` setelah deploy ke hosting PHP.

---

## STEP 1 — Import Database

### Menggunakan phpMyAdmin:
1. Login ke **cPanel** → buka **phpMyAdmin**
2. Klik **New** di sidebar kiri → buat database bernama `naureen_db`
3. Pilih database `naureen_db` → klik tab **Import**
4. Klik **Choose File** → pilih file `naureen_db.sql`
5. Klik **Go** / **Import** → tunggu hingga selesai
6. Pastikan tabel `kontak` dan `admin` berhasil dibuat

---

## STEP 2 — Konfigurasi Database

Edit file `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_cpanel_username_naureen');  // Username dari cPanel
define('DB_PASS', 'your_database_password');         // Password database
define('DB_NAME', 'your_cpanel_username_naureen_db'); // Format InfinityFree
```

### Format nama di hosting gratis:
- **InfinityFree**: `username_naureen_db` (prefix otomatis)
- **000WebHost**: `id_naureen_db`
- **Hostinger Free**: sesuai nama yang dibuat di panel

---

## STEP 3 — Upload File ke Hosting

### Opsi A — File Manager (cPanel):
1. Login cPanel → buka **File Manager**
2. Masuk ke folder `public_html` (atau `htdocs`)
3. Klik **Upload** → upload semua file satu per satu atau buat zip dulu
4. Jika upload zip: klik kanan file zip → **Extract**
5. Pastikan struktur folder sesuai di atas

### Opsi B — FTP (FileZilla):
1. Download [FileZilla](https://filezilla-project.org/)
2. Masukkan Host, Username, Password, Port dari cPanel/hosting
3. Drag & drop folder `naureen/` ke `public_html/`

---

## STEP 4 — Rename index.html

Setelah upload, rename `index.html` → `index.php` agar PHP bekerja:
- Di File Manager: klik kanan → Rename
- Di FTP: rename sebelum upload

---

## STEP 5 — Hosting Gratis yang Direkomendasikan

### InfinityFree (infinityfree.net)
- ✅ PHP + MySQL gratis
- ✅ SSL gratis
- ✅ Subdomain gratis (yoursite.infinityfreeapp.com)
- Cara daftar: https://infinityfree.net/register

### 000WebHost (000webhost.com oleh Hostinger)
- ✅ PHP + MySQL gratis
- ✅ 300MB storage
- ✅ Mudah digunakan
- Cara daftar: https://www.000webhost.com/

---

## STEP 6 — Kustomisasi Konten

### Ganti nomor WhatsApp:
Cari dan ganti `6281234567890` di `index.php` dengan nomor asli:
```
wa.me/628XXXXXXXXXX
```

### Ganti embed Google Maps:
Di `index.php`, cari `<iframe src="https://www.google.com/maps/embed?...`
1. Buka [Google Maps](https://maps.google.com)
2. Cari lokasi Naureen Mini Garden
3. Klik **Share** → **Embed a map** → salin kode iframe
4. Tempel menggantikan iframe yang ada

### Embed TikTok:
1. Buka video TikTok di browser
2. Klik **Share** → **Embed** → salin kode
3. Di `index.php`, ganti bagian `.video-placeholder` dengan kode embed TikTok

### Ganti gambar placeholder:
- Gambar saat ini: `https://picsum.photos/seed/garden1/1920/1080`
- Ganti URL dengan path foto asli: `assets/images/hero.jpg`
- Upload foto ke folder `assets/images/`

---

## STEP 7 — Akses Admin Panel

URL: `https://yoursite.com/admin/pesan.php`

Login default:
- Username: `admin`
- Password: `admin123`

**Segera ganti password** di file `admin/pesan.php` baris:
```php
$ADMIN_PASS = 'ganti_password_anda';
```

---

## Checklist Sebelum Go Live

- [ ] Rename `index.html` → `index.php`
- [ ] Import `naureen_db.sql` ke phpMyAdmin
- [ ] Update `config/database.php` dengan kredensial hosting
- [ ] Ganti nomor WhatsApp dengan nomor asli
- [ ] Update embed Google Maps dengan lokasi asli
- [ ] Update alamat di section Lokasi
- [ ] Embed video TikTok asli (opsional)
- [ ] Ganti foto placeholder dengan foto asli (opsional)
- [ ] Ganti password admin panel
- [ ] Test form kontak end-to-end
- [ ] Test link WhatsApp

---

## Troubleshooting

**Form tidak menyimpan data?**
→ Cek `config/database.php` — pastikan nama DB, user, password benar

**Halaman blank setelah submit form?**
→ Aktifkan error reporting di PHP atau cek error log hosting

**Google Maps tidak muncul?**
→ Beberapa hosting gratis memblokir iframe. Gunakan embed Maps biasa tanpa API key

**Gambar tidak muncul?**
→ Pastikan path file benar. Gunakan URL absolut jika perlu.
