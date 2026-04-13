<?php
require_once __DIR__ . '/database.php';

try {
    $conn = getConnection();
    
    // Create Table
    $sql = "CREATE TABLE IF NOT EXISTS pengaturan (
        kunci VARCHAR(50) PRIMARY KEY,
        nilai TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    if (!$conn->query($sql)) {
        die("Gagal membuat tabel pengaturan: " . $conn->error);
    }
    
    // Seed initial data
    $default_settings = [
        'hero_title' => 'Naureen Mini Garden',
        'hero_sub' => 'Tempat Healing & Wisata Alam untuk Keluarga',
        'about_text' => 'Naureen Mini Garden hadir sebagai ruang terbuka hijau yang menawarkan pengalaman wisata alam yang menyegarkan dan memanjakan mata. Kami menyediakan berbagai spot foto estetik, area bermain keluarga, serta suasana alam yang tenang untuk melepas penat.

Dengan konsep mini garden yang tertata rapi dan alami, setiap sudut taman kami dirancang untuk memberikan kenangan indah bagi setiap pengunjung.',
        'harga_dewasa' => 'Rp 15.000',
        'harga_anak' => 'Rp 10.000',
        'jadwal_wd' => '08:00 – 17:00',
        'jadwal_we' => '07:00 – 18:00',
        'alamat_teks' => 'Jl. [Nama Jalan], Kelurahan [Nama Kelurahan], Kecamatan [Nama Kecamatan], Samarinda, Kalimantan Timur 75000',
        'maps_link' => 'https://maps.app.goo.gl/Hh2mZ8rJsihPQN6S7',
        'hero_image' => 'https://picsum.photos/seed/garden1/1920/1080',
        'about_image' => 'https://picsum.photos/seed/garden2/700/500'
    ];
    
    foreach ($default_settings as $k => $v) {
        $stmt = $conn->prepare("INSERT IGNORE INTO pengaturan (kunci, nilai) VALUES (?, ?)");
        $stmt->bind_param('ss', $k, $v);
        $stmt->execute();
        $stmt->close();
    }
    
    echo "SUCCESS";
    $conn->close();
} catch (Exception $e) {
    die("ERROR: " . $e->getMessage());
}
