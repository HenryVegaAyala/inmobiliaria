<?php
$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : 'listado';
?>
<input type="hidden" name="hdIdProyecto" id="hdIdProyecto" value="0">
<input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
<input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />
<div class="generic-panel <?php echo ($screenmode == 'propietario' ? 'gp-no-footer' : ''); ?>">
    <div class="gp-header padding10">
        <div class="input-control text" data-role="input-control">
            <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
            <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
        </div>
    </div>
    <div class="gp-body">
        <div id="tableDocumentos" class="itables">
            <div class="ihead">
                <table>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Enlace</th>
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
    <?php if ($screenmode != 'propietario'): ?>
    <div class="gp-footer">
        <div class="appbar">
            <button id="btnImportarArchivos" name="btnImportarArchivos" type="button" class="metro_button float-right" title="Eliminar Proyecto">
                <h2><i class="icon-upload"></i></h2>
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>
<div id="modalUploadExcel" class="modal-dialog-x modal-example-content">
    <input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
    <input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />
    <input type="hidden" name="hdEstado_proceso" id="hdEstado_proceso" value="0">
    <div class="modal-example-header">
        <h2 class="no-margin b-hide">
            <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
            Importar archivos
        </h2>
    </div>
    <div class="modal-example-body">
        <div class="grid">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <select id="ddlProceso" name="ddlProceso" class="form-control full-size">
                        <option value="0">NO SE ENCONTRARON PROCESOS RELACIONADOS AL PROYECTO SELECCIONADO</option>
                    </select>
                </div>
                <div class="gp-body">
                    <div class="row text-center">
                        <div class="droping-air mode-file">
                            <input type="file" class="file-import">
                            <div class="help">
                                Seleccione o arrastre un archivo
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="progress-bar large" data-role="progress-bar" data-value="0" data-color="bg-cyan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-example-footer">
        <div class="grid fluid">
            <div class="row">
                <div class="span6">
                    <button id="btnSubirDatos" type="button" disabled="" class="command-button disabled">Iniciar subida</button>
                </div>
                <div class="span6">
                    <button id="btnCancelarSubida" type="button" class="command-button danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="dist/js/app/reports/archivos-script.js"></script>