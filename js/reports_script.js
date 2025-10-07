$(document).ready(function(){
    loadReport('weekly');

    $('#reportType').on('change', function(){
        loadReport($(this).val());
    });

    function loadReport(type){
        if($.fn.DataTable.isDataTable('#reportsTable')){
            $('#reportsTable').DataTable().destroy();
        }

        $('#reportsTable').DataTable({
            ajax: {
                url: 'get_reports.php',
                type: 'POST',
                data: {type: type},
                dataSrc: function(json){
                    let total = 0;
                    json.data.forEach(row => total += parseFloat(row.amount));
                    $('#totalRevenue').text('₱' + total.toLocaleString(undefined,{minimumFractionDigits:2}));
                    return json.data;
                }
            },
            columns: [
                { data: 'no' },
                { data: 'reservation_id' },
                { data: 'payment_date' },
                { data: 'payment_method' },
                { data: 'payment_reference' },
                { data: 'amount' },
                { data: 'payment_status' }
            ],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', text: 'Copy' },
                { extend: 'csv', text: 'Export CSV' },
                { extend: 'excel', text: 'Export Excel' },
                { extend: 'pdf', text: 'Export PDF' },
                { extend: 'print', text: 'Print' }
            ]
        });
    }
});