$(function () {
    $('#txtFechaIniConsumo').mask('99/99/9999');
    cargarDatePicker('#txtFechaIniConsumo', function (dateText, inst) {
    });

    $('#txtFechaFinConsumo').mask('99/99/9999');
    cargarDatePicker('#txtFechaFinConsumo', function (dateText, inst) {
    });

    $('#txtImporteSaldo').on('focus', function(event) {
        event.preventDefault();
        $(this).select();
    });

    $('#btnIngresoFechasConsumo').on('click', function(event) {
        event.preventDefault();

        $('#txtFechaFinConsumo').val('');
        $('#txtFechaIniConsumo').val('');

        bootbox.confirm('¿Desea utilizar el rango de fechas que provee el sistema, el cual toma como referencia inicial el año y el mes del proceso actual?', function (result) {
            if (result){
                var fechaIni = new Date($('#hdAnho').val(), Number($('#hdMes').val()) - 1, 1);
                $('#txtFechaIniConsumo').val(moment(fechaIni).format('DD/MM/YYYY'));
                
                var fechaFin = new Date(fechaIni.setMonth(fechaIni.getMonth()+1));
                $('#txtFechaFinConsumo').val(moment(fechaFin).format('DD/MM/YYYY'));

                IngresarFechasConsumo();
            }
            else {
                openModalCallBack('#modalIngresoFechasConsumo', function () {
                    $('#txtFechaIniConsumo').focus();
                });
            };
        });
    });

    $('#btnIngresarFechasConsumo').on('click', function(event) {
        event.preventDefault();
        IngresarFechasConsumo();
        closeCustomModal('#modalIngresoFechasConsumo');
    });

    $("#txtSearchConcepto").easyAutocomplete({
        url: function (phrase) {
            return "services/concepto/concepto-search.php?criterio=" + phrase + "&tipobusqueda=4&tipoconcepto=02&idproyecto=" + $('#hdIdProyecto').val();
        },
        getValue: function (element) {
            return element.tm_idconcepto +  ' - ' + element.tm_descripcionconcepto;
        },
        list: {
            onChooseEvent: function () {
                var value = $("#txtSearchConcepto").getSelectedItemData().tm_idconcepto;

                $("#hdIdConcepto").val(value).trigger("change");

                $('#btnConsultarConsumo').trigger('click');
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_idconcepto +  ' - ' + item.tm_descripcionconcepto;
            }
        },
        theme: "square"
    });

    $('#btnCancelarCalculoAgua').on('click', function(event) {
        event.preventDefault();
        $('#pnlCalculoAguaMeses').fadeOut(400, function () {
            /*paginaPropiedad = 1;
            ListarPropiedades('1');*/
        });
    });

    $('#btnExportarPropiedad').on('click', function(event) {
        event.preventDefault();
        ExportarPropiedades();
    });

    $('#btnExportarPropiedad_Concepto').on('click', function(event) {
        event.preventDefault();
        ExportarPropiedades_Concepto();
    });    

    $('#btnExportarFacturasExcel').on('click', function(event) {
        event.preventDefault();
        ExportarDetalleFacturas();
    });

    $('#btnExportarTotalesFacturaExcel').on('click', function(event) {
        event.preventDefault();
        ExportarTotalesFacturaExcel();
    });

    $('#btnImportarPropiedad').on('click', function(event) {
        event.preventDefault();
        $('#hdTipoImportacion').val('00');
        $('#pnlImportConsumo').removeClass('gp-no-header').find('.gp-header').removeClass('oculto');

        $('#pnlInfoConcepto').removeClass('hide');
        openCustomModal('#modalUploadExcel');
    });

    $('#btnImportarPropiedad_Concepto').on('click', function(event) {
        event.preventDefault();
        $('#hdTipoImportacion').val('01');
        $('#pnlImportConsumo').removeClass('gp-no-header').find('.gp-header').removeClass('oculto');

        $('#pnlInfoConcepto').addClass('hide');
        openCustomModal('#modalUploadExcel');
    });

    $('#btnImportarDetalleFacturas').on('click', function(event) {
        event.preventDefault();
        $('#hdTipoImportacion').val('01');
        $('#pnlImportConsumo').addClass('gp-no-header').find('.gp-header').addClass('oculto');
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

    $('#ddlTipoPropiedadFacturacion').on('change', function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarFacturacion('#gvGenFacturacion', '1');
    });

    $('#txtSearchFacturacion').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchFacturacion').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnGeneracionConceptoVariable').on('click', function(event) {
        event.preventDefault();
        
        $('#lblTotalConsumo_Gen').text($('#lblTotalConsumo_Soles').text());
        $('#hdTotalConsumo_Gen').val($('#lblTotalConsumo_Soles').text());

        habilitarControl('#btnGenerarConceptoVariable', true);
        openCustomModal('#modalConceptoVariableGen');
    });

    $('#btnGenerarConceptoVariable').on('click', function(event) {
        event.preventDefault();
        GenerarConceptoVariable();
    });

    $('#btnSearchFacturacion').on('click', function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarFacturacion('#gvGenFacturacion', '1');
    });
    
    $('#groupOpcionesFactura').on('click', 'button', function(event) {
        var targedId = this.getAttribute('data-target');

        $(this).siblings('.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        $('#pnlListado > .gp-body section.tab-principal').hide();
        $(targedId).show();

        if (targedId == '#tabFacturacion'){
            addValidFormRegister();
            // $('#campoConsultar, #campoNuevaInfo, #campoConcepto').hide();
            // $('#campoFechaVencimiento, #campoFechaTope').show();

            $('#groupVistaConsumo, #groupConcepto').addClass('hide');
            $('#groupFechas').removeClass('hide');
            /*if ($('#gvGenFacturacion .dato').length == 0){
            };*/
            paginaGenFacturacion = 1;
            ListarFacturacion('#gvGenFacturacion', '1');
        }
        else {
            removeValidFormRegister();
            if (targedId == '#tabCalculoEscalonable'){
                // $('#campoFechaVencimiento, #campoFechaTope, #campoConcepto').hide();
                // $('#campoConsultar, #campoNuevaInfo').show();
                $('#btnConsultarConsumo').trigger('click');
                $('#groupFechas, #groupConcepto').addClass('hide');
                $('#groupVistaConsumo').removeClass('hide');
                $('#btnNuevoConsumo').removeClass('hide');
            }
            else if (targedId == '#tabConceptoVariable'){
                $('#btnConsultarConsumo').trigger('click')
                // $('#campoFechaVencimiento, #campoFechaTope').hide();
                // $('#campoConsultar, #campoNuevaInfo, #campoConcepto').show();
                $('#groupFechas').addClass('hide');
                $('#groupVistaConsumo, #groupConcepto').removeClass('hide');
                $('#btnNuevoConsumo').removeClass('hide');
            }
            else if (targedId == '#tabCalculoAscensor'){
                $('#btnConsultarConsumo').trigger('click')
                // $('#campoFechaVencimiento, #campoFechaTope, #campoNuevaInfo, #campoConcepto').hide();
                // $('#campoConsultar').show();
                $('#groupFechas, #groupConcepto').addClass('hide');
                $('#groupVistaConsumo').removeClass('hide');
                $('#btnNuevoConsumo').addClass('hide');
            };
        };
    });

    // $('#ddlAnho').on('change', function(event) {
    //     event.preventDefault();
    //     if ($('#tabFacturacion').is(':visible')){
    //         paginaGenFacturacion = 1;
    //         ListarFacturacion('#gvGenFacturacion', '1');
    //     }
    //     else {
    //         $('.span-button.success').trigger('click');
    //     };
    // });

    // $('#ddlMes').on('change', function(event) {
    //     event.preventDefault();
    //     if ($('#tabFacturacion').is(':visible')){
    //         paginaGenFacturacion = 1;
    //         ListarFacturacion('#gvGenFacturacion', '1');
    //     }
    //     else {
    //         $('.span-button.success').trigger('click');
    //     };
    // });

    $('#txtSearchFiltro').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchFiltro').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchFiltro').on('click', function(event) {
        event.preventDefault();
        ListarProyectos('1');
    });

    $('#groupVistaConsumo').on('click', '.span-button', function(event) {
        event.preventDefault();

        var elementMain = $('#groupOpcionesFactura .btn-success');
        var targedId = this.getAttribute('data-target');
        var targedMainId = elementMain.attr('data-target');

        $('#groupVistaConsumo .btn.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        if (targedMainId == '#tabCalculoEscalonable'){
            $('#pnlTotalConsumoSoles').removeClass('hide');
            ListarPropiedadConsumo(targedId);
            ListarSumaConceptoAgua();
        }
        else if (targedMainId == '#tabConceptoVariable'){
            $('#pnlTotalConsumoSoles').addClass('hide');
            if ($('#hdIdConcepto').val() > '0')
                ListarPropiedadConsumo_Concepto(targedId);
        }
        else if (targedMainId == '#tabCalculoAscensor'){
            $('#pnlTotalConsumoSoles').addClass('hide');
            ListarTorreSuministro();
        };
    });

    $('#txtFechaVencimiento').mask('99/99/9999');
    cargarDatePicker('#txtFechaVencimiento', function (dateText, inst) {
    });

    $('#txtFechaTope').mask('99/99/9999');
    cargarDatePicker('#txtFechaTope', function (dateText, inst) {
    });

    /*$('#gvDepartamento').add('#gvEstacionamiento').add('#gvDeposito').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var checkBox = $(this).find('input:checkbox');
        
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            //$(this).find('.expand-data').slideUp();
            checkBox.removeAttr('checked');
            if ($('#gvDepartamento .dato.selected').length == 0){
                $('#btnLimpiarSeleccion, #btnGenerar').addClass('oculto');
            };
        }
        else {
            $(this).addClass('selected');
            //$(this).find('.expand-data').slideDown();
            checkBox.attr('checked', '');
            $('#btnLimpiarSeleccion, #btnGenerar').removeClass('oculto');
        };
    });*/

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#hdIdPrimary').val('0');
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnSelectAll').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnGenerar').addClass('oculto');
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDatos .dato').addClass('selected');
        $('#gvDatos input:checkbox').attr('checked', '');
        $('#btnLimpiarSeleccion, #btnGenerar').removeClass('oculto');
    });

    $('#gvDatos > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePresupuesto').val());

            ListarPresupuesto(paginaActual);
        };
    });

    $('#btnBackPrevPanel').on('click', function(event) {
        event.preventDefault();
        BackToPrevPanel();
    });

    $('#btnAddDetalle').on('click', function(event) {
        var pestana;
        event.preventDefault();
        //openCustomModal('#modalRegistro');
    });

    $('#pnlInfoProyecto').add('#pnlConsumoProyecto').add('#pnlInfoConcepto').on('click', function(event) {
        event.preventDefault();
        var panelinfo;
        var tipofiltro = '';
        var titulofiltro = '';
        
        panelinfo = this;
        tipofiltro = panelinfo.getAttribute('data-tipofiltro');
        titulofiltro = panelinfo.getAttribute('data-hint');

        paginaFiltro = 1;
        
        if (tipofiltro == 'proyecto' || tipofiltro == 'consumo' || tipofiltro == 'concepto'){
            $('#pnlDatosFiltro').removeClass('with-appbar');
            $('#pnlDatosFiltro .appbar').addClass('oculto');

            if (tipofiltro == 'concepto')
                ListarConcepto('1');
            else
                ListarProyectos('1');
        };

        $('#pnlDatosFiltro').attr('data-tipofiltro', tipofiltro);
        $('#txtTituloFiltro').text(titulofiltro);
        
        $('#pnlDatosFiltro').fadeIn(400, function () {

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
            };
        };
    });

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

    $('#btnAsignFilter').on('click', function(event) {
        event.preventDefault();
        AgregarPresupuesto();
    });

    $('#gvFiltro').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var pnlDatosFiltro;
        var iddata = '0';
        var nombre = '';
        var escobrodiferenciado = '0';
        var tiporesultado = '';
        var tipofiltro = '';
        var checkBox;

        pnlDatosFiltro = document.getElementById('pnlDatosFiltro');
        tipofiltro = pnlDatosFiltro.getAttribute('data-tipofiltro');

        if (tipofiltro == 'proyecto'){
            iddata = this.getAttribute('data-idproyecto');
            nombre = this.getAttribute('data-nombre');
            escobrodiferenciado = this.getAttribute('data-escobrodiferenciado');

            $('#ddlMes').val(this.getAttribute('data-mes'));
            setProyecto(iddata, nombre, escobrodiferenciado);
        }
        else if (tipofiltro == 'consumo'){
            iddata = this.getAttribute('data-idproyecto');
            nombre = this.getAttribute('data-nombre');
            escobrodiferenciado = this.getAttribute('data-escobrodiferenciado');

            //$('#ddlMesInicio').val(this.getAttribute('data-mes'));
            setConsumoProyecto(iddata, nombre, escobrodiferenciado);
        }
        else if (tipofiltro == 'concepto'){
            // checkBox = $(this).find('input:checkbox');
        
            // if ($(this).hasClass('selected')){
            //     $(this).removeClass('selected');
            //     //$(this).find('.expand-data').slideUp();
            //     checkBox.removeAttr('checked');
            //     if ($('#gvFiltro .dato.selected').length == 0){
            //         $('#btnClearFilter, #btnAsignFilter').addClass('oculto');
            //     };
            // }
            // else {
            //     $(this).addClass('selected');
            //     //$(this).find('.expand-data').slideDown();
            //     checkBox.attr('checked', '');
            //     $('#btnClearFilter, #btnAsignFilter').removeClass('oculto');
            // };
            iddata = this.getAttribute('data-idconcepto');
            nombre = this.getAttribute('data-descripcion');

            setConcepto(iddata, nombre);
        };
    });
    
    //ListarPropiedades('1');
    
    /*$("#tabDetalle").tabcontrol().bind("tabcontrolchange", function(event, frame){
        paginaPropiedad = 1;
        ListarPropiedades('1');
    });*/

    /*$('#ddlTipoPropiedadFiltro').on('change', function(event) {
        event.preventDefault();
        paginaPropiedad = 1;
        ListarPropiedades('1');
    });

    $('#txtSearchPropiedad').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchPropiedad').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchPropiedad').on('click', function(event) {
        event.preventDefault();
        paginaPropiedad = 1;
        ListarPropiedades('1');
    });

    $('#gvPropiedad').on('click', '.dato', function(event) {
        event.preventDefault();
        
        $(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#gvPropiedad > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropiedad').val());

            ListarPropiedades(paginaActual);
        };
    });*/

    /*$('#gvEstacionamiento > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropiedad').val());

            ListarPropiedades(paginaActual);
        };
    });

    $('#gvDeposito > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropiedad').val());

            ListarPropiedades(paginaActual);
        };
    });*/

    $('#gvGenFacturacion > .gridview').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageGenFacturacion').val());

            ListarFacturacion('#gvGenFacturacion', paginaActual);
        };
    });

    $('#gvGenFacturacion').on('click', '.dato', function(event) {
        event.preventDefault();
        var idfacturacion = '0';

        $('#gvGenFacturacion .dato.selected').removeClass('selected');
        $(this).addClass('selected');

        idfacturacion = this.getAttribute('data-idfacturacion');

        ListarDetalle(idfacturacion);
    });

    $('#btnEliminar').on('click', function (event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarFacturacion();
        };
    });

    /*$(document).on('keyup', function (e) {
        try {
            var dir = o[e.which];
            var $active = $('#gvGenFacturacion .dato.selected'),
                i = $card.index($active);
            var scrollPropiedades;
            var iScroll = 0;
            var heightCard = 0;

            if (e.which == 13) {
                //$('#gvGenFacturacion .dato.selected').removeClass('selected');
                //$active.addClass('selected');
                $active.trigger('click');
                return;
            };

            if (!$active.length) {
                //$card.first().addClass('selected');
                $card.first().trigger('click');
                return;
            }
            else {
                if (dir === 'next' || dir === 'prev') {
                    //$active.removeClass('selected')[dir]().addClass('selected');
                    $active.removeClass('selected')[dir]().trigger('click');
                }
                else {
                    var p = dir === 'up' ? (i - 3) : (i + 3);
                    heightCard = $card.eq(p).height() + 15;

                    //$card.removeClass('selected').eq(p).addClass('selected');
                    $card.removeClass('selected').eq(p).trigger('click');
                    
                    scrollPropiedades = $('#gvGenFacturacion .gridview');
                    iScroll = scrollPropiedades.scrollTop();

                    iScroll = dir === 'up' ? (iScroll - heightCard) : (iScroll + heightCard);
                    scrollPropiedades.animate({ scrollTop: iScroll  }, 400, function () {
                        
                    });
                };
            };
        }
        catch(error){
            console.log(error.message);
        };
    });*/

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate
    });

    $('#btnEnviarEmail').on('click', function(event) {
        event.preventDefault();
        var confirmar = confirm('¿Desea iniciar el envío de facturas por corre? Esto puede llevar varios minutos...');
        
        if (confirmar) {
            GenerarPDF('EMAIL');
        };
    });

    $('#btnImprimirFactura').on('click', function(event) {
        event.preventDefault();

        MessageBox('¿Que desea hacer?', 'M&oacute;dulo de impresi&oacute;n', '[Salir sin cambios], [Ver impresion], [Generar impresion]', function(action){
            if (action == 'Ver impresion'){
                VerImpresion('media/pdf/' + $('#hdIdProyecto').val() + $('#hdAnho').val() + $('#hdMes').val() + '.pdf?new=' + new Date().getTime());
            }
            else if (action == 'Salir sin cambios') {
                alert('No se realizó ninguna operación')
            }
            else {
                GenerarPDF('EXPORTACION');
            };
        });
    });

    $('#tablePropiedad tbody').on({
        click: function(event) {
            event.preventDefault();
            if ($(this).hasClass('lecanterior') || $(this).hasClass('lecactual')) {
                $(this).select();
                return false;
            };
        },
        keyup: function (event) {
            if ($(this).hasClass('lecanterior') || $(this).hasClass('lecactual')) {
                var lecanterior = 0;
                var lecactual = 0;

                if ($(this).hasClass('lecanterior')){
                    lecanterior = Number($(this).val());
                    lecactual = Number($(this).parent().parent().find('.lecactual').val());
                }
                else if ($(this).hasClass('lecactual')){
                    lecanterior = Number($(this).parent().parent().find('.lecanterior').val());
                    lecactual = Number($(this).val());
                };

                var consumo = lecactual - lecanterior;

                if (consumo < 0)
                    $(this).parent().parent().addClass('red white-text');
                else
                    $(this).parent().parent().removeClass('red white-text');

                $(this).parent().parent().find('.consumo').text(consumo.toFixed(3));
                $(this).parent().parent().find('.input-consumo').val(consumo.toFixed(3));
            };
        }
    }, 'input:text');

    $('#btnCalcularConsumo').on('click', function(event) {
        event.preventDefault();
        RegistrarCalculoConsumo();
    });

    $('#btnCalcularConsumo_Concepto').on('click', function(event) {
        event.preventDefault();
        RegistrarCalculoConsumo_Concepto();
    });

    $('#btnCalConsumoMeses').on('click', function(event) {
        event.preventDefault();
        ShowPanelCalculoAguaMeses();
    });

    $('#btnGenerarCalculoAgua').on('click', function(event) {
        event.preventDefault();
        CalcularAguaMeses();
    });

    $('#btnBackToFacturacion').on('click', function(event) {
        event.preventDefault();
        $('#pnlCalculoAguaMeses').fadeOut(400, function() {
            
        });
    });

    $('#btnConfirmarTorre').on('click', function(event) {
        event.preventDefault();
        RegistrarTorreConsumo();
    });

    $('#btnGuardarConcepto').on('click', function(event) {
        event.preventDefault();
        GuardarConceptoFact();
    });

    $('#btnCloseGenPDF').add('#btnCancelarEnvio').on('click', function(event) {
        event.preventDefault();

        if (completado == false){
            confirma = confirm('¿Está seguro de cancelar el envío?');
            
            if (confirma){
                progress = 0;
                indexList = 0;
                
                // if (intervalIndividual.isRunning())
                //     intervalIndividual.stop();

                abandonarTodasLasPeticiones();
            };
        };

        closeCustomModal('#modalGenPDF');
    });

    $('#btnCloseGenFacturacion').add('#btnCancelarEnvio_Facturacion').on('click', function(event) {
        event.preventDefault();

        if (completado == false){
            confirma = confirm('¿Está seguro de cancelar el envío?');
            
            if (confirma){
                progress = 0;
                indexList = 0;
                
                // if (intervalIndividual.isRunning())
                //     intervalIndividual.stop();

                abandonarTodasLasPeticiones();
            };
        };

        closeCustomModal('#modalGenFacturacion');
    });

    $('#btnFinalizarEnvio').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#modalGenPDF');
    });

    $('#btnFinalizarEnvio_Facturacion').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#modalGenFacturacion');
    });

    var xhrRequests = [];

    // Cada vez que se hace una peticion, la agregamos al arreglo
    $(document).ajaxSend(function(e, jqXHR, options) {
        xhrRequests.push(jqXHR);
    });
 
    // Y al completarse la peticion la eliminamos del arreglo, de lo contrario se quedara para ser cancelada
    $(document).ajaxComplete(function(e, jqXHR, options) {
        xhrRequests = $.grep(xhrRequests, function(x) {
            return x != jqXHR;
        });
    });
 
    // Recorrer cada peticion y cancelarla
    var abandonarTodasLasPeticiones = function() {
        completado = true;
        $.each(xhrRequests, function(idx, jqXHR) {
            jqXHR.abort();
        });
    };

    $('#btnDivisionFactura').on('click', function(event) {
        event.preventDefault();

        var factura;
        var idfacturacion = '0';
        var idpropiedad = '0';
        var nropropiedad = '';
        var idproyecto = '0';
        var anho = '';
        var mes = '';
        var nombremes = '';

        factura = $('#gvGenFacturacion .dato.selected')[0];
        idfacturacion = factura.getAttribute('data-idfacturacion');
        idpropiedad = factura.getAttribute('data-idpropiedad');
        nropropiedad = factura.getAttribute('data-nombre');
        idproyecto = $('#hdIdProyecto').val();
        anho = $('#hdAnho').val();
        mes = $('#hdMes').val();
        nombremes = arrMeses[Number($('#hdMes').val()) - 1];

        $('#lblNroPropiedad').attr({
            'data-idfacturacion': idfacturacion,
            'data-idpropiedad': idpropiedad
        }).text(nropropiedad);
        
        $('#lblAnhoMesDiv').text(nombremes + '-' + anho);

        openModalCallBack('#modalDivision', function () {
            ListarIncidencias(idpropiedad, idproyecto, anho, mes);
        });
    });

    $('#txtNroPropietarios').on({
        keydown: function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER){
                if ($('#tablePropietario tbody tr').length > 0) {
                    $('#tablePropietario tbody .inputTextInTable:first-child').focus();
                };
                return false;
            }
        },
        keypress : function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER)
                return false;
        },
        keyup : function(event) {
            ConfigurarFilasIncidencia();
        }
    });

    $('#tablePropietario tbody').on('click', 'tr[data-seleccionable="true"]', function(event) {
        event.preventDefault();
        
        var url = 'index.php?pag=admin&subpag=propietario&screenmode=search';

        $('#tablePropietario tbody tr[data-seleccionable="true"]').attr('data-edit', 'false');
        $(this).attr('data-edit', 'true');

        $('#pnlSearchPropietario').fadeIn(400, function() {
            if (!$('#ifrSearchPropietario').hasClass('loaded')){
                $('#ifrSearchPropietario').attr('src', url).addClass('loaded');
            };
        });
    });

    $('#tablePropietario tbody').on('click', '.inputTextInTable', function(event) {
        event.preventDefault();
        return false;
    });

    $('#ifrSearchPropietario').on('load', function(){
        $(this).contents().find('body, body *').on('click', function(event) {
            window.top.hideAllSlidePanels();
        });
    });

    $('#btnDividirFactura').on('click', function(event) {
        event.preventDefault();
        DividirFactura();
    });

    $('#tableConcepto tbody').on('keyup', '.inputTextInTable', function(event) {
        event.preventDefault();
        CalcularTotal();
    });

    $('#btnGenerar').on('click', function(event) {
        event.preventDefault();

        var estadoproceso = window.top.estadoproceso;

        if (estadoproceso == 1)
            EliminarFacturacionPrevia();
        else
            bootbox.alert('El proceso con el que se está trabajando está cerrado, no es posible generar con un proceso cerrado');
    });

    $('#btnRegenerar').on('click', function(event) {
        event.preventDefault();

        var estadoproceso = window.top.estadoproceso;

        if (estadoproceso == 1)
            RegenerarFacturacion();
        else
            bootbox.alert('El proceso con el que se está trabajando está cerrado, no es posible generar con un proceso cerrado');
    });

    $('#btnHideImpresion').on('click', function(event) {
        event.preventDefault();
        $('#pnlImpresionFactura').fadeOut(400);
    });

    $('#btnVistaPrevia').on('click', function(event) {
        event.preventDefault();
        GenerarIndividual();
    });
});

var paginaPropiedad = 1;
var paginaFiltro = 1;
var paginaProyecto = 1;
var paginaConcepto = 1;
var paginaFacturacion = 1;
var paginaGenFacturacion = 1;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var indexList = 0;
var elemsSelected;
var progress = 0;
var completado = false;
var nroFacturas = 0;
var fileValue = false;
var progressError = false;
var progressSuccess = false;
// var intervalIndividual = new Interval(function(){
//     $('#pbProgresoIndividual').progressbar('value', (++progress));
//     if (progress == 100){
//         intervalIndividual.stop();
//     };
// }, 100);

function IniciarForm () {
    var idproyecto = window.top.idproyecto;
    var anho = window.top.anho;
    var mes = window.top.mes;
    var escobrodiferenciado = window.top.escobrodiferenciado;
    var estadoproceso = window.top.estadoproceso;
    
    $('#hdIdProyecto').val(idproyecto);
    $('#hdIdConsumoProyecto').val(idproyecto);
    $('#hdAnho').val(anho);
    $('#hdMes').val(mes);

    if (escobrodiferenciado == '0') {
        $('#btnAscensor').addClass('oculto');
        if ($('#tabCalculoAscensor').is(':visible'))
            $('#groupOpcionesFactura .btn:first').trigger('click');
    }
    else
        $('#btnAscensor').removeClass('oculto');

    if ($('#tabFacturacion').is(':visible')){
        paginaGenFacturacion = 1;
        ListarFacturacion('#gvGenFacturacion', '1');
    }
    else
        $('#groupVistaConsumo .btn.btn-success').trigger('click');
    // RegistroPorDefecto();
    // RegistroPorDefectoId(idproyecto);
}

function ListarConcepto (pagina) {
    var selectorgrid = '#gvFiltro';
    var selector = selectorgrid + ' .gridview';
    var tipobusqueda = '';
    var criterio = '';

    precargaExp(selectorgrid, true);

    $(selector).addClass('items-area').addClass('listview').removeClass('card-area');

    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '4',
            id: '0',
            idproyecto: $('#hdIdProyecto').val(),
            criterio: $('#txtSearchFiltro').val(),
            tipoconcepto: '02',
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].tm_idconcepto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idconcepto="' + iditem + '" data-tipoconcepto="' + data[i].ta_tipoconcepto + '" data-descripcion="' + data[i].tm_descripcionconcepto + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].tm_descripcionconcepto + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                paginaConcepto = paginaConcepto + 1;

                $('#hdPageConcepto').val(paginaConcepto);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No hay datos.</h2>');
            };
            
            precargaExp(selectorgrid, false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ShowPanelCalculoAguaMeses () {
    $('#pnlCalculoAguaMeses').fadeIn(400, function () {
        /*paginaPropiedad = 1;
        ListarPropiedades('1');*/
    });
}

function CalcularAguaMeses () {
    var data = new FormData();

    precargaExp('#tableConsumoAgua', true);

    data.append('tipo', 'CONSUMOAGUAMES');
    data.append('idproyecto', $('#hdIdConsumoProyecto').val());
    data.append('mesini', $('#ddlMesInicio').val());
    data.append('mesfin', $('#ddlMesFin').val());

    $.ajax({
        type: 'GET',
        url: 'services/facturacion/facturacion-search.php',
        dataType: 'json',
        data: {
            tipo: 'CONSUMOAGUAMES',
            idproyecto: $('#hdIdConsumoProyecto').val(),
            mesini: $('#ddlMesInicio').val(),
            mesfin: $('#ddlMesFin').val()
        },
        cache: false,
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            precargaExp('#tableConsumoAgua', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-idpropiedad="' + data[i].idpropiedad + '">';
                    strhtml += '<td>' + data[i].descripcionpropiedad + '</td>';
                    strhtml += '<td class="consumo">' + Number(data[i].consumopromedio).toFixed(2) + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };

                $('#btnCalcularConsumo').removeClass('oculto');
            }
            else {
                $('#btnCalcularConsumo').addClass('oculto');
            };

            $('#tableConsumoAgua tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
    
}

function setPropietario (idpropietario, descripcion) {
    var linkpropietario;

    linkpropietario = $('#tablePropietario tbody tr[data-edit="true"]');

    linkpropietario.attr({
        'data-edit': 'false',
        'data-idpropietario': idpropietario
    }).find('h3').text(descripcion);
    
    closePanelPropietario();
}

function closePanelPropietario () {
    $('#pnlSearchPropietario').fadeOut(400);
}

function RegistroPorDefectoId (idproyecto) {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'defecto',
            tipobusqueda: idproyecto
        },
        success: function (data) {
            var countdata = 0;
            var idproyecto = '0';
            var descripcion = '';
            var escobrodiferenciado = '';

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].mesproceso) - 1] + ' ' + data[0].anhoproceso;
                escobrodiferenciado = data[0].escobrodiferenciado;

                $('#ddlMes').val(data[0].mesproceso);
                setProyecto(idproyecto, descripcion, escobrodiferenciado);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}


function RegistroPorDefecto () {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {tipo: 'defecto'},
        success: function (data) {
            var countdata = 0;
            var idproyecto = '0';
            var descripcion = '';
            var escobrodiferenciado = '';

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].mesproceso) - 1] + ' ' + data[0].anhoproceso;
                escobrodiferenciado = data[0].escobrodiferenciado;

                $('#ddlMes').val(data[0].mesproceso);
                setProyecto(idproyecto, descripcion, escobrodiferenciado);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function setProyecto (idproyecto, nombre, escobrodiferenciado) {
    $('#hdIdProyecto').val(idproyecto);
    $('#hdIdConsumoProyecto').val(idproyecto);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto .info .descripcion').text(nombre);

    $('#pnlConsumoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlConsumoProyecto .info .descripcion').text(nombre);

    if (escobrodiferenciado == '0') {
        $('#btnAscensor').addClass('oculto');
        if ($('#tabCalculoAscensor').is(':visible')) {
            $('#pnlListado > .title-window button:first').trigger('click');
        };
    }
    else {
        $('#btnAscensor').removeClass('oculto');
    };

    $('#pnlDatosFiltro').fadeOut('400', function() {
        var today = new Date();
        var yyyy = today.getFullYear();
        
        //paginaPropiedad = 1;

        ListarAnhoProceso(yyyy);
        //ListarPropiedades('1');
    });
}

function setConsumoProyecto (idproyecto, nombre, escobrodiferenciado) {
    $('#hdIdConsumoProyecto').val(idproyecto);

    $('#pnlConsumoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlConsumoProyecto .info .descripcion').text(nombre);

    $('#pnlDatosFiltro').fadeOut('400', function() {
    });
}

function setConcepto (idconcepto, nombre, escalonable) {
    $('#hdIdConcepto').val(idconcepto);
    $('#hdConceptoEscalonable').val(escalonable);

    $('#pnlInfoConcepto').attr('data-idconcepto', idconcepto);
    $('#pnlInfoConcepto .info .descripcion').text(nombre);

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
        data: "tipo=asignacion&criterio=" + $('#txtSearchFiltro').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idproyecto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' + data[i].nombreproyecto + '" data-escobrodiferenciado="' + data[i].escobrodiferenciado + '" data-mes="' + data[i].mesproceso + '" data-anho="' + data[i].anhoproceso + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[i].mesproceso) - 1] + ' ' + data[i].anhoproceso + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                paginaFiltro = paginaFiltro + 1;
                $('#hdPageProyecto').val(paginaFiltro);
                
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
            $('#ddlAnhoImport').html(strhtml);

            if ($('#tabFacturacion').is(':visible')){
                paginaGenFacturacion = 1;
                ListarFacturacion('#gvGenFacturacion', '1');
            }
            else {
                $('.span-button.success').trigger('click');
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarPropiedades (pagina) {
    // var idtipopropiedad = '0';

    /*idtipopropiedad = $('#tabDetalle li.active').attr('data-idtipopropiedad');

    if (idtipopropiedad == 'DPT'){
        selectorgrid = '#gvDepartamento';
    }
    else if (idtipopropiedad == 'EST'){
        selectorgrid = '#gvEstacionamiento';
    }
    else if (idtipopropiedad == 'DEP'){
        selectorgrid = '#gvDeposito';
    };*/

    var selectorgrid = '#gvPropiedad';

    precargaExp(selectorgrid, true);

    var selector = selectorgrid + ' .gridview';

    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdProyecto').val(),
            idtipopropiedad: $('#ddlTipoPropiedadFiltro').val(),
            criterio: $('#txtSearchPropiedad').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var strhtml = '';
            var colortile = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].idpropiedad;
                    var idtipopropiedad = data[i].idtipopropiedad;
                    var nombrepropietario = '';
                    
                    if (data[i].descrippersona != null)
                        nombrepropietario = data[i].descrippersona.trim().length == 0 ? '(EN BLANCO)' : data[i].descrippersona;
                    else
                        nombrepropietario = '(EN BLANCO)';

                    if (idtipopropiedad == 'DPT')
                        colortile = ' blue-grey lighten-2';
                    else if (idtipopropiedad == 'DEP')
                        colortile = ' grey darken-1';
                    else if (idtipopropiedad == 'EST')
                        colortile = ' blue-grey';
                    else if (idtipopropiedad == 'TIE')
                        colortile = ' blue-grey darken-1';

                    strhtml += '<div class="tile dato double bg-gray-glass ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-area="' + data[i].area + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="white-text">' + data[i].descripcionpropiedad + '</h2>';
                    strhtml += '<h6 class="padding5 text-ellipsis smaller bg-white text-center fg-dark">' + nombrepropietario + '</h6>';
                    strhtml += '</div></div>';
                    strhtml += '<div class="brand"><span class="badge bg-dark">Area: ' + data[i].area + ' (m<sup>2</sup>)</span></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                };
                
                paginaPropiedad = paginaPropiedad + 1;

                $('#hdPagePropiedad').val(paginaPropiedad);

                if (pagina == 1)
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $(selector).find('.dato').eq(0).trigger('click');
            }
            else {
                if (pagina == 1)
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp(selectorgrid, false);
        }
    });
}

function addValidFormRegister () {
    $('#txtFechaVencimiento').rules('add', {
        required : true,
        date: true
    });

    $('#txtFechaTope').rules('add', {
        required : true,
        date: true
    });
}

function removeValidFormRegister () {
    $('#txtFechaVencimiento').rules('remove');
    $('#txtFechaTope').rules('remove');
}

function GenerarFacturacion () {
    // var input_data;

    indexList = 0;
    progress = 0;
    nroFacturas = 0;
    elemsSelected = [];
    completado = false;
    progressError = false;

    if ($('#form1').valid()){
        precargaExp('#pnlListado > .gp-body', true);
        
        $('#btnFinalizarEnvio_Facturacion').addClass('oculto');
        $('#btnCancelarEnvio_Facturacion').removeClass('oculto');
        
        // input_data = $('#pnlDetalle > .gp-header :input').serializeArray();

        // $.each(input_data, function(key, fields){
        //     data.append(fields.name, fields.value);
        // });

        openModalCallBack('#modalGenFacturacion', function () {
            $.ajax({
                url: 'services/propiedad/propiedad-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipo: 'allfields',
                    tipobusqueda: '4',
                    idtipopropiedad: '*',
                    id: $('#hdIdProyecto').val(),
                    criterio: '',
                    pagina: '0'
                },
                success:  function (data) {
                    precargaExp('#pnlListado > .gp-body', false);

                    var countdata = 0;

                    precargaExp('#modalGenFacturacion', false);
                    
                    elemsSelected = data;
                    countdata = data.length;
                    nroFacturas = countdata;
                    
                    $('#lblNroPropEncontradas').text(countdata);
                    GenerarFacturacion_Individual(data[0]);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        // $.ajax({
        //     url: 'services/facturacion/facturacion-post.php',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: data,
        //     cache: false,
        //     contentType:false,
        //     processData: false,
        //     success: function (data) {
        //         precargaExp('#pnlListado > .gp-body', false);

        //         MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
        //             if (data.rpta != '0'){
        //                 paginaGenFacturacion = 1;
        //                 ListarFacturacion('#gvGenFacturacion', '1');
        //             };
        //         });
        //     },
        //     error: function (data) {
        //         console.log(data);
        //     }
        // });
    };
}

function EliminarFacturacionPrevia () {
    var data = new FormData();

    data.append('btnEliminarFacturacionPrevia', 'btnEliminarFacturacionPrevia');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            if (data.rpta == '0'){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                });
            }
            else
                GenerarFacturacion();
        },
        error:function (data){
            console.log(data);
        }
    });
}

function GenerarFacturacion_Individual (item) {
    var idpropiedad = item.idpropiedad;
    var data = new FormData();

    data.append('btnRegenerar', 'btnRegenerar');
    data.append('hdTipoFacturacion', '1');
    data.append('hdIdPropiedad', idpropiedad);
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());
    data.append('txtFechaVencimiento', $('#txtFechaVencimiento').val());
    data.append('txtFechaTope', $('#txtFechaTope').val());

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            var porcentaje = 0;
            var titulomsje = '';
            var contenidomsje = '';

            ++indexList;
            progressError = false;
            porcentaje = Math.round((indexList * 100) / nroFacturas);
            // pbTotal = $('#pbProgresoTotal');

            // pbIndividual.progressbar('value', 100);
            // pbIndividual.progressbar('color', 'bg-green');

            // if (intervalIndividual.isRunning())
            //     intervalIndividual.stop();
            
            $('#lblNroFactCalculadas').text(indexList);
            $('#lblPorcentajeEnvio_Facturacion').text(porcentaje);
            $('#lblDescripFactura_Facturacion').text(item.idpropiedad + ' - ' + item.descripcionpropiedad);

            if (indexList <= elemsSelected.length - 1){
                // pbTotal.progressbar('value', indexList);
                GenerarFacturacion_Individual(elemsSelected[indexList]);
            }
            else {
                completado = true;
                
                // pbTotal.progressbar('color', 'bg-green');
                // pbTotal.progressbar('value', 100);

                $('#btnFinalizarEnvio_Facturacion').removeClass('oculto');
                $('#btnCancelarEnvio_Facturacion').addClass('oculto');

                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    closeCustomModal('#modalGenFacturacion');
                    if (data.rpta != '0'){
                        paginaGenFacturacion = 1;
                        ListarFacturacion('#gvGenFacturacion', '1');
                    };
                });
            };
        },
        beforeSend: function () {
            // pbIndividual.progressbar('color', 'bg-cyan');
            // intervalIndividual.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        // if (intervalIndividual.isRunning())
                        //     intervalIndividual.stop();
                        // pbIndividual.progressbar('value', 100);
                        GenerarFacturacion_Individual(elemsSelected[indexList]);
                    }, 10000);
                };
            };
        },
        error: function (data) {
            progress = 0;
            // pbIndividual.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function RegenerarFacturacion () {
    var data = new FormData();
    // var input_data;

    precargaExp('#pnlListado > .gp-body', true);
    
    // input_data = $('#pnlDetalle > .gp-header :input').serializeArray();
    var factura = $('#gvGenFacturacion .dato.selected')[0];
    var idpropiedad = factura.getAttribute('data-idpropiedad');

    data.append('btnRegenerar', 'btnRegenerar');
    data.append('hdTipoFacturacion', '2');
    data.append('hdIdPropiedad', idpropiedad);
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());
    data.append('txtFechaVencimiento', $('#txtFechaVencimiento').val());
    data.append('txtFechaTope', $('#txtFechaTope').val());

    // $.each(input_data, function(key, fields){
    //     data.append(fields.name, fields.value);
    // });

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaGenFacturacion = 1;
                    ListarFacturacion('#gvGenFacturacion', '1');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

var o = {
    38: 'up',
    40: 'bottom',
    37: 'prev',
    39: 'next'
};

function ListarFacturacion (selectorgrid, pagina) {
    var selector = selectorgrid + ' .gridview';

    precargaExp(selectorgrid, true);

    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            criterio: $('#txtSearchFacturacion').val(),
            id: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val(),
            idtipopropiedad: $('#ddlTipoPropiedadFacturacion').val(),
            pagina: pagina
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var iditem = '0';
            var elemindex = 0;

            countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    iditem = data[i].tm_idfacturacion;
                    strhtml += '<div class="card dato bg-cyan heightuno half-col pos-rel" data-idfacturacion="' + iditem + '" data-nombre="' + data[i].nombreproyecto + '" data-idpropiedad="' + data[i].idpropiedad + '" data-codigo="' + data[i].tm_codigo + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<p><span class="descripcion float-left white-text">' + data[i].nombreproyecto + '</span></p>';

                    strhtml += '<div class="expand-data">';
                    strhtml += '<div class="grid fluid pos-rel">';
                    
                    strhtml += '<div class="row">';
                    strhtml += '<label>' + data[i].tm_per_ano + '</label>';
                    strhtml += '</div>';

                    strhtml += '<div class="row">';
                    strhtml += '<h3 class="fg-white padding5">' + arrMeses[parseInt(data[i].tm_per_mes) - 1] + '</h3>';
                    strhtml += '</div>';

                    strhtml += '<div class="badge">';
                    strhtml += '<div class="total-card grid fluid">';
                    strhtml += '<div class="row">';
                    strhtml += '<div class="span3 text-total fg-white no-margin">S/.</div>';
                    strhtml += '<div class="span9 subtotal text-total text-right fg-white no-margin">' + RedondeoMagico(data[i].tm_importefacturado).toFixed(2) + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                };
                
                if (pagina == '1'){
                    elemindex = 0;
                    $(selector).html(strhtml);
                }
                else {
                    if (selectorgrid == '#gvGenFacturacion')
                        elemindex = $('#gvGenFacturacion .dato').length;

                    $(selector).append(strhtml);
                };

                if (selectorgrid == '#gvGenFacturacion'){
                    $(selector).find('.dato').eq(elemindex).trigger('click');

                    paginaGenFacturacion = paginaGenFacturacion + 1;
                    $('#hdPageGenFacturacion').val(paginaGenFacturacion);

                    $card = $('#gvGenFacturacion .dato');

                    // $('#btnExportarTotalesFacturaExcel, #btnExportarFacturasExcel, #btnImportarDetalleFacturas, #btnRegenerar, #btnEliminar, #btnVistaPrevia, #btnGuardarConcepto, #btnDivisionFactura, #btnEnviarEmail, #btnImprimirFactura').removeClass('oculto');
                    $('#btnExportarTotalesFacturaExcel, #btnExportarFacturasExcel, #btnRegenerar, #btnEliminar, #btnVistaPrevia, #btnGuardarConcepto, #btnDivisionFactura, #btnEnviarEmail, #btnImprimirFactura').removeClass('oculto');
                }
                else if (selectorgrid == '#gvFacturacion'){
                    paginaFacturacion = paginaFacturacion + 1;
                    $('#hdPageFacturacion').val(paginaFacturacion);
                };
            }
            else {
                if (pagina == '1'){
                    $('#lblTotalConceptoFact').text('0.00');
                    $(selector).html('<h2>No hay datos.</h2>');
                    $('#btnRegenerar, #btnEliminar, #btnVistaPrevia, #btnGuardarConcepto, #btnDivisionFactura, #btnEnviarEmail, #btnImprimirFactura').addClass('oculto');
                    $('#tableConcepto tbody').html('');
                };
            };

            precargaExp(selectorgrid, false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function CalcularTotal () {
    var i = 0;
    var countdata = 0;
    var itemsDetalle;
    var tableDetalle;
    var esformula = '0';
    var escalonable = '0';
    var subtotal = 0;
    var total = 0;

    itemsDetalle = $('#tableConcepto .ibody table');
    tableDetalle = itemsDetalle[0];

    countdata = tableDetalle.rows.length;

    if (countdata > 0){
        while (i < countdata){
            esformula = tableDetalle.rows[i].getAttribute('data-esformula');
            escalonable = tableDetalle.rows[i].getAttribute('data-escalonable');

            if (esformula == '0' && escalonable == '0'){
                subtotal = Number(tableDetalle.rows[i].cells[1].childNodes[0].value);
            }
            else {
                subtotal = Number(tableDetalle.rows[i].cells[1].innerText);
            };

            total += subtotal;
            ++i;
        };
    };

    var totalFixed = total.toFixed(2);
    var totalString = totalFixed.toString();
    var redondeoTotal = RedondeoMagico(totalString);
    document.getElementById('lblTotalConceptoFact').innerText = Number(redondeoTotal).toFixed(2);
}

function ListarDetalle (idfacturacion) {
    precargaExp('#tableConcepto', true);

    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'DETALLE',
            tipobusqueda: '1',
            id: idfacturacion
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var htmlinputtext = '';
            var esformula = '0';
            var escalonable = '0';
            var valorconcepto = '0';
            
            precargaExp('#tableConcepto', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    esformula = data[i].esformula;
                    escalonable = data[i].escalonable;
                    valorconcepto = data[i].td_valorconcepto;

                    if (esformula == '0' && escalonable == '0'){
                        htmlinputtext = '<input type="text" class="inputTextInTable text-center" value="' + valorconcepto + '" />';
                    }
                    else {
                        htmlinputtext = valorconcepto;
                    };

                    strhtml += '<tr data-iddetalle="' + data[i].td_idconceptofacturacion + '" data-idconcepto="' + data[i].tm_idconcepto + '" data-tiporesultado="' + data[i].ta_tiporesultado + '" data-esformula="' + esformula + '" data-escalonable="' + escalonable + '">';
                    strhtml += '<td>' + data[i].tm_idconcepto + ' - ' + data[i].nombreconcepto + '</td>';
                    strhtml += '<td class="subtotal text-center">' + htmlinputtext + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };

                $('#tableConcepto tbody').html(strhtml);
                $('#tableConcepto .ibody table').enableCellNavigation();
                $('#btnGuardarConcepto').removeClass('oculto');
            }
            else {
                $('#tableConcepto tbody').html('');
                $('#btnGuardarConcepto').addClass('oculto');
            };

            CalcularTotal();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarPropiedadConsumo (tipo) {
    precargaExp('#tablePropiedad', true);

    var tipobusqueda = tipo == 'consulta' ? '2' : '1';

    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'PROPCONSUMO',
            tipobusqueda: tipobusqueda,
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var totalconsumo = 0;
            
            precargaExp('#tablePropiedad', false);

            if (countdata > 0){
                while(i < countdata){
                    var consumo = Number(data[i].td_consumoperiodo).toFixed(3);
                    var consumoimporte = Number(data[i].consumoimporte).toFixed(2);


                    
                    // strhtml += '<td>';
                    // strhtml += '<input type="hidden" name="consumo[' + i + '][iditem]" value="' + data[i].td_idconsumoescalonable + '" />';
                    // strhtml += '<input type="hidden" name="consumo[' + i + '][idpropiedad]" value="' + data[i].tm_idpropiedad + '" />';
                    // strhtml += '<input type="hidden" name="consumo[' + i + '][consumo]" class="input-consumo" value="' + consumo + '" />';

                    // strhtml += data[i].tm_descripcionpropiedad + '</td>';
                    // strhtml += '<td><input type="text" name="consumo[' + i + '][lecturaanterior]" class="lecanterior inputTextInTable text-right" value="' + Number(data[i].td_lecturaanterior).toFixed(2) + '" /></td>';
                    // strhtml += '<td><input type="text" name="consumo[' + i + '][lecturaactual]" class="lecactual inputTextInTable text-right" value="' + Number(data[i].td_lecturaactual).toFixed(2) + '" /></td>';
                    // strhtml += '<td class="consumo">' + consumo + '</td>';

                    // strhtml += '<td><input type="text" name="consumo[' + i + '][fechaini]" class="fechaini inputTextInTable text-right" value="' + convertDate(data[i].fechaini) + '" /></td>';
                    // strhtml += '<td><input type="text" name="consumo[' + i + '][fechafin]" class="fechafin inputTextInTable text-right" value="' + convertDate(data[i].fechafin) + '" /></td>';

                    // strhtml += '<input type="hidden" name="consumo[' + i + '][iditem]" value="' + data[i].td_idconsumoescalonable + '" />';
                    // strhtml += '<input type="hidden" name="consumo[' + i + '][idpropiedad]" value="' + data[i].tm_idpropiedad + '" />';
                    // strhtml += '<input type="hidden" name="consumo[' + i + '][consumo]" class="input-consumo" value="' + consumo + '" />';
                    

                    var color_fila = consumo < 0 ? ' class="red white-text"' : '';

                    strhtml += '<tr' + color_fila + ' data-iddetalle="' + data[i].td_idconsumoescalonable + '" data-idpropiedad="' + data[i].tm_idpropiedad + '">';
                    strhtml += '<td>';

                    strhtml += data[i].tm_descripcionpropiedad + '</td>';

                    strhtml += '<td><input type="text" name="txtLecturaAnterior[]" class="lecanterior inputTextInTable text-right" value="' + Number(data[i].td_lecturaanterior).toFixed(3) + '" /></td>';
                    strhtml += '<td><input type="text" name="txtLecturaActual[]" class="lecactual inputTextInTable text-right" value="' + Number(data[i].td_lecturaactual).toFixed(3) + '" /></td>';
                    strhtml += '<td class="consumo">' + consumo + '</td>';
                    strhtml += '<td class="consumoimporte">' + consumoimporte + '</td>';

                    strhtml += '<td><input type="text" name="txtFechaInicio[]" class="fechaini inputTextInTable text-right" value="' + convertDate(data[i].fechaini) + '" /></td>';
                    strhtml += '<td><input type="text" name="txtFechaFin[]" class="fechafin inputTextInTable text-right" value="' + convertDate(data[i].fechafin) + '" /></td>';


                    strhtml += '</tr>';

                    totalconsumo += Number(data[i].td_consumoperiodo);

                    ++i;
                };

                $('#btnCalcularConsumo, #btnIngresoFechasConsumo').removeClass('oculto');
            }
            else
                $('#btnCalcularConsumo, #btnIngresoFechasConsumo').addClass('oculto');

            $('#tablePropiedad tbody').html(strhtml);
            $('#tablePropiedad .ibody table').enableCellNavigation();

            $('#lblTotalConsumo').text(totalconsumo.toFixed(3));
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarPropiedadConsumo_Concepto (tipo) {
    precargaExp('#tablePropiedadConcepto', true);

    var tipobusqueda = tipo == 'consulta' ? '2' : '1';

    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'PROPCONSUMO_CONCEPTO',
            tipobusqueda: tipobusqueda,
            idproyecto: $('#hdIdProyecto').val(),
            idconcepto: $('#hdIdConcepto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var totalconceptovariable = 0;
            
            precargaExp('#tablePropiedadConcepto', false);

            if (countdata > 0){
                while(i < countdata){
                    // strhtml += '<tr>';

                    // strhtml += '<td>';
                    // strhtml += '<input type="hidden" name="conceptovariable[' + i + '][iditem]" value="' + data[i].td_idconsumoconcepto + '" />';
                    // strhtml += '<input type="hidden" name="conceptovariable[' + i + '][idpropiedad]" value="' + data[i].tm_idpropiedad + '" />';

                    // strhtml += data[i].tm_descripcionpropiedad + '</td>';
                    // // strhtml += '<td>' + data[i].tm_idconcepto + '</td>';
                    // strhtml += '<td><input type="text" name="conceptovariable[' + i + '][importe]" class="importeconcepto inputTextInTable text-right" value="' + Number(data[i].td_importe).toFixed(2) + '" /></td>';

                    var color_fila = Number(data[i].td_importe) < 0 ? ' class="red white-text"' : '';

                    strhtml += '<tr' + color_fila + ' data-iddetalle="' + data[i].td_idconsumoconcepto + '" data-idpropiedad="' + data[i].tm_idpropiedad + '">';
                    strhtml += '<td>';

                    strhtml += data[i].tm_descripcionpropiedad + '</td>';
                    strhtml += '<td><input type="text" name="conceptovariable[' + i + '][importe]" class="importeconcepto inputTextInTable text-right" value="' + Number(data[i].td_importe).toFixed(2) + '" /></td>';

                    strhtml += '</tr>';

                    totalconceptovariable += Number(data[i].td_importe);

                    ++i;
                };

                $('#btnCalcularConsumo_Concepto').removeClass('oculto');
            }
            else
                $('#btnCalcularConsumo_Concepto').addClass('oculto');

            $('#tablePropiedadConcepto tbody').html(strhtml);
            $('#tablePropiedadConcepto .ibody table').enableCellNavigation();

            $('#lblTotalConceptoVariable').text(totalconceptovariable.toFixed(0));
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function DetalleConcepto (iditem, valorconcepto) {
    this.iditem = iditem;
    this.valorconcepto = valorconcepto;
}

function ExtraerDetalleConcepto () {
    var i = 0;
    var countdata = 0;
    var itemsDetalle;
    var tableConcepto;
    var listDetalle = [];
    var strDetalle = '';

    var iditem = '0';
    var esformula = '0';
    var escalonable = '0';
    var valorconcepto = '0';

    itemsDetalle = $('#tableConcepto .ibody table');
    tableConcepto = itemsDetalle[0];

    countdata = tableConcepto.rows.length;

    if (countdata > 0){
        while (i < countdata){
            esformula = tableConcepto.rows[i].getAttribute('data-esformula');
            escalonable = tableConcepto.rows[i].getAttribute('data-escalonable');

            if (esformula == '0' && escalonable == '0'){
                iditem = tableConcepto.rows[i].getAttribute('data-iddetalle');
                valorconcepto = tableConcepto.rows[i].cells[1].childNodes[0].value;

                var detalle = new DetalleConcepto(iditem, valorconcepto);
                listDetalle.push(detalle);
            };

            ++i;
        };

        strDetalle = JSON.stringify(listDetalle);
    };

    return strDetalle;
}

function DetalleConsumo (iditem, idpropiedad, lecturaanterior, lecturaactual, consumo, fechaini, fechafin) {
    this.iditem = iditem;
    this.idpropiedad = idpropiedad;
    this.lecturaanterior = lecturaanterior;
    this.lecturaactual = lecturaactual;
    this.consumo = consumo;
    this.fechaini = fechaini;
    this.fechafin = fechafin;
}

function DetalleConsumo_Concepto (iditem, idpropiedad, importe) {
    this.iditem = iditem;
    this.idpropiedad = idpropiedad;
    this.importe = importe;
}

function RegistrarCalculoConsumo () {
    var data = new FormData();

    precargaExp('#pnlListado > .gp-body', true);

    var i = 0;
    var itemsDetalle = $('#tablePropiedad .ibody table');
    var tablePropiedad = itemsDetalle[0];
    var countdata = tablePropiedad.rows.length;
    var listDetalle = [];
    var detallePropiedad = '';

    if (countdata > 0){
        while (i < countdata){
            var iditem = tablePropiedad.rows[i].getAttribute('data-iddetalle');
            var idpropiedad = tablePropiedad.rows[i].getAttribute('data-idpropiedad');
            var lecanterior = tablePropiedad.rows[i].cells[1].childNodes[0].value;
            var lecactual = tablePropiedad.rows[i].cells[2].childNodes[0].value;
            var consumo = tablePropiedad.rows[i].cells[3].innerText;

            var fechaini = tablePropiedad.rows[i].cells[5].childNodes[0].value;
            var fechafin = tablePropiedad.rows[i].cells[6].childNodes[0].value;

            // if (Number(consumo) > 0){
            var detalle = new DetalleConsumo(iditem, idpropiedad, lecanterior, lecactual, consumo, fechaini, fechafin);
            listDetalle.push(detalle);
            // };

            ++i;
        };

        detallePropiedad = JSON.stringify(listDetalle);
    };

    // var input_data = $('#tablePropiedad :input').serializeArray();

    data.append('btnCalcularConsumo', 'btnCalcularConsumo');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());
    data.append('detallePropiedad', detallePropiedad);

    // $.each(input_data, function(key, fields){
    //     data.append(fields.name, fields.value);
    // });

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    ListarPropiedadConsumo('consulta');
                    ListarSumaConceptoAgua();
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function RegistrarCalculoConsumo_Concepto () {
    var data = new FormData();
    // var input_data;
    // var detallePropiedad = '';
    // var i = 0;
    // var countdata = 0;
    // var itemsDetalle;
    // var tablePropiedad;
    // var listDetalle = [];
    // var strDetalle = '';
    // var iditem = '0';
    // var idconcepto = '0';
    // var importe = '0';

    precargaExp('#pnlListado > .gp-body', true);

    var i = 0;
    var itemsDetalle = $('#tablePropiedadConcepto .ibody table');
    var tablePropiedad = itemsDetalle[0];
    var countdata = tablePropiedad.rows.length;
    var listDetalle = [];
    var detallePropiedad = '';

    if (countdata > 0){
        while (i < countdata){
            var iditem = tablePropiedad.rows[i].getAttribute('data-iddetalle');
            var idpropiedad = tablePropiedad.rows[i].getAttribute('data-idpropiedad');
            var importe = tablePropiedad.rows[i].cells[1].childNodes[0].value;

            // if (Number(importe) > 0){
            var detalle = new DetalleConsumo_Concepto(iditem, idpropiedad, importe);
            listDetalle.push(detalle);
            // };

            ++i;
        };

        detallePropiedad = JSON.stringify(listDetalle);
    };
    // var input_data = $('#pnlConceptoVariable :input').serializeArray();

    data.append('btnCalcularConsumo_Concepto', 'btnCalcularConsumo_Concepto');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdIdConcepto', $('#hdIdConcepto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());
    data.append('detallePropiedad', detallePropiedad);
    
    // $.each(input_data, function(key, fields){
    //     data.append(fields.name, fields.value);
    // });

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0')
                    ListarPropiedadConsumo_Concepto('consulta');
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GuardarConceptoFact () {
    var data = new FormData();
    var input_data;
    var detalleConcepto = '';
    var factura;
    var idfacturacion = '0';
    var importefactura = '0';

    precargaExp('#tableConcepto', true);

    factura = $('#gvGenFacturacion .dato.selected');
    idfacturacion = factura[0].getAttribute('data-idfacturacion');
    importefactura = document.getElementById('lblTotalConceptoFact').innerText;
    detalleConcepto = ExtraerDetalleConcepto();

    data.append('btnGuardarConcepto', 'btnGuardarConcepto');
    data.append('hdIdFacturacion', idfacturacion);
    data.append('txtTotalImporte', importefactura);
    data.append('detalleConcepto', detalleConcepto);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            var totalconceptofact = 0;

            precargaExp('#tableConcepto', false);

            totalconceptofact = Number(document.getElementById('lblTotalConceptoFact').innerText);
            factura.find('.subtotal').text(totalconceptofact.toFixed(2));
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                ListarDetalle(idfacturacion);
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ObtenerFacturacion (idfacturacion) {
    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            id: idfacturacion
        },
        success: function (data) {
            var countdata = 0;
            var factura;
            var importefactura = 0;

            if (countdata > 0) {
                factura = $('#gvGenFacturacion .dato.selected');
                importefactura = Number(data[0].tm_importefacturado);
                
                factura.find('.subtotal').text(importefactura.toFixed(2));
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
    
}

function GenerarPDF(tipoGen) {
    var titleGenPDF = '';
    var infoGenEmail = '';
    var desProgIndividual = '';
    var desPorcjEnvio = '';

    indexList = 0;
    progress = 0;
    nroFacturas = 0;
    elemsSelected = [];
    completado = false;
    progressError = false;
    
    $('#btnFinalizarEnvio').addClass('oculto');
    $('#btnCancelarEnvio').removeClass('oculto');

    precargaExp('#modalGenPDF', true);

    if (tipoGen == 'EMAIL'){
        titleGenPDF = 'Envio de emails';
        infoGenEmail = 'Facturas enviadas';
        desProgIndividual = 'Enviando factura ';
        desPorcjEnvio = 'Envio ';
    }
    else {
        titleGenPDF = 'Exportar facturas a PDF';
        infoGenEmail = 'Facturas exportadas';
        desProgIndividual = 'Exportando factura ';
        desPorcjEnvio = 'Exportación ';
    };

    $('#lblTitleGenPDF').text(titleGenPDF);
    $('#lblInfoGenEmail').text(infoGenEmail);
    $('#lblDesProgIndividual').text(desProgIndividual);
    $('#lblDesPorcjEnvio').text(desPorcjEnvio);

    openModalCallBack ('#modalGenPDF', function () {
        var data = new FormData();

        data.append('hdIdProyecto', $('#hdIdProyecto').val());
        data.append('hdAnho', $('#hdAnho').val());
        data.append('hdMes', $('#hdMes').val());

        $.ajax({
            url: 'services/files/files__facturacion.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            cache: false,
            contentType:false,
            processData: false,
            success: function (data) {
                $.ajax({
                    url: 'services/facturacion/facturacion-search.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        tipo: 'ALLFIELDS',
                        tipobusqueda: '1',
                        id: $('#hdIdProyecto').val(),
                        criterio: '',
                        anho: $('#hdAnho').val(),
                        mes: $('#hdMes').val(),
                        pagina: '0'
                    },
                    success:  function (data) {
                        var countdata = 0;

                        precargaExp('#modalGenPDF', false);
                        
                        elemsSelected = data;
                        countdata = data.length;
                        nroFacturas = countdata;
                        
                        $('#lblNroFactGeneradas').text(countdata);
                        GenerarArchivo(tipoGen, data[0]);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
}

function GenerarIndividual () {
    $('#pnlImpresionFactura').fadeIn(400, function() {
        var idfacturacion = '0';
        
        precargaExp('#pnlImpresionFactura', true);

        idfacturacion = $('#gvGenFacturacion .dato.selected').attr('data-idfacturacion');

        $.ajax({
            url: 'services/facturacion/facturacion-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipo: 'ALLFIELDS',
                tipobusqueda: '2',
                id: idfacturacion,
                criterio: ''
            },
            success:  function (data) {
                var newdata = new FormData();
                var item;
                var folder = $('#hdIdProyecto').val();

                //alert(data.length);
                if (data.length > 0){
                    item = data[0];

                    newdata.append('btnGenerarPDF', 'btnGenerarPDF');
                    newdata.append('tipoGen', 'EXPORTACION');
                    newdata.append('ddlAnho', $('#hdAnho').val());
                    newdata.append('ddlMes', $('#hdMes').val());
                    newdata.append('hdIdFacturacion', item.tm_idfacturacion);
                    newdata.append('hdIdProyecto', item.tm_idproyecto);
                    newdata.append('hdIdPropiedad', item.idpropiedad);
                    newdata.append('hdIdPropietario', item.idpropietario);
                    newdata.append('txtCodigo', item.tm_codigo);
                    newdata.append('txtFechaEmision', item.tm_fechaemision);
                    newdata.append('txtFechaVencimiento', item.tm_fechavencimiento);
                    newdata.append('txtFechaTope', item.tm_fechatope);
                    newdata.append('txtRatio', item.tm_ratio);
                    newdata.append('txtSimboloMoneda', item.simbolomoneda);
                    newdata.append('txtTotalImporte', item.tm_importefacturado);
                    
                    $.ajax({
                        url: 'services/facturacion/facturacion-post.php',
                        type: 'POST',
                        dataType: 'json',
                        data: newdata,
                        cache: false,
                        contentType:false,
                        processData: false,
                        success: function (data) {
                            precargaExp('#pnlImpresionFactura', false);
                            
                            $('#ifrImpresionFactura').attr('src', 'media/pdf/' + folder + item.tm_per_ano + item.tm_per_mes + '/' + item.tm_idfacturacion + '.pdf?new=' + new Date().getTime());
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
                else {
                    precargaExp('#pnlImpresionFactura', false);

                    MessageBox('No se encontraron datos de facturacion', 'Error en visualizacion', "[Aceptar]", function () {
                        $('#pnlImpresionFactura').fadeOut(400, function() {
                        });
                    });
                };

            },
            error: function (data) {
                console.log(data);
            }
        });
    });
}

function GenerarArchivo (tipoGen, item) {
    var data = new FormData();
    var pbIndividual;

    data.append('btnGenerarPDF', 'btnGenerarPDF');
    data.append('tipoGen', tipoGen);
    data.append('ddlAnho', $('#hdAnho').val());
    data.append('ddlMes', $('#hdMes').val());
    data.append('hdIdFacturacion', item.tm_idfacturacion);
    data.append('hdIdProyecto', item.tm_idproyecto);
    data.append('hdIdPropiedad', item.idpropiedad);
    data.append('hdIdPropietario', item.idpropietario);
    data.append('txtCodigo', item.tm_codigo);
    data.append('txtFechaEmision', item.tm_fechaemision);
    data.append('txtFechaVencimiento', item.tm_fechavencimiento);
    data.append('txtFechaTope', item.tm_fechatope);
    data.append('txtRatio', item.tm_ratio);
    data.append('txtSimboloMoneda', item.simbolomoneda);
    data.append('txtTotalImporte', item.tm_importefacturado);

    // pbIndividual = $('#pbProgresoIndividual').progressbar({
    //     animate: true
    //     // color: 'bg-cyan'
    // });

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            // var pbTotal;
            var porcentaje = 0;
            var titulomsje = '';
            var contenidomsje = '';

            ++indexList;
            progressError = false;
            porcentaje = Math.round((indexList * 100) / nroFacturas);
            // pbTotal = $('#pbProgresoTotal');

            // pbIndividual.progressbar('value', 100);
            // pbIndividual.progressbar('color', 'bg-green');

            // if (intervalIndividual.isRunning())
            //     intervalIndividual.stop();
            
            $('#lblNroFactEnviadas').text(indexList);
            $('#lblPorcentajeEnvio').text(porcentaje);
            $('#lblDescripFactura').text(item.tm_idfacturacion + ' - ' + item.descripcionpropiedad);

            if (indexList <= elemsSelected.length - 1){
                // pbTotal.progressbar('value', indexList);
                GenerarArchivo(tipoGen, elemsSelected[indexList]);
            }
            else {
                completado = true;
                
                // pbTotal.progressbar('color', 'bg-green');
                // pbTotal.progressbar('value', 100);

                $('#btnFinalizarEnvio').removeClass('oculto');
                $('#btnCancelarEnvio').addClass('oculto');
                
                if (tipoGen == 'EMAIL'){
                    MessageBox('Env&iacute;o completado', 'Todas las facturas se enviaron por correo', "[Aceptar]", function () {
                    });
                }
                else {
                    ExportarFacturas();
                };
            };
        },
        beforeSend: function () {
            // pbIndividual.progressbar('color', 'bg-cyan');
            // intervalIndividual.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        // if (intervalIndividual.isRunning())
                        //     intervalIndividual.stop();
                        // pbIndividual.progressbar('value', 100);
                        GenerarArchivo(tipoGen, elemsSelected[indexList]);
                    }, 10000);
                };
            };
        },
        error: function (data) {
            progress = 0;
            // pbIndividual.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function ExportarPropiedades () {
    var data = new FormData();
    var idproyecto = $('#hdIdProyecto').val();
    var tipo = $('#groupVistaConsumo .span-button.btn-success').attr('data-target');
    var tipobusqueda = tipo == 'consulta' ? '2' : '1';

    precargaExp('#pnlListado', true);

    data.append('btnExportarPropiedad', 'btnExportarPropiedad');
    data.append('hdIdProyecto', idproyecto);
    data.append('hdTipoConsultaExport', tipobusqueda);
    data.append('ddlAnho', $('#hdAnho').val());
    data.append('ddlMes', $('#hdMes').val());

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado', false);

            MessageBox('Exportaci&oacute;n completada', 'Todas las propiedades se generaron correctamente', "[Aceptar]", function () {
                window.location = 'media/xls/' + idproyecto + '.xlsx';
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ExportarPropiedades_Concepto () {
    var data = new FormData();
    var idproyecto = $('#hdIdProyecto').val();
    var idconcepto = $('#hdIdConcepto').val();
    var anho = $('#hdAnho').val();
    var mes = $('#hdMes').val();
    var tipo = $('#groupVistaConsumo .span-button.btn-success').attr('data-target');
    var tipobusqueda = tipo == 'consulta' ? '2' : '1';

    precargaExp('#pnlListado', true);

    data.append('btnExportarPropiedad_Concepto', 'btnExportarPropiedad_Concepto');
    data.append('hdIdProyecto', idproyecto);
    data.append('hdTipoConsultaExport', tipobusqueda);
    data.append('hdIdConcepto', idconcepto);
    data.append('hdAnho', anho);
    data.append('hdMes', mes);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado', false);

            MessageBox('Exportaci&oacute;n completada', 'Todas las propiedades se generaron correctamente', "[Aceptar]", function () {
                window.location = 'media/xls/' + idproyecto + '.xlsx';
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ExportarDetalleFacturas () {
    var data = new FormData();
    var idproyecto = $('#hdIdProyecto').val();
    var anho = $('#hdAnho').val();
    var mes = $('#hdMes').val();

    precargaExp('#pnlListado', true);

    data.append('btnExportarFacturasExcel', 'btnExportarFacturasExcel');
    data.append('hdIdProyecto', idproyecto);
    data.append('ddlAnho', anho);
    data.append('ddlMes', mes);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado', false);

            MessageBox('Exportaci&oacute;n completada', 'Todas los detalles de las facturas se generaron correctamente', "[Aceptar]", function () {
                window.location = 'media/xls/' + idproyecto + '_' + anho + '_' + mes + '.xlsx';
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ExportarTotalesFacturaExcel () {
    var data = new FormData();
    var idproyecto = $('#hdIdProyecto').val();
    var anho = $('#hdAnho').val();
    var mes = $('#hdMes').val();

    precargaExp('#pnlListado', true);

    data.append('btnExportarTotalesFacturaExcel', 'btnExportarTotalesFacturaExcel');
    data.append('hdIdProyecto', idproyecto);
    data.append('ddlAnho', anho);
    data.append('ddlMes', mes);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado', false);

            MessageBox('Exportaci&oacute;n completada', 'Todas las facturas de este proyecto se exportaron correctamente', "[Aceptar]", function () {
                window.location = 'media/xls/' + idproyecto + '_' + anho + '_' + mes + '_TF.xlsx?new=' + new Date().getTime();
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ExportarFacturas () {
    var data = new FormData();

    precargaExp('#modalGenPDF', true);

    data.append('btnExportar', 'btnExportar');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('ddlAnho', $('#hdAnho').val());
    data.append('ddlMes', $('#hdMes').val());

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#modalGenPDF', false);

            MessageBox('Exportaci&oacute;n completada', 'Todas las facturas se generaron correctamente', "[Aceptar]", function () {
                VerImpresion(data.contenidomsje + '?new=' + new Date().getTime());
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function VerImpresion (url) {
    $('#pnlImpresionFactura').fadeIn(400, function() {
        $('#ifrImpresionFactura').attr('src', url);
    });
}

function ListarTorreSuministro () {
    precargaExp('#tableTorre', true);

    $.ajax({
        url: 'services/facturacion/facturacion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'TORRES',
            tipobusqueda: '1',
            idproyecto: $('#hdIdProyecto').val(),
            anho: $('#hdAnho').val(),
            mes: $('#hdMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            precargaExp('#tableTorre', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-iddetalle="' + data[i].td_idconsumoascensor + '" data-idtorre="' + data[i].tm_idtorre + '">';
                    strhtml += '<td>' + data[i].tm_descripciontorre + '</td>';
                    strhtml += '<td><input type="text" name="txtNroSuministro[]" class="inputTextInTable" value="' + data[i].td_nrosuministro + '" /></td>';
                    strhtml += '<td><input type="text" name="txtImporteTorre[]" class="inputTextInTable text-right" value="' + Number(data[i].td_importe).toFixed(2) + '" /></td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableTorre tbody').html(strhtml);
            $('#tableTorre .ibody table').enableCellNavigation();

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function DetalleTorre (iditem, idtorre, nrosuministro, importe) {
    this.iditem = iditem;
    this.idtorre = idtorre;
    this.nrosuministro = nrosuministro;
    this.importe = importe;
}

function ExtraerTorre() {
    var i = 0;
    var countdata = 0;
    var itemsDetalle;
    var tableTorre;
    var listDetalle = [];
    var strDetalle = '';

    var iditem = '0';
    var idtorre = '0';
    var nrosuministro = '0';
    var importe = '0';

    itemsDetalle = $('#tableTorre .ibody table');
    tableTorre = itemsDetalle[0];

    countdata = tableTorre.rows.length;

    if (countdata > 0){
        while (i < countdata){
            iditem = tableTorre.rows[i].getAttribute('data-iddetalle');
            idtorre = tableTorre.rows[i].getAttribute('data-idtorre');
            nrosuministro = tableTorre.rows[i].cells[1].childNodes[0].value;
            importe = tableTorre.rows[i].cells[2].childNodes[0].value;

            var detalle = new DetalleTorre(iditem, idtorre, nrosuministro, importe);
            listDetalle.push(detalle);
            ++i;
        };

        strDetalle = JSON.stringify(listDetalle);
    };

    return strDetalle;
}

function RegistrarTorreConsumo () {
    var data = new FormData();
    var input_data;
    var detallePropiedad = '';

    precargaExp('#pnlDetalle > .gp-body', true);

    detalleTorre = ExtraerTorre();

    data.append('btnRegistrarAscensor', 'btnRegistrarAscensor');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('ddlAnho', $('#hdAnho').val());
    data.append('ddlMes', $('#hdMes').val());
    data.append('detalleTorre', detalleTorre);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlDetalle > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                ListarTorreSuministro();
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarIncidencias (idpropiedad, idproyecto, anho, mes) {
    var selector = '#tablePropietario';

    precargaExp(selector, true);
    
    $.ajax({
        type: "GET",
        url: "services/facturacion/facturacion-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipo: 'INCIDENCIAS',
            idpropiedad: idpropiedad,
            idproyecto: idproyecto,
            anho: anho,
            mes: mes
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-iddetalle="' + data[i].idincidencia + '" data-idpropietario="' + data[i].idpropietario + '" data-seleccionable="false">';
                    strhtml += '<td><h3>' + data[i].descripcion + '</h3></td>';
                    strhtml += '<td><input type="text" name="txtNroDias[]" class="inputTextInTable text-right" value="' + data[i].diasincidencia + '" /></td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };
            
            $(selector + ' tbody').html(strhtml);
            $(selector + ' .ibody table').enableCellNavigation();

            ConfigurarFilasIncidencia();
            
            precargaExp(selector, false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ConfigurarFilasIncidencia () {
    var nrofilas = 0;
    var nropropietarios = 0;
    var nrofilasadd = 0;
    var i = 0;
    var strhtml = '';
    var selector = '#tablePropietario';

    nrofilas = $('#tablePropietario tbody tr[data-idpropietario!="0"]').length;
    nropropietarios = parseInt($('#txtNroPropietarios').val());

    $(selector + ' tbody tr[data-idpropietario="0"]').remove();
    
    if (nrofilas > 0) {
        if (nropropietarios > nrofilas){
            nrofilasadd = nropropietarios - nrofilas;

            while(i < nrofilasadd){
                strhtml += '<tr data-iddetalle="0" data-idpropietario="0" data-edit="false" data-seleccionable="true">';
                strhtml += '<td><h3>SELECCIONAR PROPIETARIO</h3></td>';
                strhtml += '<td><input type="text" name="txtNroDias[]" class="inputTextInTable text-right" value="0" /></td>';
                strhtml += '</tr>';
                ++i;
            };

            $(selector + ' tbody').append(strhtml);
            $(selector + ' .ibody table').enableCellNavigation();
        };
    };
}

function DetallePropietario (iditem, idpropietario, diasincidencia) {
    this.iditem = iditem;
    this.idpropietario = idpropietario;
    this.diasincidencia = diasincidencia;
}

function ExtraerPropietario() {
    var i = 0;
    var countdata = 0;
    var itemsDetalle;
    var tablePropietario;
    var listDetalle = [];
    var strDetalle = '';

    var iditem = '0';
    var idpropietario = '0';
    var diasincidencia = '0';

    itemsDetalle = $('#tablePropietario .ibody table');
    tablePropietario = itemsDetalle[0];

    countdata = tablePropietario.rows.length;

    if (countdata > 0){
        while (i < countdata){
            iditem = tablePropietario.rows[i].getAttribute('data-iddetalle');
            idpropietario = tablePropietario.rows[i].getAttribute('data-idpropietario');
            diasincidencia = tablePropietario.rows[i].cells[1].childNodes[0].value;

            var detalle = new DetallePropietario(iditem, idpropietario, diasincidencia);
            listDetalle.push(detalle);
            ++i;
        };

        strDetalle = JSON.stringify(listDetalle);
    };

    return strDetalle;
}

function DividirFactura () {
    var data = new FormData();
    var idfacturacion = '0';
    var idpropiedad = '0';
    var idproyecto = '0';
    var anho = '0';
    var mes = '0';

    precargaExp('#tablePropietario', true);

    factura = document.getElementById('lblNroPropiedad');
    idfacturacion = factura.getAttribute('data-idfacturacion');
    idpropiedad = factura.getAttribute('data-idpropiedad');
    idproyecto = $('#hdIdProyecto').val();
    anho = $('#hdAnho').val();
    mes = $('#hdMes').val();
    detallePropietario = ExtraerPropietario();

    data.append('btnDividirFactura', 'btnDividirFactura');
    data.append('hdIdFacturacion', idfacturacion);
    data.append('hdIdPropiedad', idpropiedad);
    data.append('hdIdProyecto', idproyecto);
    data.append('ddlAnho', anho);
    data.append('ddlMes', mes);
    data.append('detallePropietario', detallePropietario);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#tablePropietario', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                ListarIncidencias(idpropiedad, idproyecto, anho, mes);
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function EliminarFacturacion () {
    indexList = 0;
    elemsSelected = $('#gvGenFacturacion .selected').toArray();
    EliminarItemFacturacion(elemsSelected[0]);
}

function EliminarItemFacturacion (item) {
    var data = new FormData();
    var idfacturacion = '0';

    idfacturacion = item.getAttribute('data-idfacturacion');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdFacturacion', idfacturacion);

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollFacturacions;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'La factura ' + idfacturacion + ': ' + item.getAttribute('data-codigo');
                
                if (data.contenidomsje == 'ERROR-COBRANZA') {
                    contenidomsje += ' se ha usado en el m&oacute;dulo de cobranza.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollFacturacions = $('#gvGenFacturacion .gridview');
                iScroll = scrollFacturacions.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();

                    if ($('#gvGenFacturacion .card').length > 0){
                        $('#gvGenFacturacion .card:first').trigger('click');
                    };
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollFacturacions.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemFacturacion(elemsSelected[indexList]);
                    });
                }
                else {
                    MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                        $('#btnRegenerar, #btnEliminar, #btnVistaPrevia, #btnGuardarConcepto, #btnDivisionFactura, #btnEnviarEmail, #btnImprimirFactura').removeClass('oculto');
                    });
                };
            };
        },
        error:function (data){
            console.log(data);
        }
    });
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
    // var pbMetro;

    // pbMetro = $('.progress-bar').progressbar();
    
    $('.droping-air .help').text('Seleccione o arrastre un archivo de Excel');
    $('.droping-air').removeClass('dropped');

    habilitarControl('#btnSubirDatos', false);
    $('#btnSubirDatos').removeClass('success');

    $('.droping-air .file-import').val('');

    // pbMetro.progressbar('value', 0);
    // pbMetro.progressbar('color', 'bg-cyan');

    fileValue = false;
}

function executeImport () {
    // var _file = fileValue;

    // if(_file.files.length === 0){
    //     return;
    // }
    var _progress = document.getElementById('pbUploadExcel');
    var _progress_text = _progress.getElementsByClassName('custom_progress_text')[0];

    var tipoImport = $('#hdTipoImportacion').val();
    var data = new FormData();
    
    data.append('btnSubirDatos', 'btnSubirDatos');
    data.append('hdTipoImportacion', tipoImport);
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdIdConcepto', $('#hdIdConcepto').val());
    data.append('hdConceptoEscalonable', $('#hdConceptoEscalonable').val());
    data.append('ddlAnhoImport', $('#hdAnho').val());
    data.append('ddlMesImport', $('#hdMes').val());
    data.append('archivo', fileValue);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            try {
                var resp = JSON.parse(request.response);

                MessageBox(resp.titulomsje, resp.contenidomsje, "[Aceptar]", function () {
                    if (resp.rpta != '0'){
                        closeCustomModal('#modalUploadExcel');
                        cancelImport();

                        if (tipoImport == '00'){
                            ListarPropiedadConsumo('consulta');
                            ListarSumaConceptoAgua();
                        }
                        else if (tipoImport == '01')
                            ListarPropiedadConsumo_Concepto('consulta');
                        else
                            ListarFacturacion('#gvGenFacturacion', '1');
                    };
                });
            } catch (e){
                var resp = {
                    status: 'error',
                    data: 'Unknown error occurred: [' + request.responseText + ']'
                };
            }

            console.log(resp.status + ': ' + resp.data);
        }
    };

    request.upload.addEventListener('progress', function(e){
        var progreso = Math.ceil(e.loaded/e.total) * 100 + '%';
        _progress.style.width = progreso;
        _progress_text.textContent = progreso;
    }, false);

    request.open('POST', "services/facturacion/facturacion-post.php");
    request.send(data);
}

function executeImport2 () {
    // var pbMetro;
    var file = fileValue;
    var data = new FormData();
    var intervalProgress;

    // pbMetro = $('.progress-bar').progressbar();

    // intervalProgress = new Interval(function(){
    //     pbMetro.progressbar('value', (++progress));
    //     if (progress == 100){
    //         intervalProgress.stop();
    //         if (progressSuccess)
    //             intervalProgress.start();
    //     };
    // }, 100);

    // pbMetro.progressbar('value', '0');
    // pbMetro.progressbar('color', 'bg-cyan');

    var tipoImport = $('#hdTipoImportacion').val();
    
    data.append('btnSubirDatos', 'btnSubirDatos');
    data.append('hdTipoImportacion', tipoImport);
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdIdConcepto', $('#hdIdConcepto').val());
    data.append('hdConceptoEscalonable', $('#hdConceptoEscalonable').val());
    data.append('ddlAnhoImport', $('#hdAnho').val());
    data.append('ddlMesImport', $('#hdMes').val());
    data.append('archivo', file);

    $.ajax({
        type: "POST",
        url: "services/facturacion/facturacion-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            progressError = false;
            if (data.rpta != '0')
                progressSuccess = true;
            
            // pbMetro.progressbar('value', 100);
            // pbMetro.progressbar('color', 'bg-green');

            // if (intervalProgress.isRunning())
            //     intervalProgress.stop();
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    closeCustomModal('#modalUploadExcel');
                    cancelImport();

                    if (tipoImport == '00'){
                        ListarPropiedadConsumo('consulta');
                        ListarSumaConceptoAgua();
                    }
                    else if (tipoImport == '01')
                        ListarPropiedadConsumo_Concepto('consulta');
                    else
                        ListarFacturacion('#gvGenFacturacion', '1');
                };
            });
        },
        // beforeSend: function () {
        //     // intervalProgress.start();
        // },
        complete: function () {
            progress = 0;
            
            if (progressError){
                setTimeout(function () {
                    // if (intervalProgress.isRunning())
                        // intervalProgress.stop();
                    // pbMetro.progressbar('value', 100);
                    executeImport();
                }, 10000);
            };
        },
        error:function (data){
            progress = 0;
            // pbMetro.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function ListarSumaConceptoAgua () {
    var data = new FormData();

    data.append('btnSumarAgua', 'btnSumarAgua');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());

    $.ajax({
        url: 'services/facturacion/facturacion-post.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            var aguasuma = Number(data.titulomsje);

            $('#lblTotalConsumo_Soles').text(aguasuma.toFixed(2));
        },
        error: function (data){
            progress = 0;
            // pbMetro.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function IngresarFechasConsumo () {
    var i = 0;
    var itemsDetalle = $('#tablePropiedad .ibody table');
    var tablePropiedad = itemsDetalle[0];
    var countdata = tablePropiedad.rows.length;
    var fechaini = $('#txtFechaIniConsumo').val();
    var fechafin = $('#txtFechaFinConsumo').val();

    if (countdata > 0){
        while (i < countdata){
            tablePropiedad.rows[i].cells[5].childNodes[0].value = fechaini;
            tablePropiedad.rows[i].cells[6].childNodes[0].value = fechafin;

            ++i;
        };
    };
}

function GenerarConceptoVariable () {
    habilitarControl('#btnGenerarConceptoVariable', false);

    var data = new FormData();
    var input_data = $('#modalConceptoVariableGen :input').serializeArray();

    data.append('btnGenerarConceptoVariable', 'btnGenerarConceptoVariable');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: "services/facturacion/facturacion-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    $('#txtImporteSaldo').val('0.00');
                    closeCustomModal('#modalConceptoVariableGen');
                };
            });
        },
        error:function (data){
            console.log(data);
        }
    });
}