<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageFacturacion" name="hdPageFacturacion" value="1" />
    <input type="hidden" id="hdPageGenFacturacion" name="hdPageGenFacturacion" value="1" />
    <input type="hidden" id="hdPagePropiedad" name="hdPagePropiedad" value="1">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page without-title-window with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Liquidaci&oacute;n
            </h1>
            <div class="panel-search hide">
                <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
                <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
                <div id="pnlInfoProyecto" data-tipofiltro="proyecto" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                    <div class="info">
                        <h3 class="descripcion">Proyecto</h3>
                    </div>
                </div>
            </div>
            <div class="divload">
                <div id="tableLiquidacion" class="itables">
                    <div class="ihead">
                        <table>
                            <thead>
                                <tr>
                                    <th>A&ntilde;o</th>
                                    <th>Mes</th>
                                    <th>Saldo inicial</th>
                                    <th>Saldo final</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="ibody">
                        <div class="ibody-content">
                            <table>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
    <div id="modalLiquidacion" class="modaluno modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Liquidaci&oacute;n - Saldo inicial
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <div id="pnlInfoLiquidacion" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                        <div class="info">
                            <h3 class="descripcion">Proyecto</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlAnho">Año</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlAnho" name="ddlAnho">
                            <option value="0">SELECCIONE PROYECTO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlMes">Mes</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlMes" name="ddlMes">
                            <?php ListarMeses(); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="txtSaldoInicial">Saldo Inicial</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtSaldoInicial" name="txtSaldoInicial" type="text" placeholder="Ingrese Saldo" aria-required="true" aria-invalid="false" data-original-title="" title="">
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
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</button>
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
<script src="dist/js/app/process/liquidacion-script.min.js"></script>