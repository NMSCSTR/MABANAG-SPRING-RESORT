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
    <title>Reports & Analytics - Mabanag Spring Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/report_style.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-umbrella-beach me-2"></i>Mabanag Spring Resort</h2>
                <p>Admin Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item"><a href="dashboard.php"><i
                            class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="menu-item"><a href="room.php"><i class="fas fa-bed"></i><span>Room Management</span></a></li>
                <li class="menu-item"><a href="cottage.php"><i class="fas fa-home"></i><span>Cottage
                            Management</span></a></li>
                <li class="menu-item"><a href="account.php"><i class="fas fa-users"></i><span>Account
                            Management</span></a></li>
                <li class="menu-item"><a href="transaction.php"><i class="fas fa-exchange-alt"></i><span>Transaction
                            History</span></a></li>
                <li class="menu-item active"><a href="reports.php"><i class="fas fa-chart-bar"></i><span>Reports &
                            Analytics</span></a></li>
            </ul>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><i class="fas fa-user-circle"></i></div>
                    <div class="user-details">
                        <span class="user-name"><?php echo $name; ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <a href="logout.php" id="logoutBtn" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i>
                    Logout</a>
            </div>
        </div>

        

        <!-- Main Content -->
        <div class="main-content">
            <nav class="top-nav">
                <div class="nav-left">
                    <button class="sidebar-toggle"><i class="fas fa-bars"></i></button>
                    <h3>Reports & Analytics</h3>
                </div>
            </nav>

            <div class="content-area">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Revenue Reports</h5>
                        <div>
                            <select id="reportType" class="form-select">
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="reportsTable" class="table table-striped">
                            <thead class="table-white">
                                <tr>
                                    <th>#</th>
                                    <th>Reservation ID</th>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Reference</th>
                                    <th>Amount (₱)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Total Revenue:</th>
                                    <th id="totalRevenue" class="text-success"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
    $(document).ready(function() {
        loadReport('weekly');

        $('#reportType').on('change', function() {
            loadReport($(this).val());
        });

        function loadReport(type) {
            if ($.fn.DataTable.isDataTable('#reportsTable')) {
                $('#reportsTable').DataTable().destroy();
            }

            $('#reportsTable').DataTable({
                ajax: {
                    url: 'get_reports.php',
                    type: 'POST',
                    data: {
                        type: type
                    },
                    dataSrc: function(json) {
                        let total = 0;
                        console.log('=== DEBUG AMOUNTS ===');
                        json.data.forEach(row => {
                            const cleanAmount = String(row.amount).replace(/,/g, '');
                            const parsedAmount = parseFloat(cleanAmount) || 0;
                            
                            console.log('Original:', row.amount, 'Cleaned:', cleanAmount, 'Parsed:', parsedAmount);
                            
                            total += parsedAmount;
                        });
                        console.log('TOTAL:', total);
                        $('#totalRevenue').text('₱' + total.toLocaleString(undefined, {
                            minimumFractionDigits: 2
                        }));
                        return json.data;
                    }

                    //without code debugging
                    // dataSrc: function(json) {
                    //     let total = 0;
                    //     json.data.forEach(row => {
                    //         // Remove commas and convert to number
                    //         const cleanAmount = String(row.amount).replace(/,/g, '');
                    //         total += parseFloat(cleanAmount) || 0;
                    //     });
                    //     $('#totalRevenue').text('₱' + total.toLocaleString(undefined, {
                    //         minimumFractionDigits: 2
                    //     }));
                    //     return json.data;
                    // }
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'reservation_id'
                    },
                    {
                        data: 'payment_date'
                    },
                    {
                        data: 'payment_method'
                    },
                    {
                        data: 'payment_reference'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'payment_status'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy'
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Print'
                    }
                ]
            });
        }
    });
    </script>
</body>

</html>