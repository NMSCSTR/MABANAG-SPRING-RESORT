function showSwal(type, message, timer = 1500) {
    Swal.fire({
        position: "top-end",
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: timer
    });
}