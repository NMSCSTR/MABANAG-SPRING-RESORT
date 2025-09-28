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
    <title>Cottage Management - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/cottage_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body data-alert-type="<?php echo isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : ''; ?>"
      data-alert-title="<?php echo isset($_SESSION['alert_title']) ? $_SESSION['alert_title'] : ''; ?>"
      data-alert-message="<?php echo isset($_SESSION['alert_message']) ? htmlspecialchars($_SESSION['alert_message']) : ''; ?>">

    <?php
        if (isset($_SESSION['alert_type'])) {
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
                <li class="menu-item active">
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
                <a href="logout.php" id=logoutBtn class="btn btn-logout">
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
                    <h3>Cottage Management</h3>
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

            <!-- Cottage Management Content -->
            <div class="content-area">
                <!-- Page Header with Add Button -->
                <div class="page-header">
                    <div class="header-info">
                        <h4>Manage Cottages</h4>
                        <p>Add, edit, and manage all cottages in the resort</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCottageModal">
                        <i class="fas fa-plus me-2"></i>Add New Cottage
                    </button>
                </div>

                <!-- Cottages Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Cottages</h5>
                        <div class="table-controls">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search cottages...">
                            </div>
                            <div class="filter-controls">
                                <select id="typeFilter" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="Beachfront">Beachfront</option>
                                    <option value="Garden View">Garden View</option>
                                    <option value="Family">Family</option>
                                    <option value="Luxury">Luxury</option>
                                    <option value="Standard">Standard</option>
                                </select>
                                <select id="availabilityFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Available">Available</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="Maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="cottagesTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cottage ID</th>
                                        <th>Cottage Type</th>
                                        <th>Price</th>
                                        <th>Availability</th>
                                        <th>Capacity</th>
                                        <th>Photo</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $conn->query("SELECT * FROM `cottage` ORDER BY `cottage_id` DESC") or die(mysqli_error());
                                        while ($fetch = $query->fetch_array()) {
                                            // Determine capacity based on cottage type
                                            $capacity = '';
                                            switch ($fetch['cottage_type']) {
                                                case 'Family':
                                                    $capacity = '6-8 People';
                                                    break;
                                                case 'Luxury':
                                                    $capacity = '4-6 People';
                                                    break;
                                                case 'Beachfront':
                                                    $capacity = '4-6 People';
                                                    break;
                                                case 'Garden View':
                                                    $capacity = '2-4 People';
                                                    break;
                                                default:
                                                    $capacity = '2-4 People';
                                            }
                                        ?>
                                    <tr>
                                        <td><?php echo $fetch['cottage_id'] ?></td>
                                        <td>
                                            <span class="cottage-type-badge cottage-type-<?php echo strtolower(str_replace(' ', '-', $fetch['cottage_type'])) ?>">
                                                <i class="fas fa-home me-1"></i><?php echo $fetch['cottage_type'] ?>
                                            </span>
                                        </td>
                                        <td>₱<?php echo $fetch['cottage_price'] ?></td>
                                        <td>
                                            <span class="availability-badge availability-<?php echo strtolower($fetch['cottage_availability']) ?>">
                                                <?php echo $fetch['cottage_availability'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="capacity-badge"><?php echo $capacity ?></span>
                                        </td>
                                        <td>
                                            <?php if (! empty($fetch['photo'])): ?>
                                                <img src="../photos/<?php echo $fetch['photo'] ?>" alt="Cottage Photo" class="cottage-thumbnail">
                                            <?php else: ?>
                                                <div class="no-photo">No Image</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $fetch['cottage_description'] ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editCottageModal"
                                                    data-id="<?php echo $fetch['cottage_id'] ?>"
                                                    data-type="<?php echo $fetch['cottage_type'] ?>"
                                                    data-price="<?php echo $fetch['cottage_price'] ?>"
                                                    data-availability="<?php echo $fetch['cottage_availability'] ?>"
                                                    data-description="<?php echo htmlspecialchars($fetch['cottage_description'], ENT_QUOTES); ?>"
                                                    data-photo="<?php echo $fetch['photo'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete"
                                                    data-id="<?php echo $fetch['cottage_id'] ?>"
                                                    data-type="<?php echo $fetch['cottage_type'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-view" data-bs-toggle="modal" data-bs-target="#viewCottageModal"
                                                    data-id="<?php echo $fetch['cottage_id'] ?>"
                                                    data-type="<?php echo $fetch['cottage_type'] ?>"
                                                    data-price="<?php echo $fetch['cottage_price'] ?>"
                                                    data-availability="<?php echo $fetch['cottage_availability'] ?>"
                                                    data-description="<?php echo htmlspecialchars($fetch['cottage_description'], ENT_QUOTES); ?>"
                                                    data-photo="<?php echo $fetch['photo'] ?>"
                                                    data-capacity="<?php echo $capacity ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
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

                <!-- Statistics Cards -->
                <div class="row stats-row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <?php
                                        $total_cottages = $conn->query("SELECT COUNT(*) as total FROM `cottage`")->fetch_array();
                                        echo $total_cottages['total'];
                                    ?>
                                </h3>
                                <p>Total Cottages</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <?php
                                        $available_cottages = $conn->query("SELECT COUNT(*) as available FROM `cottage` WHERE `cottage_availability` = 'Available'")->fetch_array();
                                        echo $available_cottages['available'];
                                    ?>
                                </h3>
                                <p>Available Cottages</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <?php
                                        $occupied_cottages = $conn->query("SELECT COUNT(*) as occupied FROM `cottage` WHERE `cottage_availability` = 'Occupied'")->fetch_array();
                                        echo $occupied_cottages['occupied'];
                                    ?>
                                </h3>
                                <p>Occupied Cottages</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <?php
                                        $maintenance_cottages = $conn->query("SELECT COUNT(*) as maintenance FROM `cottage` WHERE `cottage_availability` = 'Maintenance'")->fetch_array();
                                        echo $maintenance_cottages['maintenance'];
                                    ?>
                                </h3>
                                <p>Under Maintenance</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Cottage Modal -->
    <div class="modal fade" id="addCottageModal" tabindex="-1" aria-labelledby="addCottageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCottageModalLabel">Add New Cottage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="add_cottage.php" method="POST" enctype="multipart/form-data" id="addCottageForm">
                    <input type="hidden" name="add_cottage" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cottage_type" class="form-label">Cottage Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="cottage_type" name="cottage_type" required>
                                        <option value="">Select Cottage Type</option>
                                        <option value="Beachfront">Beachfront Cottage</option>
                                        <option value="Garden View">Garden View Cottage</option>
                                        <option value="Family">Family Cottage</option>
                                        <option value="Luxury">Luxury Cottage</option>
                                        <option value="Standard">Standard Cottage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cottage_price" class="form-label">Price(₱) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="cottage_price" name="cottage_price" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cottage_availability" class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select class="form-select" id="cottage_availability" name="cottage_availability" required>
                                        <option value="Available">Available</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="text" class="form-control" id="capacity" readonly>
                                    <div class="form-text">Capacity is automatically determined by cottage type</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cottage_photo" class="form-label">Cottage Photo</label>
                            <input type="file" class="form-control" id="cottage_photo" name="photo" accept="image/*">
                            <div class="form-text">Upload a photo of the cottage (JPEG, PNG, JPG, max 2MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="cottage_description" class="form-label">Cottage Description</label>
                            <textarea class="form-control" id="cottage_description" name="description" rows="3" placeholder="Brief description of the cottage amenities and features"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Cottage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Cottage Modal -->
    <div class="modal fade" id="editCottageModal" tabindex="-1" aria-labelledby="editCottageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCottageModalLabel">Edit Cottage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="edit_cottage.php" method="POST" enctype="multipart/form-data" id="editCottageForm">
                    <input type="hidden" name="edit_cottage" value="1">
                    <input type="hidden" id="edit_cottage_id" name="cottage_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_cottage_type" class="form-label">Cottage Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_cottage_type" name="cottage_type" required>
                                        <option value="Beachfront">Beachfront Cottage</option>
                                        <option value="Garden View">Garden View Cottage</option>
                                        <option value="Family">Family Cottage</option>
                                        <option value="Luxury">Luxury Cottage</option>
                                        <option value="Standard">Standard Cottage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_cottage_price" class="form-label">Price per Night (₱) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_cottage_price" name="cottage_price" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_cottage_availability" class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_cottage_availability" name="cottage_availability" required>
                                        <option value="Available">Available</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_capacity" class="form-label">Capacity</label>
                                    <input type="text" class="form-control" id="edit_capacity" readonly>
                                    <div class="form-text">Capacity is automatically determined by cottage type</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_cottage_photo" class="form-label">Cottage Photo</label>
                            <input type="file" class="form-control" id="edit_cottage_photo" name="photo" accept="image/*">
                            <div class="form-text">Current photo: <span id="current_cottage_photo"></span>. Leave empty to keep current photo.</div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_cottage_description" class="form-label">Cottage Description</label>
                            <textarea class="form-control" id="edit_cottage_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Cottage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Cottage Modal -->
    <div class="modal fade" id="viewCottageModal" tabindex="-1" aria-labelledby="viewCottageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCottageModalLabel">Cottage Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="cottage-image-preview mb-4">
                                <img id="view_cottage_photo" src="" alt="Cottage Photo" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cottage-details">
                                <h4 id="view_cottage_type" class="mb-3"></h4>
                                <div class="detail-item">
                                    <strong>Cottage ID:</strong>
                                    <span id="view_cottage_id"></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Price:</strong>
                                    <span id="view_cottage_price" class="text-primary"></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Availability:</strong>
                                    <span id="view_cottage_availability"></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Capacity:</strong>
                                    <span id="view_cottage_capacity"></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Description:</strong>
                                    <!-- <p id="view_cottage_description" class="mt-2">No description available.</p> -->
                                    <span id="view_cottage_description"></span>
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/cottage_script.js"></script>
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