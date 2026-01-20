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
                    <form action="auth/login_process.php" method="POST">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email atau Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email atau username" required>
                            </div>
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
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('Mohon lengkapi semua field!');
                return false;
            }
        });
    </script>
</body>
</html>
