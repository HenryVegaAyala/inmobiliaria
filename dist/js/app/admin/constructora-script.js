$(function  () {
    ListarConstructora('1');

    $('#txtSearch').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearch').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();
        $('#btnLimpiarSeleccion').trigger('click');
        
        paginaConstructora = 1;
        ListarConstructora('1');
    });

    $('#gvDatos').on('click', '.dato', function(event) {
        var checkBox = $(this).find('input:checkbox');
        event.preventDefault();
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvDatos .dato.selected').length == 0){
                $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
                $('#btnLimpiarSeleccion, #btnEditar, #btnDetalleFromList, #btnEliminar').addClass('oculto');
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
            $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
            if ($('#gvDatos .dato.selected').length == 1){
                $('#btnEditar, #btnDetalleFromList').removeClass('oculto');
            }
            else {
                $('#btnEditar, #btnDetalleFromList').addClass('oculto');
            };
        };
    });

    $('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        LimpiarForm();
        GoToEdit();
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

    $('#pnlInfoUbigeo').on('click', function(event) {
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

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });

    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnCancelar').on('click', function (event) {
        event.preventDefault();
        closeCustomModal('#modalRegistroConstructora');
    });

    $('#btnEliminar').on('click', function (event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarConstructora();
        };
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDatos .dato').addClass('selected');
        $('#gvDatos input:checkbox').attr('checked', '');
        $('#btnNuevo, #btnDetalleFromList, #btnUploadExcel, #btnEditar').addClass('oculto');
        $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
    });

    $('#gvDatos > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageConstructora').val());

            ListarConstructora(paginaActual);
        };
    });
});

var paginaConstructora = 1;
var indexList = 0;
var elemsSelected;

function ListarConstructora (pagina) {
    var selector = '#gvDatos .items-area';

    precargaExp('#gvDatos', true);

    $.ajax({
        url: 'services/constructora/constructora-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'LISTADO',
            tipobusqueda: '1',
            criterio: $('#txtSearch').val()
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        
        countdata = data.length;
        
        if (countdata > 0) {
            while(i < countdata){
                iditem = data[i].idconstructora;
                strhtml += '<a href="#" class="list dato without-foto bg-gray-glass half-col bg-cyan g200" data-idconstructora="' + iditem + '">';

                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                strhtml += '<div class="list-content pos-rel">';

                strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-bottom-right padding5 margin5 text-ellipsis">LOCALIDAD: ' + data[i].localidad + '</span>';

                strhtml += '<div class="data">';
                strhtml += '<main><p class="fg-white"><strong class="descripcion">' + data[i].nombreconstructora + '</strong></p>';
                strhtml += '</main></div></div>';
                strhtml += '</a>';
                ++i;
            }

            paginaConstructora = paginaConstructora + 1;

            $('#hdPageConstructora').val(paginaConstructora);
            
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
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function GoToEdit () {
    //precargaExp('body', true);
    var recordEdit = $('#gvDatos .list.selected');
    var idrecord = '0';
    
    if (recordEdit.length > 0){
        idrecord = recordEdit.attr('data-idconstructora');
        
        $.ajax({
            url: 'services/constructora/constructora-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipo: 'ID',
                criterio: idrecord
            }
        })
        .done(function(data) {
            var countdata = 0;
            
            countdata = data.length;

            if (countdata > 0){
                $('#hdIdPrimary').val(data[0].idconstructora);
                $('#hdIdPropietario').val(data[0].idtipopropietario);
                $('#ddlTipoConstructora').val(data[0].idtipoconstructora);
                $('#txtNombreConstructora').val(data[0].nombreconstructora);
                $('#ddlTipoDocJuridica').val(data[0].iddocident);
                $('#txtRucEmpresa').val(data[0].numerodoc);
                $('#txtRazonSocial').val(data[0].razsocial);
                $('#txtDireccionEmpresa').val(data[0].direccion);
                $('#txtTelefonoEmpresa').val(data[0].telefono);
                $('#txtEmailEmpresa').val(data[0].email);
                $('#txtWebEmpresa').val(data[0].urlweb);

                setUbigeo(data[0].idlocalidad, data[0].localidad);
            };
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    };    

    openCustomModal('#modalRegistroConstructora');
}

function setUbigeo (idubigeo, descripcion) {

    $('#pnlInfoUbigeo').attr('data-idubigeo', idubigeo);
    $('#pnlInfoUbigeo .info .descripcion').text(descripcion);

    $('#hdIdLocalidad').val(idubigeo);
    closeCustomModal('#modalUbigeo');
}

function ListarUbigeo () {
    precargaExp('#modalUbigeo .scrollbarra', true);

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

        precargaExp('#modalUbigeo .scrollbarra', false);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
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
    $('#txtNombreConstructora').val('');
    $('#ddlTipoConstructora')[0].selectedIndex = 0;
    $('#ddlTipoDocJuridica')[0].selectedIndex = 0;
    $('#txtRucEmpresa').val('');
    $('#txtRazonSocial').val('');
    $('#txtDireccionEmpresa').val('');
    $('#txtTelefonoEmpresa').val('');
    $('#txtEmailEmpresa').val('');
    $('#txtWebEmpresa').val('');
    setUbigeo('0', 'Localidad');
}

function EnvioAdminDatos (form) {
    var data = new FormData();

    addValidPersonaJuridica();
    
    if ($('#form1').valid()){
        data.append('btnGuardar', 'btnGuardar');

        var input_data = $('#form1 :input').serializeArray();

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: "services/constructora/constructora-post.php",
            contentType:false,
            processData:false,
            cache: false,
            dataType: 'json',
            data: data,
            complete: function (data) {
                removeValidPersonaJuridica();
            },
            success: function(data){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (data.rpta != '0'){
                        paginaConstructora = 1;
                        clearOnlyListSelection();
                        $('#txtSearch').val('');
                        ListarConstructora('1');
                        closeCustomModal('#modalRegistroConstructora');
                        $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                        $('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnEliminar').addClass('oculto');
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
/*
function EliminarDatos () {
    var data = new FormData();
    var input_data;

    confirma = confirm('¿Desea eliminar este elemento?');

    if (confirma){
        input_data = $('#form1 .listview input:checkbox:checked').serializeArray();
        
        data.append('btnEliminar', 'btnEliminar');
        
        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: "services/constructora/constructora-post.php",
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
                        $('#btnLimpiarSeleccion, #btnDetalleFromList, #btnEditar, #btnEliminar').addClass('oculto');

                        if ($('.listview .list').length == 0){
                            $('#txtSearch').val('');
                            paginaConstructora = 1;
                            ListarConstructora('1');
                        };
                    });
                };
            },
            error:function (data){
                console.log(data);
            }
        });
    };
}*/


function EliminarConstructora () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemConstructora(elemsSelected[0]);
}

function EliminarItemConstructora (item) {
    var data = new FormData();
    var idconstructora = '0';

    idconstructora = item.getAttribute('data-idconstructora');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdConstructora', idconstructora);

    $.ajax({
        url: 'services/constructora/constructora-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollConstructoras;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'La empresa inmobiliaria ' + idconstructora + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROYECTO') {
                    contenidomsje += ' tiene proyectos relacionados.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollConstructoras = $('#gvDatos .listview');
                iScroll = scrollConstructoras.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollConstructoras.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemConstructora(elemsSelected[indexList]);
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