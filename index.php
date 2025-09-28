<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/index_style.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#amenities">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-resort ms-lg-3 mt-2 mt-lg-0" href="guest_reservation.php">Reserve Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-3 fw-bold mb-4">Experience Paradise at Mabanag Spring Resort</h1>
                <p class="lead mb-4">Luxury beachfront resort offering world-class amenities, breathtaking views, and unforgettable experiences.</p>
                <a href="guest_reservation.php" class="btn btn-resort me-2">Book Your Stay</a>
                <a id="checkReservationModal" class="btn btn-outline-light">Check Reservation</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">About Mabanag Spring Resort</h2>
                    <p>Leave the hustle behind and answer the call of adventure at Mabanag Spring Resort. Dive into our invigorating, crystal-clear springs, surrounded by the lush sounds of nature. This is where you’ll create stories worth telling, from splashing fun with the family to blissful relaxation under the sun. We provide the perfect setting for every moment, making your vacation or random gimiks as lively or as tranquil as you wish. Your ultimate spring getaway is waiting.</p>
                    <p>Book Your Adventure!</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Spring Vibes</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Stunning Views</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Multiple dining options</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Very clear and clean spring water</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Resort Pool" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <?php 
    require_once 'admin/connect.php';
    $sql = "SELECT * FROM room WHERE room_availability = 'available'";
    $result = $conn->query($sql);
    ?>

    <!-- Rooms Section -->
    <section id="rooms" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Resort Accommodations</h2>
        <p class="text-center mb-5">Choose from our selection of beautifully appointed rooms and suites, each designed with your comfort in mind.</p>
        
        <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    // Loop through rooms
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card room-card h-100">
                                <img src="photos/<?php echo htmlspecialchars($row['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['room_type']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['room_type']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($row['room_description']); ?></p>
                                    <p class="h5 text-primary">₱<?php echo htmlspecialchars($row['room_price']); ?>/night</p>
                                    <a href="guest_reservation.php" class="btn btn-resort mt-2">Reserve Now</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No rooms available at the moment.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section id="amenities" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Resort Amenities</h2>
            <p class="text-center mb-5">Enjoy our world-class facilities designed to enhance your stay and create unforgettable memories.</p>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <img src="https://images.unsplash.com/photo-1540497077202-7c8a3999166f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Spa">
                        <div class="card-body text-center">
                            <h5 class="card-title">Luxury Spa</h5>
                            <p class="card-text">Indulge in rejuvenating treatments at our award-winning spa with expert therapists.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <img src="https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Fine Dining">
                        <div class="card-body text-center">
                            <h5 class="card-title">Fine Dining</h5>
                            <p class="card-text">Savor exquisite cuisine at our multiple restaurants offering diverse culinary experiences.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <img src="https://images.unsplash.com/photo-1530549387789-4c1017266635?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Water Sports">
                        <div class="card-body text-center">
                            <h5 class="card-title">Water Sports</h5>
                            <p class="card-text">Experience thrilling water activities including snorkeling, kayaking, and paddleboarding.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Resort Gallery</h2>
            <p class="text-center mb-5">Take a visual journey through our beautiful resort and facilities.</p>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Resort Beach">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Resort Pool">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Resort Restaurant">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Resort Garden">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Guest Experiences</h2>
            <p class="text-center mb-5">See what our guests have to say about their stay at Mabanag Spring Resort.</p>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card p-4 h-100">
                        <p class="fst-italic">"Absolutely breathtaking! The service was impeccable and the views were stunning. We'll definitely be back!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Johnson" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small>New York, USA</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card p-4 h-100">
                        <p class="fst-italic">"The perfect honeymoon destination. The private villa was incredible and the staff went above and beyond."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Michael Chen" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="mb-0">Michael & Emma Chen</h6>
                                <small>London, UK</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card p-4 h-100">
                        <p class="fst-italic">"Our family had an amazing time. The kids loved the pools and activities. Truly a memorable vacation!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Lisa Rodriguez" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="mb-0">Lisa Rodriguez</h6>
                                <small>Toronto, Canada</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-5 booking-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Ready for Your Dream Vacation?</h2>
                    <p class="mb-0">Book your stay today and experience the luxury and tranquility of Mabanag Spring Resort.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-light btn-lg px-4">Check Availability</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Contact Us</h2>
            <p class="text-center mb-5">Get in touch with us for any inquiries or special requests.</p>
            
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-resort">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5><i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort</h5>
                    <p>Luxury beachfront resort offering world-class amenities and unforgettable experiences in a pristine tropical setting.</p>
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
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Beachfront Road, Paradise Island</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@mabanagspringresort.com</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Newsletter</h5>
                    <p>Subscribe to our newsletter for special offers and updates.</p>
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
<div class="modal fade resort-modal" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header resort-modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Check Reservation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="reservationIdInput" class="form-label">Enter Reservation ID</label>
        <input type="number" class="form-control resort-modal-input" id="reservationIdInput" placeholder="Reservation ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary resort-modal-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-resort resort-modal-btn" id="checkReservationBtn">Check</button>
      </div>
    </div>
  </div>
</div>

<script>
// Show modal when "Check Reservation" is clicked
document.getElementById('checkReservationModal').addEventListener('click', function() {
    var modal = new bootstrap.Modal(document.getElementById('reservationModal'));
    modal.show();
});

// Redirect on check
document.getElementById('checkReservationBtn').addEventListener('click', function() {
    var reservationId = document.getElementById('reservationIdInput').value.trim();
    if (reservationId) {
        window.location.href = 'transaction_details.php?reservation_id=' + encodeURIComponent(reservationId);
    }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>