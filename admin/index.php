<?php
require_once '../config.php';
session_start();

// Cek jika belum login
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil semua menu
$query_menu = "SELECT m.*, k.nama as nama_kategori 
               FROM menu m 
               JOIN kategori k ON m.id_kategori = k.id 
               ORDER BY m.id_kategori, m.nama";
$result_menu = mysqli_query($conn, $query_menu);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kafe Nusantara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="light-mode">
    <header class="admin-header">
    <div class="container">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo Kafe Nusantara">
            <h1>Admin Kafe Nusantara</h1>
        </div>
        <div class="nav-buttons">
            <button id="darkModeToggle" class="btn-icon">
                <i class="fas fa-moon"></i>
            </button>
            <button id="mobileMenuToggle" class="btn-icon mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <a href="logout.php" class="btn-danger desktop-only">Logout</a>
        </div>
    </div>
    <div class="nav-menu" id="navMenu">
        <div class="container">
            <a href="index.php">Dashboard</a>
            <a href="add_menu.php">Tambah Menu</a>
            <a href="../index.php">Lihat Website</a>
            <a href="logout.php" class="mobile-only">Logout</a>
        </div>
    </div>
</header>
    <main class="admin-main">
        <div class="container">
            <div class="admin-header-actions">
                <h2>Manajemen Menu</h2>
                <a href="add_menu.php" class="btn-success"><i class="fas fa-plus"></i> Tambah Menu Baru</a>
            </div>
            
            <div class="admin-content">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_menu) > 0): ?>
                                <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>
                                    <tr>
                                        <td><?php echo $menu['id']; ?></td>
                                        <td>
                                            <img src="../img/menu/<?php echo $menu['gambar']; ?>" alt="<?php echo $menu['nama']; ?>" class="menu-thumb">
                                        </td>
                                        <td><?php echo $menu['nama']; ?></td>
                                        <td><?php echo $menu['nama_kategori']; ?></td>
                                        <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo substr($menu['deskripsi'], 0, 50) . (strlen($menu['deskripsi']) > 50 ? '...' : ''); ?></td>
                                        <td class="action-buttons">
                                            <a href="edit_menu.php?id=<?php echo $menu['id']; ?>" class="btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="delete_menu.php?id=<?php echo $menu['id']; ?>" class="btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada menu yang tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Kafe Nusantara. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>