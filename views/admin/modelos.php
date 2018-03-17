<?php
require 'bussiness/modelocarta.php';

$objModeloCarta = new clsModeloCarta();

$idmodelocarta = (isset($_GET['idmodelocarta'])) ? $_GET['idmodelocarta'] : '0';

$row = $objModeloCarta->Listar('2', $idmodelocarta, '', 1);

$nombremodelo = '';
$contenido = '';

if (count($row) > 0){
	$nombremodelo = $row[0]['nombre'];
	$contenido = $row[0]['contenido'];
}
?>
<form id="form1" name="form1" method="post">
	<input type="hidden" name="hdUsuario" id="hdUsuario" value="<?php echo $login; ?>">
    <div class="page-region without-appbar">
		<div id="pnlNuevoModelo" class="generic-panel">
			<input type="hidden" name="hdIdPrimary" id="hdIdPrimary" value="<?php echo $idmodelocarta; ?>">
			<div class="gp-header">
				<div class="grid fluid">
					<div class="row padding10">
						<div class="span6">
							<label for="txtNombreModelo">Nombre de plantilla</label>
			                <div class="input-control text" data-role="input-control">
			                    <input id="txtNombreModelo" name="txtNombreModelo" type="text" placeholder="Ingrese nombre de plantilla" value="<?php echo $nombremodelo; ?>">
			                    <button class="btn-clear" tabindex="-1" type="button"></button>
			                </div>
						</div>
						<div class="span4">
							<label for="ddlTerminos">Terminos</label>
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlTerminos" name="ddlTerminos">
                                    <option value=":Propiedad:">Propiedad</option>
			                        <option value=":ApeNom:">Apellidos y nombres</option>
			                        <option value=":FechaHoy:">Fecha de hoy</option>
			                        <option value=":MesProyecto:">Mes de proyecto</option>
			                        <option value=":FechaEmision:">Fecha de emisi&oacute;n</option>
                                </select>
                            </div>
						</div>
						<div class="span2">
							<button id="btnAddTermino" type="button" class="command-button mode-add success">Agregar termino</button>
						</div>
					</div>
				</div>
			</div>
			<div class="gp-body">
				<textarea id="txtEstructura" name="txtEstructura" placeholder="">
					<?php echo $contenido; ?>
                </textarea>
			</div>
			<div class="gp-footer">
				<div class="grid fluid">
					<div class="row padding10">
						<div class="span6"></div>
						<div class="span3">
							<button id="btnShowFiles" type="button" class="command-button mode-add default">Archivos</button>
						</div>
						<div class="span3">
							<button id="btnGuardarModelo" type="button" class="command-button mode-add success">Guardar plantilla</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="pnlFiles" class="top-panel with-appbar inner-page with-mini-title-window" style="display:none;">
	        <h2 class="mini-title-window">
	            <a href="#" id="btnHideFiles" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
	            Archivos
	        </h2>
	        <div class="divload">
	        	<div id="moduloFiles" class="moduloTwoPanel">
		            <div class="colTwoPanel1">
	            		<iframe id="ifrFiles" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
	            	</div>
	            	<div class="colTwoPanel2">
	            		<div id="gvFiles" class="scrollbarra">
			                <div class="gridview tile-area"></div>
			            </div>
	            	</div>
            	</div>
	        </div>
	        <div class="appbar">
	            <button id="btnInsertFiles" type="button" class="metro_button oculto float-right">
	                <h2><i class="icon-checkmark"></i></h2>
	            </button>
	            <button id="btnClearSelect" type="button" class="metro_button oculto float-left">
	                <h2><i class="icon-undo"></i></h2>
	            </button>
	            <button id="btnSelectAll" type="button" class="metro_button float-left" data-tipofiltro="concepto" data-hint-position="top" title="Conceptos">
	                <h2><i class="icon-checkbox"></i></h2>
	            </button>
	        </div>
	    </div>
	</div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="dist/js/app/admin/modelocarta-script.min.js"></script>