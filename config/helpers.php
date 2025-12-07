<?php

/**
 * Helper Functions
 * File ini berisi fungsi-fungsi pembantu untuk project
 */

/**
 * Format harga ke format Rupiah
 * 
 * @param float $price
 * @return string
 */
function formatPrice($price)
{
    return 'Rp ' . number_format($price, 0, ',', '.');
}

/**
 * Format waktu posting secara relatif
 * 
 * @param string $datetime
 * @return string
 */
function formatTimeAgo($datetime)
{
    $createdAt = new DateTime($datetime);
    $now = new DateTime();
    $interval = $now->diff($createdAt);

    if ($interval->d == 0) {
        if ($interval->h == 0) {
            return $interval->i . 'm yang lalu';
        }
        return $interval->h . 'h yang lalu';
    } elseif ($interval->d < 7) {
        return $interval->d . 'd yang lalu';
    } else {
        return $createdAt->format('d M Y');
    }
}

/**
 * Escape HTML characters
 * 
 * @param string $text
 * @return string
 */
function escape($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Truncate text
 * 
 * @param string $text
 * @param int $limit
 * @param string $suffix
 * @return string
 */
function truncate($text, $limit = 50, $suffix = '...')
{
    if (strlen($text) <= $limit) {
        return $text;
    }
    return substr($text, 0, $limit) . $suffix;
}

/**
 * Validate email
 * 
 * @param string $email
 * @return bool
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate CSRF token
 * 
 * @return string
 */
function generateCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token
 * @return bool
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Redirect to URL
 * 
 * @param string $url
 * @return void
 */
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

/**
 * Set flash message
 * 
 * @param string $type
 * @param string $message
 * @return void
 */
function setFlash($type, $message)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get flash message
 * 
 * @return array|null
 */
function getFlash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Check if user is logged in
 * 
 * @return bool
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Get current user ID
 * 
 * @return int|null
 */
function getCurrentUserID()
{
    return $_SESSION['user_id'] ?? null;
}
