<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Procesar Facturaci&oacute;n
            </h1>
            <div class="divContent">
            	<div class="grid padding10">
                    <div class="row">
                        <label for="ddlCondominio">Condominio</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlCondominio" name="ddlCondominio">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span6">
                                    <label for="ddAnho">A&ntilde;o</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddAnho" name="ddAnho">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="span6">
                                    <label for="ddlMes">Mes</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddlMes" name="ddlMes">
                                            
                                        </select>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span6"><button id="btnGenerarFacturacion" name="btnGenerarFacturacion" class="command-button success">Generar Facturaci&oacute;n</button></div>
                                <div class="span6"><button id="btnDetallesFacturacion" name="btnDetallesFacturacion" class="command-button success">Detalles de Facturaci&oacute;n</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>