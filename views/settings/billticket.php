<form id="form1" name="form1" method="post" action="services/tipocomprobante/tipocomprobante-post.php">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="generic-panel gp-no-header">
        <div class="gp-body">
            <div class="scrollbarra padding10">
                <div id="gvDatos" class="listview"></div>
            </div>            
        </div>
        <div class="gp-footer">
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-undo"></i></h2>
                </button>
            </div>
        </div>
    </div>
    <div id="modalRegistro" class="modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNombre"><?php $translate->__('Nombre'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row hide">
                    <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea id="txtDescripcion" name="txtDescripcion"></textarea>
                    </div>
                </div>
                <div class="row hide">
                    <label for="txtCodigoSunat"><?php $translate->__('COD SUNAT'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtCodigoSunat" name="txtCodigoSunat" type="text" placeholder="Ingrese c&oacute;digo SUNAT" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row hide">
                    <label for="txtAbreviatura"><?php $translate->__('Abreviatura'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAbreviatura" name="txtAbreviatura" type="text" placeholder="Ingrese abreviatura" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6 right">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6 hide">
                        <button id="btnLimpiar" type="button" class="command-button mode-add default">Limpiar</button>
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
<script src="dist/js/app/settings/tipocomprobante-script.js"></script>