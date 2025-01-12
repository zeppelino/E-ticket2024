/*================
    FUNCIONES PARA CAMBIO DE FECHA
 ================*/

// Función para convertir fecha de DD-MM-YYYY a YYYY-MM-DD
function formatDateForDatabase(dateString) {
    // Dividimos la cadena de fecha en día, mes y año
    var parts = dateString.split('-');
    var day = parts[2]; // Día
    var month = parts[1]; // Mes
    var year = parts[0]; // Año

    // Retornamos la fecha en formato 'YYYY-MM-DD'
    return `${year}-${month}-${day}`;
}

// Función para convertir fecha de YYYY-MM-DD a DD-MM-YYYY 
function formatDateToInput(dateString) {
    // Asegúrate de que el formato de entrada es "YYYY-MM-DD" (según el formato de la base de datos)
    var date = new Date(dateString); // Convierte la cadena de la fecha a un objeto Date
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2); // Sumamos 1 ya que getMonth() devuelve 0-11
    var day = ('0' + date.getDate()).slice(-2);
    
    // Retornamos la fecha en formato 'YYYY-MM-DD'
    return `${year}-${month}-${day}`;
}


    // Actualizar el campo 'fechaHasta' para que no sea menor que 'fechaDesde'
    /* document.getElementById('fechaDesde').addEventListener('change', function() {
        var fechaDesde = this.value;
        document.getElementById('fechaHasta').setAttribute('min', fechaDesde);
    }); */

    
    /* ===============
        DATA TABLES
    ================== */
    $(document).ready(function () {
        // Verifica si el DataTable ya está inicializado
        if ($.fn.DataTable.isDataTable('#dataTableEvento')) {
            $('#dataTableEvento').DataTable().clear().destroy(); // Destruir instancia previa
        }
    
        // Inicializar DataTable
        $('#dataTableEvento').DataTable({
            responsive: true,
            lengthMenu: [8, 20, 30],
            pageLength: 8, // Número de filas por página
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
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
            },
        });
    });
    