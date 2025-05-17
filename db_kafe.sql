-- Buat database
CREATE DATABASE IF NOT EXISTS db_kafe;
USE db_kafe;

-- Buat tabel kategori
CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL
);

-- Buat tabel menu
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL,
    gambar VARCHAR(255),
    id_kategori INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id)
);

-- Buat tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Masukkan data kategori
INSERT INTO kategori (nama) VALUES 
('Minuman'), 
('Makanan'), 
('Dessert');

-- Masukkan data admin (password: admin123)
INSERT INTO admin (username, password) VALUES 
('admin', 'admin123');

-- Masukkan beberapa data menu contoh
INSERT INTO menu (nama, deskripsi, harga, gambar, id_kategori) VALUES 
('Kopi Hitam', 'Kopi hitam khas Indonesia dengan cita rasa kuat', 15000, 'kopi_hitam.jpg', 1),
('Cappuccino', 'Kopi dengan campuran susu dan foam yang lembut', 25000, 'cappuccino.jpg', 1),
('Nasi Goreng Spesial', 'Nasi goreng dengan telur, ayam, dan sayuran', 35000, 'nasi_goreng.jpg', 2),
('Mie Goreng', 'Mie goreng dengan bumbu khas dan sayuran segar', 30000, 'mie_goreng.jpg', 2),
('Pancake', 'Pancake lembut dengan sirup maple dan buah segar', 28000, 'pancake.jpg', 3),
('Es Krim Vanilla', 'Es krim vanilla lembut dengan topping coklat', 18000, 'es_krim.jpg', 3);