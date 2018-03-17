<?php
include('bussiness/documentos.php');
include('bussiness/inquilino.php');
$IdEmpresa = 1;
$IdCentro = 1;
$objDocIdentidad = new clsDocumentos();
$objInquilino = new clsInquilino();
$counterDocIdentNat = 0;
$counterDocIdentJur = 0;
$rowDocIdentNat = $objDocIdentidad->CodigoTributable('1');
$countRowDocIdentNat = count($rowDocIdentNat);
$rowDocIdentJur = $objDocIdentidad->CodigoTributable('6');
$countRowDocIdentJur = count($rowDocIdentJur);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageInquilino" name="hdPageInquilino" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdCodigoOri" name="hdCodigoOri" value="0">
    <input type="hidden" id="hdTipoInquilino" name="hdTipoInquilino" value="NA">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <input type="hidden" name="hdIdUbigeoNatural" id="hdIdUbigeoNatural" value="0">
    <input type="hidden" name="hdIdUbigeoJuridico" id="hdIdUbigeoJuridico" value="0">
    <input type="hidden" name="hdIdUbigeoUE" id="hdIdUbigeoUE" value="0">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page with-panel-search with-appbar">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Inquilinos
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="scrollbarra">
                    <div class="items-area listview gridview">
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right"  data-hint-position="top" title="Eliminar">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right"  data-hint-position="top" title="Editar">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnUploadExcel" type="button" class="metro_button float-right"  data-hint-position="top" title="Importar">
                    <h2><i class="icon-upload-2"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right"  data-hint-position="top" title="Nuevo">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left"  data-hint-position="top" title="Limpiar selecci&oacute;n">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <button id="btnDetalleFromList" type="button" class="metro_button oculto float-left"  data-hint-position="top" title="Propiedades">
                    <h2><i class="icon-grid"></i></h2>
                </button>
            </div>
        </div>
        <div id="pnlForm" class="inner-page with-appbar" style="display: none;">
            <h1 class="title-window hide">
                <a id="btnBackToListFromForm" class="btnBackList" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Registro
                <button class="large success no-margin" type="button" data-tipoinquilino="NA" data-target="#tab1"><?php $translate->__('Inquilino Natural'); ?></button>
                <button class="large no-margin" type="button" data-tipoinquilino="JU" data-target="#tab2"><?php $translate->__('Inquilino Juridico'); ?></button>
            </h1>
            <div class="divContent">
                <div class="grid">
                    <div class="row">
                        <div class="span6 text-center pos-rel">
                            <img src="images/user-nosetimg-233.jpg" alt="" id="imgFoto" data-src="images/user-nosetimg-233.jpg" />
                            <input type="file" id="fileUploadImage">
                            <button id="btnResetImage" class="compositor-cleansel-button oculto bg-darkTeal fg-white" type="button"><i class="icon-undo"></i></button>
                            <button class="compositor-upload-button bg-darkTeal fg-white" type="button" data-hint-position="top" title="Cambiar imagen"><i class="icon-upload"></i></button>
                        </div>
                        <div class="span8">
                            <section id="tab1" class="tab-principal">
                                <div class="grid fluid padding10">
                                    <div class="row">
                                        <div class="span6">
                                            <label for="ddlTipoDocNatural">Tipo de documento de identidad</label>
                                            <div class="input-control select fa-caret-down" data-role="input-control">
                                                <select id="ddlTipoDocNatural" name="ddlTipoDocNatural">
                                                    <?php
                                                    for ($counterDocIdentNat=0; $counterDocIdentNat < $countRowDocIdentNat; $counterDocIdentNat++):
                                                    ?>
                                                    <option value="<?php echo $rowDocIdentNat[$counterDocIdentNat]['tm_iddocident']; ?>">
                                                        <?php $translate->__($rowDocIdentNat[$counterDocIdentNat]['tm_descripcion']); ?>
                                                    </option>
                                                    <?php
                                                    endfor;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <label for="txtNroDocNatural">Documento de identidad</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtNroDocNatural" name="txtNroDocNatural" type="text" maxlength="8" placeholder="<?php $translate->__('Ejemplo: 45035046'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtApePaterno"><?php $translate->__('Apellido paterno'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtApePaterno" name="txtApePaterno" type="text" placeholder="Ejemplo: Qui&ntilde;onez">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtApeMaterno"><?php $translate->__('Apellido materno'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtApeMaterno" name="txtApeMaterno" type="text" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtNombres">Nombres</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtNombres" name="txtNombres" type="text" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtDireccionNatural">Direcci&oacute;n</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtDireccionNatural" name="txtDireccionNatural" type="text" placeholder="<?php $translate->__('Ejemplo: Direcci&oacute;n #456 Urb. XYZ'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span4">
                                            <label for="txtTelefonoNatural">Tel&eacute;fono</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtTelefonoNatural" name="txtTelefonoNatural" type="text" placeholder="<?php $translate->__('Ejemplo: +51979611547'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="span8">
                                            <label for="txtEmailNatural">Email</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtEmailNatural" name="txtEmailNatural" type="text" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="pnlInfoUbigeoNatural" data-idubigeo="0" class="panel-info without-foto" data-hint-position="top" title="Ubigeo">
                                            <div class="info">
                                                <h3 class="descripcion">Ubigeo</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="tab2" class="tab-principal" style="display:none;">
                                <div class="grid fluid" style="padding: 0 20px 0;">
                                    <div class="row">
                                        <div class="span6">
                                            <label for="ddlTipoDocJuridica">Tipo de documento de identidad</label>
                                            <div class="input-control select fa-caret-down" data-role="input-control">
                                                <select id="ddlTipoDocJuridica" name="ddlTipoDocJuridica">
                                                    <?php
                                                    for ($counterDocIdentJur=0; $counterDocIdentJur < $countRowDocIdentJur; $counterDocIdentJur++):
                                                    ?>
                                                    <option value="<?php echo $rowDocIdentJur[$counterDocIdentJur]['tm_iddocident']; ?>">
                                                        <?php $translate->__($rowDocIdentJur[$counterDocIdentJur]['tm_descripcion']); ?>
                                                    </option>
                                                    <?php
                                                    endfor;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <label for="txtRucEmpresa">N&uacute;mero de contribuyente</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtRucEmpresa" name="txtRucEmpresa" type="text" maxlength="11" placeholder="<?php $translate->__('Ejemplo: 10450350261'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtRazonSocial">Raz&oacute;n Social</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtRazonSocial" name="txtRazonSocial" type="text" placeholder="<?php $translate->__('Ejemplo: Gonzales S.A.'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtDireccionEmpresa">Direcci&oacute;n</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtDireccionEmpresa" name="txtDireccionEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: Direcci&oacute;n #456 Urb. XYZ'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span4">
                                            <label for="txtTelefonoEmpresa">Tel&eacute;fono</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtTelefonoEmpresa" name="txtTelefonoEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: +51979611547'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="span8">
                                            <label for="txtEmailEmpresa">Email</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtEmailEmpresa" name="txtEmailEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtWebEmpresa">P&aacute;gina web</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtWebEmpresa" name="txtWebEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: www.tudominio.com'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="pnlInfoUbigeoEmpresa" data-idubigeo="0" class="panel-info without-foto" data-hint-position="top" title="Ubigeo">
                                            <div class="info">
                                                <h3 class="descripcion">Ubigeo</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnCancelar" type="button" class="metro_button float-right">
                    <h2><i class="icon-cancel"></i></h2>
                </button>
                <button id="btnGuardar" type="button" class="metro_button float-right">
                    <h2><i class="icon-checkmark"></i></h2>
                </button>
            </div>
        </div>
        <div id="pnlDetalle" class="inner-page" style="display: none;">
            <h1 class="title-window hide">
                <a id="btnBackToListFromDetalle" class="btnBackList" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Propiedades
            </h1>
            <div class="divContent">
                <div class="generic-panel">
                    <div class="gp-header">
                        <div id="pnlInfoPersona" data-idpersona="0" class="panel-info" data-hint-position="top" title="">
                            <div class="foto"></div>
                            <div class="info">
                                <h3 class="descripcion"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="gp-body">
                        <div id="tabDetalle" class="tab-control" data-role="tab-control">
                            <ul class="tabs">
                                <li class="active" data-tab="Departamento" data-idtipopropiedad="DPT"><a href="#_page_1">Departamentos</a></li>
                                <li data-tab="Estacionamiento" data-idtipopropiedad="EST"><a href="#_page_2">Estacionamientos</a></li>
                                <li data-tab="Deposito" data-idtipopropiedad="DEP"><a href="#_page_3">Dep&oacute;sitos</a></li>
                            </ul>
                            <div class="frames">
                                <div class="frame" id="_page_1" data-idtipopropiedad="DPT">
                                    <div id="tableDepartamento" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Proyecto</th>
                                                        <th>Departamento</th>
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
                                                    </tbody>                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame" id="_page_2" data-idtipopropiedad="EST">
                                    <div id="tableEstacionamiento" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Proyecto</th>
                                                        <th>Estacionamiento</th>
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
                                                    </tbody>                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame" id="_page_3" data-idtipopropiedad="DEP">
                                    <div id="tableDeposito" class="itables">
                                        <div class="ihead">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Proyecto</th>
                                                        <th>Deposito</th>
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
            <!-- <div class="appbar">
                <button id="btnEliminarDetalle" name="btnEliminar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditarDetalle" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnNuevoDetalle" type="button" class="metro_button float-right">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSelDetalle" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-undo"></i></h2>
                </button>
            </div> -->
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
                    <label for="ddlCondominioDep">Condominio</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlCondominioDep" name="ddlCondominioDep">
                        </select>
                    </div>
                    <label for="txtAreaDepartamento">Area</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAreaDepartamento" name="txtAreaDepartamento" type="text" placeholder="Ingrese &aacute;rea">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarDepartamento" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarDepartamento" type="button" class="command-button mode-add default">Limpiar</button>
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
                    <label for="ddlCondominioEst">Condominio</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlCondominioEst" name="ddlCondominioEst">
                        </select>
                    </div>
                    <label for="txtAreaEst">Area</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAreaEst" name="txtAreaEst" type="text" placeholder="Ingrese &aacute;rea">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarEstacionamientos" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarEstacionamiento" type="button" class="command-button mode-add default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalDeposito" class="modal-dialog modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del Dep&oacute;sito
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                 <div class="row">
                    <label for="txtAreaDeposito">Area</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAreaDeposito" name="txtAreaDeposito" type="text" placeholder="Ingrese &aacute;rea">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarDeposito" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarDeposito" type="button" class="command-button mode-add default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalUbigeo" class="modaluno modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Ubigeo
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddlDepartamento">Departamento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDepartamento" name="ddlDepartamento">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlProvincia">Provincia</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlProvincia" name="ddlProvincia">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlDistrito">Distrito</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDistrito" name="ddlDistrito">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnAplicarUbigeo" type="button" class="command-button mode-add success">Aplicar Ubigeo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalUploadExcel" class="modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Importar datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row text-center">
                    <div class="droping-air mode-file">
                        <input type="file" class="file-import">
                        <div class="icon"></div>
                        <div class="help">
                            Seleccione o arrastre un archivo de Excel
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="progress-bar large" data-role="progress-bar" data-value="0" data-color="bg-cyan"></div>
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
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');

?>
<script src="dist/js/app/admin/inquilino-script.min.js"></script>