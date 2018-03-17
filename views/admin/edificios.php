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
                Edificios
            </h1>
            <div class="divContent">
            	<div class="grid padding10">
                   <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span12">
                                    <label for="ddEdificio">Edificio</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddEdificio" name="ddEdificio">
                                            
                                        </select>
                                    </div>
                                    <button id="btnAdicionarEdificio" name="btnAdicionarEdificio" class="command-button primary">Adicionar Edificio</button>
                                    <br>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div id="tabDetalle" class="tab-control" data-role="tab-control">
                            <ul class="tabs">
                                <li class="active" data-tab="Departamento"><a href="#_page_2">Departamentos</a></li>
                                <li data-tab="Estacionamiento"><a href="#_page_3">Estacionamientos</a></li>
                                <li data-tab="Deposito"><a href="#_page_4">Depósitos</a></li>
                            </ul>
                 
                            <div class="frames">
                                <div class="frame" id="_page_2">
                                    <div id="tableDepartamento" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Torre</th>
                                                        <th>Area</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                       <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Departamento">Departamento 1</td><td class="Torre">Torre 1</td><td class="Area">80.00</td><td class="Estado">Entregado</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Departamento">Departamento 2</td><td class="Torre">Torre 2</td><td class="Area">100.00</td><td class="Estado">Inmobiliaria</td>
                                                        </tr>
                                                    </tbody>                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame" id="_page_3">
                                    <div id="tableEstacionamiento" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Estacionamiento</th>
                                                        <th>Área</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                       <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Estacionamiento">Estacionamiento 1</td><td class="Area">80.00</td><td class="Estado">Entregado</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Estacionamiento">Estacionamiento 2</td><td class="Area">100.00</td><td class="Estado">Inmobiliaria</td>
                                                        </tr>
                                                    </tbody>                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame" id="_page_4">
                                    <div id="tableDeposito" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Depósito</th>
                                                        <th>Área</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                       <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Deposito">Depósito 1</td><td class="Area">80.00</td><td class="Estado">Entregado</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-Codigo="3" data-tipomenu="01"><td class="Deposito">Depósito 2</td><td class="Area">100.00</td><td class="Estado">Inmobiliaria</td>
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
    <div id="modalTorre" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos de la Torre
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtTorre">Torre</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtTorre" name="txtTorre" type="text" placeholder="Ingrese Torre" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="ddEstado">Estado</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddEstado" name="ddEstado">
                        </select>
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
    <div id="modalDepartamento" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Departamento
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                 <div class="row">
                        <label for="txtDepartamento">Departamento</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtDepartamento" name="txtDepartamento" type="text" placeholder="Ingrese Departamento" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="ddTorre">Torre</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddTorre" name="ddTorre">
                            </select>
                        </div>
                        <label for="txtArea">Area</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtArea" name="txtArea" type="text" placeholder="Ingrese Area" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="ddEstado">Estado</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddEstado" name="ddEstado">
                            </select>
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
    <div id="modalEstacionamiento" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Estacionamiento
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                 <div class="row">
                        <label for="txtEstacionamiento">Estacionamiento</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtEstacionamiento" name="txtEstacionamiento" type="text" placeholder="Ingrese Estacionamiento" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="txtArea">Area</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtArea" name="txtArea" type="text" placeholder="Ingrese Area" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="ddEstado">Estado</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddEstado" name="ddEstado">
                            </select>
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
    <div id="modalDeposito" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Depósito
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                 <div class="row">
                        <label for="txtDeposito">Depósito</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtDeposito" name="txtDeposito" type="text" placeholder="Ingrese Depósito" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="txtArea">Area</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtArea" name="txtArea" type="text" placeholder="Ingrese Area" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="ddEstado">Estado</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddEstado" name="ddEstado">
                            </select>
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
    <div id="modalEdificio" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Edificio
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                 <div class="row">
                        <label for="txtNombreEdificio">Nombre Edificio</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtNombreEdificio" name="txtNombreEdificio" type="text" placeholder="Ingrese nombre del edificio" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                        <label for="ddTipo">Tipo de prorrateo de conceptos</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddTipo" name="ddTipo">
                            </select>
                        </div>
                        <label for="ddPais">País</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddPais" name="ddPais">
                            </select>
                        </div>
                        <label for="ddRegion">Region</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddRegion" name="ddRegion">
                            </select>
                        </div>
                       <label for="ddProvincia">Provincia</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddProvincia" name="ddProvincia">
                            </select>
                        </div> 
                       <label for="ddLocalidad">Distrito/localidad</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddRegion" name="ddRegion">
                            </select>
                        </div>  
                        <label for="txtDireccion">Dirección</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtDireccion" name="txtDireccion" type="text" placeholder="Ingrese dirección" aria-required="true" aria-invalid="false" data-original-title="" title="">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>      
                        <label for="ddEstado">Estado</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddEstado" name="ddEstado">
                            </select>
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
            if (pestana=='Torre') {
               openCustomModal('#modalTorre');   
            }else if (pestana=="Departamento") {
               openCustomModal('#modalDepartamento'); 
            }else if (pestana=="Estacionamiento") {
               openCustomModal('#modalEstacionamiento'); 
            }else if (pestana=="Deposito") {
               openCustomModal('#modalDeposito');    
            };
        });

        $('#btnAdicionarEdificio').on('click', function(event) {
            event.preventDefault();
            openCustomModal('#modalEdificio');   
        });
    })
</script>