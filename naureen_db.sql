-- ============================================================
-- naureen_db.sql — Database Naureen Mini Garden
-- Jalankan query ini di phpMyAdmin atau MySQL CLI
-- ============================================================



-- 2. Tabel kontak
CREATE TABLE IF NOT EXISTS `kontak` (
  `id`       INT           NOT NULL AUTO_INCREMENT,
  `nama`     VARCHAR(100)  NOT NULL,
  `no_hp`    VARCHAR(20)   NOT NULL,
  `kategori` VARCHAR(50)   NOT NULL,
  `pesan`    TEXT          NOT NULL,
  `tanggal`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_kategori` (`kategori`),
  INDEX `idx_tanggal`  (`tanggal`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- (Opsional) Tabel admin untuk login dashboard sederhana
-- ============================================================
CREATE TABLE IF NOT EXISTS `admin` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(50)  NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL COMMENT 'bcrypt hash',
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- Default admin: username=admin, password=admin123 (ganti segera!)
-- Password di bawah adalah bcrypt dari "admin123"
INSERT IGNORE INTO `admin` (`username`, `password`)
VALUES ('admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ============================================================
-- Query berguna untuk admin
-- ============================================================
-- Lihat semua pesan:
-- SELECT * FROM kontak ORDER BY tanggal DESC;

-- Filter per kategori:
-- SELECT * FROM kontak WHERE kategori = 'Pertanyaan' ORDER BY tanggal DESC;

-- Hitung per kategori:
-- SELECT kategori, COUNT(*) as total FROM kontak GROUP BY kategori;

-- Export bulan ini:
-- SELECT * FROM kontak WHERE MONTH(tanggal) = MONTH(NOW()) AND YEAR(tanggal) = YEAR(NOW());
