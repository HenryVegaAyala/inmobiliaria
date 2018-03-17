<?php
include('bussiness/banco.php');
include('bussiness/tabla.php');

$objBanco = new clsBanco();
$objTabla = new clsTabla();

$counterTipoPropiedad = 0;
$counterTipoOperacion = 0;
$counterBanco = 0;

$rowBanco = $objBanco->Listar('1', '0', '');
$countRowBanco = count($rowBanco);

$rowTipoOperacion = $objTabla->ValorPorCampo('ta_tipo_operacion');
$countRowTipoOperacion = count($rowTipoOperacion);

$rowTipoPropiedad = $objTabla->ValorExcluido('ta_tipopropiedad', 'NA');
$countRowTipoPropiedad = count($rowTipoPropiedad);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="<?php echo $idpersona; ?>" />
    <input type="hidden" id="hdIdPropiedad" name="hdIdPropiedad" value="0" />
    <input type="hidden" id="hdSaldoInicial" name="hdSaldoInicial" value="0" />
    <input type="hidden" id="hdSaldoDeudaAnterior" name="hdSaldoDeudaAnterior" value="0" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <input type="hidden" id="hdPagePropietario" name="hdPagePropietario" value="1">
    <input type="hidden" id="hdPageGenFacturacion" name="hdPageGenFacturacion" value="1" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
    <input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
    <input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Cobranza
            </h1>
            <div class="divContent">
                <div id="pnlPrincipalCobranza" class="all-height pos-rel">
                    <ul class="nav nav-tabs" id="tabGeneralCobranza" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_saldos">Saldos por propiedad</a></li>
                        <li role="presentation"><a href="#tab_listado">Listado de cobranzas realizadas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab_saldos">
                            <div id="pnlCobranza" class="row all-height">
                                <div class="col-md-6 all-height no-margin no-padding">
                                    <div id="pnlListPropiedades" class="generic-panel">
                                        <div class="gp-header">
                                            <div class="row padding10">
                                                <div class="col-md-4">
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlTipoPropiedadFiltro" name="ddlTipoPropiedadFiltro">
                                                            <option value="*">TODOS</option>
                                                            <?php
                                                            for ($counterTipoPropiedad=0; $counterTipoPropiedad < $countRowTipoPropiedad; $counterTipoPropiedad++):
                                                            ?>
                                                            <option value="<?php echo $rowTipoPropiedad[$counterTipoPropiedad]['ta_codigo']; ?>">
                                                                <?php $translate->__($rowTipoPropiedad[$counterTipoPropiedad]['ta_denominacion']); ?>
                                                            </option>
                                                            <?php
                                                            endfor;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-control text" data-role="input-control">
                                                        <input id="txtSearchPropiedad" name="txtSearchPropiedad" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                                        <button id="btnSearchPropiedad" name="btnSearchPropiedad" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gp-body">
                                            <div id="gvPropiedad" class="scrollbarra">
                                                <div class="items-area tile-area gridview padding5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gp-footer">
                                            <div class="appbar" style="text-align: center;">
                                                <button id="btnAgregarFromPropiedad" type="button" class="metro_button no-float" data-hint-position="top" title="Cobrar saldo anterior">
                                                    <h2><i class="icon-plus"></i></h2>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 all-height no-margin no-padding">
                                    <div class="generic-panel">
                                        <div class="gp-header">
                                            <div class="row padding10">
                                                <div class="col-md-1">
                                                    <label for="ddlAnho">A&ntilde;o: </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="ddlAnho" name="ddlAnho" class="form-control">
                                                        <option value="0">SELECCIONE PROYECTO</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="txtFechaIni_Filter">Desde</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="form-control">
                                                            <input id="txtFechaIni_Filter" name="txtFechaIni_Filter" class="full-size" type="text" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="txtFechaFin_Filter">Hasta</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="form-control">
                                                            <input id="txtFechaFin_Filter" name="txtFechaFin_Filter" class="full-size" type="text" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gp-body">
                                            <div class="generic-panel gp-no-footer">
                                                <div class="gp-header padding10">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3>Deuda anterior: <span id="lblDeudaAnteriorMes"></span></h3>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button id="btnCobroDeudaAnterior" type="button" class="btn btn-primary center-block">Cobrar deuda anterior</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gp-body">
                                                    <div id="tableFacturacion" class="itables">
                                                        <div class="ihead">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Codigo</th>
                                                                        <th>Fecha vencimiento</th>
                                                                        <th>Fecha tope</th>
                                                                        <th>Mes</th>
                                                                        <th>A&ntilde;o</th>
                                                                        <th>Importe</th>
                                                                        <th>Saldo</th>
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
                                            </div>
                                        </div>
                                        <div class="gp-footer">
                                            <div class="appbar">
                                                <button id="btnAgregarFromFacturacion" type="button" class="metro_button left hide" data-hint-position="top" title="Cobrar  facturas">
                                                    <h2><i class="icon-plus"></i></h2>
                                                </button>

                                                <div id="pnlTotalConsumoSoles" class="col-md-4 float-right">
                                                    <div class="row">
                                                        <label class="black-text">Saldo de otros a&ntilde;os (S/.)</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2 padding5">
                                                            <h3 class="no-margin">S/.</h3>
                                                        </div>
                                                        <div class="col-md-8 padding5">
                                                            <h3 class="no-margin text-right" id="lblSaldoTotal_EsteAnho">0.00</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 float-right">
                                                    <div class="row">
                                                        <label id="lblTextSaldoAnho" class="black-text">Saldo <?php echo date('Y'); ?></label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2 padding5">
                                                            <h3 class="no-margin hide">S/.</h3>
                                                        </div>
                                                        <div class="col-md-8 padding5">
                                                            <h3 class="no-margin text-right" id="lblSaldoTotal_OtrosAnhos">0.00</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab_listado">
                            <div class="generic panel">
                                <div class="gp-header"></div>
                                <div class="gp-body">
                                    <div id="tableCobranza" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th style="width: 150px;">Tipo operaci&oacute;n</th>
                                                        <th style="width: 100px;">Fecha</th>
                                                        <th>Propietario</th>
                                                        <th style="width: 100px;">Propiedad</th>
                                                        <th style="width: 60px;">A&ntilde;o</th>
                                                        <th style="width: 60px;">Mes</th>
                                                        <!-- <th>Banco</th>
                                                        <th>Cuenta bancaria</th>  -->
                                                        <th style="width: 120px;">Nro Operaci&oacute;n</th>
                                                        <th style="width: 130px;">Importe</th>
                                                        <th></th>
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
                                <div class="gp-footer">
                                    <div class="appbar">
                                        <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Eliminar cobranza">
                                            <h2><i class="icon-remove"></i></h2>
                                        </button>
                                        <button id="btnEditar" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Editar cobranza">
                                            <h2><i class="icon-pencil"></i></h2>
                                        </button>
                                        <button id="btnNuevo" type="button" class="metro_button float-right" data-hint-position="top" title="Nueva cobranza">
                                            <h2><i class="icon-plus-2"></i></h2>
                                        </button>
                                        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Limpiar selecci&oacute;n">
                                            <h2><i class="icon-undo"></i></h2>
                                        </button>
                                        <?php if ($idperfil == '61'): ?>
                                        <button id="btnEstadoCuenta" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Estado de cuenta">
                                            <h2><i class="icon-bars"></i></h2>
                                        </button>
                                        <?php endif; ?>
                                        <button id="btnSelectAll" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Seleccionar todo">
                                            <h2><i class="icon-checkbox"></i></h2>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalRegistroCobranza" class="modal-nomodal modal-dialog-x modal-example-content">
        <input type="hidden" id="hdIdFacturacion" name="hdIdFacturacion" value="0">
        <input type="hidden" id="hdIdConcepto" name="hdIdConcepto" value="0">
        <input type="hidden" id="hdIdBanco" name="hdIdBanco" value="0">
        <input type="hidden" id="hdIdCuentaBancaria" name="hdIdCuentaBancaria" value="0">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de Cobranza
            </h2>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdTieneFactura" name="hdTieneFactura" value="0">
            <div class="all-height pos-rel">
                <ul class="nav nav-tabs" id="tabCobranza" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_general">Datos generales</a></li>
                    <li role="presentation"><a href="#tab_detalle_cobranza">Subir voucher</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_general">
                        <div class="generic-panel">
                            <div class="gp-header">
                                <div class="scrollbarra">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="ddlTipoOperacion">Tipo de operaci&oacute;n</label>
                                            <div class="input-control select fa-caret-down" data-role="input-control">
                                                <select id="ddlTipoOperacion" name="ddlTipoOperacion">
                                                    <?php
                                                    for ($counterTipoOperacion=0; $counterTipoOperacion < $countRowTipoOperacion; $counterTipoOperacion++):
                                                    ?>
                                                    <option value="<?php echo $rowTipoOperacion[$counterTipoOperacion]['ta_codigo']; ?>">
                                                        <?php $translate->__($rowTipoOperacion[$counterTipoOperacion]['ta_denominacion']); ?>
                                                    </option>
                                                    <?php
                                                    endfor;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="txtFechaCobranza">Fecha cobranza</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtFechaCobranza" name="txtFechaCobranza" type="text" value="<?php echo date('d/m/Y'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2 colPeriodo">
                                            <label for="ddlAnhoCobranza">A&ntilde;o de cobranza</label>
                                            <div class="input-control select fa-caret-down" data-role="input-control">
                                                <select id="ddlAnhoCobranza" name="ddlAnhoCobranza">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 colPeriodo">
                                            <label for="ddlMesCobranza">Meses de cobranza</label>
                                            <div class="input-control select fa-caret-down" data-role="input-control">
                                                <select id="ddlMesCobranza" name="ddlMesCobranza">
                                                    <?php ListarMeses(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id="pnlInfoConcepto" data-tipofiltro="concepto" class="panel-info without-foto" data-hint-position="top" title="Conceptos">
                                                <div class="info">
                                                    <h3 class="descripcion">Conceptos</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 id="lblBanco"></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 id="lblCuentaBancaria"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="txtNroOperacion">N&uacute;mero operaci&oacute;n</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtNroOperacion" name="txtNroOperacion" type="text" placeholder="Ingrese n&uacute;mero de operaci&oacute;n" title="" value="">
                                                <button class="btn-clear" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="txtImporteCobranza">Importe</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtImporteCobranza" name="txtImporteCobranza" type="text" placeholder="Ingrese importe de pago" title="" value="0.00">
                                                <button class="btn-clear" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="txtImporteMora">Importe mora</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtImporteMora" name="txtImporteMora" type="text" placeholder="Ingrese importe de mora" title="" value="0.00">
                                                <button class="btn-clear" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="colCheckImporteDetallado col-md-3">
                                            <label>
                                                <input id="chkImporteDetallado" name="chkImporteDetallado" type="checkbox" value="1"> Con importes detallados
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gp-body">
                                <div id="tableFacturacion__PorCobrar" class="itables">
                                    <div class="ihead">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Codigo</th>
                                                    <th style="width: 15%;">Fecha vencimiento</th>
                                                    <th style="width: 15%;">Fecha tope</th>
                                                    <th style="width: 10%;">Mes</th>
                                                    <th style="width: 5%;">A&ntilde;o</th>
                                                    <th style="width: 15%;">Importe</th>
                                                    <th style="width: 15%;">Saldo</th>
                                                    <th style="width: 15%;">Pago</th>
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
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab_detalle_cobranza">
                        <div class="droping-air mode-image">
                            <input id="fileImagen" name="fileImagen" type="file" class="file-import">
                            <div class="icon"></div>
                            <div class="help">
                                Seleccione o arrastre un archivo de imagen (*.jpg, .gif, *.png)
                            </div>
                            <a class="cancel oculto" data-hint-position="left" title="Quitar imagen"><h2 class="no-margin fg-white fg-hover-amber"><i class="icon-cancel"></i></h2></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span9">
                    </div>
                    <div class="span3">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Aplicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlImpresionFactura" class="top-panel inner-page" style="display:none;">
        <h1 class="title-window">
            <a href="#" id="btnHideImpresion" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            Vista de factura
        </h1>
        <div id="precargaCli" class="divload">
            <iframe id="ifrImpresionFactura" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
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
    <div id="pnlDatosFiltro" data-tipofiltro="proyecto" class="top-panel inner-page" style="display:none;">
        <div class="generic-panel">
            <div class="gp-header">
                <h1 class="title-window">
                    <a href="#" id="btnHideFiltro" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
                    <span id="txtTituloFiltro">Conceptos</span>
                    <div class="col-md-6 no-float margin10 place-top-right">
                        <div class="input-group">
                          <input id="txtSearchFiltro" name="txtSearchFiltro" type="text" class="form-control fg-dark margin-top5 margin-bottom5" placeholder="Buscar...">
                          <span class="input-group-btn">
                            <button id="btnSearchFiltro" class="btn btn-default" type="button">Buscar</button>
                          </span>
                        </div><!-- /input-group -->
                    </div>
                </h1>
            </div>
            <div class="gp-body">
                <div id="gvFiltro" class="scrollbarra">
                    <div class="items-area listview gridview"></div>
                </div>
            </div>
            <div class="gp-footer">
                <div class="appbar">
                    <button id="btnAsignarConcepto" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Asignar conceptos">
                        <h2><i class="icon-checkmark"></i></h2>
                    </button>
                    <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Limpiar selecci&oacute;n">
                        <h2><i class="icon-undo"></i></h2>
                    </button>
                    <button id="btnSelectAll" type="button" class="metro_button float-left" data-hint-position="top" title="Seleccionar todo">
                        <h2><i class="icon-checkbox"></i></h2>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="modalEstadoCuenta" class="modalcuatro modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Estados de cuenta
                <button class="large success no-margin" type="button" data-target="propietario"><?php $translate->__('Propietarios'); ?></button>
                <button class="large no-margin" type="button" data-target="inquilino"><?php $translate->__('Inquilinos'); ?></button>
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="moduloEstadoCuenta" class="moduloTwoPanel default">
                <div class="colTwoPanel1">
                    <div class="generic-panel gp-no-footer">
                        <div class="gp-header padding10">
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearchPropietario" name="txtSearchPropietario" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearchPropietario" name="btnSearchPropietario" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </div>
                        <div class="gp-body">
                            <div id="gvPropietario" class="scrollbarra">
                                <div class="items-area listview gridview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="colTwoPanel2">
                    <div id="gpEstadoCuenta" class="generic-panel gp-no-footer">
                        <div class="gp-header">
                            <div id="tableMaestroCuenta" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Facturado</th>
                                                <th>Cancelado</th>
                                                <th>Saldo</th>
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
                        <div class="gp-body">
                            <div id="tableDetalleCuenta" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Propiedad</th>
                                                <th>Mes</th>
                                                <th>Facturado</th>
                                                <th>Cancelado</th>
                                                <th>Saldo</th>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span7">
                    </div>
                    <div class="span5">
                        <button id="btnGuardarEsadoCuenta" type="button" class="command-button mode-add success">Guardar estado de cuenta</button>
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
<script src="plugins/multiselect/js/bootstrap-multiselect.min.js"></script>
<script src="dist/js/app/process/cobranza-script.min.js"></script>