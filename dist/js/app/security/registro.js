$(function () {
	$('#fileUploadImage').change(function(){
        var file;
        var filename = '';
        var filesize = '';
        var filetype = '';
        var oFReader = new FileReader();
        
        file = this.files[0];

        oFReader.readAsDataURL(file);

        filename = file.name;
        filesize = file.size;
        filetype = file.type;

        oFReader.onload = function (oFREvent) {
            $('#imgFoto').attr('src', oFREvent.target.result);
            $('#hdFoto').val(filename);
            $('#btnResetImage').removeClass('oculto');
        };
    });

    $('#btnResetImage').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#imgFoto').attr('src', $('#imgFoto').attr('data-src'));
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });

    addValidFormRegister();
});

function EnvioAdminDatos (form) {
	habilitarControl('#btnGuardar', false);

    var inputFileImage = document.getElementById('fileUploadImage');
    var file = inputFileImage.files[0];
    var data = new FormData();
    var input_data = $('#form1 :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');
    data.append('archivo', file);

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/usuarios/registro-post.php',
        cache: false,
        contentType:false,
        processData:false,
        dataType: 'json',
        data: data,
        success: function(data){
            if (data.rpta == '0')
            	window.location = 'cancel.php';
            else
            	window.location = 'confirm.php';
        }
    });
}

function addValidFormRegister () {
	$('#txtNombre').rules('add', {
    	required: true,
        maxlength: 50
    });

    $('#txtNumeroDoc').rules('add', {
    	required: true,
        maxlength: 10
    });

    $('#txtNombres').rules('add', {
    	required: true,
        maxlength: 200
    });

    $('#txtApellidos').rules('add', {
    	required: true,
        maxlength: 200
    });

    $('#txtClave').rules('add', {
    	required: true,
        maxlength: 32
    });

    $('#txtConfirmClave').rules('add', {
    	required: true,
    	equalTo: "#txtClave",
        maxlength: 32
    });

    $('#txtEmail').rules('add', {
    	required: true,
        email: true,
        maxlength: 100
    });
}