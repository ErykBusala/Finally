<?php
include '../../koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch notifications for the logged-in user
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$notifications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Notifikasi</h2>
        <div class="list-group">
            <?php if ($notifications->num_rows > 0): ?>
                <?php while ($notification = $notifications->fetch_assoc()): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= htmlspecialchars($notification['message']) ?></span>
                        <button class="btn btn-sm btn-primary mark-as-read" data-id="<?= $notification['id'] ?>" data-product-id="<?= $notification['product_id'] ?>">Mark as Read</button>
                        <button class="btn btn-sm btn-danger delete-notification" data-id="<?= $notification['id'] ?>">Delete</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="list-group-item">Tidak ada notifikasi.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal for Rental Details -->
    <div class="modal fade" id="rentalDetailsModal" tabindex="-1" aria-labelledby="rentalDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rentalDetailsLabel">Detail Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="rentalDetailsBody">
                    <!-- Rental details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
                    $('.delete-notification').on('click', function() {
                        var notificationId = $(this).data('id');
                        // Confirm delete action
                        if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                            // Send AJAX request to delete the notification
                            $.ajax({
                                url: '../handler/delete_notification.php', // Ensure the path is correct
                                type: 'POST',
                                data: {
                                    id: notificationId
                                },
                                success: function(response) {
                                    // Remove the notification element from the list
                                    $('button[data-id="' + notificationId + '"]').closest('.list-group-item').remove();
                                    alert(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error deleting notification:", error);
                                }
                            });
                        }
                        $('.mark-as-read').on('click', function() {
                            var notificationId = $(this).data('id');
                            var productId = $(this).data('product-id');

                            // Mark the notification as read
                            $.ajax({
                                url: '../handler/mark_as_read.php', // Ensure the path is correct
                                type: 'POST',
                                data: {
                                    id: notificationId
                                },
                                success: function(response) {
                                    // Load rental details into the modal
                                    loadRentalDetails(productId);
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error marking as read:", error);
                                }
                            });
                        });

                        function loadRentalDetails(productId) {
                            // Load the rental details for the specific product
                            $.ajax({
                                url: '../handler/get_rental_details.php', // Ensure the path is correct
                                type: 'GET',
                                data: {
                                    product_id: productId
                                },
                                success: function(data) {
                                    $('#rentalDetailsBody').html(data);
                                    $('#rentalDetailsModal').modal('show');
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error loading rental details:", error);
                                }
                            });
                        }
                    });
                });
    </script>
</body>

</html>