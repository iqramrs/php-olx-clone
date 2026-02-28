<?php
http_response_code(500);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .error-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card error-card text-center">
                    <div class="card-body p-5">
                        <i class="fas fa-triangle-exclamation fa-4x mb-3" style="color: #dc3545;"></i>
                        <h1 class="fw-bold mb-2" style="color: var(--primary-color);">500</h1>
                        <h5 class="mb-3">Terjadi kesalahan pada server</h5>
                        <p class="text-muted mb-4">Silakan coba lagi beberapa saat. Jika masalah berlanjut, kembali ke beranda.</p>
                        <a href="landingPage.php" class="btn" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: 600;">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
