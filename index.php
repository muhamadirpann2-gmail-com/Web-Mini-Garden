<?php
require_once __DIR__ . '/database.php';

try {
    $conn = getConnection();
    $res = $conn->query("SELECT * FROM pengaturan");
    $pengaturan = [];
    while ($row = $res->fetch_assoc()) {
        $pengaturan[$row['kunci']] = $row['nilai'];
    }
    $conn->close();
} catch (Exception $e) {
    // Fallback jika database belum ada
    $pengaturan = [];
}

function get_setting($key, $default) {
    global $pengaturan;
    return htmlspecialchars($pengaturan[$key] ?? $default);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Naureen Mini Garden – Tempat wisata alam, spot foto, dan healing terbaik. Cocok untuk keluarga dan komunitas." />
  <title>Naureen Mini Garden – Tempat Healing & Wisata Alam</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- ========== NAVBAR ========== -->
  <nav class="navbar" id="navbar">
    <div class="container nav-inner">
      <a href="#hero" class="nav-logo">
        <span class="logo-leaf">&#9752;</span> Naureen Mini Garden
      </a>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
      <ul class="nav-links" id="navLinks">
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#fasilitas">Fasilitas</a></li>
        <li><a href="#video">Video</a></li>
        <li><a href="#lokasi">Lokasi</a></li>
        <li><a href="#kontak">Kontak</a></li>
        <li>
          <a href="https://wa.me/6282255650226?text=Halo%20Naureen%20Mini%20Garden%2C%20saya%20ingin%20reservasi." 
             class="btn-wa-nav" target="_blank" rel="noopener">
            &#128222; Reservasi
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- ========== HERO ========== -->
  <section class="hero" id="hero">
    <div class="hero-overlay"></div>
    <img src="<?= get_setting('hero_image', 'https://picsum.photos/seed/garden1/1920/1080') ?>" alt="Naureen Mini Garden" class="hero-bg" loading="eager" />
    <div class="hero-content container">
      <p class="hero-label">&#127807; Wisata Alam Samarinda</p>
      <h1 class="hero-title"><?= get_setting('hero_title', 'Naureen Mini Garden') ?></h1>
      <p class="hero-sub"><?= get_setting('hero_sub', 'Tempat Healing & Wisata Alam untuk Keluarga') ?></p>
      <p class="hero-desc">
        Nikmati keindahan alam yang asri, spot foto estetik, dan suasana tenang<br class="d-none-mobile" />
        di tengah kehijauan kota Samarinda.
      </p>
      <div class="hero-actions">
        <a href="https://wa.me/6282255650226?text=Halo%20Naureen%20Mini%20Garden%2C%20saya%20ingin%20reservasi%20kunjungan." 
           class="btn-wa" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg>
          Reservasi via WhatsApp
        </a>
        <a href="#tentang" class="btn-outline">Jelajahi Lebih &darr;</a>
      </div>
    </div>
    <div class="hero-scroll-hint">&#8595;</div>
  </section>

  <!-- ========== TENTANG ========== -->
  <section class="section" id="tentang">
    <div class="container">
      <div class="about-grid">
        <div class="about-img-wrap">
          <img src="<?= get_setting('about_image', 'https://picsum.photos/seed/garden2/700/500') ?>" alt="Suasana Naureen Mini Garden" class="about-img" loading="lazy" />
          <div class="about-badge">Buka Setiap Hari</div>
        </div>
        <div class="about-text">
          <span class="section-label">Tentang Kami</span>
          <h2 class="section-title">Surga Hijau di Tengah Kota Samarinda</h2>
          <p><?= nl2br(get_setting('about_text', 'Naureen Mini Garden hadir sebagai ruang terbuka hijau yang menawarkan pengalaman wisata alam yang menyegarkan...')) ?></p>
          <p>
            Dengan konsep <em>mini garden</em> yang tertata rapi dan alami, setiap sudut taman kami dirancang untuk memberikan kenangan indah bagi setiap pengunjung.
          </p>
          <div class="about-stats">
            <div class="stat-item">
              <span class="stat-num">500+</span>
              <span class="stat-label">Pengunjung / Bulan</span>
            </div>
            <div class="stat-item">
              <span class="stat-num">15+</span>
              <span class="stat-label">Spot Foto Estetik</span>
            </div>
            <div class="stat-item">
              <span class="stat-num">100%</span>
              <span class="stat-label">Natural & Alami</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== KEUNGGULAN ========== -->
  <section class="section section-light" id="keunggulan">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Kenapa Kami?</span>
        <h2 class="section-title">Keunggulan Naureen Mini Garden</h2>
        <p class="section-desc">Pengalaman wisata yang tak terlupakan untuk seluruh anggota keluarga</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">&#128247;</div>
          <h3>Spot Foto Estetik</h3>
          <p>Lebih dari 15 spot foto instagramable dengan latar alam hijau yang cantik dan pencahayaan alami terbaik.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">&#127807;</div>
          <h3>Suasana Alam Asri</h3>
          <p>Udara segar, tanaman hijau lebat, dan suara alam menjadi terapi alami untuk melepas stres sehari-hari.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">&#128106;</div>
          <h3>Ramah Keluarga</h3>
          <p>Area bermain anak, jalur yang nyaman untuk lansia, dan fasilitas lengkap untuk semua usia.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">&#128205;</div>
          <h3>Lokasi Strategis</h3>
          <p>Mudah dijangkau dari pusat kota Samarinda, tersedia area parkir luas untuk kendaraan roda dua dan empat.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">&#9749;</div>
          <h3>Area Santai & Kuliner</h3>
          <p>Nikmati minuman segar dan camilan di gazebo teduh sambil menikmati pemandangan taman yang indah.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">&#128081;</div>
          <h3>Event & Gathering</h3>
          <p>Tersedia paket khusus untuk gathering komunitas, acara keluarga, ulang tahun, dan foto prewedding.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== GALERI ========== -->
  <section class="section" id="galeri">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Galeri</span>
        <h2 class="section-title">Keindahan Naureen Mini Garden</h2>
        <p class="section-desc">Sekilas pandang keindahan taman kami yang menakjubkan</p>
      </div>
      <div class="gallery-grid">
        <div class="gallery-item gallery-main">
          <img src="https://picsum.photos/seed/garden3/800/600" alt="Spot foto utama" loading="lazy" />
          <div class="gallery-overlay"><span>Spot Foto Utama</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://picsum.photos/seed/garden4/400/300" alt="Area taman" loading="lazy" />
          <div class="gallery-overlay"><span>Area Taman Hijau</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://picsum.photos/seed/garden5/400/300" alt="Spot foto" loading="lazy" />
          <div class="gallery-overlay"><span>Spot Foto Estetik</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://picsum.photos/seed/garden6/400/300" alt="Area santai" loading="lazy" />
          <div class="gallery-overlay"><span>Area Santai</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://picsum.photos/seed/garden7/400/300" alt="Bunga dan tanaman" loading="lazy" />
          <div class="gallery-overlay"><span>Koleksi Bunga</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://picsum.photos/seed/garden8/400/300" alt="Gazebo" loading="lazy" />
          <div class="gallery-overlay"><span>Gazebo & Kuliner</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== VIDEO ========== -->
  <section class="section section-light" id="video">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Video</span>
        <h2 class="section-title">Lihat Suasana Naureen Mini Garden</h2>
        <p class="section-desc">Rasakan keindahan taman kami melalui video berikut</p>
      </div>
      <div class="video-grid">
        <!-- Ganti dengan embed TikTok asli setelah memiliki akun -->
        <div class="video-placeholder">
          <div class="video-play-icon">&#9654;</div>
          <p class="video-caption">Video TikTok akan ditampilkan di sini</p>
          <p class="video-note">Embed: <code>https://www.tiktok.com/embed/v2/{video_id}</code></p>
          <!-- Contoh embed TikTok asli (uncomment dan isi video ID):
          <blockquote class="tiktok-embed"
            cite="https://www.tiktok.com/@username/video/VIDEO_ID"
            data-video-id="VIDEO_ID"
            style="max-width:100%;min-width:300px;">
          </blockquote>
          <script async src="https://www.tiktok.com/embed.js"></script>
          -->
        </div>
        <div class="video-placeholder">
          <div class="video-play-icon">&#9654;</div>
          <p class="video-caption">Video TikTok akan ditampilkan di sini</p>
          <p class="video-note">Embed: <code>https://www.tiktok.com/embed/v2/{video_id}</code></p>
        </div>
      </div>
      <div class="video-cta">
        <p>Ikuti kami di TikTok untuk update terbaru</p>
        <a href="https://tiktok.com/@naureenminigarden" target="_blank" rel="noopener" class="btn-tiktok">
          &#9654; Tonton di TikTok
        </a>
      </div>
    </div>
  </section>

  <!-- ========== INFORMASI WISATA ========== -->
  <section class="section" id="fasilitas">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Informasi Wisata</span>
        <h2 class="section-title">Harga, Jam Buka & Fasilitas</h2>
      </div>
      <div class="info-grid">
        <!-- Harga Tiket -->
        <div class="info-card">
          <div class="info-icon">&#127915;</div>
          <h3>Harga Tiket</h3>
          <div class="ticket-list">
            <div class="ticket-item">
              <span>Dewasa</span>
              <span class="ticket-price"><?= get_setting('harga_dewasa', 'Rp 15.000') ?></span>
            </div>
            <div class="ticket-item">
              <span>Anak-anak (3–12 th)</span>
              <span class="ticket-price"><?= get_setting('harga_anak', 'Rp 10.000') ?></span>
            </div>
            <div class="ticket-item">
              <span>Balita (< 3 th)</span>
              <span class="ticket-price free">Gratis</span>
            </div>
            <div class="ticket-item">
              <span>Parkir Motor</span>
              <span class="ticket-price">Rp 2.000</span>
            </div>
            <div class="ticket-item">
              <span>Parkir Mobil</span>
              <span class="ticket-price">Rp 5.000</span>
            </div>
          </div>
        </div>

        <!-- Jam Buka -->
        <div class="info-card">
          <div class="info-icon">&#128336;</div>
          <h3>Jam Buka</h3>
          <div class="schedule-list">
            <div class="schedule-item">
              <span>Senin – Jumat</span>
              <span class="schedule-time"><?= get_setting('jadwal_wd', '08:00 – 17:00') ?></span>
            </div>
            <div class="schedule-item">
              <span>Sabtu & Minggu</span>
              <span class="schedule-time highlight"><?= get_setting('jadwal_we', '07:00 – 18:00') ?></span>
            </div>
            <div class="schedule-item">
              <span>Hari Libur Nasional</span>
              <span class="schedule-time highlight">07:00 – 18:00</span>
            </div>
          </div>
          <p class="info-note">&#128276; Reservasi group & event dapat dilakukan di luar jam operasional.</p>
        </div>

        <!-- Fasilitas -->
        <div class="info-card">
          <div class="info-icon">&#127968;</div>
          <h3>Fasilitas</h3>
          <ul class="facilities-list">
            <li>&#10003; Area parkir luas (motor & mobil)</li>
            <li>&#10003; Toilet & mushola bersih</li>
            <li>&#10003; Gazebo & area duduk</li>
            <li>&#10003; Stand kuliner & minuman</li>
            <li>&#10003; Spot foto 15+ titik</li>
            <li>&#10003; Area bermain anak</li>
            <li>&#10003; WiFi area tertentu</li>
            <li>&#10003; Pemandu foto (request)</li>
          </ul>
        </div>
      </div>

      <div class="wa-cta-box">
        <div>
          <h3>Reservasi Sekarang</h3>
          <p>Hubungi kami via WhatsApp untuk pemesanan group, event, atau informasi lebih lanjut.</p>
        </div>
        <a href="https://wa.me/6282255650226?text=Halo%20Naureen%20Mini%20Garden%2C%20saya%20ingin%20informasi%20lebih%20lanjut." 
           class="btn-wa" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg>
          Chat WhatsApp
        </a>
      </div>
    </div>
  </section>

  <!-- ========== LOKASI ========== -->
  <section class="section section-light" id="lokasi">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Lokasi</span>
        <h2 class="section-title">Temukan Kami di Sini</h2>
        <p class="section-desc">Mudah dijangkau dari berbagai penjuru Samarinda</p>
      </div>
      <div class="location-grid">
        <div class="map-wrap">
          <!-- Ganti src dengan embed Google Maps lokasi asli -->
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127825.5975614285!2d117.0778751637451!3d-0.49499999999999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67eca9c3a5c9b%3A0x3c87d7c5b7a0e0e0!2sSamarinda%2C%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" title="Lokasi Naureen Mini Garden">
          </iframe>
        </div>
        <div class="location-info">
          <h3>Alamat</h3>
          <p>&#128205; <?= get_setting('alamat_teks', 'Jl. [Nama Jalan], Kelurahan [Nama Kelurahan]') ?></p>
          <h3>Kontak</h3>
          <p>&#128222; <a href="tel:+6282255650226">+62 822-5565-0226 (Admin 1)</a></p>
          <p>&#128222; <a href="tel:+6285250345997">+62 852-5034-5997 (Admin 2)</a></p>
          <p>&#128233; <a href="mailto:info@naureenminigarden.com">info@naureenminigarden.com</a></p>
          <h3>Media Sosial</h3>
          <div class="sosmed-links">
            <a href="https://instagram.com/naureenminigarden" target="_blank" rel="noopener">&#128247; Instagram</a>
            <a href="https://tiktok.com/@naureenminigarden" target="_blank" rel="noopener">&#9654; TikTok</a>
            <a href="https://www.facebook.com/share/18TGzJRhJz/?mibextid=wwXIfr" target="_blank" rel="noopener">&#128172; Facebook</a>
          </div>
          <a href="<?= get_setting('maps_link', 'https://maps.google.com/?q=Samarinda+Kalimantan+Timur') ?>" target="_blank" rel="noopener" class="btn-direction">
            &#128506; Petunjuk Arah
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== FORM KONTAK ========== -->
  <section class="section" id="kontak">
    <div class="container">
      <div class="section-header">
        <span class="section-label">Hubungi Kami</span>
        <h2 class="section-title">Ada Pertanyaan atau Saran?</h2>
        <p class="section-desc">Kami siap membantu Anda. Isi form di bawah ini.</p>
      </div>
      <div class="contact-wrap">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert-success">
          &#10004; Pesan Anda telah berhasil terkirim! Kami akan menghubungi Anda segera.
        </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert-error">
          &#10006; Terjadi kesalahan. Silakan coba lagi atau hubungi via WhatsApp.
        </div>
        <?php endif; ?>

        <form class="contact-form" action="process_form.php" method="POST" id="contactForm">
          <div class="form-row">
            <div class="form-group">
              <label for="nama">Nama Lengkap <span class="required">*</span></label>
              <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required />
            </div>
            <div class="form-group">
              <label for="no_hp">Nomor HP <span class="required">*</span></label>
              <input type="tel" id="no_hp" name="no_hp" placeholder="Contoh: 082255650226" required />
            </div>
          </div>
          <div class="form-group">
            <label for="kategori">Kategori <span class="required">*</span></label>
            <select id="kategori" name="kategori" required>
              <option value="" disabled selected>-- Pilih Kategori --</option>
              <option value="Pertanyaan">Pertanyaan</option>
              <option value="Kritik & Saran">Kritik &amp; Saran</option>
              <option value="Reservasi">Reservasi / Pemesanan</option>
              <option value="Kerjasama">Kerjasama</option>
            </select>
          </div>
          <div class="form-group">
            <label for="pesan">Pesan <span class="required">*</span></label>
            <textarea id="pesan" name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
          </div>
          <button type="submit" class="btn-submit">
            Kirim Pesan &rarr;
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#hero" class="footer-logo">
            <span class="logo-leaf">&#9752;</span> Naureen Mini Garden
          </a>
          <p>Tempat healing dan wisata alam terbaik di Samarinda. Hadir untuk memberikan pengalaman alam yang menyegarkan.</p>
          <a href="https://wa.me/6282255650226?text=Halo%20Naureen%20Mini%20Garden!" 
             class="btn-wa-sm" target="_blank" rel="noopener">
            &#128222; WhatsApp Kami
          </a>
        </div>
        <div class="footer-links">
          <h4>Navigasi</h4>
          <ul>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#fasilitas">Fasilitas & Harga</a></li>
            <li><a href="#video">Video</a></li>
            <li><a href="#lokasi">Lokasi</a></li>
            <li><a href="#kontak">Kontak</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h4>Kontak</h4>
          <p>&#128205; Samarinda, Kalimantan Timur</p>
          <p>&#128222; +62 822-5565-0226 (Admin 1)</p>
          <p>&#128222; +62 852-5034-5997 (Admin 2)</p>
          <p>&#128336; Senin–Jumat: 08.00–17.00</p>
          <p>&#128336; Sabtu–Minggu: 07.00–18.00</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Naureen Mini Garden. All rights reserved.</p>
        <p>Naureen Mini Garden Samarinda</p>
      </div>
    </div>
  </footer>

  <!-- Floating WhatsApp Button -->
  <a href="https://wa.me/6282255650226?text=Halo%20Naureen%20Mini%20Garden%2C%20saya%20ingin%20bertanya."
     class="wa-float" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
  </a>

  <script src="assets/js/main.js"></script>
</body>
</html>
