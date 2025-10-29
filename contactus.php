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
    <link rel="stylesheet" href="css/contactus.css">
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
                    <li class="nav-item"><a class="nav-link" href="notice.php">Important Notice</a></li>
                    <li class="nav-item"><a class="nav-link active fw-semibold" href="contactus.php">Contact</a></li>
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