$(document).ready(function() {
    $.extend( $.fn.dataTable.defaults, {
        language: { url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json" }
    });
    $('#basic-1').DataTable();
    $('#basic-2').DataTable();
    $('#basic-3').DataTable();
    $('#basic-4').DataTable();
    $('#basic-5').DataTable();
    $('#basic-6').DataTable();
});