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
    <title>Room Management - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/room_style.css">
    <script src="../js/swal-message.js"></script>
</head>
<body>
    <?php
        $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
        unset($_SESSION['success'], $_SESSION['error'], $_SESSION['errors']);
    ?>
    <script>
        <?php if(!empty($success)): ?>
            showSwal("success", <?php echo json_encode($success); ?>, 1500);
        <?php endif; ?>

        <?php if(!empty($error)): ?>
            showSwal("error", <?php echo json_encode($error); ?>, 2000);
        <?php endif; ?>

        <?php if(!empty($errors) && is_array($errors)):
            foreach($errors as $err): ?>
            showSwal("error", <?php echo json_encode($err); ?>, 2000);
        <?php endforeach; endif; ?>
    </script>
    </script>
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
                <li class="menu-item active">
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
                    <h3>Room Management</h3>
                </div>
                <!-- <div class="nav-right">
                    <div class="user-menu">
                        <button class="nav-btn user-dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span> <?php echo $name; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div> -->
            </nav>

            <!-- Room Management Content -->
            <div class="content-area">
                <!-- Page Header with Add Button -->
                <div class="page-header">
                    <div class="header-info">
                        <h4>Manage Rooms</h4>
                        <p>Add, edit, and manage all rooms in the resort</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="fas fa-plus me-2"></i>Add New Room
                    </button>
                </div>

                <!-- Rooms Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Rooms</h5>
                        <div class="table-controls">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search rooms...">
                            </div>
                            <div class="filter-controls">
                                <select id="typeFilter" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Suite">Suite</option>
                                    <option value="Villa">Villa</option>
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
                            <table id="roomsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th>Room ID</th> -->
                                        <th>Room Number</th>
                                        <th>Room Type</th>
                                        <th>Price</th>
                                        <th>Availability</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = $conn->query("SELECT * FROM `room` ORDER BY `room_id` DESC") or die(mysqli_error());
                                    while($fetch = $query->fetch_array()){
                                    ?>
                                    <tr>
                                        <!-- <td><?php echo $fetch['room_id']?></td> -->
                                        <td><?php echo $fetch['room_number']?></td>
                                        <td>
                                            <span class="room-type-badge room-type-<?php echo strtolower($fetch['room_type'])?>">
                                                <?php echo $fetch['room_type']?>
                                            </span>
                                        </td>
                                        <td>₱<?php echo $fetch['room_price']?>/night</td>
                                        <td>
                                            <span class="availability-badge availability-<?php echo strtolower($fetch['room_availability'])?>">
                                                <?php echo $fetch['room_availability']?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            $description = isset($fetch['room_description']) ? $fetch['room_description'] : '';
                                            if(!empty($description)): 
                                                echo strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
                                            else: 
                                                echo '<span class="text-muted">No description</span>';
                                            endif; 
                                            ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($fetch['photo'])): ?>
                                                <img src="../photos/<?php echo $fetch['photo']?>" alt="Room Photo" class="room-thumbnail zoomable-room-img" data-img="../photos/<?php echo $fetch['photo']?>" data-bs-toggle="modal" data-bs-target="#zoomImageModal">
                                            <?php else: ?>
                                                <div class="no-photo">No Image</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editRoomModal" 
                                                    data-id="<?php echo $fetch['room_id']?>"
                                                    data-number="<?php echo $fetch['room_number']?>"
                                                    data-type="<?php echo $fetch['room_type']?>"
                                                    data-price="<?php echo $fetch['room_price']?>"
                                                    data-availability="<?php echo $fetch['room_availability']?>"
                                                    data-photo="<?php echo $fetch['photo']?>"
                                                    data-description="<?php echo isset($fetch['room_description']) ? htmlspecialchars($fetch['room_description']) : ''?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#deleteRoomModal" 
                                                    data-id="<?php echo $fetch['room_id']?>"
                                                    data-number="<?php echo $fetch['room_number']?>">
                                                    <i class="fas fa-trash"></i>
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
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <?php
                                    $total_rooms = $conn->query("SELECT COUNT(*) as total FROM `room`")->fetch_array();
                                    echo $total_rooms['total'];
                                    ?>
                                </h3>
                                <p>Total Rooms</p>
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
                                    $available_rooms = $conn->query("SELECT COUNT(*) as available FROM `room` WHERE `room_availability` = 'Available'")->fetch_array();
                                    echo $available_rooms['available'];
                                    ?>
                                </h3>
                                <p>Available Rooms</p>
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
                                    $occupied_rooms = $conn->query("SELECT COUNT(*) as occupied FROM `room` WHERE `room_availability` = 'Occupied'")->fetch_array();
                                    echo $occupied_rooms['occupied'];
                                    ?>
                                </h3>
                                <p>Occupied Rooms</p>
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
                                    $maintenance_rooms = $conn->query("SELECT COUNT(*) as maintenance FROM `room` WHERE `room_availability` = 'Maintenance'")->fetch_array();
                                    echo $maintenance_rooms['maintenance'];
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

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="add_room.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Room Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="room_number" name="room_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_type" class="form-label">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="room_type" name="room_type" required>
                                        <option value="">Select Room Type</option>
                                        <option value="Deluxe">Deluxe Room</option>
                                        <option value="Suite">Suite</option>
                                        <option value="Villa">Villa</option>
                                        <option value="Standard">Standard Room</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_price" class="form-label">Price per Night (₱) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="room_price" name="room_price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_availability" class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select class="form-select" id="room_availability" name="room_availability" required>
                                        <option value="Available">Available</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="room_photo" class="form-label">Room Photo</label>
                            <input type="file" class="form-control" id="room_photo" name="photo" accept="image/*">
                            <div class="form-text">Upload a photo of the room (JPEG, PNG, JPG, max 2MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="room_description" class="form-label">Room Description</label>
                            <textarea class="form-control" id="room_description" name="description" rows="3" placeholder="Brief description of the room amenities and features"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_room" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="edit_room.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_room_id" name="room_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_room_number" class="form-label">Room Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_room_number" name="room_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_room_type" class="form-label">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_room_type" name="room_type" required>
                                        <option value="Deluxe">Deluxe Room</option>
                                        <option value="Suite">Suite</option>
                                        <option value="Villa">Villa</option>
                                        <option value="Standard">Standard Room</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_room_price" class="form-label">Price per Night (₱) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_room_price" name="room_price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_room_availability" class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_room_availability" name="room_availability" required>
                                        <option value="Available">Available</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_room_photo" class="form-label">Room Photo</label>
                            <input type="file" class="form-control" id="edit_room_photo" name="photo" accept="image/*">
                            <div class="form-text">Current photo: <span id="current_photo"></span></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_room_description" class="form-label">Room Description</label>
                            <textarea class="form-control" id="edit_room_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="edit_room">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Room Modal -->
    <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="delete_room.php" method="POST">
                    <input type="hidden" id="delete_room_id" name="room_id">
                    <div class="modal-body">
                        <p>Are you sure you want to delete room <strong id="delete_room_number"></strong>?</p>
                        <p class="text-danger">This action cannot be undone. All associated data will be permanently deleted.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div class="modal fade" id="zoomImageModal" tabindex="-1" aria-labelledby="zoomImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="zoomedRoomImage" src="" alt="Zoomed Room Photo" style="max-width:100%; max-height:80vh;">
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
    <script src="../js/room_script.js"></script>
    <script>
        $(document).ready(function() {
            $('.zoomable-room-img').on('click', function() {
                var imgSrc = $(this).data('img');
                $('#zoomedRoomImage').attr('src', imgSrc);
                $('#zoomImageModal').modal('show');
            });
        });
    </script>
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