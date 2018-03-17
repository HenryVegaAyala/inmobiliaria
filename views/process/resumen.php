<?php
$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : 'listado';

if ($idperfil != '61'){
	require 'bussiness/propietario.php';
    $objPropietario = new clsPropietario();

    $idpropietario_user = $idpersona;

    $rowPropietario = $objPropietario->Listar('2', 0, 0, $idpersona, '', '', 1);
    $countPropietario = count($rowPropietario);
                
    if ($rowPropietario[0]['tm_iditc'] == 'NA') {
        $txtApePaterno = $rowPropietario[0]['tm_apepaterno'];
        $txtApeMaterno = $rowPropietario[0]['tm_apematerno'];
        $txtNombres = $rowPropietario[0]['tm_nombres'];

        $descripcion_propietario = $txtApePaterno . ' ' . $txtApeMaterno . ' ' . $txtNombres;
    }
    else {
        $txtRazonSocial = $rowPropietario[0]['tm_razsocial'];

        $descripcion_propietario = $txtRazonSocial;
    }

    $imgfoto = $rowPropietario[0]['tm_foto'] == 'no-set' ? 'dist/img/user2-160x160.jpg' : $rowPropietario[0]['tm_foto'];
}
?>
<input type="hidden" name="hdIdProyecto" id="hdIdProyecto" value="0">
<input type="hidden" name="hdIdPerfil" id="hdIdPerfil" value="<?php echo $idperfil; ?>">
<input type="hidden" name="hdIdPropietario" id="hdIdPropietario" value="<?php echo $idpersona; ?>">
<div id="pnlPropietarioGeneral" class="generic-panel gp-no-footer<?php echo $idperfil == '61' ? ' gp-no-header' : ''; ?>">
    <div class="gp-header<?php echo $idperfil == '61' ? ' hide' : ''; ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="pnlInfo" data-idpersona="<?php echo $idpersona; ?>" class="panel-info margin10" data-hint-position="top" title="">
                <div class="foto">
                  <img id="imgFoto" width="60" height="62" style="width: 60px; height: 62px;" src="<?php echo $imgfoto; ?>" />
                </div>
                <div class="info">
                    <h3 class="descripcion"><?php echo $descripcion_propietario; ?></h3>
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="gp-body">
    	<div id="pnlProceso" class="generic-panel">
	        <div class="gp-header">
	          <div class="row">
	          	<div class="col-md-5">
	          	<?php if ($idperfil == '61'): ?>
	              <label for="ddlPropiedad" class="control-label">Propiedad</label>
	              <select id="ddlPropiedad" name="ddlPropiedad" class="form-control full-size">
	                  <option value="0">SELECCIONE PROPIEDAD</option>
	              </select>
	          	<?php else: ?>
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
	          	<?php endif; ?>
	            
	            <div class="col-md-2">
	                <label for="ddlAnho">Año</label>
	                <div class="input-control select fa-caret-down" data-role="input-control">
	                    <select id="ddlAnho" name="ddlAnho">
	                        <option value="0">SELECCIONE PROYECTO</option>
	                    </select>
	                </div>
	            </div>
	            <?php if ($idperfil != '61'): ?>
	            <div class="col-md-2">
	                <label for="ddlMes">Mes</label>
	                <div class="input-control select fa-caret-down" data-role="input-control">
	                    <select id="ddlMes" name="ddlMes">
	                        <?php ListarMeses(); ?>
	                    </select>
	                </div>
	            </div>
	            <?php endif; ?>
	            <div class="col-md-3">
	            	<button id="btnConsultar" class="btn btn-primary margin20 center-block" type="button"><?php $translate->__('Consultar'); ?></button>
	            </div>
	          </div>
	        </div>
	        <div class="gp-body">
		    	<div id="tableDetalle" class="itables">
		            <div class="ihead">
		                <table>
		                    <thead>
		                        <tr>
		                            <th><?php echo ($idperfil == '61') ? 'Mes' : 'Propiedad' ?></th>
		                            <th>Facturado</th>
		                            <th>Cobrado</th>
		                            <th>Saldo</th>
		                            <th>% Saldo</th>
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
	        	<div class="row col-md-8 float-right">
	        		<div class="col-md-4">
	        			<label>Total Facturado</label>
	        			<div class="col-md-2 padding5">
                            <h3 class="no-margin">S/.</h3>
                        </div>
                        <div class="col-md-8 padding5">
                            <h3 class="no-margin text-right" id="lblTotalFacturado">0.00</h3>
                        </div>
	        		</div>
	        		<div class="col-md-4">
	        			<label>Total Cobrado</label>
	        			<div class="col-md-2 padding5">
                            <h3 class="no-margin">S/.</h3>
                        </div>
                        <div class="col-md-8 padding5">
                            <h3 class="no-margin text-right" id="lblTotalCobrado">0.00</h3>
                        </div>
	        		</div>
	        		<div class="col-md-4">
	        			<label>Total Saldo</label>
	        			<div class="col-md-2 padding5">
                            <h3 class="no-margin">S/.</h3>
                        </div>
                        <div class="col-md-8 padding5">
                            <h3 class="no-margin text-right" id="lblTotalSaldo">0.00</h3>
                        </div>
	        		</div>
	        	</div>
	        </div>
	    </div>
    </div>
</div>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="dist/js/app/process/resumen-script.js"></script>