# 🏪 OLX Clone - Platform Jual Beli Online Modern

Platform jual beli online yang responsif dan profesional, terinspirasi dari OLX dengan desain modern dan fitur lengkap. Built menggunakan native PHP (PDO) dan MySQL.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/php-8.0+-green.svg)
![MySQL](https://img.shields.io/badge/mysql-5.7+-orange.svg)

## ✨ Fitur Utama

### 🎯 Frontend

- ✅ Desain responsif modern (Mobile, Tablet, Desktop)
- ✅ Navigation bar sticky dengan smooth scroll
- ✅ Hero section dengan search bar premium
- ✅ Grid kategori produk dinamis dengan hover effects
- ✅ Iklan terbaru dengan lazy loading
- ✅ Modern UI/UX dengan CSS Gradients & animations
- ✅ Smooth transitions dan micro-interactions
- ✅ Footer dengan social media integration

### 🔧 Backend

- ✅ PDO Database dengan prepared statements
- ✅ Database schema dengan foreign keys & indexes
- ✅ Error handling yang robust
- ✅ Helper functions untuk kebutuhan umum
- ✅ Security best practices implemented

### 📱 Performance

- ✅ CSS modular & optimized (611 lines)
- ✅ JavaScript vanilla (276 lines)
- ✅ Image lazy loading support
- ✅ Gzip compression configured
- ✅ Browser caching optimized

## 📋 Kebutuhan Sistem

- PHP >= 8.0
- MySQL >= 5.7 atau MariaDB >= 10.1
- Apache dengan mod_rewrite
- XAMPP / Laragon atau server lokal lainnya

## 🚀 Quick Start

### 1. Clone Project

```bash
git clone https://github.com/Iqram-Salampessy/php-olx-clone.git
cd olx_clone
```

### 2. Setup Database

**Via phpMyAdmin:**

- Buka `http://localhost/phpmyadmin`
- Create database `olx_clone`
- Import `database/schema.sql`

**Atau via Command Line:**

```bash
mysql -u root -p < database/schema.sql
```

### 3. Konfigurasi Database

Edit `config/database.php`:

```php
$db_config = [
    'host' => 'localhost',
    'db_name' => 'olx_clone',
    'db_user' => 'root',
    'db_password' => '',
];
```

### 4. Create Upload Folder

```bash
mkdir uploads && chmod 755 uploads
```

### 5. Access Application

Buka: `http://localhost/olx_clone/public/`

## 📁 Project Structure

```
olx_clone/
├── assets/
│   ├── css/style.css          (611 lines - Fully optimized)
│   ├── js/main.js             (276 lines - Vanilla JS)
│   └── images/
├── config/
│   ├── database.php           (Database connection)
│   └── helpers.php            (Utility functions)
├── database/
│   └── schema.sql             (Complete schema + samples)
├── public/
│   ├── index.php              (220 lines - Homepage)
│   ├── .htaccess              (URL rewriting)
│   └── [More pages coming...]
├── uploads/                   (User uploads)
├── .env.example
├── README.md
└── SETUP_GUIDE.md
```

## 🎨 Design & Styling

### Color Scheme

| Element   | Color     | Usage              |
| --------- | --------- | ------------------ |
| Primary   | `#001f2e` | Headers, footers   |
| Secondary | `#0099ff` | CTAs, links        |
| Accent    | `#ffb400` | Prices, highlights |
| Light BG  | `#f8f9fa` | Sections           |

### Responsive Design

- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 480px - 767px
- **Phone**: < 480px

## 💾 Database Schema

### Core Tables

```sql
users(id, name, email, password, phone, profile_image, bio)
categories(id, name, icon, description)
ads(id, user_id, category_id, title, description, price, location, status, views)
ad_images(id, ad_id, image_path)
```

### Optional Tables

- `favorites` - User favorited ads
- `reviews` - User ratings & reviews

## 🔒 Security

Implemented:

- ✅ PDO prepared statements
- ✅ Password bcrypt hashing
- ✅ Input validation & sanitization
- ✅ HTML entity encoding
- ✅ CSRF protection ready
- ✅ Security headers configured
- ✅ SQL injection prevention

## 📝 Available Functions

```php
formatPrice($price)           // Format Rupiah
formatTimeAgo($datetime)      // Relative time
escape($text)                 // HTML escape
truncate($text, $limit)       // Text truncation
isValidEmail($email)          // Email validation
isLoggedIn()                  // Check auth status
getCurrentUserID()            // Get current user
```

## 🛠️ Development Tips

### Customize Colors

Edit `:root` in `assets/css/style.css`:

```css
:root {
  --primary-color: #001f2e;
  --secondary-color: #0099ff;
  --accent-color: #ffb400;
  /* ... */
}
```

### Add New Pages

1. Create file in `public/page-name.php`
2. Include database config: `require_once '../config/database.php'`
3. Include helpers: `require_once '../config/helpers.php'`

## 📊 Performance Optimizations

- Images compressed & lazy-loaded
- Database indexes on foreign keys
- CSS custom properties for theming
- Gzip compression enabled
- Browser caching configured

## 🗂️ Files Modified/Created

- ✅ `public/index.php` - Homepage (220 lines)
- ✅ `assets/css/style.css` - Styling (611 lines, fully responsive)
- ✅ `assets/js/main.js` - JavaScript (276 lines)
- ✅ `config/database.php` - DB connection
- ✅ `config/helpers.php` - Utility functions
- ✅ `database/schema.sql` - DB schema with samples
- ✅ `public/.htaccess` - URL rewriting
- ✅ `.env.example` - Environment template
- ✅ `SETUP_GUIDE.md` - Detailed setup
- ✅ `README.md` - This file

## 🚀 Coming Soon

- [ ] User Authentication
- [ ] Ad Management System
- [ ] Search & Filter
- [ ] Favorites/Wishlist
- [ ] Messaging System
- [ ] User Reviews
- [ ] Admin Panel

## 📚 Resources

- [PHP.net](https://www.php.net)
- [MDN Web Docs](https://developer.mozilla.org/)
- [CSS Grid Guide](https://css-tricks.com/snippets/css/complete-guide-grid/)
- [Font Awesome](https://fontawesome.com/)

## 📄 License

MIT License - Free to use for personal and commercial projects.

## 👨‍💻 Author

**Iqram Salampessy**  
GitHub: [@Iqram-Salampessy](https://github.com/Iqram-Salampessy)

---

<div align="center">

**⭐ If this project helped you, please give it a star!**

Made with ❤️ for learning and development

</div>
