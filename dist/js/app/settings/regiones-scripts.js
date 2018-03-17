$(function () {
    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnLimpiar').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
    });

    $('#btnEliminar').on('click', function () {
        Eliminar();
        return false;
    });

    $('#txtNombre').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnGuardar').focus();
            return false;
        }
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        limpiarSeleccionados();
        $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
        $('#btnNuevo').removeClass('oculto');
    });

    $('#btnEditar').on('click', function(event) {
        var id = $('.listview a.list.selected').attr('data-id');
        event.preventDefault();
        openCustomModal('#modalRegistro');
        GetDataById(id);
    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
        openCustomModal('#modalRegistro');
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: Guardar
    });

    $('#gvDatos').on('click', '.dato', function(event) {
            var checkBox = $(this).find('input:checkbox');
            event.preventDefault();
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvDatos .dato.selected').length == 0){
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                }
                else {
                    if ($('#gvDatos .dato.selected').length == 1){
                        $('#btnLimpiarSeleccion, #btnEditar').removeClass('oculto');
                    }
                }
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevo, #btnUploadExcel').addClass('oculto');
                $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnEditar').removeClass('oculto');
                }
                else {
                    $('#btnEditar').addClass('oculto');
                }
            }
        });

    addValidForm();
    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtCodigo').val('');
    $('#txtCoordenadas').val('');
    $('#txtNombre').val('').focus();
}

function addValidForm () {
    $('#txtNombre').rules('add', {
        required: true,
        maxlength: 150
    });
    $('#txtCodigo').rules('add', {
        maxlength: 10
    });
    $('#txtCoordenadas').rules('add', {
        maxlength: 150
    });
}

function GuardarDatos () {
    $('#form1').submit();
}

function limpiarSeleccionados () {
    $('.listview .selected').removeClass('selected');
    $('.listview .list input:checkbox').removeAttr('checked');
}

function MostrarDatos () {
    $.ajax({
        url: 'services/regiones/regiones-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            criterio: ''
        }
    })
    .done(function(data) {
        var i = 0;
        var count = 0;
        var strhtml = '';

        count = data.length;
        
        if (count > 0){
            for (i = 0; i < count; i++) {
                strhtml += '<a href="#" class="list dato" data-id="' + data[i].tm_idregion + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idregion + '" />';
                strhtml += '<div class="list-content">';
                strhtml += '<div class="data">';
                strhtml += '<h2>' + data[i].tm_nombre + '</h2>';
                strhtml += '</div></div></a>';
            };
        };

        $('.listview').html(strhtml);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function Guardar (form) {
    $.ajax({
        type: "POST",
        url: 'services/regiones/regiones-post.php',
        cache: false,
        dataType: 'json',
        data: $(form).serialize() + "&btnGuardar=btnGuardar"
    })
    .done(function(data) {
        MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
            if (Number(data.rpta) > 0){
                resetForm('form1');
                closeCustomModal('#modalRegistro');
                $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                $('#btnNuevo').removeClass('oculto');
                limpiarSeleccionados();
                MostrarDatos();
            };
        });
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function Eliminar () {
    var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminar=btnEliminar';
    precargaExp('.page-region', true);
    $.ajax({
        type: "POST",
        url: 'services/regiones/regiones-post.php',
        cache: false,
        dataType: 'json',
        data: serializedReturn,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (Number(data.rpta) > 0){
                    closeCustomModal('#modalRegistro');
                    $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                    $('#btnNuevo').removeClass('oculto');
                    limpiarSeleccionados();
                    MostrarDatos();
                };
            });
        }
    });
}

function GetDataById (idData) {
    $.ajax({
        url: 'services/regiones/regiones-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            id: idData
        }
    })
    .done(function(data) {
        $('#hdIdPrimary').val(data[0].tm_idregion);
        $('#txtNombre').val(data[0].tm_nombre);
        $('#txtCoordenadas').val(data[0].tm_coordgmaps);
        $('#txtCodigo').val(data[0].tm_codigo);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

