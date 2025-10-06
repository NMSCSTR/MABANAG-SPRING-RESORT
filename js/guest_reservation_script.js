document.addEventListener('DOMContentLoaded', function() {
    const reservationTypeSelect = document.getElementById('reservation_type');
    const roomSelect = document.getElementById('room_id');
    const cottageSelect = document.getElementById('cottage_id');
    const roomLabel = document.getElementById('room_label');
    const cottageLabel = document.getElementById('cottage_label');
    const totalAmountDisplay = document.getElementById('total_amount');
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');
    const stayDuration = document.getElementById('stay_duration');
    const durationDays = document.getElementById('duration_days');

    const today = new Date().toISOString().split('T')[0];
    checkInDate.min = today;
    checkOutDate.min = today;

    reservationTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;

        // Reset visibility
        roomSelect.style.display = 'none';
        cottageSelect.style.display = 'none';
        roomLabel.style.display = 'none';
        cottageLabel.style.display = 'none';
        checkOutDate.parentElement.style.display = 'block'; // ensure visible for room
        checkOutDate.required = true;

        // Reset selections
        roomSelect.value = '';
        cottageSelect.value = '';

        if (selectedType === 'room') {
            roomSelect.style.display = 'block';
            roomLabel.style.display = 'block';
            roomSelect.required = true;
            cottageSelect.required = false;

            // Show checkout date
            checkOutDate.parentElement.style.display = 'block';
            checkOutDate.required = true;
        } 
        else if (selectedType === 'cottage') {
            cottageSelect.style.display = 'block';
            cottageLabel.style.display = 'block';
            cottageSelect.required = true;
            roomSelect.required = false;

            // Hide checkout date for cottage
            checkOutDate.parentElement.style.display = 'none';
            checkOutDate.required = false;
            checkOutDate.value = '';

            // Immediately update total (since it’s per-use, not per-day)
            updateTotalAmount();
        }
        else {
            roomSelect.required = false;
            cottageSelect.required = false;
        }

        updateTotalAmount();
    });

    // Price calculations
    [roomSelect, cottageSelect, checkInDate, checkOutDate].forEach(el => {
        el.addEventListener('change', updateTotalAmount);
    });

    function updateTotalAmount() {
        let total = 0, dailyRate = 0, numberOfDays = 1;

        if (reservationTypeSelect.value === 'room' && roomSelect.value) {
            const price = roomSelect.options[roomSelect.selectedIndex].getAttribute('data-price');
            dailyRate = parseFloat(price);
        } 
        else if (reservationTypeSelect.value === 'cottage' && cottageSelect.value) {
            const price = cottageSelect.options[cottageSelect.selectedIndex].getAttribute('data-price');
            dailyRate = parseFloat(price);
        }

        // Only compute duration for room type
        if (reservationTypeSelect.value === 'room' && checkInDate.value && checkOutDate.value) {
            const checkIn = new Date(checkInDate.value);
            const checkOut = new Date(checkOutDate.value);
            const diffTime = checkOut - checkIn;
            numberOfDays = Math.max(1, diffTime / (1000 * 3600 * 24));
            stayDuration.style.display = 'block';
            durationDays.textContent = numberOfDays;
        } else {
            stayDuration.style.display = 'none';
        }

        total = (reservationTypeSelect.value === 'room')
            ? dailyRate * numberOfDays
            : dailyRate; // cottage = flat rate

        totalAmountDisplay.innerHTML = `
            <span class="amount-breakdown">
                ₱${dailyRate.toFixed(2)} ${reservationTypeSelect.value === 'room' ? `× ${numberOfDays} day${numberOfDays > 1 ? 's' : ''}` : ''} =
            </span>
            <span class="amount-total">₱${total.toFixed(2)}</span>
        `;
    }


    // Form validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if all required fields are filled
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Check date validation
        if (checkInDate.value && checkOutDate.value) {
            const checkIn = new Date(checkInDate.value);
            const checkOut = new Date(checkOutDate.value);
            
            if (checkOut <= checkIn) {
                isValid = false;
                checkOutDate.classList.add('is-invalid');
                showAlert('Check-out date must be after check-in date.', 'error');
            } else {
                checkOutDate.classList.remove('is-invalid');
            }
        }
        
        // Check if reservation type is selected
        if (!reservationTypeSelect.value) {
            isValid = false;
            reservationTypeSelect.classList.add('is-invalid');
        } else {
            reservationTypeSelect.classList.remove('is-invalid');
        }
        
        // Check if room/cottage is selected based on type
        if (reservationTypeSelect.value === 'room' && !roomSelect.value) {
            isValid = false;
            roomSelect.classList.add('is-invalid');
        } else {
            roomSelect.classList.remove('is-invalid');
        }
        
        if (reservationTypeSelect.value === 'cottage' && !cottageSelect.value) {
            isValid = false;
            cottageSelect.classList.add('is-invalid');
        } else {
            cottageSelect.classList.remove('is-invalid');
        }
        
        if (isValid) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            submitBtn.disabled = true;
            
            // Submit the form
            setTimeout(() => {
                form.submit();
            }, 1000);
        } else {
            showAlert('Please fill in all required fields correctly.', 'error');
        }
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Show alert function
    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert alert at the top of the form
        form.insertBefore(alertDiv, form.firstChild);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading animation to form sections
    const formSections = document.querySelectorAll('.form-section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    formSections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });

    // Phone number formatting
    const phoneInput = document.getElementById('contactno');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.slice(0, 3) + ' ' + value.slice(3);
            } else if (value.length <= 10) {
                value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6);
            } else {
                value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 10);
            }
        }
        this.value = value;
    });


    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add form reset functionality
    const resetBtn = document.querySelector('.btn-reset');
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            form.reset();
            roomSelect.style.display = 'none';
            cottageSelect.style.display = 'none';
            roomLabel.style.display = 'none';
            cottageLabel.style.display = 'none';
            stayDuration.style.display = 'none';
            totalAmountDisplay.textContent = '₱0.00';
            
            // Remove validation classes
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
        }
    });

    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const inputs = Array.from(form.querySelectorAll('input, select, textarea'));
            const currentIndex = inputs.indexOf(e.target);
            if (currentIndex < inputs.length - 1) {
                inputs[currentIndex + 1].focus();
            }
        }
    });

    // File upload functionality
    const fileInput = document.getElementById('receipt_file');
    const filePreview = document.getElementById('file-preview');
    const fileUploadContainer = document.querySelector('.file-upload-container');

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            validateAndPreviewFile(file);
        }
    });

    // Drag and drop functionality
    fileUploadContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            fileInput.files = files;
            validateAndPreviewFile(file);
        }
    });

    // Click to upload
    fileUploadContainer.addEventListener('click', function() {
        fileInput.click();
    });

    // File validation and preview
    function validateAndPreviewFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            showAlert('Invalid file type. Please upload JPG, PNG, or PDF files only.', 'error');
            fileInput.value = '';
            return;
        }

        if (file.size > maxSize) {
            showAlert('File size too large. Please upload files smaller than 5MB.', 'error');
            fileInput.value = '';
            return;
        }

        // Show preview
        showFilePreview(file);
    }

    // Show file preview
    function showFilePreview(file) {
        const previewName = filePreview.querySelector('.preview-name');
        const previewSize = filePreview.querySelector('.preview-size');
        const previewIcon = filePreview.querySelector('.preview-icon');

        previewName.textContent = file.name;
        previewSize.textContent = formatFileSize(file.size);
        
        // Set appropriate icon based on file type
        if (file.type.startsWith('image/')) {
            previewIcon.className = 'fas fa-file-image preview-icon';
        } else if (file.type === 'application/pdf') {
            previewIcon.className = 'fas fa-file-pdf preview-icon';
        } else {
            previewIcon.className = 'fas fa-file preview-icon';
        }

        filePreview.style.display = 'block';
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Remove file function (called from HTML)
    window.removeFile = function() {
        fileInput.value = '';
        filePreview.style.display = 'none';
    };

    // File validation on form submission
    form.addEventListener('submit', function(e) {
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            fileInput.classList.add('is-invalid');
            showAlert('Please upload a payment receipt.', 'error');
            return;
        }

        const file = fileInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            fileInput.classList.add('is-invalid');
            showAlert('Invalid file type. Please upload JPG, PNG, or PDF files only.', 'error');
            return;
        }

        if (file.size > maxSize) {
            e.preventDefault();
            fileInput.classList.add('is-invalid');
            showAlert('File size too large. Please upload files smaller than 5MB.', 'error');
            return;
        }

        fileInput.classList.remove('is-invalid');
    });
});
