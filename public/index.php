<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform jual beli online terpercaya - OLX Clone">
    <meta name="keywords" content="jual beli, online, bekas, baru">
    <title>OLX Clone - Jual Beli Online Terpercaya</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-brand">
                    <a href="index.php" class="logo">
                        <i class="fas fa-tag"></i>
                        <span>OLX</span>
                    </a>
                </div>
                <div class="navbar-menu">
                    <a href="index.php" class="nav-link active">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                    <a href="#categories" class="nav-link">
                        <i class="fas fa-th"></i>
                        Kategori
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-question-circle"></i>
                        Bantuan
                    </a>
                </div>
                <div class="navbar-actions">
                    <a href="login.php" class="btn btn-outline">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </a>
                    <a href="register.php" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Temukan Barang Favorit Anda</h1>
                <p>Jual dan beli barang bekas atau baru dengan harga terbaik</p>
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="Cari barang..." required>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section" id="categories">
        <div class="container">
            <h2>Kategori Populer</h2>
            <div class="categories-grid">
                <?php
                // Koneksi database
                require_once '../config/database.php';

                try {
                    $query = "SELECT id, name, icon FROM categories LIMIT 8";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($categories as $category) {
                        echo '<a href="category.php?id=' . htmlspecialchars($category['id']) . '" class="category-card">';
                        if ($category['icon']) {
                            echo '<img src="' . htmlspecialchars($category['icon']) . '" alt="' . htmlspecialchars($category['name']) . '">';
                        } else {
                            echo '<i class="fas fa-cube"></i>';
                        }
                        echo '<span>' . htmlspecialchars($category['name']) . '</span>';
                        echo '</a>';
                    }
                } catch (Exception $e) {
                    echo '<p class="error">Gagal memuat kategori: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Latest Ads Section -->
    <section class="ads-section">
        <div class="container">
            <div class="section-header">
                <h2>Iklan Terbaru</h2>
                <a href="ads.php" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="ads-grid">
                <?php
                try {
                    $query = "
                        SELECT 
                            a.id, 
                            a.title, 
                            a.price, 
                            a.location, 
                            a.created_at,
                            c.name as category_name,
                            u.name as user_name,
                            ai.image_path
                        FROM ads a
                        LEFT JOIN categories c ON a.category_id = c.id
                        LEFT JOIN users u ON a.user_id = u.id
                        LEFT JOIN ad_images ai ON a.id = ai.ad_id
                        ORDER BY a.created_at DESC
                        LIMIT 12
                    ";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($ads)) {
                        echo '<p class="no-data">Belum ada iklan yang tersedia</p>';
                    } else {
                        // Group images by ad
                        $adsGrouped = [];
                        foreach ($ads as $ad) {
                            if (!isset($adsGrouped[$ad['id']])) {
                                $adsGrouped[$ad['id']] = $ad;
                                $adsGrouped[$ad['id']]['images'] = [];
                            }
                            if ($ad['image_path']) {
                                $adsGrouped[$ad['id']]['images'][] = $ad['image_path'];
                            }
                        }

                        foreach ($adsGrouped as $ad) {
                            $image = !empty($ad['images']) ? $ad['images'][0] : 'placeholder.jpg';
                            $createdAt = new DateTime($ad['created_at']);
                            $now = new DateTime();
                            $interval = $now->diff($createdAt);

                            if ($interval->d == 0) {
                                $timeAgo = $interval->h . 'h yang lalu';
                            } elseif ($interval->d < 7) {
                                $timeAgo = $interval->d . 'd yang lalu';
                            } else {
                                $timeAgo = $createdAt->format('d M Y');
                            }

                            echo '<div class="ad-card">';
                            echo '<a href="ad-detail.php?id=' . htmlspecialchars($ad['id']) . '" class="ad-image">';
                            echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($ad['title']) . '">';
                            echo '<span class="category-badge">' . htmlspecialchars($ad['category_name'] ?? 'Umum') . '</span>';
                            echo '</a>';
                            echo '<div class="ad-content">';
                            echo '<h3><a href="ad-detail.php?id=' . htmlspecialchars($ad['id']) . '">' . htmlspecialchars($ad['title']) . '</a></h3>';
                            echo '<p class="price">Rp ' . number_format($ad['price'], 0, ',', '.') . '</p>';
                            echo '<p class="location"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($ad['location'] ?? 'Lokasi tidak tersedia') . '</p>';
                            echo '<div class="ad-footer">';
                            echo '<span class="time">' . htmlspecialchars($timeAgo) . '</span>';
                            echo '<span class="seller">' . htmlspecialchars($ad['user_name'] ?? 'Penjual Anonim') . '</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                } catch (Exception $e) {
                    echo '<p class="error">Gagal memuat iklan: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Mulai Jual Sekarang</h2>
            <p>Jual barang milik Anda dan dapatkan uang tambahan</p>
            <a href="login.php" class="btn btn-primary btn-large">Buat Iklan Gratis</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>Tentang</h4>
                    <ul>
                        <li><a href="#">Tentang OLX</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Karir</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">Hubungi Kami</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Komunitas</h4>
                    <ul>
                        <li><a href="#">Forum</a></li>
                        <li><a href="#">Testimoni</a></li>
                        <li><a href="#">Tips & Trik</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 OLX Clone. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>

</html>