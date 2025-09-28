<!DOCTYPE html>
<?php 
    require_once 'validate.php';
    require_once 'name.php';
    require_once 'connect.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Serenity Bay Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <!-- Admin Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort</h2>
                <p>Admin Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item active">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="room.php">
                        <i class="fas fa-bed"></i>
                        <span>Room Management</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="cottage.php">
                        <i class="fas fa-home"></i>
                        <span>Cottage Management</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="account.php">
                        <i class="fas fa-users"></i>
                        <span>Account Management</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="payment.php">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment Management</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="transaction.php">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transaction History</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="reports.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?php echo $name; ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <a href="logout.php" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="nav-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h3>Dashboard Overview</h3>
                </div>
                <div class="nav-right">
                    <div class="notifications">
                        <button class="nav-btn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>
                    <div class="user-menu">
                        <button class="nav-btn user-dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span> <?php echo $name; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <div class="content-area">
                <!-- Stats Cards -->
                <div class="row stats-row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php $total_rooms = $conn->query("SELECT COUNT(*) as total FROM `room`")->fetch_array();
                                    echo $total_rooms['total'];
                                    ?>
                                </h3>
                                <p>Total Rooms</p>
                            </div>
                            <div class="stat-badge success">+2</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-info">
                                <h3>      
                                    <?php $total_cottages = $conn->query("SELECT COUNT(*) as total FROM `cottage`")->fetch_array();
                                    echo $total_cottages['total'];
                                    ?>
                                </h3>
                                <p>Total Cottages</p>
                            </div>
                            <div class="stat-badge warning">-1</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3> <?php $total_guest = $conn->query("SELECT COUNT(*) as total FROM `guest`")->fetch_array();
                                    echo $total_guest['total'];
                                    ?></h3>
                                <p>Active Guests</p>
                            </div>
                            <div class="stat-badge success">+15</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3>₱12,540</h3>
                                <p>Revenue Today</p>
                            </div>
                            <div class="stat-badge success">+8%</div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Recent Activity -->
                <div class="row content-row">
                    <!-- Revenue Chart -->
                    <div class="col-xl-8 mb-4">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h5>Revenue Overview</h5>
                                <div class="chart-controls">
                                    <button class="btn-control active">Weekly</button>
                                    <button class="btn-control">Monthly</button>
                                    <button class="btn-control">Yearly</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="col-xl-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Bookings</h5>
                            </div>
                            <div class="card-body">
                                <div class="booking-list">
                                    <div class="booking-item">
                                        <div class="booking-info">
                                            <h6>Ocean View Suite</h6>
                                            <p>John Smith • Check-in: Today</p>
                                        </div>
                                        <span class="booking-status confirmed">Confirmed</span>
                                    </div>
                                    <div class="booking-item">
                                        <div class="booking-info">
                                            <h6>Beachfront Villa</h6>
                                            <p>Sarah Johnson • Check-in: Tomorrow</p>
                                        </div>
                                        <span class="booking-status pending">Pending</span>
                                    </div>
                                    <div class="booking-item">
                                        <div class="booking-info">
                                            <h6>Deluxe Room</h6>
                                            <p>Michael Brown • Check-in: Dec 15</p>
                                        </div>
                                        <span class="booking-status confirmed">Confirmed</span>
                                    </div>
                                    <div class="booking-item">
                                        <div class="booking-info">
                                            <h6>Garden Cottage</h6>
                                            <p>Emily Davis • Check-in: Dec 18</p>
                                        </div>
                                        <span class="booking-status cancelled">Cancelled</span>
                                    </div>
                                </div>
                                <a href="transaction.php" class="btn btn-view-all">View All Bookings</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions and System Status -->
                <div class="row content-row">
                    <!-- Quick Actions -->
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="quick-actions">
                                    <a href="room.php" class="action-btn">
                                        <i class="fas fa-plus"></i>
                                        <span>Add New Room</span>
                                    </a>
                                    <a href="cottage.php" class="action-btn">
                                        <i class="fas fa-home"></i>
                                        <span>Manage Cottages</span>
                                    </a>
                                    <a href="payment.php" class="action-btn">
                                        <i class="fas fa-credit-card"></i>
                                        <span>Process Payment</span>
                                    </a>
                                    <a href="account.php" class="action-btn">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Create Account</span>
                                    </a>
                                    <a href="#" class="action-btn">
                                        <i class="fas fa-chart-line"></i>
                                        <span>Generate Report</span>
                                    </a>
                                    <a href="#" class="action-btn">
                                        <i class="fas fa-cog"></i>
                                        <span>System Settings</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/admin_script.js"></script>
</body>
</html>