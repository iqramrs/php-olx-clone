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

// Helpers
function formatRupiah($price) {
    return 'Rp ' . number_format((float)$price, 0, ',', '.');
}

function timeAgo($date) {
    if (!$date) return '-';
    $timestamp = strtotime($date);
    $diff = time() - $timestamp;
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';
    return date('d M Y', $timestamp);
}

$adId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($adId <= 0) {
    header('Location: landingPage.php');
    exit;
}

// Fetch ad detail
$ad = null;
try {
    $stmt = $pdo->prepare("SELECT a.*, c.name AS category_name, u.name AS seller_name, u.created_at AS seller_created, u.whatsapp AS seller_whatsapp
                           FROM ads a
                           LEFT JOIN categories c ON a.category_id = c.id
                           LEFT JOIN users u ON a.user_id = u.id
                           WHERE a.id = :id
                           LIMIT 1");
    $stmt->execute([':id' => $adId]);
    $ad = $stmt->fetch();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

if (!$ad) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body><p>Iklan tidak ditemukan.</p><a href="landingPage.php">Kembali</a></body></html>';
    exit;
}

// Fetch ad images
$images = [];
try {
    $stmt = $pdo->prepare("SELECT image FROM ad_images WHERE ad_id = :id ORDER BY id ASC");
    $stmt->execute([':id' => $adId]);
    $images = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

if (empty($images)) {
    $images = [['image' => 'https://placehold.co/600x400?text=No+Image']];
}

$mainImage = $images[0]['image'];
$sellerName = $ad['seller_name'] ?: 'Pengguna';
$sellerJoined = $ad['seller_created'] ? date('M Y', strtotime($ad['seller_created'])) : '-';
$categoryLink = $ad['category_id'] ? 'landingPage.php?category=' . urlencode($ad['category_id']) : 'landingPage.php';
$idLabel = '#AD' . str_pad($ad['id'], 5, '0', STR_PAD_LEFT);

$rawWhatsapp = $ad['seller_whatsapp'] ?? '';
$sanitizedWhatsapp = preg_replace('/\D+/', '', $rawWhatsapp);
if (strpos($sanitizedWhatsapp, '0') === 0) {
    $sanitizedWhatsapp = '62' . substr($sanitizedWhatsapp, 1);
}
$waMessage = 'Halo, saya tertarik dengan iklan "' . ($ad['title'] ?? '') . '"';
$whatsappUrl = !empty($sanitizedWhatsapp)
    ? 'https://wa.me/' . $sanitizedWhatsapp . '?text=' . urlencode($waMessage)
    : null;

// Fetch related ads (same category, exclude current)
$relatedAds = [];
if (!empty($ad['category_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT a.id, a.title, a.price, a.location, a.release_at,
                                      (SELECT image FROM ad_images WHERE ad_id = a.id ORDER BY id ASC LIMIT 1) AS first_image
                               FROM ads a
                               WHERE a.category_id = :catId AND a.id != :currentId
                               ORDER BY a.id DESC
                               LIMIT 4");
        $stmt->execute([
            ':catId' => $ad['category_id'],
            ':currentId' => $adId,
        ]);
        $relatedAds = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ad['title']) ?> - OLX Clone</title>
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
        
        .thumbnail-image {
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        
        .thumbnail-image:hover,
        .thumbnail-image.active {
            border-color: var(--secondary-color);
        }

        .main-image-container {
            background-color: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
        }

        .main-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        body {
            overflow-x: hidden;
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
            
            <form action="search.php" method="GET" class="d-none d-lg-flex flex-grow-1 mx-4">
                <div class="input-group">
                    <input type="text" name="query" class="form-control border-secondary" placeholder="Cari barang atau tempat..." required>
                    <button class="btn" style="background-color: var(--secondary-color);" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                        <a href="landingPage.php" class="nav-link">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                        <a href="detail.php?id=<?= htmlspecialchars($_GET['id']) ?>&logout=true" class="btn btn-outline-danger ms-2">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="nav-link">Login</a>
                        <a href="postAd.php" class="btn ms-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">
                            <i class="fas fa-plus me-1"></i> Jual
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- BREADCRUMB -->
    <section class="py-3" style="background-color: var(--light-gray);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="landingPage.php" style="color: var(--primary-color);">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= htmlspecialchars($categoryLink) ?>" style="color: var(--primary-color);"><?= htmlspecialchars($ad['category_name'] ?: 'Kategori') ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($ad['title']) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- DETAIL SECTION -->
    <section class="pt-5 pb-0">
        <div class="container px-4 px-md-5">
            <div class="row gx-4 gy-0">
                <!-- IMAGE GALLERY -->
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm mb-0">
                        <div class="card-body p-0">
                            <!-- Main Image -->
                            <div class="main-image-container" id="mainImageContainer">
                                <img src="<?= htmlspecialchars($mainImage) ?>" alt="<?= htmlspecialchars($ad['title']) ?>" id="mainImage">
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            <div class="p-3">
                                <div class="row g-2">
                                    <?php foreach ($images as $idx => $img): ?>
                                    <div class="col-3">
                                        <img src="<?= htmlspecialchars($img['image']) ?>" alt="Thumbnail <?= $idx + 1 ?>" class="img-thumbnail thumbnail-image <?= $idx === 0 ? 'active' : '' ?>" onclick="changeImage(this)">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DESCRIPTION UNDER GALLERY -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Deskripsi</h6>
                            <p class="mb-0" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($ad['description'] ?: 'Tidak ada deskripsi.')) ?></p>
                        </div>
                    </div>

                    <?php if (!empty($relatedAds)): ?>
                    <!-- RELATED ADS -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-2" style="color: var(--primary-color);">Iklan Terkait</h6>
                            <p class="text-muted small mb-3">Produk lain di kategori yang sama</p>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <?php foreach ($relatedAds as $rel): ?>
                                <div class="col">
                                    <a href="detail.php?id=<?= htmlspecialchars($rel['id']) ?>" class="text-decoration-none text-dark h-100 d-block">
                                        <div class="card border-0 h-100 shadow-sm hover-lift">
                                            <div class="position-relative">
                                                <img src="<?= htmlspecialchars($rel['first_image'] ?: 'https://placehold.co/600x400?text=No+Image') ?>" 
                                                     alt="<?= htmlspecialchars($rel['title']) ?>" 
                                                     class="card-img-top" 
                                                     style="height: 160px; object-fit: cover;">
                                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2"><?= htmlspecialchars($ad['category_name'] ?: 'Kategori') ?></span>
                                            </div>
                                            <div class="card-body p-3">
                                                <h6 class="card-title text-truncate" style="color: var(--primary-color); min-height: 44px;">
                                                    <?= htmlspecialchars($rel['title']) ?>
                                                </h6>
                                                <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 16px;">
                                                    <?= formatRupiah($rel['price']) ?>
                                                </p>
                                                <?php if (!empty($rel['location'])): ?>
                                                <p class="mb-2 text-muted small d-flex align-items-center gap-1">
                                                    <i class="fas fa-map-marker-alt"></i> <span><?= htmlspecialchars($rel['location']) ?></span>
                                                </p>
                                                <?php endif; ?>
                                                <p class="text-muted small mb-0"><?= timeAgo($rel['release_at']) ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- SIDEBAR INFO -->
                <div class="col-lg-5">
                    <!-- PRICE & ACTION -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="fw-bold mb-0" style="color: var(--primary-color); font-size: 28px;"><?= formatRupiah($ad['price']) ?></h2>
                                    <p class="text-muted small mb-0">Harga bisa nego</p>
                                </div>
                                <button class="btn btn-light" id="favoriteBtn" onclick="toggleFavorite()" title="Simpan iklan">
                                    <i class="far fa-heart fa-lg"></i>
                                </button>
                            </div>

                            <h5 class="fw-bold mb-3" style="color: var(--primary-color);"><?= htmlspecialchars($ad['title']) ?></h5>

                            <div class="mb-3">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt" style="color: var(--secondary-color);"></i>
                                    <span class="ms-2"><?= htmlspecialchars($ad['location'] ?: 'Lokasi tidak tersedia') ?></span>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock" style="color: var(--secondary-color);"></i>
                                    <span class="ms-2 text-muted">Diposting <?= timeAgo($ad['release_at']) ?></span>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-tag" style="color: var(--secondary-color);"></i>
                                    <a href="<?= htmlspecialchars($categoryLink) ?>" class="ms-2 text-decoration-none" style="color: var(--primary-color);"><?= htmlspecialchars($ad['category_name'] ?: 'Kategori') ?></a>
                                </p>
                            </div>

                            <hr>

                            <!-- CONTACT BUTTONS -->
                            <div class="mb-3">
                                <?php if ($whatsappUrl): ?>
                                    <a href="<?= htmlspecialchars($whatsappUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn w-100 mb-2 py-3" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: bold; font-size: 14px; border: none;">
                                        <i class="fab fa-whatsapp me-2"></i>Hubungi Penjual
                                    </a>
                                <?php else: ?>
                                    <button type="button" class="btn w-100 mb-2 py-3 disabled" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: bold; font-size: 14px; border: none;" title="Nomor WhatsApp penjual tidak tersedia">
                                        <i class="fab fa-whatsapp me-2"></i>Hubungi Penjual
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="alert alert-warning small mb-0" role="alert" style="font-size: 12px;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Tips Aman:</strong> Bertemu langsung, periksa barang, jangan transfer dulu
                            </div>
                        </div>
                    </div>

                    <!-- SELLER INFO -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Informasi Penjual</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user fa-lg text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($sellerName) ?></h6>
                                    <p class="text-muted small mb-0">Bergabung sejak <?= htmlspecialchars($sellerJoined) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AD DETAILS -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Detail Iklan</h6>
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-muted small">ID Iklan</td>
                                        <td class="fw-bold text-end small"><?= htmlspecialchars($idLabel) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted small">Kondisi</td>
                                        <td class="text-end">
                                            <span class="badge bg-warning text-dark">Bekas</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted small">Dilihat</td>
                                        <td class="fw-bold text-end small">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted small">Disimpan</td>
                                        <td class="fw-bold text-end small">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SHARE -->
                    <div class="card border-0 shadow-sm mb-0">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Bagikan</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary flex-fill btn-sm">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info flex-fill btn-sm">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success flex-fill btn-sm">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary flex-fill btn-sm">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
        <footer style="background-color: var(--primary-color); color: white; width: 100vw; margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw);">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Change main image when clicking thumbnail
        function changeImage(el) {
            const src = el.src;
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail-image').forEach(img => {
                img.classList.remove('active');
            });
            el.classList.add('active');
        }

        // Toggle favorite button
        function toggleFavorite() {
            const btn = document.getElementById('favoriteBtn');
            const icon = btn.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.classList.remove('btn-light');
                btn.classList.add('btn-danger');
                btn.style.color = 'white';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-light');
                btn.style.color = '';
            }
        }

    </script>
</body>
</html>
