// transaction_script.js

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
    const transactionsTable = $('#transactionsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[3, 'desc']], // Sort by reservation date descending
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search transactions...",
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
        transactionsTable.search(this.value).draw();
    });

    // Filter by reservation status
    $('#statusFilter').on('change', function() {
        const value = this.value;
        transactionsTable.column(5).search(value).draw();
    });

    // Filter by payment status
    $('#paymentFilter').on('change', function() {
        const value = this.value;
        transactionsTable.column(6).search(value).draw();
    });

    // View Transaction Modal Handler
    const viewTransactionModal = document.getElementById('viewTransactionModal');
    if (viewTransactionModal) {
        viewTransactionModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reservationId = button.getAttribute('data-id');
            const guestName = button.getAttribute('data-guest');
            const guestContact = button.getAttribute('data-contact');
            const reservationType = button.getAttribute('data-type');
            const reservationDate = button.getAttribute('data-date');
            const amount = button.getAttribute('data-amount');
            const reservationStatus = button.getAttribute('data-reservation-status');
            const paymentStatus = button.getAttribute('data-payment-status');
            const room = button.getAttribute('data-room');
            const cottage = button.getAttribute('data-cottage');

            document.getElementById('view_transaction_id').textContent = '#' + reservationId;
            document.getElementById('view_guest_name').textContent = guestName;
            document.getElementById('view_guest_contact').textContent = guestContact;
            document.getElementById('view_reservation_type').textContent = reservationType;
            document.getElementById('view_reservation_date').textContent = new Date(reservationDate).toLocaleString();
            document.getElementById('view_payment_amount').textContent = amount ? '₱' + parseFloat(amount).toFixed(2) : '-';
            document.getElementById('view_reservation_status').textContent = reservationStatus.charAt(0).toUpperCase() + reservationStatus.slice(1);
            document.getElementById('view_payment_status').textContent = paymentStatus ? paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1) : 'No Payment';
            document.getElementById('view_room_cottage').textContent = room !== 'N/A' ? room : (cottage !== 'N/A' ? cottage : 'N/A');
        });
    }

    // Confirm Reservation
    const confirmButtons = document.querySelectorAll('.btn-confirm');
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reservationId = this.getAttribute('data-id');
            const guestName = this.getAttribute('data-guest');
            
            Swal.fire({
                title: 'Confirm Reservation?',
                html: `Are you sure you want to confirm the reservation for <strong>${guestName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, confirm!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit confirmation
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'update_reservation.php';
                    
                    const reservationInput = document.createElement('input');
                    reservationInput.type = 'hidden';
                    reservationInput.name = 'reservation_id';
                    reservationInput.value = reservationId;
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = 'confirmed';
                    
                    form.appendChild(reservationInput);
                    form.appendChild(statusInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Cancel Reservation
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reservationId = this.getAttribute('data-id');
            const guestName = this.getAttribute('data-guest');
            
            Swal.fire({
                title: 'Cancel Reservation?',
                html: `Are you sure you want to cancel the reservation for <strong>${guestName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit cancellation
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'update_reservation.php';
                    
                    const reservationInput = document.createElement('input');
                    reservationInput.type = 'hidden';
                    reservationInput.name = 'reservation_id';
                    reservationInput.value = reservationId;
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = 'cancelled';
                    
                    form.appendChild(reservationInput);
                    form.appendChild(statusInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Verify Payment
    const verifyButtons = document.querySelectorAll('.btn-verify');
    verifyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const paymentId = this.getAttribute('data-id');
            const amount = this.getAttribute('data-amount');
            
            Swal.fire({
                title: 'Verify Payment?',
                html: `Are you sure you want to verify this payment of <strong>₱${amount}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, verify!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit verification
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'update_payment.php';
                    
                    const paymentInput = document.createElement('input');
                    paymentInput.type = 'hidden';
                    paymentInput.name = 'payment_id';
                    paymentInput.value = paymentId;
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'payment_status';
                    statusInput.value = 'verified';
                    
                    form.appendChild(paymentInput);
                    form.appendChild(statusInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Reject Payment
    const rejectButtons = document.querySelectorAll('.btn-reject');
    rejectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const paymentId = this.getAttribute('data-id');
            const amount = this.getAttribute('data-amount');
            
            Swal.fire({
                title: 'Reject Payment?',
                html: `Are you sure you want to reject this payment of <strong>₱${amount}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit rejection
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'update_payment.php';
                    
                    const paymentInput = document.createElement('input');
                    paymentInput.type = 'hidden';
                    paymentInput.name = 'payment_id';
                    paymentInput.value = paymentId;
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'payment_status';
                    statusInput.value = 'rejected';
                    
                    form.appendChild(paymentInput);
                    form.appendChild(statusInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // // Export functionality
    // document.getElementById('exportBtn').addEventListener('click', function() {
    //     Swal.fire({
    //         title: 'Export Report',
    //         text: 'Choose export format:',
    //         icon: 'info',
    //         showCancelButton: true,
    //         confirmButtonText: 'Excel',
    //         cancelButtonText: 'PDF',
    //         showDenyButton: true,
    //         denyButtonText: 'CSV'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // Export to Excel
    //             exportReport('excel');
    //         } else if (result.isDenied) {
    //             // Export to CSV
    //             exportReport('csv');
    //         } else if (result.dismiss === Swal.DismissReason.cancel) {
    //             // Export to PDF
    //             exportReport('pdf');
    //         }
    //     });
    // });

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

    // Filter functionality
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        // Apply filters to DataTable
        let searchQuery = '';
        
        if (formData.get('date_from')) {
            searchQuery += `Date From: ${formData.get('date_from')} `;
        }
        if (formData.get('date_to')) {
            searchQuery += `Date To: ${formData.get('date_to')} `;
        }
        if (formData.get('reservation_status')) {
            searchQuery += `Status: ${formData.get('reservation_status')} `;
        }
        if (formData.get('payment_status')) {
            searchQuery += `Payment: ${formData.get('payment_status')} `;
        }
        
        transactionsTable.search(searchQuery.trim()).draw();
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('filterModal')).hide();
        
        Swal.fire({
            title: 'Filters Applied!',
            text: 'Your filters have been applied to the transaction list.',
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // Reset filters
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterForm').reset();
        transactionsTable.search('').draw();
        
        Swal.fire({
            title: 'Filters Reset!',
            text: 'All filters have been cleared.',
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // Receipt modal functionality
    const receiptModal = document.getElementById('receiptModal');
    if (receiptModal) {
        receiptModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const receiptPath = button.getAttribute('data-receipt');
            const paymentMethod = button.getAttribute('data-payment-method');
            
            // Set payment method
            document.getElementById('receipt-payment-method').textContent = paymentMethod;
            
            // Set download link
            document.getElementById('download-receipt').href = '../' + receiptPath;
            
            // Determine file type and display accordingly
            const fileExtension = receiptPath.split('.').pop().toLowerCase();
            const receiptImage = document.getElementById('receipt-image');
            const receiptPdfContainer = document.getElementById('receipt-pdf-container');
            const receiptPdf = document.getElementById('receipt-pdf');
            
            if (fileExtension === 'pdf') {
                // Show PDF
                receiptImage.style.display = 'none';
                receiptPdfContainer.style.display = 'block';
                receiptPdf.src = '../' + receiptPath;
            } else {
                // Show image
                receiptPdfContainer.style.display = 'none';
                receiptImage.style.display = 'block';
                receiptImage.src = '../' + receiptPath;
            }
        });
        
        // Clear modal content when hidden
        receiptModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('receipt-image').src = '';
            document.getElementById('receipt-pdf').src = '';
            document.getElementById('receipt-image').style.display = 'none';
            document.getElementById('receipt-pdf-container').style.display = 'none';
        });
    }
});