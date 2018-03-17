<?php
include('bussiness/tabla.php');

$objTabla = new clsTabla();

$counterTipoReporte = 0;
$counterTipoConcepto = 0;
$counterTipoPropiedad = 0;
$counterTipoPropietario = 0;

$rowTipoReporte = $objTabla->ValorPorCampo('ta_tiporeporte');
$countRowTipoReporte = count($rowTipoReporte);

$rowTipoConcepto = $objTabla->ValorPorCampo('ta_tipoconcepto');
$countRowTipoConcepto = count($rowTipoConcepto);

$rowTipoPropiedad = $objTabla->ValorPorCampo('ta_tipopropiedad');
$countRowTipoPropiedad = count($rowTipoPropiedad);

$rowTipoPropietario = $objTabla->ValorExcluido('ta_tipopersona', '00,01,02,03');
$countRowTipoPropietario = count($rowTipoPropietario);

$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : 'listado';
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0" />
    <input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
    <input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />
    <input type="hidden" id="hdTipoReporte" name="hdTipoReporte" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <div class="page-region">
        <div id="pnlListado" class="inner-page">
            <div class="row all-height">
                <ul class="col-md-2 all-height grey darken-4 sidebar-menu no-margin">
                    <li class="active bg-dark"><a href="#reportes"><i class="icon-equalizer"></i> <span>Reportes</span></a></li>
                    <li class=""><a href="#documentos"><i class="icon-file"></i> <span>Documentos</span></a></li>
                </ul><!-- /.sidebar-menu -->
                <section class="col-md-10 all-height">
                    <div id="reportes" class="xpanel all-height">
                        <div class="generic-panel gp-no-header">
                            <div class="gp-body">
                                <div class="scrollbarra">
                                    <div class="grid padding10">
                                        <div id="pnlFiltros" class="grid fluid">
                                            <h2>Datos generales del reporte</h2>
                                            <?php if ($screenmode == 'propietario'): ?>
                                            <div class="row">
                                              <label for="ddlProyecto" class="control-label">Proyecto</label>
                                              <select id="ddlProyecto" name="ddlProyecto" class="form-control full-size">
                                                  <option value="0">SELECCIONE PROYECTO</option>
                                                  <?php
                                                  include 'bussiness/condominio.php';

                                                  $objProyecto = new clsProyecto();

                                                  $rowProyecto = $objProyecto->ListarPorPropietario($idpersona);
                                                  $countProyecto = count($rowProyecto);
                                                  ?>
                                                  <?php
                                                  for ($i=0; $i < $countProyecto; $i++):
                                                  ?>
                                                  <option <?php echo $i==0?' selected':''; ?> data-logo="<?php echo $rowProyecto[$i]['logo']; ?>" value="<?php echo $rowProyecto[$i]['idproyecto']; ?>">
                                                      <?php echo $rowProyecto[$i]['nombreproyecto']; ?>
                                                  </option>
                                                  <?php
                                                  endfor;
                                                  ?>
                                              </select>
                                            </div>
                                            <br>
                                            <?php endif; ?>
                                            <div class="row">
                                                <label for="ddlTipoReporte">Tipo de reporte</label>
                                                <div class="input-control select fa-caret-down" data-role="input-control">
                                                    <select id="ddlTipoReporte" name="ddlTipoReporte">
                                                        <?php
                                                        for ($counterTipoReporte=0; $counterTipoReporte < $countRowTipoReporte; $counterTipoReporte++):
                                                        ?>
                                                        <option value="<?php echo $rowTipoReporte[$counterTipoReporte]['ta_codigo']; ?>">
                                                            <?php $translate->__($rowTipoReporte[$counterTipoReporte]['ta_denominacion']); ?>
                                                        </option>
                                                        <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="rowFechaSimple" class="row">
                                                <div class="span2">
                                                    <label for="ddlAnho">A&ntilde;o</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlAnho" name="ddlAnho">
                                                            <option value="0">SELECCIONE PROYECTO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <label for="ddlMes">Mes</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlMes" name="ddlMes">
                                                            <?php ListarMeses(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="rowFechaRango" class="row oculto">
                                                <div class="span2">
                                                    <label for="ddlAnhoIni">A&ntilde;o Inicio</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlAnhoIni" name="ddlAnhoIni">
                                                            <option value="0">SELECCIONE PROYECTO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <label for="ddlMesIni">Mes Inicio</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlMesIni" name="ddlMesIni">
                                                            <?php ListarMeses(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <label for="ddlAnhoFin">A&ntilde;o Fin</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlAnhoFin" name="ddlAnhoFin">
                                                            <option value="0">SELECCIONE PROYECTO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <label for="ddlMesFin">Mes Fin</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlMesFin" name="ddlMesFin">
                                                            <?php ListarMeses(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 id="lblTitleCustomFilter">Filtros personalizados</h2>
                                            <div id="rowConcepto" class="row">
                                                <div class="span4">
                                                    <label for="ddlTipoConcepto">Tipo de concepto</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlTipoConcepto" name="ddlTipoConcepto">
                                                            <option value="0">TODOS</option>
                                                            <?php
                                                            for ($counterTipoConcepto=0; $counterTipoConcepto < $countRowTipoConcepto; $counterTipoConcepto++):
                                                            ?>
                                                            <option value="<?php echo $rowTipoConcepto[$counterTipoConcepto]['ta_codigo']; ?>">
                                                                <?php $translate->__($rowTipoConcepto[$counterTipoConcepto]['ta_denominacion']); ?>
                                                            </option>
                                                            <?php
                                                            endfor;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span8">
                                                    <div id="pnlInfoConcepto" data-tipofiltro="concepto" class="panel-info without-foto" data-hint-position="top" title="Conceptos">
                                                        <div class="info">
                                                            <h3 class="descripcion">Conceptos</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="rowPropiedad" class="row oculto">
                                                <div class="span4">
                                                    <label for="ddlTipoPropiedad">Tipo de propiedad</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlTipoPropiedad" name="ddlTipoPropiedad">
                                                            <option value="0">TODOS</option>
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
                                                <div class="span8">
                                                    <div id="pnlInfoPropiedad" data-tipofiltro="propiedad" class="panel-info without-foto" data-hint-position="top" title="Propiedades">
                                                        <div class="info">
                                                            <h3 class="descripcion">Propiedades</h3>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            <div id="rowPropietario" class="row oculto">
                                                <div class="span4">
                                                    <label for="ddlTipoPropietario">Tipo de propietario</label>
                                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                                        <select id="ddlTipoPropietario" name="ddlTipoPropietario">
                                                            <?php
                                                            for ($counterTipoPropietario=0; $counterTipoPropietario < $countRowTipoPropietario; $counterTipoPropietario++):
                                                            ?>
                                                            <option value="<?php echo $rowTipoPropietario[$counterTipoPropietario]['ta_codigo']; ?>">
                                                                <?php $translate->__($rowTipoPropietario[$counterTipoPropietario]['ta_denominacion']); ?>
                                                            </option>
                                                            <?php
                                                            endfor;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="span8">
                                                    <div id="pnlInfoPropietario" data-tipofiltro="propietario" class="panel-info without-foto" data-hint-position="top" title="Propietario">
                                                        <div class="info">
                                                            <h3 class="descripcion">Propietarios</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pnlAgrupacion" class="grid oculto fluid">
                                            <h2>Agrupaciones</h2>
                                            <div class="row">
                                                <div class="input-control select fa-caret-down" data-role="input-control">
                                                    <select id="ddlAgrupacion" name="ddlAgrupacion">
                                                        <option value="0">
                                                            NINGUNA
                                                        </option>
                                                        <?php
                                                        for ($counterTipoConcepto=0; $counterTipoConcepto < $countRowTipoConcepto; $counterTipoConcepto++):
                                                        ?>
                                                        <option value="<?php echo $rowTipoConcepto[$counterTipoConcepto]['ta_codigo']; ?>">
                                                            <?php $translate->__($rowTipoConcepto[$counterTipoConcepto]['ta_denominacion']); ?>
                                                        </option>
                                                        <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gp-footer">
                                <div class="appbar all-height">
                                    <button id="btnGenerarReporte" type="button" class="metro_button float-right" data-hint-position="top" title="Generar reporte">
                                        <h2><i class="icon-printer"></i></h2>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="documentos" class="xpanel all-height">
                        <iframe src="?pag=reports&subpag=archivos" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="pnlDatosFiltro" data-tipofiltro="proyecto" class="top-panel inner-page" style="display:none;">
        <h1 class="title-window">
            <a id="btnHideFiltro" href="#" title="Atr&aacute;s" class="btn btn-lg margin10 btn-primary">
                <i class="icon-arrow-left-3 white-text"></i>
            </a>
            <span id="txtTituloFiltro"></span>
            <div class="col-md-6 no-float margin10 place-top-right">
                <div class="input-group">
                  <input id="txtSearchFiltro" name="txtSearchFiltro" type="text" class="form-control fg-dark" placeholder="Buscar...">
                  <span class="input-group-btn">
                    <button id="btnSearchFiltro" class="btn btn-default" type="button">Buscar</button>
                  </span>
                </div><!-- /input-group -->
            </div>
        </h1>
        <div id="precargaCli" class="all-height" style="padding-top: 70px;">
            <div class="generic-panel gp-no-header">
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
    </div>
    <div id="pnlImpresionFactura" class="top-panel inner-page" style="display:none;">
        <h1 class="title-window">
            <a href="#" id="btnHideImpresion" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
            Impresi&oacute;n de reporte
        </h1>
        <div id="precargaCli" class="divload">
            <iframe id="ifrImpresionFactura" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="dist/js/app/reports/reporteador-script.js"></script>