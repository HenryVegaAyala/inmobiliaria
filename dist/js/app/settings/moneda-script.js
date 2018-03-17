$(function () {
    
    //document.oncontextmenu = function() {return false;};

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

    $('#txtSearch').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            event.preventDefault();
            $('#txtSearch').focus();
            MostrarDatos();
            return false;
        }
    });
    
    $('#txtNombre').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#txtSimbolo').focus();
            return false;
        }
    });

    $('#txtSimbolo').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnGuardar').focus();
            return false;
        }
    });
    
    $('#btnSearchMoneda').on('click', function(event) {
        event.preventDefault();
        MostrarDatos();
         $('#txtSearch').focus();
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

//    $('#btnEliminar').on('click', function(event) {
//        event.preventDefault();
//        var elem = $('.listview a.selected');
//    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
        openCustomModal('#modalRegistro');
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnviarDatos
    });

    addValidForm();
    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtSimbolo').val('');
    $('#txtNombre').val('').focus();
}

function addValidForm () {
    $('#txtNombre').rules('add', {
        required: true,
        maxlength: 15
    });

    $('#txtSimbolo').rules('add', {
        required: true,
        maxlength: 5
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
        url: 'services/moneda/moneda-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            criterio: $('#txtSearch').val()
        }
    })
    .done(function(data) {
        var i = 0;
        var count = data.length;
        var strhtml = '';
        if (count > 0){
            for (i = 0; i < count; i++) {
                strhtml += '<a href="#" class="list dato" data-id="' + data[i].mon_idmoneda + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].mon_idmoneda + '" />';
                strhtml += '<div class="list-content"><div class="simbol"><span>';
                strhtml += data[i].mon_simbolo;
                strhtml += '</div>';
                strhtml += '<div class="data">';
                strhtml += '<h2>' + data[i].mon_nombre + '</h2>';
                strhtml += '</div></div></a>';
            };
        }
        $('.listview').html(strhtml);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function EnviarDatos (form) {
    $.ajax({
        type: "POST",
        url: 'services/moneda/moneda-post.php',
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
    //console.log($('.listview a.selected'));
    var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminar=btnEliminar';
    precargaExp('.page-region', true);
    $.ajax({
        type: "POST",
        url: 'services/moneda/moneda-post.php',
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
        url: 'services/moneda/moneda-search.php',
        type: 'GET',
        dataType: 'json',
        data: {id: idData}
    })
    .done(function(data) {
        $('#hdIdPrimary').val(data[0].mon_idmoneda);
        $('#txtNombre').val(data[0].mon_nombre);
        $('#txtSimbolo').val(data[0].mon_simbolo);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

}