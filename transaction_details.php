<!DOCTYPE html>
<?php 
    require_once 'admin/connect.php';
    
    // Check if reservation_id is provided
    if (!isset($_GET['reservation_id']) || empty($_GET['reservation_id'])) {
        header("Location: guest_reservation.php");
        exit();
    }
    
    $reservation_id = $_GET['reservation_id'];
    
    // Fetch reservation details
    $query = "
        SELECT 
            r.*,
            g.firstname, 
            g.lastname, 
            g.address, 
            g.contactno,
            p.payment_method,
            p.payment_reference,
            p.payment_status,
            p.receipt_file,
            rm.room_number,
            rm.room_type,
            rm.room_price,
            c.cottage_type,
            c.cottage_price
        FROM reservation r
        JOIN guest g ON r.guest_id = g.guest_id
        LEFT JOIN payment p ON r.reservation_id = p.reservation_id
        LEFT JOIN room rm ON r.room_id = rm.room_id
        LEFT JOIN cottage c ON r.cottage_id = c.cottage_id
        WHERE r.reservation_id = '$reservation_id'
    ";
    
    $result = $conn->query($query);
    
    if (!$result || $result->num_rows == 0) {
        header("Location: guest_reservation.php");
        exit();
    }
    
    $reservation = $result->fetch_assoc();
    
    // Calculate duration
    $check_in = new DateTime($reservation['check_in_date']);
    $check_out = new DateTime($reservation['check_out_date']);
    $duration = $check_out->diff($check_in)->days;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/transaction_details_style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#amenities">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="hero-title">Reservation Confirmation</h1>
                    <p class="hero-subtitle">Your reservation has been submitted successfully</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Details Section -->
    <div class="container">
        <div class="details-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-check-circle me-2"></i>Reservation #<?php echo $reservation['reservation_id']; ?>
                </h2>
                <p class="card-subtitle">Thank you for choosing Mabanag Spring Resort</p>
            </div>
            
            <div class="card-body">
                <!-- Print Header (only visible when printing) -->
                <div class="print-header" style="display: none;">
                    <div class="print-logo">Mabanag Spring Resort</div>
                    <div class="print-title">Reservation Confirmation</div>
                    <div class="print-subtitle">Reservation #<?php echo $reservation['reservation_id']; ?></div>
                    <div class="print-subtitle">Date: <?php echo date('F j, Y'); ?></div>
                </div>
                
                <!-- Personal Information -->
                <div class="section-title print-section-title">
                    <i class="fas fa-user me-2"></i>Personal Information
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Full Name:</div>
                    <div class="info-value"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?></div>
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Contact Number:</div>
                    <div class="info-value"><?php echo $reservation['contactno']; ?></div>
                </div>
                
                <!-- Reservation Details -->
                <div class="section-title print-section-title">
                    <i class="fas fa-calendar-alt me-2"></i>Reservation Details
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Reservation Type:</div>
                    <div class="info-value">
                        <?php 
                            if ($reservation['room_id']) {
                                echo 'Room Reservation';
                            } else if ($reservation['cottage_id']) {
                                echo 'Cottage Reservation';
                            }
                        ?>
                    </div>
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">
                        <?php 
                            if ($reservation['room_id']) {
                                echo 'Room Details:';
                            } else if ($reservation['cottage_id']) {
                                echo 'Cottage Details:';
                            }
                        ?>
                    </div>
                    <div class="info-value">
                        <?php 
                            if ($reservation['room_id']) {
                                echo 'Room ' . $reservation['room_number'] . ' - ' . $reservation['room_type'];
                            } else if ($reservation['cottage_id']) {
                                echo $reservation['cottage_type'];
                            }
                        ?>
                    </div>
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Check-in Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($reservation['check_in_date'])); ?></div>
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Check-out Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($reservation['check_out_date'])); ?></div>
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Duration:</div>
                    <div class="info-value"><?php echo $duration . ' day(s)'; ?></div>
                </div>
                
                <!-- Payment Information -->
                <div class="section-title print-section-title">
                    <i class="fas fa-credit-card me-2"></i>Payment Information
                </div>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Payment Method:</div>
                    <div class="info-value"><?php echo ucfirst(str_replace('_', ' ', $reservation['payment_method'])); ?></div>
                </div>
                
                <?php if (!empty($reservation['payment_reference'])): ?>
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Payment Reference:</div>
                    <div class="info-value"><?php echo $reservation['payment_reference']; ?></div>
                </div>
                <?php endif; ?>
                
                <div class="info-row print-info-row">
                    <div class="info-label print-info-label">Payment Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-<?php echo $reservation['payment_status']; ?>">
                            <?php echo ucfirst($reservation['payment_status']); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Total Amount -->
                <div class="amount-display print-total-amount">
                    <div class="amount-label">Total Amount</div>
                    <div class="amount-value">₱<?php echo number_format($reservation['total_amount'], 2); ?></div>
                </div>
                
                <!-- Important Notes (only visible on screen) -->
                <div class="alert alert-info mt-4 no-print">
                    <h5><i class="fas fa-info-circle me-2"></i>Important Information</h5>
                    <ul class="mb-0 mt-2">
                        <li>Your reservation is currently <strong>pending approval</strong>.</li>
                        <li>Our team will verify your payment and contact you within 24 hours.</li>
                        <li>Please keep this reservation ID for future reference: <strong>#<?php echo $reservation['reservation_id']; ?></strong></li>
                        <li>For any inquiries, please contact us at +63 123 456 7890.</li>
                    </ul>
                </div>
                
                <!-- Print Footer (only visible when printing) -->
                <div class="print-footer" style="display: none;">
                    <p>Thank you for choosing Mabanag Spring Resort</p>
                    <p>Contact: +63 123 456 7890 | Email: info@mabanagresort.com</p>
                    <p>This is an automated confirmation. Please present this document upon arrival.</p>
                </div>
                
                <!-- Watermark (only visible when printing) -->
                <div class="print-watermark" style="display: none;">CONFIRMED</div>
                
                <!-- Action Buttons (only visible on screen) -->
                <div class="action-buttons no-print">
                    <button class="btn btn-print" onclick="printReservation()">
                        <i class="fas fa-print me-2"></i>Print Confirmation
                    </button>
                    <a href="index.php" class="btn btn-back">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer no-print">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort</h5>
                    <p>Experience the perfect blend of nature and comfort at our beautiful resort.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="guest_reservation.php">Reservation</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-phone me-2"></i>+63 123 456 7890</p>
                    <p><i class="fas fa-envelope me-2"></i>info@mabanagresort.com</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2025 Mabanag Spring Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/transaction_details_script.js"></script>
</body>
</html>