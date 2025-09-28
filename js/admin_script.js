// admin_script.js

// Toggle sidebar on mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Initialize Revenue Chart
    initializeRevenueChart();
    
    // Chart controls functionality
    const chartControls = document.querySelectorAll('.btn-control');
    chartControls.forEach(control => {
        control.addEventListener('click', function() {
            chartControls.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            updateChart(this.textContent.trim());
        });
    });
});

// Revenue Chart Initialization
function initializeRevenueChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Sample data for the chart
    const weeklyData = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Revenue ($)',
            data: [3200, 4500, 3800, 5200, 6100, 7800, 6900],
            backgroundColor: 'rgba(42, 157, 143, 0.2)',
            borderColor: 'rgba(42, 157, 143, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    };
    
    const monthlyData = {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
            label: 'Revenue ($)',
            data: [18500, 22400, 19800, 25600],
            backgroundColor: 'rgba(42, 157, 143, 0.2)',
            borderColor: 'rgba(42, 157, 143, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    };
    
    const yearlyData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue ($)',
            data: [85000, 92000, 105000, 98000, 112000, 125000, 134000, 128000, 118000, 132000, 145000, 158000],
            backgroundColor: 'rgba(42, 157, 143, 0.2)',
            borderColor: 'rgba(42, 157, 143, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    };
    
    const chartConfig = {
        type: 'line',
        data: weeklyData,
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
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };
    
    window.revenueChart = new Chart(ctx, chartConfig);
}

// Update chart based on selected timeframe
function updateChart(timeframe) {
    if (!window.revenueChart) return;
    
    // In a real application, you would fetch new data from the server
    // For this example, we'll just update with sample data
    let newData;
    
    switch(timeframe) {
        case 'Weekly':
            newData = [3200, 4500, 3800, 5200, 6100, 7800, 6900];
            window.revenueChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            break;
        case 'Monthly':
            newData = [18500, 22400, 19800, 25600];
            window.revenueChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            break;
        case 'Yearly':
            newData = [85000, 92000, 105000, 98000, 112000, 125000, 134000, 128000, 118000, 132000, 145000, 158000];
            window.revenueChart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            break;
    }
    
    window.revenueChart.data.datasets[0].data = newData;
    window.revenueChart.update();
}

// Simulate real-time updates (for demo purposes)
setInterval(() => {
    // Update stats with random variations
    const stats = document.querySelectorAll('.stat-info h3');
    if (stats.length > 0) {
        // Randomly update the active guests count
        const guestsElement = stats[2];
        const currentGuests = parseInt(guestsElement.textContent);
        const variation = Math.floor(Math.random() * 5) - 2; // -2 to +2
        const newGuests = Math.max(100, currentGuests + variation);
        guestsElement.textContent = newGuests;
        
        // Update the badge
        const badge = guestsElement.parentElement.nextElementSibling;
        badge.textContent = variation > 0 ? `+${variation}` : variation;
        badge.className = `stat-badge ${variation >= 0 ? 'success' : 'warning'}`;
    }
}, 10000); // Update every 10 seconds