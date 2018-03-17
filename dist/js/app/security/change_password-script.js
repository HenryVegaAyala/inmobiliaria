$(function () {
    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate
    });

    addValidFormRegister();

	$('#password_modal_save').on('click', function(event) {
		event.preventDefault();
		CambiarClave();
	});
});

function addValidFormRegister () {
    $('#current_password').rules('add', {
        required : true
    });

    $('#new_password').rules('add', {
        required : true
    });

    $('#confirm_password').rules('add', {
        required : true
    });
}

function LimpiarForm () {
	$('#current_password').val('');
	$('#new_password').val('');
    $('#confirm_password').val('');
}

function CambiarClave () {
    if ($('#form1').valid()){
        var data = new FormData();
        var input_data = $('#form1 :input').serializeArray();

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });

        precargaExp('#form1', true);
    
        $.ajax({
            type: "POST",
            url: "services/usuarios/changepassword-post.php",
            contentType:false,
            processData:false,
            cache: false,
            dataType: 'json',
            data: data,
            success: function(data){
                precargaExp('#form1', false);

                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (data.rpta != '0'){
                    	LimpiarForm();
                    	$('#current_password').focus();
                    };
                });
            },
            error:function (data){
                console.log(data);
            }
        });
    };
}