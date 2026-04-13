<?php
// ============================================================
// process_form.php — Proses Form Kontak Naureen Mini Garden
// ============================================================

require_once __DIR__ . '/database.php';

// Hanya terima method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ── 1. Ambil & sanitasi input ──────────────────────────────
$is_ajax  = isset($_POST['is_ajax']);
$nama     = trim(htmlspecialchars($_POST['nama']     ?? '', ENT_QUOTES, 'UTF-8'));
$no_hp    = trim(htmlspecialchars($_POST['no_hp']    ?? '', ENT_QUOTES, 'UTF-8'));
$kategori = trim(htmlspecialchars($_POST['kategori'] ?? '', ENT_QUOTES, 'UTF-8'));
$pesan    = trim(htmlspecialchars($_POST['pesan']    ?? '', ENT_QUOTES, 'UTF-8'));

// ── 2. Validasi ────────────────────────────────────────────
$errors = [];

if (empty($nama)) {
    $errors[] = 'Nama tidak boleh kosong.';
} elseif (mb_strlen($nama) > 100) {
    $errors[] = 'Nama terlalu panjang (maks. 100 karakter).';
}

if (empty($no_hp)) {
    $errors[] = 'Nomor HP tidak boleh kosong.';
} elseif (!preg_match('/^[0-9\+\-\s]{8,20}$/', $no_hp)) {
    $errors[] = 'Format nomor HP tidak valid.';
}

$allowed_kategori = ['Pertanyaan', 'Kritik & Saran', 'Reservasi', 'Kerjasama'];
if (empty($kategori) || !in_array($kategori, $allowed_kategori, true)) {
    $errors[] = 'Kategori tidak valid.';
}

if (empty($pesan)) {
    $errors[] = 'Pesan tidak boleh kosong.';
} elseif (mb_strlen($pesan) > 2000) {
    $errors[] = 'Pesan terlalu panjang (maks. 2000 karakter).';
}

// Jika ada error, redirect kembali
if (!empty($errors)) {
    if ($is_ajax) {
        echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
        exit;
    }
    header('Location: index.php?status=error#kontak');
    exit;
}

// ── 3. Simpan ke database (prepared statement) ─────────────
try {
    $conn = getConnection();

    $stmt = $conn->prepare(
        "INSERT INTO kontak (nama, no_hp, kategori, pesan, tanggal) VALUES (?, ?, ?, ?, NOW())"
    );

    if (!$stmt) {
        throw new RuntimeException('Prepare statement gagal: ' . $conn->error);
    }

    $stmt->bind_param('ssss', $nama, $no_hp, $kategori, $pesan);

    if (!$stmt->execute()) {
        throw new RuntimeException('Execute gagal: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    if ($is_ajax) {
        echo json_encode(['status' => 'success', 'message' => 'Pesan Anda telah berhasil terkirim! Kami akan menghubungi Anda segera.']);
        exit;
    }

    // ── 4. Redirect sukses ──────────────────────────────────
    header('Location: index.php?status=success#kontak');
    exit;

} catch (RuntimeException $e) {
    error_log('process_form.php error: ' . $e->getMessage());
    if ($is_ajax) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        exit;
    }
    header('Location: index.php?status=error#kontak');
    exit;
}
