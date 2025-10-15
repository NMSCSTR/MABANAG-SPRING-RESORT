<!DOCTYPE html>
<html lang="en">
<?php 
    require_once 'admin/connect.php';
    $sql = mysqli_query($conn, " SELECT * FROM `owners_info` WHERE `info_id` = 1");
    $info = mysqli_fetch_assoc($sql);
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mabanag Spring Resort</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --ocean-blue: #1a6fa3;
      --seafoam-green: #2a9d8f;
      --sand: #f4a261;
      --coral: #e76f51;
      --deep-blue: #264653;
      --light-blue: #8ecae6;
      --resort-primary: #009688;
      --resort-accent: #00796b;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }

    /* Navbar */
    .navbar {
      padding: 1rem;
      transition: all 0.4s ease;
    }

    .navbar.sticky {
      background-color: rgba(38, 70, 83, 0.9);
      backdrop-filter: blur(6px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
      font-weight: 600;
      color: var(--sand) !important;
    }

    .navbar-nav .nav-link {
      color: white !important;
      font-weight: 500;
      margin-left: 15px;
    }

    .btn-reserve {
      background-color: var(--resort-primary);
      color: #fff;
      transition: 0.3s;
    }

    .btn-reserve:hover {
      background-color: var(--resort-accent);
    }

    /* Hero */
    .hero {
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('photo/bgmabanag.jpg') center/cover no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }

    .hero p {
      font-size: 1.2rem;
      margin-top: 1rem;
    }

    /* About Section */
    #about {
      background-color: #ffffff;
      padding: 60px 0;
    }

    .section-title {
      font-size: 2.5rem;
      color: var(--resort-accent);
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .feature-icon {
      font-size: 1.5rem;
      color: var(--resort-primary);
      margin-right: 10px;
    }

    .about-video-wrapper {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .about-video {
      width: 100%;
      height: auto;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      .hero p {
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-water me-2"></i>Mabanag Spring Resort</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#rooms">Rooms</a></li>
          <li class="nav-item"><a class="nav-link" href="#amenities">Cottages</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item">
            <a class="btn btn-reserve ms-lg-3 mt-2 mt-lg-0" href="guest_reservation.php">Reserve Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1>Escape. Relax. Refresh.</h1>
      <p>Your dream spring getaway starts here.</p>
    </div>
  </section>

  <!-- About Section -->
  <section id="about">
    <div class="container">
      <div class="row align-items-center">
        <!-- Text Content -->
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="section-title">About Mabanag Spring Resort</h2>
          <p>
            Tucked away in nature’s lush embrace, Mabanag Spring Resort offers you the purest escape. Swim in crystal waters, hear birdsong, and let go of the city noise.
          </p>
          <ul class="list-unstyled mt-4">
            <li class="mb-2"><i class="fa-solid fa-water-ladder feature-icon"></i>Natural Spring Pools</li>
            <li class="mb-2"><i class="fa-solid fa-mountain-sun feature-icon"></i>Scenic Mountain Views</li>
            <li class="mb-2"><i class="fa-solid fa-utensils feature-icon"></i>Local Dining Delights</li>
            <li class="mb-2"><i class="fa-solid fa-seedling feature-icon"></i>Eco-Friendly Environment</li>
          </ul>
        </div>

        <!-- Video Content -->
        <div class="col-lg-6">
          <div class="about-video-wrapper">
            <video autoplay muted loop playsinline class="about-video">
              <source src="photo/bgvideo.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sticky navbar on scroll
    window.addEventListener('scroll', function () {
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
