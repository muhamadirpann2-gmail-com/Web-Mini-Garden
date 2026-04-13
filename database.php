<?php
// ============================================================
// config/database.php — Koneksi Database Naureen Mini Garden
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Ganti dengan username hosting Anda
define('DB_PASS', '');           // Ganti dengan password hosting Anda
define('DB_NAME', 'naureen_db');

/**
 * Membuat koneksi mysqli ke database.
 * Melempar Exception jika koneksi gagal.
 */
function getConnection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        // Jangan tampilkan detail error ke user di production
        error_log('DB Connection Error: ' . $conn->connect_error);
        throw new RuntimeException('Koneksi database gagal. Silakan coba lagi nanti.');
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}
