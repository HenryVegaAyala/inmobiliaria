$(function () {
    var screenmode = getParameterByName('screenmode');

    if (screenmode == 'search'){
        $('#btnSelectAll').addClass('oculto');

        $('#btnSelectOne').on('click', function(event) {
            event.preventDefault();
            SeleccionarPropietario();
        });
        ListarPropietarios('1');
    }
    else if (screenmode == 'propietario') {
        // var tipobusqueda = '3';
        // var idrecord = $('#hdIdPropietarioUser').val();

        // GetEdit(tipobusqueda, idrecord);
        SetTabByDefault($('#hdTipoPropietario').val());
    }
    else {
        $('#btnSelectOne').addClass('oculto');
        ListarPropietarios('1');
    };    
    
    $('#btnCustomBack').on('click', function(event) {
        event.preventDefault();
        
        if (screenmode == 'search') {
            window.parent.closePanelPropietario();
        }
        else {
            window.top.showDesktop();
        };
    });

    $('#pnlForm > .title-window').on('click', 'button', function(event) {
        event.preventDefault();
        var targedId = $(this).attr('data-target');
        var TipoPropietario = $(this).attr('data-tipopropietario');

        $(this).siblings('.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        $('#pnlForm > .divContent section.tab-principal').hide();
        $(targedId).show();
        $('#hdTipoPropietario').val(TipoPropietario);
    });

    $('#txtSearchPropietario').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchPropietario').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchPropietario').on('click', function(event) {
        event.preventDefault();
        $('#btnLimpiarSeleccion').trigger('click');
        paginaPropietario = 1;
        ListarPropietarios('1');
    });

    $('#gvDatos').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var checkBox = $(this).find('input:checkbox');
        
        if (screenmode == 'search'){
            $('#gvDatos input:checkbox').removeAttr('checked');
            $(this).siblings('.selected').removeClass('selected');
            $(this).addClass('selected');

            checkBox.attr('checked', '');
            $('#btnSelectOne').removeClass('oculto');
        }
        else {
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvDatos .dato.selected').length == 0){
                    $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnDetalleFromList, #btnSendMail, #btnEliminar').addClass('oculto');
                }
                else {
                    if ($('#gvDatos .dato.selected').length == 1){
                        $('#btnLimpiarSeleccion, #btnEditar, #btnDetalleFromList').removeClass('oculto');
                    };
                };
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevo, #btnUploadExcel').addClass('oculto');
                $('#btnLimpiarSeleccion, #btnEliminar, #btnSendMail').removeClass('oculto');
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnEditar, #btnDetalleFromList').removeClass('oculto');
                }
                else {
                    $('#btnEditar, #btnDetalleFromList').addClass('oculto');
                };
            };
        };
    });

    $('#btnDetalleFromList').on('click', function(event) {
        event.preventDefault();
        GoToDetalle();
    });

    $('#btnSendMail').on('click', function(event) {
        event.preventDefault();
        
        var lista_correos = $('#gvDatos .selected').map(function() {
            return this.getAttribute('data-email');
        }).get().join(';');

        // var lista_correos = $('#gvDatos .selected').attr('data-email');
        openModalCallBack('#modalEmail', function () {
            $('#ifrEmail').attr('src', 'index.php?pag=admin&subpag=email&para=' + lista_correos);
        });
    });

    $('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        LimpiarForm();
        GoToEdit();
    });

    $('#btnBackToListFromForm').add('#btnBackToListFromDetalle').on('click', function (event) {
        event.preventDefault();
        if ($(this).attr('id') == 'btnBackToListFromForm'){
            $('#pnlForm').fadeOut(400, function() {
                $('#pnlListado').fadeIn(400, function() {
                    
                });
            });
        }
        else {
            $('#pnlDetalle').fadeOut(400, function() {
                $('#pnlListado').fadeIn(400, function() {
                    
                });
            });
        };
        
        if (screenmode != 'search'){
            $('#btnLimpiarSeleccion').trigger('click');
        };
    });

    $('#btnCancelar').on('click', function (event) {
        event.preventDefault();
        closeCustomModal('#modalRegistro');
    });

    $('#btnNuevoDetalle').on('click', function(event) {
        event.preventDefault();
        MostrarModalPorTab();
    });

    $('#pnlInfoUbigeoNatural').add('#pnlInfoUbigeoEmpresa').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalUbigeo', function () {
            //ListarUbigeo();
            precargaExp('#modalUbigeo', true);
            
            ListarUbicacion('#ddlDepartamento', '1', '0', function () {
                ListarUbicacion('#ddlProvincia', $('#ddlDepartamento').val(), '0', function () {
                    ListarUbicacion('#ddlDistrito', $('#ddlProvincia').val(), '0', function () {
                        precargaExp('#modalUbigeo', false);
                    });
                });
            });
        });
    });

    $('#ddlDepartamento').on('change', function(event) {
        event.preventDefault();
        precargaExp('#modalUbigeo', true);

        ListarUbicacion('#ddlProvincia', $(this).val(), '0', function () {
            ListarUbicacion('#ddlDistrito', $('#ddlProvincia').val(), '0', function () {
                precargaExp('#modalUbigeo', false);
            });
        });
    });

    $('#ddlProvincia').on('change', function(event) {
        event.preventDefault();
        precargaExp('#modalUbigeo', true);

        ListarUbicacion('#ddlDistrito', $(this).val(), '0', function () {
            precargaExp('#modalUbigeo', false);
        });
    });

    $('#btnAplicarUbigeo').on('click', function(event) {
        event.preventDefault();
        var idubigeo = '0';
        var descripcion = '';

        idubigeo = $('#ddlDistrito').val();
        descripcion = 'Perú/'  + $('#ddlDepartamento option:selected').text() + '/' + $('#ddlProvincia option:selected').text() + '/' + $('#ddlDistrito option:selected').text()
        
        setUbigeo(idubigeo, descripcion);
    });

    $('#pnlInfoUbigeoContacto').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalUbigeo', function () {
            
        });
    });

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

    $('#gvUbigeo').on('click', '.panel-info', function(event) {
        event.preventDefault();
        var idubigeo = '0';
        var nombre = '';
        var seletor = '';

        idubigeo = $(this).attr('data-idubigeo');
        nombre = $(this).find('.descripcion').text();

        setUbigeo(idubigeo, nombre);
    });

    $('#txtSearchUbigeo').on('keyup', function(event) {
        ListarUbigeo();
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });

    $('#btnGuardar').on('click', function (evt) {
        $('#hdLegal').val('LEGAL');
        GuardarDatos();
    });

    $('#btnAceptarTerminos').on('click', function (evt) {
        $('#hdLegal').val('');
        GuardarDatos();
    });    

    $('#btnEliminar').on('click', function(event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarPropietario();
        };
    });

    $('#btnHideConstructora').on('click', function(event) {
        event.preventDefault();
        $('#pnlConstructora').fadeOut(400, function() {
            
        });
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#hdIdPrimary').val('0');
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnSendMail, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#gvDatos > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropietario').val());

            ListarPropietarios(paginaActual);
        };
    });

    // $("#tabDetalle").tabcontrol().bind("tabcontrolchange", function(event, frame){
    //     ListarPropiedadesPorTipo();
    // });

    $('#btnUploadExcel').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalUploadExcel');
    });

    $('.droping-air .file-import').on({
        'dragenter': function (event) {
            event.stopPropagation();
            event.preventDefault();
        },
        'dragover': function (event) {
            event.stopPropagation();
            event.preventDefault();
        },
        'change': function(event) {
            event.preventDefault();

            prepareImport(this.files);
        },
        'drop': function (event) {
            event.preventDefault();
            var files = event.originalEvent.dataTransfer.files;

            prepareImport(files);
        }
    });

    $('#btnCancelarSubida').on('click', function(event) {
        event.preventDefault();
        cancelImport();
    });

    $('#btnSubirDatos').on('click', function(event) {
        event.preventDefault();
        executeImport();
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDatos .dato').addClass('selected');
        $('#gvDatos input:checkbox').attr('checked', '');
        $('#btnNuevo, #btnDetalleFromList, #btnSendMail, #btnUploadExcel, #btnEditar').addClass('oculto');
        $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
    });
});

var indexList = 0;
var elemsSelected;
var fileValue = false;
var progress = 0;
var progressError = false;
var progressSuccess = false;
var paginaPropietario = 1;

function ListarPropietarios (pagina) {
    var selector = '#gvDatos .items-area';

    precargaExp('#gvDatos', true);
    
    $.ajax({
        type: "GET",
        url: "services/propietario/propietario-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + encodeURIComponent($('#txtSearchPropietario').val()) + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var screenmode = '';
            var bgtiporelacion = '';

            screenmode = getParameterByName('screenmode');
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].tm_idtipopropietario;
                    foto = data[i].tm_foto;
                    strhtml += '<a href="#" class="list dato bg-gray-glass bg-cyan" data-idpropietario="' + iditem + '" data-tipopropietario="' + data[i].tm_iditc + '" data-email="' + data[i].tm_email + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';

                    /*if (data[i].tm_idcanal == 1)
                        bgtiporelacion = 'bg-green';
                    else
                        bgtiporelacion = 'bg-darkCyan';*/
                    
                    strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-top-right padding5 margin5">UBIGEO: ' + data[i].ubigeo + '</span>';

                    strhtml += '<div class="data">';
                    strhtml += '<aside>';

                    if (foto == 'no-set')
                        strhtml += '<i class="fa fa-user"></i>';
                    else
                        strhtml += '<img src="' + foto + '" />';
                    
                    strhtml += '</aside>';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].descripcion + '</span></p><p class="fg-white">Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].tipodoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                }

                paginaPropietario = paginaPropietario + 1;

                $('#hdPagePropietario').val(paginaPropietario);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                if (screenmode == 'search'){
                    $('#btnSelectAll').addClass('oculto');
                    $(selector).find('.dato').eq(0).trigger('click');
                }
                else {
                    $('#btnSelectAll').removeClass('oculto');
                };
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No hay datos.</h2>');
                    
                    if (screenmode == 'search'){
                        $('#btnSelectOne').addClass('oculto');
                    };
                };
            };
            
            precargaExp('#gvDatos', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarPropiedadesPorTipo () {
    var idpropietario = '0';
    var idtipopropiedad = '';
    
    idpropietario = $('#gvDatos .dato.selected').attr('data-idpropietario');
    idtipopropiedad = $('#tabDetalle li.active').attr('data-idtipopropiedad');
    
    $.ajax({
        url: 'services/propiedad/propiedad-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'propietario',
            idtipopropiedad: idtipopropiedad,
            id: idpropietario
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selector = '';

            countdata = data.length;

            if (idtipopropiedad == 'DPT'){
                selector = '#tableDepartamento .ibody tbody';
            }
            else if (idtipopropiedad == 'DEP'){
                selector = '#tableDeposito .ibody tbody';
            }
            else if (idtipopropiedad == 'EST'){
                selector = '#tableEstacionamiento .ibody tbody';
            };

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr class="' + data[i].colorestado + '">';
                    strhtml += '<td>' + data[i].nombreproyecto + '</td>';
                    strhtml += '<td>' + data[i].propiedad + '</td>';
                    strhtml += '<td>' + data[i].areapropiedad + '</td>';
                    strhtml += '<td>' + data[i].estado + '</td>';
                    strhtml += '</tr>';
                    ++i;
                }
            };

            $(selector).html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function SeleccionarPropietario () {
    var propietario;
    var idpropietario = '0';
    var descripcion = '';

    propietario = $('#gvDatos .dato.selected');

    idpropietario = propietario[0].getAttribute('data-idpropietario');
    descripcion = propietario.find('.descripcion').text();

    window.parent.setPropietario(idpropietario, descripcion);
}

function prepareImport (files) {
    var allowedTypes = ['xls','xlsx'];
    var extension = '';
    var filename = '';

    fileValue = files[0]; 
    filename = files[0].name;
    extension = filename.split('.').pop().toLowerCase();

    if($.inArray(extension, allowedTypes) == -1) {
        MessageBox('Extensi&oacute;n no v&aacute;lida', 'El tipo de archivo no es compatible para la importaci&oacute;n', "[Aceptar]", function () {

        });
        return false;
    };

    $('.droping-air .help').text(filename);
    $('.droping-air').addClass('dropped');

    habilitarControl('#btnSubirDatos', true);
    $('#btnSubirDatos').addClass('success');
}

function cancelImport () {
    var pbMetro;

    pbMetro = $('.progress-bar').progressbar();
    
    $('.droping-air .help').text('Seleccione o arrastre un archivo de Excel');
    $('.droping-air').removeClass('dropped');

    habilitarControl('#btnSubirDatos', false);
    $('#btnSubirDatos').removeClass('success');

    $('.droping-air .file-import').val('');

    pbMetro.progressbar('value', 0);
    pbMetro.progressbar('color', 'bg-cyan');

    fileValue = false;
}

function executeImport () {
    var pbMetro;
    var file = fileValue;
    var data = new FormData();
    var intervalProgress;

    pbMetro = $('.progress-bar').progressbar();

    intervalProgress = new Interval(function(){
        pbMetro.progressbar('value', (++progress));
        if (progress == 100){
            intervalProgress.stop();
            if (progressSuccess)
                intervalProgress.start();
        };
    }, 100);

    pbMetro.progressbar('value', '0');
    pbMetro.progressbar('color', 'bg-cyan');

    data.append('btnSubirDatos', 'btnSubirDatos');
    data.append('archivo', file);

    $.ajax({
        type: "POST",
        url: "services/propietario/propietario-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            progressError = false;
            if (data.rpta != '0')
                progressSuccess = true;
            
            pbMetro.progressbar('value', 100);
            pbMetro.progressbar('color', 'bg-green');

            if (intervalProgress.isRunning())
                intervalProgress.stop();
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    closeCustomModal('#modalUploadExcel');
                    cancelImport();
                    paginaPropietario = 1;
                    ListarPropietarios('1');
                };
            });
        },
        beforeSend: function () {
            intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                setTimeout(function () {
                    if (intervalProgress.isRunning())
                        intervalProgress.stop();
                    pbMetro.progressbar('value', 100);
                    executeImport();
                }, 10000);
            };
        },
        error:function (data){
            progress = 0;
            pbMetro.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function SetTabByDefault(tipopropietario){
    var buttoncli = '';
    var targedId = '';

    if (tipopropietario == 'NA')
        targedId = '#tab1';
    else
        targedId = '#tab2';
    
    buttoncli = '[data-tipopropietario="' + tipopropietario + '"]';

    $('#pnlForm > .title-window .btn').removeClass('btn-success');
    $('#pnlForm > .title-window .btn' + buttoncli).addClass('btn-success');

    $('#pnlForm > .divContent section.tab-principal').hide();
    $(targedId).show();
}

function setUbigeo (idubigeo, descripcion) {
    var selector = '';
    var selectorHidden = '';
    var TipoPropietario = $('#pnlForm > .title-window .btn.btn-success').attr('data-tipopropietario');

    if (TipoPropietario == 'NA'){
        selector = '#pnlInfoUbigeoNatural';
        selectorHidden = '#hdIdUbigeoNatural';
    }
    else {
        selector = '#pnlInfoUbigeoEmpresa';
        selectorHidden = '#hdIdUbigeoJuridico';
    };

    $(selector).attr('data-idubigeo', idubigeo);
    $(selector + ' .info .descripcion').text(descripcion);

    $(selectorHidden).val(idubigeo);
    closeCustomModal('#modalUbigeo');
}

function ListarUbigeo () {
    $.ajax({
        url: 'services/ubigeo/ubigeo-autocomplete.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            criterio: $('#txtSearchUbigeo').val()
        }
    })
    .done(function(data) {
        var countdata = 0;
        var i = 0;
        var strhtml = '';

        countdata = data.length;

        if (countdata > 0){
            while(i < countdata){
                strhtml += '<div data-idubigeo="' + data[i].tm_idubigeo + '" title="' + data[i].ubigeo + '" class="panel-info without-foto">';
                strhtml += '<div class="info">';
                strhtml += '<h3 class="descripcion">' + data[i].ubigeo + '</h3>';
                strhtml += '</div>';
                strhtml += '</div>';
                ++i;
            };
        }
        else {
            strhtml = '<h2>No hay datos.</h2>';
        };

        $('#gvUbigeo').html(strhtml);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function clearImagenForm () {
    $('#fileUploadImage').replaceWith( $('#fileUploadImage').val('').clone( true ) );
    $('#imgFoto').attr({
        'src': 'dist/img/user-nosetimg-233.jpg',
        'data-src': 'dist/img/user-nosetimg-233.jpg'
    });
    $('#btnResetImage').addClass('oculto');
}

function addValidPersonaNatural () {
    $('#txtNroDocNatural').rules('add', {
        minlength: 8,
        digits: true
    });

    $('#txtApePaterno').rules('add', {
        required : true
    });

    $('#txtApeMaterno').rules('add', {
        required : true
    });

    $('#txtNombres').rules('add', {
        required : true
    });
}

function removeValidPersonaNatural () {
    $('#txtNroDocNatural').rules('remove');
    $('#txtApePaterno').rules('remove');
    $('#txtApeMaterno').rules('remove');
    $('#txtNombres').rules('remove');
}

function addValidPersonaJuridica () {
    $('#txtRucEmpresa').rules('add', {
        minlength: 11,
        digits: true
    });

    $('#txtRazonSocial').rules('add', {
        required : true
    });
}

function removeValidPersonaJuridica () {
    $('#txtRucEmpresa').rules('remove');
    $('#txtRazonSocial').rules('remove');
}

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#hdCodigoOri').val('0');
    $('#ddlTipoDocJuridica')[0].selectedIndex = 0;
    $('#txtRucEmpresa').val('');
    $('#txtRazonSocial').val('');
    $('#txtDireccionEmpresa').val('');
    $('#txtTelefonoEmpresa').val('');
    $('#txtEmailEmpresa').val('');
    $('#txtWebEmpresa').val('');
    $('#chkEsConstructora')[0].checked = false;
    $('#ddlTipoDocNatural')[0].selectedIndex = 0;
    $('#txtNroDocNatural').val('');
    $('#txtApePaterno').val('');
    $('#txtApeMaterno').val('');
    $('#txtNombres').val('');
    $('#txtDireccionNatural').val('');
    $('#txtTelefonoNatural').val('');
    $('#txtEmailNatural').val('');
    setUbigeo(0, 'Ubigeo');
}

function EnvioAdminDatos (form) {
    var screenmode = getParameterByName('screenmode');

    // if (screenmode == 'propietario') {
        
    // };

    var inputFileImage = document.getElementById('fileUploadImage');
    var file = inputFileImage.files[0];
    var data = new FormData();

    if ($('#hdTipoPropietario').val() == 'NA') {
        removeValidPersonaJuridica();
        addValidPersonaNatural();
        // if ($('#txtNroDocNatural').val().trim().length == 0){
        //     confirma = confirm('El nro de documento está vacio, ¿Desea continuar?');
        //     if (!confirma){
        //         return false;
        //     }
        // };
    }
    else {
        removeValidPersonaNatural();
        addValidPersonaJuridica();
        // if ($('#txtRucEmpresa').val().trim().length == 0){
        //     confirma = confirm('El campo de RUC está vacio, ¿Desea continuar?');
        //     if (!confirma){
        //         return false;
        //     }
        // };
    };

    if ($('#form1').valid()){
        data.append('btnGuardar', 'btnGuardar');
        data.append('hdLegal', $('#hdLegal').val());
        data.append('archivo', file);

        var input_data = $('#form1 :input').serializeArray();


        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: "services/propietario/propietario-post.php",
            contentType:false,
            processData:false,
            cache: false,
            dataType: 'json',
            data: data,
            complete: function (data) {
                if ( $('#hdTipoPropietario').val() == 'NA') {
                    removeValidPersonaNatural();
                }
                else {
                    removeValidPersonaJuridica();
                };
            },
            success: function(data){
                if (data.rpta == '0') {
                    if (data.titulomsje == 'ENTER-LEGAL')
                        openCustomModal('#modalCondiciones');
                    else
                        closeCustomModal('#modalCondiciones');
                }
                else {
                    MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                        closeCustomModal('#modalCondiciones');
                        
                        var screenmode = getParameterByName('screenmode');
                        if (screenmode != 'propietario') {
                            paginaPropietario = 1;
                            clearOnlyListSelection();
                            ListarPropietarios('1');
                            clearImagenForm();
                            BackToPrevPanel();
                            $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
                            $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                        };
                    });
                }
            },
            error:function (data){
                console.log(data);
            }
        });
    };
}

function GuardarDatos () {
    $('#form1').submit();
}

function MostrarModalPorTab () {
    var pestana;
    pestana = $('#tabDetalle .tabs li.active').attr('data-tab');
    
    if (pestana == 'Departamento') {
       openCustomModal('#modalDepartamento');   
    }
    else if (pestana == "Estacionamiento") {
       openCustomModal('#modalEstacionamiento');   
    }
    else if (pestana == "Deposito") {
       openCustomModal('#modalDeposito');   
    };
}

function GoToDetalle () {
    var persona;
    var idpersona = '0';
    var foto = '';
    var nombrepersona = '';

    persona = $('#gvDatos .dato.selected');

    idpersona = persona.attr('data-idpropietario');
    foto =  persona.find('.list-content aside').html();
    nombrepersona = persona.find('.list-content .descripcion').text();

    $('#hdIdPrimary').val(idpersona);

    $('#pnlInfoPersona').attr({
        'data-idpersona': idpersona,
        'data-hint': nombrepersona
    });

    $('#pnlInfoPersona' + ' .foto').html(foto);
    $('#pnlInfoPersona' + ' .info .descripcion').text(nombrepersona);

    $('#pnlListado').fadeOut(500, function () {
        $('#pnlDetalle').fadeIn(500, function () {
            ListarPropiedadesPorTipo();
        });
    });
}

function GoToEdit () {
    //precargaExp('body', true);
    var recordEdit = $('#gvDatos .list.selected');
    var idrecord = '0';
    var tipopropietario = 'NA';

    var screenmode = getParameterByName('screenmode');
    
    $('#hdIdPrimary').val('0');

    if (screenmode != 'search') {
        if (recordEdit.length > 0){
            tipobusqueda = '2';
            idrecord = recordEdit.attr('data-idpropietario');
            // tipopropietario = recordEdit.attr('data-tipopropietario');
            
            GetEdit (tipobusqueda, idrecord);
        };
    };

    $('#pnlListado').fadeOut(500, function () {
        $('#pnlForm').fadeIn(500, function () {

        });
    });
}

function GetEdit (tipobusqueda, idrecord) {    
    $.ajax({
        url: 'services/propietario/propietario-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            id: idrecord
        }
    })
    .done(function(data) {
        var countdata = 0;
        countdata = data.length;

        if (countdata > 0){
            foto = data[0].tm_foto;

            $('#hdIdPrimary').val(data[0].tm_idtipopropietario);
            $('#hdCodigoOri').val(data[0].tm_codigo_ori);
            $('#hdTipoPropietario').val(data[0].tm_iditc);

            SetTabByDefault(data[0].tm_iditc);

            if (data[0].tm_iditc == 'NA'){
                $('#ddlTipoDocNatural').val(data[0].tm_iddocident);
                $('#txtNroDocNatural').val(data[0].tm_numerodoc);
                $('#txtDireccionNatural').val(data[0].tm_direccion);
                $('#txtTelefonoNatural').val(data[0].tm_telefono);
                $('#txtApePaterno').val(data[0].tm_apepaterno);
                $('#txtApeMaterno').val(data[0].tm_apematerno);
                $('#txtNombres').val(data[0].tm_nombres);
                $('#txtEmailNatural').val(data[0].tm_email);
                $('#hdIdUbigeoNatural').val(data[0].tm_idubigeo);
            }
            else {
                $('#ddlTipoDocJuridica').val(data[0].tm_iddocident);
                $('#txtRucEmpresa').val(data[0].tm_numerodoc);
                $('#txtRazonSocial').val(data[0].tm_razsocial);
                $('#txtEmailEmpresa').val(data[0].tm_email);
                $('#txtRepresentante').val(data[0].tm_representante);
                $('#txtDireccionEmpresa').val(data[0].tm_direccion);
                $('#txtTelefonoEmpresa').val(data[0].tm_telefono);
                $('#txtWebEmpresa').val(data[0].tm_urlweb);
                $('#hdIdUbigeoJuridico').val(data[0].tm_idubigeo);
                $('#chkEsConstructora')[0].checked = data[0].tm_esconstructora == '1' ? true : false;

                //ContactoEmpListar(data[0].tm_codigo_ori);
            };

            setUbigeo(data[0].tm_idubigeo, data[0].ubigeo);

            clearImagenForm();
            
            if (foto != 'no-set'){
                $('#imgFoto').attr({
                    'src': data[0].tm_foto,
                    'data-src': data[0].tm_foto
                });
            };
            
            $('#hdFoto').val(foto);
        };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
/*
function EliminarDatos () {
    var data = new FormData();
    var input_data;

    input_data = $('#form1 .listview input:checkbox:checked').serializeArray();
    
    data.append('btnEliminar', 'btnEliminar');
    
    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/propietario/propietario-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            if (Number(data.rpta) > 0){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    $('.listview .list.selected').remove();
                    $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnSendMail, #btnEditar, #btnEliminar').addClass('oculto');

                    if ($('.listview .list').length == 0){
                        $('#txtSearchPropietario').val('');
                        paginaPropietario = 1;
                        ListarPropietarios('1');
                    };
                });
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}*/

function EliminarPropietario () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemPropietario(elemsSelected[0]);
}

function EliminarItemPropietario (item) {
    var data = new FormData();
    var idpropietario = '0';

    idpropietario = item.getAttribute('data-idpropietario');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPropietario', idpropietario);

    $.ajax({
        url: 'services/propietario/propietario-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollPropietarios;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El propietario ' + idpropietario + ': ' + $(item).find('.descripcion').text();
                
                if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' esta asignado a una propiedad.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollPropietarios = $('#gvDatos .listview');
                iScroll = scrollPropietarios.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollPropietarios.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemPropietario(elemsSelected[indexList]);
                    });
                }
                else {
                    MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                        $('#btnLimpiarSeleccion').trigger('click');
                    });
                };
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}
