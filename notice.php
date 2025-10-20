<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Important Guest Notice | Mabanag Spring Resort</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --forest-green: #2d5a27;
      --spring-green: #4a7c59;
      --leaf-green: #8cb369;
      --water-blue: #4d9de0;
      --sand: #e6ccb2;
      --resort-primary: #2d5a27;
      --resort-accent: #4a7c59;
      --resort-light: #e8f5e8;
      --resort-dark: #1e3d20;
      --white: #fff;
    }

    body {
      font-family: "Poppins", sans-serif;
      background-color: #f9f9f9;
      color: #333;
      overflow-x: hidden;
    }

    /* 🔹 Updated Navbar Design */
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

    .navbar .navbar-brand i {
      color: var(--sand);
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

    .btn-resort {
      background-color: var(--white);
      color: var(--forest-green);
      border-radius: 30px;
      padding: 0.5rem 1.2rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-resort:hover {
      background-color: var(--resort-primary);
      color: var(--white);
    }

    /* Hero Section */
    .notice-hero {
      background: linear-gradient(rgba(45, 90, 39, 0.8), rgba(45, 90, 39, 0.8)),
        url("photo/g1.jpg");
      background-size: cover;
      background-position: center;
      color: #fff;
      text-align: center;
      padding: 120px 20px 100px;
    }

    .notice-hero h1 {
      font-weight: 700;
      letter-spacing: 1px;
    }

    .notice-hero p {
      font-size: 16px;
      opacity: 0.9;
    }

    /* Notice Section */
    .notice-section {
      margin-top: -50px;
    }

    .notice-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 40px 30px;
      text-align: center;
      max-width: 800px;
      margin: auto;
      position: relative;
      overflow: hidden;
    }

    .notice-card::before {
      content: "";
      position: absolute;
      top: -100px;
      right: -100px;
      width: 250px;
      height: 250px;
      background: radial-gradient(circle, var(--resort-light), transparent 60%);
      opacity: 0.4;
    }

    .notice-card h4 {
      color: var(--resort-primary);
      font-weight: 700;
    }

    .notice-card span {
      display: inline-block;
      background: var(--resort-light);
      color: var(--resort-dark);
      border-radius: 10px;
      padding: 15px 25px;
      margin-top: 20px;
      font-size: 14px;
    }

    .notice-card i {
      margin-right: 5px;
    }

    /* FAQ Section */
    .faq-section {
      padding: 80px 0;
      background: var(--resort-light);
    }

    .section-title {
      color: var(--resort-primary);
      font-weight: 600;
    }

    .accordion-button {
      font-weight: 500;
    }

    .accordion-button:not(.collapsed) {
      background-color: var(--resort-light);
      color: var(--resort-primary);
    }

    footer {
      background-color: var(--resort-dark);
      color: var(--white);
      text-align: center;
      padding: 20px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <!-- 🌿 Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-leaf me-2"></i>Mabanag Spring Resort</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
          <li class="nav-item"><a class="nav-link" href="cottages.php">Cottages</a></li>
          <li class="nav-item"><a class="nav-link active fw-semibold" href="notice.php">Important Notice</a></li>
          <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <a class="btn btn-resort" href="guest_reservation.php">Reserve Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 🌿 Hero Section -->
<section class="notice-hero position-relative text-center text-white d-flex align-items-center justify-content-center">
  <div class="overlay"></div>
  <div class="content" data-aos="fade-up">
    <i class="fas fa-bell fa-3x mb-3 text-light"></i>
    <h1 class="fw-bold display-5">Important Guest Notice</h1>
    <p class="lead mt-2">Please take a moment to review our resort guidelines for a safe and relaxing experience.</p>
  </div>
</section>

<!-- 🌸 Notice Details Section -->
<section class="notice-details py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="notice-card shadow-lg text-center p-5 rounded-4 position-relative overflow-hidden" data-aos="fade-up">
          <div class="floating-icon">
            <i class="fas fa-leaf"></i>
          </div>

          <i class="fas fa-umbrella-beach fa-2x mb-3 text-success"></i>
          <h3 class="fw-bold text-resort-primary mb-3">Guest Reminder</h3>
          <p class="text-muted mb-4">
            <i class="fas fa-info-circle text-success me-1"></i>
            Please note that the <strong>entrance fee</strong> is <u>separate from room rates</u>. Kindly settle all entrance
            fees upon arrival.
          </p>

          <div class="fee-box text-start mx-auto bg-light p-4 rounded-3 shadow-sm" style="max-width: 500px;">
            <h5 class="fw-semibold text-resort-primary mb-3">
              <i class="fas fa-ticket-alt me-2 text-success"></i>Entrance Fee for Room Guests
            </h5>
            <ul class="list-unstyled mb-0 small">
              <li class="mb-1"><i class="fas fa-user text-primary me-2"></i>Adult – <strong>₱100.00</strong></li>
              <li class="mb-1"><i class="fas fa-child text-warning me-2"></i>Children (4–9 yrs) – <strong>₱40.00</strong></li>
              <li><i class="fas fa-baby text-info me-2"></i>3 yrs & below – <strong>FREE</strong></li>
            </ul>
          </div>

          <div class="mt-4">
            <i class="fas fa-wifi text-success me-2"></i>
            <em class="text-muted">WiFi available at the Lemonade Stand, Convenience Store, and Entrance area.</em>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 🌾 FAQ Section -->
<section class="faq-section py-5 leaf-pattern">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold text-resort-primary"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h2>
      <p class="text-muted">Answers to some of our most common guest inquiries</p>
    </div>

    <div class="accordion accordion-flush shadow-sm" id="faqAccordion" data-aos="fade-up">
      <div class="accordion-item mb-3 rounded-3 border-0 shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            What are your check-in and check-out times?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse show">
          <div class="accordion-body">
            Check-in is at <strong>2:00 PM</strong> and check-out is at <strong>12:00 PM</strong>. Early check-in or late check-out may be available upon request and subject to availability.
          </div>
        </div>
      </div>

      <div class="accordion-item mb-3 rounded-3 border-0 shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            Are pets allowed?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse">
          <div class="accordion-body">
            Pets are welcome in designated areas only. Kindly contact us prior to your visit for arrangements and guidelines.
          </div>
        </div>
      </div>

      <div class="accordion-item rounded-3 border-0 shadow-sm">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            Is parking available?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse">
          <div class="accordion-body">
            Yes! Complimentary and secure parking is available for all guests.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Footer -->
  <footer>
    <p class="mb-0">&copy; 2025 Mabanag Spring Resort | All Rights Reserved</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
