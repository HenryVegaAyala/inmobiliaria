$(function  () {
    ListarInquilinos('1');

    $('#pnlForm > .title-window').on('click', 'button', function(event) {
        event.preventDefault();
        var targedId = $(this).attr('data-target');
        var TipoInquilino = $(this).attr('data-tipoinquilino');

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        $('#pnlForm > .divContent section.tab-principal').hide();
        $(targedId).show();
        $('#hdTipoInquilino').val(TipoInquilino);
    });

    $('#gvDatos').on('click', '.dato', function(event) {
        var checkBox = $(this).find('input:checkbox');
        event.preventDefault();
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvDatos .dato.selected').length == 0){
                $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEditar, #btnEliminar').addClass('oculto');
            }
            else {
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEditar').removeClass('oculto');
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnNuevo, #btnUploadExcel').addClass('oculto');
            $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEliminar').removeClass('oculto');
            if ($('#gvDatos .dato.selected').length == 1){
                $('#btnEditar').removeClass('oculto');
            }
            else {
                $('#btnEditar').addClass('oculto');
            };
        };
    });

    $('#btnDetalleFromList').on('click', function(event) {
        event.preventDefault();
        GoToDetalle();
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
        $('#btnLimpiarSeleccion').trigger('click');
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
        GuardarDatos();
    });

    $('#btnEliminar').on('click', function(event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarInquilino();
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
        $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#gvDatos > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageInquilino').val());

            ListarInquilinos(paginaActual);
        };
    });

    $("#tabDetalle").tabcontrol().bind("tabcontrolchange", function(event, frame){
        ListarPropiedadesPorTipo();
    });

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
});

var indexList = 0;
var elemsSelected;
var fileValue = false;
var progress = 0;
var progressError = false;
var progressSuccess = false;
var paginaInquilino = 1;

function ListarInquilinos (pagina) {
    var selector = '#gvDatos .items-area';

    precargaExp('#gvDatos', true);

    $.ajax({
        type: "GET",
        url: "services/inquilino/inquilino-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearch').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countDatos = data.length;
            var emptyMessage = '';
            var strhtml = '';
            var bgtiporelacion = '';

            if (countDatos > 0){
                while(i < countDatos){
                    iditem = data[i].tm_idtipoinquilino;
                    foto = data[i].tm_foto;
                    strhtml += '<a href="#" class="list dato bg-gray-glass bg-cyan" data-idinquilino="' + iditem + '" data-tipoinquilino="' + data[i].tm_iditc + '">';

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

                paginaInquilino = paginaInquilino + 1;

                $('#hdPageInquilino').val(paginaInquilino);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No hay datos.</h2>');
                };
            };
            
            precargaExp('#gvDatos', false);
        }
    });
}

function ListarPropiedadesPorTipo () {
    var idinquilino = '0';
    var idtipopropiedad = '';
    
    idinquilino = $('#gvDatos .dato.selected').attr('data-idinquilino');
    idtipopropiedad = $('#tabDetalle li.active').attr('data-idtipopropiedad');
    
    $.ajax({
        url: 'services/propiedad/propiedad-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'inquilino',
            idtipopropiedad: idtipopropiedad,
            id: idinquilino
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selector = '';

            countdata = data.length;

            if (idtipopropiedad == 'DPT')
                selector = '#tableDepartamento .ibody tbody';
            else if (idtipopropiedad == 'DEP')
                selector = '#tableDeposito .ibody tbody';
            else if (idtipopropiedad == 'EST')
                selector = '#tableEstacionamiento .ibody tbody';

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

function SetTabByDefault(tipoinquilino){
    var buttoncli = '';
    var targedId = '';

    if (tipoinquilino == 'NA')
        targedId = '#tab1';
    else
        targedId = '#tab2';
    
    buttoncli = '[data-tipoinquilino="' + tipoinquilino + '"]';

    $('#pnlForm > .title-window button').removeClass('success');
    $('#pnlForm > .title-window button' + buttoncli).addClass('success');

    $('#pnlForm > .divContent section.tab-principal').hide();
    $(targedId).show();
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
        url: "services/inquilino/inquilino-post.php",
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
                    paginaInquilino = 1;
                    ListarInquilinos('1');
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

function setUbigeo (idubigeo, descripcion) {
    var selector = '';
    var selectorHidden = '';
    var TipoInquilino = $('#pnlForm > .title-window button.success').attr('data-tipoinquilino');

    if (TipoInquilino == 'NA'){
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
        'src': 'images/user-nosetimg-233.jpg',
        'data-src': 'images/user-nosetimg-233.jpg'
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
    var inputFileImage = document.getElementById('fileUploadImage');
    var file = inputFileImage.files[0];
    var data = new FormData();
    
    if ($('#hdTipoInquilino').val() == 'NA') {
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
        data.append('archivo', file);

        var input_data = $('#form1 :input').serializeArray();

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: "services/inquilino/inquilino-post.php",
            contentType:false,
            processData:false,
            cache: false,
            dataType: 'json',
            data: data,
            complete: function (data) {
                if ( $('#hdTipoInquilino').val() == 'NA') {
                    removeValidPersonaNatural();
                }
                else {
                    removeValidPersonaJuridica();
                };
            },
            success: function(data){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (data.rpta != '0'){
                        paginaInquilino = 1;
                        clearOnlyListSelection();
                        ListarInquilinos('1');
                        clearImagenForm();
                        BackToPrevPanel();
                        $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                        $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                    };
                });
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

    idpersona = persona.attr('data-idinquilino');
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
    var tipoinquilino = 'NA';
    
    if (recordEdit.length > 0){
        idrecord = recordEdit.attr('data-idinquilino');
        tipoinquilino = recordEdit.attr('data-tipoinquilino');
        
        SetTabByDefault(tipoinquilino);
        
        $.ajax({
            url: 'services/inquilino/inquilino-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idrecord
            }
        })
        .done(function(data) {
            var countdata = 0;
            countdata = data.length;

            if (countdata > 0){
                foto = data[0].tm_foto;

                $('#hdIdPrimary').val(data[0].tm_idtipoinquilino);
                $('#hdCodigoOri').val(data[0].tm_codigo_ori);
                $('#hdTipoInquilino').val(data[0].tm_iditc);

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

                    //ContactoEmpListar(data[0].tm_codigo_ori);
                }

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
    };    

    $('#pnlListado').fadeOut(500, function () {
        $('#pnlForm').fadeIn(500, function () {

        });
    });
}

/*function EliminarDatos () {
    var data = new FormData();

    data.append('btnEliminar', 'btnEliminar');

    var input_data = $('#form1 .listview input:checkbox:checked').serializeArray();

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/inquilino/inquilino-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            if (Number(data.rpta) > 0){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    $('#hdPage').val('1');
                    $('#hdPageActual').val('1');
                    $('.listview .list.selected').remove();
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');

                    if ($('.listview .list').length == 0){
                        $('.listview').html('<h2>No hay datos.</h2>');
                    };
                });
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}*/


function EliminarInquilino () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemInquilino(elemsSelected[0]);
}

function EliminarItemInquilino (item) {
    var data = new FormData();
    var idinquilino = '0';

    idinquilino = item.getAttribute('data-idinquilino');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdInquilino', idinquilino);

    $.ajax({
        url: 'services/inquilino/inquilino-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollInquilinos;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El inquilino ' + idinquilino + ': ' + $(item).find('.descripcion').text();
                
                if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' esta asignado a una propiedad.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollInquilinos = $('#gvDatos .listview');
                iScroll = scrollInquilinos.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollInquilinos.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemInquilino(elemsSelected[indexList]);
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
