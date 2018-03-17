<?php
include('bussiness/propietario.php');

$objPropietario = new clsPropietario();

$nombrepropietario = '';

$rowPropietario = $objPropietario->Listar('2', 1, 1, $idpersona, '', '', 1);
$countRowPropietario = count($rowPropietario);

if ($countRowPropietario > 0){
	$nombrepropietario = $rowPropietario[0]['descripcion'];
}
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="<?php echo $idpersona; ?>" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPagePropietario" name="hdPagePropietario" value="1">
    <input type="hidden" id="hdPageGenFacturacion" name="hdPageGenFacturacion" value="1" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Estados de cuenta
            </h1>
            <div class="divContent">
            	<div class="grid">
            		<div class="row">
                        <div id="pnlFiltroProyecto" data-tipofiltro="filtroproyecto" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                            <div class="info">
                                <h3 class="descripcion">Proyecto</h3>
                            </div>
                        </div>
                    </div>
            		<div class="row">
            			<div class="grid fluid">
            				<div class="row">
            					<div class="span4">
            						<h2>Resumen de cuenta - Proyecto <span id="lblProyecto"></span></h2>
            					</div>
            					<div class="span8">
            						<div class="grid">
            							<div class="row">
					            			<div class="span2">
					                            <label for="ddlAnhoIni">A&ntilde;o Inicio</label>
					                            <div class="input-control select fa-caret-down" data-role="input-control">
					                                <select id="ddlAnhoIni" name="ddlAnhoIni">
					                                </select>
					                            </div>
					                        </div>
					                        <div class="span2">
					                            <label for="ddlMesIni">Mes Inicio</label>
					                            <div class="input-control select fa-caret-down" data-role="input-control">
					                                <select id="ddlMesIni" name="ddlMesIni">
					                                    <?php ListarMeses($mesini); ?>
					                                </select>
					                            </div>
					                        </div>
					                        <div class="span2">
					                            <label for="ddlAnhoFin">A&ntilde;o Fin</label>
					                            <div class="input-control select fa-caret-down" data-role="input-control">
					                                <select id="ddlAnhoFin" name="ddlAnhoFin">
					                                </select>
					                            </div>
					                        </div>
					                        <div class="span2">
					                            <label for="ddlMesFin">Mes Fin</label>
					                            <div class="input-control select fa-caret-down" data-role="input-control">
					                                <select id="ddlMesFin" name="ddlMesFin">
					                                    <?php ListarMeses($mesfin); ?>
					                                </select>
					                            </div>
					                        </div>
					                        <div class="span2">
					                        	<button id="btnBuscar" type="button" class="command-button mode-add success">Buscar</button>
					                        </div>
            							</div>
            						</div>
            					</div>
            				</div>
            			</div>
            		</div>
            		<div class="row">
		            	<div style="height: 160px;">
		            		<div id="tableResumenProyecto" class="itables with-border">
			                    <div class="ihead">
			                        <table>
			                            <thead>
			                                <tr>
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
            		<div class="row">
            			<h2>Detalle de cuenta - Propietario <span id="lblPropietario"><?php echo $nombrepropietario; ?></span></h2>
            		</div>
            		<div class="row">
		            	<div style="height: 350px;">
		            		<div id="tableResumenPropietario" class="itables with-border">
			                    <div class="ihead">
			                        <table>
			                            <thead>
			                                <tr>
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
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>
<script src="dist/js/app/process/estadocuenta-script.min.js"></script>