<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Dell XPS 13 Bekas Seperti Baru - OLX Clone</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --primary-color: #002f34;
            --secondary-color: #ffd500;
            --light-gray: #f5f5f5;
            --border-color: #e6e6e6;
        }
        
        .thumbnail-image {
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        
        .thumbnail-image:hover,
        .thumbnail-image.active {
            border-color: var(--secondary-color);
        }

        .main-image-container {
            background-color: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
        }

        .main-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-5" href="index.php" style="color: var(--primary-color);">
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
                    <a href="auth/login.php" class="nav-link">Login</a>
                    <a href="auth/register.php" class="nav-link">Daftar</a>
                    <a href="ads/create.php" class="btn ms-2" style="background-color: var(--secondary-color); color: var(--primary-color);" role="button">
                        <i class="fas fa-plus me-1"></i> Jual
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- BREADCRUMB -->
    <section class="py-3" style="background-color: var(--light-gray);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php" style="color: var(--primary-color);">Home</a></li>
                    <li class="breadcrumb-item"><a href="category.php?id=1" style="color: var(--primary-color);">Elektronik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laptop Dell XPS 13</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- DETAIL SECTION -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- IMAGE GALLERY -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <!-- Main Image -->
                            <div class="main-image-container" id="mainImageContainer">
                                <img src="https://placehold.co/600x400" alt="Laptop Dell XPS 13" id="mainImage">
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            <div class="p-3">
                                <div class="row g-2">
                                    <div class="col-3">
                                        <img src="https://placehold.co/600x400" alt="Image 1" class="img-thumbnail thumbnail-image active" onclick="changeImage(this.src)">
                                    </div>
                                    <div class="col-3">
                                        <img src="https://placehold.co/600x400" alt="Image 2" class="img-thumbnail thumbnail-image" onclick="changeImage(this.src)">
                                    </div>
                                    <div class="col-3">
                                        <img src="https://placehold.co/600x400" alt="Image 3" class="img-thumbnail thumbnail-image" onclick="changeImage(this.src)">
                                    </div>
                                    <div class="col-3">
                                        <img src="https://placehold.co/600x400" alt="Image 4" class="img-thumbnail thumbnail-image" onclick="changeImage(this.src)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3" style="color: var(--primary-color);">Deskripsi Iklan</h4>
                            <p class="text-muted" style="white-space: pre-line; line-height: 1.8;">Jual Laptop Dell XPS 13 dalam kondisi bekas seperti baru. 

Spesifikasi:
- Processor: Intel Core i7 Gen 11
- RAM: 16GB DDR4
- Storage: 512GB NVMe SSD
- Display: 13.4" FHD+ (1920x1200) Touchscreen
- Graphics: Intel Iris Xe
- Battery: Masih awet 6-8 jam pemakaian normal
- Kondisi: 95% mulus, no minus

Kelengkapan:
✓ Unit laptop
✓ Charger original
✓ Box dan dus original
✓ Nota pembelian (garansi resmi masih berlaku 6 bulan)

Alasan jual: Upgrade ke model terbaru
Laptop sangat terawat, jarang dibawa keluar rumah.
Cocok untuk profesional, mahasiswa, atau content creator.

Harga masih bisa nego tipis kalau serius.
Lokasi: Jakarta Pusat, bisa COD atau kirim via JNE/Gojek.

Minat serius langsung chat atau telpon!
No hit and run ya, terima kasih 🙏</p>
                        </div>
                    </div>

                    <!-- SIMILAR ADS -->
                    <div class="mt-4">
                        <h4 class="fw-bold mb-3" style="color: var(--primary-color);">Iklan Serupa</h4>
                        <div class="row g-3">
                            <!-- Similar Ad 1 -->
                            <div class="col-6 col-md-4">
                                <a href="detail.php?id=2" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm hover-lift">
                                        <img src="https://placehold.co/250x200" alt="MacBook" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-truncate small">MacBook Air M1 2020 256GB</h6>
                                            <p class="fw-bold mb-1" style="color: var(--primary-color); font-size: 14px;">Rp 10.500.000</p>
                                            <p class="text-muted small mb-0">Jakarta Selatan</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Similar Ad 2 -->
                            <div class="col-6 col-md-4">
                                <a href="detail.php?id=3" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm hover-lift">
                                        <img src="https://placehold.co/250x200" alt="Asus" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-truncate small">Asus ROG Gaming Laptop</h6>
                                            <p class="fw-bold mb-1" style="color: var(--primary-color); font-size: 14px;">Rp 8.500.000</p>
                                            <p class="text-muted small mb-0">Bandung</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Similar Ad 3 -->
                            <div class="col-6 col-md-4">
                                <a href="detail.php?id=4" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm hover-lift">
                                        <img src="https://placehold.co/250x200" alt="Lenovo" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-truncate small">Lenovo ThinkPad X1 Carbon</h6>
                                            <p class="fw-bold mb-1" style="color: var(--primary-color); font-size: 14px;">Rp 7.200.000</p>
                                            <p class="text-muted small mb-0">Surabaya</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR INFO -->
                <div class="col-lg-4">
                    <!-- PRICE & ACTION -->
                    <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="fw-bold mb-0" style="color: var(--primary-color); font-size: 32px;">Rp 5.500.000</h2>
                                    <p class="text-muted small mb-0">Harga bisa nego</p>
                                </div>
                                <button class="btn btn-light" id="favoriteBtn" onclick="toggleFavorite()">
                                    <i class="far fa-heart fa-lg"></i>
                                </button>
                            </div>

                            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Laptop Dell XPS 13 Bekas Seperti Baru</h5>

                            <div class="mb-3">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                    <span class="ms-2">Jakarta Pusat</span>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-muted"></i>
                                    <span class="ms-2 text-muted">Diposting 2 jam yang lalu</span>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-tag text-muted"></i>
                                    <a href="category.php?id=1" class="ms-2 text-decoration-none" style="color: var(--primary-color);">Elektronik</a>
                                </p>
                            </div>

                            <hr>

                            <!-- SELLER INFO -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Informasi Penjual</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user fa-lg text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold">Ahmad Fauzi</h6>
                                        <p class="text-muted small mb-0">Bergabung sejak Jan 2024</p>
                                    </div>
                                </div>
                                <a href="profile.php?id=1" class="btn btn-outline-secondary w-100 mb-2">
                                    <i class="fas fa-user me-2"></i>Lihat Profil
                                </a>
                            </div>

                            <hr>

                            <!-- CONTACT BUTTONS -->
                            <div>
                                <button class="btn w-100 mb-2 py-3" style="background-color: var(--secondary-color); color: var(--primary-color); font-weight: bold; font-size: 16px;">
                                    <i class="fas fa-phone me-2"></i>Hubungi Penjual
                                </button>
                                <button class="btn btn-outline-dark w-100 py-3" style="font-weight: bold; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#chatModal">
                                    <i class="fas fa-comment-dots me-2"></i>Chat
                                </button>
                            </div>

                            <div class="mt-3">
                                <div class="alert alert-warning small mb-0" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Tips Aman Berbelanja:</strong>
                                    <ul class="mb-0 mt-2 ps-3">
                                        <li>Bertemu langsung dengan penjual</li>
                                        <li>Periksa barang sebelum membayar</li>
                                        <li>Jangan transfer uang sebelum melihat barang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AD DETAILS -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Detail Iklan</h6>
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-muted">ID Iklan</td>
                                        <td class="fw-bold text-end">#AD00001</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kondisi</td>
                                        <td class="text-end">
                                            <span class="badge bg-warning text-dark">Bekas</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Dilihat</td>
                                        <td class="fw-bold text-end">1,234 kali</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Disimpan</td>
                                        <td class="fw-bold text-end">56 kali</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SHARE -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Bagikan</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary flex-fill">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info flex-fill">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success flex-fill">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CHAT MODAL -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="modal-title">Chat dengan Penjual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pesan Anda</label>
                            <textarea class="form-control" rows="4" placeholder="Halo, saya tertarik dengan produk Anda..."></textarea>
                        </div>
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-2"></i>
                            Silakan login terlebih dahulu untuk dapat mengirim pesan ke penjual.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="auth/login.php" class="btn" style="background-color: var(--secondary-color); color: var(--primary-color);">Login untuk Chat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer style="background-color: var(--primary-color); color: white;" class="mt-5">
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
        // Change main image when clicking thumbnail
        function changeImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail-image').forEach(img => {
                img.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Toggle favorite button
        function toggleFavorite() {
            const btn = document.getElementById('favoriteBtn');
            const icon = btn.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.classList.remove('btn-light');
                btn.classList.add('btn-danger');
                btn.style.color = 'white';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-light');
                btn.style.color = '';
            }
        }

        // Hover effect for similar ads
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Phone number reveal (example)
        document.querySelector('.btn[style*="background-color: var(--secondary-color)"]').addEventListener('click', function() {
            alert('Nomor Telepon: 0812-3456-7890\n\nHubungi penjual untuk informasi lebih lanjut.');
        });
    </script>
</body>
</html>
