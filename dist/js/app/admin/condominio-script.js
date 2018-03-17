$(function  () {
    ProyectoPorDefecto();
    ListarAnhoProceso();

    // fakewaffle.responsiveTabs(['xs', 'sm']);

    $('#btnSearchDepartamento').on('click', function(event) {
        event.preventDefault();
        ListarDepartamentos('1');
    });

    $('#txtSearchConstructora').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            ListarConstructora();
            return false;
        };
    });

    $('#myTab').on('click', 'a', function (e) {
        e.preventDefault();
        // $(this).tab('show');

        var _tab = this.getAttribute('href');

        $('#myTab .tab-bar li').removeClass('active');
        $(this).parent().addClass('active');

        $('.panel-tab').removeClass('active');
        $(_tab).addClass('active');

        if (_tab != '#tab_propiedades')
            createFrame('#pnlInfoGeneralProyecto', this);
    });

    $('#tabProyecto').on('click', 'a', function (e) {
        e.preventDefault();
        $(this).tab('show');

        createFrame('#pnlInfoDetalleProyecto', this);
    });

    $('#tableProceso tbody').on('click', 'tr button', function(event) {
        event.preventDefault();
        
        var elem = this;
        var accion = elem.getAttribute('data-action');
        var _row = getParentsUntil(elem, '#tableProceso', 'tr');
        _row = _row[0];
        
        if (accion == 'details') {
            
            $('#lblProceso').attr({
                'data-mes': _row.getAttribute('data-mes'),
                'data-anho': _row.getAttribute('data-anho'),
                'data-estado': _row.getAttribute('data-estado')
            }).text($(_row).find('td:eq(1) h4').text() + ' ' + _row.getAttribute('data-anho'));

            // $('#tabProyecto a:first').tab('show');
            // $('#pnlInfoDetalleProyecto iframe').remove();

            // $('#tabProyecto a').eq(0).trigger('click');

            $('#tabProyecto li.active a').trigger('click');
            
            $('#pnlInfoGeneralProyecto').fadeOut(400, function() {
                $('#pnlInfoDetalleProyecto').fadeIn(400, function() {
                });
            });

            closeCustomModal('#modalProceso');
        }
        else if (accion == 'reopen') {
            var idproceso = _row.getAttribute('data-idproceso');

            bootbox.confirm('¿Desea re-aperturar este proceso?', function (result) {
                if (result)
                    ReaperturarProceso(idproceso);
            });
        }
        else if (accion == 'delete') {
            var idproceso = _row.getAttribute('data-idproceso');

            bootbox.confirm('¿Desea eliminar este proceso?', function (result) {
                if (result)
                    EliminarProceso(idproceso);
            });
        };

        return false;
    });

    // $('#btnCambiarProyecto').on('click', function(event) {
    //     event.preventDefault();
    //     $('#lblTitleProceso').addClass('hide');
    //     $('#inputInfoProceso').removeClass('hide');
    //     $("#txtSearchProyecto").focus();
    // });

    // $("#txtSearchProyecto").easyAutocomplete({
    //     url: function (phrase) {
    //         return "services/condominio/condominio-search.php?criterio=" + phrase + "&tipobusqueda=1";
    //     },
    //     getValue: function (element) {
    //         return element.codigoproyecto +  ' - ' + element.nombreproyecto;
    //     },
    //     list: {
    //         onSelectItemEvent: function () {
    //             var value = $("#txtSearchProyecto").getSelectedItemData().idproyecto;

    //             $("#hdIdProyecto").val(value).trigger("change");
    //         }
    //     },
    //     template: {
    //         type: "custom",
    //         method: function (value, item) {
    //             return item.codigoproyecto +  ' - ' + item.nombreproyecto;
    //         }
    //     },
    //     theme: "square"
    // });

    $('#btnGuardarLiquidacion').on('click', function(event) {
        event.preventDefault();
        GuardarLiquidacion();
    });

    // $('#gvDatos').on('click', '.dato', function(event) {
    //     event.preventDefault();

    //     var proyecto = this;
    //     var idproyecto = this.getAttribute('data-idproyecto');

    //     $('#hdIdProyecto').val(idproyecto);

    //     $('#pnlInfoGeneralProyecto iframe').remove();
    //     $('#pnlInfoDetalleProyecto iframe').remove();
        
    //     $('#pnlListado').fadeOut(400, function() {
    //         $('#pnlOpciones').fadeIn(400, function() {
    //             GoToPropiedades(proyecto);
                
    //             $('#myTabs li.active').removeClass('active');
    //             $('#pnlInfoGeneralProyecto .tab-pane.active').removeClass('active');

    //             $('#myTabs li:first-child').addClass('active');
    //             $('#pnlInfoGeneralProyecto .tab-pane:first').addClass('active');

    //             $('#tabProyecto li.active').removeClass('active');
    //             $('#pnlInfoDetalleProyecto .tab-pane.active').removeClass('active');

    //             $('#tabProyecto li:first-child').addClass('active');
    //             $('#pnlInfoDetalleProyecto .tab-pane:first').addClass('active');

    //             // $('#myTabs li:first-child a').trigger('click');
    //             // $('#tabProyecto li:first-child a').trigger('click');
    //         });
    //     });
    // });

    $('#gvDatos').on('click', '.dropdown-list a', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var proyecto = getParentsUntil(this, '#gvDatos', '.dato');
        var idproyecto = proyecto[0].getAttribute('data-idproyecto');
        
        escobrodiferenciado = proyecto[0].getAttribute('data-escobrodiferenciado');
        idbanco = proyecto[0].getAttribute('data-idbanco');
        idcuentabancaria = proyecto[0].getAttribute('data-idcuentabancaria');

        $('#hdIdProyecto').val(idproyecto);
        
        if (accion == 'edit')
            GoToEdit(idproyecto);
        else if (accion == 'more-info')
            MostrarPropiedades(proyecto[0]);
        else if (accion == 'delete') {
            bootbox.confirm('¿Desea eliminar este proyecto?', function (result) {
                if (result)
                    EliminarItemProyecto(proyecto[0]);
            });
        };
    });

    // $('#gvDatos').on('click', '.dato', function(event) {
    //     event.preventDefault();
        
    //     var checkBox = $(this).find('input:checkbox');
        
    //     if ($(this).hasClass('selected')){
    //         $(this).removeClass('selected');
    //         checkBox.removeAttr('checked');
    //         if ($('#gvDatos .dato.selected').length == 0){
    //             $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
    //             $('#btnLimpiarSeleccion, #btnEditar, #btnFijarProyecto, #btnListPropiedades, #btnEliminar, #btnIniciarFacturacion').addClass('oculto');
    //         }
    //         else {
    //             if ($('#gvDatos .dato.selected').length == 1){
    //                 $('#btnLimpiarSeleccion, #btnEditar, #btnFijarProyecto, #btnListPropiedades').removeClass('oculto');
    //             };
    //         };
    //     }
    //     else {
    //         $(this).addClass('selected');
    //         checkBox.attr('checked', '');
    //         $('#btnNuevo, #btnUploadExcel').addClass('oculto');
    //         $('#btnLimpiarSeleccion, #btnEliminar, #btnIniciarFacturacion').removeClass('oculto');
    //         if ($('#gvDatos .dato.selected').length == 1){
    //             $('#btnEditar, #btnFijarProyecto, #btnListPropiedades').removeClass('oculto');
    //         }
    //         else {
    //             $('#btnEditar, #btnFijarProyecto, #btnListPropiedades').addClass('oculto');
    //         };
    //     };
    // });

    $('#txtFechaVencimiento').mask('99/99/9999');
    cargarDatePicker('#txtFechaVencimiento', function (dateText, inst) {
    });

    $('#txtFechaTope').mask('99/99/9999');
    cargarDatePicker('#txtFechaTope', function (dateText, inst) {
    });

    $('#btnOrdenPropiedad').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalOrdenPropiedad', function () {
            ListarPropiedades_Orden('1');
        });
    });

    $('#btnIniciarFacturacion').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalGenFacturacion');
    });

    $('#btnGenerarFacturacion').on('click', function(event) {
        event.preventDefault();
        GenerarFacturacion();
    });

    $('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        //$('#rowCobroDiferenciado').fadeOut(400);
        $('#tableConcepto tbody').html('');
        $('#tableConceptoFormula tbody').html('');
        LimpiarProyecto();
        cancelImport();
        setUbigeo(0, 'Localidad');

        // if (this.getAttribute('id') == 'btnNuevo')
        GoToEdit('0');
    });

    $('.btnBackList').on('click', function (event) {
        event.preventDefault();
        BackToPrevPanel();
        $('#hdIdProyecto').val('0');

        $('#lblProceso').attr({
            'data-mes': '0',
            'data-anho': '0'
        }).text('Ninguno');

        if ($(this).attr('id') == 'btnBackToProyecto'){
            $('#btnLimpiarSeleccion').trigger('click');
            $('#btnClearSelPropiedades').trigger('click');
        };
    });

    $('#btnCancelar').on('click', function (event) {
        event.preventDefault();
        closeCustomModal('#modalRegistroProyecto');
    });

    $('#btnProceso').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalProceso', function () {
            ListarProcesos();
        });
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

        var idubigeo = $('#ddlDistrito').val();
        var descripcion = 'Perú/'  + $('#ddlDepartamento option:selected').text() + '/' + $('#ddlProvincia option:selected').text() + '/' + $('#ddlDistrito option:selected').text()
        
        setUbigeo(idubigeo, descripcion);
    });

    $('#btnHideConstructora').on('click', function(event) {
        event.preventDefault();
        $('#pnlConstructora').fadeOut(400, function() {
            
        });
    });

    $('#pnlInfoConstructora').on('click', function(event) {
        event.preventDefault();
        ShowPanelConstructora();
    });

    $('#gvConstructora .items-area').on('click', '.tile', function(event) {
        event.preventDefault();
        
        var idconstructora = '0';
        var nombre = '';

        idconstructora = $(this).attr('data-idconstructora');
        nombre = $(this).attr('data-nombre');

        setConstructora(idconstructora, nombre);
    });

    $('#ddlTipoProyecto').on('change', function(event) {
        event.preventDefault();
        ShowAskCobroTorre();
    });

    $('#ddlTipoValoracion').on('change', function(event) {
        event.preventDefault();
        //ShowAskCobroTorre();
    });

    /*$('#chkDatoSimpleDuplex').on('click', function(event) {
        //MostrarRowPorcentajeDuplex(this.checked);
        var idtorre = '0';
        var nombre = '';
        var seletor = '';

        idtorre = $(this).attr('data-idtorre');
        nombre = $(this).find('.descripcion').text();

        setTorre(idtorre, nombre);
    });*/

    $('#chkDatoSimpleDuplex').on('click', function(event) {
        MostrarRowPorcentajeDuplex(this.checked);
    });

    $('#chkPorcjDuplex').on('click', function(event) {
        MostrarPorcjDuplex(this.checked);
    });

    $('#ddlBanco').on('change', function(event) {
        event.preventDefault();
        ListarCuentaBancaria('0');
    });

    $('#btnGuardar').on('click', function (evt) {
        GuardarDatos();
    });

    // $('#btnListPropiedades').on('click', function(event) {
    //     event.preventDefault();
    //     GoToPropiedades();
    // });

    $('#btnGenPropFromList').on('click', function(event) {
        event.preventDefault();
        var proyecto;
        var topTorre = '';

        LimpiarForm();
        
        $('#rowTipoPropiedad').show();
        $('#rowRangos').show();
        //$('#btnPropiedadMasiva').addClass('oculto');
        //$('#btnGenerarPropiedad').removeClass('oculto');
        //$('#pnlPropiedadSelected').hide();

        proyecto = $('#gvDatos .list.selected');

        tipoproyecto = proyecto.attr('data-tipoproyecto');

        /*if (tipoproyecto == '00'){
            topTorre = '350px';
        }
        else {
            topTorre = '300px';
        };*/
        
        //$('#pnlPropiedadSelected').css('margin-top', '300px');

        GetLastIndexPropiedad();
        
        openModalCallBack('#modalGenPropiedad', function () {
            /*var idtipopropiedad = '0';
            idtipopropiedad = $('#ddlTipoPropiedad').val();
            ListarConceptos('PROPIEDAD', '00', idtipopropiedad, '0');*/
        });
    });

    $('#btnMassConcept').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
        GoToEditPropiedad();
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: EnvioAdminDatos
    });

    $('#chkIngresoTorre').on('click', function(event) {
        if ($(this)[0].checked){
            $('#pnlInfoTorre').addClass('oculto');
            $('#rowIngreso').removeClass('oculto');
            $('#txtIngresoTorre').focus();
        }
        else {
            $('#pnlInfoTorre').removeClass('oculto');
            $('#rowIngreso').addClass('oculto');
        };
    });

    $('#pnlInfoTorre').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalTorre', function () {
            ListarTorres();
        });
    });

    /*$('#btnGenerarPropiedad').on('click', function(event) {
        event.preventDefault();
        GenerarPropiedades();
    });*/

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#hdIdProyecto').val('0');
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnFijarProyecto, #btnEliminar, #btnIniciarFacturacion').addClass('oculto');
    });

    $('#gvPropiedad').on('click', '.tile[data-relaciones!="0"] .link-relacion', function(event) {
        event.preventDefault();
        var idpropiedad = '0';
        idpropiedad = $(this).parent().parent().parent().parent().attr('data-idpropiedad');
        ShowPanelRelacionadas(idpropiedad);
        return false;
    });

    $('#gvPropiedad').on('click', '.tile', function(event) {
        event.preventDefault();
        
        var checkBox = $(this).find('input:checkbox');
        var tipopropiedad = $('#ddlTipoPropiedadFiltro').val();
        var tipovaloracion = $('#hdTipoValoracion').val();
        
        var inputInItem = $(this).find('.inputInItem'); 
        var inputSaldoInicial = $(this).find('.input-saldoinicial'); 
        var inputRatio = $(this).find('.inputRatio');
        var inputImporteFijo = $(this).find('.inputImporteFijo');

        if ($(this).hasClass('selected')){

            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            
            inputInItem.addClass('hide');
            inputRatio.addClass('hide');
            inputImporteFijo.addClass('hide');

            if ($('#gvPropiedad .dato.selected').length == 0){
                $('#btnGenPropFromList').removeClass('oculto');
                $('#btnAsignPropToPerson, #btnMassConcept, #btnEliminarPropiedad, #btnClearSelPropiedades, #btnRelacionarPropiedades, #btnRomperRelaciones').addClass('oculto');
                //$('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnFijarProyecto, #btnEliminar').addClass('oculto');
            }
            else {
                if ($('#gvPropiedad .dato.selected').length == 1){
                    if ((tipopropiedad == 'EST') || (tipopropiedad == 'DEP')) {
                        $('#btnRelacionarPropiedades, #btnRomperRelaciones').removeClass('oculto');
                    }
                    else {
                        $('#btnRelacionarPropiedades, #btnRomperRelaciones').addClass('oculto');
                    };
                    $('#btnAsignPropToPerson, #btnMassConcept, #btnEliminarPropiedad, #btnClearSelPropiedades').removeClass('oculto');
                    //$('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar').removeClass('oculto');
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            
            inputInItem.removeClass('hide');
            
            if (tipovaloracion == '02')
                inputRatio.removeClass('hide');
            else if (tipovaloracion == '03')
                inputImporteFijo.removeClass('hide');

            inputSaldoInicial.focus();

            $('#btnGenPropFromList').addClass('oculto');
            //$('#btnNuevo, #btnUploadExcel').addClass('oculto');
            //$('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
            if (tipopropiedad == 'DPT') {
                $('#btnRelacionarPropiedades, #btnRomperRelaciones').addClass('oculto');
            }
            else {
                $('#btnRelacionarPropiedades, #btnRomperRelaciones').removeClass('oculto');
            };
            $('#btnAsignPropToPerson, #btnMassConcept, #btnEliminarPropiedad, #btnClearSelPropiedades').removeClass('oculto');

            /*if ($('#gvPropiedad .dato.selected').length == 1){
                //$('#btnEditar, #btnFijarProyecto, #btnListPropiedades').removeClass('oculto');
            }
            else {
                //$('#btnEditar, #btnFijarProyecto, #btnListPropiedades').addClass('oculto');
            };*/
        };
    });

    $('#gvPropiedad').on('focus', 'input:text', function(event) {
        $(this).select();
    });

    $('#gvPropiedad').on('click', 'input:text', function(event) {
        event.preventDefault();
        event.stopPropagation();
    });

    $('#gvDepartamento').on('click', '.tile', function(event) {
        event.preventDefault();

        var checkBox = $(this).find('input:checkbox');

        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvDepartamento .dato.selected').length == 0){
                $('#btnRelacionar, #btnClearSelDepartamentos').addClass('oculto');
            }
            else {
                $('#btnRelacionar, #btnClearSelDepartamentos').removeClass('oculto');
            };
        }
        else {
            $(this).siblings('.selected').removeClass('selected');
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnRelacionar, #btnClearSelDepartamentos').removeClass('oculto');
        };
    });

    $('#btnClearSelDepartamentos').on('click', function(event) {
        event.preventDefault();
        $('#btnSelectAllDepartamentos').removeClass('oculto');
        $('#gvDepartamento .tile.selected').removeClass('selected');
        $('#gvDepartamento input:checkbox:checked').removeAttr('checked');
        $('#btnRelacionar, #btnClearSelDepartamentos').addClass('oculto');
    });

    $('#btnSelectAllDepartamentos').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDepartamento .tile').addClass('selected');
        $('#gvDepartamento input:checkbox').attr('checked', '');
        $('#btnRelacionar, #btnClearSelDepartamentos').removeClass('oculto');
    });

    $('#btnRelacionarPropiedades').on('click', function(event) {
        event.preventDefault();
        ShowPanelDepartamento();
    });

    $('#btnRelacionar').on('click', function(event) {
        event.preventDefault();
        RelacionarDepartamento();
    });

    $('#btnRomperRelaciones').on('click', function(event) {
        event.preventDefault();
        RomperRelaciones();
    });

    $('#btnHideDepartamento').on('click', function(event) {
        event.preventDefault();
        $('#pnlDepartamento').fadeOut(400, function() {
            $('#btnClearSelDepartamentos').trigger('click');
        });
    });

    $('#btnHideRelaciones').on('click', function(event) {
        event.preventDefault();
        $('#pnlRelacionadas').fadeOut(400, function() {
            $('#pnlListPropiedades').fadeIn(400, function() {
                
            });
        });
    });

    $('#btnClearSelPropiedades').on('click', function(event) {
        event.preventDefault();
        $('#btnSelectAllPropiedades').removeClass('oculto');
        $('#gvPropiedad .tile.selected').removeClass('selected');
        $('#gvPropiedad input:checkbox:checked').removeAttr('checked');
        $('#btnGenPropFromList').removeClass('oculto');
        
        
        $('#gvPropiedad .inputInItem').addClass('hide');
        // $('#btnSaveValuesPropiedades').addClass('oculto');

        $('#btnAsignPropToPerson, #btnMassConcept, #btnEliminarPropiedad, #btnClearSelPropiedades, #btnRelacionarPropiedades, #btnRomperRelaciones').addClass('oculto');
    });

    $('#btnSelectAllPropiedades').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvPropiedad .tile').addClass('selected');
        $('#gvPropiedad input:checkbox').attr('checked', '');
        $('#btnGenPropFromList').addClass('oculto');

        var tipovaloracion = $('#hdTipoValoracion').val();

        $('#gvPropiedad .inputInItem').removeClass('hide');
            
        if (tipovaloracion == '02')
            $('#gvPropiedad .inputRatio').removeClass('hide');
        else if (tipovaloracion == '03')
            $('#gvPropiedad .inputImporteFijo').removeClass('hide');
        // $('#btnSaveValuesPropiedades').removeClass('oculto');

        $('#btnAsignPropToPerson, #btnMassConcept, #btnEliminarPropiedad, #btnClearSelPropiedades').removeClass('oculto');
    });

    $('#btnSaveValuesPropiedades').on('click', function(event) {
        event.preventDefault();
        //ActualizarValorPropiedad();
        openModalCallBack('#modalGenValorFijo', function () {
            var flagDirect = false;
            var flagOtroValor = false;

            var tipovaloracion = $('#hdTipoValoracion').val();
            var textOtroValor = $('#optOtroValor').parent().find('.text');
            
            $('#txtValorFijo').val('0.00');

            if ($('#gvPropiedad .dato.selected').length > 0) {
                flagDirect = true;
            }
            else {
                $('#optAllValue')[0].checked = true;
                $('#optSaldoInicial')[0].checked = true;
                
                $('#txtValorFijo').focus();
            };

            $('#optDirect')[0].checked = flagDirect;
            // 

            habilitarControl('#optDirect', flagDirect);

            if ((tipovaloracion == '02') || (tipovaloracion == '03')) {
                flagOtroValor = true;
                if (tipovaloracion == '02') {
                    textOtroValor.text('Ratio fijo');
                }
                else {
                    textOtroValor.text('Importe fijo');
                };
            }
            else {
                textOtroValor.text('No disponible');
            };

            habilitarControl('#optOtroValor', flagOtroValor);
        });
    });

    $('#btnGuardarValores').on('click', function(event) {
        event.preventDefault();
        if ($('#optDirect')[0].checked) {
            ActualizarValorPropiedad();
        }
        else {
            ActualizarValorFijoMasivo();
        };
    });

    $('#btnAsignPropToPerson').on('click', function(event) {
        event.preventDefault();
        ShowPanelPropietarioInquilino();
    });

    $('#pnlInfoArea').on('click', function(event) {
        event.preventDefault();
        unsetArea();
        $('#gpConcepto').removeClass('gp-no-body').removeClass('gp-expand-header');
        openCustomModal('#modalConcepto');
    });

    $('#btnHidePropietarioInquilino').on('click', function(event) {
        event.preventDefault();
        $('#pnlPropietarioInquilino').fadeOut(400, function() {
            $('#btnClearSelPropInquilino').trigger('click');
        });
    });

    $('#txtAreaTechada').on({
        keydown: function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER){
                $('#txtAreaSinTechar').focus();
                return false;
            }
        },
        keypress : function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER)
                return false;
        },
        keyup : function(event) {
            CalcularArea();
        }
    });

    $('#txtAreaSinTechar').on('keyup', function(event) {
        CalcularArea();
    });

    $('#pnlPropietarioInquilino').on('click', '.list', function(event) {
        event.preventDefault();
    
        var checkBox = $(this).find('input:checkbox');
        
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#pnlPropietarioInquilino .dato.selected').length == 0){
                //$('').removeClass('oculto');
                $('#btnClearSelPropInquilino, #btnAsignarPropiedades').addClass('oculto');
                //$('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnEliminar').addClass('oculto');
            }
            else {
                if ($('#pnlPropietarioInquilino .dato.selected').length == 1){
                    $('#btnClearSelPropInquilino, #btnAsignarPropiedades').removeClass('oculto');
                    //$('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar').removeClass('oculto');
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            //$('').addClass('oculto');
            //$('#btnNuevo, #btnUploadExcel').addClass('oculto');
            //$('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
            $('#btnClearSelPropInquilino, #btnAsignarPropiedades').removeClass('oculto');

            /*if ($('#pnlPropietarioInquilino .dato.selected').length == 1){
                //$('#btnEditar, #btnListPropiedades').removeClass('oculto');
            }
            else {
                //$('#btnEditar, #btnListPropiedades').addClass('oculto');
            };*/
        };
    });

    $('#btnClearSelPropInquilino').on('click', function(event) {
        event.preventDefault();
        $('#btnSelectAllPropInquilino').removeClass('oculto');
        $('#pnlPropietarioInquilino .dato.selected').removeClass('selected');
        $('#pnlPropietarioInquilino input:checkbox:checked').removeAttr('checked');
        $('#btnClearSelPropInquilino, #btnAsignarPropiedades').addClass('oculto');
    });

    $('#btnSelectAllPropInquilino').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#pnlPropietarioInquilino .dato').addClass('selected');
        $('#pnlPropietarioInquilino input:checkbox').attr('checked', '');
        $('#btnClearSelPropInquilino, #btnAsignarPropiedades').removeClass('oculto');
    });

    $('#btnAsignarPropiedades').on('click', function(event) {
        event.preventDefault();
        AsignarPropiedades();
    });

    $('#txtSearch').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearch').trigger('click');
            return false;
        };
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();
        $('#btnLimpiarSeleccion').trigger('click');
        
        paginaProyecto = 1;
        ListarProyectos('1');
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
        $('#btnClearSelPropiedades').trigger('click');
        
        paginaPropiedad = 1;
        ListarPropiedades('1');
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
        paginaPropietario = 1;
        ListarPropietarios('1');
    });

    $('#txtSearchInquilino').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchInquilino').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchInquilino').on('click', function(event) {
        event.preventDefault();
        paginaInquilino = 1;
        ListarInquilinos('1');
    });

    $('#gvDatos').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropiedad').val());

            ListarProyectos(paginaActual);
        };
    });

    $('#gvPropiedad > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropiedad').val());

            ListarPropiedades(paginaActual);
        };
    });

    $('#gvPropietario > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPagePropietario').val());

            ListarPropietarios(paginaActual);
        };
    });

    $('#gvInquilino > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageInquilino').val());

            ListarInquilinos(paginaActual);
        };
    });

    $('#ddlTipoPropiedadFiltro').on('change', function(event) {
        event.preventDefault();
        $('#btnClearSelPropiedades').trigger('click');
        
        paginaPropiedad = 1;
        ListarPropiedades('1');
    });

    $('#ddlTipoPropiedad').on('change', function(event) {
        event.preventDefault();
        GetLastIndexPropiedad();
    });

    $('#tableConcepto tbody').on('keyup', 'input:text', function(event) {
        EvalConcepto();
    });

    $('#btnAplicarConcepto').on('click', function(event) {
        event.preventDefault();
        setArea();
        closeCustomModal('#modalConcepto');
    });

    $('#btnPropiedadMasiva').on('click', function(event) {
        event.preventDefault();
        EditMassrPropiedad();
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

    $('#btnCancelarGenProp').add('#btnCloseModalGenPropiedad').on('click', function(event) {
        event.preventDefault();
        
        if (completado == false){
            bootbox.confirm('¿Está seguro de cancelar el envío?', function (result) {
                if (result){
                    progress = 0;
                    indexList = 0;
                    
                    if (intervalProgress.isRunning())
                        intervalProgress.stop();

                    abandonarTodasLasPeticiones();

                    MessageBox('Operaci&oacute;n cancelada', 'Se cancelaron todas las peticiones', "[Aceptar]", function () {
                    });
                };
            });
        };

        closeCustomModal('#modalGenPropiedad');
    });

    $('#btnEliminarPropiedad').on('click', function(event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarPropiedad();
        };
    });   

    $('#btnGenVistaPropiedad').on('click', function(event) {
        event.preventDefault();
        GenerarVistaPreviaPropiedad();
    });

    $('#pnlInfoConcepto').on('click', function(event) {
        event.preventDefault();
        $('#gpConcepto').addClass('gp-no-body').addClass('gp-expand-header');
        openCustomModal('#modalConcepto');
    });

    $('#btnBackToInfoProyecto').on('click', function(event) {
        event.preventDefault();

        $('#lblProceso').attr({
            'data-mes': '0',
            'data-anho': '0'
        }).text('Ninguno');

        $('#pnlInfoDetalleProyecto').fadeOut(400, function() {
            $('#pnlInfoGeneralProyecto').fadeIn(400, function() {
            });
        });
    });

    $('#tableProceso tbody').on('click', 'tr[data-estado="1"]', function(event) {
        event.preventDefault();
        
        $(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');

        $('#btnCerrarProceso').removeClass('oculto');
    });

    $('#btnAbrirProceso').on('click', function(event) {
        event.preventDefault();
        GestionarProceso(true);
    });

    $('#btnCerrarProceso').on('click', function(event) {
        event.preventDefault();
        GestionarProceso(false);
    });

    $('#btnFijarProyecto').on('click', function(event) {
        event.preventDefault();
        FijarProyecto();
    });

    $('.droping-air').on({
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
    }, '.file-import');

    $('.droping-air .cancel').on('click', function(event) {
        event.preventDefault();
        cancelImport();
    });

    $('#btnEliminar').on('click', function(event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarProyecto();
        };
    });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var paginaProyecto = 1;
var paginaPropiedad = 1;
var paginaPropietario = 1;
var paginaInquilino = 1;
var formula = '';
var fileValue = false;
var completado = true;
var escobrodiferenciado = 0;
var idbanco = 0;
var idcuentabancaria = 0;

var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var intervalProgress = new Interval(function(){
    var pbMetro;
    var progressBar;
    
    progressBar = $(elemsSelected[indexList]).find('.progress-bar');
    
    pbMetro = progressBar.progressbar({
        animate: true
        // color: 'bg-cyan'
    });

    pbMetro.progressbar('value', (++progress));
    if (progress == 100)
        intervalProgress.stop();
}, 100);

function LimpiarForm_SaldoInicial () {
    $('#hdIdPrimary').val('0');
    $('#txtSaldoInicial').val('').focus();
}

function GoToEdit_SaldoInicial () {
    //precargaExp('body', true);
    // var recordEdit = $('#tableLiquidacion tr.selected');
    // var idrecord = '0';
    
    // if (recordEdit.length > 0){
    //     idrecord = recordEdit.attr('data-idliquidacion');
        
    //     $.ajax({
    //         url: 'services/liquidacion/liquidacion-search.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         data: {
    //             tipobusqueda: '2',
    //             id: idrecord
    //         }
    //     })
    //     .done(function(data) {
    //         var countdata = 0;

    //         countdata = data.length;

    //         if (countdata > 0){
    //             $('#hdIdPrimary').val(data[0].tm_idliquidacion);
    //             $('#ddlAnho').val(data[0].tm_per_ano);
    //             $('#ddlMes').val(data[0].tm_per_mes);
    //             $('#txtSaldoInicial').val(data[0].tm_saldoinicial);

    //             setProyecto(data[0].tm_idproyecto, data[0].nombreproyecto);
    //         };
    //     })
    //     .fail(function() {
    //         console.log("error");
    //     })
    //     .always(function() {
    //         console.log("complete");
    //     });
    // };
    openModalCallBack('#modalLiquidacion', function () {
        var today = new Date();
        var yyyy = today.getFullYear();

        ListarAnhoProceso_liquidacion(yyyy);
    });
}


function createFrame(selector, _link) {
    precargaExp('body', true);

    var idproyecto = $('#hdIdProyecto').val();
    var anho = $('#lblProceso').attr('data-anho');
    var mes = $('#lblProceso').attr('data-mes');
    var estadoproceso = $('#lblProceso').attr('data-estado');

    window.top.idproyecto = idproyecto;
    window.top.anho = anho;
    window.top.mes = mes;
    window.top.escobrodiferenciado = escobrodiferenciado;
    window.top.idbanco = idbanco;
    window.top.idcuentabancaria = idcuentabancaria;
    window.top.estadoproceso = estadoproceso;

    var _frame;

    if ($(selector + ' .tab-pane.active iframe').length == 0){
        var tab = _link.getAttribute('href');
        var url = _link.getAttribute('data-url');

        var panel = document.getElementById(tab.substr(1));
        _frame = document.createElement('iframe');

        url = url + '&idproyecto=' + idproyecto;
        url = url + '&anho=' + anho;
        url = url + '&mes=' + mes;
        url = url + '&escobrodiferenciado=' + escobrodiferenciado;
        url = url + '&idbanco=' + idbanco;
        url = url + '&idcuentabancaria=' + idcuentabancaria;
        url = url + '&estadoproceso=' + estadoproceso;

        _frame.setAttribute('scrolling', 'no');
        _frame.setAttribute('marginwidth', '0');
        _frame.setAttribute('marginheight', '0');
        _frame.setAttribute('width', '100%');
        _frame.setAttribute('height', '100%');
        _frame.setAttribute('frameborder', 'no');
        _frame.setAttribute('src', url);

        // console.log('shit');

        _frame.onload = function(event){
            var fd = this.document || this.contentWindow;
            fd.Cambiar_DatosProyecto_Work(idproyecto, anho, mes);
            precargaExp('body', false);
        };

        panel.appendChild(_frame);
    }
    else {
        _frame = $(selector + ' .tab-pane.active iframe')[0];
        var fd = _frame.document || _frame.contentWindow;
        // console.log(fd);
        console.log('fuck');
        // var _fd = _frame.document || _frame.contentWindow;
        fd.Cambiar_DatosProyecto_Work(idproyecto, anho, mes);
        precargaExp('body', false);
    };
}

function ListarAnhoProceso () {
    $.ajax({
        url: 'services/proceso/proceso-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ANHO',
            idproyecto: '0'
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<option value="' + data[i].per_ano + '">' + data[i].per_ano + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">NO HAY PROCESOS VIGENTES</option>';

            $('#ddlAnho').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarAnhoProceso_liquidacion (anhodefault) {
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

            $('#ddlAnho_Liquidacion').html(strhtml);

            // ListarLiquidacion();
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function ListarProyectos (pagina) {
    var selector = '#gvDatos';

    precargaExp('#gvDatos', true);

    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearch').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    // iditem = data[i].idproyecto;
                    // strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-codigo="' + data[i].codigoproyecto + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-datosimpleduplex="' + data[i].datosimpleduplex + '" data-tipovaloracion="' + data[i].tipovaloracion + '">';

                    // strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    // strhtml += '<div class="list-content pos-rel">';

                    // strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-top-right padding5 margin5">TIPO DE VALORACION: ' + data[i].ubigeo + '</span>';

                    // strhtml += '<div class="data">';
                    // strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].codigoproyecto + ' - ' + data[i].nombreproyecto + '</span></p><p class="fg-white">Direcci&oacute;n: <span class="direccion">' + data[i].direccionproyecto + '</span></p>';

                    // if (data[i].pordefecto == '1')
                    //     strhtml += '<i class="icon-checkmark place-bottom-right padding10 fg-white bg-green"></i>';

                    // strhtml += '</main>';
                    // strhtml += '<div class="progress-bar small hide" data-role="progress-bar" data-value="0"></div>';

                    // strhtml += '</div></div>';
                    // strhtml += '</a>';

                    var iditem = data[i].idproyecto;

                    // var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_subtotal).toFixed(2);
                    // var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    // var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_totalcompra).toFixed(2);

                    strhtml += '<div';
                    strhtml += ' data-id="' + iditem + '"';

                    strhtml += ' data-idproyecto="' + iditem + '"';
                    strhtml += ' data-codigo="' + data[i].codigoproyecto + '"';
                    strhtml += ' data-nombre="' + data[i].nombreproyecto + '"';
                    strhtml += ' data-tipoproyecto="' + data[i].tipoproyecto + '"';
                    strhtml += ' data-datosimpleduplex="' + data[i].datosimpleduplex + '"';
                    strhtml += ' data-tipovaloracion="' + data[i].tipovaloracion + '"';
                    strhtml += ' data-tipoproyecto="' + data[i].tipoproyecto + '"';
                    strhtml += ' data-datosimpleduplex="' + data[i].datosimpleduplex + '"';
                    strhtml += ' data-tipovaloracion="' + data[i].tipovaloracion + '"';
                    strhtml += ' data-escobrodiferenciado="' + data[i].escobrodiferenciado + '"';
                    strhtml += ' data-idbanco="' + data[i].idbanco + '"';
                    strhtml += ' data-idcuentabancaria="' + data[i].idcuentabancaria + '"';

                    strhtml += ' class="dato result item pos-rel animate mdl-shadow--2dp margin10 full-size">';
                    
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4>ID Proyecto #' + iditem + '</h4>';

                    strhtml += '<p class="descripcion"><strong>' + data[i].codigoproyecto + ' - ' + data[i].nombreproyecto + '</strong></p>';
                    strhtml += '<p class="lugar"><strong>Direcci&oacute;n: </strong>' + data[i].direccionproyecto.length == 0 ? 'Sin direcci&oacute;n espec&iacute;fica' : data[i].direccionproyecto + '</p>';
                    // strhtml += '<p class="lugar"><strong>Ubicaci&oacute;n: </strong>' + data[i].ubigeo + '</p>';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4>Tipo de proyecto:</h4>';
                    // strhtml += '<p><span class="horario">El d&iacute;a: ' + fecha +  ', desde las: ' + horainicio + ' hasta las ' + horafinal + ' </span><br />';
                    strhtml += '<span class="duracion">' + data[i].ubigeo + '</span>';
                    // strhtml += '</p>';
                    // strhtml += '<h4><span class="label label-' + data[i].color_estado_requerimiento + '">' + data[i].text_estado_requerimiento + '</span></h4>';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="col-md-4">';

                     strhtml += '<div class="grouped-buttons no-margin pos-rel">';

                    strhtml += '<a data-action="more" href="#" class="btn btn-primary right margin10">Opciones</a>';

                    strhtml += '<ul class="dropdown-list">';
                    strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
                    strhtml += '<li><a href="#" data-action="more-info">M&aacute;s informaci&oacute;n</a></li>';
                    strhtml += '<li role="separator" class="divider"></li>';
                    strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
                    strhtml += '</ul>';

                    strhtml += '</div>';

                    // strhtml += '<button type="button" class="btn btn-primary center-block btn-sm">Editar</button>';
                    // strhtml += '<div class="padding30">'
                    // strhtml += '<div class="btn-group center-block">';
                    // strhtml += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones <span class="caret"></span></button>';
                    // strhtml += '<ul class="dropdown-menu">';
                    // strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
                    // strhtml += '<li><a href="#" data-action="more-info">M&aacute;s informaci&oacute;n</a></li>';
                    // // strhtml += '<li><a href="#"></a></li>';
                    // strhtml += '<li role="separator" class="divider"></li>';
                    // strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
                    // strhtml += '</ul>';
                    // strhtml += '</div>';
                    // strhtml += '</div>';

                    // strhtml += '<h5 class="row"><strong class="col-md-4">Base imponible: </strong><span class="col-md-8 blue-text text-right">' + importe_sinimpuesto + '</span></h5>';
                    // strhtml += '<h5 class="row"><strong class="col-md-4">Impuestos deducidos: </strong><span class="col-md-8 blue-text text-right">' + importe_impuesto + '</span></h5>';
                    // strhtml += '<h5 class="row"><strong class="col-md-4">Total de importe: </strong><span class="col-md-8 blue-text text-right">' + importe_conimpuesto + '</span></h5>';
                    // strhtml += '<h4 class="text-center">Vacantes</h4>';
                    // strhtml += '<h4 class="text-center blue-text">' + cantidad + '</h4>';
                    // strhtml += '</div>';
                    
                    // strhtml += '</div>';
                    
                    // strhtml += '<small class="text-muted margin10 place-bottom-right"><i class="fa fa-clock-o"></i> Publicado el: ' + fecha_reg + '</small>';
                    strhtml += '<div class="clear"></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';

                    ++i;
                };

                paginaProyecto = paginaProyecto + 1;

                $('#hdPageProyecto').val(paginaProyecto);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No hay datos.</h2>');
            };
            
            precargaExp('#gvDatos', false);
        }
    });
}

function ListarPropiedades (pagina) {
    var selector = '#gvPropiedad .items-area';

    precargaExp('#gvPropiedad', true);

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
            var countdata = 0;
            var strhtml = '';
            var colortile = '';
            var iditem = '';
            var idtipopropiedad = '';
            var bgarea = '';
            var nrodoc = '';
            var nombrepropietario = '';
            var textrelaciones = '';
            var cssBgRelacion = '';
            var tipovaloracion = $('#hdTipoValoracion').val();

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idpropiedad;
                    idtipopropiedad = data[i].idtipopropiedad;


                    if (data[i].numerodoc != null) {
                        nrodoc = data[i].numerodoc.trim().length == 0 ? '' : data[i].numerodoc + ' ';
                    };

                    if (data[i].descrippersona != null) {
                        nombrepropietario = data[i].descrippersona.trim().length == 0 ? '(EN BLANCO)' : data[i].descrippersona;
                    }
                    else {
                        nombrepropietario = '(EN BLANCO)';
                    };
                    
                    if (idtipopropiedad == 'DPT')
                        colortile = ' blue-grey lighten-2';
                    else if (idtipopropiedad == 'DEP')
                        colortile = ' grey darken-1';
                    else if (idtipopropiedad == 'EST')
                        colortile = ' blue-grey';
                    else if (idtipopropiedad == 'TIE')
                        colortile = ' blue-grey darken-1';

                    if (Number(data[i].area) > 0) {
                        bgarea = 'bg-dark';
                    }
                    else {
                        bgarea = 'bg-darkRed';
                    };

                    if (data[i].cantidadrelaciones == '0') {
                        if (data[i].propiedadpadre.length == 0){
                            textrelaciones = 'SIN PROPIEDADES RELACIONADAS';
                            cssBgRelacion = ' bg-gray';
                        }
                        else {
                            textrelaciones = data[i].propiedadpadre;
                            cssBgRelacion = ' light-blue darken-4';
                        };
                    }
                    else {
                        textrelaciones = 'VER PROPIEDADES RELACIONADAS';
                        cssBgRelacion = ' light-blue darken-4';
                    };

                    strhtml += '<div class="tile dato double almost-double-vertical shadow ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-areasintechar="' + data[i].areasintechar + '" ';
                    strhtml += 'data-areatechada="' + data[i].areatechada + '" ';
                    strhtml += 'data-area="' + data[i].area + '" ';
                    strhtml += 'data-idclasepropiedad="' + data[i].idclasepropiedad + '" ';
                    strhtml += 'data-idpropietario="' + data[i].idpersona + '" ';
                    strhtml += 'data-relaciones="' + data[i].cantidadrelaciones + '" ';
                    strhtml += 'title="' + nrodoc + nombrepropietario + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="place-top-left">';
                    strhtml += '<h5 class="fg-white">'+ data[i].torre + '</h5>';
                    strhtml += '</div>';

                    strhtml += '<div class="inputInItem padding20 bg-white shadow row hide">';

                    strhtml += '<div class="grid fluid"><div class="row">';

                    strhtml += '<div class="span6">';
                    strhtml += '<div class="inputSaldoInicial">';
                    strhtml += '<label class="black-text">Saldo Inicial</label>';
                    strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
                    strhtml += '<input type="text" class="fg-black input-saldoinicial" value="' + data[i].saldoinicial + '" />';
                    strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '<div class="span6">';
                    
                    strhtml += '<div class="inputRatio hide">';
                    strhtml += '<label class="black-text">Ratio</label>';
                    strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
                    strhtml += '<input type="text" class="fg-black input-ratio" value="' + data[i].ratio + '" />';
                    strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '<div class="inputImporteFijo hide">';
                    strhtml += '<label class="black-text">Importe Fijo</label>';
                    strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
                    strhtml += '<input type="text" class="fg-black input-importefijo" value="' + data[i].importefijo + '" />';
                    strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    
                    strhtml += '</div>';

                    strhtml += '</div></div>';

                    strhtml += '</div>';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h3 class="white-text">' + data[i].descripcionpropiedad + '</h3>';
                    strhtml += '<h6 class="padding5 text-ellipsis smaller bg-white text-center fg-dark">' + nombrepropietario + '</h6>';
                    strhtml += '<h6 class="link-relacion padding5 smaller text-center fg-white' + cssBgRelacion + '">' + textrelaciones + '</h6>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand"><span class="badge ' + bgarea + '">Area: ' + data[i].area + ' (m<sup>2</sup>)</span></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                }
                
                paginaPropiedad = paginaPropiedad + 1;

                $('#hdPagePropiedad').val(paginaPropiedad);

                if (pagina == 1)
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == 1)
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#gvPropiedad', false);
        }
    });
}

function ListarPropiedades_Orden (pagina) {
    var selector = '#gvPropiedadOrden .ui-sortable';

    precargaExp('#gvPropiedadOrden', true);

    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdProyecto').val(),
            idtipopropiedad: "*",
            criterio: $('#txtSearchPropiedad').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var strhtml = '';
            var colortile = '';
            var bgarea = '';
            var nrodoc = '';
            var nombrepropietario = '';
            var textrelaciones = '';
            var cssBgRelacion = '';
            var tipovaloracion = $('#hdTipoValoracion').val();

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].idpropiedad;
                    var idtipopropiedad = data[i].idtipopropiedad;

                    if (data[i].numerodoc != null)
                        nrodoc = data[i].numerodoc.trim().length == 0 ? '' : data[i].numerodoc + ' ';

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

                    bgarea = Number(data[i].area) > 0 ? 'bg-dark' : 'bg-darkRed';

                    if (data[i].cantidadrelaciones == '0') {
                        if (data[i].propiedadpadre.length == 0){
                            textrelaciones = 'SIN PROPIEDADES RELACIONADAS';
                            cssBgRelacion = ' bg-gray';
                        }
                        else {
                            textrelaciones = data[i].propiedadpadre;
                            cssBgRelacion = ' light-blue darken-4';
                        };
                    }
                    else {
                        textrelaciones = 'VER PROPIEDADES RELACIONADAS';
                        cssBgRelacion = ' light-blue darken-4';
                    };

                    // strhtml += '<div class="tile dato double almost-double-vertical shadow ' + colortile + '" ';
                    strhtml += '<a ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-areasintechar="' + data[i].areasintechar + '" ';
                    strhtml += 'data-areatechada="' + data[i].areatechada + '" ';
                    strhtml += 'data-area="' + data[i].area + '" ';
                    strhtml += 'data-idclasepropiedad="' + data[i].idclasepropiedad + '" ';
                    strhtml += 'data-idpropietario="' + data[i].idpersona + '" ';
                    strhtml += 'data-relaciones="' + data[i].cantidadrelaciones + '" ';
                    strhtml += 'title="' + nrodoc + nombrepropietario + '" ';
                    
                    strhtml += 'href="#" class="list' + colortile + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="list-content">' + data[i].descripcionpropiedad + '</div></a>';
                    
                    ++i;
                }
                
                paginaPropiedad = paginaPropiedad + 1;

                $('#hdPagePropiedad__Orden').val(paginaPropiedad);

                if (pagina == 1)
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $( selector ).sortable({
                    start: function(event, ui) {
                        var start_pos = ui.item.index();
                        ui.item.data('start_pos', start_pos);
                    },
                    update: function(event, ui) {
                        var start_pos = ui.item.data('start_pos');
                        var end_pos = ui.item.index();
                        
                        alert(start_pos + ' - ' + end_pos);
                    }
                });

                $( selector ).disableSelection();

                $('#gvPropiedadOrden').on('scroll', '.listview', function(){
                    var paginaActual = 0;

                    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        paginaActual = Number($('#hdPagePropiedad__Orden').val());

                        ListarPropiedades_Orden(paginaActual);
                    };
                });
            }
            else {
                if (pagina == 1){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                };
            };
            
            precargaExp('#gvPropiedadOrden', false);
        }
    });
}

function ListarPropietarios (pagina) {
    var selector = '#gvPropietario .items-area';

    precargaExp('#gvPropietario', true);

    $.ajax({
        type: "GET",
        url: "services/propietario/propietario-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + encodeURIComponent($('#txtSearchPropietario').val()) + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var bgtiporelacion = '';

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].tm_idtipopropietario;
                    foto = data[i].tm_foto;
                    strhtml += '<a href="#" class="list dato bg-gray-glass bg-cyan" data-idpropietario="' + iditem + '" data-tipopropietario="' + data[i].tm_iditc + '" data-tipopersona="00">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';

                    /*if (data[i].tm_idcanal == 1)
                        bgtiporelacion = 'bg-green';
                    else
                        bgtiporelacion = 'bg-darkCyan';*/
                    
                    strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-bottom-right padding5 margin5"style="z-index: 99;">UBIGEO: ' + data[i].ubigeo + '</span>';

                    strhtml += '<div class="data">';
                    strhtml += '<aside>';

                    if (foto == 'no-set')
                        strhtml += '<i class="fa fa-user"></i>';
                    else
                        strhtml += '<img src="' + foto + '" />';
                    
                    strhtml += '</aside>';

                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].descripcion + '</span></p><p class="fg-white">Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].tipodoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                    strhtml += '</main>';

                    strhtml += '<div class="progress-bar small" data-role="progress-bar" data-value="0"></div>';
                    //strhtml += '<progress></progress>';
                    //strhtml += '<span class="list-remark">No asignado</span>';

                    strhtml += '</div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                paginaPropietario = paginaPropietario + 1;

                $('#hdPagePropietario').val(paginaPropietario);
                
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
            
            precargaExp('#gvPropietario', false);
        }
    });   
}

function ListarInquilinos (pagina) {
    var selector = '#gvInquilino .items-area';

    precargaExp('#gvInquilino', true);
    
    $.ajax({
        type: "GET", 
        url: "services/inquilino/inquilino-search.php",
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchInquilino').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var bgtiporelacion = '';

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].tm_idtipoinquilino;
                    foto = data[i].tm_foto;

                    strhtml += '<a href="#" class="list dato bg-gray-glass bg-cyan" data-idinquilino="' + iditem + '" data-tipoinquilino="' + data[i].tm_iditc + '" data-tipopersona="01">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    
                    strhtml += '<span class="ubigeotag fg-white bg-darkCyan place-top-right padding5 margin5">UBIGEO: ' + data[i].ubigeo + '</span>';

                    strhtml += '<div class="data">';
                    strhtml += '<aside>';

                    if (foto == 'no-set')
                        strhtml += '<i class="fa fa-user"></i>';
                    else
                        strhtml += '<img src="' + foto + '" />';
                    
                    strhtml += '</aside>';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].descripcion + '</span></p><p class="fg-white">Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].tipodoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                    strhtml += '</main>';

                    strhtml += '<div class="progress-bar small" data-role="progress-bar" data-value="0"></div>';

                    strhtml += '</div></div>';
                    strhtml += '</a>';
                    ++i;
                };

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
            
            precargaExp('#gvInquilino', false);
        }
    });
}

function prepareImport (files) {
    var allowedTypes = ['jpg','png','gif','jpeg'];
    var extension = '';
    var filename = '';
    var oFReader = new FileReader();

    fileValue = files[0]; 
    filename = files[0].name;
    extension = filename.split('.').pop().toLowerCase();

    if ($.inArray(extension, allowedTypes) == -1) {
        MessageBox('Archivo no v&aacute;lido', 'El tipo de archivo *.' + extension + ' no es compatible', "[Aceptar]", function () {
        });
        return false;
    };

    oFReader.readAsDataURL(fileValue);
    console.log(fileValue);
    oFReader.onload = function (oFREvent) {
        $('.droping-air .help').text(filename);
        $('.droping-air').addClass('dropped');
        $('.droping-air > .icon').css('background', 'url(' + oFREvent.target.result + ') no-repeat center');
        $('.droping-air > .cancel').removeClass('oculto');
    };
}

function cancelImport () {    
    $('#fileImagen').val('');
    $('.droping-air .help').text('Seleccione o arrastre un archivo de imagen (*.jpg, .gif, *.png)');
    $('.droping-air').removeClass('dropped');
    $('.droping-air > .icon').css('background', 'transparent');
    $('.droping-air > .cancel').addClass('oculto');
    $('#hdFoto').val('no-set');
    fileValue = false;
}

function CalcularArea () {
    var areatechada = 0;
    var areasintechar = 0;
    var area = 0;

    areatechada = Number(document.getElementById('txtAreaTechada').value);
    areasintechar = Number(document.getElementById('txtAreaSinTechar').value);
    area = areatechada + areasintechar;

    document.getElementById('txtAreaPropiedad').value = area.toFixed(2);
}

function AsignarPropiedades () {
    indexList = 0;
    elemsSelected = $('#pnlPropietarioInquilino .list.selected').toArray();
    EnvioDataAsignacion(elemsSelected[0]);
}

function EnvioDataAsignacion (item) {
    var idpersona = '';
    
    var data = new FormData();
    var itemSelected = $(item);

    var progressBar = itemSelected.find('.progress-bar');
    
    var pbMetro = progressBar.progressbar({
        animate: true
        // color: 'bg-cyan'
    });
    
    var tipopersona = itemSelected.attr('data-tipopersona');
    
    if (tipopersona == '00')
        idpersona = itemSelected.attr('data-idpropietario');
    else if (tipopersona == '01')
        idpersona = itemSelected.attr('data-idinquilino');
    
    var itemsPropiedades = $('#gvPropiedad .tile.selected');

    var listpropiedades = $.map(itemsPropiedades, function(n, i){
        return n.getAttribute('data-idpropiedad');
    }).join(',');
    
    data.append('btnAsignarPropiedades', 'btnAsignarPropiedades');
    data.append('listpropiedades', listpropiedades);
    data.append('hdTipoPersona', tipopersona);
    data.append('hdIdPersona', idpersona);

    $.ajax({
        url: 'services/propiedad/propiedad-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            //console.log(data);
            ++indexList;
            progressError = false;
            
            pbMetro.progressbar('value', 100);
            // pbMetro.progressbar('color', 'bg-green');

            if (intervalProgress.isRunning())
                intervalProgress.stop();

            if (indexList <= elemsSelected.length - 1){
                EnvioDataAsignacion(elemsSelected[indexList]);
            }
            else {
                completado = true;
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (data.rpta != '0'){
                        paginaPropiedad = 1;
                        ListarPropiedades('1');
                        $('#btnHidePropietarioInquilino').trigger('click');
                    };
                });
            };
        },
        beforeSend: function () {
            completado = false;
            intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        if (intervalProgress.isRunning())
                            intervalProgress.stop();
                        pbMetro.progressbar('value', 100);
                        EnvioDataAsignacion(elemsSelected[indexList]);
                    }, 10000);
                };
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

function MostrarRowPorcentajeDuplex (flag) {
    if (flag){
        $('#rowPorcentajeDuplex').show();
    }
    else {
        $('#chkPorcjDuplex')[0].checked = false;
        $('#rowPorcentajeDuplex').hide();
        $('#rowPorcjDuplex').hide();
        $('#rowChkPorcjDuplex').removeClass('span8').addClass('span12');
        $('#txtPorcjDuplex').val('0');
    };
}

function MostrarPorcjDuplex (flag) {
    if (flag){
        $('#rowPorcjDuplex').show();
        $('#rowChkPorcjDuplex').removeClass('span12').addClass('span8');
        $('#txtPorcjDuplex').val('50').focus();
    }
    else {
        $('#rowPorcjDuplex').hide();
        $('#rowChkPorcjDuplex').removeClass('span8').addClass('span12');
        $('#txtPorcjDuplex').val('0');
    };
}

function EliminarProyecto () {xzzxxxz
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemProyecto(elemsSelected[0]);
}

function EliminarItemProyecto (item) {
    var data = new FormData();
    var idproyecto = '0';

    idproyecto = item.getAttribute('data-idproyecto');

    data.append('btnEliminarItem', 'btnEliminarItem');
    data.append('hdIdProyecto', idproyecto);

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollProyectos;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El proyecto ' + idproyecto + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' tiene propiedades relacionadas.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollProyectos = $('#gvDatos .listview');
                iScroll = scrollProyectos.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollProyectos.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemProyecto(elemsSelected[indexList]);
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

function GenerarFacturacion () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    GenerarFacturacionProyecto(elemsSelected[0]);
}

function GenerarFacturacionProyecto (item) {
    var idproyecto = item.getAttribute('data-idproyecto');
    var itemSelected = $(item);
    var progressBar = itemSelected.find('.progress-bar');
    var pbMetro = progressBar.progressbar({
        animate: true
        // color: 'bg-cyan'
    });

    var data = new FormData();
    data.append('btnGenerar', 'btnGenerar');
    data.append('hdIdProyecto', idproyecto);
    data.append('ddlAnho', $('#ddlAnho').val());
    data.append('ddlMes', $('#ddlMes').val());
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
            var scrollPropiedades = $('#gvPropiedadSelected .listview');
            var iScroll = scrollPropiedades.scrollTop();

            ++indexList;
            progressError = false;
            
            pbMetro.progressbar('value', 100);
            // pbMetro.progressbar('color', 'bg-green');

            if (intervalProgress.isRunning())
                intervalProgress.stop();

            if (indexList <= elemsSelected.length - 1){
                iScroll = iScroll + (itemSelected.height() + 18);
                
                scrollPropiedades.animate({ scrollTop: iScroll  }, 400, function () {
                    GenerarFacturacionProyecto(elemsSelected[indexList]);
                });
            }
            else {
                completado = true;

                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    $('#btnLimpiarSeleccion').trigger('click');
                    paginaProyecto = 1;
                    ListarProyectos('1');
                });
            };
        },
        beforeSend: function () {
            closeCustomModal('#modalGenFacturacion');
            $('#gvDatos .dato.selected .progress-bar').removeClass('hide');
            intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        if (intervalProgress.isRunning())
                            intervalProgress.stop();
                        pbMetro.progressbar('value', 100);
                        GenerarFacturacionProyecto(elemsSelected[indexList]);
                    }, 10000);
                };
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

function EliminarPropiedad () {
    indexList = 0;
    elemsSelected = $('#gvPropiedad .selected').toArray();
    EliminarItemPropiedad(elemsSelected[0]);
}

function EliminarItemPropiedad (item) {
    var data = new FormData();
    var idpropiedad = '0';

    idpropiedad = item.getAttribute('data-idpropiedad');

    data.append('btnEliminarPropiedad', 'btnEliminarPropiedad');
    data.append('hdIdPropiedad', idpropiedad);

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollPropiedades;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'La propiedad ' + idpropiedad + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' tiene propiedades relacionadas.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollPropiedades = $('#gvPropiedad .listview');
                iScroll = scrollPropiedades.scrollTop();

                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollPropiedades.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemPropiedad(elemsSelected[indexList]);
                    });
                }
                else {
                    MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                        $('#btnClearSelPropiedades').trigger('click');
                    });
                };
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function RomperRelaciones () {
    var data = new FormData();
    var input_data;

    confirma = confirm('¿Desea romper las relaciones de las propiedades seleccionadas?');

    if (confirma){

        input_data = $('#gvPropiedad input:checkbox:checked').serializeArray();

        data.append('btnBreakRelacion', 'btnBreakRelacion');
        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            url: 'services/condominio/condominio-post.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            cache: false,
            contentType:false,
            processData: false,
            success: function (data) {
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    $('#btnClearSelPropiedades').trigger('click');
                    paginaPropiedad = 1;
                    ListarPropiedades('1');
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function RelacionarDepartamento () {
    indexList = 0;
    elemsSelected = $('#gvPropiedad .selected').toArray();
    RelacionarItemDepartamento(elemsSelected[0]);
}

function RelacionarItemDepartamento (item) {
    var data = new FormData();
    var iddepartamento = '0';
    var idpropiedad = '0';

    iddepartamento = $('#gvDepartamento .tile.selected').attr('data-idpropiedad')
    idpropiedad = item.getAttribute('data-idpropiedad');

    data.append('btnRelacionar', 'btnRelacionar');
    data.append('hdIdDepartamento', iddepartamento);
    data.append('hdIdPropiedad', idpropiedad);

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var contenidomsje = '';
            var itemSelected;
            
            itemSelected = $(item);

            if (data.rpta == '0'){
                contenidomsje = 'La propiedad ' + idpropiedad + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' tiene departamentos relacionados.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;

                if (indexList <= elemsSelected.length - 1){
                    RelacionarItemDepartamento(elemsSelected[indexList]);
                }
                else {
                    MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                        $('#btnHideDepartamento').trigger('click');
                        paginaPropiedad = 1;
                        ListarPropiedades('1');
                    });
                };
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function CopiarPropiedades (editmode, inicio, elem, callback) {
    var i = 0;
    var strhtml = '';
    var itemSelected;
    var idpropiedad = '0';
    var idtipopropiedad = '0';
    var area = '0';
    var descripcionpropiedad = '';
    var tipopropiedad = '';
    var countdata = 0;

    i = inicio;
    tipopropiedad = $('#ddlTipoPropiedad').val();
    
    if (editmode == 'NEW'){
        idtipopropiedad = tipopropiedad;
        countdata = parseInt(elem.val()) + 1;
    }
    else if (editmode == 'EDIT'){
        countdata = elem.length;
    };

    if (countdata > 0) {
        while(i < countdata){
            if (editmode == 'NEW'){
                descripcionpropiedad = tipopropiedad + i.toString();
                area = $('#txtAreaPropiedad').val();
            }
            else if (editmode == 'EDIT') {
                idpropiedad = elem[i].getAttribute('data-idpropiedad');
                idtipopropiedad = elem[i].getAttribute('data-idtipopropiedad');
                area = elem[i].getAttribute('data-area');
                descripcionpropiedad = elem[i].getAttribute('data-descripcion');
            };
            
            strhtml += '<div href="#" class="list dato bg-gray-glass" data-idpropiedad="' + idpropiedad + '" data-idtipopropiedad="' + idtipopropiedad + '">';
            strhtml += '<div class="list-content pos-rel">';
            strhtml += '<span class="ubigeotag fg-white bg-darker place-top-right padding5 margin5">Area: ' + area + ' (m<sup>2</sup>)</span>';
            strhtml += '<div class="data">';

            strhtml += '<main style="max-width: 300px;">';

            strhtml += '<div class="row">';
            strhtml += '<div class="input-control text no-margin" data-role="input-control">';
            strhtml += '<input type="text" class="input-descripcion" value="' + descripcionpropiedad + '" />';
            strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
            strhtml += '</div>';
            strhtml += '</div>';

            strhtml += '<div class="row">';
            strhtml += '<label>Saldo Inicial</label>';
            strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
            strhtml += '<input type="text" class="input-saldoinicial" value="0" />';
            strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
            strhtml += '</div>';
            strhtml += '</div>';
            
            if ($('#hdTipoValoracion').val() == '02') {
                strhtml += '<div class="row">';
                strhtml += '<label>Ratio</label>';
                strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
                strhtml += '<input type="text" class="input-ratio" value="0" />';
                strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
                strhtml += '</div>';
                strhtml += '</div>';
            }
            else if ($('#hdTipoValoracion').val() == '03') {
                strhtml += '<div class="row">';
                strhtml += '<label>Importe fijo</label>';
                strhtml += '<div class="input-control text no-margin" data-role="input-control">';            
                strhtml += '<input type="text" class="input-importefijo" value="0" />';
                strhtml += '<button class="btn-clear" tabindex="-1" type="button"></button>';
                strhtml += '</div>';
                strhtml += '</div>';
            };

            strhtml += '</main>';

            strhtml += '<progress class="progress-bar small" data-role="progress-bar" data-value="0"></progress>';
            strhtml += '</div></div>';
            strhtml += '</div>';
            ++i;
        };
    };

    $('#gvPropiedadSelected .items-area').html(strhtml);
    callback();
}

function DetalleConcepto (codigoconcepto, valorconcepto, tiporesultado) {
    this.codigoconcepto = codigoconcepto;
    this.valorconcepto = valorconcepto;
    this.tiporesultado = tiporesultado;
}

function EditMassrPropiedad () {
    if ($('#txtAreaPropiedad').val().trim().length == 0){
        MessageBox('Valores no v&aacute;lidos', 'Area de propiedades deben tener algun valor', "[Aceptar]", function () {
        });
        return false;
    }
    else {
        if (Number($('#txtAreaPropiedad').val()) == 0){
            MessageBox('Valores no v&aacute;lidos', 'Area de propiedades deben ser mayores a cero', "[Aceptar]", function () {
            });
            return false;
        }
    };

    indexList = 0;
    elemsSelected = $('#gvPropiedadSelected .list').toArray();
    EnvioDataEditPropiedad(elemsSelected[0]);
}

function ExtraerDetalleConcepto (tipoconcepto) {
    var i = 0;
    var countdata = 0;
    var codigoconcepto = '';
    var valorconcepto = '';
    var selector = '';
    var itemsConcepto;
    var tableConcepto;
    var listConcepto = [];
    var detalleConcepto = '';

    if (tipoconcepto == '00'){
        selector = '#tableConcepto';
    }
    else {
        selector = '#tableConceptoFormula';
    };

    itemsConcepto = $(selector + ' .ibody table');
    tableConcepto = itemsConcepto[0];

    countdata = tableConcepto.rows.length;

    if (countdata > 0){
        while (i < countdata){
            codigoconcepto = tableConcepto.rows[i].getAttribute('data-idconcepto');
            if (tipoconcepto == '00'){
                valorconcepto = tableConcepto.rows[i].cells[1].childNodes[0].value;
            }
            else {
                valorconcepto = tableConcepto.rows[i].cells[1].childNodes[0].innerText;
            };

            var detalle = new DetalleConcepto(codigoconcepto, valorconcepto, tipoconcepto);
            listConcepto.push(detalle);
            ++i;
        };

        detalleConcepto = JSON.stringify(listConcepto);
    };

    return detalleConcepto;
}

function EnvioDataEditPropiedad (item) {
    var data = new FormData();
    var ratiopropiedad = '0';
    var importefijo = '0';
    var detalleConcepto = '';
    var detalleConceptoFormula = '';

    var idpropiedad = item.getAttribute('data-idpropiedad');
    var idtipopropiedad = item.getAttribute('data-idtipopropiedad');
    var itemSelected = $(item);
    var descripcionpropiedad = itemSelected.find('.input-descripcion').val();
    var saldoinicial = itemSelected.find('.input-saldoinicial').val();
    // var orden =  item.getAttribute('data-orden');

    if ($('#hdTipoValoracion').val() == '02')
        ratiopropiedad = itemSelected.find('.input-ratio').val();
    else if ($('#hdTipoValoracion').val() == '03')
        importefijo = itemSelected.find('.input-importefijo').val();

    //detalleConcepto = ExtraerDetalleConcepto('00');
    //detalleConceptoFormula = ExtraerDetalleConcepto('01');

    var progressBar = itemSelected.find('.progress-bar');
    
    var pbMetro = progressBar.progressbar({
        animate: true
        // color: 'bg-cyan'
    });

    var input_data = $('#modalGenPropiedad :input').serializeArray();

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    data.append('btnPropiedadMasiva', 'btnPropiedadMasiva');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdIdPropiedad', idpropiedad);
    data.append('ddlTipoPropiedad', idtipopropiedad);
    data.append('txtNombrePropiedad', descripcionpropiedad);
    data.append('txtRatioPropiedad', ratiopropiedad);
    data.append('txtImporteFijoPropiedad', importefijo);
    data.append('txtSaldoInicial', saldoinicial);
    // data.append('hdOrden', orden);
    data.append('chkIngresoTorre', $('#chkIngresoTorre')[0].checked == true ? '1' : '0');
    data.append('hdIdTorre', $('#hdIdTorre').val());
    data.append('txtIngresoTorre', $('#txtIngresoTorre').val());
    data.append('txtNroSuministro', $('#txtNroSuministro').val());
    data.append('txtAreaSinTechar', $('#txtAreaSinTechar').val());
    data.append('txtAreaTechada', $('#txtAreaTechada').val());
    data.append('txtAreaPropiedad', $('#txtAreaPropiedad').val());
    //data.append('detalleConcepto', detalleConcepto);
    //data.append('detalleConceptoFormula', detalleConceptoFormula);

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollPropiedades = $('#gvPropiedadSelected .listview');
            var iScroll = scrollPropiedades.scrollTop();

            ++indexList;
            progressError = false;
            
            pbMetro.progressbar('value', 100);
            // pbMetro.progressbar('color', 'bg-green');

            if (intervalProgress.isRunning())
                intervalProgress.stop();

            if (indexList <= elemsSelected.length - 1){
                iScroll = iScroll + (itemSelected.height() + 18);
                
                scrollPropiedades.animate({ scrollTop: iScroll  }, 400, function () {
                    EnvioDataEditPropiedad(elemsSelected[indexList]);
                });
            }
            else {
                completado = true;

                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (data.rpta != '0'){
                        paginaPropiedad = 1;
                        closeCustomModal('#modalGenPropiedad');
                        ListarPropiedades ('1');
                    };
                });
            };
        },
        beforeSend: function () {
            intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        if (intervalProgress.isRunning())
                            intervalProgress.stop();
                        pbMetro.progressbar('value', 100);
                        EnvioDataEditPropiedad(elemsSelected[indexList]);
                    }, 10000);
                };
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

function ListarTorres () {
    $.ajax({
        url: 'services/torre/torre-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            id: $('#hdIdProyecto').val()
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        
        countdata = data.length;
        
        if (countdata > 0){
            while(i < countdata){
                strhtml += '<div data-idtorre="' + data[i].idtorre + '" title="' + data[i].descripciontorre + '" class="panel-info without-foto">';
                strhtml += '<div class="info">';
                strhtml += '<h3 class="descripcion">' + data[i].descripciontorre + '</h3>';
                strhtml += '</div>';
                strhtml += '</div>';
                ++i;
            };
        }
        else {
            strhtml = '<h2>No hay datos.</h2>';
        };

        $('#gvTorre').html(strhtml);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function EvalConcepto () {
    var tableConcepto;
    var tableConceptoFormula;
    var itemsConcepto;
    var itemsFormula;
    var codigoconcepto = '';
    var valor = '';
    var formula = '';
    var i = 0;
    var j = 0;
    var countdata_concepto = 0;
    var countdata_formula = 0;
    var nrodecimales_concepto = 0;
    var nrodecimales_formula = 0;
    var nrocaracteres_formula = '';
    var resultformula;

    itemsConcepto = $('#tableConcepto .ibody table');
    tableConcepto = itemsConcepto[0];

    itemsFormula = $('#tableConceptoFormula .ibody table');
    tableConceptoFormula = itemsFormula[0];

    countdata_concepto = tableConcepto.rows.length;
    countdata_formula = tableConceptoFormula.rows.length;

    if (countdata_formula > 0){
        while (i < countdata_formula) {
            formula = tableConceptoFormula.rows[i].getAttribute('data-formula');
            j = 0;
            nrocaracteres_formula = Number(tableConceptoFormula.rows[i].getAttribute('data-nrocaracteres'));
            nrodecimales_formula = Number(tableConceptoFormula.rows[i].getAttribute('data-nrodecimales'));

            if (countdata_concepto > 0){
                while (j < countdata_concepto){
                    codigoconcepto = tableConcepto.rows[j].getAttribute('data-idconcepto');
                    valor = tableConcepto.rows[j].cells[1].childNodes[0].value;

                    nrodecimales_concepto = Number(tableConcepto.rows[j].getAttribute('data-nrodecimales'));

                    if (tableConcepto.rows[j].getAttribute('data-tipovalor') == '01'){
                        if (nrodecimales_concepto > 0){
                            valor = 'Number(' + Number(valor).toFixed(nrodecimales_concepto) + ')';
                        }
                        else {
                            valor = 'Number(' + valor + ')';
                        };
                    };

                    formula = formula.replace('[' + codigoconcepto + ']', valor);
                    ++j;
                };
            };
            
            try {
                resultformula = eval(formula);
            }
            catch(err){
                console.log(err.message);
            };

            if (tableConceptoFormula.rows[i].getAttribute('data-tipovalor') == '01'){
                if (nrodecimales_formula > 0){
                    resultformula = Number(resultformula).toFixed(nrodecimales_formula);
                };
            }
            else {
                resultformula = resultformula.toString().substring(0, nrocaracteres_formula);
            };

            tableConceptoFormula.rows[i].cells[1].childNodes[0].innerText = resultformula;
            
            ++i;
        };
    };
}

function ListarConceptos (tipo, tipoconcepto, subtipoconcepto, idpropiedad) {
    precargaExp('#modalConcepto .modal-example-body', true);
    //alert(idpropiedad);
    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: tipo,
            tipoconcepto: tipoconcepto,
            subtipoconcepto: subtipoconcepto,
            idproyecto: $('#hdIdProyecto').val(),
            idpropiedad: idpropiedad
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtmlconcepto = '';
        var strhtmlformula = '';
        var defaultvalue = '';
        var maxcaracter = '';
        var nrodecimales = 0;
        var valorconcepto = 0;
        var valor = '';

        countdata = data.length;

        precargaExp('#modalConcepto .modal-example-body', false);
        
        if (countdata > 0){
            while(i < countdata){
                strhtml = '<tr ';
                strhtml += 'data-idconcepto="' + data[i].tm_idconcepto + '" ';
                strhtml += 'data-esformula="' + data[i].tm_esformula + '" ';
                strhtml += 'data-formula="' + data[i].tm_definicion_formula + '" ';
                strhtml += 'data-tipovalor="' + data[i].ta_tipovalor + '" ';
                strhtml += 'data-nrocaracteres="' + data[i].tm_numerocaracteres + '" ';
                strhtml += 'data-nrodecimales="' + data[i].tm_numerodecimales + '">';
                strhtml += '<td class="colConcepto">';
                strhtml += '<h4>' + data[i].tm_idconcepto + ' - ' + data[i].tm_descripcionconcepto + '</h4>';
                strhtml += '</td>';
                strhtml += '<td class="colValor">';

                nrodecimales = Number(data[i].tm_numerodecimales);
                valorconcepto = Number(data[i].td_valorconcepto);

                if (data[i].ta_tipovalor == '00'){
                    defaultvalue = '';
                    maxcaracter = ' maxlength="' + data[i].tm_numerocaracteres + '"';
                }
                else {
                    defaultvalue = '0';
                    maxcaracter = '';
                    if (nrodecimales > 0){
                        defaultvalue += '.' + '0'.repeat(nrodecimales);
                    };
                };

                if (valorconcepto > 0){
                    valor = valorconcepto;
                }
                else {
                    valor = defaultvalue;
                };
                
                if (data[i].tm_esformula == '0'){
                    strhtml += '<input type="text" name="txtValorConcepto[]" class="inputTextInTable" value="' + valor + '"' + maxcaracter + ' />';
                }
                else {
                    strhtml += '<h4>' + valor + '</h4>';
                };

                strhtml += '</td>';
                strhtml += '</tr>';

                if (data[i].tm_esformula == '0'){
                    strhtmlconcepto += strhtml;
                }
                else {
                    strhtmlformula += strhtml;
                };
                ++i;
            }
        };

        $('#tableConcepto tbody').html(strhtmlconcepto);
        $('#tableConceptoFormula tbody').html(strhtmlformula);

        EvalConcepto();
        
        /*unsetArea();
        if (idpropiedad != '0'){
            setArea();
        };*/
    })
    .fail(function(data) {
        console.log(data);
    })
    .always(function() {
        console.log("complete");
    });
}

function GoToPropiedades (_proyecto) {
    // var proyecto = $('#gvDatos .list.selected');
    var proyecto = $(_proyecto);
    var idproyecto = proyecto.attr('data-idproyecto');
    var nombreproyecto = proyecto.attr('data-nombre');
    var tipoproyecto = proyecto.attr('data-tipoproyecto');
    var tipovaloracion = proyecto.attr('data-tipovaloracion');
    var datosimpleduplex = proyecto.attr('data-datosimpleduplex');

    $('#hdTipoValoracion').val(tipovaloracion);
    $('#tituloProyecto').attr('data-hint', nombreproyecto).text(nombreproyecto);
    
    $('#chkIngresoTorre')[0].checked = false;
    $('#rowIngreso').addClass('oculto');

    if (tipoproyecto == '00'){
        $('#rowChkIngreso').removeClass('oculto');
        $('#pnlInfoTorre').removeClass('oculto');
    }
    else {
        $('#rowChkIngreso').addClass('oculto');
        $('#pnlInfoTorre').addClass('oculto');
    };

    if (datosimpleduplex == '1'){
        $('#rowClasePropiedad').removeClass('oculto');
        $('#ddlClasePropiedad')[0].selectedIndex = 0;
    }
    else {
        $('#rowClasePropiedad').addClass('oculto');
        $('#ddlClasePropiedad').val('02');
    };
    
    paginaPropiedad = 1;

    $('#pnlListado').fadeOut(400, function() {
        $('#pnlListPropiedades').fadeIn(400, function() {
            ListarPropiedades('1');
        });
    });
}

function GetLastIndexPropiedad () {
    $.ajax({
        url: 'services/propiedad/propiedad-lastindex.php',
        type: 'GET',
        dataType: 'json',
        data: {
            idtipopropiedad: $('#ddlTipoPropiedad').val(),
            idproyecto: $('#hdIdProyecto').val()
        }
    })
    .done(function(data) {
        $('#txtNroInicial').val(data);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function GuardarDatos () {
    $('#form1').submit();
}

function MostrarModalPorTab () {
    var pestana = "";

    pestana=$('#tabDetalle .tabs li.active').attr('data-tab');
    if (pestana=='Torre') {
       openCustomModal('#modalTorre');   
    }else if (pestana=="Departamento") {
       openCustomModal('#modalDepartamento'); 
    }else if (pestana=="Estacionamiento") {
       openCustomModal('#modalEstacionamiento'); 
    }else if (pestana=="Deposito") {
       openCustomModal('#modalDeposito');    
    }else if (pestana=="AreaComun") {
       openCustomModal('#modalAreaComun');    
    };
}

function setConstructora (idconstructora, nombre) {
    $('#hdIdConstructora').val(idconstructora);

    $('#pnlInfoConstructora').attr('data-idconstructora', idconstructora);
    $('#pnlInfoConstructora .info .descripcion').text(nombre);

    $('#pnlConstructora').fadeOut('400', function() {

    });
}

function setUbigeo (idubigeo, descripcion) {

    $('#pnlInfoUbigeo').attr('data-idubigeo', idubigeo);
    $('#pnlInfoUbigeo .info .descripcion').text(descripcion);

    $('#hdIdLocalidad').val(idubigeo);
    closeCustomModal('#modalUbigeo');
}

function setTorre (idtorre, descripcion) {

    $('#pnlInfoTorre').attr('data-idtorre', idtorre);
    $('#pnlInfoTorre .info .descripcion').text(descripcion);

    $('#hdIdTorre').val(idtorre);
    closeCustomModal('#modalTorre');
}

function setArea () {
    var area = '';
    var txtResultado = $('#tableConceptoFormula tbody tr:last-child .colValor h4');

    area = Number(txtResultado.text()).toFixed(2);
    
    $('#txtAreaPropiedad').val(area);
    $('#pnlInfoArea').attr('data-editado', '1');
    $('#pnlInfoArea .info .descripcion').html('Area: ' + area + ' (m<sup>2</sup>)');
}

function unsetArea () {
    $('#txtAreaPropiedad').val('0.00');
    $('#pnlInfoArea').attr('data-editado', '0');
    $('#pnlInfoArea .info .descripcion').html('Area: 0 (m<sup>2</sup>)');
}

function ListarConstructora () {
    $.ajax({
        url: 'services/constructora/constructora-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'BUSQUEDA',
            tipobusqueda: '1',
            criterio: $('#txtSearchConstructora').val()
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        
        countdata = data.length;
        
        if (countdata > 0) {
            while(i < countdata){
                strhtml += '<div class="tile dato double bg-olive" data-idconstructora="' + data[i].idconstructora + '" data-nombre="' + data[i].nombreconstructora + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].idconstructora + '" />';
                strhtml += '<div class="tile_true_content">';
                strhtml += '<div class="tile-content">';
                strhtml += '<h3 class="text-center fg-white">' + data[i].nombreconstructora + '</h3>';
                strhtml += '</div>';
                strhtml += '</div>';
                strhtml += '</div>';

                ++i;
            };

            $('#gvConstructora .items-area').html(strhtml);
        }
        else {
            $('#gvConstructora .items-area').html('<h2>No se encontraron resultados</h2>');
        };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
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

function GoToEdit (idproyecto) {
    precargaExp('#modalRegistroProyecto', true);
    
    $('#hdIdProyecto').val(idproyecto);
    
    if (idproyecto != '0'){
        $.ajax({
            url: 'services/condominio/condominio-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idproyecto
            },
            success: function (data) {
                var countdata = 0;
                var tipoproyecto = '';
                var datosimpleduplex = false;
                var esporcjduplex = false;
                var logo = '';

                precargaExp('#modalRegistroProyecto', false);
                
                countdata = data.length;

                if (countdata > 0){
                    tipoproyecto = data[0].tipoproyecto;
                    datosimpleduplex = (data[0].datosimpleduplex == '1' ? true : false);
                    esporcjduplex = (data[0].tieneporcjduplex == '1' ? true : false);
                    logo = data[0].logo;
                    
                    $('#hdIdProyecto').val(data[0].idproyecto);
                    $('#ddlTipoProyecto').val(tipoproyecto);
                    $('#ddlTipoValoracion').val(data[0].tipovaloracion);
                    $('#txtCodigoProyecto').val(data[0].codigoproyecto);
                    $('#txtNombreProyecto').val(data[0].nombreproyecto);
                    $('#txtDireccion').val(data[0].direccionproyecto);
                    $('#ddlBanco').val(data[0].idbanco);
                    $('#txtDireccionPago').val(data[0].direccionpago);
                    $('#txtEmailPago').val(data[0].emailpago);
                    $('#chkCobroDiferenciado')[0].checked = (data[0].escobrodiferenciado == '1' ? true : false);
                    $('#chkDatoSimpleDuplex')[0].checked = datosimpleduplex;
                    $('#chkPorcjDuplex')[0].checked = esporcjduplex;

                    ShowAskCobroTorre();

                    MostrarRowPorcentajeDuplex(datosimpleduplex);
                    MostrarPorcjDuplex(esporcjduplex);
                    ListarCuentaBancaria(data[0].idcuentabancaria);
                    
                    if (logo != 'no-set'){
                        $('.droping-air .help').text(logo.substring(logo.lastIndexOf('/') + 1));
                        $('.droping-air').addClass('dropped');
                        $('.droping-air > .icon').css('background', 'url(' + logo + ') no-repeat center');
                        $('.droping-air > .cancel').removeClass('oculto');
                    };
                    
                    $('#hdFoto').val(logo);

                    setConstructora(data[0].idconstructora, data[0].constructora);
                    setUbigeo(data[0].idlocalidad, data[0].ubigeo);

                    $('#txtPorcjDuplex').val(Number(data[0].porcjduplex).toFixed(2));
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
    else {
        precargaExp('#modalRegistroProyecto', false);
    };

    openModalCallBack('#modalRegistroProyecto', function () {
        ListarConceptos('PROYECTO', '04', '0', '0');
    });
}

function ShowPanelConstructora () {
    //$('#noticeConstructora').fadeOut(300);
    $('#pnlConstructora').fadeIn(400, function () {
        ListarConstructora();
    });
}

function ListarDepartamentos (pagina) {
    var selector = '#gvDepartamento .items-area';

    precargaExp('#gvDepartamento', true);

    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdProyecto').val(),
            idtipopropiedad: 'DPT',
            criterio: $('#txtSearchDepartamento').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var colortile = '';
            var iditem = '';
            var idtipopropiedad = '';
            var bgarea = '';
            var nrodoc = '';
            var nombrepropietario = '';
            var textrelaciones = '';
            var cssBgRelacion = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idpropiedad;
                    idtipopropiedad = data[i].idtipopropiedad;
                    
                    if (data[i].numerodoc != null)
                        nrodoc = data[i].numerodoc.trim().length == 0 ? '' : data[i].numerodoc + ' ';

                    if (data[i].descrippersona != null)
                        nombrepropietario = data[i].descrippersona.trim().length == 0 ? '(EN BLANCO)' : data[i].descrippersona;
                    else
                        nombrepropietario = '(EN BLANCO)';
                    
                    if (idtipopropiedad == 'DPT')
                        colortile = 'bg-teal';
                    else if (idtipopropiedad == 'DEP')
                        colortile = 'bg-darkGreen';
                    else if (idtipopropiedad == 'EST')
                        colortile = 'bg-indigo';
                    else if (idtipopropiedad == 'TIE')
                        colortile = 'bg-orange';

                    if (Number(data[i].area) > 0)
                        bgarea = 'bg-dark';
                    else
                        bgarea = 'bg-darkRed';
                    
                    if (data[i].cantidadrelaciones == '0') {
                        textrelaciones = 'SIN PROPIEDADES RELACIONADAS';
                        cssBgRelacion = ' bg-gray';
                    }
                    else {
                        textrelaciones = 'VER PROPIEDADES RELACIONADAS';
                        cssBgRelacion = ' bg-green';
                    };

                    strhtml += '<div class="tile dato double almost-double-vertical bg-gray-glass ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-areasintechar="' + data[i].areasintechar + '" ';
                    strhtml += 'data-areatechada="' + data[i].areatechada + '" ';
                    strhtml += 'data-area="' + data[i].area + '" ';
                    strhtml += 'data-idclasepropiedad="' + data[i].idclasepropiedad + '" ';
                    strhtml += 'data-idpropietario="' + data[i].idpersona + '" ';
                    strhtml += 'data-relaciones="' + data[i].cantidadrelaciones + '" ';
                    strhtml += 'title="' + nrodoc + nombrepropietario + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="fg-dark">' + data[i].descripcionpropiedad + '</h2>';
                    strhtml += '<h6 class="padding5 text-ellipsis smaller bg-white text-center fg-dark">' + nombrepropietario + '</h6>';
                    strhtml += '<h6 class="padding5 smaller bg-white text-center fg-white' + cssBgRelacion + '">' + textrelaciones + '</h6>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand"><span class="badge ' + bgarea + '">Area: ' + data[i].area + ' (m<sup>2</sup>)</span></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                }
                
                paginaPropiedad = paginaPropiedad + 1;

                $('#hdPagePropiedad').val(paginaPropiedad);

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
            
            precargaExp('#gvDepartamento', false);
        }
    });
}

function ListarRelacionadas (idpropiedad, pagina) {
    var selector = '#gvRelaciones .items-area';

    precargaExp('#gvRelaciones', true);

    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'relacionadas',
            idproyecto: $('#hdIdProyecto').val(),
            id: idpropiedad,
            criterio: $('#txtSearchRelacionadas').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var colortile = '';
            var iditem = '';
            var idtipopropiedad = '';
            var bgarea = '';
            var nrodoc = '';
            var nombrepropietario = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idpropiedad;
                    idtipopropiedad = data[i].idtipopropiedad;
                    nrodoc = data[i].numerodoc.trim().length == 0 ? '' : data[i].numerodoc + ' ';
                    nombrepropietario = data[i].descrippersona.trim().length == 0 ? '(EN BLANCO)' : data[i].descrippersona;
                    
                    if (idtipopropiedad == 'DPT')
                        colortile = ' blue-grey lighten-2';
                    else if (idtipopropiedad == 'DEP')
                        colortile = ' grey darken-1';
                    else if (idtipopropiedad == 'EST')
                        colortile = ' blue-grey';
                    else if (idtipopropiedad == 'TIE')
                        colortile = ' blue-grey darken-1';

                    if (Number(data[i].area) > 0) {
                        bgarea = 'bg-dark';
                    }
                    else {
                        bgarea = 'bg-darkRed';
                    };

                    strhtml += '<div class="tile dato double ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-areasintechar="' + data[i].areasintechar + '" ';
                    strhtml += 'data-areatechada="' + data[i].areatechada + '" ';
                    strhtml += 'data-area="' + data[i].area + '" ';
                    strhtml += 'data-idclasepropiedad="' + data[i].idclasepropiedad + '" ';
                    strhtml += 'data-idpropietario="' + data[i].idpersona + '" ';
                    strhtml += 'title="' + nrodoc + nombrepropietario + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="fg-white">' + data[i].descripcionpropiedad + '</h2>';
                    strhtml += '<h6 class="padding5 text-ellipsis smaller bg-white text-center fg-dark">' + nombrepropietario + '</h6>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand"><span class="badge ' + bgarea + '">Area: ' + data[i].area + ' (m<sup>2</sup>)</span></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                }
                
                paginaPropiedad = paginaPropiedad + 1;

                $('#hdPagePropiedad').val(paginaPropiedad);

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
            
            precargaExp('#gvRelaciones', false);
        }
    });
}

function ShowPanelDepartamento () {
    //$('#noticeDepartamento').fadeOut(300);
    $('#pnlDepartamento').fadeIn(400, function () {
        ListarDepartamentos('1');
    });
}

function ShowPanelRelacionadas (idpropiedad) {
    //$('#noticeRelacionadas').fadeOut(300);
    $('#pnlListPropiedades').fadeOut(400, function() {
        $('#pnlRelacionadas').fadeIn(400, function () {
            ListarRelacionadas(idpropiedad, '1');
        });
    });
}

function ShowPanelPropietarioInquilino () {
    //$('#noticeConstructora').fadeOut(300);

    paginaPropietario = 1;
    paginaInquilino = 1;

    $('#pnlPropietarioInquilino').fadeIn(400, function () {
        ListarPropietarios('1');
        ListarInquilinos('1');
    });
}

function FijarProyecto () {
    var idproyecto = '0';
    idproyecto = $('#gvDatos .dato.selected').attr('data-idproyecto');

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        dataType: 'json',
        data: {
            'btnFijarProyecto': 'btnFijarProyecto',
            'hdIdProyecto': idproyecto
        },
        success: function (data) {
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaProyecto = 1;
                    clearOnlyListSelection();
                    ListarProyectos('1');
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnFijarProyecto, #btnEliminar').addClass('oculto');
                };
            });
        },
        error: function () {
            hdIdProyecto
        }
    });
}

function EnvioAdminDatos (form) {
    var data = new FormData();
    var input_data;

    precargaExp('#modalRegistroProyecto', true);

    input_data = $('#modalRegistroProyecto :input').serializeArray();
    detalleConcepto = ExtraerDetalleConcepto('00');
    
    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdIdConstructora', $('#hdIdConstructora').val());
    data.append('hdIdLocalidad', $('#hdIdLocalidad').val());
    data.append('hdFoto', $('#hdFoto').val());
    data.append('archivo', fileValue);

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    data.append('detalleConcepto', detalleConcepto);
    
    $.ajax({
        type: "POST",
        url: "services/condominio/condominio-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            precargaExp('#modalRegistroProyecto', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaProyecto = 1;
                    clearOnlyListSelection();
                    ListarProyectos('1');
                    closeCustomModal('#modalRegistroProyecto');
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnListPropiedades, #btnEditar, #btnFijarProyecto, #btnEliminar').addClass('oculto');
                };
            });
        },
        error:function (data){
            console.log(data);
        }
    });
}
/*
function EliminarPropiedad () {
    var data = new FormData();
    var input_data;

    data.append('btnEliminarPropiedad', 'btnEliminarPropiedad');
    input_data = $('#form1 .listview input:checkbox:checked').serializeArray();

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/condominio/condominio-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaPropiedad = 1;
                    $('#btnClearSelPropiedades').trigger('click');
                    ListarPropiedades('1');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}*/

function GoToEditPropiedad () {
    var propiedad;
    var idpropiedad = '0';
    var idtipopropiedad = '0';
    var nropropiedades = 0;
    var areasintechar = '0';
    var areatechada = '0';
    var area = '0';
    var idclasepropiedad = '';

    propiedad = $('#gvPropiedad .selected');
    nropropiedades = propiedad.length;

    if (nropropiedades > 1){
        $('#rowTipoPropiedad').hide();
        //$('#pnlPropiedadSelected').css('margin-top', '140px');
    }
    else {
        idpropiedad = propiedad[0].getAttribute('data-idpropiedad');
        idtipopropiedad = propiedad[0].getAttribute('data-idtipopropiedad');
        areasintechar = propiedad[0].getAttribute('data-areasintechar');
        areatechada = propiedad[0].getAttribute('data-areatechada');
        area = propiedad[0].getAttribute('data-area');
        idclasepropiedad = propiedad[0].getAttribute('data-idclasepropiedad');

        $('#ddlTipoPropiedad').val(idtipopropiedad);
        $('#txtAreaSinTechar').val(areasintechar);
        $('#txtAreaTechada').val(areatechada);
        $('#txtAreaPropiedad').val(area);
        $('#ddlClasePropiedad').val(idclasepropiedad);

        $('#rowTipoPropiedad').show();
        //$('#pnlPropiedadSelected').css('margin-top', '220px');
    };

    $('#rowRangos').hide();
    //$('#btnPropiedadMasiva').removeClass('oculto');
    //$('#btnGenerarPropiedad').addClass('oculto');
    
    openModalCallBack('#modalGenPropiedad', function () {
        var itemSelected;
    
        itemSelected = $('#gvPropiedad .tile.selected');
        //addValidArea();

        CopiarPropiedades('EDIT', 0, itemSelected, function () {
            /*var idtipopropiedad = '0';
            idtipopropiedad = $('#ddlTipoPropiedad').val();
            
            ListarConceptos('PROPIEDAD', '00', idtipopropiedad, idpropiedad);*/
        });
        /*$('#pnlPropiedadSelected').fadeIn(400, function  () {
        });*/
    });
}

function GenerarVistaPreviaPropiedad () {
    var elem = $('#txtNroFinal');
    var inicio = parseInt($('#txtNroInicial').val());
    
    CopiarPropiedades ('NEW', inicio, elem, function () {
        
    });
}

function ShowAskCobroTorre () {
    if ($('#ddlTipoProyecto').val() == '00'){
        $('#rowCobroDiferenciado').show();
    }
    else {
        $('#rowCobroDiferenciado').hide();
        $('#chkCobroDiferenciado')[0].checked = false;
    };
}

function ListarCuentaBancaria (defaultvalue) {
    $.ajax({
        url: 'services/cuentabancaria/cuentabancaria-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '4',
            id: $('#ddlBanco').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selected = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    selected = (defaultvalue == data[i].tm_idcuentabancaria) ? ' selected="selected"' : '';
                    
                    strhtml += '<option value="' + data[i].tm_idcuentabancaria + '"' + selected + '>' + data[i].tm_descripcioncuenta + '</option>';
                    ++i;
                };
            }
            else {
                strhtml = '<option value="0">No hay cuentas bancarias</option>';
            };

            $('#ddlCuentaBancaria').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function LimpiarProyecto () {
    $('#ddlTipoProyecto')[0].selectedIndex = 0;
    $('#ddlTipoValoracion')[0].selectedIndex = 0;
    $('#txtNombreProyecto').val('');
    $('#txtCodigoProyecto').val('');
    $('#txtDireccion').val('');

    ShowAskCobroTorre();

    $('#rowPorcentajeDuplex').hide();
}

function LimpiarForm () {
    $('#ddlTipoPropiedad')[0].selectedIndex = 0;
    //unsetArea();
    $('#txtAreaTechada').val('0.00');
    $('#txtAreaSinTechar').val('0.00');
    $('#txtAreaPropiedad').val('0.00');
    $('#txtNroInicial').val('0');
    $('#txtNroFinal').val('0');
    $('#txtIngresoTorre').val('');
    $('#txtNroSuministro').val('0');
    $('#gvPropiedadSelected .items-area').html('');
}

function ListarProcesos () {
    // var proyecto;
    var idproyecto = $('#hdIdProyecto').val();

    precargaExp('#tableProceso', true);

    // proyecto = $('#gvDatos .dato.selected');
    // idproyecto = proyecto.attr('data-idproyecto');

    $.ajax({
        url: 'services/proceso/proceso-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'LISTADO',
            tipo: '1',
            id: idproyecto
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var rowpos;

            precargaExp('#tableProceso', false);

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-idproceso="' + data[i].tm_idproceso + '" data-mes="' + data[i].tm_per_mes + '" data-anho="' + data[i].tm_per_ano + '" data-estado="' + data[i].tm_idestadoproceso + '">';
                    strhtml += '<td><h4>' + data[i].tm_per_ano + '</h4></td>';
                    strhtml += '<td><h4>' + arrMeses[parseInt(data[i].tm_per_mes) - 1] + '</h4></td>';
                    strhtml += '<td></td>';
                    strhtml += '<td><button data-action="details" class="btn btn-primary center-block">Ver detalle</button></td>';
                    
                    strhtml += '<td>';

                    if ($('#hdIdPerfil').val() == '61'){
                        if ($('#hdIdProyecto_Sesion').val() == ''){ 
                            strhtml += '<button type="button" data-action="delete" class="btn btn-danger center-block" title="Eliminar proceso"><i class="fa fa-trash"></i></button>';

                            if (data[i].tm_idestadoproceso == '0'){
                                strhtml += '</td><td>';
                                strhtml += '<button type="button" data-action="reopen" class="btn btn-info center-block" title="Reaperturar proceso"><i class="fa fa-repeat"></i></button>';
                            }
                            else
                                strhtml += '</td><td>';
                        }
                        else
                            strhtml += '</td><td>';
                    }
                    else
                        strhtml += '</td><td>';
                    
                    strhtml += '</td>';

                    strhtml += '</tr>';
                    ++i;
                };

                if ($('#tableProceso tbody').html(strhtml).find('tr[data-estado="1"]').length > 0) {
                    $('#btnCerrarProceso').removeClass('oculto');
                    
                    $('#tableProceso tbody').html(strhtml).find('tr[data-estado="1"]:first').trigger('click');
                    rowpos = $('#tableProceso tbody tr[data-estado="1"]').position();
                    $('#tableProceso .ibody-content').animate({ scrollTop: rowpos.top - 50  }, 400, function () {
                    });
                }
                else
                    $('#btnCerrarProceso').addClass('oculto');

            }
            else {
                $('#btnCerrarProceso').addClass('oculto');
                $('#tableProceso tbody').html('');
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GestionarProceso (flag) {
    var data = new FormData();
    var input_data;
    var anho = '0';
    var mes = '0';
    var proceso;
    var idproceso = '0';
    // var proyecto;
    // var idproyecto = '0';

    precargaExp('#tableProceso', true);

    // proyecto = $('#gvDatos .dato.selected');
    var idproyecto = $('#hdIdProyecto').val();

    input_data = $('#modalProceso :input').serializeArray();
    
    if (flag){
        anho = $('#ddlAnhoProceso').val();
        mes = $('#ddlMesProceso').val();
    }
    else {
        proceso = $('#tableProceso tbody tr.selected');
        idproceso = proceso.attr('data-idproceso');
        anho = proceso.attr('data-anho');
        mes = proceso.attr('data-mes');
    };
    
    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdProceso', idproceso);
    data.append('hdIdProyecto', idproyecto);
    data.append('ddlAnho', anho);
    data.append('ddlMes', mes);

    $.ajax({
        url: 'services/proceso/proceso-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            precargaExp('#tableProceso', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    if (flag == false){
                        if ($('#tableProceso tbody').find('tr[data-estado="1"]').length == 0)
                            $('#btnCerrarProceso').addClass('oculto');
                        $('#btnBackToInfoProyecto').trigger('click');
                    };
                    
                    ListarProcesos();
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function DetallePropiedad (idpropiedad, saldoinicial, valor) {
    this.idpropiedad = idpropiedad;
    this.saldoinicial = saldoinicial;
    this.valor = valor;
}

function ActualizarValorFijoMasivo () {
    var data = new FormData();
    var tipovaloracion = $('#hdTipoValoracion').val();
    var valor = $('#txtValorFijo').val();

    precargaExp('#pnlListPropiedades', true);

    tipovaloracion = $('#optSaldoInicial')[0].checked ? '01' : tipovaloracion;

    data.append('btnGuardarValores', 'btnGuardarValores');
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdTipoValoracion', tipovaloracion);
    data.append('txtValorFijo', valor);

    $.ajax({
        url: 'services/propiedad/propiedad-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            precargaExp('#pnlListPropiedades', false);
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    closeCustomModal('#modalGenValorFijo');
                    $('#btnClearSelPropiedades').trigger('click');
                    paginaPropiedad = 1;
                    ListarPropiedades('1');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ActualizarValorPropiedad () {
    var data = new FormData();
    var detallePropiedad = '';
    var valor = 0;
    var listPropiedad = [];
    var tipovaloracion = $('#hdTipoValoracion').val();
    
    precargaExp('#pnlListPropiedades', true);

    $('#gvPropiedad .dato').each(function(index, el) {
        var idpropiedad = el.getAttribute('data-idpropiedad');
        var saldoinicial = $(el).find('.input-saldoinicial').val();
        var ratio = $(el).find('.input-ratio').val();
        var importefijo = $(el).find('.input-importefijo').val();

        if (tipovaloracion == '02')
            valor = ratio;
        else if (tipovaloracion == '03')
            valor = importefijo;

        var detalle = new DetallePropiedad(idpropiedad, saldoinicial, valor);
        listPropiedad.push(detalle);
    });

    detallePropiedad = JSON.stringify(listPropiedad);
    
    data.append('btnSaveValuesPropiedades', 'btnSaveValuesPropiedades');
    data.append('hdTipoValoracion', tipovaloracion);
    data.append('detallePropiedad', detallePropiedad);

    $.ajax({
        url: 'services/propiedad/propiedad-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            precargaExp('#pnlListPropiedades', false);
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    closeCustomModal('#modalGenValorFijo');
                    $('#btnClearSelPropiedades').trigger('click');
                    paginaPropiedad = 1;
                    ListarPropiedades('1');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GuardarLiquidacion () {
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

function ReaperturarProceso (idproceso) {
    var data = new FormData();

    data.append('btnReaperturar', 'btnReaperturar');
    data.append('hdIdProceso', idproceso);

    precargaExp('#tableProceso', true);

    $.ajax({
        url: 'services/proceso/proceso-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            precargaExp('#tableProceso', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0')
                    ListarProcesos();
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function EliminarProceso (idproceso) {
    var data = new FormData();

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdProceso', idproceso);

    precargaExp('#tableProceso', true);

    $.ajax({
        url: 'services/proceso/proceso-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType:false,
        processData: false,
        data: data,
        success: function (data) {
            precargaExp('#tableProceso', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0')
                    ListarProcesos();
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ProyectoPorDefecto () {
    var idproyecto_sesion = $('#hdIdProyecto_Sesion').val();

    if (idproyecto_sesion == '')
        ListarProyectos('1');
    else {
        $.ajax({
            url: 'services/condominio/condominio-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idproyecto_sesion
            },
            success: function (data) {
                var countdata = data.length;

                if (countdata > 0){
                    var proyecto = document.createElement('a');

                    proyecto.setAttribute('data-idproyecto', data[0].idproyecto);
                    proyecto.setAttribute('data-nombre', data[0].nombreproyecto);
                    proyecto.setAttribute('data-tipoproyecto', data[0].tipoproyecto);
                    proyecto.setAttribute('data-tipovaloracion', data[0].tipovaloracion);
                    proyecto.setAttribute('data-datosimpleduplex', data[0].datosimpleduplex);

                    $('#hdIdProyecto').val(data[0].idproyecto);
                    MostrarPropiedades(proyecto);
                };
            },
            error:function (data){
                console.log(data);
            }
        });
    };
}

function MostrarPropiedades (proyecto) {
    $('#pnlInfoGeneralProyecto iframe').remove();
    $('#pnlInfoDetalleProyecto iframe').remove();


    $('#pnlListado').fadeOut(400, function() {
        $('#pnlOpciones').fadeIn(400, function() {
            GoToPropiedades(proyecto);
            $('#myTab .tab-bar li:first-child a').trigger('click');
        });
    });
}

function initEventReorder () {
    $('#gvPropiedad').sortable({
        items: '.dato',
        opacity: 1,
        axis: 'y',
        helper: ayudaArraste,
        forcePlaceholderSize: true,
        sort: function(e, ui) {
            return $("<div style='width:100% !important;'>").html( $(ui).html() ).css({
                border: "1px solid #cccccc",
                textAlign: "center",
                "height": "25px"
            });
        },
        update: function(e, ui) {
            var idpropiedad = $(ui.item).attr('data-idpropiedad');
            var ordenPropiedadAnt = $(ui.item).prev().attr('data-orden');
            
            ordenPropiedadAnt = (ordenPropiedadAnt != null) ? ordenPropiedadAnt : 0;
            
            $("#hdIdPropiedad").val(idpropiedad);
            $("#hdIdOrdenOrgAnt").val(ordenPropiedadAnt);

            saveReorder();
        }
    });
}