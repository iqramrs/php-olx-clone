<?php

/**
 * Database Configuration
 * 
 * File ini menghubungkan aplikasi dengan database MySQL
 * Menggunakan PDO untuk keamanan dan fleksibilitas
 */

// Konfigurasi Database
$db_config = [
    'host' => 'localhost',
    'db_name' => 'olx_clone',
    'db_user' => 'root',
    'db_password' => '', // Sesuaikan dengan password XAMPP Anda jika ada
    'charset' => 'utf8mb4',
    'port' => 3306
];

try {
    // Membuat DSN (Data Source Name)
    $dsn = "mysql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['db_name']};charset={$db_config['charset']}";

    // Membuat koneksi PDO
    $pdo = new PDO($dsn, $db_config['db_user'], $db_config['db_password']);

    // Set error mode ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tampilkan error message yang aman
    error_log("Database Connection Error: " . $e->getMessage());

    http_response_code(500);
    die("
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Database Connection Error</title>
            <style>
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
                    background: linear-gradient(135deg, #001f2e 0%, #003d4d 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                    margin: 0;
                }
                .error-container {
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
                    padding: 40px;
                    max-width: 500px;
                    text-align: center;
                }
                h1 {
                    color: #f44336;
                    margin-bottom: 16px;
                    font-size: 28px;
                }
                p {
                    color: #666;
                    line-height: 1.6;
                    margin: 12px 0;
                    font-size: 14px;
                }
                .details {
                    background: #f5f5f5;
                    padding: 20px;
                    border-radius: 6px;
                    text-align: left;
                    margin-top: 24px;
                    border-left: 4px solid #f44336;
                }
                .details ul {
                    margin: 10px 0;
                    padding-left: 20px;
                }
                .details li {
                    margin: 6px 0;
                    font-size: 13px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class='error-container'>
                <h1>⚠️ Database Connection Error</h1>
                <p>Tidak dapat terhubung ke database MySQL.</p>
                <p>Silakan periksa konfigurasi database Anda.</p>
                <div class='details'>
                    <strong>Langkah Troubleshooting:</strong>
                    <ul>
                        <li>✓ Pastikan MySQL/MariaDB sudah berjalan</li>
                        <li>✓ Periksa konfigurasi di config/database.php</li>
                        <li>✓ Pastikan database 'olx_clone' sudah dibuat</li>
                        <li>✓ Jalankan database/schema.sql untuk membuat tabel</li>
                        <li>✓ Periksa username dan password database</li>
                    </ul>
                </div>
            </div>
        </body>
        </html>
    ");
}
