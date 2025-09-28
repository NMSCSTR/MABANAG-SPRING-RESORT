// cottage_script.js

document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert for displaying messages (Solution 2)
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
    const cottagesTable = $('#cottagesTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[0, 'desc']],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search cottages...",
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
        cottagesTable.search(this.value).draw();
    });

    // Filter by cottage type
    $('#typeFilter').on('change', function() {
        const value = this.value;
        cottagesTable.column(1).search(value).draw();
    });

    // Filter by availability
    $('#availabilityFilter').on('change', function() {
        const value = this.value;
        cottagesTable.column(3).search(value).draw();
    });

    // Capacity mapping based on cottage type
    const capacityMap = {
        'Beachfront': '4-6 People',
        'Garden View': '2-4 People',
        'Family': '6-8 People',
        'Luxury': '4-6 People',
        'Standard': '2-4 People'
    };

    // Update capacity when cottage type changes
    function updateCapacity(selectId, outputId) {
        const select = document.getElementById(selectId);
        const output = document.getElementById(outputId);
        
        if (select && output) {
            select.addEventListener('change', function() {
                const capacity = capacityMap[this.value] || '2-4 People';
                output.value = capacity;
            });
            
            // Set initial value
            if (select.value) {
                output.value = capacityMap[select.value] || '2-4 People';
            }
        }
    }

    // Setup capacity updates
    updateCapacity('cottage_type', 'capacity');
    updateCapacity('edit_cottage_type', 'edit_capacity');

    // Edit Cottage Modal Handler
    const editCottageModal = document.getElementById('editCottageModal');
    if (editCottageModal) {
        editCottageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const cottageId = button.getAttribute('data-id');
            const cottageType = button.getAttribute('data-type');
            const cottagePrice = button.getAttribute('data-price');
            const cottageAvailability = button.getAttribute('data-availability');
            const cottagePhoto = button.getAttribute('data-photo');

            document.getElementById('edit_cottage_id').value = cottageId;
            document.getElementById('edit_cottage_type').value = cottageType;
            document.getElementById('edit_cottage_price').value = cottagePrice;
            document.getElementById('edit_cottage_availability').value = cottageAvailability;
            document.getElementById('current_cottage_photo').textContent = cottagePhoto || 'No photo';
            
            // Update capacity
            const capacity = capacityMap[cottageType] || '2-4 People';
            document.getElementById('edit_capacity').value = capacity;
        });
    }

    // View Cottage Modal Handler
    const viewCottageModal = document.getElementById('viewCottageModal');
    if (viewCottageModal) {
        viewCottageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const cottageId = button.getAttribute('data-id');
            const cottageType = button.getAttribute('data-type');
            const cottagePrice = button.getAttribute('data-price');
            const cottageAvailability = button.getAttribute('data-availability');
            const cottagePhoto = button.getAttribute('data-photo');
            const cottageCapacity = button.getAttribute('data-capacity');

            document.getElementById('view_cottage_id').textContent = cottageId;
            document.getElementById('view_cottage_type').textContent = cottageType + ' Cottage';
            document.getElementById('view_cottage_price').textContent = '$' + cottagePrice + '/night';
            document.getElementById('view_cottage_availability').textContent = cottageAvailability;
            document.getElementById('view_cottage_capacity').textContent = cottageCapacity;
            
            // Set photo
            const photoElement = document.getElementById('view_cottage_photo');
            if (cottagePhoto) {
                photoElement.src = '../photos/' + cottagePhoto;
                photoElement.alt = cottageType + ' Cottage';
            } else {
                photoElement.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjhGOUZBIi8+CjxwYXRoIGQ9Ik0yMDAgMTUwQzIyMi4wOTEgMTUwIDI0MCAxMzIuMDkxIDI0MCAxMTBDMjQwIDg3LjkwODYgMjIyLjA5MSA3MCAyMDAgNzBDMTc3LjkwOSA3MCAxNjAgODcuOTA4NiAxNjAgMTExQzE2MCAxMzIuMDkxIDE3Ny45MDkgMTUwIDIwMCAxNTBaIiBmaWxsPSIjQzhEOEVGIi8+CjxwYXRoIGQ9Ik0xMDAgMjAwSDMwMFYyNzBIMTAwVjIwMFoiIGZpbGw9IiNDOEQ4RUYiLz4KPC9zdmc+';
                photoElement.alt = 'No cottage photo available';
            }
        });
    }

    // Enhanced delete confirmation with SweetAlert
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cottageId = this.getAttribute('data-id');
            const cottageType = this.getAttribute('data-type');
            
            Swal.fire({
                title: 'Are you sure?',
                html: `You are about to delete the <strong>${cottageType} Cottage</strong>. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_cottage.php';
                    
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'cottage_id';
                    input.value = cottageId;
                    
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Form submission confirmations
    const addForm = document.getElementById('addCottageForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            const formData = new FormData(this);
            const cottageType = formData.get('cottage_type');
            
            if (!cottageType) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a cottage type'
                });
                return;
            }
            
            Swal.fire({
                title: 'Add New Cottage?',
                html: `Are you sure you want to add a <strong>${cottageType} Cottage</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (!result.isConfirmed) {
                    e.preventDefault();
                }
            });
        });
    }

    const editForm = document.getElementById('editCottageForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const formData = new FormData(this);
            const cottageType = formData.get('cottage_type');
            
            Swal.fire({
                title: 'Update Cottage?',
                html: `Are you sure you want to update the <strong>${cottageType} Cottage</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (!result.isConfirmed) {
                    e.preventDefault();
                }
            });
        });
    }

    // Real-time statistics update (simulated)
    setInterval(() => {
        const stats = document.querySelectorAll('.stat-info h3');
        if (stats.length >= 4) {
            // Rotate the available cottages count slightly
            const availableStat = stats[1];
            const current = parseInt(availableStat.textContent);
            const variation = Math.floor(Math.random() * 3) - 1; // -1, 0, or +1
            const newValue = Math.max(0, current + variation);
            availableStat.textContent = newValue;
            
            // Update occupied cottages accordingly
            const totalStat = parseInt(stats[0].textContent);
            const maintenanceStat = parseInt(stats[3].textContent);
            const occupiedStat = stats[2];
            occupiedStat.textContent = totalStat - newValue - maintenanceStat;
        }
    }, 15000); // Update every 15 seconds
});