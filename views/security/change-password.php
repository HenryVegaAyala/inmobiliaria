
<form id="form1" name="form1" method="post">

	<div id="password_modal">
	    <div class="modal-header">
	        <h3>Cambiar contrase&ntilde;a <span class="extra-title muted"></span></h3>
	    </div>
	    <div class="modal-body form-horizontal">
	        <div class="control-group">
	            <label for="current_password" class="control-label">Contrase&ntilde;a actual</label>
	            <div class="controls">
	                <input type="password" name="current_password" id="current_password">
	            </div>
	        </div>
	        <div class="control-group">
	            <label for="new_password" class="control-label">Nueva contrase&ntilde;a</label>
	            <div class="controls">
	                <input type="password" name="new_password" id="new_password">
	            </div>
	        </div>
	        <div class="control-group">
	            <label for="confirm_password" class="control-label">Confirmar contrase&ntilde;a</label>
	            <div class="controls">
	                <input type="password" name="confirm_password" id="confirm_password">
	            </div>
	        </div>      
	    </div>
	    <div class="modal-footer">
	        <button class="btn btn-primary" id="password_modal_save">Cambiar clave</button>
	    </div>
	</div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="dist/js/app/security/change_password-script.js"></script>