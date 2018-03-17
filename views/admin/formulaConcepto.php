<form id="form1" name="form1" method="post">
	<div class="grid">
        <div class="row">
            <div class="grid fluid">
                <div class="row">
                   <div id="row" class="span4">
                        <label for="txtCodigo">C&oacute;digo</label>
                        <div class="input-control text" data-role="input-control">
                                <input id="txtCodigo" name="txtCodigo" type="text" placeholder="Ingrese C&oacute;digo" aria-required="true" aria-invalid="false" data-original-title="" title="">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                    <div id="row" class="span8">
                        <label for="txtDescripcion">Descripci&oacute;n</label>
                        <div class="input-control text" data-role="input-control">
                                <input id="txtDescripcion" name="txtDescripcion" type="text" placeholder="Ingrese Descripci&oacute;n" aria-required="true" aria-invalid="false" data-original-title="" title="">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
       <div class="row">
            <div class="grid fluid">
                <div class="row">
                    <div id="rowCero" class="span1">
                        <button id="btnCero" name="btnCero" class="command-button primary">0</button>
                    </div>
                   <div id="rowUno" class="span1">
                        <button id="btnUno" name="btnUno" class="command-button primary">1</button>
                    </div>
                    <div id="rowDos" class="span1">
                        <button id="btnDos" name="btnDos" class="command-button primary">2</button>
                    </div>
                    <div id="rowTres" class="span1">
                        <button id="btnTres" name="btnTres" class="command-button primary">3</button>
                    </div>
                    <div id="rowCuatro" class="span1">
                        <button id="btnCuatro" name="btnCuatro" class="command-button primary">4</button>
                    </div>
                    <div id="rowCinco" class="span1">
                        <button id="btnCinco" name="btnCinco" class="command-button primary">5</button>
                    </div>
                    <div id="rowSeis" class="span1">
                        <button id="btnSeis" name="btnSeis" class="command-button primary">6</button>
                    </div>
                    <div id="rowSiete" class="span1">
                        <button id="btnSiete" name="btnSiete" class="command-button primary">7</button>
                    </div>
                    <div id="rowOcho" class="span1">
                        <button id="btnOcho" name="btnOcho" class="command-button primary">8</button>
                    </div>
                    <div id="rowNueve" class="span1">
                        <button id="btnNueve" name="btnNueve" class="command-button primary">9</button>
                    </div>
                </div>
            </br>
                <div class="row">
                    <div id="rowIzquierda" class="span1">
                        <button id="btnIzquierda" name="btnIzquierda" class="command-button info">(</button>
                    </div>
                   <div id="rowDerecha" class="span1">
                        <button id="btnDerecha" name="btnDerecha" class="command-button info">)</button>
                    </div>
                    <div id="rowPor" class="span1">
                        <button id="btnPor" name="btnPor" class="command-button info">*</button>
                    </div>
                    <div id="rowEntre" class="span1">
                        <button id="btnEntre" name="btnEntre" class="command-button info">/</button>
                    </div>
                    <div id="rowSuma" class="span1">
                        <button id="btnSuma" name="btnSuma" class="command-button info">+</button>
                    </div>
                    <div id="rowResta" class="span1">
                        <button id="btnResta" name="btnResta" class="command-button info">-</button>
                    </div>
                </div>
            </br>
            </div>
        </div>
        <div class="row">
            <label for="txtFormula">F&oacute;rmula</label>
            <div class="input-control text" data-role="input-control">
                    <input id="txtFormula" name="txtFormula" type="text" placeholder="Ingrese F&oacute;rmula" aria-invalid="false" data-original-title="" title="">
                    <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
        </div>
    </div>
    <div class="appbar">
        <button id="btnCancelar" type="button" class="metro_button float-right">
            <h2><i class="icon-cancel"></i></h2>
        </button>
        <button id="btnGuardar" name="btnGuardar" type="button" class="metro_button float-right">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>