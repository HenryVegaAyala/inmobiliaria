<?php 
include('bussiness/tabla.php');
$objTabla = new clsTabla();

$counterTipoPropiedad = 0;

$rowTipoPropiedad = $objTabla->ValorExcluido('ta_tipopropiedad', 'NA');
$countRowTipoPropiedad = count($rowTipoPropiedad);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdTipoImportacion" name="hdTipoImportacion" value="1" />
    <input type="hidden" id="hdPageFacturacion" name="hdPageFacturacion" value="1" />
    <input type="hidden" id="hdPageGenFacturacion" name="hdPageGenFacturacion" value="1" />
    <input type="hidden" id="hdPagePropiedad" name="hdPagePropiedad" value="1">
    <input type="hidden" id="hdPageProyecto" name="hdPageProyecto" value="1">
    <input type="hidden" id="hdPageConcepto" name="hdPageConcepto" value="1">
    <input type="hidden" id="hdIdConcepto" name="hdIdConcepto" value="0">
    <input type="hidden" id="hdConceptoEscalonable" name="hdConceptoEscalonable" value="0">

    <input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
    <input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />

    <div class="page-region without-appbar">
        <div id="pnlListado" class="generic-panel gp-no-footer">
            <div class="gp-header">
                <div class="row padding10">
                    <div id="groupVistaConsumo" class="col-md-4">
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="btnConsultarConsumo" class="span-button btn btn-primary btn-success success" type="button" data-target="consulta"><?php $translate->__('Consultar consumo'); ?></button>
                            <button id="btnNuevoConsumo" class="span-button btn btn-primary" type="button" data-target="generacion"><?php $translate->__('Nuevo consumo'); ?></button>
                        </div>
                    </div>
                    <div id="groupFechas" class="col-md-8 hide">
                        <div class="form-inline" role="group" aria-label="...">
                            <div class="form-group no-margin">
                                <label for="txtFechaVencimiento" class="white-text">Fecha vencimiento</label>
                                <div class="form-control">
                                    <input id="txtFechaVencimiento" name="txtFechaVencimiento" type="text" title="">
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label for="txtFechaTope" class="white-text">Fecha tope</label>
                                <div class="form-control">
                                    <input id="txtFechaTope" name="txtFechaTope" type="text" title="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="groupConcepto" class="col-md-4 hide">
                        <div class="form-group no-margin">
                            <input type="text" name="txtSearchConcepto" id="txtSearchConcepto" class="form-control" placeholder="Buscar conceptos..." style="width: 100%;" />
                        </div>
                    </div>
                    <div class="col-md-4 right">
                        <div id="groupOpcionesFactura" class="btn-group right" role="group" aria-label="...">
                            <button class="btn btn-primary btn-success" type="button" data-target="#tabCalculoEscalonable"><?php $translate->__('Agua'); ?></button>
                            <button id="btnAscensor" class="btn btn-primary oculto" type="button" data-target="#tabCalculoAscensor"><?php $translate->__('Ascensores'); ?></button>
                            <button class="btn btn-primary btn-primary no-margin" type="button" data-target="#tabConceptoVariable"><?php $translate->__('Concepto variable'); ?></button>
                            <button class="btn btn-primary" type="button" data-target="#tabFacturacion"><?php $translate->__('Facturar'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gp-body">
                <section id="tabCalculoEscalonable" class="tab-principal">
                    <div id="pnlCalculoEscalonable" class="inner-page with-appbar">
                        <div class="divContent">
                            <div id="tablePropiedad" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Propiedad</th>
                                                <th>Lectura anterior</th>
                                                <th>Lectura actual</th>
                                                <th>Consumo</th>
                                                <th>Importe Consumo</th>
                                                <th>Fecha inicial</th>
                                                <th>Fecha final</th>
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
                            <button id="btnCalConsumoMeses" name="btnCalConsumoMeses" type="button" class="metro_button float-left" title="Calcular consumo por meses" data-hint-position="top">
                                <h2><i class="icon-calculate"></i></h2>
                            </button>
                            <button id="btnGeneracionConceptoVariable" name="btnGeneracionConceptoVariable" type="button" class="metro_button float-left" title="Generar concepto variable" data-hint-position="top">
                                <h2><i class="fa fa-money" aria-hidden="true"></i></h2>
                            </button>
                            <button id="btnCalcularConsumo" type="button" class="metro_button oculto float-right" title="Aplicar cambios" data-hint-position="top">
                                <h2><i class="icon-checkmark"></i></h2>
                            </button>
                            <button id="btnIngresoFechasConsumo" type="button" class="metro_button oculto float-right" title="Ingresar fechas de manera masiva" data-hint-position="top">
                                <h2><i class="icon-calendar"></i></h2>
                            </button>
                            <div id="pnlTotalConsumoSoles" class="col-md-4 float-right">
                                <div class="row">
                                    <label class="black-text">Total Consumo (S/.)</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 padding5">
                                        <h3 class="no-margin">S/.</h3>
                                    </div>
                                    <div class="col-md-8 padding5">
                                        <h3 class="no-margin text-right" id="lblTotalConsumo_Soles">0.00</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 float-right">
                                <div class="row">
                                    <label class="black-text">Total Consumo (M3)</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 padding5">
                                        <h3 class="no-margin hide">S/.</h3>
                                    </div>
                                    <div class="col-md-8 padding5">
                                        <h3 class="no-margin text-right" id="lblTotalConsumo">0.00</h3>
                                    </div>
                                </div>
                            </div>
                            <button id="btnExportarPropiedad" type="button" class="metro_button float-left" data-hint-position="top" title="Exportar propiedades">
                                <h2><i class="icon-download"></i></h2>
                            </button>
                            <button id="btnImportarPropiedad" type="button" class="metro_button float-left" data-hint-position="top" title="Importar consumo de agua">
                                <h2><i class="icon-upload"></i></h2>
                            </button>
                        </div>
                    </div>
                </section>
                <section id="tabConceptoVariable" class="tab-principal" style="display: none;">
                    <div id="pnlConceptoVariable" class="inner-page with-appbar">
                        <div class="divContent">
                            <div id="tablePropiedadConcepto" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Propiedad</th>
                                                <th>Importe</th>
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
                            <button id="btnCalcularConsumo_Concepto" type="button" class="metro_button oculto float-right" title="Aplicar cambios" data-hint-position="top">
                                <h2><i class="icon-checkmark"></i></h2>
                            </button>
                            <div class="col-md-4 float-right">
                                <div class="row">
                                    <label class="black-text">Total Concepto Variable</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 padding5">
                                        <h3 class="no-margin">S/.</h3>
                                    </div>
                                    <div class="col-md-8 padding5">
                                        <h3 class="no-margin text-right" id="lblTotalConceptoVariable">0.00</h3>
                                    </div>
                                </div>
                            </div>
                            <button id="btnExportarPropiedad_Concepto" type="button" class="metro_button float-left" data-hint-position="top" title="Exportar propiedades">
                                <h2><i class="icon-download"></i></h2>
                            </button>
                            <button id="btnImportarPropiedad_Concepto" type="button" class="metro_button float-left" data-hint-position="top" title="Importar consumo de agua">
                                <h2><i class="icon-upload"></i></h2>
                            </button>
                        </div>
                    </div>
                </section>
                <section id="tabCalculoAscensor" class="tab-principal" style="display: none;">
                    <div id="pnlCalculoAscensor" class="inner-page with-appbar">
                        <div class="divContent">
                            <div id="tableTorre" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Torre</th>
                                                <th>Nro. Suministro</th>
                                                <th>Importe</th>
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
                            <button id="btnConfirmarTorre" type="button" class="metro_button float-right">
                                <h2><i class="icon-checkmark"></i></h2>
                            </button>
                        </div>
                    </div>
                </section>
                <section id="tabFacturacion" class="tab-principal" style="display: none;">
                    <div id="pnlFacturacion" class="inner-page with-appbar">
                        <div class="divContent">
                            <div class="moduloTwoPanel default">
                                <div class="colTwoPanel1">
                                    <div class="generic-panel gp-no-footer">
                                        <div class="gp-header">
                                            <div class="grid fluid padding10">
                                                <div class="row">
                                                    <div class="span3">
                                                        <div class="input-control select fa-caret-down" data-role="input-control">
                                                            <select id="ddlTipoPropiedadFacturacion" name="ddlTipoPropiedadFacturacion">
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
                                                    <div class="span9">
                                                        <div class="input-control text" data-role="input-control">
                                                            <input id="txtSearchFacturacion" name="txtSearchFacturacion" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                                            <button id="btnSearchFacturacion" name="btnSearchPropiedad" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gp-body">
                                            <div id="gvGenFacturacion" class="scrollbarra">
                                                <div class="card-area gridview padding5">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="colTwoPanel2">
                                    <div id="pnlConceptoFacturacion" class="generic-panel gp-no-header">
                                        <div class="gp-body">
                                            <div id="tableConcepto" class="itables">
                                                <div class="ihead">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Concepto</th>
                                                                <th>Subtotal</th>
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
                                            <div class="appbar bg-darkCyan">
                                                <div class="grid fluid">
                                                    <div class="row">
                                                        <div class="span2 padding5">
                                                            <h3 class="fg-white">S/.</h3>
                                                        </div>
                                                        <div class="span8 padding5">
                                                            <h3 id="lblTotalConceptoFact" class="fg-white text-right">0.00</h3>
                                                        </div>
                                                        <div class="span2">
                                                            <button id="btnGuardarConcepto" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Guardar conceptos">
                                                            <h2><i class="icon-checkmark"></i></h2>
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
                        <div class="appbar">
                            <button id="btnImprimirFactura" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Imprimir facturas">
                                <h2><i class="icon-printer"></i></h2>
                            </button>
                            <button id="btnEnviarEmail" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Enviar facturas por correo">
                                <h2><i class="icon-mail"></i></h2>
                            </button>
                            <button id="btnGenerar" type="button" class="metro_button float-right" data-hint-position="top" title="Generar facturacion">
                                <h2><i class="icon-coins"></i></h2>
                            </button>
                            <button id="btnImportarDetalleFacturas" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Importar detalles de facturas">
                                <h2><i class="icon-upload"></i></h2>
                            </button>
                            <button id="btnExportarFacturasExcel" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Exporar detalle facturas a Excel">
                                <h2><i class="icon-download"></i></h2>
                            </button>
                            <button id="btnExportarTotalesFacturaExcel" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Exporar totales de facturas a Excel">
                                <h2><i class="fa fa-file-excel-o" aria-hidden="true"></i></h2>
                            </button>
                            <button id="btnDivisionFactura" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Dividir factura">
                                <h2><i class="icon-flip-2"></i></h2>
                            </button>
                            <button id="btnRegenerar" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Regenerar factura seleccionada">
                                <h2><i class="icon-cycle"></i></h2>
                            </button>
                            <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-left">
                                <h2><i class="icon-remove"></i></h2>
                            </button>
                            <button id="btnVistaPrevia" name="btnVistaPrevia" type="button" class="metro_button oculto float-left">
                                <h2><i class="icon-search"></i></h2>
                            </button>
                            <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                                <h2><i class="icon-undo"></i></h2>
                            </button>
                            <button id="btnSelectAll" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Seleccionar todo">
                                <h2><i class="icon-checkbox"></i></h2>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="hide inner-page with-title-window without-appbar">
            <div class="title-window">
            </div>
            <div class="divContent">
                <div class="pnlDetalleDos generic-panel hide gp-no-footer">
                    <div class="gp-header">
                        <div class="row">
                            <div id="pnlInfoProyecto" data-tipofiltro="proyecto" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                                <div class="info">
                                    <h3 class="descripcion">Proyecto</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 hide">
                                <label for="ddlAnho">Año</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlAnho" name="ddlAnho">
                                        <option value="0">SELECCIONE PROYECTO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 hide">
                                <label for="ddlMes">Mes</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlMes" name="ddlMes">
                                        <?php ListarMeses(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gp-body">
                    </div>   
                </div>                
            </div>
        </div>
    </div>
    <div id="pnlCalculoAguaMeses" class="top-panel inner-page  with-appbar" style="display:none;">
        <h1 class="title-window hide">
            <a id="btnBackToFacturacion" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            Calculo de consumo de agua por meses
        </h1>
        <div class="divContent smaller">
            <div id="pnlDetallePromedio" class="pnlDetalle generic-panel gp-no-footer">
                <div class="gp-header">
                    <input type="hidden" id="hdIdConsumoProyecto" name="hdIdConsumoProyecto" value="0">
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span8 hide">
                                <div id="pnlConsumoProyecto" data-tipofiltro="consumo" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                                    <div class="info">
                                        <h3 class="descripcion">Proyecto</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="span4"></div>
                            <div class="span2">
                                <label for="ddlMesInicio" class="fonty">Mes Inicio</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlMesInicio" name="ddlMesInicio">
                                        <?php ListarMeses(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label for="ddlMesFin" class="fonty">Mes Fin</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlMesFin" name="ddlMesFin">
                                        <?php ListarMeses(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span4"></div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="tableConsumoAgua" class="itables fonty">
                        <div class="ihead">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Propiedades</th>
                                        <th>Consumo promedio</th>
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
        <div class="appbar">
            <button id="btnCancelarCalculoAgua" type="button" class="metro_button float-right">
                <h2><i class="icon-cancel"></i></h2>
            </button>
            <button id="btnGenerarCalculoAgua" type="button" class="metro_button float-right">
                <h2><i class="icon-checkmark"></i></h2>
            </button>
        </div>
    </div>
    <div id="pnlPropiedad" class="top-panel inner-page with-appbar" style="display:none;">
        <div id="tabDetalle" class="tab-control" data-role="tab-control">
            <ul class="tabs">
                <li class="active" data-tab="Departamento" data-idtipopropiedad="DPT"><a href="#_page_1">Departamentos</a></li>
                <li data-tab="Estacionamiento" data-idtipopropiedad="EST"><a href="#_page_2">Estacionamientos</a></li>
                <li data-tab="Deposito" data-idtipopropiedad="DEP"><a href="#_page_3">Dep&oacute;sitos</a></li>
            </ul>
            <div class="frames">
                <div class="frame no-padding" id="_page_1" data-idtipopropiedad="DPT">
                    <div id="gvDepartamento" class="scrollbarra">
                        <div class="card-area gridview padding5">
                        </div>
                    </div>
                </div>
                <div class="frame no-padding" id="_page_2" data-idtipopropiedad="EST">
                    <div id="gvEstacionamiento" class="scrollbarra">
                        <div class="card-area gridview padding5">
                        </div>
                    </div>
                </div>
                <div class="frame no-padding" id="_page_3" data-idtipopropiedad="DEP">
                    <div id="gvDeposito" class="scrollbarra">
                        <div class="card-area gridview padding5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalGenPDF" class="modal-dialog-x modaluno modal-example-content">
        <div class="modal-example-header no-overflow">
            <h2 class="no-margin b-hide">
                <a id="btnCloseGenPDF" class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                <span id="lblTitleGenPDF">Envio de emails</span>
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                    <div class="span5">
                        <h1  id="lblNroFactGeneradas" class="text-center">0</h1>
                    </div>
                    <div class="span2">
                        <h1 class="text-center">/</h1>
                    </div>
                    <div class="span5">
                        <h1 id="lblNroFactEnviadas" class="text-center">0</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="span5">
                        <h5 class="text-center">Facturas generadas</h5>
                    </div>
                    <div class="span2"></div>
                    <div class="span5">
                        <h5 id="lblInfoGenPDF" class="text-center">Facturas enviadas</h5>
                    </div>
                </div>
                <div class="row">
                    <div id="pbProgresoIndividual" class="progress-bar large" data-role="progress-bar" data-value="0"></div>
                </div>
                <div class="row">
                    <h5 class="text-center"><strong id="lblDesProgIndividual">Enviando factura </strong><strong id="lblDescripFactura"></strong></h5>
                </div>
                <div class="row">
                    <div id="pbProgresoTotal" class="progress-bar large" data-role="progress-bar" data-value="0"></div>
                </div>
                <div class="row">
                    <h5 class="text-center"><strong id="lblDesPorcjEnvio">Envio </strong><strong id="lblPorcentajeEnvio"></strong>% completado.</h5>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnFinalizarEnvio" type="button" class="command-button mode-add success oculto">Finalizar</button>
                        <button id="btnCancelarEnvio" type="button" class="command-button mode-add warning">Cancelar env&iacute;o</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalGenFacturacion" class="modal-dialog-x modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a id="btnCloseGenFacturacion" class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                <span id="lblTitleGenFacturacion">Generaci&oacute;n de facturaci&oacute;n</span>
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                    <div class="span5">
                        <h1  id="lblNroPropEncontradas" class="text-center">0</h1>
                    </div>
                    <div class="span2">
                        <h1 class="text-center">/</h1>
                    </div>
                    <div class="span5">
                        <h1 id="lblNroFactCalculadas" class="text-center">0</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="span5">
                        <h5 class="text-center">Propiedades encontradas</h5>
                    </div>
                    <div class="span2"></div>
                    <div class="span5">
                        <h5 id="lblInfoGenPDF_Facturacion" class="text-center">Facturas generadas</h5>
                    </div>
                </div>
                <div class="row">
                    <div id="pbProgresoIndividual_Facturacion" class="progress-bar large" data-role="progress-bar" data-value="0"></div>
                </div>
                <div class="row">
                    <h5 class="text-center"><strong id="lblDesProgIndividual_Facturacion">Enviando factura </strong><strong id="lblDescripFactura_Facturacion"></strong></h5>
                </div>
                <div class="row">
                    <div id="pbProgresoTotal_Facturacion" class="progress-bar large" data-role="progress-bar" data-value="0"></div>
                </div>
                <div class="row">
                    <h5 class="text-center"><strong id="lblDesPorcjEnvio_Facturacion">Envio </strong><strong id="lblPorcentajeEnvio_Facturacion"></strong>% completado.</h5>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnFinalizarEnvio_Facturacion" type="button" class="command-button mode-add success oculto">Finalizar</button>
                        <button id="btnCancelarEnvio_Facturacion" type="button" class="command-button mode-add warning">Cancelar env&iacute;o</button>
                    </div>
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
    <div id="modalDivision" class="modal-dialog-x modaldos modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Divisi&oacute;n de factura
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span6">
                                <h3 id="lblNroPropiedad" data-idfacturacion="0" data-idpropiedad="0"></h3>
                            </div>
                            <div class="span3">
                                <h3 id="lblAnhoMesDiv"></h3>
                            </div>
                            <div class="span3">
                                <label for="txtNroPropietarios">Nro de propietarios</label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtNroPropietarios" name="txtNroPropietarios" type="text" title="" value="2">
                                    <button class="btn-clear" type="button"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="tablePropietario" class="itables">
                        <div class="ihead">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Propietario</th>
                                        <th>Cant. D&iacute;as</th>
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
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnDividirFactura" type="button" class="command-button mode-add success">Dividir factura</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlSearchPropietario" data-tipofiltro="proyecto" class="top-panel" style="display:none;">
        <iframe id="ifrSearchPropietario" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
    </div>
    <div id="pnlImpresionFactura" class="top-panel inner-page" style="display:none;">
        <h1 class="title-window">
            <a href="#" id="btnHideImpresion" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
            Impresi&oacute;n de factura
        </h1>
        <div id="precargaCli" class="divload">
            <iframe id="ifrImpresionFactura" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
    <div id="modalUploadExcel" class="modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Importar datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row text-center">
                    <div class="droping-air mode-file">
                        <input type="file" class="file-import">
                        <div class="help">
                            Seleccione o arrastre un archivo de Excel
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div id="pbUploadExcel" class="progress-bar large" data-role="progress-bar" data-value="0" data-color="bg-cyan"></div> -->
                    <div class="custom_progress_outer">
                        <div id="pbUploadExcel" class="custom_progress">
                            <div class="custom_progress_text">0 %</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnSubirDatos" type="button" disabled="" class="command-button disabled">Iniciar subida</button>
                    </div>
                    <div class="span6">
                        <button id="btnCancelarSubida" type="button" class="command-button danger">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalIngresoFechasConsumo" class="modal-dialog-x modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Ingresar fechas
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="txtFechaIniConsumo" class="control-label">Fecha de inicio</label>
                        <div class="">
                            <input id="txtFechaIniConsumo" name="txtFechaIniConsumo" class="form-control" type="text" title="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="txtFechaFinConsumo" class="control-label">Fecha final</label>
                        <input id="txtFechaFinConsumo" name="txtFechaFinConsumo" class="form-control" type="text" title="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer padding10">
            <button id="btnIngresarFechasConsumo" type="button" class="btn btn-primary right">Aplicar fechas</button>
        </div>
    </div>
    <div id="modalConceptoVariableGen" class="modaluno modal-dialog-x modal-example-content">
        <input type="hidden" name="hdTotalConsumo_Gen" id="hdTotalConsumo_Gen" value="0">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Generaci&oacute;n de concepto variable
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                    <h3><strong>Valor consumo: S/. </strong><span id="lblTotalConsumo_Gen"></span></h3>
                </div>
                <div class="row">
                    <label for="txtImporteSaldo">Importe facturado</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtImporteSaldo" name="txtImporteSaldo" type="text" placeholder="Ingrese importe a calcular" title="" value="0.00">
                        <button class="btn-clear" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span1"></div>
                    <div class="span10">
                        <button id="btnGenerarConceptoVariable" type="button" class="command-button mode-add success">Calcular concepto de agua variable</button>
                    </div>
                    <div class="span1"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script>
<script src="dist/js/app/process/facturacion-script.js"></script>