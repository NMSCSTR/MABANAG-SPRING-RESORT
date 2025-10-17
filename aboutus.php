<!doctype html>
<html lang="en">
<?php 
    require_once 'admin/connect.php';
    $sql = mysqli_query($conn, " SELECT * FROM `owners_info` WHERE `info_id` = 1");
    $info = mysqli_fetch_assoc($sql);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mabanag Spring Resort</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
        --white: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f9f8;
        margin: 0;
        padding: 0;
        color: #333;
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
        background-color: rgba(45, 90, 39, 0.95);
        padding: 1rem 0;
        transition: all 0.4s ease;
    }

    .navbar.sticky {
        background-color: rgba(45, 90, 39, 0.98);
        backdrop-filter: blur(6px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.6rem;
        color: var(--sand);
    }

    .navbar-nav .nav-link {
        color: #fff !important;
        margin-left: 15px;
        font-weight: 500;
        transition: 0.3s;
        position: relative;
    }

    

    .navbar-nav .nav-link:hover {
        color: var(--sand) !important;
    }
    
    .navbar .navbar-nav .nav-link.active {
        color: var(--sand) !important;
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
    
    .navbar .navbar-nav .nav-link.active::after {
        width: 100%;
    }

    .btn-resort {
        background-color: var(--white);
        color: var(--resort-primary);
        border-radius: 30px;
        padding: 0.5rem 1.5rem;
        transition: background-color 0.3s;
        border: none;
    }

    .btn-resort:hover {
        background-color: var(--white);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(38, 70, 83, 0.6), rgba(0, 0, 0, 0.5)),
            url('photo/bgmabanag.jpg') center/cover no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: linear-gradient(to top, #f5f9f8, transparent);
    }

    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1.5rem;
    }

    .hero-section p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-section .btn {
        margin: 0.3rem;
        border-radius: 30px;
        padding: 10px 25px;
        transition: 0.3s;
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

    /* About Section */
    #about {
        background-color: #ffffff;
        padding: 5rem 0;
        text-align: center;
    }

    .section-title {
        font-size: 2.5rem;
        color: var(--resort-accent);
        font-weight: 600;
        margin-bottom: 2rem;
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

    .features-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-box {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        max-width: 250px;
        transition: transform 0.3s;
        text-align: center;
        border-top: 4px solid var(--resort-primary);
    }

    .feature-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        font-size: 2.8rem;
        color: var(--resort-primary);
        margin-bottom: 1rem;
    }

    .feature-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
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

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.3rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .features-grid {
            flex-direction: column;
            align-items: center;
        }

        .navbar-nav .nav-link {
            margin-left: 0;
            padding: 10px 0;
        }

        .section-title::after {
            width: 70%;
            left: 15%;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 2rem;
        }

        .btn-resort, .btn-outline-light {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .hero-section .btn {
            margin-right: 0 !important;
        }
    }

    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
                <li class="nav-item">
                    <a class="btn btn-resort ms-lg-3 mt-2 mt-lg-0" href="guest_reservation.php">Reserve Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <span class="nature-badge">Nature's Sanctuary</span>
        <h1>Reconnect with Nature</h1>
        <p>Find peace, adventure, and beauty at Mabanag Spring Resort - where nature's embrace awaits.</p>
        <a href="guest_reservation.php" class="btn btn-resort">Book Now</a>
        <a href="#about" class="btn btn-outline-light">Explore More</a>
    </div>
</section>

<!-- About Section -->
<section id="about" class="leaf-pattern">
    <div class="container">
        <h2 class="section-title">Why Choose Our Natural Haven?</h2>
        <p class="text-center mb-5">Experience the perfect blend of natural beauty and modern comfort at our eco-friendly resort.</p>
        
        <div class="features-grid">
            <div class="feature-box" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-water feature-icon"></i>
                <div class="feature-title">Fresh Spring Pools</div>
                <p>Crystal-clear waters straight from nature's pristine mountain sources.</p>
            </div>
            <div class="feature-box" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-tree feature-icon"></i>
                <div class="feature-title">Nature Surroundings</div>
                <p>Immerse in lush greenery, ancient trees, and peaceful natural vibes.</p>
            </div>
            <div class="feature-box" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-mountain feature-icon"></i>
                <div class="feature-title">Scenic Views</div>
                <p>Panoramic landscapes, vibrant sunsets, and breathtaking mountain vistas.</p>
            </div>
            <div class="feature-box" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-utensils feature-icon"></i>
                <div class="feature-title">Local Cuisine</div>
                <p>Savor fresh, organic dishes prepared with locally sourced ingredients.</p>
            </div>
            <div class="feature-box" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-spa feature-icon"></i>
                <div class="feature-title">Relaxation Areas</div>
                <p>Unwind in eco-friendly cottages, hammocks, and shaded natural spots.</p>
            </div>
        </div>
    </div>
</section>

<!-- Eco-Friendly Section -->
<section class="py-5 water-pattern">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title">Our Commitment to Nature</h2>
                <p class="mb-4">At Mabanag Spring Resort, we're dedicated to preserving the natural beauty that surrounds us. Our eco-friendly practices ensure minimal environmental impact while providing you with an unforgettable experience.</p>
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-recycle text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Sustainable Practices</h5>
                        <small>Reducing our environmental footprint</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-leaf text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Natural Preservation</h5>
                        <small>Protecting local flora and fauna</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-hand-holding-heart text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Community Support</h5>
                        <small>Empowering local communities</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         class="img-fluid rounded shadow" alt="Eco Resort">
                    <div class="position-absolute bottom-0 start-0 bg-white p-3 m-3 rounded shadow-sm">
                        <h5 class="mb-0">Green Certified</h5>
                        <small>Eco-friendly resort since 2015</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, var(--resort-primary), var(--resort-accent)); color: white;">
    <div class="container text-center">
        <h2 class="mb-4">Ready to Experience Nature's Magic?</h2>
        <p class="mb-4">Book your stay today and immerse yourself in the tranquility of Mabanag Spring Resort.</p>
        <a href="guest_reservation.php" class="btn btn-light btn-lg px-5">Book Your Escape</a>
    </div>
</section>

<!-- Footer -->
<footer class="footer" style="background-color: var(--deep-blue); color: white; padding: 60px 0 30px; position: relative;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</h5>
                <p>A sanctuary where nature's beauty meets comfort. Experience the perfect blend of tranquility and adventure in our eco-friendly resort nestled in pristine natural surroundings.</p>
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
                <p>Subscribe for eco-tips, special offers, and resort updates.</p>
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

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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
</body>

</html>