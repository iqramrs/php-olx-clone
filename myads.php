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

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? 'User';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ad_id'])) {
    $deleteAdId = (int) ($_POST['delete_ad_id'] ?? 0);

    if ($deleteAdId > 0) {
        try {
            $pdo->beginTransaction();

            $ownerCheck = $pdo->prepare("SELECT id FROM ads WHERE id = :ad_id AND user_id = :user_id LIMIT 1");
            $ownerCheck->execute([
                ':ad_id' => $deleteAdId,
                ':user_id' => $userId,
            ]);

            if (!$ownerCheck->fetch()) {
                throw new Exception('Iklan tidak ditemukan atau bukan milik Anda.');
            }

            $deleteImages = $pdo->prepare("DELETE FROM ad_images WHERE ad_id = :ad_id");
            $deleteImages->execute([':ad_id' => $deleteAdId]);

            $deleteAd = $pdo->prepare("DELETE FROM ads WHERE id = :ad_id AND user_id = :user_id");
            $deleteAd->execute([
                ':ad_id' => $deleteAdId,
                ':user_id' => $userId,
            ]);

            $pdo->commit();
            $success = 'Iklan berhasil dihapus.';
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log($e->getMessage());
            $error = 'Gagal menghapus iklan. Silakan coba lagi.';
        }
    }
}

$myAds = [];
try {
    $query = "SELECT
                a.id,
                a.title,
                a.price,
                a.location,
                a.release_at,
                c.name AS category_name,
                (SELECT image FROM ad_images WHERE ad_id = a.id ORDER BY id ASC LIMIT 1) AS first_image
              FROM ads a
              LEFT JOIN categories c ON a.category_id = c.id
              WHERE a.user_id = :user_id
              ORDER BY a.id DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $myAds = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

function formatRupiah($price) {
    return 'Rp ' . number_format((float) $price, 0, ',', '.');
}

function timeAgo($datetime) {
    if (!$datetime) return '-';

    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';

    return date('d M Y', $timestamp);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iklan Saya - OLX Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #002f34;
            --secondary-color: #ffd500;
            --light-gray: #f5f5f5;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons .btn {
            flex: 1;
        }
    </style>
</head>
<body style="background-color: var(--light-gray);">
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-5" href="landingPage.php" style="color: var(--primary-color);">
                <i class="fas fa-store me-2"></i>OLX CLONE
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    <span class="nav-link fw-bold" style="color: var(--primary-color);">Halo, <?= htmlspecialchars($userName) ?></span>
                    <a href="landingPage.php" class="nav-link">Beranda</a>
                    <a href="myads.php" class="nav-link active fw-semibold" style="color: var(--primary-color);">Iklan Saya</a>
                    <a href="postAd.php" class="btn ms-lg-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">
                        <i class="fas fa-plus me-1"></i> Jual
                    </a>
                    <a href="myads.php?logout=true" class="btn btn-outline-danger ms-lg-2 mt-2 mt-lg-0">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="py-4" style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white;">
        <div class="container">
            <h1 class="h3 fw-bold mb-1">Iklan Saya</h1>
            <p class="mb-0">Lihat semua iklan yang sudah Anda pasang</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success border-0 shadow-sm mb-4"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (empty($myAds)): ?>
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="fw-bold" style="color: var(--primary-color);">Anda belum memasang iklan</h4>
                        <p class="text-muted mb-4">Yuk mulai jual barang Anda sekarang juga.</p>
                        <a href="postAd.php" class="btn" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: 600;">
                            <i class="fas fa-plus me-2"></i>Pasang Iklan Sekarang
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0" style="color: var(--primary-color);">Daftar Iklan</h2>
                    <span class="badge bg-warning text-dark px-3 py-2"><?= count($myAds) ?> iklan</span>
                </div>

                <div class="row g-3">
                    <?php foreach ($myAds as $ad): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card border-0 h-100 shadow-sm hover-lift">
                                <a href="detail.php?id=<?= htmlspecialchars($ad['id']) ?>" class="text-decoration-none text-dark">
                                    <div class="position-relative">
                                        <img src="<?= htmlspecialchars($ad['first_image'] ?: 'https://placehold.co/600x400?text=No+Image') ?>"
                                             alt="<?= htmlspecialchars($ad['title']) ?>"
                                             class="card-img-top"
                                             style="height: 200px; object-fit: cover;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">
                                            <?= htmlspecialchars($ad['category_name'] ?: 'Kategori') ?>
                                        </span>
                                    </div>
                                </a>
                                <div class="card-body p-3">
                                    <a href="detail.php?id=<?= htmlspecialchars($ad['id']) ?>" class="text-decoration-none text-dark">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">
                                            <?= htmlspecialchars($ad['title']) ?>
                                        </h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">
                                            <?= formatRupiah($ad['price']) ?>
                                        </p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($ad['location'] ?: 'Lokasi tidak tersedia') ?>
                                        </p>
                                        <p class="text-muted small mb-0"><?= timeAgo($ad['release_at']) ?></p>
                                    </a>

                                    <div class="action-buttons mt-3">
                                        <a href="editAd.php?id=<?= htmlspecialchars($ad['id']) ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-pen me-1"></i>Edit
                                        </a>
                                        <form action="myads.php" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus iklan ini?');">
                                            <input type="hidden" name="delete_ad_id" value="<?= htmlspecialchars($ad['id']) ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
