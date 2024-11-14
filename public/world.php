<?php
session_start(); // Start session

// Check if user is logged in and verified
if (!isset($_SESSION['user_id']) || $_SESSION['is_verified'] != 1) {
    header("Location: login");
    exit();
}

// Database connection
include '../koneksi.php';

// Update notification status to 'read' when clicked
if (isset($_GET['mark_as_read'])) {
    $notificationId = $_GET['mark_as_read'];
    $updateSql = "UPDATE notifications SET status = 'read' WHERE id = ? AND user_id = ?";
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param("ii", $notificationId, $_SESSION['user_id']);
    $stmtUpdate->execute();
    $stmtUpdate->close();
}

// Get all products and their rental status for the logged-in user
$sql = "SELECT produk.*, sewa.tanggal_selesai 
        FROM produk 
        LEFT JOIN sewa ON produk.id = sewa.produk_id AND sewa.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penyewaan Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <div id="navbarr" class="d-flex justify-content-end">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
                    <li class="nav-item nav-item-rental"><a class="nav-link" href="#">Penyewaan</a></li>
                    <li id="produk" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Produk</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Penyewaan</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Notification Icon with Badge -->
                <?php
$sqlNotifications = "SELECT * FROM notifications WHERE user_id = ? AND status = 'unread' ORDER BY created_at DESC";
$stmtNotif = $conn->prepare($sqlNotifications);
$stmtNotif->bind_param("i", $_SESSION['user_id']);
$stmtNotif->execute();
$resultNotif = $stmtNotif->get_result();
$unreadCount = $resultNotif->num_rows;
?>

<div class="dropdown" style="margin-right: 20px;">
    <a href="#" id="notificationDropdown" class="text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        <span id="notificationBadge" class="badge bg-danger"><?= $unreadCount ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
        <?php while ($notif = $resultNotif->fetch_assoc()): ?>
            <li><a class="dropdown-item" href="?mark_as_read=<?= $notif['id'] ?>"><?= htmlspecialchars($notif['message']) ?></a></li>
        <?php endwhile; ?>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item text-center" href="./pluggin/notifications.php">Lihat semua</a></li>
    </ul>
</div>


                <!-- User Profile Dropdown -->
                <div class="dropdown" style="margin-right: 80px;">
                    <a href="#" class="dropdown-toggle text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="profile.php">Profil</a></li>
                        <li><a class="dropdown-item" href="settings.php">Pengaturan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>



    <!-- VIDEO -->
    <div class="container-fluid p-0" style="padding-top: 70px;">
        <div class="video-wrapper">
            <video autoplay muted loop>
                <source src="src/video/1.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-text">"Riasan adalah seni, dan setiap wajah adalah kanvas."</div>
        </div>
    </div>

    <!-- Scroll bar CARD -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold">Penyewaan Produk-produk</h1>
            <a href="#" id="lihatSemua1" class="text-center text-decoration-none">
                <p>Lihat Semua</p>
            </a>
            <hr>
            <div id="scrollButtonsS" class="d-flex gap-3 justify-content-center text-center">
                <button id="scrollLeftS" class="btn btn-outline-secondary rounded-circle">←</button>
                <a href="#" id="lihatSemua2" class="text-center text-decoration-none">
                    <p>Lihat Semua</p>
                </a>
                <button id="scrollRightS" class="btn btn-outline-secondary rounded-circle">→</button>
            </div>
        </div>
        <div id="scrollable-Pre-Order" class="scrollable-container p-2">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()):
                    $tanggalSelesai = $row['tanggal_selesai'];
                    $now = new DateTime();
                    $endDate = new DateTime($tanggalSelesai);
                    $remainingTimeInSeconds = max(0, $endDate->getTimestamp() - $now->getTimestamp());
                    $isRented = $remainingTimeInSeconds > 0;
                    $hargaProduk = $row['harga'];
                ?>
                    <div class="card text-center" data-tanggal-selesai="<?= htmlspecialchars($tanggalSelesai) ?>">
                        <img src="<?= htmlspecialchars($row['gambar_produk']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama_produk']) ?></h5>
                            <h6 class="card-title"><?= htmlspecialchars($row['deskripsi']) ?></h6>
                            <p class="card-text"><strong>Harga:</strong> Rp<?= number_format($hargaProduk, 0, ',', '.') ?></p>
                            <h6 class="card-title">Stok Barang Tersisa: <?= htmlspecialchars($row['stok']) ?></h6>

                            <?php if ($isRented): ?>
                                <div class="mt-3 text-center">
                                    <div id="countdownTimer<?= $row['id'] ?>" class="countdown" data-remaining-time="<?= $remainingTimeInSeconds ?>"></div>
                                </div>
                            <?php else: ?>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#sewaModal<?= $row['id'] ?>">Sewa Sekarang</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="sewaModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="sewaModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sewaModalLabel">Konfirmasi Penyewaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Anda akan menyewa <strong><?= htmlspecialchars($row['nama_produk']) ?></strong> dengan harga <strong>Rp<?= number_format($hargaProduk, 0, ',', '.') ?></strong> per unit.</p>

                                    <!-- Input jumlah produk -->
                                    <label for="jumlah<?= $row['id'] ?>">Jumlah Produk:</label>
                                    <input type="number" class="form-control" id="jumlah<?= $row['id'] ?>" placeholder="Masukkan jumlah" min="1" value="1">

                                    <label for="durasiSewa<?= $row['id'] ?>">Durasi Sewa (hari):</label>
                                    <input type="number" class="form-control" id="durasiSewa<?= $row['id'] ?>" placeholder="Masukkan durasi" min="3" value="3"> <!-- Set minimum to 3 -->

                                    <!-- New note field -->
                                    <label for="note<?= $row['id'] ?>">Pesan atau Catatan:</label>
                                    <textarea class="form-control" id="note<?= $row['id'] ?>" placeholder="Tambahkan pesan untuk penyewaan"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="btnSewa<?= $row['id'] ?>" onclick="sewaProduk(<?= $row['id'] ?>)">Sewa</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function sewaProduk(productId) {
                            const durasi = parseInt(document.getElementById('durasiSewa' + productId).value, 10);
                            const jumlah = parseInt(document.getElementById('jumlah' + productId).value, 10);
                            const note = document.getElementById('note' + productId).value;
                            const userId = <?= json_encode($_SESSION['user_id']); ?>;

                            if (isNaN(durasi) || durasi <= 0) {
                                alert("Durasi sewa minimal 1 hari.");
                                return;
                            }

                            const data = {
                                id: productId,
                                durasi: durasi,
                                jumlah: jumlah,
                                note: note,
                                user_id: userId
                            };

                            $.ajax({
                                url: './handler/proses_sewa.php',
                                type: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                success: function(response) {
                                    try {
                                        const result = typeof response === 'string' ? JSON.parse(response) : response;
                                        if (result.success) {
                                            alert("Sewa berhasil! Total biaya: Rp" + result.total + ". Tanggal selesai: " + result.tanggal_selesai);
                                            location.reload();
                                        } else {
                                            alert("Error: " + result.message);
                                        }
                                    } catch (e) {
                                        console.error("Failed to parse JSON response:", e);
                                        alert("Terjadi kesalahan saat memproses data.");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error:", status, error);
                                    alert("Terjadi kesalahan saat menghubungi server: " + xhr.responseText);
                                }
                            });

                            $('#sewaModal' + productId).modal('hide');
                        }

                        function startCountdown(elementId, totalSeconds) {
                            const countdownElement = document.getElementById(elementId);
                            let secondsRemaining = totalSeconds;

                            const interval = setInterval(() => {
                                if (secondsRemaining <= 0) {
                                    clearInterval(interval);
                                    countdownElement.textContent = "Waktu penyewaan telah habis.";
                                } else {
                                    const days = Math.floor(secondsRemaining / (3600 * 24));
                                    const hours = Math.floor((secondsRemaining % (3600 * 24)) / 3600);
                                    const minutes = Math.floor((secondsRemaining % 3600) / 60);
                                    const seconds = secondsRemaining % 60;

                                    countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                    secondsRemaining--;
                                }
                            }, 1000);
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            const countdownElement = document.getElementById('countdownTimer<?= $row['id'] ?>');
                            if (countdownElement) {
                                const remainingTime = parseInt(countdownElement.getAttribute('data-remaining-time'), 10);
                                startCountdown('countdownTimer<?= $row['id'] ?>', remainingTime);
                            }
                        });
                    </script>

                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada produk yang disewa saat ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Other HTML content... -->

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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="src/js/script.js"></script>
</body>

</html>

</body>

</html>