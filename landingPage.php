<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: landingPage.php');
    exit;
}

// Check login status
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : null;

// Filter params
$searchQuery = trim($_GET['q'] ?? ($_GET['query'] ?? ''));
$minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
$maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
$locationFilter = strtolower(trim($_GET['location'] ?? ''));
$sortBy = $_GET['sort'] ?? 'latest';
$currentPage = max(1, (int)($_GET['page'] ?? 1));
$perPage = 24;
$totalAds = 0;
$totalPages = 1;

$allowedLocations = ['jakarta', 'surabaya', 'bandung', 'medan', 'semarang'];
if (!in_array($locationFilter, $allowedLocations, true)) {
    $locationFilter = '';
}

$allowedSorts = ['latest', 'oldest', 'price-asc', 'price-desc'];
if (!in_array($sortBy, $allowedSorts, true)) {
    $sortBy = 'latest';
}

if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
    $temp = $minPrice;
    $minPrice = $maxPrice;
    $maxPrice = $temp;
}

// Fetch categories from database
$categories = [];
try {
    $query = "SELECT id, name, icon FROM categories ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

// Fetch ads from database with first image (supports category filter + search + pagination)
$ads = [];
$selectedCategoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
$selectedCategoryName = null;
try {

    // Find selected category name for display
    if ($selectedCategoryId) {
        foreach ($categories as $cat) {
            if ((int)$cat['id'] === $selectedCategoryId) {
                $selectedCategoryName = $cat['name'];
                break;
            }
        }
    }

    $query = "SELECT 
                a.id, 
                a.title, 
                a.slug, 
                a.price, 
                a.location,
                a.release_at,
                c.name as category_name,
                (SELECT image FROM ad_images WHERE ad_id = a.id ORDER BY id ASC LIMIT 1) as first_image
              FROM ads a
              LEFT JOIN categories c ON a.category_id = c.id";

    $conditions = [];
    $params = [];

    if ($selectedCategoryId) {
        $conditions[] = "a.category_id = :categoryId";
        $params[':categoryId'] = $selectedCategoryId;
    }

    if ($minPrice !== null) {
        $conditions[] = "a.price >= :minPrice";
        $params[':minPrice'] = $minPrice;
    }

    if ($maxPrice !== null) {
        $conditions[] = "a.price <= :maxPrice";
        $params[':maxPrice'] = $maxPrice;
    }

    if ($locationFilter !== '') {
        $conditions[] = "LOWER(a.location) = :location";
        $params[':location'] = $locationFilter;
    }

    if ($searchQuery !== '') {
        $conditions[] = "(a.title LIKE :search OR a.description LIKE :search OR a.location LIKE :search)";
        $params[':search'] = '%' . $searchQuery . '%';
    }

    $whereClause = '';
    if (!empty($conditions)) {
        $whereClause = " WHERE " . implode(' AND ', $conditions);
    }

    $countQuery = "SELECT COUNT(*) FROM ads a" . $whereClause;
    $countStmt = $pdo->prepare($countQuery);
    $countStmt->execute($params);
    $totalAds = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalAds / $perPage));

    if ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $offset = ($currentPage - 1) * $perPage;
    $query .= $whereClause;

    switch ($sortBy) {
        case 'oldest':
            $query .= " ORDER BY a.release_at ASC";
            break;
        case 'price-asc':
            $query .= " ORDER BY a.price ASC";
            break;
        case 'price-desc':
            $query .= " ORDER BY a.price DESC";
            break;
        default:
            $query .= " ORDER BY a.release_at DESC";
            break;
    }

    $query .= " LIMIT " . (int)$perPage . " OFFSET " . (int)$offset;

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $ads = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

// Helper function to format price
function formatRupiah($price) {
    return 'Rp ' . number_format($price, 0, ',', '.'); 
}

// Helper function to get time ago
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';
    return date('d M Y', $timestamp);
}

$baseQueryParams = [];
if ($selectedCategoryId) {
    $baseQueryParams['category'] = $selectedCategoryId;
}
if ($searchQuery !== '') {
    $baseQueryParams['q'] = $searchQuery;
}
if ($minPrice !== null) {
    $baseQueryParams['min_price'] = $minPrice;
}
if ($maxPrice !== null) {
    $baseQueryParams['max_price'] = $maxPrice;
}
if ($locationFilter !== '') {
    $baseQueryParams['location'] = $locationFilter;
}
if ($sortBy !== 'latest') {
    $baseQueryParams['sort'] = $sortBy;
}

function buildPageUrl($page, $params) {
    $params['page'] = $page;
    return 'landingPage.php?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLX Clone - Jual Beli Online Terpercaya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #002f34;
            --secondary-color: #ffd500;
            --light-gray: #f5f5f5;
        }
        
        .hover-shadow:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
            transition: box-shadow 0.3s ease;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-5" href="landingPage.php" style="color: var(--primary-color);">
                <i class="fas fa-store me-2"></i>OLX CLONE
            </a>
            
            <form action="landingPage.php" method="GET" class="d-none d-lg-flex flex-grow-1 mx-4">
                <div class="input-group">
                    <?php if ($selectedCategoryId): ?>
                        <input type="hidden" name="category" value="<?= htmlspecialchars($selectedCategoryId) ?>">
                    <?php endif; ?>
                    <input type="text" name="q" class="form-control border-secondary" placeholder="Cari barang atau tempat..." value="<?= htmlspecialchars($searchQuery) ?>">
                    <button class="btn" style="background-color: var(--secondary-color);" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    <?php if ($isLoggedIn): ?>
                        <a href="postAd.php" class="btn ms-lg-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">
                            <i class="fas fa-plus me-1"></i> Jual
                        </a>

                        <div class="dropdown ms-lg-2 mt-2 mt-lg-0">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>Halo, <?= htmlspecialchars($userName) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="profile.php?id=<?= htmlspecialchars($_SESSION['user_id']) ?>">
                                        <i class="fas fa-user me-2"></i>Profile Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="myads.php">
                                        <i class="fas fa-list me-2"></i>Iklan Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="landingPage.php?logout=true">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn ms-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white; padding: 60px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-5 fw-bold mb-3">Jual Beli Barang Bekas & Baru</h1>
                    <p class="lead mb-4">Temukan barang yang Anda inginkan dengan harga terbaik dari seluruh Indonesia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- KATEGORI SECTION -->
    <section class="py-5" style="background-color: var(--light-gray);">
        <div class="container">
            <h2 class="mb-4 fw-bold" style="color: var(--primary-color);">Jelajahi Kategori</h2>
            <div class="row g-3">
                <?php if (empty($categories)): ?>
                    <div class="col-12 text-center py-3">
                        <p class="text-muted">Kategori belum tersedia</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="landingPage.php?category=<?= htmlspecialchars($cat['id']) ?>" class="text-decoration-none">
                            <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                                <div class="card-body py-4">
                                    <i class="<?= htmlspecialchars($cat['icon'] ?: 'fas fa-tag') ?> fa-3x mb-3" style="color: var(--primary-color);"></i>
                                    <h5 class="card-title" style="color: var(--primary-color);"><?= htmlspecialchars($cat['name']) ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FILTER & ADS SECTION -->
    <section class="py-5">
        <div class="container-fluid px-4">
            <div class="row">
                <!-- SIDEBAR FILTER -->
                <aside class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-bottom" style="background-color: var(--light-gray);">
                            <h5 class="mb-0" style="color: var(--primary-color);">Filter Pencarian</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="landingPage.php">
                                <?php if ($selectedCategoryId): ?>
                                    <input type="hidden" name="category" value="<?= htmlspecialchars($selectedCategoryId) ?>">
                                <?php endif; ?>
                                <?php if ($searchQuery !== ''): ?>
                                    <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">
                                <?php endif; ?>

                            <!-- Harga Filter -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Harga (Rp)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" placeholder="Min" class="form-control" id="minPrice" name="min_price" min="0" value="<?= $minPrice !== null ? htmlspecialchars((string)$minPrice) : '' ?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" placeholder="Max" class="form-control" id="maxPrice" name="max_price" min="0" value="<?= $maxPrice !== null ? htmlspecialchars((string)$maxPrice) : '' ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Lokasi Filter -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Lokasi</label>
                                <select class="form-select" name="location">
                                    <option value="" <?= $locationFilter === '' ? 'selected' : '' ?>>Semua Lokasi</option>
                                    <option value="jakarta" <?= $locationFilter === 'jakarta' ? 'selected' : '' ?>>Jakarta</option>
                                    <option value="surabaya" <?= $locationFilter === 'surabaya' ? 'selected' : '' ?>>Surabaya</option>
                                    <option value="bandung" <?= $locationFilter === 'bandung' ? 'selected' : '' ?>>Bandung</option>
                                    <option value="medan" <?= $locationFilter === 'medan' ? 'selected' : '' ?>>Medan</option>
                                    <option value="semarang" <?= $locationFilter === 'semarang' ? 'selected' : '' ?>>Semarang</option>
                                </select>
                            </div>

                            <hr>

                            <!-- Urutkan -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Urutkan Berdasarkan</label>
                                <select class="form-select" name="sort">
                                    <option value="latest" <?= $sortBy === 'latest' ? 'selected' : '' ?>>Terbaru</option>
                                    <option value="oldest" <?= $sortBy === 'oldest' ? 'selected' : '' ?>>Terlama</option>
                                    <option value="price-asc" <?= $sortBy === 'price-asc' ? 'selected' : '' ?>>Harga Terendah</option>
                                    <option value="price-desc" <?= $sortBy === 'price-desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
                                </select>
                            </div>

                            <button type="submit" class="btn w-100" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: bold;">Terapkan Filter</button>
                            <a href="landingPage.php<?= !empty($baseQueryParams['category']) ? '?category=' . urlencode((string)$baseQueryParams['category']) : (!empty($baseQueryParams['q']) ? '?q=' . urlencode((string)$baseQueryParams['q']) : '') ?>" class="btn btn-outline-secondary w-100 mt-2">Reset Filter</a>
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- MAIN ADS GRID -->
                <main class="col-lg-9">
                    <div class="mb-4">
                        <h2 class="fw-bold" style="color: var(--primary-color);">
                            Iklan Terbaru
                            <?php if (!empty($selectedCategoryName)): ?>
                                <span class="badge bg-warning text-dark ms-2" style="font-size: 0.8rem;">Kategori: <?= htmlspecialchars($selectedCategoryName) ?></span>
                            <?php endif; ?>
                            <span class="badge bg-light text-dark ms-2" style="font-size: 0.8rem;"><?= htmlspecialchars((string)$totalAds) ?> hasil</span>
                        </h2>
                    </div>
                    
                    <div class="row g-3">
                        <?php if (empty($ads)): ?>
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada iklan tersedia</p>
                                <a href="postAd.php" class="btn btn-warning">Pasang Iklan Pertama</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($ads as $ad): ?>
                            <!-- CARD IKLAN -->
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="detail.php?id=<?= htmlspecialchars($ad['id']) ?>" class="text-decoration-none text-dark">
                                    <div class="card border-0 h-100 shadow-sm hover-lift">
                                        <div class="position-relative">
                                            <img src="<?= htmlspecialchars($ad['first_image'] ?: 'https://placehold.co/600x400?text=No+Image') ?>" 
                                                 alt="<?= htmlspecialchars($ad['title']) ?>" 
                                                 class="card-img-top" 
                                                 style="height: 200px; object-fit: cover;">
                                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Baru</span>
                                            <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" 
                                                    style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="card-title text-truncate" style="color: var(--primary-color);">
                                                <?= htmlspecialchars($ad['title']) ?>
                                            </h6>
                                            <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">
                                                <?= formatRupiah($ad['price']) ?>
                                            </p>
                                            <p class="mb-2 text-muted small">
                                                <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($ad['location'] ?: 'Lokasi tidak tersedia') ?>
                                            </p>
                                            <p class="text-muted small"><?= timeAgo($ad['release_at']) ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- PAGINATION -->
                    <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage <= 1 ? '#' : htmlspecialchars(buildPageUrl($currentPage - 1, $baseQueryParams)) ?>" tabindex="-1">Previous</a>
                            </li>

                            <?php
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($totalPages, $currentPage + 2);
                            ?>

                            <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                                <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= htmlspecialchars(buildPageUrl($page, $baseQueryParams)) ?>" <?= $page === $currentPage ? 'style="background-color: var(--secondary-color); color: var(--primary-color); border-color: var(--secondary-color);"' : '' ?>><?= $page ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage >= $totalPages ? '#' : htmlspecialchars(buildPageUrl($currentPage + 1, $baseQueryParams)) ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white; padding: 60px 0; margin: 40px 0;">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-3">Punya Barang untuk Dijual?</h2>
            <p class="lead mb-4">Mulai berjualan hari ini dan dapatkan pembeli yang tepat untuk barang Anda</p>
            <a href="postAd.php" class="btn btn-warning btn-lg" style="background-color: var(--secondary-color); border: none; color: var(--primary-color); font-weight: bold;">
                <i class="fas fa-plus me-2"></i>Posting Iklan Gratis
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background-color: var(--primary-color); color: white;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Tentang Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Tentang OLX</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Karir</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Bantuan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Hubungi Kami</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Keamanan</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Cara Berbelanja</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Mitra</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Mitra Penjual</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Integasi API</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Promosi</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Advertising</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-white-50">
            <div class="text-center text-white-50">
                <p>&copy; 2026 OLX Clone. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add hover effects to cards
        const cards = document.querySelectorAll('.hover-lift');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Heart favorite toggle
        const favoriteButtons = document.querySelectorAll('.btn-light[style*="border-radius"]');
        favoriteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.backgroundColor = '#ffcccc';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.backgroundColor = '';
                }
            });
        });
    </script>
</body>
</html>
