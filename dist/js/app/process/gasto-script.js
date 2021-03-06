$(function () {
    $('.date-register').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('#ddlTipoDesembolso').on('change', function(event) {
        event.preventDefault();
        // if ($(this).val() == '01') {
        //     $('.datosEfectivo').removeClass('hide');
        //     $('.datosDeposito').addClass('hide');
        // }
        // else {
        //     $('.datosEfectivo').addClass('hide');
        //     $('.datosDeposito').removeClass('hide');
        // };
    });

    $('#ddlTipoAfectacion').on('change', function(event) {
        event.preventDefault();
        if ($(this).val() == '01')
            $('.rowPropietario').addClass('hide');
        else
            $('.rowPropietario').removeClass('hide');
    });

    $("#txtSearchProveedor").easyAutocomplete({
        url: function (phrase) {
            return "services/proveedores/proveedores-search.php?criterio=" + phrase + "&tipobusqueda=1";
        },
        getValue: function (element) {
            return element.nrodocumento +  ' - ' + element.razonproveedor;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchProveedor").getSelectedItemData().idproveedor;

                $("#hdIdProveedor").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.nrodocumento +  ' - ' + item.razonproveedor;
            }
        },
        theme: "square"
    });

    $("#txtSearchConcepto").easyAutocomplete({
        url: function (phrase) {
            return "services/concepto/concepto-search.php?criterio=" + phrase + "&tipobusqueda=4&tipoconcepto=03&idproyecto=" + $('#hdIdProyecto').val();
        },
        getValue: function (element) {
            return element.tm_idconcepto +  ' - ' + element.tm_descripcionconcepto;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchConcepto").getSelectedItemData().tm_idconcepto;

                $("#hdIdConcepto").val(value).trigger("change");
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


    $("#txtSearchPropietario").easyAutocomplete({
        url: function (phrase) {
            return "services/propietario/propietario-search.php?criterio=" + phrase + "&tipobusqueda=1";
        },
        getValue: function (element) {
            return element.tm_numerodoc +  ' - ' + element.descripcion;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchPropietario").getSelectedItemData().tm_idtipopropietario;

                $("#hdIdPropietario").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_numerodoc +  ' - ' + item.descripcion;
            }
        },
        theme: "square"
    });
    
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
        
        paginaGasto = 1;
        ListarGasto('1');
    });

    $('#gvDatos').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var checkBox = $(this).find('input:checkbox');
        
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvDatos .dato.selected').length == 0){
                $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                $('#btnLimpiarSeleccion, #btnProyeccion, #btnEditar, #btnEliminar').addClass('oculto');
            }
            else {
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnLimpiarSeleccion, #btnProyeccion, #btnEditar').removeClass('oculto');
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnNuevo, #btnUploadExcel').addClass('oculto');
            $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
            if ($('#gvDatos .dato.selected').length == 1){
                $('#btnEditar, #btnProyeccion').removeClass('oculto');
            }
            else {
                $('#btnEditar, #btnProyeccion').addClass('oculto');
            };
        };
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $('#hdIdPrimary').val('0');
        $('#gvDatos .dato.selected').removeClass('selected');
        $('#gvDatos input:checkbox:checked').removeAttr('checked');
        $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
        $('#btnLimpiarSeleccion, #btnProyeccion, #btnEditar, #btnEliminar').addClass('oculto');
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        $('#gvDatos .dato').addClass('selected');
        $('#gvDatos input:checkbox').attr('checked', '');
        $('#btnNuevo, #btnProyeccion, #btnUploadExcel, #btnEditar').addClass('oculto');
        $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
    });

    $('#gvDatos > .gridview').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageGasto').val());

            ListarGasto(paginaActual);
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

    $('#pnlInfoProyecto').add('#pnlFiltroProyecto').add('#btnAddDetalle').on('click', function(event) {
        event.preventDefault();
        var panelinfo;
        var tipofiltro = '';
        var titulofiltro = '';
        
        panelinfo = this;
        tipofiltro = panelinfo.getAttribute('data-tipofiltro');
        titulofiltro = panelinfo.getAttribute('data-hint');

        paginaFiltro = 1;
        
        if (tipofiltro == 'proyecto' || tipofiltro == 'filtroproyecto'){
            $('#pnlDatosFiltro').removeClass('with-appbar');
            $('#pnlDatosFiltro .appbar').addClass('oculto');
            ListarProyectos('1');
        }
        else if (tipofiltro == 'concepto'){
            $('#pnlDatosFiltro').addClass('with-appbar');
            $('#pnlDatosFiltro .appbar').removeClass('oculto');
            ListarConcepto('1');
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

    $('#gvFiltro > .gridview').on('scroll', function(){
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
        AgregarGasto();
    });

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
        var tipofiltro = '';

        paginaFiltro = 1;

        tipofiltro = $('#pnlDatosFiltro').attr('data-tipofiltro');
        $('#btnClearFilter').trigger('click');
            
        if (tipofiltro == 'proyecto' || tipofiltro == 'filtroproyecto'){
            ListarProyectos('1');
        }
        else if (tipofiltro == 'concepto') {
            ListarConcepto('1');
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
        var selectorInfo = '';

        pnlDatosFiltro = document.getElementById('pnlDatosFiltro');
        tipofiltro = pnlDatosFiltro.getAttribute('data-tipofiltro');

        if (tipofiltro == 'concepto'){
            checkBox = $(this).find('input:checkbox');
        
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                //$(this).find('.expand-data').slideUp();
                checkBox.removeAttr('checked');
                if ($('#gvFiltro .dato.selected').length == 0){
                    $('#btnClearFilter, #btnAsignFilter').addClass('oculto');
                };
            }
            else {
                $(this).addClass('selected');
                //$(this).find('.expand-data').slideDown();
                checkBox.attr('checked', '');
                $('#btnClearFilter, #btnAsignFilter').removeClass('oculto');
            };
        }
        else {
            iddata = this.getAttribute('data-idproyecto');
            nombre = this.getAttribute('data-nombre');
            selectorInfo = tipofiltro == 'proyecto' ? '#pnlInfoProyecto' : '#pnlFiltroProyecto';
            
            $('#ddlMes').val(this.getAttribute('data-mes'));
            setProyecto(selectorInfo, iddata, nombre);
        };
    });

    $('#tableDetalle tbody').on({
        click: function(event) {
            event.preventDefault();
            $(this).select();
            return false; 
        },
        keyup: function (event) {
            var cantidad = 0;
            var precio = 0;
            var subtotal = 0;

            if ($(this).hasClass('cantidad')){
                cantidad = Number($(this).val());
                precio = Number($(this).parent().parent().find('.precio').val());
            }
            else if ($(this).hasClass('precio')){
                cantidad = Number($(this).parent().parent().find('.cantidad').val());
                precio = Number($(this).val());
            };

            subtotal = cantidad * precio;
            $(this).parent().parent().find('.subtotal').text(subtotal.toFixed(2));

            CalcularTotal();
        }
    }, 'input:text');

    $('#btnAgregar').on('click', function(event) {
        event.preventDefault();
        AgregarGasto();
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        Registrar();
    });

    $('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        LimpiarForm();
        GoToEdit();
    });

    $('#btnEliminar').on('click', function (event) {
        event.preventDefault();
        confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma){
            EliminarGasto();
        };
    });

    $('#btnCancelar').on('click', function(event) {
        event.preventDefault();
        $('#pnlRegistro').fadeOut(400, function() {
            $('#pnlListado').fadeIn(400);
        });
    });
});

var indexList = 0;
var elemsSelected;
var paginaFiltro = 1;
var paginaGasto = 1;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function IniciarForm () {
    var idproyecto = window.top.idproyecto;
    $('#hdIdProyecto').val(idproyecto);
    // ProyectoById(idproyecto);
    // RegistroPorDefecto();
    var today = new Date();
    var yyyy = today.getFullYear();
    
    ListarAnhoProceso(yyyy);
    ListarGasto('1');
}

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#hdIdProveedor').val('0');
    $('#hdIdPropietario').val('0');
    $('#hdIdConcepto').val('0');
    $('#ddlTipoGasto')[0].selectedIndex = 0;
    $('#ddlTipoDesembolso')[0].selectedIndex = 0;
    $('#ddlTipoAfectacion')[0].selectedIndex = 0;
    $('#txtSearchProveedor').val('');
    $('#txtSearchConcepto').val('');
    $('#txtSearchPropietario').val('');
    $('#ddlTipoDocumento')[0].selectedIndex = 0;
    $('#txtSerieDocumento').val('');
    $('#txtNroDocumento').val('');
    $('#txtNroSuministro').val('');
    $('#txtFecha').val($('#txtFecha').attr('data-date-default'));
    $('#ddlAnho')[0].selectedIndex = 0;
    $('#ddlMes')[0].selectedIndex = 0;
    $('#txtImporte').val('0.00');
    $('#txtDescripcion').val('');
    // $('#tableDetalle tbody').html('');
}

function GoToEdit () {
    precargaExp('#tableDetalle', true);

    // document.getElementById('txtImporteTotal').value = '0.00';
    // document.getElementById('lblImporteTotal').innerText = '0.00';
    
    var recordEdit = $('#gvDatos .dato.selected');
    if (recordEdit.length > 0){
        var idrecord = recordEdit.attr('data-idgasto');

        $.ajax({
            url: 'services/gasto/gasto-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipo: 'GETDATA',
                id: idrecord
            },
            success: function (data) {
                var i = 0;
                var countdata = 0;
                var strhtml = '';
                
                countdata = data.length;

                if (countdata > 0){
                    // $('#lblImporteTotal').text(Number(data[0].tm_gastototal).toFixed(2));    
                    
                    $('#hdIdPrimary').val(data[0].idgastoproyecto);

                    $('#hdIdProveedor').val(data[0].idproveedor);
                    $('#hdIdPropietario').val(data[0].idpropietario);
                    $('#hdIdConcepto').val(data[0].idconcepto);

                    $('#hdIdProyecto').val(data[0].idproyecto);
                    $('#ddlTipoGasto').val(data[0].tipogasto);
                    $('#ddlTipoDesembolso').val(data[0].tipodesembolso);
                    $('#txtSearchConcepto').val(data[0].concepto);
                    $('#txtNroSuministro').val(data[0].numerosuministro);
                    $('#txtDescripcion').val(data[0].descripciongasto);
                    $('#ddlMes').val(data[0].per_mes);
                    $('#ddlAnho').val(data[0].per_ano);
                    $('#txtSearchProveedor').val(data[0].proveedor);
                    $('#ddlTipoDocumento').val(data[0].idtipodocumento);
                    $('#txtSerieDocumento').val(data[0].serie_documento);
                    $('#txtNroDocumento').val(data[0].numero_documento);
                    $('#txtFecha').val( convertDate(data[0].fecha_documento) );
                    $('#txtImporte').val(data[0].importe);
                    $('#ddlTipoAfectacion').val(data[0].tipoafectacion).trigger('change');
                    $('#txtSearchPropietario').val(data[0].propietario);
                    $('#ddlAnho').val(data[0].per_ano);
                    $('#ddlMes').val(data[0].per_mes);
                    
                    // setProyecto(data[0].tm_idproyecto, data[0].nombreproyecto);
                    // ListarDetalle();
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };

    precargaExp('#tableDetalle', false);

    $('#pnlListado').fadeOut(500, function () {
        $('#pnlRegistro').fadeIn(500, function () {

        });
    });
}

function ListarDetalle () {
    $.ajax({
        url: 'services/gasto/gasto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'DETALLE',
            tipobusqueda: '1',
            id: $('#hdIdPrimary').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-iddetalle="' + data[i].td_idconceptogasto + '" data-idconcepto="' + data[i].tm_idconcepto + '" data-tiporesultado="' + data[i].ta_tiporesultado + '">';
                    strhtml += '<td>' + data[i].tm_idconcepto + ' - ' + data[i].nombreconcepto + '</td>';
                    strhtml += '<td><input type="text" name="txtCantidad[]" class="cantidad inputTextInTable cantidad text-right" value="' + data[i].tm_cantidad + '" /></td>';
                    strhtml += '<td><input type="text" name="txtPrecio[]" class="precio inputTextInTable precio text-right" value="' + data[i].tm_valor_unitario + '" /></td>';
                    strhtml += '<td class="subtotal">' + data[i].td_valorconcepto + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableDetalle tbody').html(strhtml);
            CalcularTotal();
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
    var strDetalle = '';
    var subtotal = 0;
    var total = 0;

    itemsDetalle = $('#tableDetalle .ibody table');
    tableDetalle = itemsDetalle[0];

    countdata = tableDetalle.rows.length;

    if (countdata > 0){
        while (i < countdata){
            subtotal = Number(tableDetalle.rows[i].cells[3].innerText);
            total += subtotal;
            ++i;
        };
    };

    document.getElementById('txtImporteTotal').value = total.toFixed(2);
    document.getElementById('lblImporteTotal').innerText = total.toFixed(2);
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

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].mesproceso) - 1] + ' ' + data[0].anhoproceso;

                $('#ddlMes').val(data[0].mesproceso);
                // setProyecto ('#pnlInfoProyecto', idproyecto, descripcion);
                setProyecto ('#pnlFiltroProyecto', idproyecto, descripcion);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function setProyecto (selector, idproyecto, nombre) {
    if (selector == '#pnlInfoProyecto'){
        $('#hdIdProyecto').val(idproyecto);
    };

    $(selector).attr('data-idproyecto', idproyecto);
    $(selector + ' .info .descripcion').text(nombre);

    $('#pnlDatosFiltro').fadeOut('400', function() {
        if (selector == '#pnlInfoProyecto'){
            var today = new Date();
            var yyyy = today.getFullYear();
            
            ListarAnhoProceso(yyyy);
        }
        else if (selector == '#pnlFiltroProyecto') {
            ListarGasto('1');
        };
    });
}

function setConcepto (idconcepto, nombre, tiporesultado) {
    $('#hdIdConcepto').val(idconcepto);

    $('#pnlInfoConcepto').attr('data-idconcepto', idconcepto);
    $('#pnlInfoConcepto').attr('data-nombre', nombre);
    $('#pnlInfoConcepto').attr('data-tiporesultado', tiporesultado);
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
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' + data[i].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[i].mesproceso) - 1] + ' ' + data[i].anhoproceso + '" data-mes="' + data[i].mesproceso + '" data-anho="' + data[i].anhoproceso + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[i].mesproceso) - 1] + ' ' + data[i].anhoproceso + '</span></p>';
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
    var selector = selectorgrid + ' .gridview';

    precargaExp(selectorgrid, true);

    $(selector).addClass('card-area').removeClass('items-area').removeClass('listview');

    $.ajax({
        url: 'services/concepto/concepto-search.php',
        type: 'GET',
        dataType: 'json',
        cache: false,
        data: {
            tipobusqueda: '4',
            id: '0',
            idproyecto: $('#hdIdProyecto').val(),
            criterio: $('#txtSearchFiltro').val(),
            tipoconcepto: '03',
            pagina: pagina
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var iditem = '0';
            
            countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    iditem = data[i].tm_idconcepto;
                    strhtml += '<div class="card dato bg-cyan pos-rel" data-idconcepto="' + iditem + '" data-nombre="' + data[i].tm_descripcionconcepto + '" data-formula="' + data[i].tm_definicion_formula + '" data-tiporesultado="' + data[i].ta_tipovalor + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<p class="fg-white"><span class="codigo float-left">' + iditem + ' -&nbsp;</span><span class="descripcion float-left">' + data[i].tm_descripcionconcepto + '</span></p>';

                    /*strhtml += '<div class="expand-data">';
                    strhtml += '<div class="grid fluid pos-rel">';
                    strhtml += '<div class="row">';
                    strhtml += '<div class="span5"><label>Cantidad</label></div>';
                    strhtml += '<div class="span7">';
                    strhtml += '<input type="text" class="cantidad fg-white inputTextInTable only-numbers" value="0.00" />';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="row">';
                    strhtml += '<div class="span5"><label>Precio</label></div>';
                    strhtml += '<div class="span7">';
                    strhtml += '<input type="text" class="precio fg-white inputTextInTable only-numbers" value="0.00" />';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '<div class="badge">';
                    strhtml += '<div class="total-card grid fluid">';
                    strhtml += '<div class="row">';
                    strhtml += '<input name="txtSubTotal" type="text" class="oculto">';
                    strhtml += '<div class="span3 text-total fg-white no-margin">S/.</div>';
                    strhtml += '<div class="span9 subtotal text-total text-right fg-white no-margin">0.00</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    strhtml += '</div>';*/

                    strhtml += '</div>';
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
        },
        error: function (data) {
            console.log(data);
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
                strhtml += '<option value="0">NO HAY PROCESOS RELACIOANDOS CON EL PROYECTO SELECCIONADO</option>';
            };

            $('#ddlAnho').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function DetalleRegistro (iditem, idconcepto, cantidad, precio, subtotal, tiporesultado) {
    this.iditem = iditem;
    this.idconcepto = idconcepto;
    this.cantidad = cantidad;
    this.precio = precio;
    this.subtotal = subtotal;
    this.tiporesultado = tiporesultado;
}

function ExtraerDetalle () {
    var i = 0;
    var countdata = 0;
    var itemsDetalle;
    var tableDetalle;
    var listDetalle = [];
    var strDetalle = '';

    var iditem = '0';
    var idconcepto = '0';
    var cantidad = '0';
    var precio = '0';
    var subtotal = '0';
    var tiporesultado = '';

    itemsDetalle = $('#tableDetalle .ibody table');
    tableDetalle = itemsDetalle[0];

    countdata = tableDetalle.rows.length;

    if (countdata > 0){
        while (i < countdata){
            idconcepto = tableDetalle.rows[i].getAttribute('data-idconcepto');
            tiporesultado = tableDetalle.rows[i].getAttribute('data-tiporesultado');
            cantidad = tableDetalle.rows[i].cells[1].childNodes[0].value;
            precio = tableDetalle.rows[i].cells[2].childNodes[0].value;
            subtotal = tableDetalle.rows[i].cells[3].innerText;

            var detalle = new DetalleRegistro(0, idconcepto, cantidad, precio, subtotal, tiporesultado);
            listDetalle.push(detalle);
            ++i;
        };

        strDetalle = JSON.stringify(listDetalle);
    };

    return strDetalle;
}

function Registrar () {
    var data = new FormData();

    var input_data = $('#pnlRegistro :input').serializeArray();
    // var detalleRegistro = ExtraerDetalle();

    data.append('btnGuardar', 'btnGuardar');
    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    // data.append('detalleRegistro', detalleRegistro);

    $.ajax({
        url: 'services/gasto/gasto-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: data,
        contentType:false,
        processData: false,
        success: function (data) {
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    $('#btnCancelar').trigger('click');
                    
                    paginaGasto = 1;
                    ListarGasto('1');
                    
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarGasto (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .card-area';
    var idproyecto = $('#hdIdProyecto').val();

    precargaExp(selectorgrid, true);

    $.ajax({
        url: 'services/gasto/gasto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: idproyecto,
            criterio: '',
            pagina: pagina
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var iditem = '0';

            countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    iditem = data[i].idgastoproyecto;
                    strhtml += '<div class="card dato bg-cyan heightuno pos-rel" data-idgasto="' + iditem + '" data-nombre="' + data[i].nombreproyecto + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<p class="fg-white"><span class="codigo fg-white float-left">' + iditem + ' -&nbsp;</span><span class="descripcion float-left fg-white">' + data[i].descripcionconcepto + '</span></p>';

                    strhtml += '<div class="expand-data">';
                    strhtml += '<div class="grid fluid pos-rel">';
                    
                    strhtml += '<div class="row">';
                    strhtml += '<label>' + data[i].anho + '</label>';
                    strhtml += '</div>';

                    strhtml += '<div class="row">';
                    strhtml += '<h3 class="fg-white padding5">' + arrMeses[parseInt(data[i].mes) - 1] + '</h3>';
                    strhtml += '</div>';

                    strhtml += '<div class="badge">';
                    strhtml += '<div class="total-card grid fluid">';
                    strhtml += '<div class="row">';
                    strhtml += '<div class="span3 text-total fg-white no-margin">S/.</div>';
                    strhtml += '<div class="span9 subtotal text-total text-right fg-white no-margin">' + Number(data[i].importe).toFixed(2) + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                };

                paginaGasto = paginaGasto + 1;
                $('#hdPageGasto').val(paginaGasto);
                
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
        },
        error: function (data) {
            console.log(data);
        }
    });
    
}

function AgregarGasto () {
    var strhtml = '';
    var i = 0;
    var countdata = 0;
    var items;

    items  = $('#gvFiltro .dato.selected');

    countdata = items.length;

    if (countdata > 0){
        while(i < countdata){
            strhtml = '<tr data-iddetalle="0" data-idconcepto="' + items[i].getAttribute('data-idconcepto') + '" data-tiporesultado="' + items[i].getAttribute('data-tiporesultado') + '">';
            strhtml += '<td>' + items[i].getAttribute('data-idconcepto') + ' - ' + items[i].getAttribute('data-nombre') + '</td>';
            strhtml += '<td><input type="text" class="cantidad inputTextInTable cantidad text-right" value="0.00" /></td>';
            strhtml += '<td><input type="text" class="precio inputTextInTable precio text-right" value="0.00" /></td>';
            strhtml += '<td class="subtotal">0.00</td>';
            strhtml += '</tr>';
            $('#tableDetalle tbody').append(strhtml);
            ++i;
        };
    };

    $('#btnClearFilter').trigger('click');
    $('#pnlDatosFiltro').fadeOut(400, function () {
        
    });

    $('#tableDetalle .ibody table').enableCellNavigation();
}

function EliminarGasto () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemGasto(elemsSelected[0]);
}

function EliminarItemGasto (item) {
    var data = new FormData();
    var idgasto = item.getAttribute('data-idgasto');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdGasto', idgasto);

    $.ajax({
        url: 'services/gasto/gasto-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollGastos;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El presupuesto ' + idgasto + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROYECTO') {
                    contenidomsje += ' tiene proyectos relacionados.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollGastos = $('#gvDatos .gridview');
                iScroll = scrollGastos.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollGastos.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemGasto(elemsSelected[indexList]);
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