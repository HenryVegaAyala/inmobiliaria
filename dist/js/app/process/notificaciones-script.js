$(function () {
    ListarModelos('1');

    $('#gvDatos').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var checkBox = $(this).find('input:checkbox');
        
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

	$('#pnlInfoProyecto').add('#pnlInfoProyecto').on('click', function(event) {
        event.preventDefault();
        var panelinfo;
        var tipofiltro = '';
        var titulofiltro = '';
        
        panelinfo = this;
        tipofiltro = panelinfo.getAttribute('data-tipofiltro');
        titulofiltro = panelinfo.getAttribute('data-hint');

        paginaFiltro = 1;
        
        if (tipofiltro == 'proyecto'){
            $('#pnlDatosFiltro').removeClass('with-appbar');
            $('#pnlDatosFiltro .appbar').addClass('oculto');
            ListarProyectos('1');
        };

        $('#pnlDatosFiltro').attr('data-tipofiltro', tipofiltro);
        $('#txtTituloFiltro').text(titulofiltro);
        
        $('#pnlDatosFiltro').fadeIn(400, function () {

        });
    });

    $('#btnBackToNotif').on('click', function(event) {
        event.preventDefault();
        $('#pnlModelo').fadeOut(400, function() {
            $('#pnlListado').fadeIn(400, function() {
                
            });
        });
    });

    $('#btnModeloEmail').on('click', function(event) {
        event.preventDefault();
        $('#pnlListado').fadeOut(400, function() {
            $('#pnlModelo').fadeIn(400, function() {
                
            });
        });
    });

    $('#btnNuevo, #btnEditar').on('click', function(event) {
        event.preventDefault();
        var idmodelocarta = '0';
        idmodelocarta = $('#gvDatos .tile.selected').attr('data-idmodelocarta');

        openModalCallBack('#modalModelo', function () {
            $('#ifrModelo').attr('src', 'index.php?pag=admin&subpag=modelos&idmodelocarta=' + (idmodelocarta == null ? '0' : idmodelocarta));
        });
    });

    $('#btnEliminar').on('click', function () {
        EliminarDatos();
        return false;
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#btnHideFiltro').on('click', function(event) {
        event.preventDefault();
        $('#pnlDatosFiltro').fadeOut(400, function() {
            
        });
    });

    $('#gvFiltro > .items-area').on('scroll', function(){
        var paginaActual = 0;
        var tipofiltro = '';

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPage').val());
            tipofiltro = $('#pnlDatosFiltro').attr('data-tipofiltro');
            
            if (tipofiltro == 'proyecto'){
                ListarProyectos(paginaActual);
            };
        };
    });

    $('#gvFiltro').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var pnlDatosFiltro;
        var iddata = '0';
        var nombre = '';
        var tiporesultado = '';
        var tipofiltro = '';
        var checkBox;

        pnlDatosFiltro = document.getElementById('pnlDatosFiltro');
        tipofiltro = pnlDatosFiltro.getAttribute('data-tipofiltro');

        if (tipofiltro == 'proyecto'){
            iddata = this.getAttribute('data-idproyecto');
            nombre = this.getAttribute('data-nombre');
            setProyecto(iddata, nombre);
        };
    });
});

var paginaModelo = 1;

function setProyecto (idproyecto, nombre) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto .info .descripcion').text(nombre);

    $('#pnlDatosFiltro').fadeOut('400', function() {
    });
}

function ListarProyectos (pagina) {
    var selectorgrid = '#gvFiltro';
    var selector = selectorgrid + ' .gridview';

    precargaExp(selectorgrid, true);

    $(selector).addClass('items-area').addClass('listview').removeClass('card-area');

    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchFiltro').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idproyecto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' + data[i].nombreproyecto + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';

                    strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-top-right padding5 margin5">UBIGEO: ' + data[i].ubigeo + '</span>';

                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + '</span></p><p class="fg-white">Direcci&oacute;n: <span class="direccion">' + data[i].direccionproyecto + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                }

                paginaFiltro = paginaFiltro + 1;
                $('#hdPage').val(paginaFiltro);
                
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
            
            precargaExp('#gvFiltro', false);
        }
    });
}

function ListarModelos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview';

    precargaExp(selectorgrid, true);

    $.ajax({
        type: "GET",
        url: "services/modelocarta/modelocarta-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchFiltro').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idmodelocarta;
                    strhtml += '<div class="tile double dato without-foto bg-gray-glass bg-cyan g200" data-idmodelocarta="' + iditem + '" data-nombre="' + data[i].nombre + '">';

                    strhtml += '<div class="tile-content">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<p class="fg-white padding10"><span class="descripcion">' + data[i].nombre + '</span></p>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    ++i;
                }

                paginaModelo = paginaModelo + 1;
                $('#hdPageModelo').val(paginaModelo);
                
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
            
            precargaExp(selectorgrid, false);
        }
    });
}

function EliminarDatos () {
    var data = new FormData();
    var input_data;

    input_data = $('#gvDatos .tile-area input:checkbox:checked').serializeArray();
    
    data.append('btnEliminar', 'btnEliminar');
    
    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/modelocarta/modelocarta-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            if (Number(data.rpta) > 0){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    $('.tile-area .dato.selected').remove();
                    $('#btnNuevo, #btnSelectAll').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');

                    if ($('.tile-area .dato').length == 0){
                        $('#txtSearch').val('');
                        paginaModelo = 1;
                        ListarModelos('1');
                    };
                });
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}