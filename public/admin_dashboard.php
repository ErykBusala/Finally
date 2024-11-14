<?php
// Koneksi ke database
include '../koneksi.php'; // Pastikan koneksi.php menghubungkan ke database dengan variabel $conn

// Ambil data produk dari database
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
$sqlTopUsers = "
    SELECT 
        u.id AS user_id,
        u.username,
        u.fullname,
        COUNT(s.id) AS jumlah_penyewaan
    FROM 
        users u
    JOIN 
        sewa s ON u.id = s.user_id
    GROUP BY 
        u.id, u.username, u.fullname
    ORDER BY 
        jumlah_penyewaan DESC
    LIMIT 10; -- Menampilkan 10 pengguna teratas yang paling sering menyewa
";

$resultTopUsers = $conn->query($sqlTopUsers);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard Sidebar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="./src/css/admin.css">
</head>

<body>

  <div class="sidebar" id="sidebar">
    <h4 class="text-center">Admin Dashboard</h4>
    <a href="#" class="nav-link" onclick="showContent('dashboard')">Dashboard</a>
    <a href="#" class="nav-link" onclick="showContent('sales')">Grafik Penjualan</a>
    <a href="#" class="nav-link" onclick="showContent('products')">Penambahan Produk</a>
    <a href="#" class="nav-link" onclick="showContent('orders')">Linimasa Penyewaan</a>
    <a href="#" class="nav-link" onclick="showContent('settings')">Settings</a>
    <a href="login" class="nav-link">Logout</a>
  </div>

  <div class="content" id="content">
    <button class="btn btn-primary toggle-btn" id="toggleBtn" onclick="toggleSidebar()">☰</button>

    <!-- Content Sections -->
    <div id="dashboard" class="polarArea active">
      <h5>Dashboard</h5>
      <canvas id="polarAreaChart"></canvas>

      <h5 class="mt-5">Pengguna dengan Penyewaan Terbanyak</h5>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Jumlah Penyewaan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($resultTopUsers->num_rows > 0) {
            while ($row = $resultTopUsers->fetch_assoc()) {
              echo "<tr>
                  <td>{$row['user_id']}</td>
                  <td>{$row['username']}</td>
                  <td>{$row['fullname']}</td>
                  <td>{$row['jumlah_penyewaan']}</td>
                </tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='text-center'>Tidak ada data penyewaan</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <div id="sales" class="polarArea">
      <h5>Grafik Penjualan</h5>
      <p>Here you can see sales charts and statistics.</p>
    </div>
    <div id="products" class="polarArea">
      <div class="d-flex justify-content-center align-items-center flex-wrap">
        <div class="form-container">
          <h5 class="text-center">Penambahan Produk Penyewaan</h5>
          <form id="productForm" action="./handler/add_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="productName" class="form-label">Nama Produk</label>
              <input type="text" class="form-control" id="productName" name="productName" placeholder="Masukkan nama produk" required>
            </div>
            <div class="mb-3">
              <label for="productPrice" class="form-label">Harga Produk</label>
              <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Masukkan harga produk" required>
            </div>
            <div class="mb-3">
              <label for="productCategory" class="form-label">Kategori Produk</label>
              <select class="form-select" id="productCategory" name="productCategory" required>
                <option value="">Pilih Kategori</option>
                <option value="adat">Adat</option>
                <option value="suku">Suku</option>
                <option value="wisuda">Wisuda</option>
                <option value="event">Event</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="productDescription" class="form-label">Deskripsi Produk</label>
              <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Tambahkan deskripsi produk"></textarea>
            </div>
            <div class="mb-3">
              <label for="productImage" class="form-label">Gambar Produk</label>
              <input type="file" class="form-control" id="productImage" name="productImage">
            </div>
            <div class="mb-3">
              <label for="productStock" class="form-label">Stok Barang</label>
              <input type="number" class="form-control" id="productStock" name="productStock" placeholder="Masukkan jumlah stok barang" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Tambah Produk</button>
          </form>
          <h5 class="text-center mt-4">Update Stok Produk</h5>
          <form id="stockUpdateForm" action="./handler/proses_update_stock.php" method="POST">
            <div class="mb-3">
              <label for="productId" class="form-label">ID Produk</label>
              <input type="number" class="form-control" id="productId" name="productId" placeholder="Masukkan ID produk" required>
            </div>
            <div class="mb-3">
              <label for="newStock" class="form-label">Stok Baru</label>
              <input type="number" class="form-control" id="newStock" name="newStock" placeholder="Masukkan jumlah stok baru" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Stok</button>
          </form>

          <h5 class="text-center mt-4">Hapus Produk</h5>
          <form id="deleteProductForm" action="./handler/proses_delete_product.php" method="POST">
            <div class="mb-3">
              <label for="deleteProductId" class="form-label">ID Produk</label>
              <input type="number" class="form-control" id="deleteProductId" name="deleteProductId" placeholder="Masukkan ID produk yang ingin dihapus" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">Hapus Produk</button>
          </form>
        </div>
      </div>
      <div class="container my-5">
        <h2 class="text-center mb-4">Pilih Kategori</h2>

        <!-- Search Input -->
        <div class="d-flex justify-content-center mb-4">
          <input type="text" id="searchInput" onkeyup="searchCards()" class="form-control w-50" placeholder="Cari produk...">
        </div>

        <!-- Category Selection Buttons -->
        <div class="d-flex justify-content-center mb-4">
          <button class="btn btn-outline-primary category-btn me-2" onclick="filterCards('all')">Semua</button>
          <button class="btn btn-outline-primary category-btn me-2" onclick="filterCards('adat')">Adat</button>
          <button class="btn btn-outline-primary category-btn me-2" onclick="filterCards('suku')">Suku</button>
          <button class="btn btn-outline-primary category-btn me-2" onclick="filterCards('wisuda')">Wisuda</button>
          <button class="btn btn-outline-primary category-btn" onclick="filterCards('event')">Event</button>
        </div>

        <!-- Cards Container -->
        <div class="row" id="cardContainer">

          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Set kategori sebagai kelas CSS
              $kategoriClass = strtolower($row['kategori']);
          ?>
              <div class="col-md-4 mb-3 card-item <?= $kategoriClass ?>" data-name="<?= strtolower($row['nama_produk']) ?>">
                <div class="card">
                  <img src="<?= $row['gambar_produk'] ?>" class="card-img-top" alt="<?= $row['nama_produk'] ?>">
                  <div class="card-body">
                    <strong class="card-title"> ID PRODUK: <?= $row['id'] ?></strong>
                    <h5 class="card-title"><?= $row['nama_produk'] ?></h5>
                    <p class="card-text"><?= $row['deskripsi'] ?></p>
                    <p class="card-text"><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <p class="card-text"><strong>Stok:</strong> <?= $row['stok'] ?></p>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<p class='text-center'>Tidak ada produk yang tersedia.</p>";
          }
          ?>

        </div>
      </div>

    </div>

    <div id="orders" class="polarArea">
      <h5>Linimasa Penyewaan</h5>
      <p>Here you can view the rental timeline.</p>
    </div>
    <div id="settings" class="polarArea">
      <h5>conain</h5>
      <p>Here you can modify your settings.</p>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Display the Dashboard content by default on page load
    window.onload = function() {
      showContent('dashboard');
    };

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const toggleBtn = document.getElementById('toggleBtn');

      // Toggle collapsed class on sidebar
      sidebar.classList.toggle('collapsed');
      content.classList.toggle('expanded');

      // Change button icon
      toggleBtn.textContent = sidebar.classList.contains('collapsed') ? '☰' : 'X';
    }

    function showContent(section) {
      const contents = document.querySelectorAll('.polarArea'); // Get all content sections

      // Hide all sections
      contents.forEach(content => {
        content.style.display = 'none'; // Ensure all sections are hidden
      });

      // Show the selected section
      document.getElementById(section).style.display = 'block';
    }

   // Inisialisasi Polar Area Chart
const ctx = document.getElementById('polarAreaChart').getContext('2d');

// Ambil data produk dari grafik.php
fetch('./grafik.php')
  .then(response => response.json()) // Ambil data JSON dari grafik.php
  .then(data => {
    const labels = data.labels;  // Mendapatkan label produk
    const stockData = data.data; // Mendapatkan data stok produk
    
    // Data untuk grafik
    const chartData = {
      labels: labels,
      datasets: [{
        label: 'Jumlah Stok Produk',
        data: stockData,
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(255, 159, 64, 0.5)',
          'rgba(255, 205, 86, 0.5)',
          'rgba(75, 192, 192, 0.5)',
          'rgba(54, 162, 235, 0.5)',
          'rgba(153, 102, 255, 0.5)',
          'rgba(255, 159, 64, 0.5)'
        ]
      }]
    };

    // Membuat chart baru dengan data yang diperbarui
    const polarAreaChart = new Chart(ctx, {
      type: 'polarArea',
      data: chartData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
        }
      }
    });
  })
  .catch(error => {
    console.error('Error fetching data from grafik.php:', error);
  });

    // CARD SELECTOR
    function filterCards(category) {
      var cards = document.getElementsByClassName('card-item');
      for (var i = 0; i < cards.length; i++) {
        if (category === 'all') {
          cards[i].style.display = 'block';
        } else {
          cards[i].style.display = cards[i].classList.contains(category) ? 'block' : 'none';
        }
      }
    }

    // JavaScript untuk filter pencarian
    function searchCards() {
      var input = document.getElementById('searchInput');
      var filter = input.value.toLowerCase();
      var cards = document.getElementsByClassName('card-item');

      for (var i = 0; i < cards.length; i++) {
        var cardName = cards[i].getAttribute('data-name');
        if (cardName.includes(filter)) {
          cards[i].style.display = 'block';
        } else {
          cards[i].style.display = 'none';
        }
      }
    }
  </script>

</body>

</html>

<?php
// Tutup koneksi database
$conn->close();
?>