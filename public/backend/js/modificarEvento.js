$(document).ready(function() {
    const $selectPaises = $("#selectPaises");
    const $selectProvincias = $("#selectProvincias");
    const $selectLocalidades = $("#selectLocalidades");

    function loadProvincias(paisId, callback = null) {
        $.ajax({
            url: `/editarEvento/provincias/${paisId}`,
            method: "GET",
            success: function(json) {
                let $options = `<option value="">Selecciona la provincia</option>`;

                json.provincias.forEach(function(el) {
                    $options += `<option value="${el.id}">${el.name}</option>`;
                });

                $selectProvincias.html($options);
                $selectProvincias.prop('disabled', false);
                
                if (callback) callback();
            },
            error: function(jqXHR) {
                let message = jqXHR.statusText || "Ocurrió un error";
                console.error(`Error loading provincias: ${jqXHR.status}: ${message}`);
            }
        });
    }

    function loadLocalidades(provinciaId, callback = null) {
        $.ajax({
            url: `/editarEvento/localidades/${provinciaId}`,
            method: "GET",
            success: function(json) {
                let $options = `<option value="">Selecciona la localidad</option>`;

                json.localidades.forEach(function(el) {
                    $options += `<option value="${el.id}">${el.name}</option>`;
                });

                $selectLocalidades.html($options);
                $selectLocalidades.prop('disabled', false);
                
                if (callback) callback();
            },
            error: function(jqXHR) {
                let message = jqXHR.statusText || "Ocurrió un error";
                console.error(`Error loading localidades: ${jqXHR.status}: ${message}`);
            }
        });
    }

    // Event listeners
    $selectPaises.change(function() {
        const paisId = $(this).val();
        if (paisId) {
            loadProvincias(paisId, function() {
                $selectLocalidades.html('<option value="">Selecciona la localidad</option>');
                $selectLocalidades.prop('disabled', true);
            });
        } else {
            $selectProvincias.html('<option value="">Selecciona la provincia</option>');
            $selectProvincias.prop('disabled', true);
            $selectLocalidades.html('<option value="">Selecciona la localidad</option>');
            $selectLocalidades.prop('disabled', true);
        }
    });

    $selectProvincias.change(function() {
        const provinciaId = $(this).val();
        if (provinciaId) {
            loadLocalidades(provinciaId);
        } else {
            $selectLocalidades.html('<option value="">Selecciona la localidad</option>');
            $selectLocalidades.prop('disabled', true);
        }
    });

    // Initial load
    const initialPaisId = $selectPaises.val();
    const initialProvinciaId = $selectProvincias.find('option:selected').val();
    const initialLocalidadId = $selectLocalidades.find('option:selected').val();

    if (initialPaisId) {
        loadProvincias(initialPaisId, function() {
            $selectProvincias.val(initialProvinciaId);
            if (initialProvinciaId) {
                loadLocalidades(initialProvinciaId, function() {
                    $selectLocalidades.val(initialLocalidadId);
                });
            }
        });
    }
});