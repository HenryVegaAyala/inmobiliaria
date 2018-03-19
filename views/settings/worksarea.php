<?php
include('bussiness/areas.php');
include('bussiness/cargos.php');

$objArea = new clsArea();
$objCargo = new clsCargo();

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';
$strListDelete = '';
$strListValids = '';

$validItems = false;
$arrayValid = array();
$arrayDelete = array();

if ($_POST){
    if (isset($_POST['btnGuardar'])){
        $hdTipoData = $_POST['hdTipoData'];
        $hdIdPrimary = $_POST['hdIdPrimary'];
        $txtNombre = $_POST['txtNombre'];
        $chkDespacho = isset($_POST['chkDespacho']) ? 1 : 0;
        
        if ($hdTipoData == '00')
            $rpta = $objArea->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, 0, $txtNombre, $chkDespacho, $idusuario);
        else
            $rpta = $objCargo->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombre, $idusuario);
        
        $jsondata = array("rpta" => $rpta);
    }
    elseif ($_POST['btnEliminar']) {
        $hdTipoData = $_POST['hdTipoData'];
        $strListItems = $_POST['listIds'];

        if ($hdTipoData == '00')
            $rpta = $objArea->MultiDelete($strListItems);
        else
            $rpta = $objCargo->MultiDelete($strListItems);
        
        /*$rsValidItems = $objCargo->Listar('VALID-VENTAS', $strListItems);
        $countValidItems = count($rsValidItems);
        
        if ($countValidItems > 0) {
            for ($counterValidItems=0; $counterValidItems < $countValidItems; ++$counterValidItems)
                array_push($arrayValid, $rsValidItems[$counterValidItems]['tm_idformapago']);
            $arrayDelete = array_diff($chkItem, $arrayValid);
            if (!empty($arrayDelete))
                $strListItems = implode(',', $arrayDelete);
            else
                $strListItems = '';
        }
        if ($countCheckItems > $countValidItems)*/
        
        if (!empty($arrayValid))
            $strListValids = implode(',', $arrayValid);
        $jsondata = array('rpta' => $rpta, 'items_valid' => $strListValids);
    }
    
    echo json_encode($jsondata);
    exit(0);
}
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdTipoData" name="hdTipoData" value="00">
    <div class="page-region without-appbar">
        <div id="pnlConfigWorks" class="sectionInception">
            <div class="sectionHeader">
                <button class="large success no-margin" type="button" data-target="#tab1" data-tipodata="00"><?php $translate->__('Areas'); ?></button>
                <button class="large" type="button" data-target="#tab2" data-tipodata="01"><?php $translate->__('Cargos'); ?></button>
            </div>
            <div class="sectionContent">
                <section id="tab1">
                    <div id="pnlArea" class="inner-page with-panel-search">
                        <div class="panel-search">
                            <div class="input-control text" data-role="input-control">
                                <input type="text" id="txtSearch" name="txtSearch" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearchProducts" type="button" class="btn-search" tabindex="-1"></button>
                            </div>
                        </div>
                        <div class="divload">
                            <div id="gvArea">
                                <div class="listview fluid scrollbarra"></div>
                            </div>
                        </div>
                        <div class="appbar">
                            <button id="btnEliminarArea" name="btnEliminarArea" type="button" class="cancel metro_button oculto float-right">
                                <h2><i class="icon-remove"></i></h2>
                            </button>
                            <button id="btnEditarArea" type="button" class="metro_button oculto float-right">
                                <h2><i class="icon-pencil"></i></h2>
                            </button>
                            <button id="btnNuevoArea" type="button" class="metro_button float-right">
                                <h2><i class="icon-plus-2"></i></h2>
                            </button>
                            <button id="btnLimpiarSeleccionArea" type="button" class="metro_button oculto float-left">
                                <h2><i class="icon-undo"></i></h2>
                            </button>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
                <section id="tab2">
                    <div id="pnlCargo" class="inner-page with-panel-search">
                        <div class="panel-search">
                            <div class="input-control text" data-role="input-control">
                                <input type="text" id="txtSearch" name="txtSearch" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearchProducts" type="button" class="btn-search" tabindex="-1"></button>
                            </div>
                        </div>
                        <div class="divload">
                            <div id="gvCargo">
                                <div class="listview fluid scrollbarra"></div>
                            </div>
                        </div>
                        <div class="appbar">
                            <button id="btnEliminarCargo" name="btnEliminarCargo" type="button" class="cancel metro_button oculto float-right">
                                <h2><i class="icon-remove"></i></h2>
                            </button>
                            <button id="btnEditarCargo" type="button" class="metro_button oculto float-right">
                                <h2><i class="icon-pencil"></i></h2>
                            </button>
                            <button id="btnNuevoCargo" type="button" class="metro_button float-right">
                                <h2><i class="icon-plus-2"></i></h2>
                            </button>
                            <button id="btnLimpiarSeleccionCargo" type="button" class="metro_button oculto float-left">
                                <h2><i class="icon-undo"></i></h2>
                            </button>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="modalRegistro" class="modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNombre"><?php $translate->__('Nombre'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div id="rowDespacho" class="row">
                    <label for="chkDespacho"><?php $translate->__('Despacho'); ?></label>
                    <div class="input-control switch margin10" data-role="input-control">
                        <label>
                            <span id="helperDespacho">NO</span>
                            <input id="chkDespacho" name="chkDespacho" type="checkbox">
                            <span class="check"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiar" type="button" class="command-button mode-add default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>
<script>
    $(function () {
        $('#btnGuardar').on('click', function(event) {
            event.preventDefault();
            GuardarDatos();
        });

        $('#btnLimpiar').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
        });

        $('#pnlConfigWorks .sectionHeader').on('click', 'button', function(event) {
            var TipoData = $(this).attr('data-tipodata');
            var targetId = $(this).attr('data-target');

            $(this).siblings('.success').removeClass('success');
            $(this).addClass('success');

            $('#hdTipoData').val(TipoData);
            $('#pnlConfigWorks .sectionContent > section').hide();
            $(targetId).show();
        });

        $('#btnLimpiarSeleccionArea').add('#btnLimpiarSeleccionCargo').on('click', function(event) {
            event.preventDefault();
            limpiarSeleccionados();
        });

        $('#btnEditarArea').add('#btnEditarCargo').on('click', function(event) {
            var elem;
            var targetId = '';
            var TipoData = '';
            var id = '0';
            
            event.preventDefault();
            
            elem = $('#pnlConfigWorks .sectionHeader button.success');
            targetId = elem.attr('data-target');

            id = $(targetId + ' a.list.selected').attr('data-id');
            
            LimpiarForm();
            openCustomModal('#modalRegistro');
            GetDataById(id);
        });

        $('#btnEliminarArea').add('#btnEliminarCargo').on('click', function(event) {
            event.preventDefault();
            Eliminar();
        });

        $('#btnNuevoArea').add('#btnNuevoCargo').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
            openCustomModal('#modalRegistro');
        });

        $('#chkDespacho').click(function () {
            $('#helperDespacho').text(($(this)[0].checked) ? 'SI' : 'NO');
            if ($(this)[0].checked)
                $(this).attr('checked', '');
            else
                $(this).removeAttr('checked');
        });

        $('#gvArea').on('click', '.dato', function(event) {
            var checkBox = $(this).find('input:checkbox');
            event.preventDefault();
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvArea .dato.selected').length == 0){
                    $('#btnNuevoArea').removeClass('oculto');
                    $('#btnLimpiarSeleccionArea, #btnEditarArea, #btnEliminarArea').addClass('oculto');
                }
                else {
                    if ($('#gvArea .dato.selected').length == 1){
                        $('#btnLimpiarSeleccionArea, #btnEditarArea').removeClass('oculto');
                    }
                }
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevoArea').addClass('oculto');
                $('#btnLimpiarSeleccionArea, #btnEliminarArea').removeClass('oculto');
                if ($('#gvArea .dato.selected').length == 1){
                    $('#btnEditarArea').removeClass('oculto');
                }
                else {
                    $('#btnEditarArea').addClass('oculto');
                }
            }
        });

        $('#gvCargo').on('click', '.dato', function(event) {
            var checkBox = $(this).find('input:checkbox');
            event.preventDefault();
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvCargo .dato.selected').length == 0){
                    $('#btnNuevoCargo').removeClass('oculto');
                    $('#btnLimpiarSeleccionCargo, #btnEditarCargo, #btnEliminarCargo').addClass('oculto');
                }
                else {
                    if ($('#gvCargo .dato.selected').length == 1){
                        $('#btnLimpiarSeleccionCargo, #btnEditarCargo').removeClass('oculto');
                    }
                }
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevoCargo').addClass('oculto');
                $('#btnLimpiarSeleccionCargo, #btnEliminarCargo').removeClass('oculto');
                if ($('#gvCargo .dato.selected').length == 1){
                    $('#btnEditarCargo').removeClass('oculto');
                }
                else {
                    $('#btnEditarCargo').addClass('oculto');
                }
            }
        });

        $("#form1").validate({
            lang: 'es',
            showErrors: showErrorsInValidate,
            submitHandler: EnviarDatos
        });

        addValidForm();
        MostrarAreas();
        MostrarCargos();
    });

    function EnviarDatos (form) {
        $.ajax({
            type: "POST",
            url: '?pag=<?php echo $pag; ?>&subpag=<?php echo $subpag; ?>',
            cache: false,
            data: $(form).serialize() + "&btnGuardar=btnGuardar",
            success: function(data){
                datos = eval( "(" + data + ")" );
                if (Number(datos.rpta) > 0){
                    MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                        var TipoData = '';

                        TipoData = $('#pnlConfigWorks .sectionHeader button.success').attr('data-tipodata');
                        
                        limpiarSeleccionados();
                        resetForm('form1');
                        closeCustomModal('#modalRegistro');

                        if (TipoData == '00')
                            MostrarAreas();
                        else
                            MostrarCargos();
                    });
                }
            }
        });
    }

    function Eliminar () {
        var elem;
        var buttonelem;
        var targetId = '';
        var TipoData = '';
        var listIds = '';

        buttonelem = $('#pnlConfigWorks .sectionHeader button.success');

        targetId = buttonelem.attr('data-target');
        TipoData = buttonelem.attr('data-tipodata');

        elem = $(targetId + ' a.selected');
        listIds =  $.map(elem, function(n, i) {
            return n.getAttribute('data-id');
        });

        var serializedReturn = 'fnPost=fnPost&hdTipoData=' + TipoData + '&listIds=' + listIds + '&btnEliminar=btnEliminar';
       
       precargaExp('.page-region', true);
        $.ajax({
            type: "POST",
            url: '?pag=<?php echo $pag; ?>&subpag=<?php echo $subpag; ?>',
            cache: false,
            data: serializedReturn,
            success: function(data){
                var titleMensaje = '';
                var contentMensaje = '';
                var datos = eval( "(" + data + ")" );
                var validItems = datos.items_valid;
                var countValidItems = validItems.length;
                precargaExp('.page-region', false);
                if (Number(datos.rpta) > 0){
                    if (countValidItems > 0){
                        titleMensaje = '<?php $translate->__('Items eliminados correctamente'); ?>';
                        contentMensaje = '<?php $translate->__('Algunos items no se eliminaron. Click en "Aceptar" para ver detalle.'); ?>';
                    }
                    else {
                        titleMensaje = '<?php $translate->__('Items eliminados correctamente'); ?>';
                        contentMensaje = '<?php $translate->__('La operaci&oacute;n ha sido completada'); ?>';    
                    }
                }
                else {
                    titleMensaje = '<?php $translate->__('No se pudo eliminar'); ?>';
                    contentMensaje = '<?php $translate->__('La operaci&oacute;n no pudo completarse'); ?>';
                }
                MessageBox(titleMensaje, contentMensaje, "[<?php $translate->__('Aceptar'); ?>]", function () {
                    var arrayValid = validItems.split(',');
                    var dataSelected = $(targetId + ' .listview .list.selected');
                    var countDataSelected = dataSelected.length;
                    var i = 0;
                    var idItem = 0;
                    var $Notif = '';

                    if (countValidItems > 0){
                        $('.error-list').html('');
                        while(i < countDataSelected){
                            idItem = dataSelected[i].getAttribute('rel');
                            if (arrayValid.indexOf( idItem )>=0){
                                $Notif += '<div class="notification warning">';
                                $Notif += '<aside><i class="fa fa-warning"></i></aside>';
                                $Notif += '<main><p><strong>Error en item con ID: ' + $(dataSelected[i]).find('.list-status span.label').text() + '</strong>';
                                $Notif += 'El item no pudo ser eliminado por tener referencia con otras operaciones realizadas.</p></main>';
                                $Notif += '</div>';
                            }
                            else {
                                $(dataSelected[i]).fadeOut(400, function () {
                                    $(this).remove();
                                });
                            }
                            ++i;
                        }
                        $('.error-list').html($Notif);
                        $('#modalItemsError').show();
                        $.fn.custombox({
                            url: '#modalItemsError',
                            effect: 'slit'
                        });
                    }
                    else {
                        if (datos.rpta > 0){
                           dataSelected.fadeOut(400, function () {
                                $(this).remove();
                            }); 
                        }
                    }
                });
            }
        });
    }

    function LimpiarForm () {
        var elem;
        var TipoData = '';
        
        event.preventDefault();
        
        elem = $('#pnlConfigWorks .sectionHeader button.success');
        TipoData = elem.attr('data-tipodata');
        
        if (TipoData == '00')
            $('#rowDespacho').removeClass('oculto');
        else
            $('#rowDespacho').addClass('oculto');

        $('#hdIdPrimary').val('0');
        $('#chkDespacho')[0].checked = false;
        $('#helperDespacho').text('NO');
        $('#txtNombre').val('').focus();
    }

    function addValidForm () {
        $('#txtNombre').rules('add', {
            required: true,
            maxlength: 150
        });
    }

    function GuardarDatos () {
        $('#form1').submit();
    }

    function limpiarSeleccionados () {
        var targetId = '';
        var TipoData = '';
        var elem;

        elem = $('#pnlConfigWorks .sectionHeader button.success');
        targetId = elem.attr('data-target');
        TipoData = elem.attr('data-target');

        $(targetId + ' .listview .selected').removeClass('selected');
        $(targetId + ' .listview .list input:checkbox').removeAttr('checked');

        if (TipoData == '00'){
            $('#btnEditarArea, #btnEliminarArea, #btnLimpiarSeleccionArea').addClass('oculto');
            $('#btnNuevoArea').removeClass('oculto');
        }
        else {
            $('#btnEditarCargo, #btnEliminarCargo, #btnLimpiarSeleccionCargo').addClass('oculto');
            $('#btnNuevoCargo').removeClass('oculto');
        }
    }

    function GetDataById (idData) {
        var TipoData = '';
        var url = '';
        var idregistro = '0';
        var nomregistro = '';

        TipoData = $('#pnlConfigWorks .sectionHeader button.success').attr('data-tipodata');

        if (TipoData == '00')
            url = 'services/areas/areas-search.php';
        else
            url = 'services/cargos/cargos-search.php';

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idData
            }
        })
        .done(function(data) {
            var countdata = 0;
            var tienedespacho = false;
            
            countdata = data.length;

            if (countdata > 0){
                if (TipoData == '00'){
                    idregistro = data[0].tp_idarea;
                    tienedespacho = (data[0].tp_esdespacho == 1 ? true : false);   
                    
                    $('#chkDespacho')[0].checked = tienedespacho;
                    $('#helperDespacho').text((tienedespacho == true ? 'SI' : 'NO')); 
                }
                else
                    idregistro = data[0].tp_idcargo;
                
                nomregistro = data[0].tp_nombre;

                $('#hdIdPrimary').val(idregistro);
                $('#txtNombre').val(nomregistro);
            };
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function MostrarAreas () {
        $.ajax({
            url: 'services/areas/areas-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '1',
                criterio: ''
            }
        })
        .done(function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<a href="#" class="list dato" data-id="' + data[i].tp_idarea + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tp_idarea + '" />';
                    strhtml += '<div class="list-content">';
                    strhtml += '<div class="data">';
                    strhtml += '<h2>' + data[i].tp_nombre + '</h2>';
                    strhtml += '</div></div></a>';
                    ++i;
                }
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';

            $('#gvArea .listview').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function MostrarCargos () {
        $.ajax({
            url: 'services/cargos/cargos-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '1',
                criterio: ''
            }
        })
        .done(function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<a href="#" class="list dato" data-id="' + data[i].tp_idcargo + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tp_idcargo + '" />';
                    strhtml += '<div class="list-content">';
                    strhtml += '<div class="data">';
                    strhtml += '<h2>' + data[i].tp_nombre + '</h2>';
                    strhtml += '</div></div></a>';
                    ++i;
                }
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';

            $('#gvCargo .listview').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
</script>