<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageMdelo" name="hdPageMdelo" value="1" />
    <div class="page-region without-appbar">
        <div id="pnlModelo" class="inner-page with-panel-search with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Plantillas de mensaje
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input id="txtSearchModelo" name="txtSearchModelo" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearchModelo" name="btnSearchModelo" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="scrollbarra">
                    <div class="items-area tile-area gridview">
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Eliminar Proyecto">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Editar Proyecto">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right" data-hint-position="top" title="Nuevo Proyecto">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Limpiar selecci&oacute;n">
                    <h2><i class="icon-undo"></i></h2>
                </button>
            </div>
        </div>
    </div>
    <div id="pnlDatosFiltro" data-tipofiltro="proyecto" class="top-panel with-appbar inner-page with-panel-search" style="display:none;">
        <h1 class="title-window hide">
            <a href="#" id="btnHideFiltro" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            <span id="txtTituloFiltro"></span>
        </h1>
        <div class="panel-search">
            <div class="input-control text" data-role="input-control">
                <input type="text" id="txtSearchFiltro" name="txtSearchFiltro" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                <button id="btnSearchFiltro" type="button" class="btn-search" tabindex="-1"></button>
            </div>
        </div>
        <div id="precargaCli" class="divload">
            <div id="gvFiltro" class="scrollbarra">
                <div class="gridview"></div>
            </div>
        </div>
        <div class="appbar">
            <button id="btnAsignFilter" type="button" class="metro_button oculto float-right">
                <h2><i class="icon-checkmark"></i></h2>
            </button>
            <button id="btnClearFilter" type="button" class="metro_button oculto float-left">
                <h2><i class="icon-undo"></i></h2>
            </button>
            <button id="btnSelectAllFilter" type="button" class="metro_button float-left" data-tipofiltro="concepto" data-hint-position="top" title="Conceptos">
                <h2><i class="icon-checkbox"></i></h2>
            </button>
        </div>
    </div>
    <div id="modalModelo" class="modal-dialog-x modaldos modal-example-content without-footer">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Modelo
            </h2>
        </div>
        <div class="modal-example-body">
            <iframe id="ifrModelo" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>
<script src="dist/js/app/process/notificaciones-script.min.js"></script>