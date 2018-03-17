<?php
require 'bussiness/tipocomprobante.php';
require 'bussiness/tabla.php';

$objTabla = new clsTabla();
$objTipoComprobante = new clsTipoComprobante();

$rowTipoGasto = $objTabla->ValorPorCampo('ta_tipogasto');
$countRowTipoGasto = count($rowTipoGasto);

$rowTipoDesembolso = $objTabla->ValorPorCampo('ta_tipodesembolso');
$countRowTipoDesembolso = count($rowTipoDesembolso);

$rowTipoAfectacion = $objTabla->ValorPorCampo('ta_tipoafectacion');
$countRowTipoAfectacion = count($rowTipoAfectacion);

$rowTipoComprobante = $objTipoComprobante->ListarTipoDocumento('1', '', '');
$countRowTipoComprobante = count($rowTipoComprobante);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageGasto" name="hdPageGasto" value="1" />
    <input type="hidden" id="hdPageProyecto" name="hdPageProyecto" value="1" />
    <input type="hidden" id="hdPagePresupuesto" name="hdPagePresupuesto" value="1" />
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Gastos
            </h1>
            <div class="panel-search">
                <div class="grid">
                    <div class="row hide" style="padding: 5px 0;">
                        <div id="pnlFiltroProyecto" data-tipofiltro="filtroproyecto" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                            <div class="info">
                                <h3 class="descripcion">Proyecto</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 5px 0;">
                        <div class="input-control text" data-role="input-control">
                            <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                            <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="scrollbarra">
                    <div class="card-area gridview">
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <!-- <button id="btnUploadExcel" type="button" class="metro_button float-right">
                    <h2><i class="icon-upload-2"></i></h2>
                </button> -->
                <button id="btnNuevo" type="button" class="metro_button float-right">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <button id="btnSelectAll" type="button" class="metro_button float-left" data-hint-position="top" title="Seleccionar todo">
                    <h2><i class="icon-checkbox"></i></h2>
                </button>
                <button id="btnProyeccion" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Proyectar presupuesto">
                    <h2><i class="icon-calendar"></i></h2>
                </button>
            </div>
        </div>
        <div id="pnlRegistro" class="inner-page with-appbar" style="display: none;">
            <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
            <input type="hidden" id="hdIdProveedor" name="hdIdProveedor" value="0">
            <input type="hidden" id="hdIdPropietario" name="hdIdPropietario" value="0">
            <input type="hidden" id="hdIdConcepto" name="hdIdConcepto" value="0">
            <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
            <h1 class="title-window hide">
                <a id="btnBackPrevPanel" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Registro
            </h1>
            <div class="divContent">
                <div class="scrollbarra">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="ddlTipoGasto"><?php $translate->__('Tipo de gasto'); ?></label>
                                <select name="ddlTipoGasto" id="ddlTipoGasto" class="form-control">
                                    <?php
                                    for ($i=0; $i < $countRowTipoGasto; $i++):
                                    ?>
                                    <option value="<?php echo $rowTipoGasto[$i]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoGasto[$i]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="ddlTipoDesembolso"><?php $translate->__('Tipo de desembolso'); ?></label>
                                <select name="ddlTipoDesembolso" id="ddlTipoDesembolso" class="form-control">
                                    <?php
                                    for ($i=0; $i < $countRowTipoDesembolso; $i++):
                                    ?>
                                    <option value="<?php echo $rowTipoDesembolso[$i]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoDesembolso[$i]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="ddlTipoAfectacion"><?php $translate->__('Tipo de afectaci&oacute;n'); ?></label>
                                <select name="ddlTipoAfectacion" id="ddlTipoAfectacion" class="form-control">
                                    <?php
                                    for ($i=0; $i < $countRowTipoAfectacion; $i++):
                                    ?>
                                    <option value="<?php echo $rowTipoAfectacion[$i]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoAfectacion[$i]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="txtSearchProveedor">Buscar proveedores...</label>
                                <input type="text" name="txtSearchProveedor" id="txtSearchProveedor" class="form-control" style="width: 100%;" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="txtSearchConcepto">Buscar conceptos...</label>
                                <input type="text" name="txtSearchConcepto" id="txtSearchConcepto" class="form-control" style="width: 100%;" />
                            </div>
                        </div>
                    </div>
                    <div class="row rowPropietario hide">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="txtSearchPropietario">Buscar propietarios...</label>
                                <input type="text" name="txtSearchPropietario" id="txtSearchPropietario" class="form-control" style="width: 100%;" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 datosDeposito">
                            <label class="control-label" for="ddlTipoDocumento">Tipo de documento</label>
                            <select id="ddlTipoDocumento" name="ddlTipoDocumento" class="form-control">
                                <?php
                                for ($i=0; $i < $countRowTipoComprobante; $i++):
                                ?>
                                <option value="<?php echo $rowTipoComprobante[$i]['idtipodocumento']; ?>">
                                    <?php $translate->__($rowTipoComprobante[$i]['descripciondocumento']); ?>
                                </option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 datosDeposito">
                            <div class="form-group">
                                <label class="control-label" for="txtSerieDocumento"><?php $translate->__('Serie'); ?></label>
                                <input class="validate form-control" type="text" id="txtSerieDocumento" name="txtSerieDocumento">
                            </div>
                        </div>
                        <div class="col-md-2 datosDeposito">
                            <div class="form-group">
                                <label class="control-label" for="txtNroDocumento"><?php $translate->__('N&uacute;mero'); ?></label>
                                <input class="validate form-control" type="text" id="txtNroDocumento" name="txtNroDocumento">
                            </div>
                        </div>
                        <div class="col-md-2 datosEfectivo">
                            <div class="form-group">
                                <label class="control-label" for="txtNroSuministro"><?php $translate->__('N&uacute;mero de suministro'); ?></label>
                                <input class="validate form-control" type="text" id="txtNroSuministro" name="txtNroSuministro">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required">
                                <label class="control-label" for="txtFecha">Fecha:</label>
                                <div class="input-group date date-register" data-provide="datepicker">
                                    <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo date('d/m/Y'); ?>" data-date-default="<?php echo date('d/m/Y'); ?>" />
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label" for="ddlAnho">A&ntilde;o</label>
                            <select id="ddlAnho" name="ddlAnho" class="form-control">
                                <option value="0">SELECCIONE PROYECTO</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="ddlMes">Mes</label>
                            <select name="ddlMes" id="ddlMes" class="form-control">
                                <?php ListarMeses(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="txtImporte"><?php $translate->__('Importe'); ?></label>
                                <input class="validate form-control align-right" type="text" id="txtImporte" name="txtImporte" value="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                                <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnCancelar" type="button" class="metro_button float-right">
                    <h2><i class="icon-cancel"></i></h2>
                </button>
                <button id="btnGuardar" type="button" class="metro_button float-right">
                    <h2><i class="icon-checkmark"></i></h2>
                </button>
            </div>
        </div>
    </div>
    <div id="modalRegistro" class="modal-dialog modaluno modal-example-content">
        <input type="hidden" id="hdIdConcepto" name="hdIdConcepto" value="0">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Detalle de presupuesto
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                    <div id="pnlInfoConcepto" data-tipofiltro="concepto" data-idconcepto="0" class="panel-info without-foto" data-hint-position="top" title="Concepto">
                        <div class="info">
                            <h3 class="descripcion">Concepto</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span6">
                        <label for="txtCantidad">Cantidad</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtCantidad" name="txtCantidad" type="text" placeholder="Ingrese Cantidad" class="only-numbers">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="txtPrecioUnitario">Precio Unitario</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtPrecioUnitario" name="txtPrecioUnitario" type="text" placeholder="Ingrese Precio Unitario" class="only-numbers">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="pnlDisplayImporte without-info">
                        <input id="txtSubTotal" name="txtSubTotal" type="text" class="oculto">
                        <div class="simbolo">
                            <h1 id="lblMonedaCobro" class="text-center fg-darkCobalt">S/.</h1>
                        </div>
                        <div class="total">
                            <h1 id="lblImporteCobro" class="importe text-right fg-emerald">0.00</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span3"></div>
                    <div class="span6">
                        <button id="btnAgregar" type="button" class="command-button mode-add success">Agregar</button>
                    </div>
                    <div class="span3"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlDatosFiltro" data-tipofiltro="proyecto" class="top-panel with-appbar inner-page with-panel-search" style="display:none;">
        <h1 class="title-window hide">
            <a href="#" id="btnHideFiltro" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            <span id="txtTituloFiltro"></span>
        </h1>
        <div class="panel-search">
            <div class="input-control text" data-role="input-control">
                <input type="text" id="txtSearchFiltro" name="txtSearchFiltro" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                <button id="btnSearchFiltro" type="button" class="btn-search" tabindex="-1"></button>
            </div>
        </div>
        <div id="precargaCli" class="divload">
            <div id="gvFiltro" class="scrollbarra">
                <div class="gridview"></div>
            </div>
        </div>
        <div class="appbar">
            <button id="btnAsignFilter" type="button" class="metro_button oculto float-right">
                <h2><i class="icon-checkmark"></i></h2>
            </button>
            <button id="btnClearFilter" type="button" class="metro_button oculto float-left">
                <h2><i class="icon-undo"></i></h2>
            </button>
            <button id="btnSelectAllFilter" type="button" class="metro_button float-left" data-tipofiltro="concepto" data-hint-position="top" title="Conceptos">
                <h2><i class="icon-checkbox"></i></h2>
            </button>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="plugins/datetimepicker/moment.min.js"></script>
<script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script>
<script src="dist/js/app/process/gasto-script.js"></script>