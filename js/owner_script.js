$(document).ready(function () {
    // Initialize DataTable
    $('#infoTable').DataTable();

    // Open edit modal
    $(document).on('click', '.editBtn', function () {
        const row = $(this).closest('tr');
        const data = row.children('td').map(function () {
            return $(this).text();
        }).get();

        const info_id = $(this).data('id');

        // Fill form fields
        $('#info_id').val(info_id);
        $('#gcash_number').val(data[0]);
        $('#gcash_name').val(data[1]);
        $('#email_address').val(data[2]);
        $('#phone_number').val(data[3]);
        $('#address').val(data[4]);
        $('#facebook_account').val(data[5]);

        // Show modal
        $('#editInfoModal').modal('show');
    });

    // Submit edit form via AJAX
    $('#editInfoForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'update_owner.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#editInfoModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            }
        });
    });
});
