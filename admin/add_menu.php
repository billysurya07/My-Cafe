<?php
require_once '../config.php';
session_start();

// Cek jika belum login
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil semua kategori
$query_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn, $query_kategori);

$error = '';
$success = '';

// Proses tambah menu
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    
    // Upload gambar
    $gambar = '';
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Verifikasi ekstensi file
        if(in_array(strtolower($filetype), $allowed)) {
            // Buat nama file unik
            $newname = uniqid() . '.' . $filetype;
            $target = '../img/menu/' . $newname;
            
            // Upload file
            if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar = $newname;
            } else {
                $error = "Gagal mengupload gambar!";
            }
        } else {
            $error = "Format gambar tidak didukung! Gunakan JPG, JPEG, PNG, atau GIF.";
        }
    } else {
        $error = "Gambar wajib diupload!";
    }
    
    // Jika tidak ada error, simpan ke database
    if(empty($error)) {
        $query = "INSERT INTO menu (nama, deskripsi, harga, gambar, id_kategori) 
                  VALUES ('$nama', '$deskripsi', '$harga', '$gambar', '$id_kategori')";
        
        if(mysqli_query($conn, $query)) {
            $success = "Menu berhasil ditambahkan!";
            // Reset form
            $nama = $deskripsi = $harga = $id_kategori = '';
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Kafe Nusantara</title>
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
                <a href="logout.php" class="btn-danger">Logout</a>
            </div>
        </div>
    </header>

    <main class="admin-main">
        <div class="container">
            <div class="admin-header-actions">
                <h2>Tambah Menu Baru</h2>
                <a href="index.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            
            <div class="admin-content">
                <?php if($error): ?>
                    <div class="alert alert-error">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="post" enctype="multipart/form-data" class="admin-form">
                    <div class="form-group">
                        <label for="nama">Nama Menu</label>
                        <input type="text" id="nama" name="nama" value="<?php echo isset($nama) ? $nama : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <select id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                                <option value="<?php echo $kategori['id']; ?>" <?php echo (isset($id_kategori) && $id_kategori == $kategori['id']) ? 'selected' : ''; ?>>
                                    <?php echo $kategori['nama']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="<?php echo isset($harga) ? $harga : ''; ?>" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo isset($deskripsi) ? $deskripsi : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="gambar">Gambar Menu</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" required>
                        <small>Format yang didukung: JPG, JPEG, PNG, GIF</small>
                    </div>
                    
                    <button type="submit" class="btn-success btn-block">Tambah Menu</button>
                </form>
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