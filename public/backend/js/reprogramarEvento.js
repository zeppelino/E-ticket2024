
/*============================================
VISTA PREVIA IMAGEN Y VALIDACION FORMATO
============================================*/

function mainThamUrl(input) {

    if (input.files && input.files[0]) {
        var imagen = input.files[0];
        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
            $("#idEventoImagen").val("");
            $('#mainThmb').attr('src',"frontend/img/eventos/imagenDefecto/porDefectoEvento.jpg").width(100).height(100);
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato JPG o PNG!",
                icon: "error",
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: "Cerrar"
            });
        } else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#mainThmb').attr('src', e.target.result).width(100).height(100);
            };
            reader.readAsDataURL(imagen);
        }
    }
}

/*===============================
LOGICA DEL WIZARD
================================*/

function validate(button) {
    var wizardSection = $(button).closest("section");

    // Verificar si el evento no tiene cupos disponibles
    if ($(wizardSection).find(".fs-3:contains('El evento se encuentra agotado')").length > 0) {
        // Saltar validación y mostrar la siguiente sección directamente
        showNextWizardSection(wizardSection);
        return;
    }

    var valid = true;

    // Restablecer todos los bordes
    $(wizardSection).find("input, select, textarea").css("border", "1px solid #9a9a9a");

    // Validar inputs
    $(wizardSection).find("input").each(function() {
        if ($(this).attr("type") !== "file" && $(this).val() === "") {
            valid = false;
            $(this).css("border", "red 1px solid");
        }
    });

    // Validar selects genéricos
    $(wizardSection).find("select:not(.ticket-select)").each(function() {
        if ($(this).val() === "" || $(this).val() === null) {
            valid = false;
            $(this).css("border", "red 1px solid");
        } else {
            $(this).css("border", "1px solid #9a9a9a"); // Quitar borde rojo si está correcto
        }
    });

    // Validar selects de tickets específicamente
    $(wizardSection).find("select.ticket-select").each(function() {
        var selectedValue = $(this).val();
        var selectedText = $(this).find('option:selected').text().trim();
    
        if (selectedValue === "" || selectedValue === null) {
            // Si el select está vacío o no se ha seleccionado nada, mostrar borde rojo
            valid = false;
            $(this).css("border", "red 1px solid");
        } else if (selectedText === 'Gratis') {
            // Si es "Gratuito", permitirlo y quitar el borde rojo
            $(this).css("border", "1px solid #9a9a9a");
        } else {
            // Si se selecciona algo válido que no es "Gratuito", validar normalmente
            $(this).css("border", "1px solid #9a9a9a");
        }
    });

    // Validar textareas
    $(wizardSection).find("textarea").each(function() {
        if ($(this).val().trim() === "") { 
            valid = false;
            $(this).css("border", "red 1px solid");
        }
    });

    // Si todo es válido, mostrar la siguiente sección
    if (valid) {
        showNextWizardSection(wizardSection);
    }
}
        
function showNextWizardSection(wizardSection) {
    $("section").addClass("display-none");
    $(wizardSection).next("section").removeClass("display-none");
    $(".wizard-flow-chart span.fill").next("span").addClass("fill");
}

function showPrevious(button) {
    var wizardSection = $(button).closest("section");
    $("section").addClass("display-none");
    $(wizardSection).prev("section").removeClass("display-none");
    $(".wizard-flow-chart span.fill").last().removeClass("fill");
}

/*============================================
IMPIDE QUE SE INGRESE CERO EN INPUTS NUMBER
==============================================*/
        
$(document).ready(function() {
    $('#formEvento').on('input', 'input[type=number]', function() {
        // Si el valor ingresado es menor que 1, restablecerlo a 1
        if ($(this).val() < 1) {
            $(this).val(1);
        }
    });
});

/*============================================
VALIDACION DE FECHAS EN DATOS BÁSICOS
==============================================*/

$(document).ready(function() {
    const $eventEnableDate = $('#eventEnableDate');
    const $eventStartDate = $('#eventStartDate');
    const $btnSigDatosBasicos = $('#btnSigDatosBasicos');

    function validateDates() {
        const fechaInicio = new Date($eventEnableDate.val());
        const fechaFin = new Date($eventStartDate.val());

        if (fechaFin.getTime() <= fechaInicio.getTime()) {
            Swal.fire({
                title: "Error en las fechas",
                text: "La fecha de publicación debe ser anterior a la fecha de realización.",
                icon: "error",
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: "Cerrar"
            });

            $btnSigDatosBasicos.prop('disabled', true); // Deshabilitar el botón
        } else {
            $btnSigDatosBasicos.prop('disabled', false); // Habilitar el botón
        }
    }

    $eventEnableDate.on('change', validateDates);
    $eventStartDate.on('change', validateDates);
    //validateDates();
});

/*==========================================
VALIDAR CANTIDAD DE TICKETS EN LAS TANDAS
==========================================*/

// Función para verificar la distribución
/* function checkDistribution() {

        var sum = 0;
        // Sumar las cantidades ingresadas en los inputs
        $('.ticket-input').each(function() {
            let value = parseInt($(this).val()) || 0; // Obtener el valor del input, o 0 si está vacío
            sum += value;

            // Mostrar la suma total en el elemento con id "totalCantidad"
            $('.totalCantDistri').text(sum);
        });

        // Verificar si la suma es igual al total
        if (sum === totalTickets ) {

            $('#nextButton').prop('disabled', false); // Habilitar el botón
            $('.totalCantDistri').css('color', 'green');
            Swal.fire({
                title: "Tickets distribuidos",
                text: "Todos los tickets estan distribuidos",
                icon: "success",
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: "Cerrar"
            });
        
        } else {
            $('#nextButton').prop('disabled', true); // Deshabilitar
            $('.totalCantDistri').css('color', 'red');
        }

}

// Ejecutar la verificación al cambiar los valores de los inputs
$(document).on('input change', '.ticket-input', function() { 
    checkDistribution();
}); */

/*=======================================
MOSTRAR CANTIDAD TOTAL DE TICKETS
=======================================*/

var totalTickets = 0;

function actualizarSumaDeCantidad() {  
let totalCantidad = 0;

    // Recorrer todos los inputs de cantidad
    $('input[name="ticketQuantity[]"]').each(function() {
        // Asegurarse de que el valor sea un número (maneja inputs vacíos)
        let cantidad = parseInt($(this).val()) || 0;
        totalCantidad += cantidad;
    });

    totalTickets = totalCantidad;

    // Mostrar la suma total en el elemento con id "totalCantidad"
    $('.totalCantidad').text(totalCantidad);

    if (esGratis) {
        $('.totalCantDistri').text(totalTickets);
        $('#cupo_tanda_1').val(totalTickets);
        $('#nextButton').prop('disabled', false); // Habilitar el botón
        $('.totalCantDistri').css('color', 'green');      
    }else{
        $('.totalCantDistri').css('color', 'red');
        $('.totalCantDistri').text(1);
        $('#cupo_tanda_1').val(1);
        $('#nextButton').prop('disabled', true); // desHabilitar el botón
    }

}

// Detectar cuando el valor de un input ticketQuantity cambia
$(document).on('input', 'input[name="ticketQuantity[]"]', function() {
    actualizarSumaDeCantidad();
});

// Llamar a la función cuando se elimine un ticket para recalcular la suma
$(document).on('click', '.eliminarTicket', function() {
    actualizarSumaDeCantidad();
});

/*==========================================
AJUSTAR FECHAS ENTRE TANDAS
==========================================*/

function ajustarFechasTandas() {
    const tandas = document.querySelectorAll('.tanda');
    tandas.forEach((tanda, index) => {
        if (index > 0) { // La primera tanda no tiene tanda anterior
            const tandaAnterior = tandas[index - 1];
            const fechaFinAnterior = tandaAnterior.querySelector(`[id^="fecha_fin_tanda_"]`).value;
            const fechaInicioActual = tanda.querySelector(`[id^="fecha_inicio_tanda_"]`);

            fechaInicioActual.value = fechaFinAnterior; // Asignar la fecha de fin de la tanda anterior
            fechaInicioActual.min = fechaFinAnterior; // Establecer el mínimo para la nueva tanda
        }
    });
}

/*==========================================
VALIDAR FECHAS INICIO Y FIN DE CADA TANDA
==========================================*/

function checkFechaInicioFinTandas() {

    const eventStartDate = document.getElementById('eventStartDate');
    const eventStartTime = document.getElementById('eventStartTime');

    const tandas = document.querySelectorAll('.tanda');
    tandas.forEach((tanda, index) => {
        const fechaInicio = tanda.querySelector(`[id^="fecha_inicio_tanda_"]`);
        const fechaFin = tanda.querySelector(`[id^="fecha_fin_tanda_"]`);

        fechaInicio.addEventListener('change', function () {
            if (new Date(fechaInicio.value) >= new Date(fechaFin.value)) {
                Swal.fire({
                    title: "Error en las fechas",
                    text: "La fecha de inicio no puede ser mayor o igual a la fecha de fin.",
                    icon: "error",
                    confirmButtonColor: "#0f9cf3",
                    confirmButtonText: "Cerrar"
                });
                fechaInicio.value = '';
            }
        });


        fechaFin.addEventListener('change', function () {
            const fechaInicioDate = new Date(fechaInicio.value);
            const fechaFinDate = new Date(fechaFin.value);
            
            // Combina la fecha y hora de publicación en un solo objeto Date
            const eventStartDateTime = new Date(`${eventStartDate.value}T${eventStartTime.value}`);

            if (fechaInicioDate >= fechaFinDate) {
                Swal.fire({
                    title: "Error en las fechas",
                    text: "La fecha de fin debe ser mayor que la fecha de inicio.",
                    icon: "error",
                    confirmButtonColor: "#0f9cf3",
                    confirmButtonText: "Cerrar"
                });
                fechaFin.value = '';
            } else if (fechaFinDate > eventStartDateTime) {
                const fechaEventoFormateada = eventStartDateTime.toLocaleString('es-AR', {
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit'
                });
                Swal.fire({
                    title: "Fecha de Fin Incorrecta",
                    text: "La fecha de fin no puede ser posterior a la fecha de realización del evento. Por favor, seleccione una fecha anterior al: " + fechaEventoFormateada,
                    icon: "error",
                    confirmButtonColor: "#0f9cf3",
                    confirmButtonText: "Cerrar"
                });
                fechaFin.value = '';
            }
        });
    });
}

/*==========================================
VALIDAR FECHAS INICIO Y FIN EN PRIMERA TANDA
==========================================*/

$(document).ready(function() {
    // Comprobar fechas del primer input al cargar la página
    checkFechaInicioFinTandas();

    // Ejecutar la verificación al cambiar los valores de los inputs (fecha de inicio y fecha de fin)
    $(document).on('input change', '.fecha-input', function() { 
        checkFechaInicioFinTandas();
    });
});





/*============================================
CODIGO PARA LAS TANDAS
==============================================*/
var tandaCount = 0;


document.addEventListener("DOMContentLoaded", function () {
     tandaCount = 1; // Inicialmente hay una tanda

    // Función para actualizar los nombres de las tandas
    function actualizarNombresDeTandas() {
        // Seleccionar todas las tandas actuales
        const tandas = document.querySelectorAll('.tanda');

        // Recorrer cada tanda y actualizar su número
        tandas.forEach(function(tanda, index) {
            const nuevoNumero = index + 1; // El nuevo número de la tanda (inicia desde 1)
            
            // Actualizar el nombre de la tanda
            const nombreTandaInput = tanda.querySelector(`[id^="nombre_tanda_"]`);
            nombreTandaInput.value = `Tanda ${nuevoNumero}`;
            nombreTandaInput.id = `nombre_tanda_${nuevoNumero}`;
            
            // Actualizar los ID de fecha de inicio
            const fechaInicioInput = tanda.querySelector(`[id^="fecha_inicio_tanda_"]`);
            fechaInicioInput.id = `fecha_inicio_tanda_${nuevoNumero}`;

            // Actualizar los ID de fecha de fin
            const fechaFinInput = tanda.querySelector(`[id^="fecha_fin_tanda_"]`);
            fechaFinInput.id = `fecha_fin_tanda_${nuevoNumero}`;

            // Actualizar el ID del cupo de entradas
            const cupoInput = tanda.querySelector(`[id^="cupo_tanda_"]`);
            cupoInput.id = `cupo_tanda_${nuevoNumero}`;
            
            // Actualizar el ID de la tanda
            tanda.id = `tanda-${nuevoNumero}`;
        });
    }

    const maxInputsTandas = 4;

    /*=======================
        AGREGAR TANDA
    =========================*/

    document.getElementById("agregarTanda").addEventListener("click", function () {
            
        // Obtener la tanda actual (última tanda)
        const ultimaTanda = document.querySelector(`#tanda-${tandaCount}`);
        const fechaInicioUltimaTanda = ultimaTanda.querySelector(`[id^="fecha_inicio_tanda_"]`).value;
        const fechaFinUltimaTanda = ultimaTanda.querySelector(`[id^="fecha_fin_tanda_"]`).value;

        // Verificar si ambos campos de la última tanda están completos
        if (!fechaInicioUltimaTanda || !fechaFinUltimaTanda) {
            Swal.fire({
                title: "Error en las fechas",
                text: "Por favor, complete las fechas de inicio y fin en la última tanda antes de agregar una nueva.",
                icon: "error",
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: "Cerrar"
            });
            return; // Detener la ejecución si no están completos
        }

        tandaCount++;

        const tandaContainer = document.createElement("div");
        tandaContainer.classList.add("tanda", "mb-3");
        tandaContainer.id = `tanda-${tandaCount}`;

        tandaContainer.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="nombre_tanda_${tandaCount}" class="form-label">Nombre de Tanda</label>
                <input type="text" class="form-control" id="nombre_tanda_${tandaCount}" name="nombre_tanda[]"
                    value="Tanda ${tandaCount}" readonly>
            </div>
            <div class="col-md-2">
                <label for="fecha_inicio_tanda_${tandaCount}" class="form-label">Fecha de Inicio *</label>
                <input type="datetime-local" class="form-control" id="fecha_inicio_tanda_${tandaCount}"
                    name="fecha_inicio_tanda[]" min="{{ $fechaHoraActual }}">
            </div>
            <div class="col-md-2">
                <label for="fecha_fin_tanda_${tandaCount}" class="form-label">Fecha de Fin *</label>
                <input type="datetime-local" class="form-control" id="fecha_fin_tanda_${tandaCount}" name="fecha_fin_tanda[]" min="{{ $fechaHoraActual }}">
            </div>
            <div class="col-md-3">
                <label for="cupo_tanda_${tandaCount}" class="form-label">Cupo/tickets *</label>
                <input type="number" class="form-control ticket-input" id="cupo_tanda_${tandaCount}" name="cupo_tanda[]"
                    placeholder="Ejemplo: 50" min="1" value="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm eliminarTanda ri-delete-bin-line"></button>
            </div>
        </div>`;

        document.getElementById("tandasContainer").appendChild(tandaContainer);

        // Asignar evento para eliminar la tanda
        tandaContainer.querySelector(".eliminarTanda").addEventListener("click", function () {
            document.getElementById("agregarTanda").disabled = false;
            tandaContainer.remove();
            tandaCount--;
            checkFechaInicioFinTandas();
            actualizarNombresDeTandas();
            checkDistribution();
        });

        // Deshabilitar el botón si se llegó al límite de tandas
        if (tandaCount >= maxInputsTandas) {
            document.getElementById("agregarTanda").disabled = true;
        } 
        
        //comprueba tickets ingresados
        checkDistribution();

        //comprueba fecha inicio-fin de cada tanda
        checkFechaInicioFinTandas();

        // Llamada para ajustar las fechas dinámicas
        ajustarFechasTandas();
    });

    checkDistribution();

});// fin creacion tandas

