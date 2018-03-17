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
                Propiedades
            </h1>
            <div class="divContent">
            	<div class="grid padding10">
                     <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span6">
                                    <label for="ddCondominio">Condominio</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddCondominio" name="ddCondominio">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="span6">
                                    <label for="ddlTorre">Torre</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddlTorre" name="ddlTorre">
                                            
                                        </select>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="grid fluid">
                            <div class="row">
                                <div class="span6">
                                    <label for="ddCondominio">Departamento</label>
                                    <div class="input-control select fa-caret-down" data-role="input-control">
                                        <select id="ddCondominio" name="ddCondominio">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="span6">
                                    <label for="txtArea">&Aacute;rea</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtArea" name="txtArea" type="text" placeholder="Ingrese &Aacute;rea" aria-invalid="false" data-original-title="" title="">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="tabDetalle" class="tab-control" data-role="tab-control">
                            <ul class="tabs">
                                <li class="active" data-tab="Propietario"><a href="#_page_1">Propietarios</a></li>
                                <li data-tab="Inquilino"><a href="#_page_2">Inquilinos</a></li>
                                <li data-tab="Estacionamiento"><a href="#_page_3">Estacionamientos</a></li>
                                <li data-tab="Deposito"><a href="#_page_4">Depósitos</a></li>
                            </ul>
                 
                            <div class="frames">
                                <div class="frame" id="_page_1">
                                    <div id="tableConcepto" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Apellido Paterno</th>
                                                        <th>Apellido Materno</th>
                                                        <th>Nombres</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idImporte="3" data-tipomenu="01"><td class="apellidoPaterno">Morales</td><td class="apellidoMaterno">Gutierrez</td><td class="nombres">Juan Carlos</td><td class="Estado">Activo</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idImporte="3" data-tipomenu="01"><td class="apellidoPaterno">Juarez</td><td class="apellidoMaterno">Morales</td><td class="nombres">Enrique</td><td class="Estado">Inactivo</td>
                                                        </tr>
                                                    </tbody>                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame" id="_page_2">
                                    <div id="tableConcepto" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Apellido Paterno</th>
                                                        <th>Apellido Materno</th>
                                                        <th>Nombres</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idImporte="3" data-tipomenu="01"><td class="apellidoPaterno">Morales</td><td class="apellidoMaterno">Gutierrez</td><td class="nombres">Juan Carlos</td><td class="Estado">Activo</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idImporte="3" data-tipomenu="01"><td class="apellidoPaterno">Juarez</td><td class="apellidoMaterno">Morales</td><td class="nombres">Enrique</td><td class="Estado">Inactivo</td>
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
                                                        <th>&Aacute;rea</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idArea="2 data-tipomenu="01"><td class="nombreEstacionamiento">Estacionamiento 1</td><td class="Area">20.00</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idArea="2 data-tipomenu="01"><td class="nombreEstacionamiento">Estacionamiento 2</td><td class="Area">20.00</td>
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
                                                        <th>Dep&oacute;sito</th>
                                                        <th>&Aacute;rea</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="ibody">
                                            <div class="ibody-content">
                                                <table>
                                                    <tbody>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idArea="3" data-tipomenu="01"><td class="nombreDeposito">Dep&oacute;sito 1</td><td class="Area">100.00</td>
                                                        </tr>
                                                        <tr data-iddetalle="27" data-idinsumo="164" data-idcategoria="undefined" data-idsubcategoria="undefined" data-idArea="3" data-tipomenu="01"><td class="nombreDeposito">Dep&oacute;sito 2</td><td class="Area">120.00</td>
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
    <div id="modalPropietario" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del propietario
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddTipoDocumento">TipoDocumento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddTipoDocumento" name="ddTipoDocumento">
                        </select>
                    </div>
                    <label for="txtDocumento">Documento</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtDocumento" name="txtDocumento" type="text" placeholder="Ingrese Documento" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtPaterno">Paterno</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtPaterno" name="txtPaterno" type="text" placeholder="Ingrese Apellido Paterno" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtMaterno">Materno</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtMaterno" name="txtMaterno" type="text" placeholder="Ingrese Apellido Materno" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>                    
                    <label for="txtNombres">Nombres</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombres" name="txtNombres" type="text" placeholder="Ingrese Nombres" aria-required="true" aria-invalid="false" data-original-title="" title="">
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
    <div id="modalInquilino" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Inquilino
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddTipoDocumento">TipoDocumento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddTipoDocumento" name="ddTipoDocumento">
                        </select>
                    </div>
                    <label for="txtDocumento">Documento</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtDocumento" name="txtDocumento" type="text" placeholder="Ingrese Documento" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtPaterno">Paterno</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtPaterno" name="txtPaterno" type="text" placeholder="Ingrese Apellido Paterno" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label for="txtMaterno">Materno</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtMaterno" name="txtMaterno" type="text" placeholder="Ingrese Apellido Materno" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>                    
                    <label for="txtNombres">Nombres</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombres" name="txtNombres" type="text" placeholder="Ingrese Nombres" aria-required="true" aria-invalid="false" data-original-title="" title="">
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
                    <label for="ddEstacionamiento">Estacionamiento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddEstacionamiento" name="ddEstacionamiento">
                        </select>
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
                    <label for="ddDeposito">Depósito</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddDeposito" name="ddDeposito">
                        </select>
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
            if (pestana=='Propietario') {
               openCustomModal('#modalPropietario');   
            }else if (pestana=="Inquilino") {
               openCustomModal('#modalInquilino'); 
            }else if (pestana=="Estacionamiento") {
               openCustomModal('#modalEstacionamiento'); 
            }else if (pestana=="Deposito") {
               openCustomModal('#modalDeposito');    
            };
        });
    })
</script>