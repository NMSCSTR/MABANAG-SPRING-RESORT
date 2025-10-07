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
    window.revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: revenueData.weekly.labels,
            datasets: [{
                label: 'Revenue (₱)',
                data: revenueData.weekly.data,
                backgroundColor: 'rgba(42, 157, 143, 0.2)',
                borderColor: 'rgba(42, 157, 143, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { drawBorder: false } },
                x: { grid: { display: false } }
            }
        }
    });
}

// Update chart based on selected timeframe
function updateChart(timeframe) {
    if (!window.revenueChart) return;
    let newLabels = [], newData = [];
    switch(timeframe) {
        case 'Weekly':
            newLabels = revenueData.weekly.labels;
            newData = revenueData.weekly.data;
            break;
        case 'Monthly':
            newLabels = revenueData.monthly.labels;
            newData = revenueData.monthly.data;
            break;
        case 'Yearly':
            newLabels = revenueData.yearly.labels;
            newData = revenueData.yearly.data;
            break;
    }
    window.revenueChart.data.labels = newLabels;
    window.revenueChart.data.datasets[0].data = newData;
    window.revenueChart.update();
}

// // Simulate real-time updates (for demo purposes)
// setInterval(() => {
//     // Update stats with random variations
//     const stats = document.querySelectorAll('.stat-info h3');
//     if (stats.length > 0) {
//         // Randomly update the active guests count
//         const guestsElement = stats[2];
//         const currentGuests = parseInt(guestsElement.textContent);
//         const variation = Math.floor(Math.random() * 5) - 2; // -2 to +2
//         const newGuests = Math.max(100, currentGuests + variation);
//         guestsElement.textContent = newGuests;
        
//         // Update the badge
//         const badge = guestsElement.parentElement.nextElementSibling;
//         badge.textContent = variation > 0 ? `+${variation}` : variation;
//         badge.className = `stat-badge ${variation >= 0 ? 'success' : 'warning'}`;
//     }
// }, 10000); // Update every 10 seconds