$(document).ready(function () {
    function initializeDataTables() {
        // Destruir todas las instancias de DataTables para las tablas con clase "tablaReporte"
        $(".tablaReporte").each(function () {
            if ($.fn.dataTable.isDataTable(this)) {
                $(this).DataTable().clear().destroy();
            }
        });  
        // Inicializa nuevamente con la configuración de idioma
        $(".tablaReporte").DataTable({
            lengthMenu: [9, 20, 30],
            paging: true,
            pageLength: 9, // Número de filas por página
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
    }
    // Oculta el div de la tabla de entradas inicialmente
    $("#divEntradas").hide();
    $("#buscarReporte").hide();
    initializeDataTables();

    $("#tipo_reporte").on("change", function () {
        var tipoReporte = $(this).val();

        if (tipoReporte === "anual") {
            $("#divAnual").show(); // Muestra el div de la tabla anual
            $("#divEntradas").hide(); // Oculta el div de entradas
        } else if (tipoReporte === "entradas") {
            $("#divEntradas").show(); // Muestra el div de entradas
            $("#divAnual").hide(); // Oculta el div de la tabla anual
        }
    });
});




/* document.addEventListener('DOMContentLoaded', function () {
    const fechaDesdeInput = document.getElementById('fecha_desde');
    const fechaHastaInput = document.getElementById('fecha_hasta');

    function validateDates() {
        const fechaDesde = new Date(fechaDesdeInput.value);
        const fechaHasta = new Date(fechaHastaInput.value);

        if (fechaDesde > fechaHasta) {
            alert('La fecha "Hasta" no puede ser menor que la fecha "Desde".');
            fechaHastaInput.value = ''; // Limpiar el campo "Hasta"
        }
    }

    // Agregar eventos de cambio para validar las fechas
    fechaDesdeInput.addEventListener('change', validateDates);
    fechaHastaInput.addEventListener('change', validateDates);
}); */

/* validacion de la fecha con sweetalert2 */
/* document.getElementById('reporteForm').addEventListener('submit', function(event) {
    var fechaDesde = document.getElementById('fecha_desde').value;
    var fechaHasta = document.getElementById('fecha_hasta').value;

    console.log(fechaDesde, fechaHasta);
    if (fechaHasta < fechaDesde) {
        event.preventDefault(); // Detener el envío del formulario
       

        Swal.fire({
            icon: 'error',
            title: 'Error en las fechas',
            text: 'La fecha "Hasta" no puede ser menor que la fecha "Desde".',
            confirmButtonText: 'Entendido'
        }).then(() => {
            // Limpiar los inputs de las fechas después de cerrar la alerta
            document.getElementById('fecha_desde').value = '';
            document.getElementById('fecha_hasta').value = '';
        });;
    }
}); */


// ESTO DE ABAJO ES LO QUE FUNCIONA 

/* document.getElementById('fecha_desde').addEventListener('change', function() {
    var fechaDesde = new Date(this.value);

    if (!isNaN(fechaDesde.getTime())) {
        // Sumar 1 año a la fecha seleccionada en "Desde"
        var fechaHasta = new Date(fechaDesde);
        fechaHasta.setFullYear(fechaHasta.getFullYear() + 1);

        // Formatear la fecha "Hasta" a 'YYYY-MM-DD'
        var fechaHastaFormateada = fechaHasta.toISOString().split('T')[0];
        document.getElementById('fecha_hasta').value = fechaHastaFormateada;
    }
}); */



// Esto funciona, hace que sea un input, busca año a año desde que se selecciona uno.
/* document.addEventListener('DOMContentLoaded', function () {
    const tipoReporte = document.getElementById('tipo_reporte');
    const fechaDesde = document.getElementById('fecha_desde');
    const fechaHasta = document.getElementById('fecha_hasta');
    const today = new Date().toISOString().split('T')[0];

    // Función para aplicar el formato de año en el campo "Desde"
    function aplicarFormatoAnual() {
        fechaDesde.setAttribute('type', 'text');
        fechaDesde.setAttribute('placeholder', 'AÑO');
        fechaDesde.value = ''; // Limpia el valor actual
        fechaDesde.addEventListener('input', enforceYearFormat);

        fechaHasta.value = today;
        fechaHasta.setAttribute('readonly', true);
    }

    // Función para aplicar el formato de entradas vendidas
    function aplicarFormatoEntradas() {
        fechaDesde.setAttribute('type', 'date');
        fechaDesde.removeAttribute('placeholder');
        fechaDesde.removeEventListener('input', enforceYearFormat);

        fechaHasta.removeAttribute('readonly');
        fechaHasta.value = '';
    }

    // Enforce año solo en el campo "Desde" para Reporte Anual
    function enforceYearFormat(event) {
        event.target.value = event.target.value.replace(/[^0-9]/g, '').substring(0, 4);
    }

    // Verificar el tipo de reporte seleccionado al cargar la página
    if (tipoReporte.value === 'anual') {
        aplicarFormatoAnual();
    } else {
        aplicarFormatoEntradas();
    }

    // Cambiar el formato de acuerdo al tipo de reporte seleccionado
    tipoReporte.addEventListener('change', function () {
        if (tipoReporte.value === 'anual') {
            aplicarFormatoAnual();
        } else {
            aplicarFormatoEntradas();
        }
    });
}); */

/* document.getElementById('fecha_desde').addEventListener('change', function() {
    var fechaDesde = new Date(this.value);

    if (!isNaN(fechaDesde.getTime())) {
        // Sumar 1 año a la fecha seleccionada en "Desde"
        var fechaHasta = new Date(fechaDesde);
        fechaHasta.setFullYear(fechaHasta.getFullYear() + 1);

        // Formatear la fecha "Hasta" a 'YYYY-MM-DD'
        var fechaHastaFormateada = fechaHasta.toISOString().split('T')[0];
        document.getElementById('fecha_hasta').value = fechaHastaFormateada;
    }
}); */
/* 
document.addEventListener('DOMContentLoaded', function () {
    const tipoReporte = document.getElementById('tipo_reporte');
    const fechaDesde = document.getElementById('fecha_desde');
    const fechaHasta = document.getElementById('fecha_hasta');

    // Función para aplicar el formato de calendario en el campo "Desde" para Reporte Anual
    function aplicarFormatoAnual() {
        fechaDesde.setAttribute('type', 'date'); // Cambiar a calendario
        fechaDesde.value = ''; // Limpia el valor actual

        // Sumar 1 año automáticamente al seleccionar una fecha en "Desde"
        fechaDesde.addEventListener('change', function() {
            var fecha = new Date(fechaDesde.value);
            if (!isNaN(fecha.getTime())) {
                fecha.setFullYear(fecha.getFullYear() + 1);
                fechaHasta.value = fecha.toISOString().split('T')[0];
                fechaHasta.setAttribute('readonly', true); // Campo "Hasta" en solo lectura
            }
        });
    }

    // Función para aplicar el formato de entradas vendidas (calendario normal)
    function aplicarFormatoEntradas() {
        fechaDesde.setAttribute('type', 'date'); // Mantener calendario
        fechaDesde.removeAttribute('placeholder');
        fechaHasta.removeAttribute('readonly'); // Habilitar campo "Hasta" para edición
        fechaHasta.value = '';
    }

    // Verificar el tipo de reporte seleccionado al cargar la página
    if (tipoReporte.value === 'anual') {
        aplicarFormatoAnual();
    } else {
        aplicarFormatoEntradas();
    }

    // Cambiar el formato de acuerdo al tipo de reporte seleccionado
    tipoReporte.addEventListener('change', function () {
        if (tipoReporte.value === 'anual') {
            aplicarFormatoAnual();
        } else {
            aplicarFormatoEntradas();
        }
    });
});

document.getElementById('reporteForm').addEventListener('submit', function(event) {
    var fechaDesde = document.getElementById('fecha_desde').value;
    var fechaHasta = document.getElementById('fecha_hasta').value;

    if (fechaHasta < fechaDesde) {
        event.preventDefault(); // Detener el envío del formulario

        Swal.fire({
            icon: 'error',
            title: 'Error en las fechas',
            text: 'La fecha "Hasta" no puede ser menor que la fecha "Desde".',
            confirmButtonText: 'Entendido'
        }).then(() => {
            // Limpiar los inputs de las fechas después de cerrar la alerta
            document.getElementById('fecha_desde').value = '';
            document.getElementById('fecha_hasta').value = '';
        });
    }
});  */

document.addEventListener('DOMContentLoaded', function () {
    const tipoReporte = document.getElementById('tipo_reporte');
    const fechaDesde = document.getElementById('fecha_desde');
    const fechaHasta = document.getElementById('fecha_hasta');


    // Validar que "Hasta" no sea menor que "Desde"
    function validarFechas() {
        const desde = new Date(fechaDesde.value);
        const hasta = new Date(fechaHasta.value);

        if (desde && hasta && hasta < desde) {
            Swal.fire({
                icon: 'error',
                title: 'Error en las fechas',
                text: 'La fecha "Hasta" no puede ser menor que la fecha "Desde".',
                confirmButtonText: 'Entendido',
            }).then(() => {
                fechaDesde.value = '';
                fechaHasta.value = '';
            });
        }
    }

    // Inicializar el formato según el tipo de reporte seleccionado
    function inicializarFormato() {
        if (tipoReporte.value === 'anual') {
            aplicarFormatoAnual();
        } else if (tipoReporte.value === 'entradas') {
            aplicarFormatoEntradas();
        }
    }

    // Escuchar cambios en el tipo de reporte
    tipoReporte.addEventListener('change', inicializarFormato);

    // Inicializar el formato al cargar la página
    inicializarFormato();

    // Validación al enviar el formulario
    document.getElementById('reporteForm').addEventListener('submit', function (event) {
        const desde = new Date(fechaDesde.value);
        const hasta = new Date(fechaHasta.value);

        if (tipoReporte.value === 'entradas' && desde && hasta && hasta < desde) {
            event.preventDefault(); // Detener el envío del formulario
            Swal.fire({
                icon: 'error',
                title: 'Error en las fechas',
                text: 'La fecha "Hasta" no puede ser menor que la fecha "Desde".',
                confirmButtonText: 'Entendido',
            });
        }
    });

    
    // Función para aplicar la lógica del Reporte Anual
    function aplicarFormatoAnual() {
        fechaDesde.setAttribute('type', 'date');
        fechaHasta.setAttribute('readonly', true); // Campo "Hasta" en solo lectura
        fechaDesde.value = '';
        fechaHasta.value = '';

        fechaDesde.addEventListener('change', function () {
            const fecha = new Date(fechaDesde.value);
            if (!isNaN(fecha.getTime())) {
                fecha.setFullYear(fecha.getFullYear() + 1); // Sumar 1 año a la fecha "Desde"
                fechaHasta.value = fecha.toISOString().split('T')[0]; // Formatear fecha
            }
        });
    }

    // Función para aplicar la lógica del Reporte de Entradas
    function aplicarFormatoEntradas() {
        fechaDesde.setAttribute('type', 'date');
        fechaHasta.setAttribute('type', 'date');
        fechaHasta.removeAttribute('readonly'); // Hacer editable el campo "Hasta"
        fechaDesde.value = '';
        fechaHasta.value = ''; // Dejar el campo "Hasta" vacío
    }
});
