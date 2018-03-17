<?php
include('bussiness/tabla.php');

$objTabla = new clsTabla();

$counterTipoConcepto = 0;
$counterTipoValor = 0;

$rowTipoConcepto = $objTabla->ValorPorCampo('ta_tipoconcepto');
$countRowTipoConcepto = count($rowTipoConcepto);

$rowTipoValor = $objTabla->ValorPorCampo('ta_tipovalor');
$countRowTipoValor = count($rowTipoValor);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdPageConcepto" name="hdPageConcepto" value="1" />
    <input type="hidden" id="hdPageConceptoFormula" name="hdPageConceptoFormula" value="1" />
    <input type="hidden" id="hdPageProyecto" name="hdPageProyecto" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Conceptos
            </h1>
            <div class="panel-search">
                <div class="grid fluid">
                    <div class="row" style="padding: 5px 0;">
                        <div id="pnlFiltroProyecto" data-tipofiltro="filtroproyecto" data-tiposeleccion="registro" data-idproyecto="0" class="panel-info without-foto hide" data-hint-position="top" title="Proyecto">
                            <div class="info">
                                <h3 class="descripcion">Proyecto</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span4">
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlTipoConceptoMainFilter" name="ddlTipoConceptoMainFilter">
                                    <?php
                                    for ($counterTipoConcepto=0; $counterTipoConcepto < $countRowTipoConcepto; $counterTipoConcepto++):
                                    ?>
                                    <option value="<?php echo $rowTipoConcepto[$counterTipoConcepto]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoConcepto[$counterTipoConcepto]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="scrollbarra">
                    <div class="items-area listview gridview">
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right" data-hint-position="top" title="Editar">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnUploadExcel" type="button" class="metro_button float-right">
                    <h2><i class="icon-upload-2"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <button id="btnSelectAll" type="button" class="metro_button float-left" data-hint-position="top" title="Seleccionar todo">
                    <h2><i class="icon-checkbox"></i></h2>
                </button>
            </div>
        </div>
    </div>
    <div id="modalRegistroConcepto" class="modal-nomodal modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de Concepto
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row hide">
                    <div id="pnlInfoProyecto" data-idproyecto="0" class="panel-info without-foto" data-hint-position="top" title="Proyecto">
                        <div class="info">
                            <h3 class="descripcion">Proyecto</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span6">
                        <label for="ddlTipoConcepto">Tipo de concepto</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlTipoConcepto" name="ddlTipoConcepto">
                                <?php
                                for ($counterTipoConcepto=0; $counterTipoConcepto < $countRowTipoConcepto; $counterTipoConcepto++):
                                ?>
                                <option value="<?php echo $rowTipoConcepto[$counterTipoConcepto]['ta_codigo']; ?>">
                                    <?php $translate->__($rowTipoConcepto[$counterTipoConcepto]['ta_denominacion']); ?>
                                </option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="ddlSubTipoConcepto">Sub-tipo de concepto</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlSubTipoConcepto" name="ddlSubTipoConcepto">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="txtNombreConcepto">Nombre Concepto</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombreConcepto" name="txtNombreConcepto" type="text" placeholder="Ingrese nombre del concepto" title="">
                        <button class="btn-clear" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtTituloConcepto">T&iacute;tulo en reportes</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtTituloConcepto" name="txtTituloConcepto" type="text" placeholder="Ingrese T&iacute;tulo" title="">
                        <button class="btn-clear" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="span2">
                        <label for="ddlTipoValor">Tipo de valor/resultado</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlTipoValor" name="ddlTipoValor">
                                <?php
                                for ($counterTipoValor=0; $counterTipoValor < $countRowTipoValor; $counterTipoValor++):
                                ?>
                                <option value="<?php echo $rowTipoValor[$counterTipoValor]['ta_codigo']; ?>">
                                    <?php $translate->__($rowTipoValor[$counterTipoValor]['ta_denominacion']); ?>
                                </option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="campoCaracter" class="span2">
                        <label id="lblCantidadCaracter" for="txtCantidadCaracter">Cantidad de caracteres</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtCantidadCaracter" name="txtCantidadCaracter" type="text" placeholder="0" title="" value="0">
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div id="campoAscensor" class="left margin10 text-center" style="width: 120px;">
                        <label for="chkAscensor">Ascensor</label>
                        <div class="input-control switch" data-role="input-control">
                            <label>
                                <span id="helperAscensor">NO</span>
                                <input id="chkAscensor" name="chkAscensor" type="checkbox" value="1">
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                    <div class="left margin10 text-center" style="width: 120px;">
                        <label for="chkFormula">F&oacute;rmula</label>
                        <div class="input-control switch" data-role="input-control">
                            <label>
                                <span id="helperFormula">NO</span>
                                <input id="chkFormula" name="chkFormula" type="checkbox" value="1">
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                    <div id="campoEscalonable" class="left margin10 text-center" style="width: 120px;">
                        <label for="chkEscalonable">Escalonable</label>
                        <div class="input-control switch" data-role="input-control">
                            <label>
                                <span id="helperEscalonable">NO</span>
                                <input id="chkEscalonable" name="chkEscalonable" type="checkbox" value="1">
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                    <div id="campoSaldoAnterior" class="left margin10 text-center" style="width: 120px;">
                        <label for="chkSaldoAnterior">Saldo Anterior</label>
                        <div class="input-control switch" data-role="input-control">
                            <label>
                                <span id="helperSaldoAnterior">NO</span>
                                <input id="chkSaldoAnterior" name="chkSaldoAnterior" type="checkbox" value="1">
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                    <div id="campoConceptoConsumoAgua" class="left margin10 text-center" style="width: 120px;">
                        <label for="chkConsumoAgua">Consumo AA.CC.</label>
                        <div class="input-control switch" data-role="input-control">
                            <label>
                                <span id="helperConsumoAgua">NO</span>
                                <input id="chkConsumoAgua" name="chkConsumoAgua" type="checkbox" value="1">
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="pnlInfoFormula" data-editado="0" class="panel-info without-foto" data-hint-position="top" title="F&oacute;rmula" style="display: none;">
                        <div class="info">
                            <h3 class="descripcion">F&oacute;rmula</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="pnlInfoEscalonable" data-editado="0" class="panel-info without-foto" data-hint-position="top" title="Valores escalonables" style="display: none;">
                        <div class="info">
                            <h3 class="descripcion">Valores escalonables</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="col-md-4 pull-right">
                <div class="row">
                    <div class="col-md-6">
                        <button id="btnLimpiar" type="button" class="btn btn-default full-size">Limpiar</button>
                    </div>
                    <div class="col-md-6">
                        <button id="btnGuardar" type="button" class="btn btn-primary full-size">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalFormula" class="modal-nomodal modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                F&oacute;rmula del Concepto
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="pnlMainFormula" class="moduloTwoPanel default">
                <div class="colTwoPanel1">
                    <div id="pnlConcepto" class="generic-panel gp-no-footer">
                        <div class="gp-header padding10">
                            <div class="grid no-padding no-margin">
                                <div class="row">
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddlTipoConceptoFormula" name="ddlTipoConceptoFormula">
                                            <option value="0">
                                                TODOS
                                            </option>
                                            <?php
                                            for ($counterTipoConcepto=0; $counterTipoConcepto < $countRowTipoConcepto; $counterTipoConcepto++):
                                            ?>
                                            <option value="<?php echo $rowTipoConcepto[$counterTipoConcepto]['ta_codigo']; ?>">
                                                <?php $translate->__($rowTipoConcepto[$counterTipoConcepto]['ta_denominacion']); ?>
                                            </option>
                                            <?php
                                            endfor;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtSearchConceptoFormula" name="txtSearchConceptoFormula" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                        <button id="btnSearchConceptoFormula" name="btnSearchConceptoFormula" type="button" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gp-body pos-rel">
                            <div id="gvConcepto" class="scrollbarra">
                                <div class="items-area listview gridview">
                                </div>
                            </div>
                            <div id="pnlDisableConcepto" class="panel-bloqueo hide"></div>
                        </div>
                    </div>
                </div>
                <div class="colTwoPanel2">
                    <div id="panelFormula" class="generic-panel gp-no-footer">
                        <div class="gp-header">
                            <div id="ScrFormula" class="bg-gray-glass bg-darkTeal">
                            </div>
                            <textarea id="txtFormula" class="oculto fg-white bg-transparent"></textarea>
                        </div>
                        <div class="gp-body">
                            <div class="scrollbarra">
                                <div class="grid">
                                    <button id="btnSuma" type="button" class="btn bg-orange fg-white" data-tipovalor="operador">+</button>
                                    <button id="btnResta" type="button" class="btn bg-orange fg-white" data-tipovalor="operador">-</button>
                                    <button id="btnPor" type="button" class="btn bg-orange fg-white" data-tipovalor="operador">*</button>
                                    <button id="btnEntre" type="button" class="btn bg-orange fg-white" data-tipovalor="operador">/</button>
                                    <button id="btnIzq" type="button" class="btn bg-orange fg-white" data-tipovalor="agrupacion">(</button>
                                    <button id="btnDer" type="button" class="btn bg-orange fg-white" data-tipovalor="agrupacion">)</button>
                                    <button id="btnCer" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">0</button>
                                    <button id="btnUno" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">1</button>
                                    <button id="btnDos" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">2</button>
                                    <button id="btnTre" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">3</button>
                                    <button id="btnCua" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">4</button>
                                    <button id="btnCin" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">5</button>
                                    <button id="btnSei" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">6</button>
                                    <button id="btnSie" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">7</button>
                                    <button id="btnOch" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">8</button>
                                    <button id="btnNue" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">9</button>
                                    <button id="btnPorc" type="button" class="btn bg-orange fg-white" data-tipovalor="numerico">%</button>
                                    <button id="btnBksp" type="button" class="btn bg-orange icon fg-white" data-tipovalor="edicion"><i class="icon-backspace-2 smaller"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span9"></div>
                    <div class="span3">
                        <button id="btnAplicarFormula" type="button" class="command-button mode-add success">Aplicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalEscalonable" class="modal-dialog modal-nomodal no-margin modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Valores escalonables
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="tableEscalonable" class="itables">
                <div class="ihead">
                    <table>
                        <thead>
                            <tr>
                                <th>Valor inicial</th>
                                <th>Valor final</th>
                                <th>Valor escala</th>
                                <th>Valor texto intervalo</th>
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
        <div class="modal-example-footer">
            <button id="btnAddRowEscalonable" type="button" class="circle-button add bg-darkCyan mypos-left">
                <h3 class="no-margin"><i class="icon-btn-circle"></i></h3>
            </button>
            <div class="grid fluid">
                <div class="row">
                    <div class="span9"></div>
                    <div class="span3">
                        <button id="btnAplicarEscalonable" type="button" class="command-button mode-add success">Aplicar</button>
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
<script src="dist/js/app/admin/concepto-script.min.js"></script>