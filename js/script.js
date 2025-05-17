document.addEventListener('DOMContentLoaded', function() {
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    
    if (darkModeToggle) {
        const icon = darkModeToggle.querySelector('i');
        
        // Cek preferensi tema dari localStorage
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        
        // Set tema awal
        if (isDarkMode) {
            body.classList.add('dark-mode');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
        
        // Toggle dark mode
        darkModeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('darkMode', 'true');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('darkMode', 'false');
            }
        });
    }
    
    // Preview gambar saat upload (untuk halaman admin)
    const fileInput = document.getElementById('gambar');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentImage = document.querySelector('.current-image');
                    if (currentImage) {
                        const img = currentImage.querySelector('img');
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Tambahkan data-label untuk tabel responsif
    const adminTable = document.querySelector('.admin-table');
    if (adminTable) {
        const headers = adminTable.querySelectorAll('th');
        const rows = adminTable.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent);
                }
            });
        });
    }
    
    // PERBAIKAN: Toggle menu mobile
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileMenuToggle && navMenu) {
        // Tambahkan event listener untuk toggle menu
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Ubah ikon hamburger menjadi X dan sebaliknya
            const icon = mobileMenuToggle.querySelector('i');
            if (navMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
            
            // Log untuk debugging
            console.log('Menu toggled:', navMenu.classList.contains('active'));
        });
        
        // Tutup menu saat mengklik di luar menu
        document.addEventListener('click', function(event) {
            if (!navMenu.contains(event.target) && !mobileMenuToggle.contains(event.target) && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
});