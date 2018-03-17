$(function  () {
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
        
        paginaConcepto = 1;
        ListarConcepto('#gvDatos', '1');
    });

    $('#txtSearchConceptoFormula').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchConceptoFormula').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#txtSearchProyecto').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchProyecto').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchProyecto').on('click', function(event) {
        event.preventDefault();
        ListarProyectos('1');
    });

    $('#btnSearchConceptoFormula').on('click', function(event) {
        event.preventDefault();
        
        pageConceptoFormula = 1;
        ListarConcepto('#gvConcepto', '1');
    });

    $('#gvDatos').on('click', '.dato', function(event) {
        event.preventDefault();
        var checkBox = $(this).find('input:checkbox');
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

    $('#panelFormula').on('click', 'button[data-tipovalor!="edicion"]', function(event) {
        event.preventDefault();
        ConstruirFormula(this);
    });

    $('#txtNombreConcepto').on('keyup', function(event) {
        $('#txtTituloConcepto').val(this.value);
    });

    MostrarFormula(false);
    MostrarEscalonable(false);
    MostrarAscensor(false);
    MostrarSaldoAnterior(false);
    MostrarConsumoAgua(false);

    $('#chkAscensor').on('click', function(event) {
        var flag = this.checked;

        MostrarAscensor(flag);
    });

    $('#chkFormula').on('click', function(event) {
        var flag = this.checked;

        MostrarFormula(flag);
    });

    $('#chkEscalonable').on('click', function(event) {
        var flag = this.checked;

        MostrarEscalonable(flag);
    });

    $('#chkSaldoAnterior').on('click', function(event) {
        var flag = this.checked;

        MostrarSaldoAnterior(flag);
    });

    $('#chkConsumoAgua').on('click', function(event) {
        var flag = this.checked;

        MostrarConsumoAgua(flag);
    });

    $('#pnlInfoFormula').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#modalFormula', function () {
            pageConceptoFormula = 1;
            $('#txtSearchConceptoFormula').val('');
            ListarConcepto('#gvConcepto', '1');
        });
    });

    $('#pnlInfoAscensor').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalAscensor');
    });

    $('#pnlInfoEscalonable').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalEscalonable');
    });

    $('#pnlInfoProyecto').add('#pnlFiltroProyecto').on('click', function(event) {
        event.preventDefault();
        ShowPanelProyecto();
    });

    $('#btnHideProyecto').on('click', function(event) {
        event.preventDefault();
        $('#pnlProyecto').fadeOut(400, function() {
            
        });
    });

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

    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        //$('#hdIdPrimary').val('0');
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDatos .dato').addClass('selected');
        $('#gvDatos input:checkbox').attr('checked', '');
        $('#btnNuevo, #btnUploadExcel, #btnEditar').addClass('oculto');
        $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
    });

    $('#gvDatos > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageConcepto').val());

            ListarConcepto('#gvDatos', paginaActual);
        };
    });

    $('#gvConcepto > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageConceptoFormula').val());

            ListarConcepto('#gvConcepto', paginaActual);
        };
    });

    $('#gvConcepto').liveDraggable({
        containment:'document',
        distance: 10,
        helper: 'clone',
        position: 'absolute',
        appendTo: 'body',
        opacity: 0.55,
        zIndex: 10000
    }, 'a');

    $('#gvConcepto').on('dblclick', 'a', function(event) {
        event.preventDefault();
        ConstruirFormula(this);
    });

    $('#ScrFormula').droppable({
        accept: "#gvConcepto a",
        drop: function (event, ui) {
            var item = ui.draggable;
            
            ConstruirFormula(item);
        }
    });

    $('#btnBksp').on('click', function(event) {
        event.preventDefault();
        var elem;
        var idconcepto = '0';
        var formula = '';
        var lastcodconcepto = '';
        
        elem = $('#ScrFormula .item-formula:last-child');
        formula = $('#txtFormula').val();

        if (elem.attr('data-idconcepto') == '0'){
            $('#txtFormula').val(formula.substring(0, formula.length - 1));
        }
        else {
            lastcodconcepto = formula.substring(formula.lastIndexOf('[') + 1, formula.lastIndexOf(']'));
            $('#txtFormula').val(formula.replace('[' + lastcodconcepto + ']', ''));
        };
        
        elem.remove();
    });

    $('#btnAplicarFormula').on('click', function(event) {
        event.preventDefault();
        setFormula('1', $('#txtFormula').val());
        closeCustomModal('#modalFormula');
    });

    $('#btnAplicarEscalonable').on('click', function(event) {
        event.preventDefault();
        setEscalonable('1', 'Valores escalonables ingresados');
        closeCustomModal('#modalEscalonable');
    });

    $('#ddlTipoConcepto').on('change', function(event) {
        event.preventDefault();
        var subtipoconcepto = '0';
        
        if ($(this).val() == '00'){
            subtipoconcepto = 'NA';
        };
        
        ListarSubTipo(subtipoconcepto);
    });

    $('#ddlTipoValor').on('change', function(event) {
        event.preventDefault();
        var texto = '';
        var tipovalor = '';

        tipovalor = $(this).val();
        
        if (tipovalor == '02') {
            $('#campoCaracter').hide(400);
        }
        else {
            if (tipovalor == '00') {
                valor = 'Cantidad de caracteres';
            }
            else if (tipovalor == '01'){
                valor = 'Cantidad de decimales';
            };
            $('#campoCaracter').show(400);
            $('#lblCantidadCaracter').text(valor);
        };
    });

    $('#btnAddRowEscalonable').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('add'))
            AgregarRowEscalonable();
        else
            QuitarRowEscalonable();
    });

    $('#tableEscalonable tbody').on('click', 'tr', function(event) {
        event.preventDefault();
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            if ($('#tableEscalonable tbody tr.selected').length == 0){
                $('#btnAddRowEscalonable').removeClass('remove').addClass('add');
            };
        }
        else {
            $(this).addClass('selected');
            $('#btnAddRowEscalonable').removeClass('add').addClass('remove');
        };
    });

    $('#tableEscalonable tbody').on('click', 'input', function(event) {
        event.preventDefault();
        return false;
    });

    $('#gvProyecto > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageProyecto').val());

            ListarProyectos(paginaActual);
        };
    });

    $('#gvProyecto .items-area').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var idproyecto = '0';
        var nombre = '';

        idproyecto = this.getAttribute('data-idproyecto');
        nombre = this.getAttribute('data-nombre');

        setProyecto(idproyecto, nombre);
    });

    $('#btnEliminar').on('click', function(event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarConcepto();
        };
    });

    $('#ddlTipoConceptoMainFilter').on('change', function(event) {
        event.preventDefault();
        paginaConcepto = 1;
        ListarConcepto('#gvDatos', '1');
    });

    $('#ddlTipoConceptoFormula').on('change', function(event) {
        event.preventDefault();
        pageConceptoFormula = 1;
        ListarConcepto('#gvConcepto', '1');
    });
});

var indexList = 0;
var elemsSelected;
var paginaConcepto = 1;
var pageConceptoFormula = 1;
var paginaProyecto = 1;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function IniciarForm () {
    var idproyecto = getParameterByName('idproyecto');
    $('#hdIdProyecto').val(idproyecto);
    paginaConcepto = 1;
    ListarConcepto('#gvDatos', '1');
    // RegistroPorDefecto();
}

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtNombreConcepto').val('');
    $('#txtTituloConcepto').val('');
    $('#txtFormula').val('');
    //$('#ddlTipoConcepto')[0].selectedIndex = 0;
    $('#ddlTipoConcepto').val($('#ddlTipoConceptoMainFilter').val());
    $('#ddlTipoValor')[0].selectedIndex = 0;
    $('#chkAscensor')[0].checked = false;
    $('#chkFormula')[0].checked = false;
    $('#chkEscalonable')[0].checked = false;
    $('#chkConsumoAgua')[0].checked = false;
    MostrarFormula(false);
    MostrarEscalonable(false);
    MostrarConsumoAgua(false);
    MostrarAscensor(false);
    ListarSubTipo('NA');
    $('#txtCantidadCaracter').val('0');
    setFormula('0', 'Fórmula');
    $('#ScrFormula').html('');
}

function ListarSubTipo (defaultvalue) {
    var codigoreferencia = '';
    var campo = '';
    var tipoconcepto = $('#ddlTipoConcepto').val();

    if ((tipoconcepto == '00') || (tipoconcepto == '03')){
        campo = tipoconcepto == '00' ? 'ta_tipopropiedad' : 'ta_tipogasto';
        codigoreferencia = $('#ddlTipoConcepto').val();
    }
    else {
        campo = '';
        codigoreferencia = '0';
    };

    $.ajax({
        url: 'services/tabla/tabla-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'REFERENCIA',
            campo: campo,
            codigoreferencia: codigoreferencia
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        var selected = '';
        
        countdata = data.length;
        
        if (countdata > 0) {
            while(i < countdata){
                selected = data[i].ta_codigo == defaultvalue ? ' selected="selected"' : '';
                strhtml += '<option' + selected + ' value="' + data[i].ta_codigo + '">' + data[i].ta_denominacion + '</option>';
                ++i;
            }
        }
        else {
            strhtml = '<option value="0">NINGUNO</option>';
        };

        $('#ddlSubTipoConcepto').html(strhtml);
    })
    .fail(function(data) {
        console.log(data);
    })
    .always(function() {
        console.log("complete");
    });
    
}

function ListarConcepto (selectorgrid, pagina) {
    var selector = selectorgrid + ' .items-area';
    var tipobusqueda = '';
    var criterio = '';
    var listaconcepto = $('#hdIdPrimary').val();

    precargaExp(selectorgrid, true);

    if (selectorgrid == '#gvDatos'){
        tipobusqueda = '1';
        criterio = $('#txtSearch').val();
        tipoconcepto = $('#ddlTipoConceptoMainFilter').val();
    }
    else {
        tipobusqueda = '2';
        criterio = $('#txtSearchConceptoFormula').val();
        tipoconcepto = $('#ddlTipoConceptoFormula').val();

        if ($('#ScrFormula .item-formula[data-idconcepto!="0"]').length > 0){
            listaconcepto += ',' + $.map($('#ScrFormula .item-formula[data-idconcepto!="0"]'), function(n, i){
                return n.getAttribute('data-idconcepto');
            }).join(',');
        };
    };

    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            idproyecto: $('#hdIdProyecto').val(),
            id: listaconcepto,
            criterio: criterio,
            tipoconcepto: tipoconcepto,
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
            };

            if (selectorgrid == '#gvDatos'){
                paginaConcepto = paginaConcepto + 1;
                $('#hdPageConcepto').val(paginaConcepto);
            }
            else {
                pageConceptoFormula = pageConceptoFormula + 1;
                $('#hdPageConceptoFormula').val(pageConceptoFormula);

                // if ($('#ScrFormula .item-formula').length > 0) {
                //     $('#pnlDisableConcepto').removeClass('hide');
                // };
            };
            
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

function GoToEdit () {
    //precargaExp('body', true);
    var recordEdit = $('#gvDatos .list.selected');
    var idrecord = '0';
    
    if (recordEdit.length > 0){
        idrecord = recordEdit.attr('data-idconcepto');
        
        $.ajax({
            url: 'services/concepto/concepto-search.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
                tipo: 'ID',
                id: idrecord
            },
            success: function (data) {
                var countdata = 0;
                var nrocaracteres = '0';
                var flagascensor = false;
                var flagformula = false;
                var flagescalonable = false;
                var flagessaldoanterior = false;
                var flagesconsumoagua = false;
                var tipoconcepto = '';
                var subtipoconcepto = '0';
                
                countdata = data.length;

                if (countdata > 0){
                    flagformula = (data[0].tm_esformula == '1' ? true : false);
                    flagascensor = (data[0].tm_ascensor == '1' ? true : false);
                    flagescalonable = (data[0].tm_escalonable == '1' ? true : false);
                    flagessaldoanterior = (data[0].tm_essaldoanterior == '1' ? true : false);
                    flagesconsumoagua = (data[0].tm_esconsumoagua == '1' ? true : false);
                    tipoconcepto = data[0].ta_tipoconcepto;

                    //alert(flagescalonable);
                    
                    //alert(data[0].tm_idconcepto);
                    $('#hdIdPrimary').val(idrecord);
                    $('#ddlTipoConcepto').val(tipoconcepto);
                    $('#chkAscensor')[0].checked = flagascensor;
                    $('#chkFormula')[0].checked = flagformula;
                    $('#chkEscalonable')[0].checked = flagescalonable;
                    $('#chkSaldoAnterior')[0].checked = flagessaldoanterior;
                    $('#chkConsumoAgua')[0].checked = flagesconsumoagua;
                    $('#txtNombreConcepto').val(data[0].tm_descripcionconcepto);
                    $('#txtTituloConcepto').val(data[0].tm_tituloconcepto);
                    $('#ddlTipoValor').val(data[0].ta_tipovalor);
                    
                    setProyecto(data[0].tm_idproyecto, data[0].nombreproyecto);

                    if (data[0].ta_tipovalor == '00') {
                        nrocaracteres = data[0].tm_numerocaracteres;
                    }
                    else {
                        nrocaracteres = data[0].tm_numerodecimales;
                    };
                    
                    MostrarFormula(flagformula);
                    MostrarEscalonable(flagescalonable);
                    MostrarAscensor(flagascensor);
                    MostrarSaldoAnterior(flagessaldoanterior);
                    MostrarConsumoAgua(flagesconsumoagua);

                    $('#txtCantidadCaracter').val(nrocaracteres);

                    if (tipoconcepto == '00'){
                        subtipoconcepto = data[0].ta_subtipoconcepto;
                    };

                    if (flagformula){
                        $('#txtFormula').val(data[0].tm_definicion_formula);
                        setFormula('1', data[0].tm_definicion_formula);
                        $('#ScrFormula').html(data[0].tm_html_formula);
                        // $('#ScrFormula .item-formula[data-idconcepto!="0"]').hint();
                    }
                    else {
                        $('#txtFormula').val('');
                        setFormula('0', 'Fórmula');
                        $('#ScrFormula').html('');
                    };

                    if (flagescalonable)
                        setEscalonable('1', 'Valores escalonables ingresados');
                    else
                        setEscalonable('0', 'Valores escalonables sin ingresar');

                    ListarSubTipo(subtipoconcepto);
                    ListarConceptoEscalonable();
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };

    openCustomModal('#modalRegistroConcepto');
}

function EliminarConcepto () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemConcepto(elemsSelected[0]);
}

function EliminarItemConcepto (item) {
    var data = new FormData();
    var idconcepto = '0';

    idconcepto = item.getAttribute('data-idconcepto');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdConcepto', idconcepto);

    $.ajax({
        url: 'services/concepto/concepto-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollConceptos;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El concepto ' + idconcepto + ': ' + $(item).find('.descripcion').text();
                
                if (data.contenidomsje == 'ERROR-FORMULA') {
                    contenidomsje += ' es parte de una formula.';
                }
                else if (data.contenidomsje == 'ERROR-COBRANZA') {
                    contenidomsje += ' se ha usado en el m&oacute;dulo de cobranza.';
                }
                else if (data.contenidomsje == 'ERROR-FACTURACION') {
                    contenidomsje += ' se ha usado en el m&oacute;dulo de facturaci&oacute;n.';
                }
                else if (data.contenidomsje == 'ERROR-GASTO') {
                    contenidomsje += ' se ha usado en el m&oacute;dulo de registro de gastos.';
                }
                else if (data.contenidomsje == 'ERROR-PRESUPUESTO') {
                    contenidomsje += ' se ha usado en el m&oacute;dulo de presupuesto.';
                }
                else if (data.contenidomsje == 'ERROR-PROPIEDAD') {
                    contenidomsje += ' es un concepto relacionado a alguna propiedad.';
                };

                if (data.contenidomsje == 'ERROR-FACTURACION') {
                    var confirm_eliminar = confirm('El concepto ' + idconcepto + ': ' + $(item).find('.descripcion').text() + ' ya está vinculado con varias facturas ¿Desea eliminarlo de todas formas?');

                    if (confirm_eliminar){
                        
                        var _data = new FormData();
                        
                        _data.append('btnEliminarConFactura', 'btnEliminarConFactura');
                        _data.append('hdIdConcepto', idconcepto);

                        $.ajax({
                            url: 'services/concepto/concepto-post.php',
                            type: 'POST',
                            dataType: 'json',
                            data: _data,
                            cache: false,
                            contentType:false,
                            processData: false,
                            success: function (data) {
                                MessageBox('Concepto ' + $(item).find('.descripcion').text() + ' eliminado', 'La eliminación de este concepto se realizó satisfactoriamente', "[Aceptar]", function () {
                                    itemSelected.fadeOut(400, function() {
                                        $(this).remove();
                                    });
                                });
                            },
                            error:function (data){
                                console.log(data);
                            }
                        });
                    };
                }
                else {
                    MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                    });
                };
            }
            else {
                ++indexList;
                
                scrollConceptos = $('#gvDatos .listview');
                iScroll = scrollConceptos.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollConceptos.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemConcepto(elemsSelected[indexList]);
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

function DetalleEscalonable (indexdetalle, valorinicial, valorfinal, valorescala, textointervalo) {
    this.indexdetalle = indexdetalle;
    this.valorinicial = valorinicial;
    this.valorfinal = valorfinal;
    this.valorescala = valorescala;
    this.textointervalo = textointervalo;
}

function EnvioAdminDatos (form) {
    var input_data;
    var listaParams = '';
    var data = new FormData();
    var countdata = 0;
    var tableEscalonable;
    var itemsDetalle;
    var listaDetalle = [];
    var i = 0;
    var detalleEscalonable = '';
    
    var valorinicial = 0;
    var valorfinal = 0;
    var valorescala = 0;
    var textointervalo = '';

    var scrformula = '';
    var strformula = '';

    input_data = $('#modalRegistroConcepto :input').serializeArray();
    
    listaParams = $.map($('#ScrFormula .item-formula[data-idconcepto!="0"]'), function(n, i){
        return n.getAttribute('data-idconcepto');
    }).join(',');

    itemsDetalle = $('#tableEscalonable .ibody table');
    tableEscalonable = itemsDetalle[0];

    countdata = tableEscalonable.rows.length;

    if (countdata > 0){
        while (i < countdata) {
            valorinicial = tableEscalonable.rows[i].cells[0].childNodes[0].value;
            valorfinal = tableEscalonable.rows[i].cells[1].childNodes[0].value;
            valorescala = tableEscalonable.rows[i].cells[2].childNodes[0].value;
            textointervalo = tableEscalonable.rows[i].cells[3].childNodes[0].value;

            var detalle = new DetalleEscalonable(i, valorinicial, valorfinal, valorescala, textointervalo);
            listaDetalle.push(detalle);
            ++i;
        };
        
        detalleEscalonable = JSON.stringify(listaDetalle);
    };

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdPrimary', $('#hdIdPrimary').val());
    data.append('hdIdProyecto', $('#hdIdProyecto').val())
    data.append('htmlFormula', $('#ScrFormula').html());
    data.append('txtFormula', $('#txtFormula').val());
    data.append('chkItemConcepto', listaParams);
    data.append('detalleEscalonable', detalleEscalonable);

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    
    $.ajax({
        type: "POST",
        url: "services/concepto/concepto-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaConcepto = 1;
                    clearOnlyListSelection();
                    $('#txtSearch').val('');
                    ListarConcepto('#gvDatos', '1');
                    closeCustomModal('#modalRegistroConcepto');
                    $('#hdIdPrimary').val('0');
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

function MostrarFormula (flag) {
    $('#helperFormula').text((flag ? 'SI' : 'NO'));

    if (flag){
        $('#campoEscalonable').hide(400);
        $('#pnlInfoFormula').show(400, function() {
            
        });
    }
    else {
        $('#campoEscalonable').show(400);
        $('#pnlInfoFormula').hide(400, function() {
            
        });
    };
}

function MostrarAscensor (flag) {
    $('#helperAscensor').text((flag ? 'SI' : 'NO'));
}

function MostrarSaldoAnterior (flag) {
    $('#helperSaldoAnterior').text((flag ? 'SI' : 'NO'));
}

function MostrarConsumoAgua (flag) {
    $('#helperConsumoAgua').text((flag ? 'SI' : 'NO'));
}

function MostrarEscalonable (flag) {
    $('#helperEscalonable').text((flag ? 'SI' : 'NO'));

    if (flag){
        $('#pnlInfoEscalonable').show(400, function() {
            
        });
    }
    else {
        $('#pnlInfoEscalonable').hide(400, function() {
            
        });
    };
}

function ConstruirFormula (obj) {
    var objeto;
    var strhtml = '';
    var tipovalor = '';
    var hints = '';
    var valor = '';
    var formula = '';
    var idconcepto = '0';
    var cssmargen = '';

    objeto = $(obj);

    tipovalor = objeto.attr('data-tipovalor');
    if (tipovalor == 'concepto') {
        idconcepto = objeto.attr('data-idconcepto');
        valor = '[' + idconcepto + ']';
        // hints = ' data-hint-position="top" title="' + objeto.find('.descripcion').text() + '"';
        formula = objeto.attr('data-formula');

        // $('#pnlDisableConcepto').removeClass('hide');
    }
    else {
        valor = objeto.text();
        // $('#pnlDisableConcepto').addClass('hide');
    };

    strhtml += $('#ScrFormula').html();

    strhtml += '<div data-idconcepto="' + idconcepto + '" data-formula="' + formula + '"' + hints + ' class="item-formula float-left">';
    strhtml += '<h5 class="fg-white no-margin">';
    strhtml += valor;
    strhtml += '</h5>';
    strhtml += '</div>';

    //alert(strhtml);

    $('#ScrFormula').html(strhtml);
    $('#txtFormula').val($('#txtFormula').val() + valor);

    // $('#ScrFormula .item-formula[data-idconcepto!="0"]').hint();
}

function setFormula (editado, formula) {
    $('#pnlInfoFormula').attr('data-editado', editado);
    $('#pnlInfoFormula .descripcion').text(formula);
}

function setEscalonable (editado, escalonables) {
    $('#pnlInfoEscalonable').attr('data-editado', editado);
    $('#pnlInfoEscalonable .descripcion').text(escalonables);
}

function AgregarRowEscalonable () {
    var strhtml = '';

    strhtml += '<tr>';
    strhtml += '<td><input type="text" name="txtValorInicial[]" class="inputTextInTable valorInicial text-right" value="0" /></td>';
    strhtml += '<td><input type="text" name="txtValorFinal[]" class="inputTextInTable valorFinal text-right" value="0" /></td>';
    strhtml += '<td><input type="text" name="txtValorEscala[]" class="inputTextInTable valorEscala text-right" value="0" /></td>';
    strhtml += '<td><input type="text" name="txtValorIntervaloEnTexto[]" class="inputTextInTable valorIntervaloEnTexto" /></td>';
    strhtml += '</tr>';

    $('#tableEscalonable tbody').append(strhtml);
}

function QuitarRowEscalonable () {
    $('#tableEscalonable tbody tr.selected').fadeOut(400, function() {
        $(this).remove();
    });
    $('#btnAddRowEscalonable').removeClass('remove').addClass('add');
}

function ShowPanelProyecto() {
    $('#pnlProyecto').fadeIn(400, function () {
        paginaProyecto = 1;
        $('#hdPageProyecto').val('1');
        ListarProyectos('1');
    });
}

function RegistroPorDefecto () {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {tipo: 'defecto-sinproceso'},
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

    $('#pnlFiltroProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlFiltroProyecto .info .descripcion').text(nombre);

    $('#pnlInfoProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlInfoProyecto .info .descripcion').text(nombre);

    $('#pnlProyecto').fadeOut('400', function() {
        $('#btnLimpiarSeleccion').trigger('click');
        
        paginaConcepto = 1;
        ListarConcepto('#gvDatos', '1');
    });
}

function ListarProyectos (pagina) {
    var selector = '#gvProyecto .items-area';

    precargaExp('#gvProyecto', true);

    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: 'json',
        data: "tipo=1&criterio=" + $('#txtSearchProyecto').val() + "&pagina=" + pagina,
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
                };

                paginaProyecto = paginaProyecto + 1;

                $('#hdPageProyecto').val(paginaProyecto);
                
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
            
            precargaExp('#gvProyecto', false);
        }
    });
}

function ListarConceptoEscalonable () {
    precargaExp('#tableEscalonable', true);

    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo:'ESCALONABLE',
            tipobusqueda: '1',
            id: $('#hdIdPrimary').val()
        },
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td><input type="text" name="txtValorInicial[]" class="inputTextInTable valorInicial text-right" value="' + data[i].td_valor_inicial + '"/></td>';
                    strhtml += '<td><input type="text" name="txtValorFinal[]" class="inputTextInTable valorFinal text-right" value="' + data[i].td_valor_final + '"/></td>';
                    strhtml += '<td><input type="text" name="txtValorEscala[]" class="inputTextInTable valorEscala text-right" value="' + data[i].td_valorintervalo + '"/></td>';
                    strhtml += '<td><input type="text" name="txtValorIntervaloEnTexto[]" class="inputTextInTable valorIntervaloEnTexto" value="' + data[i].td_textointervalo + '"/></td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableEscalonable .ibody tbody').html(strhtml);
            
            precargaExp('#tableEscalonable', false);
        }
    });
    
}