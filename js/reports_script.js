// reports_script.js
$(document).ready(function() {
    const exportButtons = [
        { extend: 'copy', text: '<i class="fas fa-copy me-1"></i>Copy', className: 'btn btn-outline-secondary btn-sm' },
        { extend: 'csv', text: '<i class="fas fa-file-csv me-1"></i>CSV', className: 'btn btn-outline-secondary btn-sm' },
        { extend: 'excel', text: '<i class="fas fa-file-excel me-1"></i>Excel', className: 'btn btn-outline-success btn-sm' },
        { extend: 'pdf', text: '<i class="fas fa-file-pdf me-1"></i>PDF', className: 'btn btn-outline-danger btn-sm' },
        { extend: 'print', text: '<i class="fas fa-print me-1"></i>Print', className: 'btn btn-outline-primary btn-sm' }
    ];

    let reportsTable;
    let currentPeriod = 'weekly';

    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#reportsTable')) {
            reportsTable.destroy();
        }

        reportsTable = $('#reportsTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
            buttons: exportButtons,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[0, 'desc']],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search reports...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No transactions found for this period",
                infoFiltered: "(filtered from _MAX_ total entries)",
                emptyTable: "No transactions found for this period",
                zeroRecords: "No matching transactions found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    }

    // 🟢 Export button (SweetAlert) → triggers corresponding DataTables export
    document.getElementById('exportReport').addEventListener('click', function() {
        Swal.fire({
            title: 'Export Report',
            text: `Export ${currentPeriod} report as:`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Excel',
            cancelButtonText: 'PDF',
            showDenyButton: true,
            denyButtonText: 'CSV'
        }).then((result) => {
            if (result.isConfirmed) {
                reportsTable.button('.buttons-excel').trigger();
            } else if (result.isDenied) {
                reportsTable.button('.buttons-csv').trigger();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                reportsTable.button('.buttons-pdf').trigger();
            }
        });
    });

    // Update metrics and table based on selected period
    function updatePeriod(period) {
        currentPeriod = period;
        
        // Update UI text
        updatePeriodText(period);
        
        // Show loading state
        showLoadingState();
        
        // Fetch data for the selected period
        fetchPeriodData(period);
    }

    function updatePeriodText(period) {
        const periodText = {
            'weekly': 'This Week',
            'monthly': 'This Month', 
            'yearly': 'This Year'
        };
        
        document.getElementById('currentPeriod').textContent = periodText[period];
        document.getElementById('tablePeriod').textContent = periodText[period];
    }

    function fetchPeriodData(period) {
        fetch('get_period_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `period=${period}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            updateMetricsUI(data);
            updateTableData(data.transactions);
        })
        .catch(error => {
            console.error('Error fetching period data:', error);
            // Fallback to sample data
            updateWithSampleData(period);
        });
    }

    function updateWithSampleData(period) {
        console.log('Using sample data for period:', period);
        
        // Sample data based on period
        const sampleData = {
            weekly: {
                totalRevenue: 12540,
                totalBookings: 28,
                occupancyRate: 65,
                avgBookingValue: 448,
                revenueTrend: 12.5,
                bookingsTrend: 8.3,
                occupancyTrend: 5.2,
                avgValueTrend: 3.7,
                transactions: generateSampleTransactions(25)
            },
            monthly: {
                totalRevenue: 45890,
                totalBookings: 102,
                occupancyRate: 72,
                avgBookingValue: 450,
                revenueTrend: 15.2,
                bookingsTrend: 12.8,
                occupancyTrend: 8.1,
                avgValueTrend: 2.1,
                transactions: generateSampleTransactions(80)
            },
            yearly: {
                totalRevenue: 542150,
                totalBookings: 1208,
                occupancyRate: 68,
                avgBookingValue: 449,
                revenueTrend: 18.7,
                bookingsTrend: 14.3,
                occupancyTrend: 6.9,
                avgValueTrend: 3.8,
                transactions: generateSampleTransactions(200)
            }
        };

        const data = sampleData[period] || sampleData.weekly;
        updateMetricsUI(data);
        updateTableData(data.transactions);
    }

    function generateSampleTransactions(count) {
        const transactions = [];
        const types = ['Room', 'Cottage'];
        const statuses = ['confirmed', 'pending', 'cancelled'];
        const paymentStatuses = ['verified', 'pending', 'rejected'];
        const guestNames = ['John Smith', 'Sarah Johnson', 'Michael Brown', 'Emily Davis', 'Robert Wilson', 'Lisa Anderson', 'David Miller', 'Jennifer Taylor'];
        
        const today = new Date();
        
        for (let i = 0; i < count; i++) {
            const daysAgo = Math.floor(Math.random() * 365);
            const date = new Date(today);
            date.setDate(today.getDate() - daysAgo);
            
            transactions.push({
                date: date.toISOString().split('T')[0],
                id: 1000 + i,
                guest: guestNames[Math.floor(Math.random() * guestNames.length)],
                type: types[Math.floor(Math.random() * types.length)],
                amount: (Math.random() * 500 + 100).toFixed(2),
                status: statuses[Math.floor(Math.random() * statuses.length)],
                paymentStatus: paymentStatuses[Math.floor(Math.random() * paymentStatuses.length)]
            });
        }
        
        return transactions.sort((a, b) => new Date(b.date) - new Date(a.date));
    }

    function updateMetricsUI(data) {
        console.log('Updating metrics with data:', data);
        
        // Update metric values
        document.getElementById('totalRevenue').textContent = '₱' + data.totalRevenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('totalBookings').textContent = data.totalBookings.toLocaleString();
        document.getElementById('occupancyRate').textContent = data.occupancyRate + '%';
        document.getElementById('avgBookingValue').textContent = '₱' + data.avgBookingValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Update trends
        updateTrend('revenueTrend', data.revenueTrend);
        updateTrend('bookingsTrend', data.bookingsTrend);
        updateTrend('occupancyTrend', data.occupancyTrend);
        updateTrend('avgValueTrend', data.avgValueTrend);
    }

    function updateTableData(transactions) {
        console.log('Updating table with transactions:', transactions);
        
        if (reportsTable) {
            reportsTable.destroy();
        }

        const tbody = document.querySelector('#reportsTable tbody');
        
        if (transactions && transactions.length > 0) {
            tbody.innerHTML = '';

            transactions.forEach(transaction => {
                const row = document.createElement('tr');
                
                const date = new Date(transaction.date);
                const formattedDate = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric' 
                });

                row.innerHTML = `
                    <td>${formattedDate}</td>
                    <td>#${transaction.id}</td>
                    <td>${transaction.guest}</td>
                    <td>
                        <span class="type-badge type-${transaction.type.toLowerCase()}">
                            ${transaction.type}
                        </span>
                    </td>
                    <td><strong class="text-primary">₱${parseFloat(transaction.amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong></td>
                    <td>
                        <span class="status-badge status-${transaction.status}">
                            ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <span class="payment-badge payment-${transaction.paymentStatus}">
                            ${transaction.paymentStatus.charAt(0).toUpperCase() + transaction.paymentStatus.slice(1)}
                        </span>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        } else {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No transactions found for this period</p>
                    </td>
                </tr>
            `;
        }

        // Reinitialize DataTable
        initializeDataTable();
    }

    function updateTrend(elementId, value) {
        const element = document.getElementById(elementId);
        const isPositive = value >= 0;
        
        element.className = `stat-trend ${isPositive ? 'up' : 'down'}`;
        element.innerHTML = `<i class="fas fa-arrow-${isPositive ? 'up' : 'down'}"></i> <span>${Math.abs(value)}%</span>`;
    }

    function showLoadingState() {
        // Add loading animation to metrics
        const metrics = ['totalRevenue', 'totalBookings', 'occupancyRate', 'avgBookingValue'];
        metrics.forEach(metric => {
            const element = document.getElementById(metric);
            element.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
        });

        // Show loading in table
        const tbody = document.querySelector('#reportsTable tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading data...</p>
                </td>
            </tr>
        `;
    }

    // Period change handlers
    document.querySelectorAll('input[name="period"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updatePeriod(this.id);
                
                // Show loading notification
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                    icon: 'info',
                    title: `Loading ${this.id} data...`
                });
            }
        });
    });

    // Export Report
    document.getElementById('exportReport').addEventListener('click', function() {
        Swal.fire({
            title: 'Export Report',
            text: `Export ${currentPeriod} report as:`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Excel',
            cancelButtonText: 'PDF',
            showDenyButton: true,
            denyButtonText: 'CSV'
        }).then((result) => {
            if (result.isConfirmed) {
                exportReport('excel');
            } else if (result.isDenied) {
                exportReport('csv');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                exportReport('pdf');
            }
        });
    });

    function exportReport(format) {
        Swal.fire({
            title: 'Exporting...',
            text: `Preparing ${currentPeriod} report as ${format.toUpperCase()}`,
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        // Create form and submit for export
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'export_report.php';
        form.style.display = 'none';

        const formatInput = document.createElement('input');
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);

        const periodInput = document.createElement('input');
        periodInput.name = 'period';
        periodInput.value = currentPeriod;
        form.appendChild(periodInput);

        document.body.appendChild(form);
        form.submit();

        // Remove form after submission
        setTimeout(() => {
            document.body.removeChild(form);
        }, 1000);
    }

    // Initialize with weekly data on page load
    initializeDataTable();
    updatePeriod('weekly');

    // Auto-refresh data every 5 minutes
    setInterval(() => {
        updatePeriod(currentPeriod);
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
            icon: 'info',
            title: 'Data refreshed automatically'
        });
    }, 300000); // 5 minutes
});