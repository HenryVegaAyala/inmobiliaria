 var TipoBusqueda = '00';

$(function () {
    // ListarPerfiles('FIELD');

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

    // $('#ulRedesGuia').on('click', 'li > a', function(event) {
    //     event.preventDefault();
    //     var idred = '0';

    //     idred = $(this).attr('data-idred');

    //     $('#ulRedesGuia li a.active').removeClass('active');
    //     $(this).addClass('active');

    //     ListarRedes('#ulSubRedesGuia', idred);
    // });

    // $('#ulSubRedesGuia').on('click', 'li > a', function(event) {
    //     event.preventDefault();
    //     var idred = '0';

    //     idred = $(this).attr('data-idred');

    //     $('#ulSubRedesGuia li a.active').removeClass('active');
    //     $(this).addClass('active');

    //     ListarRedes('#ulTiendasGuia', idred);
    // });

    // $('#ulTiendasGuia').on('click', 'li > a', function(event) {
    //     event.preventDefault();
    //     var idred = '0';
    //     var codigo = '';
    //     var descripcion = '';

    //     idred = $(this).attr('data-idred');
    //     codigo = $(this).attr('data-codigo');
    //     descripcion = $(this).find('h2').text();

    //     $('#ulTiendasGuia li a.active').removeClass('active');
    //     $(this).addClass('active');

    //     //$('#hdIdRedGuia').val(idred);

    //     setPersona(idred, codigo, descripcion);
    // });

    $('#gvPersona > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropietario').val());

            ListarPropietarios(paginaActual);
        };
    });

    $('#tablePerfil').on('click', 'input:checkbox', function(event) {
        $('#tablePerfil input:checkbox').removeAttr('checked');
        $(this)[0].checked = true;

        $('#hdIdPerfilUsuario').val($(this).val());
    });

    $('#pnlConfigMenu > .sectionHeader').on('click', 'button', function(event) {
        var countSelected = 0;
        var targetId = '';

        targetId = $(this).attr('data-target');

        $(this).siblings('.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        $('#pnlConfigMenu > .sectionContent > section').hide();

        if (targetId == '#tab1'){
            countSelected = $('#pnlUsuario .dato.selected').length;

            $('#btnAplicarPerfil').addClass('oculto');
            $('#btnNuevoPerfil, #btnEditarPerfil, #btnEliminarPerfil').addClass('oculto');

            if (countSelected > 0){
                if (countSelected == 1)
                    $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').removeClass('oculto');
                else
                    $('#btnEliminar, #btnLimpiarSeleccion').removeClass('oculto');
            }
            else
                $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
        }
        else if (targetId == '#tab2'){
            $('#btnAplicarPerfil').removeClass('oculto');
            if ($('#gvPerfil .tile').length > 0)
                $('#btnNuevoPerfil, #btnEditarPerfil, #btnEliminarPerfil').removeClass('oculto');
            
            $('#btnNuevo, #btnLimpiarSeleccion, #btnEditar, #btnEliminar, #btnUploadExcel').addClass('oculto');
        }
        $(targetId).show();
    });

    // $('#pnlConfigUser > .sectionHeader').on('click', 'button', function(event) {
    //     var countSelected = 0;
    //     var targetId = '';

    //     targetId = $(this).attr('data-target');

    //     $(this).siblings('.btn-success').removeClass('btn-success');
    //     $(this).addClass('btn-success');

    //     if (targetId == '#tabUser2'){
    //         if ($('#tablePerfil tbody tr').length == 0)
    //             ListarPerfiles('FIELD');
    //     }

    //     $('#pnlConfigUser > .sectionContent > section').hide();

    //     targetId = $(this).attr('data-target');
    //     $(targetId).show();
    // });

    $('#gvDatos').on('click', '.dato', function(event) {
        var checkBox = $(this).find('input:checkbox');
        event.preventDefault();
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvDatos .dato.selected').length == 0){
                $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
                $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
            }
            else {
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnLimpiarSeleccion, #btnEditar').removeClass('oculto');
                };
            };
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
            };
        };
    });

    $('#pnlPersona > .sectionHeader').on('click', 'button', function(event) {
        var tipodata = '';

        tipodata = $(this).attr('data-tipodata');

        $('#hdTipoDataPersona').val(tipodata);
        
        $(this).siblings('.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        if (tipodata == '02'){
            $('#tabPersona1').hide();
            $('#tabPersona2').show();
            ListarRedes('#ulRedesGuia', '0');
        }
        else {
            $('#tabPersona2').hide();
            $('#tabPersona1').show();
            BuscarPersona('1');
        };
    });

    $('.borrar-persona').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        $('#hdIdPersona').val('0');
        $('#hdTipoDataPersona').val('00');

        $('#pnlInfoPersonal').attr('data-idpersona', '0');
        $('#pnlInfoPersonal .descripcion').text('Elegir persona...');

        $(this).addClass('hide');
    });

    $('#gvPersona .items-area').on('click', '.list', function(event) {
        var idpersona = '0',
            nrodoc = '',
            descripcion = '';

        event.preventDefault();
        
        idpersona = $(this).attr('data-idpropietario');
        // nrodoc = $(this).find('main p .docidentidad').text();
        descripcion = $(this).find('main p .descripcion').text();

        setPersona(idpersona, descripcion, this);
    });

    $('#pnlInfoPersonal').on('click', function(event) {
        event.preventDefault();
        ShowPanelPersona();
    });

    $('#btnExitPersona').on('click', function(event) {
        event.preventDefault();
        $('#pnlSearchPersona').fadeOut(400);
    });

    $('.borrar-proyecto').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        $('#hdIdProyecto').val('0');

        $('#pnlInfoProyecto__Usuario').attr('data-idproyecto', '0');
        $('#pnlInfoProyecto__Usuario .descripcion').text('Elegir proyecto...');

        $(this).addClass('hide');
    });

    $('#gvProyecto .items-area').on('click', '.list', function(event) {
        var idproyecto = '0',
            nrodoc = '',
            descripcion = '';

        event.preventDefault();
        
        idproyecto = $(this).attr('data-idproyecto');
        descripcion = $(this).find('main p .descripcion').text();

        setProyecto(idproyecto, descripcion, this);
    });

    $('#pnlInfoProyecto__Usuario').on('click', function(event) {
        event.preventDefault();
        ShowPanelProyecto();
    });

    $('#btnExitProyecto').on('click', function(event) {
        event.preventDefault();
        $('#pnlSearchProyecto').fadeOut(400);
    });

    $('#ddlCargo').focus().on('change', function () {
        idreferencia = $(this).val();
        LoadPersonal(TipoBusqueda, $(this).val(), '0', '1');
    });

    $('#btnCancelar, #btnBackList').on('click', function () {    
        resetForm('form1');
        limpiarSeleccionados();
        clearImagenForm();
        BackToList();
        BuscarDatos('1');
        return false;
    });

    $('#btnEditar').on('click', function(event) {
        var id = $('#gvDatos .dato.selected').attr('data-id');
        event.preventDefault();
        LimpiarFormUsuario();
        openCustomModal('#modalUsuarioReg');
        GetDataById(id);
    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        LimpiarFormUsuario();
        openCustomModal('#modalUsuarioReg');
    });
    
    $('#gvDatos').on('click', function () {
        if ($('.filtro').length > 0){
            $('#btnFilter').removeClass('active');
            $('.filtro').slideUp();
        };
    });

    BuscarDatos('1');

    $('#txtSearch').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            BuscarDatos('1');
            return false;
        }
    }).on('keypress', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearch').on('click', function () {
        BuscarDatos('1');
        return false;
    });

    if ($('#btnFilter').length > 0){
        $('#btnFilter').on('click', function(){
            if (!$(this).hasClass('active')){
                $(this).addClass('active');
                $('.filtro').slideDown();
                if ($('#ddlCategoria').length > 0)
                    $('#ddlCategoria').focus();
            }
            else {
                $(this).removeClass('active');
                $('.filtro').slideUp();
                $('#txtSearch').focus();                
            }
            return false;
        });
    }
    
    $('#btnGuardar').on('click', function (evt) {
        GuardarDatos();
    });

    $('#btnEliminar').on('click', function () {
        EliminarDatos();
        return false;
    });

    $("#btnLimpiarSeleccion").on('click', function(){
        $(this).addClass('oculto');
        $('#btnEditar, #btnEliminar').addClass('oculto');
        $('#btnNuevo').removeClass('oculto');
        limpiarSeleccionados();
        return false;
    });

    $('#btnEliminarPerfil').on('click', function(event) {
        event.preventDefault();
        EliminarPerfil();
    });

    $('#btnEditarPerfil').on('click', function(event) {
        var id = '0';
        event.preventDefault();
        
        id = $('#gvPerfil .tile.selected').attr('data-idperfil');

        LimpiarFormPerfil();
        openCustomModal('#modalPerfil');
        GetPerfil(id);
        
        $('#txtNombrePerfil').focus();
    });

    $('#btnNuevoPerfil').on('click', function(event) {
        event.preventDefault();
        
        LimpiarFormPerfil();
        openCustomModal('#modalPerfil');
        
        $('#txtNombrePerfil').focus();
    });

    $('#gvPerfil').on('click', '.tile', function(event) {
        var idperfil = '0';
        event.preventDefault();

        idperfil = $(this).attr('data-idperfil');
        
        $(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');

        ListarOpcionesMenu(idperfil);
    });

    $('#btnGuardarPerfil').on('click', function(event) {
        event.preventDefault();
        GuardarPerfil();
    });

    $('#btnAplicarPerfil').on('click', function(event) {
        event.preventDefault();
        AplicarPerfil();
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });
    
    $('#chkAllMenu').on('click', function(event) {
        var checking = $(this)[0].checked;
        var checkboxes = $('#tableMenu tbody input:checkbox');
        var countcheck = checkboxes.length;

        if (countcheck > 0) {
            for (var i = 0; i < countcheck; i++) {
                checkboxes[i].checked = checking;
            };
        };
    });

    addValidFormRegister();
    
    ListarPerfiles('DATA');
});

function ListarRedes (selector, idred) {
    $.ajax({
        url: 'services/redes/redes-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '4',
            id: idred,
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
                strhtml += '<li><a data-idred="' + data[i].tm_idred + '" data-codigo="' + data[i].tm_codigo + '" href="#"><h2>' + data[i].tm_nombre + '</h2></a></li>';
            };
        };

        $(selector).html(strhtml);
        if (selector != '#ulTiendasGuia')
            $(selector).find('li:first-child > a').trigger('click');
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function ShowPanelPersona () {
    $('#pnlSearchPersona').fadeIn(400, function () {
        BuscarPersona('1');
    });
}

function ShowPanelProyecto () {
    $('#pnlSearchProyecto').fadeIn(400, function () {
        BuscarProyecto('1');
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

function addValidFormRegister () {
    // $('#txtEmail').rules('add', {
    //     email: true,
    //     maxlength: 100
    // });
}

function removeValidFormRegister () {
    // $('#txtEmail').rules('remove');
}

function GetDataById (id) {
    // $('#pnlConfigUser > .sectionHeader > button:first-child').trigger('click');

    $.ajax({
        type: "GET",
        url: "services/usuarios/usuarios-search.php",
        cache: false,
        dataType: 'json',
        data: "tipobusqueda=2&criterio=&idusuario=" + id,
        success: function(data){
            var count = 0;
            var foto = '';
            
            count = data.length;
            
            if (count > 0){
                foto =  data[0].tm_foto;

                $('#hdIdPrimary').val(data[0].tm_idusuario);
                $('#txtNombre').val(data[0].tm_login);
                $('#txtNombres').val(data[0].tm_nombres);
                $('#txtApellidos').val(data[0].tm_apellidos);
                $('#txtClave').val(data[0].tm_clave);
                $('#txtTelefono').val(data[0].tm_telefono);
                $('#txtEmail').val(data[0].tm_correousuario);
                $('#hdFoto').val(foto);
                $('#ddlPerfil').val(data[0].tm_idperfil);

                setPersona(data[0].tm_idpersona, data[0].persona);
                setProyecto(data[0].tm_idproyecto, data[0].proyecto);

                clearImagenForm();
                
                if (foto != 'no-set'){
                    $('#imgFotoUsuario').attr({
                        'src': foto,
                        'data-src': foto
                    });
                };
            }
        }
    });
}

// function cargarDataPersona (idpersona, tipopersona) {

    //setPersona(data[0].tm_idpersona, '', descripcion);
// }

function setPersona (idpersona, descripcion, objPersona) {
    $('#hdIdPersona').val(idpersona);
    $('#hdTipoDataPersona').val('04');

    $('#pnlInfoPersonal').attr('data-idpersona', idpersona);
    $('#pnlInfoPersonal .descripcion').text(descripcion);
    //$('#pnlInfoPersonal .docidentidad').text(nrodoc);

    $('.borrar-persona').removeClass('hide');

    if (typeof objPersona !== 'undefined') {
        $('#txtNombres').val(objPersona.getAttribute('data-nombres'));
        $('#txtApellidos').val(objPersona.getAttribute('data-apellidos'));
        $('#txtEmail').val(objPersona.getAttribute('data-email'));
        $('#txtTelefono').val(objPersona.getAttribute('data-telefono'));
    };

    if ($('#pnlSearchPersona').is(':visible')) {
        $('#pnlSearchPersona').fadeOut('400', function() {
            
        });
    };
}

function setProyecto (idproyecto, descripcion, objProyecto) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlInfoProyecto__Usuario').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto__Usuario .descripcion').text(descripcion);

    $('.borrar-proyecto').removeClass('hide');

    if ($('#pnlSearchProyecto').is(':visible')) {
        $('#pnlSearchProyecto').fadeOut('400', function() {
            
        });
    };
}

function BuscarDatos (pagina) {
    var selector = '#gvDatos .items-area';
    var idproyecto_sesion = '0';

    precargaExp('#gvDatos', true);

    if ($('#hdIdPerfil').val() == '61') {
        if ($('#hdIdProyecto_Sesion').val() != '')
            idproyecto_sesion = $('#hdIdProyecto_Sesion').val();
    };
    

    if (idproyecto_sesion == '0')
        tipobusqueda =  '1';
    else
        tipobusqueda = idproyecto_sesion;

    $.ajax({
        type: "GET",
        url: "services/usuarios/usuarios-search.php",
        cache: false,
        dataType: 'json',
        data: "tipobusqueda=" + tipobusqueda + "&idcargo=" + $('#ddlCargo').val() + "&criterio=" + $('#txtSearch').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var count = data.length;
            var emptyMessage = '';
            var strhtml = '';
            var colortile = '';

            if (count > 0){
                while(i < count){
                    iditem = data[i].tm_idusuario;
                    foto = data[i].tm_foto;

                    if (data[i].activo == '1')
                        colortile = 'bg-gray-glass';
                    else
                        colortile = 'bg-amber';
                    
                    strhtml += '<a href="#" class="list dato ' + colortile + '" data-id="' + iditem + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content">';
                    strhtml += '<div class="data">';
                    strhtml += '<aside>';

                    if (foto == 'no-set')
                        strhtml += '<i class="fa fa-user"></i>';
                    else
                        strhtml += '<img src="' + foto + '" />';
                    strhtml += '</aside>';
                    strhtml += '<main><p class="fg-darker"><strong>' + data[i].tm_login + '</strong>Email: ' + (data[i].tm_correousuario == null ? '' : data[i].tm_correousuario) + '</p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPage').val(Number($('#hdPage').val()) + 1);

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPage').val();
                        BuscarDatos(pagina);
                    }
                });
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            }
            
            precargaExp('#gvDatos', false);
        }
    });
}

function BackToList () {
    removeValidFormRegister();
    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
    $('#btnGuardar, #btnCancelar').addClass('oculto');
    $('#pnlForm').fadeOut(500, function () {
        $('#pnlConfigMenu').fadeIn(500, function () {
            $('#txtSearch').focus();
        });
    });
}

function EnvioAdminDatos (form) {
    // alert($('#hdIdProyecto').val());
    // return false;
    var inputFileImage = document.getElementById('fileUploadImage');
    var file = inputFileImage.files[0];
    var data = new FormData();

    // var idperfil = $('#hdIdPerfilUsuario').val();

    // if (idperfil != '0'){
        data.append('btnGuardar', 'btnGuardar');
        data.append('archivo', file);

        var input_data = $('#form1 :input').serializeArray();

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/perfil/perfilmenu-post.php',
            cache: false,
            contentType:false,
            processData:false,
            dataType: 'json',
            data: data,
            success: function(data){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (Number(data.rpta) > 0){
                        var screenmode = getParameterByName('screenmode');

                        if (screenmode != 'usuarios') {
                            $('#hdPage').val('1');
                            $('#hdPageActual').val('1');
                            $('#btnEditar, #btnEliminar').addClass('oculto');
                            $('#btnNuevo').removeClass('oculto');
                            
                            limpiarSeleccionados();
                            BuscarDatos('1');
                            clearImagenForm();
                            closeCustomModal('#modalUsuarioReg');
                            // resetForm('form1');
                        };
                    };
                });
            }
        });
    // }
    // else {
    //     MessageBox('Seleccione perfil en el detalle de perfil', 'No es posible registrar esta informacion', "[Aceptar]", function () {
    //         $('#pnlConfigUser > .sectionHeader > button:last-child').trigger('click');
    //     });
    // }
}

function GuardarDatos () {
    $('#form1').submit();
}

function ListarPerfiles (tipomuestra) {
    var tipobusqueda = '1';
    var idperfil = '0';
    var selectorLoading = '';
    var checking = '';
    
    if (tipomuestra == 'DATA'){
        // tipobusqueda = '1';
        selectorLoading = '#pnlPermisos .gp-header';
    }
    else if (tipomuestra == 'FIELD'){
        // tipobusqueda = 'PERFILUSER';
        // idperfil = $('#hdIdPerfilUsuario').val();
        // selectorLoading = '#ddlPerfil';
    };

    if (selectorLoading != '')
        precargaExp(selectorLoading, true);
    
    $.ajax({
        type: 'GET',
        url: 'services/perfil/perfil-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idperfil: '0',
            idusuario: ''
        },
        success: function(data){
            var i = 0;
            var count = 0;
            var strhtml = '';
            var selector = '';

            count = data.length;

            if (tipomuestra == 'DATA')
                selector = '#gvPerfil';
            else if (tipomuestra == 'FIELD')
                selector = '#ddlPerfil';
            
            if (count > 0){
                while(i < count){
                    if (tipomuestra == 'DATA'){
                        strhtml += '<div data-idperfil="' + data[i].tm_idperfil + '" class="tile dato double" data-click="transform">';
                        strhtml += '<div class="tile-content">';
                        strhtml += '<div class="text-right padding10 ntp">';
                        strhtml += '<h3 class="fg-gray">' + data[i].tm_nombre + '</h3>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                        strhtml += '<div class="brand">';
                        strhtml += '<div class="label fg-darker">C&oacute;digo: ' + data[i].tm_codigo + '</div>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                    }
                    else if (tipomuestra == 'FIELD'){
                        // if (data[i].td_idperfilusuario == 0)
                        //     checking = '';
                        // else
                        //     checking = ' checked=""';

                        // strhtml += '<tr><td>';
                        // strhtml += '<div class="input-control checkbox" data-role="input-control">';
                        // strhtml += '<label>';
                        // strhtml += '<input name="hdIdPefilMenu[]" type="checkbox" value="' + data[i].tm_idperfil + '"' + checking + ' />';
                        // strhtml += '<span class="check"></span>';
                        // strhtml += '</label></div>';
                        // strhtml += '</td><td>' + data[i].tm_nombre + '</td></tr>';

                        strhtml += '<option value="' + data[i].tm_idperfil + '">' + data[i].tm_nombre + '</option>';
                    }
                    ++i;
                }
                if (tipomuestra == 'DATA')
                    $(selector).html(strhtml).find('.tile:first').trigger('click');
                else if (tipomuestra == 'FIELD')
                    $(selector).html(strhtml);
            }
            else {
                if (tipomuestra == 'DATA')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                else if (tipomuestra == 'FIELD')
                    $(selector).html('');
            }
            
            if (selectorLoading != '')
                precargaExp(selectorLoading, true);
        }
    });
}

function LimpiarFormUsuario () {
    var selectorTab = '';
    var selectorSection = '';

    selectorTab = '#pnlConfigUser > .sectionHeader button';
    selectorSection = '#pnlConfigUser > .sectionContent section';

    $('#tablePerfil tbody tr').remove();
    
    $(selectorTab).removeClass('btn-success');
    $(selectorTab).first().addClass('btn-success');
    
    $(selectorSection).hide();
    $(selectorSection).first().show();
}

function LimpiarFormPerfil () {
    $('#hdIdPerfil').val('0');
    $('#txtNombrePerfil').val('');
    $('#txtDescripcionPerfil').val('');
    $('#txtAbreviaturaPerfil').val('');
}

function GetPerfil (idperfil) {
    $.ajax({
        type: 'GET',
        url: 'services/perfil/perfil-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            idperfil: idperfil
        },
        success: function(data){
            var count = 0;
            count = data.length;
            
            if (count > 0){
                $('#hdIdPerfil').val(data[0].tm_idperfil);
                $('#txtNombrePerfil').val(data[0].tm_nombre);
                $('#txtDescripcionPerfil').val(data[0].tm_descripcion);
                $('#txtAbreviaturaPerfil').val(data[0].tm_abreviatura);
            }
        }
    });
}

function GuardarPerfil () {
    $.ajax({
        type: 'POST',
        url: 'services/perfil/perfilmenu-post.php',
        cache: false,
        dataType: 'json',
        data: 'fnPost=fnPost&btnGuardarPerfil=btnGuardarPerfil&hdIdPerfil=' + $('#hdIdPerfil').val() + '&' + $('#modalPerfil input:text, #modalPerfil textarea').serialize(),
        success: function(data){
            if (data.rpta) {
                MessageBox('Datos guardados', 'La operaci&oacute;n se complet&oacute; correctamente.', '[Aceptar]', function () {
                    closeCustomModal('#modalPerfil');
                    ListarPerfiles('DATA');
                    ListarPerfiles('FIELD');
                });
            };
        }
    });
}

function EliminarPerfil () {
    var idperfil = '0';
    
    idperfil = $('#gvPerfil .tile.selected').attr('data-idperfil');
    
    $.ajax({
        type: 'POST',
        url: 'services/perfil/perfilmenu-post.php',
        cache: false,
        dataType: 'json',
        data: 'fnPost=fnPost&btnEliminarPerfil=btnEliminarPerfil&hdIdPerfil=' + idperfil,
        success: function(data){
            if (data.rpta) {
                MessageBox(data.titulomsje, data.contenidomensaje, '[Aceptar]', function () {
                    ListarPerfiles('DATA');
                    ListarPerfiles('FIELD');
                });
            };
        }
    });
}

function AplicarPerfil () {
    var idperfil = '0';
    var listIdMenu = '';
    
    idperfil = $('#gvPerfil .tile.selected').attr('data-idperfil');
    
    listIdMenu =$.map($('#tableMenu tbody input:checkbox:checked'), function(n, i){
        return n.value;
    }).join(',');

    $.ajax({
        type: 'POST',
        url: 'services/perfil/perfilmenu-post.php',
        cache: false,
        dataType: 'json',
        data: {
            fnPost: 'fnPost',
            btnAplicarPerfil: 'btnAplicarPerfil',
            hdIdPerfil: idperfil,
            listIdMenu: listIdMenu
        },
        success: function(data){
            if (data.rpta) {
                MessageBox(data.titulomsje, data.contenidomensaje, '[Aceptar]', function () {
                    ListarOpcionesMenu(idperfil);
                });
            };
        }
    });
}

function limpiarSeleccionados () {
    $('.listview .selected').removeClass('selected');
    $('.listview .list input:checkbox').removeAttr('checked');
}

function EliminarDatos () {
    var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminar=btnEliminar';
    precargaExp('.page-region', true);
    $.ajax({
        type: "POST",
        url: 'services/perfil/perfilmenu-post.php',
        cache: false,
        dataType: 'json',
        data: serializedReturn,
        success: function(data){
            precargaExp('.page-region', false);
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (Number(data.rpta) > 0){
                    $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                    $('#btnNuevo').removeClass('oculto');
                    limpiarSeleccionados();
                    BuscarDatos('1');
                };
            });
        }
    });
    
}

function ListarOpcionesMenu (idperfil) {
    $('#chkAllMenu')[0].checked = false;
    precargaExp('#tableMenu .ibody', true);

    $.ajax({
        type: 'GET',
        url: 'services/menu/menu-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'CONFIG',
            idperfil: idperfil
        },
        success: function(data){
            var i = 0;
            var count = 0;
            var strhtml = '';
            var selector = '';

            count = data.length;
            selector = '#tableMenu tbody';

            if (count > 0){
                /*while(i < count){
                    ++i;
                }*/
                strhtml = treeMenu(data, 0, 0);
                $(selector).html(strhtml);
            }
            else
                $(selector).html('<h2>No se encontraron resultados.</h2>');                
            
            precargaExp('#tableMenu .ibody', false);
        }
    });
}

function treeMenu(data, mom, level){
    var checking = '';
    var strhtml = '';

    for (var k in data) {
        if (data[k].tm_idmenuref == mom) {
            if (data[k].td_idperfilmenu == 0)
                checking = '';
            else
                checking = ' checked=""';

            strhtml += '<tr>';
            strhtml += '<td style="width:20px;">';
            strhtml += '<div class="input-control checkbox" data-role="input-control">';
            strhtml += '<label>';
            strhtml += '<input name="hdIdMenu[]" type="checkbox" value="' + data[k].tm_idmenu + '"' + checking + ' />';
            strhtml += '<span class="check"></span>';
            strhtml += '</label></div>';
            strhtml += '<input type="hidden"  value="' + data[k].td_idperfilmenu + '" />';
            strhtml += '</td><td>' + data[k].tm_nombre + '</td></tr>';
            strhtml += treeMenu(data, data[k].tm_idmenu, level);
        };
     }
     return strhtml;
}

function BuscarPersona (pagina) {
    var selector = '#gvPersona .items-area';
    
    precargaExp('#gvPersona', true);
    
    $.ajax({
        type: "GET",
        url: 'services/propietario/propietario-search.php',
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchPersona').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idtipopropietario;
                    var foto = data[i].tm_foto;

                    strhtml += '<a href="#" ';

                    strhtml += 'data-nombres="' + data[i].tm_nombres + '" ';
                    strhtml += 'data-apellidos="' + data[i].tm_apepaterno + ' ' + data[i].tm_apematerno + '" ';
                    strhtml += 'data-email="' + data[i].tm_email + '" ';
                    strhtml += 'data-telefono="' + data[i].tm_telefono + '" ';

                    strhtml += 'class="list dato bg-gray-glass bg-cyan" data-idpropietario="' + iditem + '" data-tipopropietario="' + data[i].tm_iditc + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
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
                };
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPagePersona').val(Number($('#hdPagePersona').val()) + 1);
                //alert($('#hdPagePersona').val());
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                };
            };
            
            precargaExp('#gvPersona', false);
        }
    });
}

function BuscarProyecto (pagina) {
    var selector = '#gvProyecto .items-area';
    
    precargaExp('#gvProyecto', true);
    
    $.ajax({
        type: "GET",
        url: 'services/condominio/condominio-search.php',
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchProyecto').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].idproyecto;

                    strhtml += '<a href="#" data-idproyecto="' + iditem + '" data-nombre="' + data[i].nombreproyecto + '" ';

                    strhtml += 'class="list dato bg-gray-glass bg-cyan">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';

                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';

                    ++i;
                };
                
                $('#hdPageProyecto').val(pagina);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#gvProyecto', false);
        }
    });
}