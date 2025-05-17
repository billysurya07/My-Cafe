<?php
require_once 'config.php';

// Ambil semua kategori
$query_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn, $query_kategori);

// Filter kategori
$filter_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$where_clause = $filter_kategori ? "WHERE id_kategori = $filter_kategori" : "";

// Ambil semua menu
$query_menu = "SELECT m.*, k.nama as nama_kategori 
               FROM menu m 
               JOIN kategori k ON m.id_kategori = k.id 
               $where_clause 
               ORDER BY m.id_kategori, m.nama";
$result_menu = mysqli_query($conn, $query_menu);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kafe Nusantara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="light-mode">
   <header>
    <div class="container">
        <div class="logo">
            <img src="img/logo.png" alt="Logo Kafe Nusantara">
            <h1>Kafe Nusantara</h1>
        </div>
        <div class="nav-buttons">
            <button id="darkModeToggle" class="btn-icon">
                <i class="fas fa-moon"></i>
            </button>
            <button id="mobileMenuToggle" class="btn-icon mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <a href="login.php" class="btn-primary desktop-only">Login Admin</a>
        </div>
    </div>
    <!-- Tambahkan nav-menu di sini, di luar container tapi masih di dalam header -->
    <div class="nav-menu" id="navMenu">
        <div class="container">
            <a href="index.php">Beranda</a>
            <a href="#menu">Menu Kami</a>
            <a href="#footer">Kontak</a>
            <a href="login.php" class="mobile-only">Login Admin</a>
        </div>
    </div>
</header>
    <main>
        <section class="hero">
            <div class="container">
                <h2>Selamat Datang di Kafe Nusantara</h2>
                <p>Nikmati berbagai menu spesial kami dengan suasana yang nyaman</p>
            </div>
        </section>

        <section class="menu-section" id="menu">
            <div class="container">
                <h2>Menu Kami</h2>
                
                <div class="filter-container">
                    <a href="index.php" class="filter-btn <?php echo $filter_kategori == '' ? 'active' : ''; ?>">Semua</a>
                    <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                        <a href="index.php?kategori=<?php echo $kategori['id']; ?>" 
                           class="filter-btn <?php echo $filter_kategori == $kategori['id'] ? 'active' : ''; ?>">
                            <?php echo $kategori['nama']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
                
                <div class="menu-grid">
                    <?php if(mysqli_num_rows($result_menu) > 0): ?>
                        <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>
                            <div class="menu-item">
                                <div class="menu-image">
                                    <img src="img/menu/<?php echo $menu['gambar']; ?>" alt="<?php echo $menu['nama']; ?>">
                                </div>
                                <div class="menu-content">
                                    <h3><?php echo $menu['nama']; ?></h3>
                                    <p class="menu-category"><?php echo $menu['nama_kategori']; ?></p>
                                    <p class="menu-price">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>
                                    <p class="menu-desc"><?php echo $menu['deskripsi']; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="no-menu">Tidak ada menu yang tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="img/logo.png" alt="Logo Kafe Nusantara">
                    <h2>Kafe Nusantara</h2>
                </div>
                <div class="footer-contact">
                    <h3>Hubungi Kami</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Nusantara No. 123, Jakarta</p>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@kafenusantara.com</p>
                </div>
                <div class="footer-social">
                    <h3>Ikuti Kami</h3>
                    <div class="social-icons">
                        <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://instagram.com/kafenusantara" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://facebook.com/kafenusantara" target="_blank"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Kafe Nusantara. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>