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
    <title>Xendit Payment Transactions - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/transaction_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    ?>

    <!-- Admin Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort</h2>
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
                <li class="menu-item active">
                    <a href="payments.php">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment Transactions</span>
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
                <li class="menu-item">
                    <a href="owners_info.php">
                        <i class="fas fa-info-circle"></i>
                        <span>Owners Info</span>
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
                    <h3>Xendit Payment Transactions</h3>
                </div>
                <!-- <div class="nav-right">
                    <div class="user-menu">
                        <button class="nav-btn user-dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo $name; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div> -->
            </nav>

            <!-- Transaction Management Content -->
            <div class="content-area">
                <!-- Transactions Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Payment Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="transactionsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Guest</th>
                                        <th>External ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Customer Email</th>
                                        <th>Description</th>
                                        <th>Invoice URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = $conn->query("
                                        SELECT 
                                            r.transaction_reference,
                                            xi.external_id,
                                            xi.status,
                                            xi.amount,
                                            xi.customer_email,
                                            xi.description,
                                            xi.invoice_url,
                                            CONCAT(g.firstname, ' ', g.lastname) AS guest_name,
                                            g.contactno AS guest_contact
                                        FROM xendit_invoices xi
                                        LEFT JOIN reservation r ON r.reservation_id = xi.reservation_id
                                        LEFT JOIN guest g ON r.guest_id = g.guest_id
                                        ORDER BY xi.saved_on DESC
                                    ") or die(mysqli_error($conn));
                            
                                    while ($fetch = $query->fetch_array()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $fetch['transaction_reference']; ?></td>
                                        <td>
                                            <div class="guest-info">
                                                <div class="guest-name"><?php echo $fetch['guest_name']; ?></div>
                                                <div class="guest-contact">Contact: <?php echo $fetch['guest_contact'] ?? 'N/A'; ?></div>
                                            </div>
                                        </td>
                                        <td><?php echo $fetch['external_id']; ?></td>
                                        <td><?php echo $fetch['status']; ?></td>
                                        <td><?php echo number_format($fetch['amount'], 2); ?></td>
                                        <td><?php echo $fetch['customer_email']; ?></td>
                                        <td><?php echo $fetch['description']; ?></td>
                                        <td><a href="<?php echo $fetch['invoice_url']; ?>" target="_blank">View Invoice</a></td>
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

    <!-- View Transaction Modal -->
    <div class="modal fade" id="viewTransactionModal" tabindex="-1" aria-labelledby="viewTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTransactionModalLabel">Transaction Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-title">Reservation Information</h6>
                            <div class="detail-item">
                                <strong>Transaction ID:</strong>
                                <span id="view_transaction_id"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Reservation Date:</strong>
                                <span id="view_reservation_date"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Reservation Type:</strong>
                                <span id="view_reservation_type"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Room/Cottage:</strong>
                                <span id="view_room_cottage"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Reservation Status:</strong>
                                <span id="view_reservation_status"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="section-title">Guest Information</h6>
                            <div class="detail-item">
                                <strong>Guest Name:</strong>
                                <span id="view_guest_name"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Contact:</strong>
                                <span id="view_guest_contact"></span>
                            </div>
                            
                            <h6 class="section-title mt-4">Payment Information</h6>
                            <div class="detail-item">
                                <strong>Amount:</strong>
                                <span id="view_payment_amount" class="text-primary"></span>
                            </div>
                            <div class="detail-item">
                                <strong>Payment Status:</strong>
                                <span id="view_payment_status"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Transactions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="filterForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="filterDateFrom" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="filterDateFrom" name="date_from">
                        </div>
                        <div class="mb-3">
                            <label for="filterDateTo" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="filterDateTo" name="date_to">
                        </div>
                        <div class="mb-3">
                            <label for="filterReservationStatus" class="form-label">Reservation Status</label>
                            <select class="form-select" id="filterReservationStatus" name="reservation_status">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="filterPaymentStatus" class="form-label">Payment Status</label>
                            <select class="form-select" id="filterPaymentStatus" name="payment_status">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="verified">Verified</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-secondary" id="resetFilters">Reset</button>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="receipt-container">
                        <div class="receipt-info mb-3">
                            <h6>Payment Method: <span id="receipt-payment-method" class="text-primary"></span></h6>
                        </div>
                        <div class="receipt-image-container">
                            <img id="receipt-image" src="" alt="Payment Receipt" class="img-fluid receipt-image" style="display: none;">
                            <div id="receipt-pdf-container" style="display: none;">
                                <iframe id="receipt-pdf" src="" width="100%" height="500px" style="border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="download-receipt" href="" class="btn btn-primary" download>
                        <i class="fas fa-download me-2"></i>Download Receipt
                    </a>
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
    <script src="../js/transaction_script.js"></script>
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