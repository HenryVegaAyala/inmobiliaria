$(function () {
    // $('#pnlInfoProyecto').on('click', function(event) {
    //     event.preventDefault();
    //     var panelinfo;
    //     var tipofiltro = '';
    //     var titulofiltro = '';
        
    //     panelinfo = this;
    //     tipofiltro = panelinfo.getAttribute('data-tipofiltro');
    //     titulofiltro = panelinfo.getAttribute('data-hint');

    //     paginaFiltro = 1;
        
    //     if (tipofiltro == 'proyecto'){
    //         $('#pnlDatosFiltro').removeClass('with-appbar');
    //         $('#pnlDatosFiltro .appbar').addClass('oculto');
    //         ListarProyectos('1');
    //     };

    //     $('#pnlDatosFiltro').attr('data-tipofiltro', tipofiltro);
    //     $('#txtTituloFiltro').text(titulofiltro);
        
    //     $('#pnlDatosFiltro').fadeIn(400, function () {

    //     });
    // });

    $('#btnHideFiltro').on('click', function(event) {
        event.preventDefault();
        $('#pnlDatosDetalle').fadeOut(400, function() {
            
        });
    });

    // $('#gvFiltro > .items-area').on('scroll', function(){
    //     var paginaActual = 0;
    //     var tipofiltro = '';

    //     if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
    //         paginaActual = Number($('#hdPage').val());
    //         tipofiltro = $('#pnlDatosFiltro').attr('data-tipofiltro');
            
    //         if (tipofiltro == 'proyecto'){
    //             ListarProyectos(paginaActual);
    //         };
    //     };
    // });

    $('#btnClearFilter').on('click', function(event) {
        event.preventDefault();
        $('#btnClearFilter, #btnAsignFilter').addClass('oculto');
        $('#btnSelectAllFilter').removeClass('oculto');
        $('#gvFiltro input:checkbox').removeAttr('checked');
        $('#gvFiltro .dato').removeClass('selected');
    });

    $('#btnSelectAllFilter').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#btnClearFilter, #btnAsignFilter').removeClass('oculto');
        $('#gvFiltro input:checkbox').attr('checked', '');
        $('#gvFiltro .dato').addClass('selected');
    });

    // $('#gvFiltro').on('click', '.dato', function(event) {
    //     event.preventDefault();
        
    //     var pnlDatosFiltro;
    //     var iddata = '0';
    //     var nombre = '';
    //     var escobrodiferenciado = '0';
    //     var tiporesultado = '';
    //     var tipofiltro = '';

    //     pnlDatosFiltro = document.getElementById('pnlDatosFiltro');
    //     tipofiltro = pnlDatosFiltro.getAttribute('data-tipofiltro');

    //     if (tipofiltro == 'proyecto'){
    //         iddata = this.getAttribute('data-idproyecto');
    //         nombre = this.getAttribute('data-nombre');

    //         $('#ddlMes').val(this.getAttribute('data-mes'));
    //         setProyecto(iddata, nombre);
    //     };
    // });

 //    $('#tableLiquidacion tbody').on('click', 'tr', function(event) {
	// 	event.preventDefault();
		
	// 	//var checkBox = $(this).find('input:checkbox');

	// 	if ($(this).hasClass('selected')){
 //            $(this).removeClass('selected');
 //            //checkBox.removeAttr('checked');
 //            if ($('#tableLiquidacion tbody tr.selected').length == 0){
 //                $('#btnNuevo, #btnSelectAll').removeClass('oculto');
 //                $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
 //            }
 //            else {
 //                if ($('#tableLiquidacion tr.selected').length == 1){
 //                    $('#btnLimpiarSeleccion, #btnEditar').removeClass('oculto');
 //                };
 //            };
 //        }
 //        else {
 //            $(this).addClass('selected');
 //            //checkBox.attr('checked', '');
 //            $('#btnNuevo').addClass('oculto');
 //            $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
 //            if ($('#tableLiquidacion tbody tr.selected').length == 1){
 //                $('#btnEditar').removeClass('oculto');
 //            }
 //            else {
 //                $('#btnEditar').addClass('oculto');
 //            };
 //        };
	// });
	
	$('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        LimpiarForm();
        GoToEdit();
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });

    $('#gvCobranza').on('click', 'button[data-action="view-details"]', function(event) {
        event.preventDefault();
        var mes = this.getAttribute('data-mes');
        ShowPanel('cobranza', mes, '');
    });

    $('#gvGasto').on('click', 'button[data-action="view-details"]', function(event) {
        event.preventDefault();
        var tipogasto = this.getAttribute('data-tipogasto');
        ShowPanel('gasto', '', tipogasto);
    });

    $('#btnGuardar').on('click', function (evt) {
        GuardarDatos();
    });

    $('#btnShowDetalle_Cobranza').on('click', function(event) {
        event.preventDefault();

        ListarCobranza_Resumen();

        $('#gvCobranza').toggle(400, function(display) {
            
        });
    });

    $('#btnShowDetalle_Gasto').on('click', function(event) {
        event.preventDefault();

        ListarGasto_Resumen();

        $('#gvGasto').toggle(400, function(display) {
            
        });
    });

    $('#txtSaldoInicial').click(function () {
       $(this).select();
    });

    $('#btnSaldoInicial').on('click', function(event) {
        event.preventDefault();
        $('#modalSaldoInicial').modal('show');
    });

    $('#modalSaldoInicial').on('shown.bs.modal', function (e) {
        $('#txtSaldoInicial').val($('#lblSaldoInicial').text()).focus().select();
    });

    $('#btnGuardarSaldoInicial').on('click', function(event) {
        event.preventDefault();
        RegistrarSaldoInicial();
    });
});

var paginaGasto = 1;
var paginaCobr
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function IniciarForm () {
    var idproyecto = window.top.idproyecto;
    var anho = window.top.anho;
    var mes = window.top.mes;

    $('#hdIdProyecto').val(idproyecto);
    $('#hdAnho').val(anho);
    $('#hdMes').val(mes);

    ListarLiquidacion();

    ObtenerTotal_Cobranza(idproyecto, anho, mes);
    ObtenerTotal_Gasto(idproyecto, anho, mes);
    // RegistroPorDefecto();
}

// function RegistroPorDefecto () {
//     $.ajax({
//         url: 'services/condominio/condominio-search.php',
//         type: 'GET',
//         dataType: 'json',
//         data: {tipo: 'defecto'},
//         success: function (data) {
//             var countdata = 0;
//             var idproyecto = '0';
//             var descripcion = '';

//             countdata = data.length;

//             if (countdata > 0){
//                 idproyecto = data[0].idproyecto;
//                 descripcion = data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].mesproceso) - 1] + ' ' + data[0].anhoproceso;

//                 $('#ddlMes').val(data[0].mesproceso);
//                 setProyecto(idproyecto, descripcion);
//             };
//         },
//         error:function (data){
//             console.log(data);
//         }
//     });
// }

function setProyecto (idproyecto, nombre) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto .info .descripcion').text(nombre);
    $('#pnlInfoLiquidacion').attr('data-idproyecto', idproyecto);
    $('#pnlInfoLiquidacion .info .descripcion').text(nombre);

    $('#pnlDatosFiltro').fadeOut('400', function() {
        var today = new Date();
        var yyyy = today.getFullYear();

        ListarAnhoProceso(yyyy);
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
        data: "tipo=asignacion&criterio=" + $('#txtSearchFiltro').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idproyecto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' +  data[i].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[i].mesproceso) - 1] + ' ' + data[i].anhoproceso + '" data-mes="' + data[i].mesproceso + '" data-anho="' + data[i].anhoproceso + '" data-escobrodiferenciado="' + data[i].escobrodiferenciado + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[i].mesproceso) - 1] + ' ' + data[i].anhoproceso + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                paginaFiltro = paginaFiltro + 1;
                $('#hdPage').val(paginaFiltro);
                
                if (pagina == '1'){
            		$('#btnNuevo').removeClass('oculto');
                    $(selector).html(strhtml);
                }
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1'){
                	$('#btnNuevo').addClass('oculto');
                    $(selector).html('<h2>No hay datos.</h2>');
                };
            };

            
            precargaExp('#gvFiltro', false);
        }
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

            ListarLiquidacion();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarLiquidacion () {

    $.ajax({
        url: 'services/liquidacion/liquidacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var countdata = data.length;

            if (countdata > 0){
                var saldoinicial = Number(data[0].saldoinicial).toFixed(2);

                $('#hdIdCierreLiquidacion').val(data[0].idcierreliquidacion);
                $('#hdSaldoInicial').val(saldoinicial);
                $('#lblSaldoInicial').text(saldoinicial);
                $('#txtSaldoInicial').val(saldoinicial);

                CalcularLiquidacion();
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function EnvioAdminDatos (form) {
    var data = new FormData();

    var input_data = $('#modalLiquidacion :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdPrimary', $('#hdIdPrimary').val());
    data.append('hdIdProyecto', $('#hdIdProyecto').val());

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/liquidacion/liquidacion-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    ListarLiquidacion();
                    closeCustomModal('#modalLiquidacion');
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                };
            });
        },
        error:function (data){
            console.log(data);
        }
    });
}

function GuardarDatos () {
    $('#form1').submit();
}

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtSaldoInicial').val('').focus();
}


function GoToEdit () {
    //precargaExp('body', true);
    var recordEdit = $('#tableLiquidacion tr.selected');
    var idrecord = '0';
    
    if (recordEdit.length > 0){
        idrecord = recordEdit.attr('data-idliquidacion');
        
        $.ajax({
            url: 'services/liquidacion/liquidacion-search.php',
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
                $('#hdIdPrimary').val(data[0].tm_idliquidacion);
                $('#ddlAnho').val(data[0].tm_per_ano);
                $('#ddlMes').val(data[0].tm_per_mes);
                $('#txtSaldoInicial').val(data[0].tm_saldoinicial);

                setProyecto(data[0].tm_idproyecto, data[0].nombreproyecto);
            };
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    };

    openCustomModal('#modalLiquidacion');
}

function RegistrarSaldoInicial () {
    var data = new FormData();

    var input_data = $('#modalSaldoInicial :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdCierreLiquidacion', $('#hdIdCierreLiquidacion').val());
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/liquidacion/liquidacion-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);
            if (data.rpta != '0'){
                $('#modalSaldoInicial').modal('hide');
                ListarLiquidacion();
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarCobranza_Resumen () {
    precargaExp('#gvCobranza', true);

    $.ajax({
        url: 'services/cobranza/cobranza-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'LIQUIDACION',
            tipobusqueda: '1',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            precargaExp('#gvCobranza', false);

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + data[i].nombremes + '</td>';
                    strhtml += '<td>' + data[i].importe + '</td>';
                    strhtml += '<td><button type="button" data-action="view-details" class="btn btn-primary" data-mes="' + data[i].numeromes + '">VER DETALLE</button></td>';
                    strhtml += '</tr>';
                    ++i;
                };
            }

            $('#gvCobranza tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarCobranzas_Proceso (mes) {
    $.ajax({
        url: 'services/cobranza/cobranza-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'COBRANZAS',
            tipobusqueda: '1',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: mes
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';

            precargaExp('#tableCobranza_Detalle', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-idconceptocobranza="' + data[i].td_idconsumoescalonable + '">';
                    // strhtml += '<td>' + data[i].propiedad + '</td>';

                    strhtml += '<td>' + data[i].tipooperacion + '</td>';
                    strhtml += '<td>' + convertDate(data[i].td_fecha) + '</td>';
                    strhtml += '<td>' + data[i].td_num_operacion + '</td>';
                    strhtml += '<td class="consumo">' + Number(data[i].td_valorconcepto).toFixed(2) + '</td>';
                    
                    // strhtml += '<td>' + data[i].nombrebanco + '</td>';
                    // strhtml += '<td>' + data[i].descripcioncuenta + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            }

            $('#tableCobranza_Detalle tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function ListarGastos_Proceso (tipogasto) {
    var selectorgrid = '#tableGasto_Detalle';
    var selector = selectorgrid + ' tbody';

    precargaExp(selectorgrid, true);

    $.ajax({
        url: 'services/gasto/gasto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'DETALLADO',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            tipogasto: tipogasto
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var iditem = '0';

            var countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    iditem = data[i].idgastoproyecto;
                    strhtml += '<tr data-idgasto="' + iditem + '">';

                    strhtml += '<td>' + data[i].desctipogasto + '</td>';
                    strhtml += '<td>' + data[i].desctipodesembolso + '</td>';
                    strhtml += '<td>' + data[i].desctipoafectacion + '</td>';
                    strhtml += '<td>' + convertDate(data[i].fecha_documento) + '</td>';
                    strhtml += '<td>' + data[i].numerosuministro + '</td>';
                    strhtml += '<td>' + data[i].descripciongasto + '</td>';
                    strhtml += '<td>' + arrMeses[parseInt(data[i].per_mes) - 1] + '</td>';
                    strhtml += '<td>' + data[i].per_anho + '</td>';
                    strhtml += '<td>' + Number(data[i].importe).toFixed(2) + '</td>';


                    strhtml += '</tr>';
                    ++i;
                };

                $(selector).html(strhtml);
            }
            else
                $(selector).html('<h2>No hay datos.</h2>');

            precargaExp(selectorgrid, false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarGasto_Resumen () {
    precargaExp('#gvGasto', true);

    $.ajax({
        url: 'services/gasto/gasto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'LIQUIDACION',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';

            precargaExp('#gvGasto', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + data[i].tipogasto + '</td>';
                    strhtml += '<td>' + Number(data[i].importe).toFixed(2) + '</td>';
                    strhtml += '<td><button type="button" data-action="view-details" class="btn btn-primary" data-tipogasto="' + data[i].codtipogasto + '">VER DETALLE</button></td>';
                    strhtml += '</tr>';
                    ++i;
                };
            }

            $('#gvGasto tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ObtenerTotal_Cobranza (idproyecto, anho, mes) {
    $.ajax({
        url: 'services/cobranza/cobranza-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'TOTAL',
            idproyecto: idproyecto,
            anho: anho,
            mes: mes
        },
        success: function (data) {
            var total = Number(data).toFixed(2);
            $('#lblCobranza').text('S/. ' + total);
            $('#hdCobranza').val(total);

            CalcularLiquidacion();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ObtenerTotal_Gasto (idproyecto, anho, mes) {
    $.ajax({
        url: 'services/gasto/gasto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'TOTAL',
            idproyecto: idproyecto,
            anho: anho,
            mes: mes
        },
        success: function (data) {
            var total = Number(data).toFixed(2);
            $('#lblGasto').text('S/. ' + total);
            $('#hdGasto').val(total);

            CalcularLiquidacion();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function CalcularLiquidacion () {
    var saldoinicial = Number($('#hdSaldoInicial').val());
    var totalcobranza = Number($('#hdCobranza').val());
    var totalgasto = Number($('#hdGasto').val());


    var total = ((saldoinicial + totalcobranza) - totalgasto).toFixed(2);

    $('#hdSaldo').val(total);
    $('#lblSaldo').text('S/. ' + total);
}

function ShowPanel(tipoconsulta, mes, tipogasto) {
    $('#pnlDatosDetalle').fadeIn(400, function () {
        var titulofiltro = '';
        if (tipoconsulta == 'cobranza'){
            ListarCobranzas_Proceso(mes);
            $('#tableCobranza_Detalle').removeClass('hide');
            $('#tableGasto_Detalle').addClass('hide');
            titulofiltro = 'DETALLE DE COBRANZAS';
        }
        else {
            titulofiltro = 'DETALLE DE GASTOS';
            $('#tableCobranza_Detalle').addClass('hide');
            $('#tableGasto_Detalle').removeClass('hide');
            ListarGastos_Proceso(tipogasto);
        };

        $('#txtTituloFiltro').text(titulofiltro);
    });
}