$(function  () {
    // RegistroPorDefecto();
    IntercambiarFiltros();

    $('#ddlProyecto').on('change', function(event) {
        event.preventDefault();
        var today = new Date();
        var yyyy = today.getFullYear();
        
        var idproyecto = $(this).val();
        
        $('#hdIdProyecto').val(idproyecto);
        
        window.top.idproyecto = idproyecto;

        ListarAnhoProceso(yyyy);
    });

    $('#ddlProyecto').trigger('change');

    $('.sidebar-menu').on('click', 'a', function(event) {
        event.preventDefault();

        var _idpanel = this.getAttribute('href');
        $('.sidebar-menu li').removeClass('bg-dark active');
        $(this).parent().addClass('bg-dark active');

        $('.xpanel').addClass('hide');
        $(_idpanel).removeClass('hide');
    });

    $('#btnImprimirReporte').on('click', function(event) {
        event.preventDefault();
        //openCustomModal('#modalReporte');    
    });

    $('#btnGenerarReporte_PDF').on('click', function(event) {
        event.preventDefault();
        GenerarReporte('PDF');
    });

    $('#btnGenerarReporte_EXCEL').on('click', function(event) {
        event.preventDefault();
        GenerarReporte('EXCEL');
    });

    $('#pnlFiltros').on('click', '.panel-info', function(event) {
        event.preventDefault();
        var panelinfo;

        panelinfo = this;

        $('#pnlDatosFiltro').fadeIn(400, function () {
            var tipofiltro = '';
            var titulofiltro = '';
            
            tipofiltro = panelinfo.getAttribute('data-tipofiltro');
            titulofiltro = panelinfo.getAttribute('data-hint');
            paginaFiltro = 1;
            
            if (tipofiltro == 'proyecto'){
                ListarProyectos('1');
            }
            else if (tipofiltro == 'concepto'){
                ListarConcepto('1');
            }
            else if (tipofiltro == 'propiedad') {
                ListarPropiedades('1');
            };
            
            this.setAttribute('data-tipofiltro', tipofiltro);
            $('#txtTituloFiltro').text(titulofiltro);
        });
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
            }
            else if (tipofiltro == 'concepto') {
                ListarConcepto(paginaActual);
            }
            else if (tipofiltro == 'propiedad') {
                ListarPropiedades(paginaActual);
            };
        };
    });

    $('#gvFiltro').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var pnlDatosFiltro;
        var idproyecto = '0';
        var nombre = '';
        var tipofiltro = '';

        pnlDatosFiltro = document.getElementById('pnlDatosFiltro');
        tipofiltro = pnlDatosFiltro.getAttribute('data-tipofiltro');

        if (tipofiltro == 'proyecto'){
            idproyecto = this.getAttribute('data-idproyecto');
            nombre = this.getAttribute('data-nombre');
            setProyecto(idproyecto, nombre);
        };
    });

    $('#ddlTipoReporte').on('change', function(event) {
        event.preventDefault();
        IntercambiarFiltros();
    });

    $('#btnHideImpresion').on('click', function(event) {
        event.preventDefault();
        $('#pnlImpresionFactura').fadeOut(400);
    });
});

var paginaFiltro = 1;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function ListarProyectos (pagina) {
    var selector = '#gvFiltro .items-area';

    precargaExp('#gvFiltro', true);

    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: 'json',
        data: "tipo=1&criterio=" + $('#txtSearchFiltro').val() + "&pagina=" + pagina,
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
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + '</span></p>';
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

function ListarConcepto (pagina) {
    var selectorgrid = '#gvFiltro';
    var selector = selectorgrid + ' .items-area';
    var tipobusqueda = '';
    var criterio = '';

    precargaExp(selectorgrid, true);

    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            id: '0',
            criterio: $('#txtSearchFiltro').val(),
            tipoconcepto: $('#ddlTipoConcepto').val(),
            pagina: pagina
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        
        countdata = data.length;
        
        if (countdata > 0) {
            while(i < countdata){
                iditem = data[i].tm_idconcepto;
                strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idconcepto="' + iditem + '" data-formula="' + data[i].tm_definicion_formula + '" data-tipovalor="concepto">';

                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                strhtml += '<div class="list-content pos-rel">';

                strhtml += '<div class="data">';
                strhtml += '<main><p class="fg-white"><span class="codigo float-left">' + data[i].tm_idconcepto + ' -&nbsp;</span><span class="descripcion float-left">' + data[i].tm_descripcionconcepto + '</span></p>';
                strhtml += '</main></div></div>';

                if (data[i].tm_esformula == '1')
                    strhtml += '<span class="place-top-right bg-emerald margin10"><h5 class="fg-white padding10 no-margin text-center"><i class="icon-calculate"></i></h5></span>';

                strhtml += '<div class="place-bottom-left fg-white">';
                strhtml += '<div class="tag-descrip bg-darkTeal">TIPO: ' + data[i].nomtipoconcepto + '</div>';
                strhtml += '<div class="tag-descrip bg-emerald">TIPO VALOR: ' + data[i].nomtipovalor + '</div>';
                strhtml += '</div>';

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

        precargaExp(selectorgrid, false);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function ListarPropiedades (pagina) {
    var selector = '#gvFiltro .items-area';

    precargaExp('#gvFiltro', true);

    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdProyecto').val(),
            idtipopropiedad: $('#ddlTipoPropiedadFiltro').val(),
            criterio: $('#txtSearchFiltro').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var colortile = '';
            var idtipopropiedad = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idpropiedad;
                    idtipopropiedad = data[i].idtipopropiedad;
                    
                    if (idtipopropiedad == 'DPT')
                        colortile = 'bg-teal';
                    else if (idtipopropiedad == 'DEP')
                        colortile = 'bg-blueGrey';
                    else if (idtipopropiedad == 'EST')
                        colortile = 'bg-indigo';

                    strhtml += '<div class="tile dato double bg-gray-glass ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-area="' + data[i].area + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="fg-white">' + data[i].descripcionpropiedad + '</h2>';
                    strhtml += '</div></div>';
                    strhtml += '<div class="brand"><span class="badge bg-dark">Area: ' + data[i].area + ' (m<sup>2</sup>)</span></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                }
                
                paginaFiltro = paginaFiltro + 1;

                $('#hdPage').val(paginaFiltro);

                if (pagina == 1)
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == 1){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                };
            };
            
            precargaExp('#gvFiltro', false);
        }
    });
}

function IntercambiarFiltros () {
    var tiporeporte = '';
    var nomtiporeporte = '';

    tiporeporte = $('#ddlTipoReporte').val();
    nomtiporeporte = $('#ddlTipoReporte option:selected').text();

    document.getElementById('hdTipoReporte').value = nomtiporeporte;

    if (tiporeporte == '01') {
        $('#rowFechaSimple').addClass('oculto');
        $('#rowConcepto, #lblTitleCustomFilter, #rowPropiedad, #rowPropietario, #rowFechaRango').removeClass('oculto');
    }
    else {
        if (tiporeporte == '00' || tiporeporte == '02') {
            $('#rowFechaSimple').addClass('oculto');
            $('#rowFechaRango').removeClass('oculto');
        }
        else {
            if (tiporeporte == '04' || tiporeporte == '05' || tiporeporte == '07') {
                $('#rowConcepto, #lblTitleCustomFilter, #rowFechaSimple, #rowFechaRango').addClass('oculto');
            }
            else {
                if (tiporeporte == '08' || tiporeporte == '09' || tiporeporte == '10') {
                    $('#rowConcepto, #lblTitleCustomFilter, #rowFechaRango').addClass('oculto');
                    $('#rowFechaSimple').removeClass('oculto');
                }
                else {
                    $('#rowConcepto, #lblTitleCustomFilter').removeClass('oculto');
                    if (tiporeporte == '06'){
                        $('#rowFechaRango').removeClass('oculto');
                        $('#rowFechaSimple').addClass('oculto');
                    }
                    else {
                        $('#rowFechaRango').addClass('oculto');
                        $('#rowFechaSimple').removeClass('oculto');
                    };
                }
            };
        };
        
        $('#rowPropiedad, #rowPropietario').addClass('oculto');
    };
}

function VerImpresion (url) {
    $('#pnlImpresionFactura').fadeIn(400, function() {
        $('#ifrImpresionFactura').attr('src', url);
    });
}

function RegistroPorDefecto () {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'defecto'
        },
        success: function (data) {
            var countdata = 0;
            var idproyecto = '0';
            var descripcion = '';

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto;

                setProyecto(idproyecto, descripcion);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function setProyecto (idproyecto, nombre) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto .info .descripcion').text(nombre);

    $('#pnlDatosFiltro').fadeOut('400', function() {
        var today = new Date();
        var yyyy = today.getFullYear();

        ListarAnhoProceso(yyyy);
    });
}

function ListarAnhoProceso (anhodefault) {
    $.ajax({
        url: 'services/proceso/proceso-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ANHO',
            idproyecto: $('#hdIdProyecto').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selected = '';
            
            countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    if (anhodefault == data[i].per_ano) {
                        selected = ' selected="selected"';
                    }
                    else {
                        selected = '';
                    };

                    strhtml += '<option' + selected + ' value="' + data[i].per_ano + '">' + data[i].per_ano + '</option>';
                    ++i;
                };
            }
            else {
                strhtml += '<option value="0">NO HAY PROCESOS RELACIONADOS CON EL PROYECTO SELECCIONADO</option>';
            };

            $('#ddlAnho').html(strhtml);
            $('#ddlAnhoIni').html(strhtml);
            $('#ddlAnhoFin').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GenerarReporte (tipoformato) {
    var data = new FormData();
    var input_data;
    
    precargaExp('#form1', true);

    input_data = $('#form1 :input').serializeArray();

    data.append('btnGenerarReporte', 'btnGenerarReporte');
    data.append('hdTipoFormato', tipoformato);

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/reporteria/reporteador-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#form1', false);

            MessageBox(data.titulomsje, 'La operación se completó satisfactoriamente', "[Aceptar]", function () {
                if (tipoformato == 'PDF')
                    VerImpresion(data.contenidomsje);
                else if (tipoformato == 'EXCEL')
                    window.location = data.contenidomsje;
            });
        },
        error: function (data) {
            precargaExp('#form1', false);
            
            MessageBox('Error en el servidor', data.responseText, "[Aceptar]", function () {
            });
            console.log(data);
        }
    });
}

function IniciarForm () {
    var idproyecto = window.top.idproyecto;
    var anho = window.top.anho;
    var mes = window.top.mes;
    // var escobrodiferenciado = window.top.escobrodiferenciado;
    
    $('#hdIdProyecto').val(idproyecto);
    $('#hdIdConsumoProyecto').val(idproyecto);
    $('#hdAnho').val(anho);
    $('#hdMes').val(mes);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    // $('#pnlInfoProyecto .info .descripcion').text(nombre);

    
    var today = new Date();
    var yyyy = $('#hdAnho').val();

    ListarAnhoProceso(yyyy);
}