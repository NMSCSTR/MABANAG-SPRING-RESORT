<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "mabanagspringresort") or die(mysqli_error());

// Check if room ID is provided in the URL
if(isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    
    // Fetch room details from database
    $query = $conn->prepare("SELECT * FROM room WHERE room_id = ?");
    $query->bind_param("i", $room_id);
    $query->execute();
    $result = $query->get_result();
    
    if($result->num_rows > 0) {
        $room = $result->fetch_assoc();
    } else {
        // Room not found, redirect to rooms page
        header("Location: room.php");
        exit();
    }
} else {
    // No room ID provided, redirect to rooms page
    header("Location: room.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($room['room_type']); ?> - Serenity Bay Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index_style.css">
    <style>
        .room-detail-hero {
            background: linear-gradient(rgba(26, 111, 163, 0.8), rgba(42, 157, 143, 0.8)), 
                        url('https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            color: white;
            margin-top: 76px;
        }
        
        .amenities-list {
            list-style: none;
            padding: 0;
        }
        
        .amenities-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .amenities-list li:before {
            content: "✓";
            color: #2a9d8f;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .booking-widget {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .room-gallery img {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        
        .room-gallery img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-umbrella-beach me-2"></i>Serenity Bay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#booking">Book Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Room Detail Hero Section -->
    <section class="room-detail-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold"><?php echo htmlspecialchars($room['room_type']); ?></h1>
                    <p class="lead">Room <?php echo htmlspecialchars($room['room_number']); ?></p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h2 class="price">₱<?php echo number_format($room['room_price'], 2); ?><small>/night</small></h2>
                    <span class="badge <?php echo $room['room_availability'] == 'Available' ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo htmlspecialchars($room['room_availability']); ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Details Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Room Images -->
                <div class="col-lg-8">
                    <div class="row room-gallery mb-4">
                        <div class="col-12 mb-4">
                            <img src="../photo/<?php echo htmlspecialchars($room['photo']); ?>" 
                                 alt="<?php echo htmlspecialchars($room['room_type']); ?>" 
                                 class="img-fluid w-100" 
                                 style="height: 400px; object-fit: cover;">
                        </div>
                        <!-- Additional images can be added here -->
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1582719471384-894fbb16e074?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                 class="img-fluid" alt="Room Interior">
                        </div>
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1582582494705-f8ce0b0c24f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                 class="img-fluid" alt="Bathroom">
                        </div>
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1586105251261-72a756497a11?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                 class="img-fluid" alt="Room View">
                        </div>
                    </div>

                    <!-- Room Description -->
                    <div class="room-description">
                        <h3 class="section-title">Room Description</h3>
                        <p>Experience luxury and comfort in our beautifully appointed <?php echo htmlspecialchars($room['room_type']); ?>. 
                           This spacious room offers stunning views, premium amenities, and everything you need for a perfect stay.</p>
                        
                        <h4 class="mt-4">Features & Amenities</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="amenities-list">
                                    <li>King Size Bed</li>
                                    <li>Air Conditioning</li>
                                    <li>Free Wi-Fi</li>
                                    <li>Flat Screen TV</li>
                                    <li>Mini Bar</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="amenities-list">
                                    <li>Private Balcony</li>
                                    <li>Ocean View</li>
                                    <li>Coffee Maker</li>
                                    <li>Safe Deposit Box</li>
                                    <li>24/7 Room Service</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Widget -->
                <div class="col-lg-4">
                    <div class="booking-widget sticky-top" style="top: 100px;">
                        <h4 class="text-center mb-4">Book This Room</h4>
                        
                        <?php if($room['room_availability'] == 'Available'): ?>
                            <form action="booking_process.php" method="POST">
                                <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                                <input type="hidden" name="room_price" value="<?php echo $room['room_price']; ?>">
                                
                                <div class="mb-3">
                                    <label for="check_in" class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control" id="check_in" name="check_in" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="check_out" class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control" id="check_out" name="check_out" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="guests" class="form-label">Number of Guests</label>
                                    <select class="form-select" id="guests" name="guests" required>
                                        <option value="1">1 Guest</option>
                                        <option value="2" selected>2 Guests</option>
                                        <option value="3">3 Guests</option>
                                        <option value="4">4 Guests</option>
                                    </select>
                                </div>
                                
                                <div class="price-summary mb-4">
                                    <h5>Price Summary</h5>
                                    <div class="d-flex justify-content-between">
                                        <span>₱<?php echo number_format($room['room_price'], 2); ?> x <span id="nights">0</span> nights</span>
                                        <span id="total_price">₱0.00</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total Amount:</span>
                                        <span id="final_total">₱0.00</span>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-resort w-100">Book Now</button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <h5>Currently Unavailable</h5>
                                <p>This room is not available for booking at the moment.</p>
                                <a href="index.html#rooms" class="btn btn-outline-primary">View Other Rooms</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Rooms Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">You Might Also Like</h2>
            <div class="row">
                <?php
                // Fetch similar rooms (same room type or similar price range)
                $similar_query = $conn->prepare("SELECT * FROM room WHERE room_id != ? AND room_availability = 'Available' LIMIT 3");
                $similar_query->bind_param("i", $room_id);
                $similar_query->execute();
                $similar_rooms = $similar_query->get_result();
                
                while($similar_room = $similar_rooms->fetch_assoc()):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card room-card h-100">
                        <img src="../photo/<?php echo htmlspecialchars($similar_room['photo']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($similar_room['room_type']); ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($similar_room['room_type']); ?></h5>
                            <p class="card-text">Room <?php echo htmlspecialchars($similar_room['room_number']); ?></p>
                            <p class="h5 text-primary">₱<?php echo number_format($similar_room['room_price'], 2); ?>/night</p>
                            <a href="view_room_details.php?room_id=<?php echo $similar_room['room_id']; ?>" class="btn btn-resort mt-2">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5><i class="fas fa-umbrella-beach me-2"></i>Serenity Bay Resort</h5>
                    <p>Luxury beachfront resort offering world-class amenities and unforgettable experiences.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Beachfront Road, Paradise Island</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@serenitybay.com</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-decoration-none">Home</a></li>
                        <li><a href="index.html#rooms" class="text-decoration-none">Rooms</a></li>
                        <li><a href="index.html#amenities" class="text-decoration-none">Amenities</a></li>
                        <li><a href="index.html#contact" class="text-decoration-none">Contact</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-5">
            <div class="text-center">
                <p>&copy; 2023 Serenity Bay Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        // Price calculation based on dates
        document.addEventListener('DOMContentLoaded', function() {
            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');
            const nightsSpan = document.getElementById('nights');
            const totalPrice = document.getElementById('total_price');
            const finalTotal = document.getElementById('final_total');
            const roomPrice = <?php echo $room['room_price']; ?>;
            
            function calculateTotal() {
                if(checkIn.value && checkOut.value) {
                    const checkInDate = new Date(checkIn.value);
                    const checkOutDate = new Date(checkOut.value);
                    const timeDiff = checkOutDate - checkInDate;
                    const nights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                    
                    if(nights > 0) {
                        nightsSpan.textContent = nights;
                        const total = roomPrice * nights;
                        totalPrice.textContent = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits: 2});
                        finalTotal.textContent = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits: 2});
                    }
                }
            }
            
            checkIn.addEventListener('change', calculateTotal);
            checkOut.addEventListener('change', calculateTotal);
            
            // Set minimum check-out date to day after check-in
            checkIn.addEventListener('change', function() {
                if(this.value) {
                    const nextDay = new Date(this.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    checkOut.min = nextDay.toISOString().split('T')[0];
                    
                    if(checkOut.value && new Date(checkOut.value) <= new Date(this.value)) {
                        checkOut.value = '';
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>