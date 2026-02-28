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

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? 'User';
$error = '';

$user = null;
$totalAds = 0;

try {
    $stmt = $pdo->prepare("SELECT id, name, email, whatsapp, created_at FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch();

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM ads WHERE user_id = :user_id");
    $countStmt->execute([':user_id' => $userId]);
    $totalAds = (int) $countStmt->fetchColumn();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'Gagal memuat profil pengguna.';
}

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$joinedAt = !empty($user['created_at']) ? date('d M Y, H:i', strtotime($user['created_at'])) : '-';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - OLX Clone</title>
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

        .profile-card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .profile-avatar {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: var(--primary-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .label-muted {
            color: #6c757d;
            font-size: 0.9rem;
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
            <h1 class="h3 fw-bold mb-1">Profile Saya</h1>
            <p class="mb-0">Informasi akun Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 shadow-sm"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="card profile-card">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="profile-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold" style="color: var(--primary-color);"><?= htmlspecialchars($user['name']) ?></h4>
                                <p class="mb-0 text-muted">Halo, <?= htmlspecialchars($userName) ?></p>
                            </div>
                        </div>
                        <a href="editProfile.php" class="btn" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: 600;">
                            <i class="fas fa-pen me-2"></i>Edit Biodata Akun
                        </a>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-white h-100">
                                <div class="label-muted mb-1">Nama</div>
                                <div class="fw-semibold"><?= htmlspecialchars($user['name']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-white h-100">
                                <div class="label-muted mb-1">Email</div>
                                <div class="fw-semibold"><?= htmlspecialchars($user['email']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-white h-100">
                                <div class="label-muted mb-1">Nomor WhatsApp</div>
                                <div class="fw-semibold"><?= htmlspecialchars($user['whatsapp']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-white h-100">
                                <div class="label-muted mb-1">Bergabung Sejak</div>
                                <div class="fw-semibold"><?= htmlspecialchars($joinedAt) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-white h-100">
                                <div class="label-muted mb-1">Total Iklan</div>
                                <div class="fw-semibold"><?= htmlspecialchars((string) $totalAds) ?> iklan</div>
                            </div>
                        </div>
                    </div>
                </div>
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
