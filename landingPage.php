<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLX Clone - Jual Beli Online Terpercaya</title>
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
                    <a href="login.php" class="nav-link">Login</a>
                    <a href="postAd.php" class="btn ms-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">
                        <i class="fas fa-plus me-1"></i> Jual
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white; padding: 60px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-5 fw-bold mb-3">Jual Beli Barang Bekas & Baru</h1>
                    <p class="lead mb-4">Temukan barang yang Anda inginkan dengan harga terbaik dari seluruh Indonesia</p>
                </div>
                <div class="col-lg-6">
                    <form action="search.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="query" class="form-control form-control-lg" placeholder="Cari di seluruh Indonesia..." required>
                            <button class="btn btn-warning" style="background-color: var(--secondary-color); border: none;" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- KATEGORI SECTION -->
    <section class="py-5" style="background-color: var(--light-gray);">
        <div class="container">
            <h2 class="mb-4 fw-bold" style="color: var(--primary-color);">Jelajahi Kategori</h2>
            <div class="row g-3">
                <!-- Kategori 1 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=1" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-mobile-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Elektronik</h5>
                                <p class="text-muted small">1,234 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 2 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=2" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-home fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Properti</h5>
                                <p class="text-muted small">567 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 3 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=3" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-car fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Kendaraan</h5>
                                <p class="text-muted small">892 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 4 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=4" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-shirt fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Fashion</h5>
                                <p class="text-muted small">2,145 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 5 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=5" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-gamepad fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Hobi & Hiburan</h5>
                                <p class="text-muted small">678 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 6 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=6" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-book fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Buku & Media</h5>
                                <p class="text-muted small">456 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 7 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php?id=7" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-couch fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Furniture</h5>
                                <p class="text-muted small">789 Iklan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kategori 8 -->
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="category.php" class="text-decoration-none">
                        <div class="card border-0 h-100 text-center shadow-sm hover-shadow">
                            <div class="card-body py-4">
                                <i class="fas fa-th-large fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5 class="card-title" style="color: var(--primary-color);">Semua Kategori</h5>
                                <p class="text-muted small">Lihat Semua</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FILTER & ADS SECTION -->
    <section class="py-5">
        <div class="container-fluid px-4">
            <div class="row">
                <!-- SIDEBAR FILTER -->
                <aside class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-bottom" style="background-color: var(--light-gray);">
                            <h5 class="mb-0" style="color: var(--primary-color);">Filter Pencarian</h5>
                        </div>
                        <div class="card-body">
                            <!-- Harga Filter -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Harga (Rp)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" placeholder="Min" class="form-control" id="minPrice" min="0">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" placeholder="Max" class="form-control" id="maxPrice">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Lokasi Filter -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Lokasi</label>
                                <select class="form-select">
                                    <option value="">Semua Lokasi</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="surabaya">Surabaya</option>
                                    <option value="bandung">Bandung</option>
                                    <option value="medan">Medan</option>
                                    <option value="semarang">Semarang</option>
                                </select>
                            </div>

                            <hr>

                            <!-- Kondisi Filter -->
                            <div class="mb-4">
                                <label class="fw-bold" style="color: var(--primary-color);">Kondisi</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="condition1" value="baru">
                                    <label class="form-check-label" for="condition1">Baru</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="condition2" value="bekas">
                                    <label class="form-check-label" for="condition2">Bekas</label>
                                </div>
                            </div>

                            <hr>

                            <!-- Urutkan -->
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: var(--primary-color);">Urutkan Berdasarkan</label>
                                <select class="form-select">
                                    <option value="">Terbaru</option>
                                    <option value="price-asc">Harga Terendah</option>
                                    <option value="price-desc">Harga Tertinggi</option>
                                    <option value="popular">Paling Populer</option>
                                </select>
                            </div>

                            <button class="btn w-100" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: bold;">Terapkan Filter</button>
                        </div>
                    </div>
                </aside>

                <!-- MAIN ADS GRID -->
                <main class="col-lg-9">
                    <div class="mb-4">
                        <h2 class="fw-bold" style="color: var(--primary-color);">Iklan Terbaru</h2>
                    </div>
                    
                    <div class="row g-3">
                        <!-- CARD IKLAN 1 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=1" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Laptop Dell XPS" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Baru</span>
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Laptop Dell XPS 13 Bekas Seperti Baru</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 5.500.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Jakarta Pusat
                                        </p>
                                        <p class="text-muted small">2 jam yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 2 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=2" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="iPhone 12" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Baru</span>
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">iPhone 12 Pro Max 256GB</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 8.900.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Bandung
                                        </p>
                                        <p class="text-muted small">4 jam yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 3 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=3" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Sepeda Motor" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Honda PCX 150 2021 Istimewa</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 18.500.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Surabaya
                                        </p>
                                        <p class="text-muted small">6 jam yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 4 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=4" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Apartemen" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Baru</span>
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Apartemen 2 Kamar Tidur Mewah</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 450.000.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Jakarta Selatan
                                        </p>
                                        <p class="text-muted small">1 hari yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 5 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=5" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Sofa" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Sofa Kulit Premium Bekas</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 2.500.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Bandung
                                        </p>
                                        <p class="text-muted small">1 hari yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 6 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=6" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Kamera DSLR" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Baru</span>
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Canon EOS 80D Lengkap Lensa</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 6.200.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Jakarta Utara
                                        </p>
                                        <p class="text-muted small">2 hari yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 7 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=7" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Jam Tangan" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Rolex Submariner Automatic</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 25.000.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Jakarta Pusat
                                        </p>
                                        <p class="text-muted small">3 hari yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- CARD IKLAN 8 -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="detail.php?id=8" class="text-decoration-none text-dark">
                                <div class="card border-0 h-100 shadow-sm hover-lift">
                                    <div class="position-relative">
                                        <img src="https://placehold.co/600x400" alt="Buku" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate" style="color: var(--primary-color);">Buku Pemrograman PHP & MySQL</h6>
                                        <p class="fw-bold mb-2" style="color: var(--secondary-color); font-size: 18px;">Rp 85.000</p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fas fa-map-marker-alt"></i> Surabaya
                                        </p>
                                        <p class="text-muted small">3 hari yang lalu</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- PAGINATION -->
                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#" style="background-color: var(--secondary-color); color: var(--primary-color);">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">4</a>
                            </li>
                            <li class="page-item disabled">
                                <span class="page-link" style="color: var(--primary-color);">...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">10</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="color: var(--primary-color);">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </main>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, #004d54 100%); color: white; padding: 60px 0; margin: 40px 0;">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-3">Punya Barang untuk Dijual?</h2>
            <p class="lead mb-4">Mulai berjualan hari ini dan dapatkan pembeli yang tepat untuk barang Anda</p>
            <a href="postAd.php" class="btn btn-warning btn-lg" style="background-color: var(--secondary-color); border: none; color: var(--primary-color); font-weight: bold;">
                <i class="fas fa-plus me-2"></i>Posting Iklan Gratis
            </a>
        </div>
    </section>

    <!-- FOOTER -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add hover effects to cards
        const cards = document.querySelectorAll('.hover-lift');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Heart favorite toggle
        const favoriteButtons = document.querySelectorAll('.btn-light[style*="border-radius"]');
        favoriteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.backgroundColor = '#ffcccc';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.backgroundColor = '';
                }
            });
        });
    </script>
</body>
</html>
