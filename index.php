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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mabanag Spring Resort</title>

    <!-- Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index_style.css">
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
<!-- 
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-resort">View More Photos</a>
            </div> -->
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
                        <label for="badge_category" class="form-label">Best describes your experience</label>
                        <select class="form-select" id="badge_category" name="badge_category" required>
                            <option value="">Choose one...</option>
                            <option value="Nature Lover">Nature Lover</option>
                            <option value="Family Getaway">Family Getaway</option>
                            <option value="Relaxation Seeker">Relaxation Seeker</option>
                            <option value="Adventure Traveler">Adventure Traveler</option>
                            <option value="Food Enthusiast">Food Enthusiast</option>
                        </select>
                    </div>

                    <div class="text-center" data-aos="zoom-in" data-aos-delay="600">
                        <button type="submit" class="btn btn-resort shadow shadow-success btn-lg mt-3">Submit Testimonial</button>
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
        document.getElementById('checkReservationModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('reservationModal'));
            modal.show();
        });

        document.getElementById('checkReservationBtn').addEventListener('click', function() {
            var transacRef = document.getElementById('transacRefInput').value.trim();
            if (transacRef) {
                window.location.href = 'transaction_details.php?transaction_ref=' + encodeURIComponent(transacRef);
            }
        });
    });
    </script>


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
     <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>