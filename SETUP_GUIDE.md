# OLX Clone - Platform Jual Beli Online

Template HTML/CSS/JavaScript untuk platform jual beli online seperti OLX, dengan fitur-fitur lengkap dan responsif.

## 📋 Struktur Direktori

```
olx_clone/
├── app/
│   ├── test.php
├── config/
│   └── database.php          # Konfigurasi database
├── database/
│   └── schema.sql            # Script pembuatan tabel database
├── public/
│   ├── index.php            # Halaman utama (sudah dibuat)
│   ├── login.php            # Halaman login
│   ├── register.php         # Halaman registrasi
│   ├── ads.php              # Daftar semua iklan
│   ├── ad-detail.php        # Detail iklan
│   ├── category.php         # Iklan per kategori
│   └── search.php           # Hasil pencarian
├── assets/
│   ├── css/
│   │   └── style.css        # File CSS utama (sudah dibuat)
│   ├── js/
│   │   └── main.js          # File JavaScript utama (sudah dibuat)
│   └── images/              # Folder untuk gambar
├── uploads/                 # Folder untuk upload gambar iklan
└── vendor/                  # Folder untuk dependencies
```

## 🚀 Fitur Utama

### Halaman Index (Sudah Dibuat)

- ✅ Navbar dengan navigasi responsif
- ✅ Hero section dengan search bar
- ✅ Kategori populer dengan grid layout
- ✅ Daftar iklan terbaru dengan gambar
- ✅ Call-to-action section untuk membuat iklan
- ✅ Footer dengan navigasi dan social links
- ✅ Responsive design untuk mobile, tablet, dan desktop

### Database

- 👥 Tabel Users (Pengguna)
- 📁 Tabel Categories (Kategori)
- 📢 Tabel Ads (Iklan)
- 🖼️ Tabel Ad Images (Gambar Iklan)
- ⭐ Tabel Favorites (Favorit) - Opsional
- ⭐ Tabel Reviews (Review/Rating) - Opsional

## 📦 Instalasi

### 1. Persiapan Database

**Menggunakan phpMyAdmin:**

1. Buka phpMyAdmin di `http://localhost/phpmyadmin`
2. Klik "New" atau buat database baru dengan nama `olx_clone`
3. Pilih database `olx_clone`
4. Klik "Import"
5. Upload file `database/schema.sql`
6. Klik "Go"

**Atau menggunakan Command Line:**

```bash
mysql -u root -p < database/schema.sql
```

### 2. Konfigurasi Database

Edit file `config/database.php`:

```php
$host = 'localhost';
$db_name = 'olx_clone';
$db_user = 'root';
$db_password = ''; // Sesuaikan jika ada password
```

### 3. Setup Folder

Buat folder untuk upload gambar:

```bash
mkdir uploads
chmod 755 uploads
```

## 🎨 Desain & Styling

### Warna Utama

- **Primary**: `#002f34` (Dark Blue)
- **Secondary**: `#0099ff` (Bright Blue)
- **Accent**: `#ffb400` (Yellow)

### Responsive Breakpoints

- Desktop: 1200px+
- Tablet: 768px - 1199px
- Mobile: < 768px
- Small Mobile: < 480px

### Font & Typography

- Font Family: System fonts (-apple-system, BlinkMacSystemFont, Segoe UI, etc.)
- Heading: Bold weight (600-700)
- Body: Normal weight (400)

## 📄 Halaman yang Sudah Dibuat

### ✅ Index.php

Halaman utama dengan fitur:

- Database connection dengan PDO
- Menampilkan kategori dari database
- Menampilkan iklan terbaru dengan:
  - Gambar produk
  - Judul iklan
  - Harga (format Rp)
  - Lokasi
  - Waktu posting (relatif: jam, hari, tanggal)
  - Nama penjual
- Responsive grid layout

## 🛠️ Halaman yang Perlu Dibuat

### Autentikasi

- `public/login.php` - Halaman login pengguna
- `public/register.php` - Halaman registrasi pengguna
- `public/logout.php` - Fungsi logout
- `public/profile.php` - Profil pengguna

### Content Pages

- `public/ads.php` - Daftar semua iklan dengan pagination
- `public/ad-detail.php` - Detail lengkap iklan
- `public/category.php` - Iklan berdasarkan kategori
- `public/search.php` - Hasil pencarian iklan
- `public/my-ads.php` - Iklan milik pengguna
- `public/create-ad.php` - Form membuat iklan baru
- `public/edit-ad.php` - Form edit iklan

### Admin Panel

- `public/admin/dashboard.php` - Dashboard admin
- `public/admin/categories.php` - Manage kategori
- `public/admin/users.php` - Manage pengguna
- `public/admin/ads.php` - Manage iklan

## 💾 Database Details

### Tabel Users

```sql
id - Primary Key
name - Nama lengkap pengguna
email - Email (unique)
password - Password (hashed)
phone - Nomor telepon
profile_image - Foto profil
bio - Biografi
created_at - Tanggal dibuat
updated_at - Tanggal diupdate
```

### Tabel Categories

```sql
id - Primary Key
name - Nama kategori (unique)
icon - Icon/emoji kategori
description - Deskripsi kategori
created_at - Tanggal dibuat
```

### Tabel Ads

```sql
id - Primary Key
user_id - Foreign Key (users)
category_id - Foreign Key (categories)
title - Judul iklan
description - Deskripsi detail
price - Harga
location - Lokasi
status - Status (active, sold, inactive)
views - Jumlah views
created_at - Tanggal dibuat
updated_at - Tanggal diupdate
```

### Tabel Ad_Images

```sql
id - Primary Key
ad_id - Foreign Key (ads)
image_path - Path ke file gambar
created_at - Tanggal dibuat
```

## 🔐 Security Tips

1. **Password Hashing**: Selalu hash password menggunakan `password_hash()`

```php
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
```

2. **Input Validation**: Validasi dan sanitasi input dari user

```php
$title = htmlspecialchars($_POST['title']);
```

3. **SQL Injection Prevention**: Gunakan prepared statements

```php
$stmt = $pdo->prepare("SELECT * FROM ads WHERE id = ?");
$stmt->execute([$id]);
```

4. **CSRF Protection**: Tambahkan token CSRF pada form

```php
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
```

5. **Session Management**: Selalu gunakan session untuk autentikasi

```php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
```

## 📱 Mobile Optimization

- Viewport meta tag sudah ditambahkan
- Media queries untuk responsive design
- Touch-friendly buttons dan links
- Mobile-first approach dalam CSS

## 🎯 Fitur JavaScript

- Active navigation indicator
- Smooth scrolling
- Image lazy loading (jika tersedia data-src)
- Search form validation
- Local storage untuk favorites
- Price formatter dengan Intl API
- Date formatter untuk tanggal
- Notification system
- Tooltip functionality

## 🚀 Development Server

Untuk menjalankan project di XAMPP:

1. Copy folder project ke `C:\xampp\htdocs\`
2. Jalankan XAMPP (Apache & MySQL)
3. Akses di browser: `http://localhost/olx_clone/public/`

## 📚 Resources

- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php)
- [CSS Grid Guide](https://css-tricks.com/snippets/css/complete-guide-grid/)
- [MDN JavaScript Guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide)
- [Font Awesome Icons](https://fontawesome.com/icons)

## 📝 Notes

- File CSS sudah dioptimasi dengan custom properties (CSS variables)
- Semua warna dapat diubah dari `:root` selector
- JavaScript modular dan dapat diperluas dengan fitur baru
- Database schema sudah include indexes untuk performa
- Foreign keys sudah dikonfigurasi dengan ON DELETE CASCADE/RESTRICT

## 🤝 Kontribusi

Silakan fork dan buat pull request untuk improvement.

## 📄 License

MIT License - Bebas digunakan untuk proyek pribadi maupun komersial.

---

**Dibuat dengan ❤️ untuk belajar PHP & Web Development**
