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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/details.css">
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
            <p class="lead mb-0 text-warning fw-bolder">COPY AND SAVE YOUR REFFERENCE # FOR FUTURE USE.</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="details-container">
        <div class="container">
            <!-- Summary Card -->
            <div class="summary-card" data-aos="fade-up">
                <div class="summary-header text-center">
                    <h4 class="">Reference: <span
                            class="text-warning fw-bolder"><?php echo $reservation['transaction_reference']; ?></span>
                    </h4>
                    <h2 class="guest-name"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?>
                    </h2>
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
                        <span
                            class="detail-value"><?php echo $reservation['firstname'] . ' ' . $reservation['lastname']; ?></span>
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
                        <span
                            class="detail-value"><?php echo date('M j, Y', strtotime($reservation['check_in_date'])); ?></span>
                    </div>
                    <?php if (!empty($reservation['check_out_date'])): ?>
                    <div class="detail-item">
                        <span class="detail-label">Check-out</span>
                        <span
                            class="detail-value"><?php echo date('M j, Y', strtotime($reservation['check_out_date'])); ?></span>
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
                            <p class="fw-semibold">
                                <?php echo ucfirst(str_replace('_', ' ', $reservation['payment_method'])); ?></p>
                        </div>
                        <?php if (!empty($reservation['payment_reference'])): ?>
                        <div class="mt-2">
                            <p class="text-muted mb-1">Reference Number</p>
                            <p class="fw-semibold"><?php echo $reservation['payment_reference']; ?></p>
                        </div>
                        <button class="btn btn-danger" id="cancelReservationBtn">
                            <i class="fas fa-times-circle me-2"></i>Cancel Reservation
                        </button>                        
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="amount-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="amount-label">Total Amount</div>
                        <div class="amount-value">₱<?php echo number_format($reservation['total_amount'], 2); ?></div>
                        
                    </div>
                    <div class="" data-aos="fade-up" data-aos-delay="300">

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
                        <div class="timeline-date">
                            <?php echo date('F j, Y g:i A', strtotime($reservation['reservation_date'])); ?></div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Payment
                            <?php echo $reservation['payment_status'] === 'verified' ? 'Confirmed' : 'Pending'; ?></div>
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
                        <div class="timeline-date">Your accommodation will be ready on
                            <?php echo date('F j, Y', strtotime($reservation['check_in_date'])); ?></div>
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
                    <li>Keep your reference number for any inquiries:
                        <strong><?php echo $reservation['transaction_reference']; ?></strong></li>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    AOS.init({
        duration: 800,
        once: true
    });
    </script>

    <script>
    document.getElementById('cancelReservationBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Cancel Reservation?',
            text: "Are you sure you want to cancel your reservation? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('cancel_reservation.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'transaction_ref=<?php echo $reservation['transaction_reference']; ?>'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled!',
                                text: data.message,
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                            });
                            console.log(data.message);
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'Something went wrong while cancelling your reservation.',
                        });
                    });
            }
        });
    });
    </script>

</body>

</html>