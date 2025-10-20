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
    <title>Mabanag Spring Resort - Rooms</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
        padding-bottom: 60px; /* space for sticky footer */
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

    /* Enhanced Room cards */
    .card.room-card {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        background-color: white;
    }

    .card.room-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .card.room-card .card-img-top {
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .card.room-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card.room-card .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* Enhanced Icons in titles */
    .card-title i {
        color: var(--resort-primary);
        margin-right: 0.5rem;
        background: var(--resort-light);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* Enhanced Sticky footer */
    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to right, var(--resort-primary), var(--resort-accent));
        color: white;
        text-align: center;
        padding: 1rem 0;
        font-weight: 500;
        z-index: 1030;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
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

    /* Enhanced Fade-in Animation */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Enhanced Price Styling */
    .text-success {
        color: var(--spring-green) !important;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Enhanced Card Text */
    .card-text {
        color: #555;
        line-height: 1.6;
        flex-grow: 1;
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
        
        .card.room-card .card-img-top {
            height: 180px;
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

    /* Room counter badge */
    .room-counter {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--sunset);
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Hero Section for Rooms */
    .rooms-hero {
        background: linear-gradient(rgba(45, 90, 39, 0.7), rgba(74, 124, 89, 0.7)),
            url('photo/g1.jpg') center/cover no-repeat;
        height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 2rem;
        margin-top: 76px;
    }

    .rooms-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
    }

    .rooms-hero p {
        font-size: 1.2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Room Features */
    .room-features {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
    }

    .room-feature {
        background-color: var(--resort-light);
        color: var(--resort-primary);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Decorative Elements */
    .decorative-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
    }

    .decorative-wave svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 50px;
    }

    .decorative-wave .shape-fill {
        fill: var(--resort-light);
    }

    /* Filter Section */
    .filter-section {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-bottom: 2rem;
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
                    <li class="nav-item"><a class="nav-link active fw-semibold" href="rooms.php">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
                    <li class="nav-item"><a class="nav-link" href="notice.php">Important Notice</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
                    <li class="nav-item mt-2 mt-lg-0 ms-lg-3">
                        <a class="btn btn-resort" href="guest_reservation.php" role="button"
                            aria-label="Reserve Now">Reserve Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Rooms Hero Section -->
    <section class="rooms-hero">
        <div class="container" data-aos="fade-up">
            <span class="nature-badge">Nature-Inspired Accommodations</span>
            <h1>Our Rooms & Suites</h1>
            <p>Experience comfort surrounded by nature in our thoughtfully designed accommodations</p>
        </div>
    </section>

    <?php 
    require_once 'admin/connect.php';
    $sql = "SELECT * FROM room WHERE room_availability = 'available'";
    $result = $conn->query($sql);
    $roomCount = $result->num_rows;
    ?>

    <!-- Rooms Section -->
    <section id="rooms" class="py-5 leaf-pattern position-relative">
        <div class="container">
            <!-- Filter Section -->
            <div class="filter-section" data-aos="fade-up">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">Find Your Perfect Room</h4>
                        <p class="text-muted mb-0">Filter by preferences</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex justify-content-md-end gap-2 flex-wrap">
                            <button class="btn btn-outline-resort active">All Rooms</button>
                            <button class="btn btn-outline-resort">Standard</button>
                            <button class="btn btn-outline-resort">Deluxe</button>
                            <button class="btn btn-outline-resort">Suites</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <h2 class="section-title text-center mb-3"><i class="fas fa-bed me-2"></i>Resort Accommodations</h2>
                    <p class="text-center mb-4 fs-5 text-secondary">Choose from our selection of beautifully appointed rooms
                        and suites, designed with your comfort in mind and inspired by nature.</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="badge bg-resort-primary rounded-pill px-3 py-2 text-white fs-6" style="background-color: var(--resort-primary);">
                            <i class="fas fa-home me-1"></i><?php echo $roomCount; ?> Rooms Available
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php
                if ($result->num_rows > 0) {
                    $count = 0;
                    while($row = $result->fetch_assoc()) {
                        $count++;
                        ?>
                <div class="col-md-6 col-lg-4 fade-in" style="transition-delay: <?= $count * 0.15 ?>s;" data-aos="fade-up" data-aos-delay="<?= $count * 100 ?>">
                    <div class="card room-card h-100" tabindex="0" aria-label="<?php echo htmlspecialchars($row['room_type']); ?> room card">
                        <div class="position-relative">
                            <img src="photos/<?php echo htmlspecialchars($row['photo']); ?>" class="card-img-top"
                                alt="Photo of <?php echo htmlspecialchars($row['room_type']); ?>">
                            <div class="room-counter"><?php echo $count; ?></div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <i class="fas fa-door-open"></i><?php echo htmlspecialchars($row['room_type']); ?>
                            </h5>
                            
                            <!-- Room Features -->
                            <!-- <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends me-1"></i>2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed me-1"></i>1 Bed</span>
                                <span class="room-feature"><i class="fas fa-wifi me-1"></i>WiFi</span>
                            </div>
                             -->
                            <p class="card-text">
                                <i class="fas fa-info-circle me-1"></i>
                                <?php echo htmlspecialchars($row['room_description']); ?>
                            </p>
                            <div class="mt-auto">
                                <p class="text-success mb-3">
                                    <i class="fas fa-tag me-1"></i>₱<?php echo number_format($row['room_price'], 2); ?> / night
                                </p>
                                <a href="guest_reservation.php" class="btn btn-resort w-100" aria-label="Reserve <?php echo htmlspecialchars($row['room_type']); ?> room">
                                    <i class="fas fa-calendar-check me-2"></i>Reserve Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<div class='col-12 text-center' data-aos='fade-up'><p class='text-muted fs-5'><i class='fas fa-bed me-2'></i>No rooms available at the moment. Please check back later.</p></div>";
                }
                ?>
            </div>
        </div>
        
        <!-- Decorative wave -->
        <div class="decorative-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 water-pattern">
        <div class="container text-center" data-aos="fade-up">
            <h2 class="section-title">Need Help Choosing?</h2>
            <p class="mb-4">Our team is here to help you find the perfect accommodation for your stay.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="contactus.php" class="btn btn-resort btn-lg">
                    <i class="fas fa-phone-alt me-2"></i>Contact Us
                </a>
                <!-- <a href="guest_reservation.php" class="btn btn-outline-resort btn-lg">
                    <i class="fas fa-question-circle me-2"></i>FAQ
                </a> -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date('Y'); ?> Mabanag Spring Resort. All rights reserved.
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

            // Fade-in animation for cards on scroll
            const fadeElems = document.querySelectorAll(".fade-in");

            function checkFade() {
                const triggerBottom = window.innerHeight * 0.85;

                fadeElems.forEach(elem => {
                    const elemTop = elem.getBoundingClientRect().top;

                    if (elemTop < triggerBottom) {
                        elem.classList.add("visible");
                    }
                });
            }

            checkFade();
            window.addEventListener("scroll", checkFade);
            
            // Add subtle hover effect to cards
            const cards = document.querySelectorAll('.room-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });

            // Filter buttons
            const filterButtons = document.querySelectorAll('.btn-outline-resort');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>