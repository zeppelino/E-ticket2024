/* ===============
   DATA TABLES
================== */
$(document).ready(function () {
    $("#dataTableNotificaciones").DataTable({
        lengthMenu: [10, 20, 30],
        paging: true,
        pageLength: 10, // Número de filas por página
        language: {
            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            infoEmpty: "Mostrando 0 registros",
            infoFiltered: "(Filtrado de _MAX_ entradas en total)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
    });
});
