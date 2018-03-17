<?php
include('bussiness/tabla.php');
include('bussiness/documentos.php');
include('bussiness/servicios.php');

$objTabla = new clsTabla();
$objDocIdentidad = new clsDocumentos();
$objServicio = new clsServicio();
$counterServicio = 0;
$counterDocIdentJur = 0;
$counterTipoConstructora = 0;
$rowTipoConstructora = $objTabla->ValorPorCampo('ta_tipoconstructora');
$countRowTipoConstructora = count($rowTipoConstructora);
$rowDocIdentJur = $objDocIdentidad->CodigoTributable('6');
$countRowDocIdentJur = count($rowDocIdentJur);
$rowServicio = $objServicio->Listar('1', '0', '');
$countRowServicio = count($rowServicio);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageConstructora" name="hdPageConstructora" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdIdPropietario" name="hdIdPropietario" value="0">
    <input type="hidden" id="hdIdLocalidad" name="hdIdLocalidad" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page with-panel-search with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Empresas inmobiliarias
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="scrollbarra">
                    <div class="items-area listview gridview">
                    </div>
                </div>
            </div>
            <div class="appbar">
                <div class="appbar">
                    <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right">
                        <h2><i class="icon-remove"></i></h2>
                    </button>
                    <button id="btnEditar" type="button" class="metro_button oculto float-right">
                        <h2><i class="icon-pencil"></i></h2>
                    </button>
                    <button id="btnUploadExcel" type="button" class="metro_button float-right">
                        <h2><i class="icon-upload-2"></i></h2>
                    </button>
                    <button id="btnNuevo" type="button" class="metro_button float-right">
                        <h2><i class="icon-plus-2"></i></h2>
                    </button>
                    <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                        <h2><i class="icon-undo"></i></h2>
                    </button>
                    <button id="btnSelectAll" type="button" class="metro_button float-left" data-hint-position="top" title="Seleccionar todo">
                        <h2><i class="icon-checkbox"></i></h2>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="modalUbigeo" class="modaluno modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Ubigeo
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddlDepartamento">Departamento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDepartamento" name="ddlDepartamento">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlProvincia">Provincia</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlProvincia" name="ddlProvincia">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlDistrito">Distrito</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDistrito" name="ddlDistrito">
                        </select>
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
                        <button id="btnAplicarUbigeo" type="button" class="command-button mode-add success">Aplicar Ubigeo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalRegistroConstructora" class="modal-dialog-x modaltres modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de constructora
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                 <div class="row">
                    <label for="txtNombreConstructora">Nombre</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombreConstructora" name="txtNombreConstructora" type="text" placeholder="Ingrese nombre de la constructora" title="">
                        <button class="btn-clear" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlTipoConstructora">Tipo de empresa</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlTipoConstructora" name="ddlTipoConstructora">
                            <?php
                            for ($counterTipoConstructora=0; $counterTipoConstructora < $countRowTipoConstructora; $counterTipoConstructora++):
                            ?>
                            <option value="<?php echo $rowTipoConstructora[$counterTipoConstructora]['ta_codigo']; ?>">
                                <?php $translate->__($rowTipoConstructora[$counterTipoConstructora]['ta_denominacion']); ?>
                            </option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div id="pnlInfoUbigeo" data-idubigeo="0" class="panel-info without-foto" data-hint-position="top" title="Localidad">
                        <div class="info">
                            <h3 class="descripcion">Localidad</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span6">
                        <label for="ddlTipoDocJuridica">Tipo de documento de identidad</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlTipoDocJuridica" name="ddlTipoDocJuridica">
                                <?php
                                for ($counterDocIdentJur=0; $counterDocIdentJur < $countRowDocIdentJur; $counterDocIdentJur++):
                                ?>
                                <option value="<?php echo $rowDocIdentJur[$counterDocIdentJur]['tm_iddocident']; ?>">
                                    <?php $translate->__($rowDocIdentJur[$counterDocIdentJur]['tm_descripcion']); ?>
                                </option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="txtRucEmpresa">N&uacute;mero de contribuyente</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtRucEmpresa" name="txtRucEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: 10450350261'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="txtRazonSocial">Raz&oacute;n Social</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtRazonSocial" name="txtRazonSocial" type="text" placeholder="<?php $translate->__('Ejemplo: Gonzales S.A.'); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtDireccionEmpresa">Direcci&oacute;n</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtDireccionEmpresa" name="txtDireccionEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: Direcci&oacute;n #456 Urb. XYZ'); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <label for="txtTelefonoEmpresa">Tel&eacute;fono</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtTelefonoEmpresa" name="txtTelefonoEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: +51979611547'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                    <div class="span8">
                        <label for="txtEmailEmpresa">Email</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtEmailEmpresa" name="txtEmailEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="txtWebEmpresa">P&aacute;gina web</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtWebEmpresa" name="txtWebEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: www.tudominio.com'); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
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
<script src="dist/js/app/admin/constructora-script.min.js"></script>