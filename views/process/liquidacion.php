<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdIdCierreLiquidacion" name="hdIdCierreLiquidacion" value="0" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0" />
    <input type="hidden" id="hdAnho" name="hdAnho" value="<?php echo date('Y'); ?>" />
    <input type="hidden" id="hdMes" name="hdMes" value="<?php echo date('m'); ?>" />

    <input type="hidden" name="hdSaldoInicial" id="hdSaldoInicial" value="0">
    <input type="hidden" name="hdCobranza" id="hdCobranza" value="0">
    <input type="hidden" name="hdGasto" id="hdGasto" value="0">
    <input type="hidden" name="hdSaldo" id="hdSaldo" value="0">

    <div id="pnlListado" class="generic-panel">
        <div class="gp-header">
            <h2 class="margin10">
                <a id="btnSaldoInicial" href="#" class="btn btn-default">Saldo inicial</a>
                <span id="lblSaldoInicial" class="text-right white-text right">0.00</span><span class="white-text right">S/. </span>
            </h2>
        </div>
        <div class="gp-body">
            <div id="tabDetallado" class="scrollbarra">
                <h2 class="margin10">
                    <a id="btnShowDetalle_Cobranza" href="#" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Total de cobranzas</a> <span id="lblCobranza" class="text-right right">S/. 0.00</span></h2>

                <div id="gvCobranza" class="padding10" style="display: none;">
                    <div class="table-responsive-vertical shadow-z-1">
                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th><?php $translate->__('Mes'); ?></th>
                                    <th><?php $translate->__('Total'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h2 class="margin10">
                    <a id="btnShowDetalle_Gasto" href="#" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Total de gastos</a> <span id="lblGasto" class="text-right right">S/. 0.00</span></h2>
                <div id="gvGasto" class="padding10" style="display: none;">
                    <div class="table-responsive-vertical shadow-z-1">
                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th><?php $translate->__('Tipo de gasto'); ?></th>
                                    <th><?php $translate->__('Importe'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tabTabulado" style="display: none;">
                <div id="tableLiquidacion" class="itables">
                    <div class="ihead">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Saldo inicial</th>
                                    <th>Gastos</th>
                                    <th>Cobranza</th>
                                    <th>Saldo final</th>
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
        <div class="gp-footer">
            <h2 class="margin10 right text-right">
                Saldo: <span id="lblSaldo">S/. 0.00</span>
            </h2>
        </div>
    </div>
    <div class="modal fade" id="modalSaldoInicial" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ingreso de saldo inicial</h4>
                </div>
                <div class="modal-body">
                    <div class="grid">
                        <div class="row">
                            <label for="txtSaldoInicial">Saldo inicial</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSaldoInicial" name="txtSaldoInicial" class="only-numbers" type="text" value="0.00">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGuardarSaldoInicial"><i class="fa fa-floppy-o"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlDatosDetalle" data-tipofiltro="proyecto" class="top-panel inner-page" style="display:none;">
        <div class="generic-panel gp-no-footer">
            <div class="gp-header">
                <h1 class="title-window">
                    <a href="#" id="btnHideFiltro" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
                    <span id="txtTituloFiltro"></span>
                    <!-- <div class="col-md-6 no-float margin10 place-top-right">
                        <div class="input-group">
                          <input id="txtSearchFiltro" name="txtSearchFiltro" type="text" class="form-control fg-dark margin-top5 margin-bottom5" placeholder="Buscar...">
                          <span class="input-group-btn">
                            <button id="btnSearchFiltro" class="btn btn-default" type="button">Buscar</button>
                          </span>
                        </div>
                    </div> -->
                </h1>
            </div>
            <div class="gp-body">
                <div id="tableCobranza_Detalle" class="padding10 scrollbarra">
                    <div class="table-responsive-vertical shadow-z-1">
                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th>TIPO DE OPERACION</th>
                                    <th>FECHA</th>
                                    <th>NRO DE OPERACION</th>
                                    <th>IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tableGasto_Detalle" class="padding10 scrollbarra hide">
                    <div class="table-responsive-vertical shadow-z-1">
                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th>TIPO DE GASTO</th>
                                    <th>TIPO DE DESEMBOLSO</th>
                                    <th>TIPO DE AFECTACION</th>
                                    <th>FECHA DE DOCUMENTO</th>
                                    <th>NRO SUMINISTRO</th>
                                    <th>DESCRIPCION</th>
                                    <th>MES</th>
                                    <th>ANHO</th>
                                    <th>IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
<script src="dist/js/app/process/liquidacion-script.min.js"></script>