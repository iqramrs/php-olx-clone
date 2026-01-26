<?php
/**
 * Database Configuration File
 * OLX Clone - PDO Connection
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'olx_clone');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
];

// Create PDO instance
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log error (in production, log to file instead of displaying)
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Display user-friendly error
    die("Database connection failed. Please try again later.");
}

/**
 * Helper function to execute prepared statements
 * 
 * @param PDO $pdo PDO instance
 * @param string $sql SQL query
 * @param array $params Parameters to bind
 * @return PDOStatement
 */
function executeQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Helper function to fetch single row
 * 
 * @param PDO $pdo PDO instance
 * @param string $sql SQL query
 * @param array $params Parameters to bind
 * @return array|false
 */
function fetchOne($pdo, $sql, $params = []) {
    $stmt = executeQuery($pdo, $sql, $params);
    return $stmt->fetch();
}

/**
 * Helper function to fetch all rows
 * 
 * @param PDO $pdo PDO instance
 * @param string $sql SQL query
 * @param array $params Parameters to bind
 * @return array
 */
function fetchAll($pdo, $sql, $params = []) {
    $stmt = executeQuery($pdo, $sql, $params);
    return $stmt->fetchAll();
}

/**
 * Helper function to get last insert ID
 * 
 * @param PDO $pdo PDO instance
 * @return string
 */
function getLastInsertId($pdo) {
    return $pdo->lastInsertId();
}

/**
 * Helper function to start transaction
 * 
 * @param PDO $pdo PDO instance
 */
function beginTransaction($pdo) {
    $pdo->beginTransaction();
}

/**
 * Helper function to commit transaction
 * 
 * @param PDO $pdo PDO instance
 */
function commitTransaction($pdo) {
    $pdo->commit();
}

/**
 * Helper function to rollback transaction
 * 
 * @param PDO $pdo PDO instance
 */
function rollbackTransaction($pdo) {
    $pdo->rollBack();
}

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL configuration
define('BASE_URL', 'http://localhost/olx_clone/');

// Upload directory configuration
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');

// Create upload directory if not exists
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}
