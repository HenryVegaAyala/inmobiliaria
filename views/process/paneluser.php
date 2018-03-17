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
<div class="maincontent">
  <input type="hidden" name="hdIdProyecto" id="hdIdProyecto" value="0">
  <input type="hidden" name="hdIdPersona" id="hdIdPersona" value="<?php echo $idpersona; ?>">
  <div id="pnlPropietarioGeneral" class="generic-panel gp-no-footer">
    <div class="gp-header">
        <div class="row">
          <div class="col-md-6">
            <div id="pnlInfoPersona" data-idpersona="0" class="panel-info margin10" data-hint-position="top" title="">
                <div class="foto">
                  <img id="imgFoto" width="60" height="62" style="width: 60px; height: 62px;" src="dist/img/user2-160x160.jpg" />
                </div>
                <div class="info">
                    <h3 class="descripcion"></h3>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="pnlInfoProyecto" data-idproyecto="0" class="panel-info margin10" data-hint-position="top" title="">
              <div class="info">
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="gp-body">
      <div id="pnlProceso" class="generic-panel gp-no-footer">
        <div class="gp-header">
          <div class="row">
            <div class="col-md-6">
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
                  <option data-logo="<?php echo $rowProyecto[$i]['logo']; ?>" value="<?php echo $rowProyecto[$i]['idproyecto']; ?>">
                      <?php echo $rowProyecto[$i]['nombreproyecto']; ?>
                  </option>
                  <?php
                  endfor;
                  ?>
              </select>
            </div>
            <div class="col-md-3">
                <label for="ddlAnho">Año</label>
                <div class="input-control select fa-caret-down" data-role="input-control">
                    <select id="ddlAnho" name="ddlAnho">
                        <option value="0">SELECCIONE PROYECTO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
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
          <div class="row no-margin" style="height: 250px;">
            <div class="col-md-6 no-padding all-height">
              <div id="pnlListPropiedades" class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                           <div class="input-group">
                              <input type="text" id="txtSearchPropiedad" name="txtSearchPropiedad" class="form-control" placeholder="Buscar propiedades ...">
                              <span class="input-group-btn">
                                <button id="btnSearchPropiedad" name="btnSearchPropiedad" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                  <div id="gvGenFacturacion" class="scrollbarra">
                      <div class="items-area tile-area gridview padding5">
                          
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 no-padding all-height">
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
                                <th colspan="2">Importe</th>
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
          </div>
          <div id="pnlRecibo" class="row">
            <div class="pos-rel all-height">
              <h1 id="reciboDefault" class="centered padding50 blue white-text text-center">En esa secci&oacute;n se mostrar&aacute; el detalle de recibo</h1>
              <div id="pnlImpresionFactura" class="inner-page" style="display:none;">
                <h1 class="title-window">
                    Vista de factura
                </h1>
                <div id="precargaCli" class="divload">
                    <iframe id="ifrImpresionFactura" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>