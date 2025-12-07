# 🚀 OLX Clone - Quick Reference Guide

## 📌 Most Important Files

| File                   | Purpose                              | Size       |
| ---------------------- | ------------------------------------ | ---------- |
| `public/index.php`     | Homepage dengan database integration | 220 lines  |
| `assets/css/style.css` | Styling profesional & responsive     | 611 lines  |
| `assets/js/main.js`    | JavaScript interaktivitas            | 276 lines  |
| `config/database.php`  | Database connection                  | ~60 lines  |
| `config/helpers.php`   | Utility functions                    | ~130 lines |

## 🎯 Quick Actions

### Access Application

```
Local: http://localhost/olx_clone/public/
Or:    http://localhost/olx_clone/ (auto-redirect)
```

### Setup Database

```bash
# Via phpMyAdmin
# 1. Create database: olx_clone
# 2. Import: database/schema.sql

# Or via Command Line
mysql -u root -p < database/schema.sql
```

### Configure Database

Edit `config/database.php`:

```php
$db_config = [
    'host' => 'localhost',
    'db_name' => 'olx_clone',
    'db_user' => 'root',
    'db_password' => '',
];
```

## 🎨 Customize Colors

Edit `assets/css/style.css` (top of file):

```css
:root {
  --primary-color: #001f2e; /* Dark blue */
  --secondary-color: #0099ff; /* Bright blue */
  --accent-color: #ffb400; /* Yellow */
  /* ... */
}
```

## 📝 Common Tasks

### Add Navigation Link

```php
// In public/index.php or any page
<a href="page-name.php" class="nav-link">Label</a>
```

### Create New Page

```php
<?php
require_once '../config/database.php';
require_once '../config/helpers.php';

// Your code here
?>
```

### Format Price

```php
echo formatPrice(150000);  // Outputs: Rp 150.000
```

### Format Time

```php
echo formatTimeAgo('2024-12-07 10:30:00');  // Outputs: 2h yang lalu
```

### Database Query

```php
$query = "SELECT * FROM ads WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$ad = $stmt->fetch();
```

### Escape HTML

```php
echo escape($_GET['search']);  // Safe from XSS
```

## 🔍 File Locations

### HTML/PHP

- Homepage: `public/index.php`
- Future pages: `public/page-name.php`

### CSS

- Main styles: `assets/css/style.css`
- Organized in sections

### JavaScript

- Main JS: `assets/js/main.js`
- Modular functions

### Configuration

- Database: `config/database.php`
- Helpers: `config/helpers.php`

### Database

- Schema: `database/schema.sql`
- Run this to create tables

## 🎓 Helper Functions

```php
formatPrice($price)           // Rp format
formatTimeAgo($datetime)      // Relative time
escape($text)                 // HTML safe
truncate($text, $limit)       // Cut text
isValidEmail($email)          // Validate email
isLoggedIn()                  // Check if logged in
getCurrentUserID()            // Get user ID
```

## 🔐 Security Rules

1. **Always escape output**

   ```php
   echo escape($user_input);
   ```

2. **Use prepared statements**

   ```php
   $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->execute([$email]);
   ```

3. **Hash passwords**

   ```php
   $hash = password_hash($password, PASSWORD_BCRYPT);
   ```

4. **Validate input**
   ```php
   if (empty($_POST['name'])) die('Name required');
   ```

## 📱 Responsive Breakpoints

```css
/* Mobile First */
.class {
  /* 0-479px */
}

@media (min-width: 480px) {
  /* 480-767px */
}
@media (min-width: 768px) {
  /* 768-1199px */
}
@media (min-width: 1200px) {
  /* 1200px+ */
}
```

## 🐛 Debugging Tips

### Enable Error Display (Development Only)

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Check Database Connection

```php
// If error page shows, check:
// 1. Is MySQL running?
// 2. config/database.php settings correct?
// 3. Does 'olx_clone' database exist?
```

### JavaScript Console

```javascript
// Open DevTools (F12) and check Console for errors
console.log("Debug message");
```

### Check File Permissions

```bash
chmod 755 uploads/
```

## 📚 File Reading Order

1. **Start here**: `README.md` - Overview
2. **Then**: `SETUP_GUIDE.md` - Installation
3. **Next**: `public/index.php` - Homepage code
4. **Then**: `assets/css/style.css` - Styling
5. **Then**: `assets/js/main.js` - JavaScript
6. **Reference**: `config/helpers.php` - Functions

## 🚀 Next Steps

### For Development

1. Create authentication pages (`login.php`, `register.php`)
2. Create ad listing page (`ads.php`)
3. Create ad detail page (`ad-detail.php`)
4. Add search functionality (`search.php`)

### For Learning

1. Study `public/index.php` structure
2. Understand CSS layout system
3. Learn PHP-Database interaction
4. Explore helper functions

### For Customization

1. Change colors in `style.css`
2. Modify navbar links
3. Add new database tables
4. Create custom functions

## 📞 Quick Links

- 📖 [PHP Documentation](https://www.php.net/docs.php)
- 🎨 [MDN CSS Reference](https://developer.mozilla.org/en-US/docs/Web/CSS)
- ⚙️ [MDN JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
- 🗄️ [MySQL Reference](https://dev.mysql.com/doc/)

## ✅ Verification Checklist

After setup, verify:

- [ ] Can access `http://localhost/olx_clone/public/`
- [ ] Homepage loads without errors
- [ ] See categories from database
- [ ] See sample ads (if data inserted)
- [ ] Navigation links work
- [ ] Responsive on mobile view (F12)
- [ ] No console errors (F12)
- [ ] Styling looks professional

## 💾 Important Reminders

⚠️ **Keep Secure**

- Don't expose database password
- Always validate user input
- Use HTTPS in production
- Keep database backups

✅ **Keep Updated**

- Update documentation
- Comment your code
- Test before deploying
- Monitor performance

🎯 **Keep Clean**

- Delete unused files
- Follow naming conventions
- Organize code logically
- Remove debug statements

---

## 🎓 Learning Path

```
Start → Homepage Setup ✅
        ↓
    Authentication
        ↓
    User Profiles
        ↓
    Ad Management
        ↓
    Search & Filter
        ↓
    Messaging
        ↓
    Admin Panel
        ↓
    Deployment
```

---

**Happy Coding! 🚀**

For more help, see:

- `SETUP_GUIDE.md` - Detailed setup
- `PROJECT_STRUCTURE.md` - File organization
- `DEVELOPMENT_CHECKLIST.md` - Progress tracking
