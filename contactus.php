<!doctype html>
<html lang="en">

<?php 
    require_once 'admin/connect.php';
    $sql = mysqli_query($conn, " SELECT * FROM `owners_info` WHERE `info_id` = 1");
    $info = mysqli_fetch_assoc($sql);
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mabanag Spring Resort - Contact Us</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
        --resort-light: #e8f5e8;
        --resort-dark: #1e3d20;
        --white: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        overflow-x: hidden;
        color: #333;
    }

    /* Nature-inspired elements */
    .leaf-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232d5a27' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .water-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234d9de0' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Enhanced Buttons */
    .btn-resort {
        background-color: var(--white);
        color: var(--resort-primary);
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 6px rgba(45, 90, 39, 0.2);
        position: relative;
        overflow: hidden;
    }

    .btn-resort:hover {
        background-color: var(--resort-accent);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(45, 90, 39, 0.3);
    }

    .btn-resort:active {
        transform: translateY(0);
    }

    .btn-outline-resort {
        background-color: transparent;
        color: var(--resort-primary);
        border: 2px solid var(--resort-primary);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-outline-resort:hover,
    .btn-outline-resort.active {
        background-color: var(--resort-primary);
        color: white;
        transform: translateY(-2px);
    }

    /* Enhanced Navbar */
    .navbar {
        background-color: rgba(45, 90, 39, 0.95) !important;
        padding: 1rem 1.5rem;
        color: white;
        transition: all 0.4s ease;
        backdrop-filter: blur(0px);
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

    /* When scrolled - enhanced colored background */
    .navbar.scrolled {
        background-color: rgba(45, 90, 39, 0.98) !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
        padding: 0.75rem 1.5rem;
        backdrop-filter: blur(10px);
    }

    /* Enhanced Section Styling */
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: var(--resort-dark);
    }

    .section-title::after {
        content: '';
        position: absolute;
        width: 60%;
        height: 4px;
        background: linear-gradient(to right, var(--resort-primary), var(--leaf-green));
        bottom: -10px;
        left: 0;
        border-radius: 2px;
    }

    .section-title.text-center::after {
        left: 20%;
        width: 60%;
    }

    /* Enhanced Responsive adjustments */
    @media (max-width: 576px) {
        .btn-resort {
            width: 100%;
            text-align: center;
        }

        .navbar .navbar-brand {
            font-size: 1.25rem;
        }

        .section-title.text-center::after {
            left: 10%;
            width: 80%;
        }
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

    /* Hero Section for Contact */
    .contact-hero {
        background: linear-gradient(rgba(45, 90, 39, 0.7), rgba(74, 124, 89, 0.7)),
            url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 2rem;
        margin-top: 76px;
    }

    .contact-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
    }

    .contact-hero p {
        font-size: 1.2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Contact Cards */
    .contact-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        height: 100%;
        transition: all 0.3s ease;
        border-top: 4px solid var(--resort-primary);
        text-align: center;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .contact-icon {
        font-size: 2.5rem;
        color: var(--resort-primary);
        margin-bottom: 1.5rem;
        background: var(--resort-light);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Contact Form */
    .contact-form {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 2rem;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--resort-primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 90, 39, 0.25);
    }

    /* Social Icons */
    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 2rem;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background-color: var(--resort-light);
        border-radius: 50%;
        color: var(--resort-primary);
        font-size: 1.2rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-icon:hover {
        background-color: var(--resort-primary);
        color: white;
        transform: translateY(-3px);
    }

    /* Map Container */
    .map-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        height: 400px;
    }

    /* Operating Hours */
    .hours-list {
        list-style: none;
        padding: 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .hours-list li:last-child {
        border-bottom: none;
    }

    /* Footer */
    footer {
        background: linear-gradient(to right, var(--resort-primary), var(--resort-accent));
        color: white;
        text-align: center;
        padding: 1.5rem 0;
        font-weight: 500;
        margin-top: 4rem;
    }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-leaf me-2"></i>Mabanag Spring Resort
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contactus.php">Contact</a></li>
                    <li class="nav-item mt-2 mt-lg-0 ms-lg-3">
                        <a class="btn btn-resort" href="guest_reservation.php" role="button"
                            aria-label="Reserve Now">Reserve Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="container" data-aos="fade-up">
            <span class="nature-badge">We're Here to Help</span>
            <h1>Get In Touch</h1>
            <p>Have questions or ready to book your nature escape? We'd love to hear from you.</p>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section id="contact-info" class="py-5 leaf-pattern">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title text-center mb-3"><i class="fas fa-envelope me-2"></i>Contact Information
                    </h2>
                    <p class="text-center mb-4 fs-5 text-secondary">Reach out to us through any of these channels. We're
                        always happy to assist you with your inquiries and reservations.</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Address Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Us</h4>
                        <p class="text-muted">Come and experience nature's beauty at our resort</p>
                        <div class="mt-3">
                            <p class="fw-bold mb-0"><i class="fas fa-location-dot me-2 text-resort-primary"></i>Address
                            </p>
                            <p><?php echo htmlspecialchars($info['address'] ?? 'Mabanag, Juban, Sorsogon'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p class="text-muted">Speak directly with our friendly staff</p>
                        <div class="mt-3">
                            <p class="fw-bold mb-0"><i class="fas fa-phone me-2 text-resort-primary"></i>Phone Number
                            </p>
                            <p><?php echo htmlspecialchars($info['phone_number'] ?? '+63 912 345 6789'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p class="text-muted">Send us your inquiries and we'll respond promptly</p>
                        <div class="mt-3">
                            <p class="fw-bold mb-0"><i class="fas fa-envelope me-2 text-resort-primary"></i>Email
                                Address</p>
                            <p><?php echo htmlspecialchars($info['email_address'] ?? 'info@mabanagresort.com'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Facebook Card -->
            <div class="row justify-content-center mt-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <h4>Follow Us</h4>
                        <p class="text-muted">Stay updated with our latest news and promotions</p>
                        <div class="mt-3">
                            <p class="fw-bold mb-0"><i class="fab fa-facebook me-2 text-resort-primary"></i>Facebook
                                Page</p>
                            <p>facebook.com/MabanagSpringResort</p>
                            <a href="https://facebook.com/MabanagSpringResort" target="_blank"
                                class="btn btn-resort mt-2">
                                <i class="fab fa-facebook-f me-2"></i>Visit Our Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h4 class="mb-4">Connect With Us on Social Media</h4>
                    <div class="social-icons">
                        <a href="https://facebook.com/MabanagSpringResort" class="social-icon" target="_blank"
                            aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank" aria-label="TripAdvisor">
                            <i class="fab fa-tripadvisor"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="py-5 water-pattern">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="contact-form">
                        <h3 class="section-title mb-4"><i class="fas fa-paper-plane me-2"></i>Send Us a Message</h3>
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-resort w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Map & Operating Hours -->
                <div class="col-lg-6" data-aos="fade-left">
                    <!-- Map -->
                    <div class="mb-5">
                        <h3 class="section-title mb-4"><i class="fas fa-map me-2"></i>Find Us</h3>
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5502.725963889533!2d123.4715908302647!3d8.140097826251901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32545d31dfed875b%3A0x3a4ef9f0dfb8b2d0!2sMabanag%20Spring%20Resort!5e1!3m2!1sen!2sph!4v1760665502209!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div>
                        <h3 class="section-title mb-4"><i class="fas fa-clock me-2"></i>Operating Hours</h3>
                        <div class="contact-card">
                            <ul class="hours-list">
                                <li>
                                    <span>Monday - Thursday</span>
                                    <span class="fw-bold text-resort-primary">8:00 AM - 8:00 PM</span>
                                </li>
                                <li>
                                    <span>Friday</span>
                                    <span class="fw-bold text-resort-primary">8:00 AM - 9:00 PM</span>
                                </li>
                                <li>
                                    <span>Saturday</span>
                                    <span class="fw-bold text-resort-primary">7:00 AM - 9:00 PM</span>
                                </li>
                                <li>
                                    <span>Sunday</span>
                                    <span class="fw-bold text-resort-primary">7:00 AM - 8:00 PM</span>
                                </li>
                                <li>
                                    <span>Holidays</span>
                                    <span class="fw-bold text-resort-primary">7:00 AM - 9:00 PM</span>
                                </li>
                            </ul>
                            <div class="mt-3 p-3 rounded" style="background-color: var(--resort-light);">
                                <p class="mb-0 text-center"><i
                                        class="fas fa-info-circle me-2 text-resort-primary"></i>Reservation office opens
                                    30 minutes earlier</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 leaf-pattern">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="section-title text-center mb-5"><i class="fas fa-question-circle me-2"></i>Frequently
                        Asked Questions</h2>

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item" data-aos="fade-up">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1">
                                    What are your check-in and check-out times?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Check-in time is 2:00 PM and check-out time is 12:00 PM. Early check-in and late
                                    check-out may be available upon request and subject to availability.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    Do you allow pets in the resort?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We love animals, but to ensure the comfort and safety of all our guests, we only
                                    allow pets in specific designated areas. Please contact us in advance if you plan to
                                    bring your pet.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    Is there parking available?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we provide complimentary parking for all our guests. Our parking area is secure
                                    and monitored.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Mabanag Spring Resort. All rights reserved.</p>
        </div>
    </footer>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init();
    </script>

    <!-- Bootstrap JS -->
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

        // Contact form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Simple form validation
            const firstName = document.getElementById('firstName').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (firstName && email && message) {
                // Show success message (in a real application, you would send this to a server)
                alert('Thank you for your message! We will get back to you soon.');
                document.getElementById('contactForm').reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
    });
    </script>
</body>

</html>