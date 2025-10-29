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
    <link rel="stylesheet" href="css/aboutus.css">


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
                <li class="nav-item"><a class="nav-link active fw-semibold" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
                <li class="nav-item"><a class="nav-link" href="notice.php">Important Notice</a></li>
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
                    <img src="photo/g2.jpg" 
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


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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