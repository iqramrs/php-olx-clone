<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';

$error = '';
$success = '';
$categories = [];

// Fetch categories from database
try {
    $query = "SELECT id, name FROM categories ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'Gagal memuat kategori. Coba lagi nanti.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title'] ?? ''));
    $category_id = intval($_POST['category_id'] ?? 0);
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $price = floatval($_POST['price'] ?? 0);
    $location = htmlspecialchars(trim($_POST['location'] ?? ''));

    // Validation (required fields per app logic)
    if (empty($title)) {
        $error = 'Judul iklan wajib diisi!';
    } elseif (strlen($title) > 50) {
        $error = 'Judul iklan maksimal 50 karakter!';
    } elseif ($category_id <= 0) {
        $error = 'Kategori wajib dipilih!';
    } elseif (empty($description)) {
        $error = 'Deskripsi wajib diisi!';
    } elseif ($price <= 0) {
        $error = 'Harga harus lebih dari 0!';
    } elseif (empty($location)) {
        $error = 'Lokasi wajib diisi!';
    } else {
        try {
            // Prepare uploads (images optional per schema)
            $images = $_FILES['images'] ?? null;

            // Create ads directory if not exists
            $ads_dir = __DIR__ . '/assets/ads';
            if (!is_dir($ads_dir)) {
                mkdir($ads_dir, 0755, true);
            }

            // Start transaction
            $pdo->beginTransaction();

            // Generate slug
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

            // Location is required by app; use as provided
            $location_val = $location;

            // Format price to 2 decimals to match DECIMAL(15,2)
            $price_val = number_format($price, 2, '.', '');

            // Insert ad (let DB handle release_at default)
            $query = "INSERT INTO ads (title, slug, description, price, location, user_id, category_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$title, $slug, $description, $price_val, $location_val, $_SESSION['user_id'], $category_id]);
            
            $ad_id = $pdo->lastInsertId();

            // Upload images if provided and insert into ad_images (no count/type/size restrictions here)
            if ($images && !empty(array_filter($images['name']))) {
                $image_query = "INSERT INTO ad_images (ad_id, image) VALUES (?, ?)";
                $image_stmt = $pdo->prepare($image_query);

                $count = count($images['name']);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($images['name'][$i]) && $images['error'][$i] === UPLOAD_ERR_OK) {
                        $ext = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
                        $safe_ext = $ext ? strtolower($ext) : 'jpg';
                        $file_name = $ad_id . '_' . ($i + 1) . '_' . time() . '.' . $safe_ext;
                        $destination = $ads_dir . '/' . $file_name;

                        if (move_uploaded_file($images['tmp_name'][$i], $destination)) {
                            $relative_path = 'assets/ads/' . $file_name;
                            $image_stmt->execute([$ad_id, $relative_path]);
                        } else {
                            throw new Exception('Gagal mengupload foto.');
                        }
                    }
                }
            }

            $pdo->commit();
            $success = 'Iklan berhasil diposting!';

            // Redirect after 2 seconds
            header('Refresh: 2; url=landingPage.php');
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            $error = 'Gagal memposting iklan. Coba lagi nanti.';
        }
    }
}
?>
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

        .alert-success, .alert-danger {
            margin-bottom: 20px;
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
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a href="landingPage.php" class="nav-link">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
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
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form action="postAd.php" method="POST" enctype="multipart/form-data" id="postAdForm">
                
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
                        <div class="error-message" id="titleError"></div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="categoryError"></div>
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
                        <div class="error-message" id="descriptionError"></div>
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
                        <div class="error-message" id="imagesError"></div>
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
                            <input type="number" class="form-control" id="price" name="price" placeholder="0" required min="0" step="1000">
                        </div>
                        <small class="text-muted">Masukkan harga tanpa titik atau koma</small>
                        <div class="error-message" id="priceError"></div>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-4">
                        <label for="location" class="form-label fw-semibold">
                            Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Masukkan lokasi" list="locationList" required>
                        <datalist id="locationList">
                            <option value="Jakarta Pusat">
                            <option value="Jakarta Barat">
                            <option value="Jakarta Timur">
                            <option value="Jakarta Selatan">
                            <option value="Jakarta Utara">
                            <option value="Bandung">
                            <option value="Surabaya">
                            <option value="Semarang">
                            <option value="Yogyakarta">
                            <option value="Medan">
                            <option value="Bekasi">
                            <option value="Tangerang">
                            <option value="Depok">
                            <option value="Bogor">
                        </datalist>
                        <div class="error-message" id="locationError"></div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="form-section">
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="landingPage.php" class="btn btn-cancel px-5">
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

        // Preview images
        function previewImages(event) {
            const files = Array.from(event.target.files);
            const container = document.getElementById('imagePreviewContainer');

            // Limit to 5 images
            if (selectedFiles.length + files.length > 5) {
                showError('imagesError', 'Maksimal 5 foto!');
                event.target.value = '';
                return;
            }

            // Check file size (max 2MB per file)
            for (let file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    showError('imagesError', `File ${file.name} terlalu besar! Maksimal 2MB per foto.`);
                    event.target.value = '';
                    return;
                }
            }

            // Check file type
            for (let file of files) {
                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                    showError('imagesError', 'Format file tidak didukung! Gunakan JPG atau PNG.');
                    event.target.value = '';
                    return;
                }
            }

            // Clear error if files are valid
            document.getElementById('imagesError').classList.remove('show');

            files.forEach((file) => {
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

        // Helper function to show error message
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }

        // Form validation
        document.getElementById('postAdForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title');
            const category = document.getElementById('category');
            const description = document.getElementById('description');
            const price = document.getElementById('price');
            const location = document.getElementById('location');

            // Reset error messages
            document.getElementById('titleError').classList.remove('show');
            document.getElementById('categoryError').classList.remove('show');
            document.getElementById('descriptionError').classList.remove('show');
            document.getElementById('priceError').classList.remove('show');
            document.getElementById('imagesError').classList.remove('show');
            document.getElementById('locationError').classList.remove('show');

            // Reset input styling
            title.classList.remove('is-invalid');
            category.classList.remove('is-invalid');
            description.classList.remove('is-invalid');
            price.classList.remove('is-invalid');
            location.classList.remove('is-invalid');

            let isValid = true;

            // Validate title
            if (!title.value.trim()) {
                showError('titleError', 'Judul iklan wajib diisi!');
                title.classList.add('is-invalid');
                isValid = false;
            } else if (title.value.length > 50) {
                showError('titleError', 'Judul iklan maksimal 50 karakter!');
                title.classList.add('is-invalid');
                isValid = false;
            }

            // Validate category
            if (!category.value) {
                showError('categoryError', 'Kategori wajib dipilih!');
                category.classList.add('is-invalid');
                isValid = false;
            }

            // Validate description
            if (!description.value.trim()) {
                showError('descriptionError', 'Deskripsi wajib diisi!');
                description.classList.add('is-invalid');
                isValid = false;
            } else if (description.value.length > 2000) {
                showError('descriptionError', 'Deskripsi maksimal 2000 karakter!');
                description.classList.add('is-invalid');
                isValid = false;
            }

            // Validate price
            if (!price.value || parseFloat(price.value) <= 0) {
                showError('priceError', 'Harga harus lebih dari 0!');
                price.classList.add('is-invalid');
                isValid = false;
            }

            // Validate location
            if (!location.value.trim()) {
                showError('locationError', 'Lokasi wajib diisi!');
                location.classList.add('is-invalid');
                isValid = false;
            }

            // Validate images
            if (selectedFiles.length === 0) {
                showError('imagesError', 'Minimal upload 1 foto produk!');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            return true;
        });

        // Real-time validation
        document.getElementById('title').addEventListener('blur', function() {
            if (this.value.trim() && this.value.length <= 50) {
                this.classList.remove('is-invalid');
                document.getElementById('titleError').classList.remove('show');
            }
        });

        document.getElementById('category').addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                document.getElementById('categoryError').classList.remove('show');
            }
        });

        document.getElementById('description').addEventListener('blur', function() {
            if (this.value.trim() && this.value.length <= 2000) {
                this.classList.remove('is-invalid');
                document.getElementById('descriptionError').classList.remove('show');
            }
        });

        document.getElementById('price').addEventListener('blur', function() {
            if (this.value && parseFloat(this.value) > 0) {
                this.classList.remove('is-invalid');
                document.getElementById('priceError').classList.remove('show');
            }
        });

        document.getElementById('location').addEventListener('blur', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                document.getElementById('locationError').classList.remove('show');
            }
        });
    </script>
</body>
</html>
