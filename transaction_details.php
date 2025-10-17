<!DOCTYPE html>
<?php 
require_once 'admin/connect.php';

// Check if transaction_ref is provided
if (!isset($_GET['transaction_ref']) || empty($_GET['transaction_ref'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Missing Reference',
            text: 'Transaction reference is required!',
        }).then(() => {
            window.location.href = 'index.php';
        });
    </script>";
    exit();
}



$transaction_ref = $_GET['transaction_ref'];
$contactno = isset($_GET['contactno']) ? $_GET['contactno'] : '';

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
    WHERE r.transaction_reference = '$transaction_ref' OR g.contactno = '$contactno'
";

$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    $msg = "The transaction you are trying to access does not exist.";
    echo "<script>
    (function(){
      var s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
      s.onload = function(){
        Swal.fire({
          icon: 'error',
          title: 'No Record Found',
          text: " . json_encode($msg) . "
        }).then(function(){
          window.location.href = 'index.php';
        });
      };
      document.head.appendChild(s);
    })();
    </script>";
    exit();
}



$reservation = $result->fetch_assoc();

// Calculate duration only if check_out_date exists
$duration = 0;
if (!empty($reservation['check_out_date'])) {
    $check_in = new DateTime($reservation['check_in_date']);
    $check_out = new DateTime($reservation['check_out_date']);
    $duration = $check_out->diff($check_in)->days;
}
?>

 <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
    :root {
        --forest-green: #2d5a27;
        --spring-green: #4a7c59;
        --leaf-green: #8cb369;
        --water-blue: #4d9de0;
        --sky-blue: #a1c6ea;
        --earth-brown: #8b5a2b;
        --sand: #e6ccb2;
        --sunset: #e76f51;
        --deep-blue: #264653;
        --resort-primary: #2d5a27;
        --resort-accent: #4a7c59;
        --resort-light: #e8f5e8;
        --resort-dark: #1e3d20;
        --card-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #333;
        min-height: 100vh;
    }

    /* Navigation */
    .navbar {
        background: rgba(45, 90, 39, 0.95) !important;
        backdrop-filter: blur(10px);
        padding: 1rem 0;
        transition: all 0.4s ease;
    }

    .navbar-brand {
        font-weight: 700;
        color: var(--sand) !important;
        font-size: 1.4rem;
    }

    /* Hero Section */
    .confirmation-hero {
        background: linear-gradient(135deg, var(--resort-primary) 0%, var(--resort-accent) 100%);
        color: white;
        padding: 4rem 0 2rem;
        margin-top: 76px;
        position: relative;
        overflow: hidden;
    }

    .confirmation-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .confirmation-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    /* Main Content Layout */
    .details-container {
        padding: 3rem 0;
    }

    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .summary-header {
        background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent));
        color: white;
        padding: 2rem;
        position: relative;
    }

    .summary-header::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: var(--resort-primary);
        transform: rotate(45deg);
    }

    .ref-number {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .guest-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .reservation-type {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Info Cards Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: var(--resort-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: var(--resort-primary);
        font-size: 1.2rem;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--resort-dark);
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        font-weight: 500;
        color: #666;
        min-width: 120px;
    }

    .detail-value {
        font-weight: 500;
        color: #333;
        text-align: right;
        flex: 1;
    }

    /* Status Card */
    .status-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
    }

    .status-badge {
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-confirmed {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-approved {
        background: #d1edff;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    /* Amount Card */
    .amount-card {
        background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent));
        color: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        text-align: center;
        margin-bottom: 2rem;
    }

    .amount-label {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .amount-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0;
    }

    /* Timeline */
    .timeline {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 40px;
        bottom: -20px;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--resort-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: var(--resort-primary);
        font-size: 1.2rem;
        position: relative;
        z-index: 2;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-weight: 600;
        color: var(--resort-dark);
        margin-bottom: 0.25rem;
    }

    .timeline-date {
        font-size: 0.9rem;
        color: #666;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: var(--resort-primary);
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: var(--resort-accent);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45, 90, 39, 0.3);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--resort-primary);
        color: var(--resort-primary);
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background: var(--resort-primary);
        color: white;
        transform: translateY(-2px);
    }

    /* Footer */
    .footer {
        background: var(--resort-dark);
        color: white;
        padding: 3rem 0 1.5rem;
        margin-top: 4rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-primary, .btn-outline {
            width: 100%;
        }
        
        .guest-name {
            font-size: 1.5rem;
        }
    }

    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white !important;
        }
        
        .summary-card, .info-card, .status-card, .amount-card, .timeline {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-leaf me-2"></i>Mabanag Spring Resort
            </a>
        </div>
    </nav>

    <!-- Confirmation Hero -->
    <section class="confirmation-hero">
        <div class="container text-center">
            <div class="confirmation-badge">
                <i class="fas fa-check-circle me-2"></i>Reservation Confirmed
            </div>
            <h1 class="display-5 fw-bold mb-3">Your Booking is Confirmed!</h1>
            <p class="lead mb-0">We're excited to welcome you to Mabanag Spring Resort</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="details-container">
        <div class="container">
            <!-- Summary Card -->
            <div class="summary-card" data-aos="fade-up">
                <div class="summary-header text-center">
                    <div class="ref-number">Reference: <?php echo $reservation['transaction_reference']; ?></div>
                    <h2 class="guest-name"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?></h2>
                    <div class="reservation-type">
                        <?php 
                            if ($reservation['room_id']) {
                                echo 'Room Reservation';
                            } else if ($reservation['cottage_id']) {
                                echo 'Cottage Reservation';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Info Cards Grid -->
            <div class="info-grid">
                <!-- Personal Information -->
                <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="card-title">Guest Information</h3>
                    <div class="detail-item">
                        <span class="detail-label">Full Name</span>
                        <span class="detail-value"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Contact</span>
                        <span class="detail-value"><?php echo $reservation['contactno']; ?></span>
                    </div>
                </div>

                <!-- Stay Details -->
                <div class="info-card" data-aos="fade-up" data-aos-delay="150">
                    <div class="card-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="card-title">Stay Details</h3>
                    <div class="detail-item">
                        <span class="detail-label">Check-in</span>
                        <span class="detail-value"><?php echo date('M j, Y', strtotime($reservation['check_in_date'])); ?></span>
                    </div>
                <?php if (!empty($reservation['check_out_date'])): ?>
                    <div class="detail-item">
                        <span class="detail-label">Check-out</span>
                        <span class="detail-value"><?php echo date('M j, Y', strtotime($reservation['check_out_date'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Duration</span>
                        <span class="detail-value"><?php echo $duration . ' night(s)'; ?></span>
                    </div>
                <?php else: ?>
                    <div class="detail-item">
                        <span class="detail-label">Duration</span>
                        <span class="detail-value">1 day (Cottage Reservation)</span>
                    </div>
                <?php endif; ?>
                </div>

                <!-- Accommodation -->
                <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="card-title">Accommodation</h3>
                    <div class="detail-item">
                        <span class="detail-label">Type</span>
                        <span class="detail-value">
                            <?php 
                                if ($reservation['room_id']) {
                                    echo 'Room ' . $reservation['room_number'];
                                } else if ($reservation['cottage_id']) {
                                    echo $reservation['cottage_type'];
                                }
                            ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Category</span>
                        <span class="detail-value">
                            <?php 
                                if ($reservation['room_id']) {
                                    echo $reservation['room_type'];
                                } else if ($reservation['cottage_id']) {
                                    echo 'Cottage';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status and Payment Row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="status-card" data-aos="fade-up" data-aos-delay="250">
                        <h3 class="card-title mb-3">Reservation Status</h3>
                        <div class="status-badge status-<?php echo $reservation['status']; ?>">
                            <i class="fas fa-check-circle"></i>
                            <?php echo ucfirst($reservation['status']); ?>
                        </div>
                        <div class="mt-3">
                            <p class="text-muted mb-2">Payment Method</p>
                            <p class="fw-semibold"><?php echo ucfirst(str_replace('_', ' ', $reservation['payment_method'])); ?></p>
                        </div>
                        <?php if (!empty($reservation['payment_reference'])): ?>
                        <div class="mt-2">
                            <p class="text-muted mb-1">Reference Number</p>
                            <p class="fw-semibold"><?php echo $reservation['payment_reference']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="amount-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="amount-label">Total Amount</div>
                        <div class="amount-value">₱<?php echo number_format($reservation['total_amount'], 2); ?></div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline" data-aos="fade-up" data-aos-delay="350">
                <h3 class="card-title mb-4">Reservation Timeline</h3>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Reservation Submitted</div>
                        <div class="timeline-date"><?php echo date('F j, Y g:i A', strtotime($reservation['reservation_date'])); ?></div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Payment <?php echo $reservation['payment_status'] === 'verified' ? 'Confirmed' : 'Pending'; ?></div>
                        <div class="timeline-date">
                            <?php 
                                if ($reservation['payment_status'] === 'verified') {
                                    echo 'Payment verified and confirmed';
                                } else {
                                    echo 'Awaiting payment verification';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Ready for Check-in</div>
                        <div class="timeline-date">Your accommodation will be ready on <?php echo date('F j, Y', strtotime($reservation['check_in_date'])); ?></div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons no-print" data-aos="fade-up" data-aos-delay="400">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Confirmation
                </button>
                <a href="index.php" class="btn btn-outline">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="contactus.php" class="btn btn-outline">
                    <i class="fas fa-question-circle me-2"></i>Need Help?
                </a>
            </div>

            <!-- Important Notes -->
            <div class="alert alert-info mt-4 no-print" data-aos="fade-up" data-aos-delay="450">
                <h5><i class="fas fa-info-circle me-2"></i>Important Information</h5>
                <ul class="mb-0 mt-2">
                    <li>Please present this confirmation and valid ID upon arrival</li>
                    <li>Check-in time: 2:00 PM | Check-out time: 12:00 PM</li>
                    <li>Keep your reference number for any inquiries: <strong><?php echo $reservation['transaction_reference']; ?></strong></li>
                    <li>Contact us for any changes or cancellations</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer no-print">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</h5>
                    <p>Experience nature's beauty in comfort and style at our eco-friendly resort.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact Information</h5>
                    <p><i class="fas fa-phone me-2"></i>+63 123 456 7890</p>
                    <p><i class="fas fa-envelope me-2"></i>info@mabanagresort.com</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Mabanag, Juban, Sorsogon</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <div class="footer-links">
                        <a href="index.php" class="d-block mb-2">Home</a>
                        <a href="rooms.php" class="d-block mb-2">Rooms & Suites</a>
                        <a href="cottages.php" class="d-block mb-2">Cottages</a>
                        <a href="contact.php" class="d-block">Contact Us</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Mabanag Spring Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>