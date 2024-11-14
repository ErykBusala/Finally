<?php
// Koneksi ke database
include '../koneksi.php'; // Pastikan koneksi.php menghubungkan ke database dengan variabel $conn

// Ambil data produk dari database
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="src/css/styles.css">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <div id="navbarr" class="d-flex justify-content-end">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                    <li class="nav-item nav-item-rental">
                        <a class="nav-link" href="#">Penyewaan</a>
                    </li>
                    <li id="produk" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produk
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Penyewaan</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" id="search" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <a href="./pluggin/login" class="btn btn-outline-primary ms-2">
                    <i class="fas fa-user"></i> Login
                </a>
            </div>
        </div>
    </nav>
    <!-- VIDEO -->
    <div class="container-fluid p-0" style="padding-top: 70px;"> <!-- Add padding-top to prevent content from going under navbar -->
        <div class="video-wrapper">
            <video autoplay muted loop>
                <source src="src/video/1.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-text">
                "Riasan adalah seni, dan setiap wajah adalah kanvas."
            </div>
        </div>
    </div>
    <!-- Scroll bar CARD -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold">Penyewaan Produk-produk</h1>
            <a href="#" id="lihatSemua1" class="text-center text-decoration-none"><p>Lihat Semua</p></a>
            <hr>
            <div id="scrollButtonsS" class="d-flex gap-3 justify-content-center text-center">
                <button id="scrollLeftS" class="btn btn-outline-secondary rounded-circle">←</button>
                <a href="#" id="lihatSemua2" class="text-center text-decoration-none"><p>Lihat Semua</p></a>
                <button id="scrollRightS" class="btn btn-outline-secondary rounded-circle">→</button>
            </div>
        </div>
    
        <div id="scrollable-Pre-Order" class="scrollable-container p-2">

        <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                // Set kategori sebagai kelas CSS
                $kategoriClass = strtolower($row['kategori']);
        ?>
            <div class="card text-center">
                <img src="<?= $row['gambar_produk'] ?>"  alt="<?= $row['nama_produk'] ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['nama_produk'] ?></h5>
                    <h6 class="card-title"><?= $row['deskripsi'] ?></h6>
                    <p class="card-text"><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <div class="d-grid gap-2">
                    <button class="btn btn-success" type="button" onclick="redirectToLogin()">Sewa Sekarang</button>
                    </div>
                    <script>function redirectToLogin() {
    // Mengarahkan pengguna ke halaman login
    window.location.href = "http://localhost/nigastrep/public/pluggin/login";

    // Menampilkan notifikasi harap login terlebih dahulu
    const notification = document.createElement("div");
    notification.textContent = "Harap login terlebih dahulu";
    notification.classList.add("notification");
    document.body.appendChild(notification);

    // Menghapus notifikasi setelah 3 detik
    setTimeout(() => {
      notification.remove();
    }, 3000);
  }</script>
                </div>
            </div>
            <?php
              }
            } else {
                echo "<p class='text-center'>Tidak ada produk yang tersedia.</p>";
              }
              ?>
        </div>
        <!-- Tambah disini -->

        <div class="container mt-5">
            <h2 class="text-center mb-4">Responsive Image Cards</h2>
            <div class="row justify-content-center">
        
                <!-- Card 1 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/400x300" alt="Image 1" class="card-img-top">
                    </div> 
                </div>
        
                <!-- Card 2 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x500" alt="Image 2" class="card-img-top">
                    </div>
                </div>
        
                <!-- Card 3 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/500x400" alt="Image 3" class="card-img-top">
                    </div>
                </div>
        
                <!-- Card 4 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/400x200" alt="Image 4" class="card-img-top">
                    </div>
                </div>
        
                <!-- Card 5 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/600x400" alt="Image 5" class="card-img-top">
                    </div>
                </div>
        
                <!-- Card 6 -->
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300" alt="Image 6" class="card-img-top">
                    </div>
                </div>
        
            </div>
        </div>
        
        <div class="container mt-5">
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold">Video Cards</h1>
                <hr>
            </div>
            

            <div class="card-container">
                <div class="card" onclick="expandCard(this)">
                  <video autoplay loop muted src="https://www.w3schools.com/html/mov_bbb.mp4"></video>
                </div>
                <div class="card" onclick="expandCard(this)">
                  <video autoplay loop muted src="https://www.w3schools.com/html/mov_bbb.mp4"></video>
                </div>
                <div class="card" onclick="expandCard(this)">
                  <video autoplay loop muted src="https://www.w3schools.com/html/mov_bbb.mp4"></video>
                </div>
              </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Bootstrap Card -->
        <div class="row about-card">
            <div class="col-md-6 order-md-2">
                <img src="https://via.placeholder.com/500" class="about-img" alt="Deskripsi gambar">
            </div>
            <div class="col-md-6 order-md-1 d-flex flex-column justify-content-center">
                <h2>About the Product</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="src/js/script.js"></script>
  </body>
</html>