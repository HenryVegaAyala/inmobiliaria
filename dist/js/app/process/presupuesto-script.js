$(function () {    
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
        
        paginaPresupuesto = 1;
        ListarPresupuesto('1');
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

    $('#btnProyeccion').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalProyeccion');
    });

    $('#btnProyectarPresupuesto').on('click', function(event) {
        event.preventDefault();
        ProyectarPresupuesto();
    });

    $('#gvDatos > .gridview').on('scroll', function(){
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
        AgregarPresupuesto();
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

            // if (selectorInfo == '#pnlFiltroProyecto') {
            //     setProyecto ('#pnlInfoProyecto', idproyecto, descripcion);
            // };
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
        AgregarPresupuesto();
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
        var confirma = confirm('¿Desea eliminar los elementos seleccionados?');
        if (confirma)
            EliminarPresupuesto();
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
var paginaPresupuesto = 1;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function IniciarForm () {
    // RegistroPorDefecto();
    var idproyecto = getParameterByName('idproyecto');
    $('#hdIdProyecto').val(idproyecto);
    ProyectoById(idproyecto);
}

function LimpiarForm () {
    $('#tableDetalle tbody').html('');
}

function GoToEdit () {
    var recordEdit = $('#gvDatos .dato.selected');
    var idrecord = '0';
    
    precargaExp('#tableDetalle', true);

    document.getElementById('txtImporteTotal').value = '0.00';
    document.getElementById('lblImporteTotal').innerText = '0.00';
    
    if (recordEdit.length > 0){
        idrecord = recordEdit.attr('data-idpresupuesto');

        $.ajax({
            url: 'services/presupuesto/presupuesto-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idrecord
            },
            success: function (data) {
                var i = 0;
                var countdata = 0;
                var strhtml = '';
                
                countdata = data.length;

                if (countdata > 0){
                    $('#hdIdPrimary').val(data[0].tm_idpresupuesto);
                    $('#lblImporteTotal').text(Number(data[0].tm_presupuestototal).toFixed(2));
                    $('#ddlMes').val(data[0].tm_per_mes);
                    
                    setProyecto('#pnlInfoProyecto', data[0].tm_idproyecto, data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].tm_per_mes) - 1] + ' ' + data[0].tm_per_ano);
                    ListarAnhoProceso(data[0].tm_per_ano);
                    ListarDetalle();
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
        url: 'services/presupuesto/presupuesto-search.php',
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
                    strhtml += '<tr data-iddetalle="' + data[i].td_idconceptopresupuesto + '" data-idconcepto="' + data[i].tm_idconcepto + '" data-tiporesultado="' + data[i].ta_tiporesultado + '">';
                    strhtml += '<td>' + data[i].tm_idconcepto + ' - ' + data[i].nombreconcepto + '</td>';
                    strhtml += '<td><input type="text" name="txtCantidad[]" class="cantidad inputTextInTable text-right" value="' + data[i].tm_cantidad + '" /></td>';
                    strhtml += '<td><input type="text" name="txtPrecio[]" class="precio inputTextInTable text-right" value="' + data[i].tm_valor_unitario + '" /></td>';
                    strhtml += '<td class="subtotal">' + data[i].td_valorconcepto + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableDetalle tbody').html(strhtml);
            $('#tableDetalle .ibody table').enableCellNavigation();
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
                setProyecto ('#pnlInfoProyecto', idproyecto, descripcion);
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
            ListarPresupuesto('1');
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
                };

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
            tipoconcepto: '01',
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
                strhtml += '<option value="0">NO HAY PROCESOS RELACIONADOS CON EL PROYECTO SELECCIONADO</option>';
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
    var input_data;
    var detalleRegistro = '';

    input_data = $('#pnlRegistro :input').serializeArray();
    detalleRegistro = ExtraerDetalle();

    data.append('btnGuardar', 'btnGuardar');
    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });
    data.append('detalleRegistro', detalleRegistro);

    $.ajax({
        url: 'services/presupuesto/presupuesto-post.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: data,
        contentType:false,
        processData: false,
        success: function (data) {
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    BackToPrevPanel();
                    paginaPresupuesto = 1;
                    ListarPresupuesto('1');
                    
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar, #btnProyeccion').addClass('oculto');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarPresupuesto (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .card-area';

    precargaExp(selectorgrid, true);

    var idproyecto = document.getElementById('pnlFiltroProyecto').getAttribute('data-idproyecto');
    var criterio = document.getElementById('txtSearch').value;

    $.ajax({
        url: 'services/presupuesto/presupuesto-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: idproyecto,
            criterio: criterio,
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
                    iditem = data[i].tm_idpresupuesto;
                    strhtml += '<div class="card dato bg-cyan heightuno pos-rel" data-idpresupuesto="' + iditem + '" data-nombre="' + data[i].nombreproyecto + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<p><span class="codigo float-left white-text">' + iditem + ' -&nbsp;</span><span class="descripcion float-left white-text">' + data[i].nombreproyecto + '</span></p>';

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
                    strhtml += '<div class="span9 subtotal text-total text-right fg-white no-margin">' + Number(data[i].tm_presupuestototal).toFixed(2) + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                };

                paginaPresupuesto = paginaPresupuesto + 1;
                $('#hdPagePresupuesto').val(paginaPresupuesto);
                
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

function AgregarPresupuesto () {
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

function ProyectarPresupuesto () {
    var data = new FormData();
    var idpresupuesto = '0';
    var nromeses = 0;

    precargaExp('#modalProyeccion', true);

    idpresupuesto = $('#gvDatos .dato.selected')[0].getAttribute('data-idpresupuesto');
    nromeses = document.getElementById('txtNroMeses').value;

    data.append('btnProyectarPresupuesto', 'btnProyectarPresupuesto');
    data.append('hdIdPresupuesto', idpresupuesto);
    data.append('txtNroMeses', nromeses);

    $.ajax({
        url: 'services/presupuesto/presupuesto-post.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: data,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#modalProyeccion', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    paginaPresupuesto = 1;
                    closeCustomModal('#modalProyeccion');
                    ListarPresupuesto('1');
                    
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar, #btnProyeccion').addClass('oculto');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function EliminarPresupuesto () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemPresupuesto(elemsSelected[0]);
}

function EliminarItemPresupuesto (item) {
    var data = new FormData();
    var idpresupuesto = '0';

    idpresupuesto = item.getAttribute('data-idpresupuesto');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPresupuesto', idpresupuesto);

    $.ajax({
        url: 'services/presupuesto/presupuesto-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollPresupuestos;
            var iScroll = 0;
            var contenidomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                contenidomsje = 'El presupuesto ' + idpresupuesto + ': ' + itemSelected.find('.descripcion').text();
                if (data.contenidomsje == 'ERROR-PROYECTO') {
                    contenidomsje += ' tiene proyectos relacionados.';
                };

                MessageBox(data.titulomsje, contenidomsje, "[Aceptar]", function () {
                });
            }
            else {
                ++indexList;
                
                scrollPresupuestos = $('#gvDatos .gridview');
                iScroll = scrollPresupuestos.scrollTop();
                
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (indexList <= elemsSelected.length - 1){
                    iScroll = iScroll + (heightItem + 18);
                    
                    scrollPresupuestos.animate({ scrollTop: iScroll  }, 400, function () {
                        EliminarItemPresupuesto(elemsSelected[indexList]);
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