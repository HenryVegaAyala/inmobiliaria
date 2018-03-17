<form id="form1" name="form1" method="post">
	<div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window hide">
            	<a id="btnShowMenu" href="#" title="<?php $translate->__('Regresar a calendario'); ?>" class="back-button"><i class="icon-lines fg-darker smaller"></i>
                </a>
                <?php $translate->__('Reporte: '); ?><span class="titulo-reporte">Ventas</span>
            </h1>
            <div class="divContent">
            	<div class="panels">
					<iframe data-tab="tab1" src="?pag=reports&subpag=ventas" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>
				</div>
            </div>
        </div>
    </div>
	<div id="pnlMenu" class="panelOptions">
		<div class="generic-panel gp-no-footer">
			<div class="gp-header">
				<h2 class="title-window">
					<a id="btnHideMenu" href="#" title="<?php $translate->__('Regresar a calendario'); ?>" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i>
		            </a>
					<?php $translate->__('Reportes disponibles'); ?>
				</h2>
			</div>
			<div class="gp-body">
				<div class="links-config">
					<ul>
						<li><a data-tab="tab1" href="?pag=reports&subpag=ventas" class="active"><h2><?php $translate->__('Ventas'); ?></h2></a></li>
						<li><a data-tab="tab2" href="?pag=reports&subpag=compras"><h2><?php $translate->__('Compras'); ?></h2></a></li>
						<li><a data-tab="tab3" href="?pag=reports&subpag=productos"><h2><?php $translate->__('Articulos'); ?></h2></a></li>
						<li><a data-tab="tab3" href="?pag=reports&subpag=clientes"><h2><?php $translate->__('Clientes'); ?></h2></a></li>
						<li><a data-tab="tab3" href="?pag=reports&subpag=personal"><h2><?php $translate->__('Personal'); ?></h2></a></li>
						<li><a data-tab="tab3" href="?pag=reports&subpag=proveedores"><h2><?php $translate->__('Proveedores'); ?></h2></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>

<?php
include('common/libraries-js.php');
?>
<script>
	$(document).ready(function(){
		$('.links-config ul').on('click', 'a', function () {
			$('.links-config a').removeClass('active');
			$(this).addClass('active');
			navigateInFrame(this);
			return false;
		});

		$('#btnShowMenu').on('click', function(event) {
			event.preventDefault();
			toggleOptions('#pnlMenu', true);
		});

		$('#btnHideMenu').on('click', function(event) {
			event.preventDefault();
			toggleOptions('#pnlMenu', false);
		});
	});
	function navigateInFrame (alink) {
		var url = alink.getAttribute('href');
		var tab = alink.getAttribute('data-tab');
		var iframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';
		$('.panels iframe').hide();
		if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0){
			$(iframe).appendTo('.panels').load(function () {
				blockLoadWin(false);
                $(this).contents().find("body, body *").on('click', function(event) {
                    window.top.hideAllSlidePanels();
                });
			});
		}
		else
			$('.panels > iframe[data-tab="' + tab + '"]').show();

		$('.titulo-reporte').text($(alink).find('h2').text());
		toggleOptions('#pnlMenu', false);
	}
</script>