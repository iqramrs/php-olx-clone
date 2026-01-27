<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';

// Fetch ads
$ads = [];
try {
    $query = "SELECT 
                a.id, 
                a.title, 
                a.slug, 
                a.price, 
                a.location,
                a.release_at,
                c.name as category_name,
                (SELECT image FROM ad_images WHERE ad_id = a.id ORDER BY id ASC LIMIT 1) as first_image
              FROM ads a
              LEFT JOIN categories c ON a.category_id = c.id
              ORDER BY a.id DESC
              LIMIT 24";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $ads = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
    die();
}

echo "<h1>Test Ads Display</h1>";
echo "<p>Total ads found: " . count($ads) . "</p>";

if (empty($ads)) {
    echo "<p style='color: red;'>No ads found!</p>";
} else {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Title</th><th>Price</th><th>Location</th><th>Image Path</th><th>Image Exists?</th></tr>";
    foreach ($ads as $ad) {
        $imagePath = $ad['first_image'];
        $imageExists = $imagePath && file_exists($imagePath) ? 'YES ✓' : 'NO ✗';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($ad['id']) . "</td>";
        echo "<td>" . htmlspecialchars($ad['title']) . "</td>";
        echo "<td>Rp " . number_format($ad['price'], 0, ',', '.') . "</td>";
        echo "<td>" . htmlspecialchars($ad['location']) . "</td>";
        echo "<td>" . htmlspecialchars($imagePath ?: 'NULL') . "</td>";
        echo "<td>" . $imageExists . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<hr><h2>Image Preview</h2>";
    foreach ($ads as $ad) {
        if ($ad['first_image']) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px; display: inline-block;'>";
            echo "<h3>" . htmlspecialchars($ad['title']) . "</h3>";
            echo "<img src='" . htmlspecialchars($ad['first_image']) . "' alt='" . htmlspecialchars($ad['title']) . "' style='max-width: 300px;'>";
            echo "</div>";
        }
    }
}
?>
