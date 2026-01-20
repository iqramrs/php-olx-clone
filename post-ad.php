<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Iklan - OLX Clone</title>
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
        }

        .form-section {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 20px;
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
            transition: all 0.3s;
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
            transition: all 0.3s;
        }

        .btn-secondary-custom:hover {
            background-color: #ffd700;
            color: var(--primary-color);
        }

        .image-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #fafafa;
        }

        .image-upload-area:hover {
            border-color: var(--primary-color);
            background-color: #f0f0f0;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #dee2e6;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }

        .image-preview .remove-btn:hover {
            background-color: #dc3545;
        }

        .character-counter {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .price-input-group .input-group-text {
            background-color: var(--light-gray);
            font-weight: 600;
        }

        .btn-cancel {
            background-color: white;
            border: 2px solid #dc3545;
            color: #dc3545;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
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
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                    <a href="login.php" class="nav-link">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <section class="py-4" style="background-color: var(--primary-color);">
        <div class="container">
            <h1 class="text-white fw-bold mb-2">
                <i class="fas fa-bullhorn me-2"></i>Posting Iklan Gratis
            </h1>
            <p class="text-white-50 mb-0">Lengkapi informasi produk Anda dengan detail</p>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="py-5">
        <div class="container">
            <form action="ads/create_process.php" method="POST" enctype="multipart/form-data" id="postAdForm">
                
                <!-- INFORMASI PRODUK -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>Informasi Produk
                    </h2>

                    <!-- Judul Iklan -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">
                            Judul Iklan <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="title" name="title" maxlength="50" placeholder="Contoh: Laptop Dell XPS 13 Bekas Seperti Baru" required oninput="updateCounter('title', 'titleCounter', 50)">
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Buat judul yang jelas dan menarik</small>
                            <small class="character-counter"><span id="titleCounter">0</span>/50</small>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <option value="1">Elektronik</option>
                            <option value="2">Properti</option>
                            <option value="3">Kendaraan</option>
                            <option value="4">Fashion</option>
                            <option value="5">Hobi & Hiburan</option>
                            <option value="6">Buku & Media</option>
                            <option value="7">Furniture</option>
                            <option value="8">Lainnya</option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="6" placeholder="Jelaskan kondisi produk, spesifikasi, alasan jual, dll." required oninput="updateCounter('description', 'descCounter', 2000)" maxlength="2000"></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Jelaskan produk Anda sedetail mungkin</small>
                            <small class="character-counter"><span id="descCounter">0</span>/2000</small>
                        </div>
                    </div>
                </div>

                <!-- FOTO PRODUK -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-camera me-2"></i>Foto Produk
                    </h2>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Upload Foto <span class="text-danger">*</span>
                        </label>
                        <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-2 fw-semibold">Klik untuk upload foto</p>
                            <small class="text-muted">Maksimal 5 foto, ukuran maks 2MB per foto</small>
                            <small class="text-muted d-block">Format: JPG, PNG, JPEG</small>
                        </div>
                        <input type="file" id="imageInput" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple style="display: none;" onchange="previewImages(event)">
                    </div>

                    <div class="image-preview-container" id="imagePreviewContainer"></div>

                    <div class="alert alert-info small mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tips:</strong> Gunakan foto yang jelas dan terang. Foto pertama akan menjadi foto utama iklan Anda.
                    </div>
                </div>

                <!-- HARGA & LOKASI -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-tag me-2"></i>Harga & Lokasi
                    </h2>

                    <!-- Harga -->
                    <div class="mb-4">
                        <label for="price" class="form-label fw-semibold">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="input-group price-input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="price" name="price" placeholder="0" required min="0" step="1000" oninput="formatPrice(this)">
                        </div>
                        <small class="text-muted">Masukkan harga tanpa titik atau koma</small>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-4">
                        <label for="location" class="form-label fw-semibold">
                            Lokasi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="location" name="location" required>
                            <option value="" selected disabled>Pilih Kota/Kabupaten</option>
                            <option value="Jakarta Pusat">Jakarta Pusat</option>
                            <option value="Jakarta Barat">Jakarta Barat</option>
                            <option value="Jakarta Timur">Jakarta Timur</option>
                            <option value="Jakarta Selatan">Jakarta Selatan</option>
                            <option value="Jakarta Utara">Jakarta Utara</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Semarang">Semarang</option>
                            <option value="Yogyakarta">Yogyakarta</option>
                            <option value="Medan">Medan</option>
                            <option value="Bekasi">Bekasi</option>
                            <option value="Tangerang">Tangerang</option>
                            <option value="Depok">Depok</option>
                            <option value="Bogor">Bogor</option>
                        </select>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="form-section">
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="index.php" class="btn btn-cancel px-5">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-secondary-custom px-5">
                            <i class="fas fa-paper-plane me-2"></i>Posting Iklan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background-color: var(--primary-color); color: white;">
        <div class="container py-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2026 OLX Clone. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedFiles = [];

        // Update character counter
        function updateCounter(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            counter.textContent = input.value.length;

            if (input.value.length >= maxLength) {
                counter.style.color = '#dc3545';
            } else {
                counter.style.color = '#6c757d';
            }
        }

        // Format price with thousand separator
        function formatPrice(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // Preview images
        function previewImages(event) {
            const files = Array.from(event.target.files);
            const container = document.getElementById('imagePreviewContainer');

            // Limit to 5 images
            if (selectedFiles.length + files.length > 5) {
                alert('Maksimal 5 foto!');
                return;
            }

            // Check file size (max 2MB per file)
            for (let file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar! Maksimal 2MB per foto.`);
                    return;
                }
            }

            files.forEach((file, index) => {
                if (selectedFiles.length >= 5) return;

                selectedFiles.push(file);
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn" onclick="removeImage(${selectedFiles.length - 1})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    container.appendChild(preview);
                };

                reader.readAsDataURL(file);
            });

            updateFileInput();
        }

        // Remove image
        function removeImage(index) {
            selectedFiles.splice(index, 1);
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';

            selectedFiles.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn" onclick="removeImage(${idx})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    container.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });

            updateFileInput();
        }

        // Update file input
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('imageInput').files = dataTransfer.files;
        }

        // Form validation
        document.getElementById('postAdForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value;
            const category = document.getElementById('category').value;
            const description = document.getElementById('description').value;
            const price = document.getElementById('price').value;
            const location = document.getElementById('location').value;
            const images = selectedFiles.length;

            if (!title || !category || !description || !price || !location) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return false;
            }

            if (images === 0) {
                e.preventDefault();
                alert('Minimal upload 1 foto produk!');
                return false;
            }

            if (price <= 0) {
                e.preventDefault();
                alert('Harga harus lebih dari 0!');
                return false;
            }

            return true;
        });
    </script>
</body>
</html>
