<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';
require_once 'helpers/security.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: landingPage.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? 'User';
$adId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($adId <= 0) {
    header('Location: myads.php');
    exit;
}

$error = '';
$success = '';

$categories = [];
try {
    $query = "SELECT id, name FROM categories ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'Gagal memuat kategori.';
}

$ad = null;
try {
    $stmt = $pdo->prepare("SELECT id, title, category_id, description, price, location, user_id FROM ads WHERE id = :id AND user_id = :user_id LIMIT 1");
    $stmt->execute([
        ':id' => $adId,
        ':user_id' => $userId,
    ]);
    $ad = $stmt->fetch();
} catch (PDOException $e) {
    error_log($e->getMessage());
}

if (!$ad) {
    header('Location: myads.php');
    exit;
}

$title = $ad['title'];
$category_id = (int) $ad['category_id'];
$description = $ad['description'];
$price = $ad['price'];
$location = $ad['location'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();

    $title = trim($_POST['title'] ?? '');
    $category_id = (int) ($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $location = trim($_POST['location'] ?? '');

    if (empty($title)) {
        $error = 'Judul iklan wajib diisi!';
    } elseif (strlen($title) > 50) {
        $error = 'Judul iklan maksimal 50 karakter!';
    } elseif ($category_id <= 0) {
        $error = 'Kategori wajib dipilih!';
    } elseif (empty($description)) {
        $error = 'Deskripsi wajib diisi!';
    } elseif ($price <= 0) {
        $error = 'Harga harus lebih dari 0!';
    } elseif (empty($location)) {
        $error = 'Lokasi wajib diisi!';
    } else {
        try {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            $priceVal = number_format($price, 2, '.', '');

            $update = $pdo->prepare("UPDATE ads
                                     SET title = :title,
                                         slug = :slug,
                                         description = :description,
                                         price = :price,
                                         location = :location,
                                         category_id = :category_id
                                     WHERE id = :id AND user_id = :user_id");

            $update->execute([
                ':title' => $title,
                ':slug' => $slug,
                ':description' => $description,
                ':price' => $priceVal,
                ':location' => $location,
                ':category_id' => $category_id,
                ':id' => $adId,
                ':user_id' => $userId,
            ]);

            $success = 'Iklan berhasil diperbarui.';
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'Gagal memperbarui iklan. Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Iklan - OLX Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #002f34;
            --secondary-color: #ffd500;
            --light-gray: #f5f5f5;
        }

        body {
            background-color: var(--light-gray);
        }

        .form-section {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 47, 52, 0.15);
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background-color: #004d54;
            color: white;
        }

        .btn-secondary-custom {
            background-color: var(--secondary-color);
            border: none;
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-secondary-custom:hover {
            background-color: #ffd700;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
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
                    <a href="landingPage.php" class="nav-link">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="py-4" style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white;">
        <div class="container">
            <h1 class="h3 fw-bold mb-1">Edit Iklan</h1>
            <p class="mb-0">Perbarui informasi iklan Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 shadow-sm"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success border-0 shadow-sm"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="form-section">
                <h2 class="section-title">Informasi Iklan</h2>
                <form method="POST" action="">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Iklan</label>
                        <input type="text" class="form-control" id="title" name="title" maxlength="50" required value="<?= htmlspecialchars($title) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="">Pilih kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>" <?= ((int)$category_id === (int)$category['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="6" maxlength="2000" required><?= htmlspecialchars($description) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" required value="<?= htmlspecialchars((string) (float) $price) ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="location" class="form-label fw-semibold">Lokasi</label>
                        <input type="text" class="form-control" id="location" name="location" required value="<?= htmlspecialchars($location) ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="myads.php" class="btn btn-light border px-4 py-2">Batal</a>
                        <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                        <a href="detail.php?id=<?= htmlspecialchars($adId) ?>" class="btn btn-secondary-custom">Lihat Iklan</a>
                    </div>
                </form>
            </div>
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
