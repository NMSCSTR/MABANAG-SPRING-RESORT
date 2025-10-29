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
    <link rel="stylesheet" href="css/rooms.css">
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