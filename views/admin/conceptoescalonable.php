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
                Concepto Escalonable
            </h1>
            <div class="divContent">
            	<div class="grid padding10">
                   <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span6">
                                    <label for="ddConceptoEscalonable">Concepto Escalonable</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddConceptoEscalonable" name="ddConceptoEscalonable">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="span2">
                                    <label for="chkEscalonable">Escalonable</label>
                                    <div class="input-control switch margin10" data-role="input-control">
                                        <label>
                                            <span id="helperEscalonable">NO</span>
                                            <input id="chkEscalonable" name="chkEscalonable" type="checkbox">
                                            <span class="check"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="span2">
                                    <label for="txtEscalas">&#191;Cu&aacute;ntas escalas se acumulan?</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtEscalas" name="txtEscalas" type="text" aria-required="true" aria-invalid="false" data-original-title="" title="">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="tabDetalle" class="tab-control" data-role="tab-control">
                            <ul class="tabs">
                                <li class="active" data-tab="Escalas"><a href="#_page_1">Detalles de las Escalas</a></li>
                            </ul>
                 
                            <div class="frames">
                                <div class="frame" id="_page_1">
                                    <div id="tableConcepto" class="itables">
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
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="ValorInicial">0</td><td class="ValorFinal">10</td><td class="ValorIntervalo">1.031</td><td class="TextoIntervalo">0 - 10</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="ValorInicial">10</td><td class="ValorFinal">25</td><td class="ValorIntervalo">1.197</td><td class="TextoIntervalo">10 - 25</td>    
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="ValorInicial">25</td><td class="ValorFinal">50</td><td class="ValorIntervalo">2.648</td><td class="TextoIntervalo">25 - 50</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="ValorInicial">50</td><td class="ValorFinal">1000</td><td class="ValorIntervalo">4.490</td><td class="TextoIntervalo">50 - 1000</td>    
                                                        </tr>
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
        </div>
    </div>
    <div class="appbar">
        <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button float-right">
            <h2><i class="icon-remove"></i></h2>
        </button>
        <button id="btnEditar" type="button" class="metro_button float-right">
            <h2><i class="icon-pencil"></i></h2>
        </button>
        <button id="btnNuevo" type="button" class="metro_button float-right">
            <h2><i class="icon-plus-2"></i></h2>
        </button>
        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
            <h2><i class="icon-undo"></i></h2>
        </button>
        <button id="btnGuardar" name="btnGuardar" type="button" class="metro_button float-left">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
        <button id="btnCancelar" type="button" class="metro_button float-left">
            <h2><i class="icon-cancel"></i></h2>
        </button>
    </div>
    <div id="modalEscalas" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Escalas
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtInicial">Inicial</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtInicial" name="txtInicial" type="text" placeholder="Ingrese Inicial" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtFinal">Final</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtFinal" name="txtFinal" type="text" placeholder="Ingrese Final" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>          
                    <label for="txtValorEscala">Valor de Escala</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtValorEscala" name="txtValorEscala" type="text" placeholder="Ingrese Valor de Escala" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtIntervalo">Texto del Intervalo</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtIntervalo" name="txtIntervalo" type="text" placeholder="Ingrese Intervalo" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>                              
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
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
<script>
    $(function  () {
        $('#btnNuevo').on('click', function(event) {
            var pestana;

            event.preventDefault();
            pestana=$('#tabDetalle .tabs li.active').attr('data-tab');
            if (pestana=='Escalas') {
               openCustomModal('#modalEscalas');  
            };
        });
    })
</script>