<?php
include 'common/config-mail.php';
$para = (isset($_GET['para'])) ? $_GET['para'] : '';
?>
<form id="form1" name="form1" method="post">
	<input type="hidden" name="hdUsuario" id="hdUsuario" value="<?php echo $login; ?>">
    <div class="page-region without-appbar">
		<div class="generic-panel gp-no-header">
			<div class="gp-body">
				<div class="scrollbarra">
					<div class="grid fluid padding10">
						<div class="row">
							<div class="span6">
								<label for="txtDe">De</label>
				                <div class="input-control text" data-role="input-control">
				                    <input id="txtDe" name="txtDe" type="text" placeholder="Ingrese remitente" value="<?php echo $email_Default; ?>">
				                    <button class="btn-clear" tabindex="-1" type="button"></button>
				                </div>
							</div>
							<div class="span6">
								<label for="txtPara">Para</label>
				                <div class="input-control text" data-role="input-control">
				                    <input id="txtPara" name="txtPara" type="text" placeholder="Ingrese destinatario" value="<?php echo $para; ?>">
				                    <button class="btn-clear" tabindex="-1" type="button"></button>
				                </div>
							</div>
						</div>
						<div class="row">
							<div class="span6">
								<label for="txtAsunto">Asunto</label>
				                <div class="input-control text" data-role="input-control">
				                    <input id="txtAsunto" name="txtAsunto" type="text" placeholder="Ingrese asunto del correo" value="">
				                    <button class="btn-clear" tabindex="-1" type="button"></button>
				                </div>
							</div>
							<div class="span6">
								<label for="ddlPlantilla">Plantilla</label>
		                        <div class="input-control select fa-caret-down" data-role="input-control">
		                            <select id="ddlPlantilla" name="ddlPlantilla">
		                            	<option value="0">Ninguna</option>
		                            </select>
		                        </div>
							</div>
						</div>
						<div class="row">
							<div class="span12">
								<textarea id="txtEstructura" name="txtEstructura" placeholder="">
				                </textarea>
							</div>
						</div>
						<div class="row">
							<div class="span12">
								<h4>Archivos adjuntos</h4>
								<div id="attach-files" class="mini-list">
									No se han adjuntado archivos
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="gp-footer">
				<div class="grid fluid">
					<div class="row padding10">
						<div class="span6"></div>
						<div class="span3">
							<button id="btnShowFiles" type="button" class="command-button mode-add default">Archivos</button>
						</div>
						<div class="span3">
							<button id="btnEnviarEmail" type="button" class="command-button mode-add success">Enviar correo</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="pnlFiles" class="top-panel with-appbar inner-page with-mini-title-window" style="display:none;">
	        <h2 class="mini-title-window">
	            <a href="#" id="btnHideFiles" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
	            Archivos
	            <button class="btn-header float-right" type="button" data-tipo="documents"><?php $translate->__('Documentos'); ?></button>
                <button class="btn-header float-right success" type="button" data-tipo="media"><?php $translate->__('Im&aacute;genes'); ?></button>
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
	        	<button id="btnAttachFiles" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Adjuntar a correo">
	                <h2><i class="icon-attachment"></i></h2>
	            </button>
	            <button id="btnInsertFiles" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Insertar a texto">
	                <h2><i class="icon-checkmark"></i></h2>
	            </button>
	            <button id="btnClearSelect" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Limpiar selecci&oacute;n">
	                <h2><i class="icon-undo"></i></h2>
	            </button>
	            <button id="btnSelectAll" type="button" class="metro_button float-left" data-hint-position="top" title="Seleccionar todos">
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
<script src="scripts/tinymce/tinymce.min.js"></script>
<script src="dist/js/app/admin/email-script.min.js"></script>