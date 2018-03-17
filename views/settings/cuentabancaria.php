<?php
include('bussiness/banco.php');
include('bussiness/documentos.php');

$objBanco = new clsBanco();
$objDocIdentidad = new clsDocumentos();

$counterBanco = 0;
$rowBanco = $objBanco->Listar('1', '0', '');
$countRowBanco = count($rowBanco);

$counterDocIdent = 0;
$rowDocIdent = $objDocIdentidad->CodigoTributable('1,6');
$countRowDocIdent = count($rowDocIdent);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0" />
    <div class="generic-panel">
    	<div class="gp-header padding10">
			<div class="row">
                <div class="col-md-6">
	                <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlBancoSearch" name="ddlBancoSearch">
                            <?php
                            for ($counterBanco=0; $counterBanco < $countRowBanco; $counterBanco++):
                            ?>
                            <option value="<?php echo $rowBanco[$counterBanco]['tm_idbanco']; ?>">
                                <?php $translate->__($rowBanco[$counterBanco]['tm_nombrebanco']); ?>
                            </option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
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
            <div class="grid fluid">
                <div class="row">
                	<label for="ddlBancoRegistro">Banco</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlBancoRegistro" name="ddlBancoRegistro">
                            <?php
                            for ($counterBanco=0; $counterBanco < $countRowBanco; $counterBanco++):
                            ?>
                            <option value="<?php echo $rowBanco[$counterBanco]['tm_idbanco']; ?>">
                                <?php $translate->__($rowBanco[$counterBanco]['tm_nombrebanco']); ?>
                            </option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtDescripcion" name="txtDescripcion" type="text" placeholder="Ingrese nombre de tipo de documento" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <h4>Titular</h4>
                <div class="row">
                    <div class="span6">
                        <label for="ddlTipoDoc">Tipo de documento de identidad</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlTipoDoc" name="ddlTipoDoc">
                                <?php
                                for ($counterDocIdent=0; $counterDocIdent < $countRowDocIdent; $counterDocIdent++):
                                ?>
                                <option value="<?php echo $rowDocIdent[$counterDocIdent]['tm_iddocident']; ?>">
                                    <?php $translate->__($rowDocIdent[$counterDocIdent]['tm_descripcion']); ?>
                                </option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="txtNroDoc">Documento de identidad</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtNroDoc" name="txtNroDoc" type="text" maxlength="11" placeholder="<?php $translate->__('Ejemplo: 45035046'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="txtNombreEmpresa">Nombre / Raz&oacute;n social</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombreEmpresa" name="txtNombreEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtEmail">Email</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtEmail" name="txtEmail" type="text" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
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
    <div id="pnlProyecto" class="top-panel inner-page with-panel-search" style="display:none;">
        <h1 class="title-window hide">
            <a href="#" id="btnHideProyecto" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            <?php $translate->__('Proyecto'); ?>
        </h1>
        <div class="panel-search">
            <div class="input-control text" data-role="input-control">
                <input type="text" id="txtSearchProyecto" name="txtSearchProyecto" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                <button id="btnSearchProyecto" type="button" class="btn-search" tabindex="-1"></button>
            </div>
        </div>
        <div id="precargaCli" class="divload">
            <div id="gvProyecto" class="scrollbarra">
                <div class="items-area listview gridview"></div>
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
        MostrarDatos ();

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
            event.preventDefault();
            var id = $('.listview a.list.selected').attr('data-id');
            
            openModalCallBack('#modalRegistro', function () {
                GetDataById(id);
            });
        });

        $('#btnNuevo').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
            openModalCallBack('#modalRegistro', function () {
                $('#txtDescripcion').val('').focus();
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

        $('#ddlBancoSearch').on('change', function(event) {
        	event.preventDefault();
        	MostrarDatos();
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
        
        addValidForm();
        //RegistroPorDefecto();
	});

	function LimpiarForm () {
        $('#hdIdPrimary').val('0');
        $('#ddlBancoRegistro').val($('#ddlBancoSearch').val());
        $('#ddlTipoDoc')[0].selectedIndex = 0;
        $('#txtNroDoc').val('');
        $('#txtNombreEmpresa').val('');
        $('#txtEmail').val('');
        setProyecto('0', 'Proyecto');
    }

    function addValidForm () {
        $('#txtDescripcion').rules('add', {
            required: true
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
            url: 'services/cuentabancaria/cuentabancaria-search.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
            	tipobusqueda: '4',
                criterio: $('#txtSearch').val(),
            	id: $('#ddlBancoSearch').val()
            },
            success: function (data) {
                var i = 0;
                var count = data.length;
                var strhtml = '';

                precargaExp('.page-region', false);

                for (i = 0; i < count; i++) {
                    strhtml += '<a href="#" class="list dato" data-id="' + data[i].tm_idcuentabancaria + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idcuentabancaria + '" />';
                    strhtml += '<div class="list-content">';
                    strhtml += '<div class="data">';
                    strhtml += '<h2>' + data[i].tm_descripcioncuenta + ' - ' + data[i].descripcionproyecto + '</h2>';
                    strhtml += '</div></div></a>';
                };

                $('.listview').html(strhtml);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function EnviarDatos (form) {
        $.ajax({
            type: "POST",
            url: 'services/cuentabancaria/cuentabancaria-post.php',
            cache: false,
            data: $(form).serialize() + "&btnGuardar=btnGuardar",
            dataType: 'json',
            success: function(data){
                if (data.rpta != '0'){
                    MessageBox('Datos guardados', 'La operaci&oacute;n se complet&oacute; correctamente.', "['Aceptar']", function () {
                        limpiarSeleccionados();
                        closeCustomModal('#modalRegistro');
                        $('#ddlBancoSearch').val($('#ddlBancoRegistro').val());
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
            url: 'services/cuentabancaria/cuentabancaria-post.php',
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
            url: 'services/cuentabancaria/cuentabancaria-search.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
            	tipobusqueda: '2',
            	id: idData
            }
        })
        .done(function(data) {
            precargaExp('#modalRegistro', false);

            $('#hdIdPrimary').val(data[0].tm_idcuentabancaria);
            $('#ddlBancoRegistro').val(data[0].tm_idbanco);
            $('#ddlTipoDoc').val(data[0].tm_iddocident);
            $('#txtNroDoc').val(data[0].tm_nrodoc);
            $('#txtNombreEmpresa').val(data[0].tm_razonsocial);
            $('#txtEmail').val(data[0].tm_email);
            $('#txtDescripcion').val(data[0].tm_descripcioncuenta).focus();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
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
            MostrarDatos();
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
</script>