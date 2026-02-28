<?php
require_once 'config.php';

$error = [];
$success = false;

// Process registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($name) || empty($email) || empty($whatsapp) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($email) > 50) {
        $error = 'Email maksimal 50 karakter!';
    } elseif (strlen($whatsapp) > 15) {
        $error = 'Nomor WhatsApp maksimal 15 karakter!';
    } elseif (strlen($name) > 100) {
        $error = 'Nama maksimal 100 karakter!';
    } elseif (strlen($password) < 8) {
        $error = 'Password minimal 8 karakter!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak sama!';
    } else {
        try {
            // Check if email already exists
            $sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            
            if ($stmt->fetch()) {
                $error = 'Email sudah terdaftar!';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $sql = "INSERT INTO users (name, email, whatsapp, password) VALUES (:name, :email, :whatsapp, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'whatsapp' => $whatsapp,
                    'password' => $hashed_password
                ]);
                
                $success = 'Registrasi berhasil! Silakan login.';
                
                // Redirect to login after 2 seconds
                header("refresh:2;url=login.php");
            }
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - OLX Clone</title>
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

        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-card {
            max-width: 500px;
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

        .password-strength {
            height: 4px;
            background-color: #dee2e6;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s;
        }

        .strength-weak { background-color: #dc3545; width: 33%; }
        .strength-medium { background-color: #ffc107; width: 66%; }
        .strength-strong { background-color: #28a745; width: 100%; }

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

        .success-message {
            display: none;
            color: #28a745;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .success-message.show {
            display: block;
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

    <!-- REGISTER SECTION -->
    <div class="register-container">
        <div class="register-card">
            <!-- Brand -->
            <div class="brand-section">
                <h1><i class="fas fa-store"></i></h1>
                <h2 class="fw-bold" style="color: var(--primary-color);">Buat Akun Baru</h2>
                <p class="text-muted">Bergabung dan mulai jual beli sekarang</p>
            </div>

            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Register Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="" method="POST" id="registerForm">
                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Panggilan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama panggilan" required maxlength="100" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                            </div>
                            <div class="error-message" id="nameError"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required maxlength="50" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="error-message" id="emailError"></div>
                        </div>
                        
                        <!-- WhatsApp -->
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label fw-semibold">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Masukkan nomor WhatsApp" required maxlength="15" value="<?= htmlspecialchars($_POST['whatsapp'] ?? '') ?>">
                            </div>
                            <div class="error-message" id="whatsappError"></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required onkeyup="checkPasswordStrength()">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'toggleIcon1')">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted" id="strengthText"></small>
                            <div class="error-message" id="passwordError"></div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', 'toggleIcon2')">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                            <div class="error-message" id="confirmPasswordError"></div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label small" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary-custom text-decoration-none">Syarat & Ketentuan</a> 
                                dan <a href="#" class="text-primary-custom text-decoration-none">Kebijakan Privasi</a>
                            </label>
                            <div class="error-message" id="termsError"></div>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau daftar dengan</span>
                        </div>

                        <!-- Social Register -->
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

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Sudah punya akun? 
                                <a href="login.php" class="text-primary-custom text-decoration-none fw-semibold">Masuk Sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    <i class="fas fa-shield-alt me-1"></i>
                    Data Anda aman dan terenkripsi
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
        function togglePassword(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);
            
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

        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            
            if (strength === 0 || strength === 1) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Password lemah';
                strengthText.style.color = '#dc3545';
            } else if (strength === 2 || strength === 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Password sedang';
                strengthText.style.color = '#ffc107';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Password kuat';
                strengthText.style.color = '#28a745';
            }
        }

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const terms = document.getElementById('terms');

            // Reset error messages
            document.getElementById('nameError').classList.remove('show');
            document.getElementById('emailError').classList.remove('show');
            document.getElementById('passwordError').classList.remove('show');
            document.getElementById('confirmPasswordError').classList.remove('show');
            document.getElementById('termsError').classList.remove('show');

            // Reset input styling
            name.classList.remove('is-invalid');
            email.classList.remove('is-invalid');
            password.classList.remove('is-invalid');
            confirmPassword.classList.remove('is-invalid');

            let isValid = true;

            // Validate name
            if (!name.value.trim()) {
                showError('nameError', 'Nama lengkap wajib diisi!');
                name.classList.add('is-invalid');
                isValid = false;
            }

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
            } else if (password.value.length < 8) {
                showError('passwordError', 'Password minimal 8 karakter!');
                password.classList.add('is-invalid');
                isValid = false;
            }

            // Validate confirm password
            if (!confirmPassword.value) {
                showError('confirmPasswordError', 'Konfirmasi password wajib diisi!');
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                showError('confirmPasswordError', 'Password tidak sama dengan konfirmasi password!');
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }

            // Validate terms
            if (!terms.checked) {
                showError('termsError', 'Anda harus menyetujui Syarat & Ketentuan!');
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
        document.getElementById('name').addEventListener('blur', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                document.getElementById('nameError').classList.remove('show');
            }
        });

        document.getElementById('email').addEventListener('blur', function() {
            if (this.value && isValidEmail(this.value)) {
                this.classList.remove('is-invalid');
                document.getElementById('emailError').classList.remove('show');
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (this.value.length >= 8) {
                this.classList.remove('is-invalid');
                document.getElementById('passwordError').classList.remove('show');
            }
        });

        document.getElementById('confirm_password').addEventListener('blur', function() {
            if (this.value === document.getElementById('password').value) {
                this.classList.remove('is-invalid');
                document.getElementById('confirmPasswordError').classList.remove('show');
            }
        });
    </script>
</body>
</html>
