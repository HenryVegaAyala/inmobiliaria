<article id="pnlAccesosDirectos" class="generic-panel gp-no-footer">
	<header class="gp-header mdl-layout__header">
        <div class="mdl-layout__header-row">
			<div id="navAccesos" class="scrollbarra-x padding10">
				<a data-idmenu="1" data-modulo="none" data-submodulo="none" data-tab="tab1" href="?pag=admin&subpag=notificaciones" class="btn btn-success"><?php $translate->__('Plantillas de correo'); ?></a>
				<a data-idmenu="2" data-modulo="none" data-submodulo="none" data-tab="tab2" href="?pag=settings&subpag=documentos" class="btn btn-success"><?php $translate->__('Documentos de identidad'); ?></a>
				<a data-idmenu="3" data-modulo="none" data-submodulo="none" data-tab="tab3" href="?pag=settings&subpag=tipo-comprobante" class="btn btn-success"><?php $translate->__('Tipos de comprobante'); ?></a>
				<a data-idmenu="4" data-modulo="none" data-submodulo="none" data-tab="tab4" href="?pag=security&subpag=usuarios" class="btn btn-primary"><?php $translate->__('Usuarios y perfiles'); ?></a>
				<a data-idmenu="5" data-modulo="none" data-submodulo="none" data-tab="tab5" href="?pag=settings&subpag=bancos" class="btn btn-primary"><?php $translate->__('Bancos'); ?></a>
				<a data-idmenu="6" data-modulo="none" data-submodulo="none" data-tab="tab6" href="?pag=settings&subpag=cuentabancaria" class="btn btn-primary"><?php $translate->__('Cuenta bancaria'); ?></a>
			</div>
		</div>
	</header>
	<section class="gp-body">
		<div class="panels"></div>
	</section>
</article>
<?php
include('common/libraries-js.php');
?>
<script src="dist/js/app/settings/settings-script.js"></script>