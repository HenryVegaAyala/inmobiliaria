<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <div class="generic-panel gp-no-header">
        <div class="gp-body">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="gvDatos" class="scrollbarra padding10">
                        <div class="items-area listview gridview">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gp-footer">
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <div class="clear"></div>
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
                    <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtDescripcion" name="txtDescripcion" type="text" placeholder="Ingrese nombre de tipo de documento" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtCodigoSunat"><?php $translate->__('COD SUNAT'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtCodigoSunat" name="txtCodigoSunat" type="text" placeholder="Ingrese c&oacute;digo SUNAT" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Aplicar</button>
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
		$('#gvDatos').on('click', '.dato', function(event) {
            event.preventDefault();
            var checkBox = $(this).find('input:checkbox');

            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvDatos .dato.selected').length == 0){
                    $('#btnNuevo, #btnUploadExcel, #btnSelectAll').removeClass('oculto');
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

        $('#btnGuardar').on('click', function(event) {
            event.preventDefault();
            GuardarDatos();
        });

        $('#btnEliminar').on('click', function () {
            Eliminar();
            return false;
        });

        $('#btnLimpiarSeleccion').on('click', function(event) {
            event.preventDefault();
            limpiarSeleccionados();
            $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
            $('#btnNuevo').removeClass('oculto');
        });

        $('#btnEditar').on('click', function(event) {
            var id = $('.listview a.list.selected').attr('data-id');
            event.preventDefault();
            openModalCallBack('#modalRegistro', function () {
                GetDataById(id);
            });
        });

        $('#btnNuevo').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
            openModalCallBack('#modalRegistro', function () {
                $('#txtDescripcion').focus();
            });
        });

        $("#form1").validate({
            lang: 'es',
            showErrors: showErrorsInValidate,
            submitHandler: EnviarDatos
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
            MostrarDatos();
        });

        addValidForm();
        MostrarDatos();
	});

	function LimpiarForm () {
        $('#hdIdPrimary').val('0');
        $('#txtCodigoSunat').val('');
        $('#txtDescripcion').val('').focus();
    }

    function addValidForm () {
        $('#txtDescripcion').rules('add', {
            required: true,
            maxlength: 50
        });
    }

    function GuardarDatos () {
        $('#form1').submit();
    }

    function limpiarSeleccionados () {
        $('.listview .selected').removeClass('selected');
        $('.listview .list input:checkbox').removeAttr('checked');
    }

	function MostrarDatos () {
        precargaExp('.page-region', true);

        $.ajax({
            url: 'services/banco/banco-search.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                criterio: $('#txtSearch').val()
            }
        })
        .done(function(data) {
            var i = 0;
            var count = data.length;
            var strhtml = '';

            precargaExp('.page-region', false);

            for (i = 0; i < count; i++) {
                strhtml += '<a href="#" class="list dato" data-id="' + data[i].tm_idbanco + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idbanco + '" />';
                strhtml += '<div class="list-content">';
                strhtml += '<div class="data">';
                strhtml += '<h2>' + data[i].tm_nombrebanco + '</h2>';
                strhtml += '</div></div></a>';
            };

            $('.listview').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function EnviarDatos (form) {
        $.ajax({
            type: "POST",
            url: 'services/banco/banco-post.php',
            cache: false,
            data: $(form).serialize() + "&btnGuardar=btnGuardar",
            dataType: 'json',
            success: function(data){
                if (data.rpta != '0'){
                    MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                        limpiarSeleccionados();
                        closeCustomModal('#modalRegistro');
                        MostrarDatos();
                        $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                        $('#btnNuevo').removeClass('oculto');
                    });
                }
            }
        });
    }

    function Eliminar () {
        var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminar=btnEliminar';
        precargaExp('.page-region', true);
        $.ajax({
            type: "POST",
            url: 'services/banco/banco-post.php',
            cache: false,
            data: serializedReturn,
            dataType: 'json',
            success: function(data){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    limpiarSeleccionados();
                    MostrarDatos();
                    $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                    $('#btnNuevo').removeClass('oculto');
                });
            }
        });
    }

    function GetDataById (idData) {
        precargaExp('#modalRegistro', true);

        $.ajax({
            url: 'services/banco/banco-search.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
            	tipobusqueda: '2',
            	id: idData
            }
        })
        .done(function(data) {
            precargaExp('#modalRegistro', false);

            $('#hdIdPrimary').val(data[0].tm_idbanco);
            $('#txtCodigoSunat').val(data[0].tm_codigosunat);
            $('#txtDescripcion').val(data[0].tm_nombrebanco).focus();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
</script>