<?php
// ============================================================
// admin/pesan.php — Dashboard melihat pesan masuk & CMS
// Akses: yoursite.com/pesan.php
// ============================================================
session_start();
require_once __DIR__ . '/database.php';

// Login sederhana
$ADMIN_USER = 'admin';
$ADMIN_PASS = 'admin123'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if ($_POST['username'] === $ADMIN_USER && $_POST['password'] === $ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = 'Username atau password salah.';
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: pesan.php');
    exit;
}

$logged_in = $_SESSION['admin_logged_in'] ?? false;
$tab = $_GET['tab'] ?? 'pesan';

// Logic for saving settings
$settings_msg = '';
if ($logged_in && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    try {
        $conn = getConnection();
        $keys = ['hero_title', 'hero_sub', 'about_text', 'harga_dewasa', 'harga_anak', 'jadwal_wd', 'jadwal_we', 'alamat_teks', 'maps_link'];
        
        $stmt = $conn->prepare("INSERT INTO pengaturan (kunci, nilai) VALUES (?, ?) ON DUPLICATE KEY UPDATE nilai=VALUES(nilai)");
        foreach ($keys as $k) {
            if (isset($_POST[$k])) {
                $val = trim($_POST[$k]);
                $stmt->bind_param('ss', $k, $val);
                $stmt->execute();
            }
        }
        $stmt->close();
        
        // Handle Image uploads
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        
        if (!empty($_FILES['hero_image']['tmp_name'])) {
            if (in_array($_FILES['hero_image']['type'], $allowed_types)) {
                $path = 'assets/images/uploads/hero_' . time() . '.jpg';
                move_uploaded_file($_FILES['hero_image']['tmp_name'], $path);
                $conn->query("INSERT INTO pengaturan (kunci, nilai) VALUES ('hero_image', '$path') ON DUPLICATE KEY UPDATE nilai='$path'");
            }
        }
        
        if (!empty($_FILES['about_image']['tmp_name'])) {
            if (in_array($_FILES['about_image']['type'], $allowed_types)) {
                $path = 'assets/images/uploads/about_' . time() . '.jpg';
                move_uploaded_file($_FILES['about_image']['tmp_name'], $path);
                $conn->query("INSERT INTO pengaturan (kunci, nilai) VALUES ('about_image', '$path') ON DUPLICATE KEY UPDATE nilai='$path'");
            }
        }
        
        $settings_msg = '<div class="alert-success" style="padding:15px;background:#d4edda;color:#155724;border-radius:8px;margin-bottom:20px;">✔ Pengaturan berhasil diperbarui!</div>';
        $conn->close();
    } catch (Exception $e) {
        $settings_msg = '<div class="alert-error" style="padding:15px;background:#f8d7da;color:#721c24;border-radius:8px;margin-bottom:20px;">✖ Gagal: ' . $e->getMessage() . '</div>';
    }
}

// Logic for fetching setting
$settings = [];
if ($logged_in) {
    try {
        $conn = getConnection();
        $res = $conn->query("SELECT * FROM pengaturan");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $settings[$row['kunci']] = $row['nilai'];
            }
        }
        $conn->close();
    } catch (Exception $e) {}
}

function s($k) { global $settings; return htmlspecialchars($settings[$k] ?? ''); }

// Logic for fetching messages
$messages = [];
if ($logged_in && $tab === 'pesan') {
    try {
        $conn = getConnection();
        $filter = $_GET['filter'] ?? 'semua';
        
        if ($filter !== 'semua') {
            $stmt = $conn->prepare("SELECT * FROM kontak WHERE kategori = ? ORDER BY tanggal DESC");
            $stmt->bind_param('s', $filter);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $conn->query("SELECT * FROM kontak ORDER BY tanggal DESC");
        }
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
        }
        $conn->close();
    } catch (Exception $e) {
        $db_error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel – Naureen Mini Garden</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background: #f0f7ec; min-height: 100vh; }
    .login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .login-card { background: #fff; border-radius: 16px; padding: 48px; width: 100%; max-width: 400px; box-shadow: 0 8px 40px rgba(58,122,34,.12); }
    .login-card h1 { font-size: 22px; color: #1f4611; margin-bottom: 8px; }
    .login-card p { font-size: 14px; color: #6b6963; margin-bottom: 32px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #3a3835; margin-bottom: 6px; }
    .form-group input, .form-group textarea { width: 100%; padding: 11px 14px; font-family: 'Poppins', sans-serif; font-size: 14px; border: 1.5px solid #e5e3de; border-radius: 8px; outline: none; }
    .form-group input:focus, .form-group textarea:focus { border-color: #5aac3a; }
    .btn-login { width: 100%; padding: 13px; background: #3a7a22; color: #fff; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 700; border: none; border-radius: 50px; cursor: pointer; margin-top: 8px; }
    .btn-login:hover { background: #2d6119; }
    .error-msg { background: #fcebeb; border: 1px solid #f09595; color: #a32d2d; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
    
    .admin-header { background: #1f4611; color: #fff; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .admin-header h1 { font-size: 18px; }
    .btn-logout { background: rgba(255,255,255,.2); color: #fff; border: none; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; padding: 8px 18px; border-radius: 50px; cursor: pointer; text-decoration: none; display: inline-block; transition: .2s; }
    .btn-logout:hover, .btn-logout.active { background: #fff; color: #1f4611; }
    
    .admin-body { padding: 32px; max-width: 1100px; margin: 0 auto; }
    
    /* Config Panel */
    .config-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e5e3de; margin-bottom: 25px; }
    .config-card h2 { font-size: 18px; margin-bottom: 20px; color: #1f4611; border-bottom: 1px solid #e5e3de; padding-bottom: 10px; }
    .row { display: flex; gap: 20px; flex-wrap: wrap; }
    .col { flex: 1; min-width: 300px; }
    
    /* Tables and Stats */
    .filters { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
    .filter-btn { padding: 7px 18px; border-radius: 50px; border: 1.5px solid #e5e3de; background: #fff; color: #6b6963; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .2s; }
    .filter-btn.active, .filter-btn:hover { background: #3a7a22; color: #fff; border-color: #3a7a22; }
    .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 32px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #e5e3de; }
    .stat-card .num { font-size: 28px; font-weight: 800; color: #3a7a22; }
    .stat-card .lbl { font-size: 12px; color: #6b6963; margin-top: 4px; }
    table { width: 100%; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e3de; border-collapse: collapse; }
    th { background: #f0f7ec; padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #3a7a22; }
    td { padding: 14px 16px; font-size: 13px; color: #3a3835; border-top: 1px solid #f2f1ee; vertical-align: top; }
    tr:hover td { background: #fafaf8; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }
    .badge-pertanyaan  { background: #e6f1fb; color: #185fa5; }
    .badge-kritik      { background: #faeeda; color: #854f0b; }
    .badge-reservasi   { background: #eaf3de; color: #3b6d11; }
    .badge-kerjasama   { background: #fbeaf0; color: #993556; }
    .empty { text-align: center; padding: 48px; color: #9e9c96; }
  </style>
</head>
<body>

<?php if (!$logged_in): ?>
<div class="login-wrap">
  <div class="login-card">
    <h1>🌿 Admin Panel</h1>
    <p>Naureen Mini Garden — Login</p>
    <?php if (isset($login_error)): ?>
      <div class="error-msg">&#10006; <?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required placeholder="admin" />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••" />
      </div>
      <button type="submit" name="login" class="btn-login">Masuk</button>
    </form>
  </div>
</div>

<?php else: ?>
<div class="admin-header">
  <h1>🌿 Naureen Mini Garden — Admin</h1>
  <div>
    <a href="?tab=pesan" class="btn-logout <?= $tab === 'pesan' ? 'active' : '' ?>">Pesan Masuk</a>
    <a href="?tab=pengaturan" class="btn-logout <?= $tab === 'pengaturan' ? 'active' : '' ?>">Pengaturan Web</a>
    <form method="POST" style="display:inline; margin-left:10px;">
      <button type="submit" name="logout" class="btn-logout" style="background:#d4edda; color:#1f4611">Keluar</button>
    </form>
  </div>
</div>

<div class="admin-body">

  <?php if ($tab === 'pengaturan'): ?>
    <!-- TAB PENGATURAN WEB -->
    <?= $settings_msg ?>
    
    <form method="POST" action="?tab=pengaturan" enctype="multipart/form-data">
        <div class="config-card">
            <h2>Gambar Utama (Images)</h2>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Gambar Hero / Banner Depan (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="hero_image" accept="image/*" />
                        <small style="color:#666">Saat ini: <a href="<?= s('hero_image') ?>" target="_blank">Lihat Gambar</a></small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Gambar Bagian Tentang Kami (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="about_image" accept="image/*" />
                        <small style="color:#666">Saat ini: <a href="<?= s('about_image') ?>" target="_blank">Lihat Gambar</a></small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="config-card">
            <h2>Teks Utama Web</h2>
            <div class="form-group">
                <label>Judul Utama (Hero Title)</label>
                <input type="text" name="hero_title" value="<?= s('hero_title') ?>" />
            </div>
            <div class="form-group">
                <label>Sub - Judul Utama</label>
                <input type="text" name="hero_sub" value="<?= s('hero_sub') ?>" />
            </div>
            <div class="form-group">
                <label>Teks Tentang Kami (Bisa lebih dari 1 paragraf)</label>
                <textarea name="about_text" rows="5"><?= s('about_text') ?></textarea>
            </div>
        </div>

        <div class="config-card">
            <h2>Harga Tiket & Jam Buka</h2>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Harga Tiket Dewasa</label>
                        <input type="text" name="harga_dewasa" value="<?= s('harga_dewasa') ?>" />
                    </div>
                    <div class="form-group">
                        <label>Harga Tiket Anak-Anak</label>
                        <input type="text" name="harga_anak" value="<?= s('harga_anak') ?>" />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Jam Buka (Senin - Jumat)</label>
                        <input type="text" name="jadwal_wd" value="<?= s('jadwal_wd') ?>" />
                    </div>
                    <div class="form-group">
                        <label>Jam Buka (Sabtu - Minggu)</label>
                        <input type="text" name="jadwal_we" value="<?= s('jadwal_we') ?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="config-card">
            <h2>Lokasi & Peta</h2>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_teks" rows="2"><?= s('alamat_teks') ?></textarea>
            </div>
            <div class="form-group">
                <label>Link Google Maps (Contoh: https://maps.app.goo.gl/...)</label>
                <input type="text" name="maps_link" value="<?= s('maps_link') ?>" />
            </div>
        </div>
        
        <button type="submit" name="save_settings" class="btn-login" style="padding:16px; font-size:16px;">💾 Simpan & Perbarui Website</button>
    </form>
    
  <?php else: ?>
    <!-- TAB PESAN MASUK -->
    <?php
      $total = count($messages);
      $by_kat = array_count_values(array_column($messages, 'kategori'));
    ?>
    <div class="stats">
      <div class="stat-card"><div class="num"><?= $total ?></div><div class="lbl">Total Pesan</div></div>
      <div class="stat-card"><div class="num"><?= $by_kat['Pertanyaan'] ?? 0 ?></div><div class="lbl">Pertanyaan</div></div>
      <div class="stat-card"><div class="num"><?= $by_kat['Kritik & Saran'] ?? 0 ?></div><div class="lbl">Kritik & Saran</div></div>
      <div class="stat-card"><div class="num"><?= $by_kat['Reservasi'] ?? 0 ?></div><div class="lbl">Reservasi</div></div>
    </div>

    <div class="filters">
      <a href="?tab=pesan&filter=semua" class="filter-btn <?= ($_GET['filter'] ?? 'semua') === 'semua' ? 'active' : '' ?>">Semua</a>
      <a href="?tab=pesan&filter=Pertanyaan" class="filter-btn <?= ($_GET['filter'] ?? '') === 'Pertanyaan' ? 'active' : '' ?>">Pertanyaan</a>
      <a href="?tab=pesan&filter=Kritik+%26+Saran" class="filter-btn <?= ($_GET['filter'] ?? '') === 'Kritik & Saran' ? 'active' : '' ?>">Kritik & Saran</a>
      <a href="?tab=pesan&filter=Reservasi" class="filter-btn <?= ($_GET['filter'] ?? '') === 'Reservasi' ? 'active' : '' ?>">Reservasi</a>
      <a href="?tab=pesan&filter=Kerjasama" class="filter-btn <?= ($_GET['filter'] ?? '') === 'Kerjasama' ? 'active' : '' ?>">Kerjasama</a>
    </div>

    <?php if (isset($db_error)): ?>
      <p style="color:#a32d2d;padding:16px">Error: <?= htmlspecialchars($db_error) ?></p>
    <?php elseif (empty($messages)): ?>
      <div class="empty"><p>Belum ada pesan masuk.</p></div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>No HP</th>
          <th>Kategori</th>
          <th>Pesan</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $i => $msg): 
          $kat_class = match($msg['kategori']) {
            'Pertanyaan'   => 'pertanyaan',
            'Kritik & Saran' => 'kritik',
            'Reservasi'    => 'reservasi',
            'Kerjasama'    => 'kerjasama',
            default        => 'pertanyaan'
          };
        ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><strong><?= htmlspecialchars($msg['nama']) ?></strong></td>
          <td><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $msg['no_hp']) ?>" target="_blank" style="color:#3a7a22"><?= htmlspecialchars($msg['no_hp']) ?></a></td>
          <td><span class="badge badge-<?= $kat_class ?>"><?= htmlspecialchars($msg['kategori']) ?></span></td>
          <td style="max-width:300px"><?= nl2br(htmlspecialchars($msg['pesan'])) ?></td>
          <td style="white-space:nowrap;color:#9e9c96"><?= date('d M Y H:i', strtotime($msg['tanggal'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php endif; ?>

</body>
</html>
