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
  <link rel="stylesheet" href="css/notice.css">
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
            Check-in is at <strong>2:00 PM</strong> and check-out is at <strong>1:00 AM</strong>. Early check-in or late check-out may be available upon request and subject to availability.
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
