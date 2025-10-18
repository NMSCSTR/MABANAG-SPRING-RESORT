// room_script.js

document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const roomsTable = $('#roomsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[0, 'desc']],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search rooms...",
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

    // Custom search functionality
    $('#searchInput').on('keyup', function() {
        roomsTable.search(this.value).draw();
    });

    // Filter by room type
    $('#typeFilter').on('change', function() {
        const value = this.value;
        roomsTable.column(2).search(value).draw();
    });

    // Filter by availability
    $('#availabilityFilter').on('change', function() {
        const value = this.value;
        roomsTable.column(4).search(value).draw();
    });

    // Edit Room Modal Handler
    const editRoomModal = document.getElementById('editRoomModal');
    if (editRoomModal) {
        editRoomModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const roomId = button.getAttribute('data-id');
            const roomNumber = button.getAttribute('data-number');
            const roomType = button.getAttribute('data-type');
            const roomPrice = button.getAttribute('data-price');
            const roomAvailability = button.getAttribute('data-availability');
            const roomPhoto = button.getAttribute('data-photo');
            const roomDescription = button.getAttribute('data-description');

            document.getElementById('edit_room_id').value = roomId;
            document.getElementById('edit_room_number').value = roomNumber;
            document.getElementById('edit_room_type').value = roomType;
            document.getElementById('edit_room_price').value = roomPrice;
            document.getElementById('edit_room_availability').value = roomAvailability;
            document.getElementById('edit_room_description').value = roomDescription || '';
            document.getElementById('current_photo').textContent = roomPhoto || 'No photo';
        });
    }

    // Delete Room Modal Handler
    const deleteRoomModal = document.getElementById('deleteRoomModal');
    if (deleteRoomModal) {
        deleteRoomModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const roomId = button.getAttribute('data-id');
            const roomNumber = button.getAttribute('data-number');

            document.getElementById('delete_room_id').value = roomId;
            document.getElementById('delete_room_number').textContent = roomNumber;
        });
    }

    

    // Form validation for room price
    // const roomPriceInputs = document.querySelectorAll('input[name="room_price"]');
    // roomPriceInputs.forEach(input => {
    //     input.addEventListener('blur', function() {
    //         const value = parseFloat(this.value);
    //         if (value < 0) {
    //             this.value = 0;
    //         } else if (value > 10000) {
    //             this.value = 10000;
    //         }
    //     });
    // });

    // Photo upload preview (for future enhancement)
    const photoInputs = document.querySelectorAll('input[type="file"]');
    photoInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // MB
                if (fileSize > 2) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                }
            }
        });
    });

    // Auto-format room number to 3 digits
    const roomNumberInputs = document.querySelectorAll('input[name="room_number"]');
    roomNumberInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                this.value = this.value.padStart(3, '0');
            }
        });
    });

    // // Real-time statistics update (simulated)
    // setInterval(() => {
    //     // This would typically fetch data from the server
    //     // For demo purposes, we'll just rotate some numbers
    //     const stats = document.querySelectorAll('.stat-info h3');
    //     if (stats.length >= 4) {
    //         // Rotate the available rooms count slightly
    //         const availableStat = stats[1];
    //         const current = parseInt(availableStat.textContent);
    //         const variation = Math.floor(Math.random() * 3) - 1; // -1, 0, or +1
    //         const newValue = Math.max(0, current + variation);
    //         availableStat.textContent = newValue;
            
    //         // Update occupied rooms accordingly
    //         const totalStat = parseInt(stats[0].textContent);
    //         const maintenanceStat = parseInt(stats[3].textContent);
    //         const occupiedStat = stats[2];
    //         occupiedStat.textContent = totalStat - newValue - maintenanceStat;
    //     }
    // }, 10000); // Update every 10 seconds
});

// // Export functionality (for future enhancement)
// function exportRooms(format) {
//     // This would typically make an AJAX call to export data
//     alert(`Exporting rooms data in ${format} format...`);
//     // In a real implementation, this would download a file
// }