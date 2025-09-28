function printReservation() {
    // Show print-specific elements
    const printElements = document.querySelectorAll('[style="display: none;"]');
    printElements.forEach(el => {
        if (el.classList.contains('print-header') ||
            el.classList.contains('print-footer') ||
            el.classList.contains('print-watermark')) {
            el.style.display = 'block';
        }
    });

    // Hide non-print elements
    const nonPrintElements = document.querySelectorAll('.no-print');
    nonPrintElements.forEach(el => {
        el.style.display = 'none';
    });

    // Print the page
    window.print();

    // Restore original display after printing
    setTimeout(() => {
        printElements.forEach(el => {
            el.style.display = 'none';
        });

        nonPrintElements.forEach(el => {
            el.style.display = '';
        });
    }, 100);
}