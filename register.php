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

            <!-- Register Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="auth/register_process.php" method="POST" id="registerForm">
                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="username_unik" required>
                            </div>
                            <small class="text-muted">Username harus unik dan minimal 4 karakter</small>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxxx" required>
                            </div>
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
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label small" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary-custom text-decoration-none">Syarat & Ketentuan</a> 
                                dan <a href="#" class="text-primary-custom text-decoration-none">Kebijakan Privasi</a>
                            </label>
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
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const username = document.getElementById('username').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const terms = document.getElementById('terms').checked;

            // Check if all fields are filled
            if (!fullname || !email || !username || !phone || !password || !confirmPassword) {
                e.preventDefault();
                alert('Mohon lengkapi semua field!');
                return false;
            }

            // Check username length
            if (username.length < 4) {
                e.preventDefault();
                alert('Username minimal 4 karakter!');
                return false;
            }

            // Check password length
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                return false;
            }

            // Check password match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama!');
                return false;
            }

            // Check phone format
            if (!phone.match(/^08[0-9]{9,11}$/)) {
                e.preventDefault();
                alert('Format nomor telepon tidak valid! Gunakan format: 08xxxxxxxxxx');
                return false;
            }

            // Check terms
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan!');
                return false;
            }

            return true;
        });
    </script>
</body>
</html>
