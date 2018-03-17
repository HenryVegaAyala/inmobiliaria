$(function () {
	getPropietario($('#hdIdPersona').val());

    $('#ddlProyecto').on('change', function(event) {
        event.preventDefault();
        
        var today = new Date();
        var yyyy = today.getFullYear();
        
        ListarAnhoProceso(yyyy);
    });

    $('#ddlAnho').on('change', function(event) {
        event.preventDefault();

        paginaGenFacturacion = 1;
        ListarPropiedades('1');
    });

    $('#ddlMes').on('change', function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarPropiedades('1');
    });
});

function getPropietario (idpropietario) {
	$.ajax({
        url: 'services/propietario/propietario-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            id: idpropietario
        }
    })
    .done(function(data) {
        var countdata = 0;
        countdata = data.length;

        if (countdata > 0){
            var foto = data[0].tm_foto;
            var nombrepersona = data[0].descripcion;

            $('#pnlInfoPersona').attr({
		        'data-idpersona': $('#hdIdPersona').val(),
		        'data-hint': nombrepersona
		    });

		    // $('#pnlInfoPersona' + ' .foto').html(foto);
		    $('#pnlInfoPersona' + ' .info .descripcion').text(nombrepersona);
            // $('#hdIdPrimary').val(data[0].tm_idtipopropietario);
            // $('#hdCodigoOri').val(data[0].tm_codigo_ori);
            // $('#hdTipoPropietario').val(data[0].tm_iditc);

            // SetTabByDefault(data[0].tm_iditc);

            // if (data[0].tm_iditc == 'NA'){
            //     $('#ddlTipoDocNatural').val(data[0].tm_iddocident);
            //     $('#txtNroDocNatural').val(data[0].tm_numerodoc);
            //     $('#txtDireccionNatural').val(data[0].tm_direccion);
            //     $('#txtTelefonoNatural').val(data[0].tm_telefono);
            //     $('#txtApePaterno').val(data[0].tm_apepaterno);
            //     $('#txtApeMaterno').val(data[0].tm_apematerno);
            //     $('#txtNombres').val(data[0].tm_nombres);
            //     $('#txtEmailNatural').val(data[0].tm_email);
            //     $('#hdIdUbigeoNatural').val(data[0].tm_idubigeo);
            // }
            // else {
            //     $('#ddlTipoDocJuridica').val(data[0].tm_iddocident);
            //     $('#txtRucEmpresa').val(data[0].tm_numerodoc);
            //     $('#txtRazonSocial').val(data[0].tm_razsocial);
            //     $('#txtEmailEmpresa').val(data[0].tm_email);
            //     $('#txtRepresentante').val(data[0].tm_representante);
            //     $('#txtDireccionEmpresa').val(data[0].tm_direccion);
            //     $('#txtTelefonoEmpresa').val(data[0].tm_telefono);
            //     $('#txtWebEmpresa').val(data[0].tm_urlweb);
            //     $('#hdIdUbigeoJuridico').val(data[0].tm_idubigeo);
            //     $('#chkEsConstructora')[0].checked = data[0].tm_esconstructora == '1' ? true : false;

            //     //ContactoEmpListar(data[0].tm_codigo_ori);
            // };

            // setUbigeo(data[0].tm_idubigeo, data[0].ubigeo);

            // clearImagenForm();
            
            if (foto != 'no-set'){
                $('#imgFoto').attr({
                    'src': data[0].tm_foto
                });
            };
            
            // $('#hdFoto').val(foto);
        };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}