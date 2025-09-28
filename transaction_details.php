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
    <style>
        :root {
            --primary-color: #2c7a7b;
            --secondary-color: #4fd1c5;
            --accent-color: #f6ad55;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--dark-color);
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .hero-section {
            background: linear-gradient(rgba(44, 122, 123, 0.8), rgba(44, 122, 123, 0.9)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            font-weight: 300;
        }
        
        .details-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: -50px auto 50px;
            position: relative;
            z-index: 1;
            max-width: 900px;
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 30px;
        }
        
        .card-title {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .card-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 10px 0 0;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .info-label {
            font-weight: 600;
            min-width: 180px;
            color: var(--dark-color);
        }
        
        .info-value {
            color: #4a5568;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-pending {
            background-color: #fffaf0;
            color: #dd6b20;
        }
        
        .status-approved {
            background-color: #f0fff4;
            color: #38a169;
        }
        
        .status-rejected {
            background-color: #fff5f5;
            color: #e53e3e;
        }
        
        .amount-display {
            background: linear-gradient(to right, #f0fff4, #e6fffa);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        
        .amount-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .amount-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 10px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-print {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-print:hover {
            background-color: #285e5e;
            color: white;
        }
        
        .btn-back {
            background-color: #e2e8f0;
            color: var(--dark-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background-color: #cbd5e0;
        }
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0 20px;
        }
        
        .footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
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
                <!-- Personal Information -->
                <div class="section-title">
                    <i class="fas fa-user me-2"></i>Personal Information
                </div>
                
                <div class="info-row">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Contact Number:</div>
                    <div class="info-value"><?php echo $reservation['contactno']; ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value"><?php echo $reservation['address']; ?></div>
                </div>
                
                <!-- Reservation Details -->
                <div class="section-title">
                    <i class="fas fa-calendar-alt me-2"></i>Reservation Details
                </div>
                
                <div class="info-row">
                    <div class="info-label">Reservation Type:</div>
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
                
                <div class="info-row">
                    <div class="info-label">
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
                
                <div class="info-row">
                    <div class="info-label">Check-in Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($reservation['check_in_date'])); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Check-out Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($reservation['check_out_date'])); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Duration:</div>
                    <div class="info-value">
                        <?php 
                            $check_in = new DateTime($reservation['check_in_date']);
                            $check_out = new DateTime($reservation['check_out_date']);
                            $duration = $check_out->diff($check_in)->days;
                            echo $duration . ' day(s)';
                        ?>
                    </div>
                </div>
                
                <!-- Payment Information -->
                <div class="section-title">
                    <i class="fas fa-credit-card me-2"></i>Payment Information
                </div>
                
                <div class="info-row">
                    <div class="info-label">Payment Method:</div>
                    <div class="info-value"><?php echo ucfirst(str_replace('_', ' ', $reservation['payment_method'])); ?></div>
                </div>
                
                <?php if (!empty($reservation['payment_reference'])): ?>
                <div class="info-row">
                    <div class="info-label">Payment Reference:</div>
                    <div class="info-value"><?php echo $reservation['payment_reference']; ?></div>
                </div>
                <?php endif; ?>
                
                <div class="info-row">
                    <div class="info-label">Payment Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-<?php echo $reservation['payment_status']; ?>">
                            <?php echo ucfirst($reservation['payment_status']); ?>
                        </span>
                    </div>
                </div>
                
                <?php if (!empty($reservation['receipt_file'])): ?>
                <div class="info-row">
                    <div class="info-label">Receipt:</div>
                    <div class="info-value">
                        <a href="<?php echo $reservation['receipt_file']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>View Receipt
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Total Amount -->
                <div class="amount-display">
                    <div class="amount-label">Total Amount</div>
                    <div class="amount-value">₱<?php echo number_format($reservation['total_amount'], 2); ?></div>
                </div>
                
                <!-- Important Notes -->
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Important Information</h5>
                    <ul class="mb-0 mt-2">
                        <li>Your reservation is currently <strong>pending approval</strong>.</li>
                        <li>Our team will verify your payment and contact you within 24 hours.</li>
                        <li>Please keep this reservation ID for future reference: <strong>#<?php echo $reservation['reservation_id']; ?></strong></li>
                        <li>For any inquiries, please contact us at +63 123 456 7890.</li>
                    </ul>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-print" onclick="window.print()">
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
    <footer class="footer">
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
</body>
</html>