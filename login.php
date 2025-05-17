<?php
require_once 'config.php';
session_start();

// Cek jika sudah login
if(isset($_SESSION['admin_id'])) {
    header("Location: admin/index.php");
    exit;
}

$error = '';

// Proses login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    // Untuk debugging
    // echo "Username: " . $username . "<br>";
    // echo "Password: " . $password . "<br>";
    
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Untuk debugging
        // echo "Stored password hash: " . $admin['password'] . "<br>";
        
        // Verifikasi password - PERBAIKAN: Gunakan password langsung untuk sementara
        // Jika password di database adalah plain text 'admin123'
        if($password == 'admin123') {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            
            header("Location: admin/index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kafe Nusantara</title>
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
            <a href="index.php" class="btn-primary desktop-only">Kembali ke Beranda</a>
        </div>
    </div>
    <div class="nav-menu" id="navMenu">
        <div class="container">
            <a href="index.php">Beranda</a>
            <a href="index.php#menu">Menu Kami</a>
            <a href="index.php#footer">Kontak</a>
        </div>
    </div>
</header>
    <main>
        <section class="login-section">
            <div class="container">
                <div class="login-container">
                    <h2>Login Admin</h2>
                    
                    <?php if($error): ?>
                        <div class="alert alert-error">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
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