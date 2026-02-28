# OLX Clone (PHP Native + MySQL)

Aplikasi marketplace sederhana untuk jual-beli barang yang dibangun dengan **PHP Native**, **PDO**, dan **MySQL**.
Project ini dibuat sebagai **personal portfolio** untuk menunjukkan kemampuan full-cycle web development (auth, CRUD, security, filtering, pagination, dan UX).

---

## Demo Fitur Utama

- Auth: register, login, logout.
- Profil pengguna: lihat biodata, edit biodata, ganti password dengan validasi keamanan.
- Kelola iklan pribadi: tambah, edit, hapus iklan.
- Detail iklan: galeri gambar, iklan terkait, kontak penjual via WhatsApp.
- Filter listing: kategori, rentang harga, lokasi, sort.
- Pagination listing iklan.
- Error pages: 404 dan 500.

---

## Tech Stack

- PHP Native
- MySQL / MariaDB
- PDO (prepared statement)
- Bootstrap 5
- Font Awesome

---

## Struktur Database

Menggunakan tabel:

- `users`
- `categories`
- `ads`
- `ad_images`

Skema tabel lengkap tersedia di `assets/Database.md`.

---

## Highlight Security

Project ini sudah menerapkan beberapa praktik security penting:

- **CSRF Protection** pada endpoint POST penting (`helpers/security.php`).
- **Password Hashing** (`password_hash`, `password_verify`).
- **Prepared Statement (PDO)** untuk mencegah SQL Injection.
- **Session Hardening**:
  - `session_regenerate_id(true)` saat login.
  - timeout inactivity session.
- **Upload Hardening**:
  - validasi MIME type gambar,
  - limit ukuran file,
  - random file naming.

---

## Alur Fitur

### 1) User & Auth

- Register akun baru.
- Login dengan email + password.
- Session disimpan untuk akses halaman private.

### 2) Ads Management

- User login bisa posting iklan (`postAd.php`).
- User dapat edit/hapus iklan miliknya sendiri (`editAd.php`, `myads.php`).

### 3) Public Listing

- Landing page menampilkan daftar iklan terbaru (`landingPage.php`).
- User bisa filter, sort, dan pindah halaman lewat pagination.

### 4) Contact Seller

- Tombol hubungi penjual di detail iklan hanya aktif untuk user yang sudah login.

---

## Setup Lokal (Laragon)

### Prasyarat

- Laragon (Apache + MySQL)
- PHP 8+ disarankan

### Langkah Menjalankan

1. Clone/copy project ke folder:
   `C:/laragon/www/olx_clone`
2. Jalankan Apache dan MySQL dari Laragon.
3. Buat database baru, contoh: `olx_clone`.
4. Import SQL schema dari `assets/Database.md`.
5. Sesuaikan konfigurasi di `config.php`:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
6. Akses aplikasi di browser:
   `http://localhost/olx_clone/landingPage.php`

---

## File Entry Points

- `landingPage.php` → halaman utama listing iklan
- `detail.php` → detail iklan
- `postAd.php` → posting iklan
- `myads.php` → daftar iklan milik user
- `editAd.php` → edit iklan
- `profile.php` → profil user
- `editProfile.php` → edit biodata + ganti password
- `login.php` / `register.php` → autentikasi

---

## Skill yang Ditunjukkan (Portfolio)

- PHP Native architecture (modular page-based).
- Database relational design & query optimization dasar.
- Authentication & authorization berbasis session.
- Security best practices untuk aplikasi web dasar.
- CRUD end-to-end + validasi server-side.
- UX consistency dengan Bootstrap.
- Error handling dan fallback page.

---

## Pengembangan Lanjutan (Roadmap)

- Fitur favorit iklan (persist ke DB).
- Chat internal buyer-seller.
- Dashboard statistik user.
- Unit test untuk helper dan validasi.
- Deployment online (VPS/Render/Railway) + custom domain.

---

## Author

Nama: (isi nama kamu)

GitHub: (isi profile GitHub kamu)

LinkedIn: (opsional)
