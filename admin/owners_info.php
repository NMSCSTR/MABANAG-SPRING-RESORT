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
    <title>Owner Info Management - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/owner_style.css">
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
                <li class="menu-item">
                    <a href="reports.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
                <li class="menu-item active">
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
                    <h3>Owners Info Management</h3>
                </div>
            </nav>

            <!-- Room Management Content -->
            <div class="content-area">
                <!-- Rooms Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>Owner's Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="infoTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>GCash Number</th>
                                        <th>GCash Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Facebook</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = $conn->query("SELECT * FROM `owners_info` ORDER BY `info_id` DESC") or die(mysqli_error());
                                    while($fetch = $query->fetch_array()){
                                    ?>
                                    <tr>
                                        <!-- <td><?php echo $fetch['info_id']?></td> -->
                                        <td><?php echo $fetch['gcash_number']?></td>
                                        <td><?php echo $fetch['gcash_name']?></td>
                                        <td><?php echo $fetch['email_address']?></td>
                                        <td><?php echo $fetch['phone_number']?></td>
                                        <td><?php echo $fetch['address']?></td>
                                        <td><?php echo $fetch['facebook_account']?></td>
                                        <td>
                                            <button class="btn btn-sm bg-transparent border editBtn" data-id="<?php echo $fetch['info_id']; ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
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

<!-- Edit Info Modal -->
<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editInfoForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editInfoModalLabel">Edit Owner Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="info_id" name="info_id">

          <div class="mb-3">
            <label>GCash Number</label>
            <input type="text" class="form-control" id="gcash_number" name="gcash_number" required>
          </div>
          <div class="mb-3">
            <label>GCash Name</label>
            <input type="text" class="form-control" id="gcash_name" name="gcash_name" required>
          </div>
          <div class="mb-3">
            <label>Email Address</label>
            <input type="email" class="form-control" id="email_address" name="email_address" required>
          </div>
          <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
          </div>
          <div class="mb-3">
            <label>Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
          </div>
          <div class="mb-3">
            <label>Facebook Account</label>
            <input type="text" class="form-control" id="facebook_account" name="facebook_account">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/owner_script.js"></script>
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