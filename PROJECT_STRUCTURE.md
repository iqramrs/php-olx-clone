# 📂 OLX Clone - Project Structure Guide

## Complete File Structure

```
olx_clone/
├── 📄 index.html                    ← Auto-redirect ke public/
├── 📄 README.md                     ← Documentation & quick start
├── 📄 SETUP_GUIDE.md               ← Detailed setup instructions
├── 📄 .env.example                 ← Environment template
├── 📄 .gitignore                   ← Git ignore rules
│
├── 📁 config/                      ← Configuration files
│   ├── 📄 database.php             ← PDO Database connection
│   ├── 📄 helpers.php              ← Utility functions
│   └── 📄 constants.php            ← Application constants
│
├── 📁 public/                      ← Web root (main folder)
│   ├── 📄 index.php                ← Homepage (220 lines)
│   ├── 📄 .htaccess                ← URL rewriting rules
│   │
│   ├── 📁 login.php                ← [akan dibuat]
│   ├── 📁 register.php             ← [akan dibuat]
│   ├── 📁 logout.php               ← [akan dibuat]
│   │
│   ├── 📁 ads.php                  ← [akan dibuat]
│   ├── 📁 ad-detail.php            ← [akan dibuat]
│   ├── 📁 category.php             ← [akan dibuat]
│   ├── 📁 search.php               ← [akan dibuat]
│   │
│   ├── 📁 create-ad.php            ← [akan dibuat]
│   ├── 📁 edit-ad.php              ← [akan dibuat]
│   ├── 📁 my-ads.php               ← [akan dibuat]
│   ├── 📁 profile.php              ← [akan dibuat]
│   └── 📁 favorites.php            ← [akan dibuat]
│
├── 📁 assets/                      ← Static files
│   ├── 📁 css/
│   │   ├── 📄 style.css            ← Main stylesheet (611 lines)
│   │   └── 📄 responsive.css       ← [optional]
│   │
│   ├── 📁 js/
│   │   ├── 📄 main.js              ← Main JavaScript (276 lines)
│   │   ├── 📄 utils.js             ← [optional]
│   │   └── 📄 api.js               ← [optional]
│   │
│   ├── 📁 images/                  ← Static images
│   │   ├── 📄 logo.png
│   │   ├── 📄 placeholder.jpg
│   │   └── ...
│   │
│   └── 📁 icons/                   ← Icon sets
│       └── 📄 [Font Awesome via CDN]
│
├── 📁 database/                    ← Database files
│   ├── 📄 schema.sql               ← DB schema & sample data
│   └── 📄 migrations/              ← [optional for future use]
│
├── 📁 uploads/                     ← User uploaded files
│   ├── 📄 .gitkeep
│   └── [user-images]/
│
├── 📁 app/                         ← Application logic
│   ├── 📄 test.php                 ← Testing file
│   ├── 📁 controllers/             ← [optional]
│   ├── 📁 models/                  ← [optional]
│   └── 📁 services/                ← [optional]
│
└── 📁 vendor/                      ← Composer dependencies [optional]
```

## File Statistics

| File                   | Lines | Size          | Purpose |
| ---------------------- | ----- | ------------- | ------- |
| `public/index.php`     | 220   | Homepage      |
| `assets/css/style.css` | 611   | Styling       |
| `assets/js/main.js`    | 276   | JavaScript    |
| `config/database.php`  | 60+   | DB Connection |
| `config/helpers.php`   | 130+  | Utilities     |
| `database/schema.sql`  | 150+  | DB Schema     |

## Key Features by File

### 🎨 Frontend

**assets/css/style.css**

- CSS Variables & custom properties
- Responsive grid layouts
- Modern gradients & shadows
- Mobile-first design
- Animation & transitions
- 4 breakpoints (desktop, tablet, mobile, phone)

**assets/js/main.js**

- DOM manipulation
- Event listeners
- Smooth scrolling
- Navbar functionality
- Form validation
- Local storage integration
- Notification system

### 🔧 Backend

**config/database.php**

- PDO connection
- Error handling
- Debug page for errors
- Connection pooling ready

**config/helpers.php**

- Price formatting
- Time formatting (relative)
- Text truncation
- Email validation
- CSRF token management
- Flash messages
- Session management

**public/index.php**

- Database queries
- Dynamic category display
- Dynamic ad listing
- Image handling
- Error messages
- SEO meta tags

## 🚀 Development Workflow

### Adding New Page

1. Create file in `public/page-name.php`
2. Include configs:
   ```php
   <?php
   require_once '../config/database.php';
   require_once '../config/helpers.php';
   ?>
   ```
3. Use template similar to `index.php`
4. Link in navbar

### Adding CSS

- Edit `assets/css/style.css`
- Add new section with clear comments
- Follow naming conventions
- Ensure mobile responsive

### Adding JavaScript

- Edit `assets/js/main.js`
- Add functions in appropriate sections
- Use vanilla JS (no jQuery)
- Test in console

## 📝 Naming Conventions

### Files

- PHP files: `kebab-case.php` (e.g., `ad-detail.php`)
- CSS files: `kebab-case.css`
- JS files: `kebab-case.js`

### Classes & IDs

- CSS classes: `kebab-case` (e.g., `.ad-card`)
- HTML IDs: `kebab-case` (e.g., `#categories`)

### Functions

- PHP functions: `camelCase()` (e.g., `formatPrice()`)
- JS functions: `camelCase()` (e.g., `formatDate()`)

### Variables

- PHP variables: `$camelCase` (e.g., `$categories`)
- JS variables: `camelCase` (e.g., `userID`)
- CSS variables: `--kebab-case` (e.g., `--primary-color`)

## 🔐 Security Notes

✅ **Protected:**

- `/config/` - Denied in `.htaccess`
- Database passwords in `config/database.php`
- `.env` file (in .gitignore)

⚠️ **Be Careful:**

- Always validate input
- Always escape output
- Use prepared statements
- Hash passwords with bcrypt

## 🎯 Next Steps

1. ✅ Complete - Homepage setup
2. ⏳ Create authentication pages
3. ⏳ Create ad management
4. ⏳ Add search & filter
5. ⏳ Create user profiles
6. ⏳ Add messaging system
7. ⏳ Create admin panel

---

For detailed setup instructions, see **SETUP_GUIDE.md**
