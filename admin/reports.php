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
    <title>Reports & Analytics - Serenity Bay Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/report_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body data-alert-type="<?php echo isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : ''; ?>"
      data-alert-title="<?php echo isset($_SESSION['alert_title']) ? $_SESSION['alert_title'] : ''; ?>"
      data-alert-message="<?php echo isset($_SESSION['alert_message']) ? htmlspecialchars($_SESSION['alert_message']) : ''; ?>">
    
    <?php
    // Clear the session variables after setting data attributes
    if(isset($_SESSION['alert_type'])) {
        unset($_SESSION['alert_type']);
        unset($_SESSION['alert_message']);
        unset($_SESSION['alert_title']);
    }

    // Get initial data for the table (last 7 days - weekly)
    $weeklyStartDate = date('Y-m-d', strtotime('-7 days'));
    $today = date('Y-m-d');
    
    $query = $conn->query("
        SELECT r.reservation_id, r.reservation_date, r.status as reservation_status,
               p.amount, p.payment_status,
               g.firstname as guest_name,
               CASE 
                   WHEN r.room_id IS NOT NULL THEN 'Room'
                   WHEN r.cottage_id IS NOT NULL THEN 'Cottage'
                   ELSE 'Unknown'
               END as reservation_type
        FROM reservation r
        LEFT JOIN payment p ON r.reservation_id = p.reservation_id
        LEFT JOIN guest g ON r.guest_id = g.guest_id
        WHERE p.payment_status = 'verified'
        AND DATE(r.reservation_date) BETWEEN '$weeklyStartDate' AND '$today'
        ORDER BY r.reservation_date DESC
        LIMIT 100
    ") or die(mysqli_error());
    ?>

    <!-- Admin Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-umbrella-beach me-2"></i>Serenity Bay</h2>
                <p>Admin Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="home.php">
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
                    <a href="transaction.php">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transaction History</span>
                    </a>
                </li>
                <li class="menu-item active">
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
                <a href="logout.php" id="logoutBtn" class="btn btn-logout">
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
                    <h3>Reports & Analytics</h3>
                </div>
                <div class="nav-right">
                    <div class="user-menu">
                        <button class="nav-btn user-dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo $name; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Reports Content -->
            <div class="content-area">
                <!-- Page Header with Period Controls -->
                <div class="page-header">
                    <div class="header-info">
                        <h4>Business Analytics</h4>
                        <p>Comprehensive reports and insights for your resort</p>
                    </div>
                    <div class="period-controls">
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="period" id="weekly" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="weekly">Weekly</label>

                            <input type="radio" class="btn-check" name="period" id="monthly" autocomplete="off">
                            <label class="btn btn-outline-primary" for="monthly">Monthly</label>

                            <input type="radio" class="btn-check" name="period" id="yearly" autocomplete="off">
                            <label class="btn btn-outline-primary" for="yearly">Yearly</label>
                        </div>
                        <div class="period-info">
                            <span id="currentPeriod">This Week</span>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Cards -->
                <div class="row stats-row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                ₱
                            </div>
                            <div class="stat-info">
                                <h3 id="totalRevenue">$0.00</h3>
                                <p>Total Revenue</p>
                                <div class="stat-trend up" id="revenueTrend">
                                    <i class="fas fa-arrow-up"></i> <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="totalBookings">0</h3>
                                <p>Total Bookings</p>
                                <div class="stat-trend up" id="bookingsTrend">
                                    <i class="fas fa-arrow-up"></i> <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="occupancyRate">0%</h3>
                                <p>Occupancy Rate</p>
                                <div class="stat-trend up" id="occupancyTrend">
                                    <i class="fas fa-arrow-up"></i> <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="avgBookingValue">$0.00</h3>
                                <p>Avg. Booking Value</p>
                                <div class="stat-trend up" id="avgValueTrend">
                                    <i class="fas fa-arrow-up"></i> <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Reports Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>Detailed Transaction Report - <span id="tablePeriod">This Week</span></h5>
                        <div class="table-controls">
                            <button class="btn btn-outline-primary" id="exportReport">
                                <i class="fas fa-download me-2"></i>Export Report
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="reportsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Transaction ID</th>
                                        <th>Guest</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($query->num_rows > 0) {
                                        while($fetch = $query->fetch_array()){
                                    ?>
                                    <tr>
                                        <td><?php echo date('M j, Y', strtotime($fetch['reservation_date']))?></td>
                                        <td>#<?php echo $fetch['reservation_id']?></td>
                                        <td><?php echo $fetch['guest_name']?></td>
                                        <td>
                                            <span class="type-badge type-<?php echo strtolower($fetch['reservation_type'])?>">
                                                <?php echo $fetch['reservation_type']?>
                                            </span>
                                        </td>
                                        <td><strong class="text-primary">₱<?php echo number_format($fetch['amount'], 2)?></strong></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $fetch['reservation_status']?>">
                                                <?php echo ucfirst($fetch['reservation_status'])?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="payment-badge payment-<?php echo $fetch['payment_status']?>">
                                                <?php echo ucfirst($fetch['payment_status'])?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No transactions found for this period</p>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/reports_script.js"></script>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });
    </script>
</body>
</html>