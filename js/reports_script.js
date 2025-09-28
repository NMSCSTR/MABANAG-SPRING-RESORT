// reports_script.js

document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert for displaying messages
    const body = document.body;
    const alertType = body.getAttribute('data-alert-type');
    const alertTitle = body.getAttribute('data-alert-title');
    const alertMessage = body.getAttribute('data-alert-message');
    
    if (alertType && alertMessage) {
        Swal.fire({
            icon: alertType,
            title: alertTitle || alertType.charAt(0).toUpperCase() + alertType.slice(1),
            html: alertMessage,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        // Clear the data attributes
        body.removeAttribute('data-alert-type');
        body.removeAttribute('data-alert-title');
        body.removeAttribute('data-alert-message');
    }

    // Initialize DataTable
    const reportsTable = $('#reportsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[0, 'desc']],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search reports...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    // Chart instances
    let revenueChart, bookingPieChart, monthlyChart, typeComparisonChart;

    // Initialize charts
    function initializeCharts() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [
                    {
                        label: 'Revenue',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: 'rgba(42, 157, 143, 1)',
                        backgroundColor: 'rgba(42, 157, 143, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Bookings',
                        data: [45, 78, 56, 98, 85, 120, 110],
                        borderColor: 'rgba(231, 111, 81, 1)',
                        backgroundColor: 'rgba(231, 111, 81, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Booking Pie Chart
        const pieCtx = document.getElementById('bookingPieChart').getContext('2d');
        bookingPieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Rooms', 'Cottages', 'Packages'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        'rgba(26, 111, 163, 0.8)',
                        'rgba(233, 196, 106, 0.8)',
                        'rgba(42, 157, 143, 0.8)'
                    ],
                    borderColor: [
                        'rgba(26, 111, 163, 1)',
                        'rgba(233, 196, 106, 1)',
                        'rgba(42, 157, 143, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Monthly Performance Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    backgroundColor: 'rgba(42, 157, 143, 0.8)',
                    borderColor: 'rgba(42, 157, 143, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Type Comparison Chart
        const typeCtx = document.getElementById('typeComparisonChart').getContext('2d');
        typeComparisonChart = new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Rooms',
                        data: [8000, 12000, 9000, 15000, 13000, 18000],
                        backgroundColor: 'rgba(26, 111, 163, 0.8)'
                    },
                    {
                        label: 'Cottages',
                        data: [4000, 7000, 6000, 10000, 9000, 12000],
                        backgroundColor: 'rgba(233, 196, 106, 0.8)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false,
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Update metrics with sample data
    function updateMetrics() {
        // Sample data - in real application, this would come from AJAX
        const metrics = {
            totalRevenue: 156840,
            totalBookings: 342,
            occupancyRate: 78,
            avgBookingValue: 458,
            revenueTrend: 12.5,
            bookingsTrend: 8.3,
            occupancyTrend: 5.2,
            avgValueTrend: 3.7
        };

        // Update metric values
        document.getElementById('totalRevenue').textContent = '$' + metrics.totalRevenue.toLocaleString();
        document.getElementById('totalBookings').textContent = metrics.totalBookings.toLocaleString();
        document.getElementById('occupancyRate').textContent = metrics.occupancyRate + '%';
        document.getElementById('avgBookingValue').textContent = '$' + metrics.avgBookingValue.toLocaleString();

        // Update trends
        updateTrend('revenueTrend', metrics.revenueTrend);
        updateTrend('bookingsTrend', metrics.bookingsTrend);
        updateTrend('occupancyTrend', metrics.occupancyTrend);
        updateTrend('avgValueTrend', metrics.avgValueTrend);

        // Update summary data
        document.getElementById('topRoomType').textContent = 'Deluxe Suite';
        document.getElementById('topCottageType').textContent = 'Beachfront';
        document.getElementById('bestMonth').textContent = 'June';
        document.getElementById('peakHours').textContent = '2:00 - 4:00 PM';
        document.getElementById('avgStay').textContent = '3.2 nights';
        document.getElementById('repeatGuests').textContent = '42%';

        // Update progress bars
        const monthlyTarget = 15000;
        const currentRevenue = 12500; // Sample current revenue
        const monthlyProgress = (currentRevenue / monthlyTarget) * 100;
        document.getElementById('monthlyTargetProgress').style.width = Math.min(monthlyProgress, 100) + '%';

        const occupancyGoal = 85;
        const currentOccupancy = 78; // Sample current occupancy
        const occupancyProgress = (currentOccupancy / occupancyGoal) * 100;
        document.getElementById('occupancyGoalProgress').style.width = Math.min(occupancyProgress, 100) + '%';
    }

    function updateTrend(elementId, value) {
        const element = document.getElementById(elementId);
        const isPositive = value >= 0;
        
        element.className = `stat-trend ${isPositive ? 'up' : 'down'}`;
        element.innerHTML = `<i class="fas fa-arrow-${isPositive ? 'up' : 'down'}"></i> <span>${Math.abs(value)}%</span>`;
    }

    // Generate Report
    document.getElementById('generateReport').addEventListener('click', function() {
        const period = document.querySelector('input[name="period"]:checked').id;
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;

        Swal.fire({
            title: 'Generating Report...',
            text: `Creating ${period} report from ${dateFrom} to ${dateTo}`,
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        // Simulate API call
        setTimeout(() => {
            updateMetrics();
            
            Swal.fire({
                title: 'Report Generated!',
                text: 'Your analytics report has been updated with the latest data.',
                icon: 'success',
                confirmButtonText: 'Great!'
            });
        }, 2000);
    });

    // Export Report
    document.getElementById('exportReport').addEventListener('click', function() {
        Swal.fire({
            title: 'Export Report',
            text: 'Choose export format:',
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
            text: `Preparing ${format.toUpperCase()} report`,
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        // Simulate export process
        setTimeout(() => {
            Swal.fire({
                title: 'Export Complete!',
                text: `Report has been exported as ${format.toUpperCase()}`,
                icon: 'success',
                confirmButtonText: 'Download'
            });
        }, 2000);
    }

    // Date range validation
    document.getElementById('dateFrom').addEventListener('change', function() {
        const dateTo = document.getElementById('dateTo');
        if (this.value > dateTo.value) {
            dateTo.value = this.value;
        }
    });

    document.getElementById('dateTo').addEventListener('change', function() {
        const dateFrom = document.getElementById('dateFrom');
        if (this.value < dateFrom.value) {
            dateFrom.value = this.value;
        }
    });

    // Initialize everything
    initializeCharts();
    updateMetrics();

    // Auto-refresh data every 5 minutes
    setInterval(() => {
        updateMetrics();
        
        // Show subtle notification
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'info',
            title: 'Data refreshed automatically'
        });
    }, 300000); // 5 minutes
});