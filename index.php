<!doctype html>
<html lang="en">
<?php 
require_once 'admin/connect.php';
$sql = mysqli_query($conn, "SELECT * FROM `owners_info` WHERE `info_id` = 1");
$info = mysqli_fetch_assoc($sql);

$sql2 = "SELECT review_text, guest_name, guest_location, badge_category, rating FROM testimonials ORDER BY review_date DESC, testimonial_id DESC LIMIT 3";


$result = $conn->query($sql2);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mabanag Spring Resort</title>

    <!-- Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
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
        --light-blue: #8ecae6;
        --resort-primary: #2d5a27;
        --resort-accent: #4a7c59;
        --white: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        overflow-x: hidden;
    }

    /* Nature-inspired elements */
    .leaf-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232d5a27' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .water-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234d9de0' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Navbar */
    .navbar {
        padding: 1rem;
        transition: all 0.4s ease;
        background-color: rgba(45, 90, 39, 0.95);
    }

    .navbar.sticky {
        background-color: rgba(45, 90, 39, 0.98);
        backdrop-filter: blur(6px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
        font-weight: 600;
        color: var(--sand) !important;
    }

    .navbar-nav .nav-link {
        color: white !important;
        font-weight: 500;
        margin-left: 15px;
        transition: 0.3s;
        position: relative;
    }

    .navbar-nav .nav-link:hover {
        color: var(--sand) !important;
    }

    .navbar .navbar-nav .nav-link.active::after {
        width: 100%;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--sand);
        transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
        width: 100%;
    }

        .navbar .navbar-nav .nav-link.active {
        color: var(--sand) !important;
    }

    .btn-reserve,
    .btn-resort {
        background-color: var(--white);
        color: var(--resort-primary);
        border: none;
        transition: 0.3s;
        border-radius: 30px;
        padding: 10px 25px;
    }

    .btn-reserve:hover,
    .btn-resort:hover {
        background-color: var(--white);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Hero */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
            url('photo/bgmabanag.jpg') center/cover no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: linear-gradient(to top, #f9f9f9, transparent);
    }

    .hero-content h1 {
        font-size: 3.2rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1.5rem;
    }

    .hero-content p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-outline-light {
        border-radius: 30px;
        padding: 10px 25px;
        transition: 0.3s;
    }

    .btn-outline-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    /* Section Titles */
    .section-title {
        color: var(--resort-accent);
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 3px;
        background: linear-gradient(to right, var(--resort-primary), var(--leaf-green));
        bottom: -10px;
        left: 25%;
        border-radius: 3px;
    }

    /* Cards */
    .room-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: 0.3s;
        background-color: white;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .testimonial-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        background-color: white;
        transition: 0.3s;
        border-top: 4px solid var(--resort-primary);
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .gallery-item {
        overflow: hidden;
        border-radius: 12px;
        position: relative;
        transition: 0.3s;
    }

    .gallery-item img {
        transition: 0.5s;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.3));
        opacity: 0;
        transition: 0.3s;
    }

    .gallery-item:hover::after {
        opacity: 1;
    }

    /* Booking Section */
    .booking-section {
        background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent));
        color: white;
        padding: 60px 0;
    }

    .booking-section h2 {
        color: white;
    }

    .booking-section .btn-light {
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .booking-section .btn-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Footer */
    .footer {
        background-color: var(--deep-blue);
        color: white;
        padding: 60px 0 30px;
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(to right, var(--resort-primary), var(--leaf-green));
    }

    .footer h5 {
        color: var(--sand);
        margin-bottom: 1.5rem;
    }

    .footer a {
        color: #ddd;
        text-decoration: none;
        transition: 0.3s;
    }

    .footer a:hover {
        color: var(--sand);
    }

    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        margin-right: 10px;
        color: #fff;
        font-size: 1.2rem;
        transition: 0.3s;
    }

    .social-icons a:hover {
        background-color: var(--sand);
        color: var(--deep-blue);
        transform: translateY(-3px);
    }

    /* Modal */
    .resort-modal .modal-content {
        border-radius: 15px;
        overflow: hidden;
        border: none;
    }

    .resort-modal-header {
        background-color: var(--resort-primary);
        color: white;
        border-bottom: none;
    }

    .resort-modal-input {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ddd;
        transition: 0.3s;
    }

    .resort-modal-input:focus {
        border-color: var(--resort-primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 90, 39, 0.25);
    }

    .resort-modal-btn {
        background-color: var(--white);
        color: var(--resort-primary);
        border-radius: 30px;
        padding: 8px 20px;
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


    .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: left;
            padding: 0;
            margin: 0;
            /* To ensure stars look clickable */
            cursor: pointer;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2.5em; /* Large stars */
            color: #ccc;
            padding: 0 5px;
            transition: color 0.2s;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
        
        /* Form Specific Styles */
        .testimonial-form-card {
            background-color: #f8f9fa; /* Light background */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }

        .rating-star { color: gold; }
        

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .navbar-nav .nav-link {
            margin-left: 0;
            padding: 10px 0;
        }

        .section-title::after {
            width: 70%;
            left: 15%;
        }

        .booking-section .text-lg-end {
            text-align: left !important;
            margin-top: 20px;
        }
    }

    @media (max-width: 576px) {
        .hero-content h1 {
            font-size: 1.8rem;
        }

        .btn-reserve,
        .btn-resort,
        .btn-outline-light {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .hero-content .btn {
            margin-right: 0 !important;
        }
    }
    </style>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
                    <li class="nav-item">
                        <a class="btn btn-reserve ms-lg-3 mt-2 mt-lg-0" href="guest_reservation.php">Reserve Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content" data-aos="fade-up" data-aos-duration="1000">
            <span class="nature-badge">Nature's Paradise</span>
            <h1>Experience Nature's Paradise at Mabanag Spring Resort</h1>
            <p>Immerse yourself in the tranquility of nature with luxury accommodations, pristine waters, and
                unforgettable experiences.</p>
            <a href="guest_reservation.php" class="btn btn-resort me-2">Book Your Stay</a>
            <a id="checkReservationModal" class="btn btn-outline-light">Check Reservation</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 leaf-pattern">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="section-title">Our Natural Sanctuary</h2>
                    <p class="mb-4">Nestled amidst lush forests and fed by natural springs, Mabanag Spring Resort offers
                        a unique escape where nature's beauty meets modern comfort.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-tree text-success"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Lush Greenery</h5>
                                    <small>Surrounded by nature</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-water text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Natural Springs</h5>
                                    <small>Pristine water sources</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-utensils text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Organic Dining</h5>
                                    <small>Farm-to-table cuisine</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-spa text-info"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Wellness Focus</h5>
                                    <small>Rejuvenate your senses</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="position-relative">
                        <img src="https://lh3.googleusercontent.com/gps-cs-s/AC9h4noTE1Fg95FHX11ctnQDFEItHXhXJTwyX5B8Mgf1YN2zOdIwYTwb-eu0MdEf6XLMZOfEBG7Z2WApTLfM8hfzQHWhMgeUoYsVd2UwF0zZ96FgQf2AvGqCyW19JT0wJf-9NLy0Sl4=s680-w680-h510-rw"
                            class="img-fluid rounded shadow" alt="Resort Nature">
                        <div class="position-absolute bottom-0 start-0 bg-white p-3 m-3 rounded shadow-sm">
                            <h5 class="mb-0">Eco-Certified Resort</h5>
                            <small>Sustainable tourism practices</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 water-pattern">
        <div class="container">
            <h2 class="section-title text-center">Nature's Gallery</h2>
            <p class="text-center mb-5">Immerse yourself in the beauty of our natural surroundings and facilities.</p>

            <div class="row">
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="gallery-item">
                        <img src="https://pbs.twimg.com/media/FBsTuwEUcAUbxXN.jpg"
                            class="img-fluid rounded" alt="Resort Beach">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="gallery-item">
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEik6BBPBX3S6RTekoCa0ppMauqftJITnhI5PpfFsd48cpDC74vgkofp4XAPpqzM7rmi5FHf3JIhBIJvIreKdXeHTxKN1EfXpiCtpOQADvEEts-uEAESj9vQObWWuZ3IT2kZCpH_mYcmcOcT/s1600/jfldfh.jpg"
                            class="img-fluid rounded" alt="Resort Pool">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="gallery-item">
                        <img src="https://i.pinimg.com/736x/74/c0/65/74c0651764e50c6f7badaecde1f34433.jpg"
                            class="img-fluid rounded" alt="Resort Restaurant">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="gallery-item">
                        <img src="https://cdns.app/wgsdkw2F/assets/image/properties/5a0787e1a6b20b39c55cbf47b6f7959c_1653700483.jpg"
                            class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="gallery-item">
                        <img src="photo/g1.jpg"
                            class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="gallery-item">
                        <img src="photo/g2.jpg"
                            class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="gallery-item">
                        <img src="photo/g3.jpg"
                            class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="gallery-item">
                        <img src="photo/bgmabanag.jpg"
                            class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-resort">View More Photos</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8" 
             data-aos="fade-up" 
             data-aos-duration="1000">

            <div class="testimonial-form-card">
                <h2 class="text-center mb-4">Share Your Mabanag Spring Resort Experience</h2>
                <p class="text-center mb-5 text-muted">We'd love to hear what you thought of your stay!</p>

                <form action="submit_rating.php" method="POST">
                    
                    <div class="row">
                        <div class="col-md-6 form-group" data-aos="fade-right" data-aos-delay="100">
                            <label for="guest_name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                        </div>
                        <div class="col-md-6 form-group" data-aos="fade-left" data-aos-delay="200">
                            <label for="guest_location" class="form-label">Your Location (e.g., New York, USA)</label>
                            <input type="text" class="form-control" id="guest_location" name="guest_location">
                        </div>
                    </div>
                    
                    <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                        <label class="form-label d-block">Overall Rating (1-5 Stars)</label>
                        <div class="star-rating">
                            <input type="radio" id="5-star" name="rating" value="5" required><label for="5-star" title="5 Stars">★</label>
                            <input type="radio" id="4-star" name="rating" value="4"><label for="4-star" title="4 Stars">★</label>
                            <input type="radio" id="3-star" name="rating" value="3"><label for="3-star" title="3 Stars">★</label>
                            <input type="radio" id="2-star" name="rating" value="2"><label for="2-star" title="2 Stars">★</label>
                            <input type="radio" id="1-star" name="rating" value="1"><label for="1-star" title="1 Star">★</label>
                        </div>
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                        <label for="review_text" class="form-label">Your Experience/Testimonial</label>
                        <textarea class="form-control" id="review_text" name="review_text" rows="5" placeholder="Tell us about your stay..." required></textarea>
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                        <label for="badge_category" class="form-label">Best describes your experience (Optional Badge)</label>
                        <select class="form-select" id="badge_category" name="badge_category">
                            <option value="">Choose one...</option>
                            <option value="Nature Lover">Nature Lover</option>
                            <option value="Family Getaway">Family Getaway</option>
                            <option value="Relaxation Seeker">Relaxation Seeker</option>
                            <option value="Adventure Traveler">Adventure Traveler</option>
                            <option value="Food Enthusiast">Food Enthusiast</option>
                        </select>
                    </div>

                    <div class="text-center" data-aos="zoom-in" data-aos-delay="600">
                        <button type="submit" class="btn btn-success btn-lg mt-3">Submit Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    </section>

    <!-- Testimonials Section -->
<!-- Testimonials Section -->
    <section class="py-5 leaf-pattern">
        <div class="container">
            <h2 class="section-title text-center">Guest Experiences</h2>
            <p class="text-center mb-5">See what our guests have to say about their stay at Mabanag Spring Resort.</p>

            <div class="row">
                <?php 
                if ($result && $result->num_rows > 0) {
      
                    while($row = $result->fetch_assoc()) {
                 
                        $review_text_display = htmlspecialchars($row['review_text']);
                        $guest_name_display = htmlspecialchars($row['guest_name']);
                        $guest_location_display = htmlspecialchars($row['guest_location']);
                        $badge_class = htmlspecialchars(str_replace(' ', '-', $row['badge_category'])); // Convert spaces to hyphens for CSS class
                        $badge_text = htmlspecialchars($row['badge_category']);
                        $rating_value = (int)$row['rating'];

        
                        $stars_html = '';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating_value) {
                                $stars_html .= '<span class="rating-star">★</span>'; // Full star
                            } else {
                                $stars_html .= '<span class="rating-star" style="color:#e0e0e0;">★</span>'; // Empty/faded star
                            }
                        }
                        
                
                        ?>
                        <div class="col-md-4 mb-4" data-aos="fade-up">
                            <div class="testimonial-card p-4 h-100 d-flex flex-column">
                                <div class="nature-badge mb-3"><?php echo $badge_text; ?></div>
                                <div class="mb-3"><?php echo $stars_html; ?></div>
                                <p class="fst-italic flex-grow-1">"<?php echo $review_text_display; ?>"</p>
                                <div class="d-flex align-items-center mt-3">
                                    <div>
                                        <h6 class="mb-0"><?php echo $guest_name_display; ?></h6>
                                        <small><?php echo $guest_location_display; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Display a message if no testimonials are found
                    echo '<div class="col-12"><p class="text-center">No testimonials found yet. Be the first to leave one!</p></div>';
                }
                
                // 4. Free result set and close connection
                if (isset($result) && is_object($result)) {
                    $result->free();
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-5 booking-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Ready for Your Nature Escape?</h2>
                    <p class="mb-0">Book your stay today and experience the tranquility and luxury of Mabanag Spring
                        Resort.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-light btn-lg px-4">Check Availability</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</h5>
                    <p>A sanctuary to breathe deeply and soak in panoramic mountain views. Nestled among ancient trees
                        and the gentle sounds of natural springs, it's a peaceful escape into the heart of nature's
                        grandeur.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tripadvisor"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none">Home</a></li>
                        <li><a href="#about" class="text-decoration-none">About</a></li>
                        <li><a href="#rooms" class="text-decoration-none">Rooms</a></li>
                        <li><a href="#amenities" class="text-decoration-none">Amenities</a></li>
                        <li><a href="#contact" class="text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> <?php echo $info['address']?></li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> <?php echo $info['phone_number']?></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo $info['email_address']?></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Nature Newsletter</h5>
                    <p>Subscribe to our newsletter for special offers, eco-tips, and updates.</p>
                    <form>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email">
                            <button class="btn btn-resort" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 Mabanag Spring Resort. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Reservation Check Modal -->
    <div class="modal fade resort-modal" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header resort-modal-header">
                    <h5 class="modal-title" id="reservationModalLabel">Check Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="transacRefInput" class="form-label">Enter Transaction Reference</label>
                    <input type="text" class="form-control resort-modal-input" id="transacRefInput"
                        placeholder="Transaction Ref...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary resort-modal-btn"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-resort resort-modal-btn"
                        id="checkReservationBtn">Check</button>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init();
    </script>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   

    <script defer>
    document.addEventListener('DOMContentLoaded', function () {
        // Show modal when "Check Reservation" is clicked
        document.getElementById('checkReservationModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('reservationModal'));
            modal.show();
        });

        // Redirect on check
        document.getElementById('checkReservationBtn').addEventListener('click', function() {
            var transacRef = document.getElementById('transacRefInput').value.trim();
            if (transacRef) {
                window.location.href = 'transaction_details.php?transaction_ref=' + encodeURIComponent(transacRef);
            }
        });
    });
    </script>


    <script>
    // Sticky navbar on scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 20) {
            navbar.classList.add('sticky');
        } else {
            navbar.classList.remove('sticky');
        }
    });
    </script>
     <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>