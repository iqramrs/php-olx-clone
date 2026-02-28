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
$error = '';
$success = '';

$user = null;
try {
    $stmt = $pdo->prepare("SELECT id, name, email, whatsapp, password FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'Gagal memuat data akun.';
}

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$name = $user['name'];
$email = $user['email'];
$whatsapp = $user['whatsapp'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $wantsPasswordChange = ($currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '');

    if (empty($name) || empty($email) || empty($whatsapp)) {
        $error = 'Nama, email, dan WhatsApp wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($name) > 100) {
        $error = 'Nama maksimal 100 karakter!';
    } elseif (strlen($email) > 50) {
        $error = 'Email maksimal 50 karakter!';
    } elseif (strlen($whatsapp) > 15) {
        $error = 'Nomor WhatsApp maksimal 15 karakter!';
    } elseif ($wantsPasswordChange && (empty($currentPassword) || empty($newPassword) || empty($confirmPassword))) {
        $error = 'Untuk ganti password, isi password saat ini, password baru, dan konfirmasi password.';
    } elseif ($wantsPasswordChange && !password_verify($currentPassword, $user['password'])) {
        $error = 'Password saat ini tidak sesuai.';
    } elseif ($wantsPasswordChange && strlen($newPassword) < 8) {
        $error = 'Password baru minimal 8 karakter.';
    } elseif ($wantsPasswordChange && !preg_match('/[A-Z]/', $newPassword)) {
        $error = 'Password baru harus mengandung minimal 1 huruf besar.';
    } elseif ($wantsPasswordChange && !preg_match('/[a-z]/', $newPassword)) {
        $error = 'Password baru harus mengandung minimal 1 huruf kecil.';
    } elseif ($wantsPasswordChange && !preg_match('/[0-9]/', $newPassword)) {
        $error = 'Password baru harus mengandung minimal 1 angka.';
    } elseif ($wantsPasswordChange && !preg_match('/[^a-zA-Z0-9]/', $newPassword)) {
        $error = 'Password baru harus mengandung minimal 1 karakter khusus.';
    } elseif ($wantsPasswordChange && $newPassword !== $confirmPassword) {
        $error = 'Konfirmasi password baru tidak sama.';
    } elseif ($wantsPasswordChange && password_verify($newPassword, $user['password'])) {
        $error = 'Password baru tidak boleh sama dengan password saat ini.';
    } else {
        try {
            $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id LIMIT 1");
            $checkEmail->execute([
                ':email' => $email,
                ':id' => $userId,
            ]);

            if ($checkEmail->fetch()) {
                $error = 'Email sudah digunakan akun lain!';
            } else {
                $updateFields = "name = :name, email = :email, whatsapp = :whatsapp";
                $params = [
                    ':name' => $name,
                    ':email' => $email,
                    ':whatsapp' => $whatsapp,
                    ':id' => $userId,
                ];

                if ($wantsPasswordChange) {
                    $updateFields .= ", password = :password";
                    $params[':password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                }

                $update = $pdo->prepare("UPDATE users SET " . $updateFields . " WHERE id = :id");
                $update->execute($params);

                $_SESSION['user_name'] = $name;
                if ($wantsPasswordChange) {
                    $success = 'Biodata akun dan password berhasil diperbarui.';
                    $user['password'] = $params[':password'];
                } else {
                    $success = 'Biodata akun berhasil diperbarui.';
                }
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'Gagal memperbarui biodata akun.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Akun - OLX Clone</title>
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

        .form-control:focus {
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
                    <a href="profile.php" class="nav-link">
                        <i class="fas fa-user me-1"></i>Profile Saya
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="py-4" style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white;">
        <div class="container">
            <h1 class="h3 fw-bold mb-1">Edit Biodata Akun</h1>
            <p class="mb-0">Perbarui informasi profil Anda</p>
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
                <h2 class="section-title">Data Akun</h2>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="100" required value="<?= htmlspecialchars($name) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="50" required value="<?= htmlspecialchars($email) ?>">
                    </div>

                    <div class="mb-4">
                        <label for="whatsapp" class="form-label fw-semibold">WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" maxlength="15" required value="<?= htmlspecialchars($whatsapp) ?>">
                    </div>

                    <h2 class="section-title mt-4">Ganti Password</h2>

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="new-password">
                        <div class="form-text">Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus.</div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="new-password">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="profile.php" class="btn btn-light border px-4 py-2">Batal</a>
                        <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
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
