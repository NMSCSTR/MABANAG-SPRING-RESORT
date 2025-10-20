<!DOCTYPE html>
<?php
    require 'admin/connect.php';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname         = $_POST['firstname'];
        $lastname          = $_POST['lastname'];
        $contactno         = $_POST['contactno'];
        $address           = $_POST['address'];
        $reservation_type  = $_POST['reservation_type'];
        $room_id           = $_POST['room_id'] ?? null;
        $cottage_id        = $_POST['cottage_id'] ?? null;
        $check_in_date     = $_POST['check_in_date'];
        $check_out_date    = $_POST['check_out_date'];
        $payment_method    = $_POST['payment_method'];
        $payment_reference = $_POST['payment_reference'] ?? '';

        $transaction_ref = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);


        // Handle file upload
        $receipt_file = null;
        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] == 0) {
            $upload_dir = 'uploads/receipts/';
            if (! file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension     = strtolower(pathinfo($_FILES['receipt_file']['name'], PATHINFO_EXTENSION));
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
                $room_data  = $room_query->fetch_array();
                $daily_rate = floatval($room_data['room_price']);

                // Calculate number of days
                $check_in       = new DateTime($check_in_date);
                $check_out      = new DateTime($check_out_date);
                $number_of_days = $check_out->diff($check_in)->days;

                $total_amount = $daily_rate * $number_of_days;
            }
        } elseif ($reservation_type == 'cottage' && $cottage_id) {
            $cottage_query = $conn->query("SELECT cottage_price FROM cottage WHERE cottage_id = '$cottage_id'");
            if ($cottage_query && $cottage_query->num_rows > 0) {
                $cottage_data = $cottage_query->fetch_array();
                $daily_rate   = floatval($cottage_data['cottage_price']);

                // Cottage is charged per use (no checkout)
                $total_amount   = $daily_rate;
                $check_out_date = 'NULL';
            }
        }

        // Insert guest information
        $guest_query = $conn->query("INSERT INTO guest (firstname, lastname, address, contactno)
                                    VALUES ('$firstname', '$lastname', '$address', '$contactno')");

        if ($guest_query) {
            $guest_id = $conn->insert_id;

            // Insert reservation
            $reservation_query = $conn->query("INSERT INTO reservation (guest_id, transaction_reference, room_id, cottage_id, check_in_date, check_out_date, total_amount)
                                             VALUES ('$guest_id', '$transaction_ref', " . ($room_id ? "'$room_id'" : 'NULL') . ", " . ($cottage_id ? "'$cottage_id'" : 'NULL') . ", '$check_in_date', " . ($check_out_date === 'NULL' ? 'NULL' : "'$check_out_date'") . ", '$total_amount')");

            if ($reservation_query) {
                $reservation_id = $conn->insert_id;

                // Insert payment record for admin review
                $receipt_file_sql      = $receipt_file ? "'$receipt_file'" : 'NULL';
                $payment_reference_sql = ! empty($payment_reference) ? "'$payment_reference'" : 'NULL';
                $payment_query         = $conn->query("INSERT INTO payment (reservation_id, amount, payment_method, payment_reference, receipt_file, payment_status)
                                             VALUES ('$reservation_id', '$total_amount', '$payment_method', $payment_reference_sql, $receipt_file_sql, 'pending')");

                if ($payment_query) {
                    // Redirect to transaction details page
                    header("Location: transaction_details.php?reservation_id=" . $reservation_id . "&transaction_ref=" . $transaction_ref);
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

<!doctype html>
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
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
        --light-blue: #8ecae6;
        --resort-primary: #2d5a27;
        --resort-accent: #4a7c59;
        --resort-light: #e8f5e8;
        --resort-dark: #1e3d20;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
        overflow-x: hidden;
    }

    /* Nature-inspired elements */
    .leaf-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232d5a27' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    /* Enhanced Navbar */
    .navbar {
        background-color: rgba(45, 90, 39, 0.95) !important;
        padding: 1rem 1.5rem;
        color: white;
        transition: all 0.4s ease;
        backdrop-filter: blur(0px);
    }

    .navbar.scrolled {
        background-color: rgba(45, 90, 39, 0.98) !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
        padding: 0.75rem 1.5rem;
        backdrop-filter: blur(10px);
    }

    .navbar .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--sand) !important;
        transition: all 0.3s ease;
    }

    .navbar .navbar-nav .nav-link {
        color: white !important;
        font-weight: 500;
        letter-spacing: 0.05rem;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
        position: relative;
    }

    .navbar .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--sand);
        transition: width 0.3s ease;
    }

    .navbar .navbar-nav .nav-link:hover::after,
    .navbar .navbar-nav .nav-link.active::after {
        width: 100%;
    }

    .navbar .navbar-nav .nav-link:hover,
    .navbar .navbar-nav .nav-link.active {
        color: var(--sand) !important;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(45, 90, 39, 0.7), rgba(74, 124, 89, 0.7)),
            url('photo/g1.jpg') center/cover no-repeat;
        height: 40vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 2rem;
        margin-top: 76px;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Nature elements */
    .nature-badge {
        background-color: var(--leaf-green);
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
    }

    /* Reservation Section */
    .reservation-section {
        padding: 4rem 0;
        background-color: #f9f9f9;
    }

    .reservation-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent));
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .card-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .card-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Form Styling */
    .reservation-form {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .section-title {
        color: var(--resort-primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        background-color: var(--resort-light);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .form-label {
        font-weight: 500;
        color: var(--resort-dark);
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--resort-primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 90, 39, 0.25);
    }

    /* Enhanced Buttons */
    .btn-reserve {
        background-color: var(--resort-primary);
        color: white;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 6px rgba(45, 90, 39, 0.2);
    }

    .btn-reserve:hover {
        background-color: var(--resort-accent);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(45, 90, 39, 0.3);
    }

    .btn-reset {
        background-color: transparent;
        color: var(--resort-primary);
        border: 2px solid var(--resort-primary);
        border-radius: 50px;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-reset:hover {
        background-color: var(--resort-primary);
        color: white;
        transform: translateY(-2px);
    }

    /* File Upload Styling */
    .file-upload-container {
        position: relative;
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #fafafa;
    }

    .file-upload-container:hover {
        border-color: var(--resort-primary);
        background-color: var(--resort-light);
    }

    .file-upload-container.dragover {
        border-color: var(--resort-primary);
        background-color: var(--resort-light);
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-info {
        pointer-events: none;
    }

    .file-text {
        display: block;
        font-weight: 500;
        color: var(--resort-dark);
        margin-bottom: 0.5rem;
    }

    .file-hint {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .file-preview {
        margin-top: 1rem;
        border-radius: 8px;
        overflow: hidden;
        background-color: var(--resort-light);
        border: 1px solid #ddd;
    }

    .preview-content {
        display: flex;
        align-items: center;
        padding: 1rem;
    }

    .preview-icon {
        font-size: 1.5rem;
        color: var(--resort-primary);
        margin-right: 1rem;
    }

    .preview-info {
        flex-grow: 1;
    }

    .preview-name {
        display: block;
        font-weight: 500;
        color: var(--resort-dark);
    }

    .preview-size {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .btn-remove-file {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: background-color 0.3s ease;
    }

    .btn-remove-file:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }

    /* Stay Duration */
    .stay-duration {
        background-color: var(--resort-light);
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid var(--resort-primary);
    }

    .duration-text {
        font-weight: 500;
        color: var(--resort-dark);
    }

    /* Total Amount */
    .total-amount {
        background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent));
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .amount-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .amount-label {
        font-size: 1.1rem;
        font-weight: 500;
    }

    #total_amount {
        font-size: 1.8rem;
        font-weight: 700;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    /* GCash Info Styling */
    .gcash-info {
        background-color: var(--resort-light);
        border-radius: 12px;
        padding: 1.5rem;
        border-left: 4px solid var(--resort-primary);
    }

    .gcash-number {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--resort-primary);
    }

    /* Footer */
    .footer {
        background: linear-gradient(to right, var(--resort-primary), var(--resort-accent));
        color: white;
        padding: 3rem 0 1.5rem;
    }

    .footer h5 {
        color: var(--sand);
        margin-bottom: 1.5rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: #ddd;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--sand);
    }

    /* Alert Styling */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .card-title {
            font-size: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-reserve, .btn-reset {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .reservation-form {
            padding: 1.5rem;
        }
        
        .card-header {
            padding: 1.5rem;
        }
        
        .hero-section {
            height: 30vh;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cottages.php">Cottages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notice.php">Important Notice</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <span class="nature-badge">Book Your Nature Escape</span>
                    <h1 class="hero-title">Make Your Reservation</h1>
                    <p class="hero-subtitle">Experience the beauty and tranquility of Mabanag Spring Resort - your perfect nature getaway awaits</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Form Section -->
    <div class="reservation-section leaf-pattern">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="reservation-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas fa-calendar-check me-2"></i>Reservation Form
                            </h2>
                            <p class="card-subtitle">Fill out the form below to book your nature escape</p>
                        </div>

                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
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
                                                while ($room = $room_query->fetch_array()):
                                            ?>
                                                <option value="<?php echo $room['room_id'] ?>" data-price="<?php echo $room['room_price'] ?>">
                                                    Room <?php echo $room['room_number'] ?> - <?php echo $room['room_type'] ?> (₱<?php echo $room['room_price'] ?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <select class="form-select" id="cottage_id" name="cottage_id" style="display: none;">
                                            <option value="">Select Cottage</option>
                                            <?php
                                                $cottage_query = $conn->query("SELECT * FROM cottage WHERE cottage_availability = 'available'");
                                                while ($cottage = $cottage_query->fetch_array()):
                                            ?>
                                                <option value="<?php echo $cottage['cottage_id'] ?>" data-price="<?php echo $cottage['cottage_price'] ?>">
                                                    <?php echo $cottage['cottage_type'] ?> (₱<?php echo $cottage['cottage_price'] ?>)
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
                                
                                <!-- GCash Information -->
                                <?php
                                    $sql  = mysqli_query($conn, " SELECT * FROM `owners_info` WHERE `info_id` = 1");
                                    $info = mysqli_fetch_assoc($sql);
                                ?>
                                <div class="gcash-info mb-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold text-resort-primary">
                                                <i class="fas fa-mobile-alt me-2"></i>Send payment to this GCash Number
                                            </label>
                                            <p class="gcash-number mb-0"><?php echo $info['gcash_number'] ?></p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-user me-2 text-success"></i> GCash Account Name
                                            </label>
                                            <p class="mb-0"><?php echo $info['gcash_name'] ?></p>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-2 mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please take a screenshot of your payment confirmation for uploading
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method *</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="gcash">GCash</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_reference" class="form-label">Payment Reference *</label>
                                        <input type="text" class="form-control" id="payment_reference" name="payment_reference"
                                               placeholder="Reference Number, etc." required>
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
                    <h5><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</h5>
                    <p>Experience the perfect blend of nature and comfort at our beautiful resort nestled in pristine natural surroundings.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="guest_reservation.php">Reservation</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-phone me-2"></i><?php echo $info['phone_number'] ?? '+63 123 456 7890'; ?></p>
                    <p><i class="fas fa-envelope me-2"></i><?php echo $info['email_address'] ?? 'info@mabanagresort.com'; ?></p>
                    <p><i class="fas fa-map-marker-alt me-2"></i><?php echo $info['address'] ?? 'Mabanag, Juban, Sorsogon'; ?></p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Mabanag Spring Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar background toggle on scroll
        document.addEventListener("DOMContentLoaded", () => {
            const navbar = document.querySelector(".navbar");

            function toggleNavbarBackground() {
                if (window.scrollY > 60) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            }

            toggleNavbarBackground();
            window.addEventListener("scroll", toggleNavbarBackground);

            // File upload preview functionality
            const fileInput = document.getElementById('receipt_file');
            const filePreview = document.getElementById('file-preview');
            const previewName = document.querySelector('.preview-name');
            const previewSize = document.querySelector('.preview-size');

            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                    
                    previewName.textContent = fileName;
                    previewSize.textContent = fileSize + ' MB';
                    filePreview.style.display = 'block';
                }
            });

            // Remove file function
            window.removeFile = function() {
                fileInput.value = '';
                filePreview.style.display = 'none';
            };

            // Drag and drop functionality
            const fileUploadContainer = document.querySelector('.file-upload-container');

            fileUploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            fileUploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            fileUploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                fileInput.files = e.dataTransfer.files;
                
                // Trigger change event
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            });
        });
    </script>

    <script src="js/guest_reservation_script.js"></script>
</body>
</html>