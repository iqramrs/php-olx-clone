<?php
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: landingPage.php');
    exit;
}

require_once 'config.php';
require_once 'helpers/security.php';

$error = '';
$email = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();

    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Validation
    if (empty($email)) {
        $error = 'Email wajib diisi!';
    } elseif (empty($password)) {
        $error = 'Password wajib diisi!';
    } else {
        try {
            // Query user by email
            $query = "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user) {
                // Email not found - suggest registration
                $error = 'Email belum terdaftar.';
            } elseif (!password_verify($password, $user['password'])) {
                // Email found but password incorrect
                $error = 'Password salah!';
            } else {
                // Login successful
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['last_activity'] = time();

                // Remember me functionality
                if ($remember) {
                    setcookie('user_email', $email, [
                        'expires' => time() + (30 * 24 * 60 * 60),
                        'path' => '/',
                        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);
                }

                // Redirect to landing page
                header('Location: landingPage.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Coba lagi nanti.';
            error_log($e->getMessage());
        }
    }
}

// Get remembered email from cookie
$remembered_email = $_COOKIE['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OLX Clone</title>
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

        body {
            background-color: var(--light-gray);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-card {
            max-width: 450px;
            width: 100%;
        }

        .brand-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-section h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .brand-section p {
            color: #6c757d;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #004d54;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 10px;
            color: #6c757d;
            font-size: 14px;
        }

        .social-btn {
            border: 1px solid #dee2e6;
            padding: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .social-btn:hover {
            background-color: #f8f9fa;
            border-color: var(--primary-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 47, 52, 0.15);
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .text-primary-custom:hover {
            color: #004d54 !important;
        }

        .error-message {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .error-message.show {
            display: block;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .alert-danger {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-5" href="landingPage.php" style="color: var(--primary-color);">
                <i class="fas fa-store me-2"></i>OLX CLONE
            </a>
            <a href="landingPage.php" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-home me-1"></i>Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- LOGIN SECTION -->
    <div class="login-container">
        <div class="login-card">
            <!-- Brand -->
            <div class="brand-section">
                <h1><i class="fas fa-store"></i></h1>
                <h2 class="fw-bold" style="color: var(--primary-color);">Selamat Datang </h2>
                <p class="text-muted">Masuk ke akun OLX Clone Anda</p>
            </div>

            <!-- Login Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" action="login.php" method="POST">
                        <?= csrf_field(); ?>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required value="<?= htmlspecialchars($email) ?>">
                            </div>
                            <div class="error-message" id="emailError"></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            <div class="error-message" id="passwordError"></div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="forgot-password.php" class="small text-primary-custom text-decoration-none">
                                Lupa Password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau masuk dengan</span>
                        </div>

                        <!-- Social Login -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button type="button" class="btn social-btn w-100">
                                    <i class="fab fa-google text-danger me-2"></i>Google
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn social-btn w-100">
                                    <i class="fab fa-facebook text-primary me-2"></i>Facebook
                                </button>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Belum punya akun? 
                                <a href="register.php" class="text-primary-custom text-decoration-none fw-semibold">Daftar Sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    <i class="fas fa-shield-alt me-1"></i>
                    Login Anda aman dan terenkripsi
                </p>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="text-muted small mb-0">&copy; 2026 OLX Clone. Semua hak dilindungi.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted text-decoration-none small me-3">Tentang</a>
                    <a href="#" class="text-muted text-decoration-none small me-3">Bantuan</a>
                    <a href="#" class="text-muted text-decoration-none small">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            // Reset error messages
            document.getElementById('emailError').classList.remove('show');
            document.getElementById('passwordError').classList.remove('show');

            // Reset input styling
            email.classList.remove('is-invalid');
            password.classList.remove('is-invalid');

            let isValid = true;

            // Validate email
            if (!email.value.trim()) {
                showError('emailError', 'Email wajib diisi!');
                email.classList.add('is-invalid');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError('emailError', 'Format email tidak valid!');
                email.classList.add('is-invalid');
                isValid = false;
            }

            // Validate password
            if (!password.value) {
                showError('passwordError', 'Password wajib diisi!');
                password.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            return true;
        });

        // Helper function to show error message
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }

        // Helper function to validate email format
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            if (this.value && isValidEmail(this.value)) {
                this.classList.remove('is-invalid');
                document.getElementById('emailError').classList.remove('show');
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                document.getElementById('passwordError').classList.remove('show');
            }
        });
    </script>
</body>
</html>
