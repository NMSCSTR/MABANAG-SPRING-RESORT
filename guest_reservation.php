<!DOCTYPE html>
<?php 
    require_once 'admin/connect.php';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $contactno = $_POST['contactno'];
        $address = $_POST['address'];
        $reservation_type = $_POST['reservation_type'];
        $room_id = $_POST['room_id'] ?? null;
        $cottage_id = $_POST['cottage_id'] ?? null;
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];
        $payment_method = $_POST['payment_method'];
        $payment_reference = $_POST['payment_reference'] ?? '';
        
        // Handle file upload
        $receipt_file = null;
        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] == 0) {
            $upload_dir = 'uploads/receipts/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES['receipt_file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $file_name = 'receipt_' . time() . '_' . uniqid() . '.' . $file_extension;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['receipt_file']['tmp_name'], $file_path)) {
                    $receipt_file = $file_path;
                } else {
                    $error_message = "Error uploading receipt file.";
                }
            } else {
                $error_message = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            }
        }
        
        // Calculate amount (rate × number of days)
        $total_amount = 0;
        if ($reservation_type == 'room' && $room_id) {
            $room_query = $conn->query("SELECT room_price FROM room WHERE room_id = '$room_id'");
            if ($room_query && $room_query->num_rows > 0) {
                $room_data = $room_query->fetch_array();
                $daily_rate = floatval($room_data['room_price']);
                
                // Calculate number of days
                $check_in = new DateTime($check_in_date);
                $check_out = new DateTime($check_out_date);
                $number_of_days = $check_out->diff($check_in)->days;
                
                $total_amount = $daily_rate * $number_of_days;
            }
            } elseif ($reservation_type == 'cottage' && $cottage_id) {
                $cottage_query = $conn->query("SELECT cottage_price FROM cottage WHERE cottage_id = '$cottage_id'");
                if ($cottage_query && $cottage_query->num_rows > 0) {
                    $cottage_data = $cottage_query->fetch_array();
                    $daily_rate = floatval($cottage_data['cottage_price']);
                    
                    // Cottage is charged per use (no checkout)
                    $total_amount = $daily_rate;
                    $check_out_date = NULL; 
                }
            }

        
        // Insert guest information
        $guest_query = $conn->query("INSERT INTO guest (firstname, lastname, address, contactno) 
                                    VALUES ('$firstname', '$lastname', '$address', '$contactno')");
        
        if ($guest_query) {
            $guest_id = $conn->insert_id;
            
            // Insert reservation
            $reservation_query = $conn->query("INSERT INTO reservation (guest_id, room_id, cottage_id, check_in_date, check_out_date, total_amount) 
                                             VALUES ('$guest_id', " . ($room_id ? "'$room_id'" : 'NULL') . ", " . ($cottage_id ? "'$cottage_id'" : 'NULL') . ", '$check_in_date', '$check_out_date', '$total_amount')");
            
            if ($reservation_query) {
                $reservation_id = $conn->insert_id;
                
                // Insert payment record for admin review
                $receipt_file_sql = $receipt_file ? "'$receipt_file'" : 'NULL';
                $payment_reference_sql = !empty($payment_reference) ? "'$payment_reference'" : 'NULL';
                $payment_query = $conn->query("INSERT INTO payment (reservation_id, amount, payment_method, payment_reference, receipt_file, payment_status) 
                                             VALUES ('$reservation_id', '$total_amount', '$payment_method', $payment_reference_sql, $receipt_file_sql, 'pending')");
                
                if ($payment_query) {
                    // Redirect to transaction details page
                    header("Location: transaction_details.php?reservation_id=" . $reservation_id . "&contactno=" . $contactno);
                    exit();
                } else {
                    $error_message = "Error creating payment record: " . $conn->error;
                }
            } else {
                $error_message = "Error creating reservation: " . $conn->error;
            }
        } else {
            $error_message = "Error creating guest record: " . $conn->error;
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Reservation - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/guest_reservation_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h1 class="hero-title">Make Your Reservation</h1>
                    <p class="hero-subtitle">Experience the beauty and tranquility of Mabanag Spring Resort</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Form Section -->
    <div class="reservation-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="reservation-card">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas fa-calendar-check me-2"></i>Reservation Form
                            </h2>
                            <p class="card-subtitle">Fill out the form below to make your reservation</p>
                        </div>
                        
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="reservation-form" enctype="multipart/form-data">
                            <!-- Personal Information -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user me-2"></i>Personal Information
                                </h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="contactno" class="form-label">Contact Number *</label>
                                        <input type="tel" class="form-control" id="contactno" name="contactno" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-bed me-2"></i>Reservation Details
                                </h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reservation_type" class="form-label">Reservation Type *</label>
                                        <select class="form-select" id="reservation_type" name="reservation_type" required>
                                            <option value="">Select Type</option>
                                            <option value="room">Room</option>
                                            <option value="cottage">Cottage</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="room_id" class="form-label" id="room_label" style="display: none;">Select Room *</label>
                                        <label for="cottage_id" class="form-label" id="cottage_label" style="display: none;">Select Cottage *</label>
                                        <select class="form-select" id="room_id" name="room_id" style="display: none;">
                                            <option value="">Select Room</option>
                                            <?php
                                            $room_query = $conn->query("SELECT * FROM room WHERE room_availability = 'available'");
                                            while($room = $room_query->fetch_array()):
                                            ?>
                                                <option value="<?php echo $room['room_id']?>" data-price="<?php echo $room['room_price']?>">
                                                    Room <?php echo $room['room_number']?> - <?php echo $room['room_type']?> (₱<?php echo $room['room_price']?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <select class="form-select" id="cottage_id" name="cottage_id" style="display: none;">
                                            <option value="">Select Cottage</option>
                                            <?php
                                            $cottage_query = $conn->query("SELECT * FROM cottage WHERE cottage_availability = 'available'");
                                            while($cottage = $cottage_query->fetch_array()):
                                            ?>
                                                <option value="<?php echo $cottage['cottage_id']?>" data-price="<?php echo $cottage['cottage_price']?>">
                                                    <?php echo $cottage['cottage_type']?> (₱<?php echo $cottage['cottage_price']?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="check_in_date" class="form-label">Check-in Date *</label>
                                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="check_out_date" class="form-label">Check-out Date *</label>
                                        <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="stay-duration" id="stay_duration" style="display: none;">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <span class="duration-text">Duration: <strong id="duration_days">0</strong> day(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-credit-card me-2"></i>Payment Information
                                </h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method  <em style="color:red">09506587329</em> Maban *</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="gcash">GCash</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_reference" class="form-label">Payment Reference</label>
                                        <input type="text" class="form-control" id="payment_reference" name="payment_reference" 
                                               placeholder="Transaction ID, Reference Number, etc.">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="receipt_file" class="form-label">Upload Payment Receipt *</label>
                                        <div class="file-upload-container">
                                            <input type="file" class="form-control file-input" id="receipt_file" name="receipt_file" 
                                                   accept=".jpg,.jpeg,.png,.pdf" required>
                                            <div class="file-upload-info">
                                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                                <span class="file-text">Choose file or drag and drop</span>
                                                <small class="file-hint">JPG, PNG, PDF (Max 5MB)</small>
                                            </div>
                                        </div>
                                        <div class="file-preview" id="file-preview" style="display: none;">
                                            <div class="preview-content">
                                                <i class="fas fa-file-image preview-icon"></i>
                                                <div class="preview-info">
                                                    <span class="preview-name"></span>
                                                    <span class="preview-size"></span>
                                                </div>
                                                <button type="button" class="btn-remove-file" onclick="removeFile()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="total-amount">
                                    <div class="amount-display">
                                        <span class="amount-label">Total Amount:</span>
                                        <div id="total_amount">₱0.00</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-reserve">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Reservation
                                </button>
                                <button type="reset" class="btn btn-reset">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
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
                <p>&copy; 2024 Mabanag Spring Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/guest_reservation_script.js"></script>
</body>
</html>