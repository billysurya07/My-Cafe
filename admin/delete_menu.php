<?php
require_once '../config.php';
session_start();

// Cek jika belum login
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Cek ID menu
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data menu untuk mendapatkan nama gambar
$query_menu = "SELECT gambar FROM menu WHERE id = '$id'";
$result_menu = mysqli_query($conn, $query_menu);

if(mysqli_num_rows($result_menu) > 0) {
    $menu = mysqli_fetch_assoc($result_menu);
    
    // Hapus gambar dari server
    if(!empty($menu['gambar']) && file_exists('../img/menu/' . $menu['gambar'])) {
        unlink('../img/menu/' . $menu['gambar']);
    }
    
    // Hapus data dari database
    $query_delete = "DELETE FROM menu WHERE id = '$id'";
    mysqli_query($conn, $query_delete);
}

// Redirect kembali ke halaman admin
header("Location: index.php");
exit;
?>