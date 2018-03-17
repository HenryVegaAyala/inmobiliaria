<?php
require 'bussiness/documentos.php';

$IdEmpresa = 1;
$IdCentro = 1;
$objDocIdentidad = new clsDocumentos();

$rowDocIdentNat = $objDocIdentidad->CodigoTributable('1');
$countRowDocIdentNat = count($rowDocIdentNat);

$rowDocIdentJur = $objDocIdentidad->CodigoTributable('6');
$countRowDocIdentJur = count($rowDocIdentJur);

$hdCodigoOri = '0';
$ddlTipoDocNatural = '';
$txtNroDocNatural = '';
$txtApePaterno = '';
$txtApeMaterno = '';
$txtNombres = '';
$txtDireccionNatural = '';
$txtTelefonoNatural = '';
$txtEmailNatural = '';
$hdIdUbigeoNatural = '0';
$UbigeoNatural = 'Ubigeo';
$ddlTipoDocJuridica = '';
$txtRucEmpresa = '';
$txtRazonSocial = '';
$txtDireccionEmpresa = '';
$txtTelefonoEmpresa = '';
$txtEmailEmpresa = '';
$txtWebEmpresa = '';
$hdIdUbigeoJuridico = '0';
$chkEsConstructora = '0';
$UbigeoJuridico = 'Ubigeo';
$imgFoto = 'dist/img/user-nosetimg-233.jpg';

$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : 'listado';
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPagePropietario" name="hdPagePropietario" value="1" />
    <input type="hidden" name="hdIdUbigeoUE" id="hdIdUbigeoUE" value="0">
    <div class="page-region without-appbar">
        <?php
        $idpropietario_user = '0';
        if ($screenmode == 'propietario'){
            require 'bussiness/propietario.php';
            $objPropietario = new clsPropietario();

            $idpropietario_user = $idpersona;

            $ocultar_lista = ' style="display: none;"';
            $ocultar_registro = '';
            $disabled = ' disabled="disabled"';

            $rowPropietario = $objPropietario->Listar('2', 0, 0, $idpersona, '', '', 1);
            $countPropietario = count($rowPropietario);

            if ($countPropietario > 0) {
                $TipoPropietario = $rowPropietario[0]['tm_iditc'];
                $hdCodigoOri = $rowPropietario[0]['tm_codigo_ori'];
                
                if ($TipoPropietario == 'NA') {
                    $ddlTipoDocNatural = $rowPropietario[0]['tm_iddocident'];
                    $txtNroDocNatural = $rowPropietario[0]['tm_numerodoc'];
                    $txtDireccionNatural = $rowPropietario[0]['tm_direccion'];
                    $txtTelefonoNatural = $rowPropietario[0]['tm_telefono'];
                    $txtApePaterno = $rowPropietario[0]['tm_apepaterno'];
                    $txtApeMaterno = $rowPropietario[0]['tm_apematerno'];
                    $txtNombres = $rowPropietario[0]['tm_nombres'];
                    $txtEmailNatural = $rowPropietario[0]['tm_email'];
                    $hdIdUbigeoNatural = $rowPropietario[0]['tm_idubigeo'];
                    $UbigeoNatural = $rowPropietario[0]['ubigeo'];
                }
                else {
                    $ddlTipoDocJuridica = $rowPropietario[0]['tm_iddocident'];
                    $txtRucEmpresa = $rowPropietario[0]['tm_numerodoc'];
                    $txtRazonSocial = $rowPropietario[0]['tm_razsocial'];
                    $txtEmailEmpresa = $rowPropietario[0]['tm_email'];
                    $txtRepresentante = $rowPropietario[0]['tm_representante'];
                    $txtDireccionEmpresa = $rowPropietario[0]['tm_direccion'];
                    $txtTelefonoEmpresa = $rowPropietario[0]['tm_telefono'];
                    $txtWebEmpresa = $rowPropietario[0]['tm_urlweb'];
                    $hdIdUbigeoJuridico = $rowPropietario[0]['tm_idubigeo'];
                    $chkEsConstructora = $rowPropietario[0]['tm_esconstructora'] == '1' ? true : false;
                    $UbigeoJuridico = $rowPropietario[0]['ubigeo'];
                }

                $Foto = $rowPropietario[0]['tm_foto'];
                $imgFoto = $Foto == 'no-set' ? 'dist/img/user-nosetimg-233.jpg' : $Foto;
            }
        }
        else {
            $ocultar_lista = '';
            $ocultar_registro = ' style="display: none;"';
            $disabled = '';

            $imgFoto = 'dist/img/user-nosetimg-233.jpg';
        }

        if ($imgFoto == '') {
            if (strlen($imgFoto) == 0)
                $imgFoto = 'dist/img/user-nosetimg-233.jpg';
        }
        ?>
            
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="<?php echo $idpropietario_user; ?>">
        <input type="hidden" id="hdCodigoOri" name="hdCodigoOri" value="<?php echo $hdCodigoOri; ?>">
        <input type="hidden" id="hdTipoPropietario" name="hdTipoPropietario" value="<?php echo $TipoPropietario; ?>">
        <input type="hidden" id="hdFoto" name="hdFoto" value="<?php echo $foto; ?>">
        <input type="hidden" name="hdIdUbigeoNatural" id="hdIdUbigeoNatural" value="<?php echo $hdIdUbigeoNatural; ?>">
        <input type="hidden" name="hdIdUbigeoJuridico" id="hdIdUbigeoJuridico" value="<?php echo $hdIdUbigeoJuridico; ?>">
        <input type="hidden" id="hdLegal" name="hdLegal" value="LEGAL">
        <div id="pnlListado" class="inner-page with-panel-search with-appbar"<?php echo $ocultar_lista; ?>>
            <h1 class="title-window hide">
                <a id="btnCustomBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Propietarios
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input id="txtSearchPropietario" name="txtSearchPropietario" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearchPropietario" name="btnSearchPropietario" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
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
                <button id="btnSendMail" type="button" class="metro_button oculto float-left"  data-hint-position="top" title="Enviar correo electr&oacute;nico">
                    <h2><i class="icon-mail"></i></h2>
                </button>
                <button id="btnSelectOne" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Seleccionar propietario">
                    <h2><i class="icon-checkmark"></i></h2>
                </button>
                <button id="btnSelectAll" type="button" class="metro_button oculto float-left" data-hint-position="top" title="Seleccionar todo">
                    <h2><i class="icon-checkbox"></i></h2>
                </button>
            </div>
        </div>
        <div id="pnlForm" class="inner-page with-title-window with-appbar"<?php echo $ocultar_registro; ?>>
            <input type="hidden" name="hdIdPropietarioUser" id="hdIdPropietarioUser" value="<?php echo $idpropietario_user; ?>">
            <h1 class="title-window">
                <?php if ($screenmode != 'propietario'): ?>
                <a id="btnBackToListFromForm" class="btnBackList" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
                <?php endif; ?>
                Registro
                <button class="btn btn-primary btn-success no-margin" type="button" data-tipopropietario="NA" data-target="#tab1"<?php echo $disabled; ?>><?php $translate->__('Propietario Natural'); ?></button>
                <button class="btn btn-primary no-margin" type="button" data-tipopropietario="JU" data-target="#tab2"<?php echo $disabled; ?>><?php $translate->__('Propietario Juridico'); ?></button>
            </h1>
            <div class="divContent">
                <div class="scrollbarra">
                    <div class="grid padding10">
                        <div class="row">
                            <div class="span6 text-center pos-rel">
                                <img src="<?php echo $imgFoto ?>" alt="" id="imgFoto" data-src="<?php echo $imgFoto; ?>" />
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
                                                        for ($i=0; $i < $countRowDocIdentNat; $i++):
                                                            $selected = $rowDocIdentNat[$i]['tm_iddocident'] == $ddlTipoDocNatural ? ' selected' : ''; 
                                                        ?>
                                                        <option<?php echo $selected; ?> value="<?php echo $rowDocIdentNat[$i]['tm_iddocident']; ?>">
                                                            <?php $translate->__($rowDocIdentNat[$i]['tm_descripcion']); ?>
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
                                                    <input id="txtNroDocNatural" name="txtNroDocNatural" type="text" value="<?php echo $txtNroDocNatural; ?>" maxlength="8" placeholder="<?php $translate->__('Ejemplo: 45035046'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtApePaterno"><?php $translate->__('Apellido paterno'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtApePaterno" name="txtApePaterno" type="text" value="<?php echo $txtApePaterno; ?>" placeholder="Ejemplo: Qui&ntilde;onez">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtApeMaterno"><?php $translate->__('Apellido materno'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtApeMaterno" name="txtApeMaterno" type="text" value="<?php echo $txtApeMaterno; ?>" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtNombres">Nombres</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtNombres" name="txtNombres" type="text" value="<?php echo $txtNombres; ?>" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtDireccionNatural">Direcci&oacute;n</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtDireccionNatural" name="txtDireccionNatural" type="text" value="<?php echo $txtDireccionNatural; ?>" placeholder="<?php $translate->__('Ejemplo: Direcci&oacute;n #456 Urb. XYZ'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="span4">
                                                <label for="txtTelefonoNatural">Tel&eacute;fono</label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtTelefonoNatural" name="txtTelefonoNatural" type="text" value="<?php echo $txtTelefonoNatural; ?>" placeholder="<?php $translate->__('Ejemplo: +51979611547'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="span8">
                                                <label for="txtEmailNatural">Email</label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtEmailNatural" name="txtEmailNatural" type="text" value="<?php echo $txtEmailNatural; ?>" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="pnlInfoUbigeoNatural" data-idubigeo="<?php echo $hdIdUbigeoNatural; ?>" class="panel-info without-foto" data-hint-position="top" title="Ubigeo">
                                                <div class="info">
                                                    <h3 class="descripcion"><?php echo $UbigeoNatural; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section id="tab2" class="tab-principal" style="display:none;">
                                    <div class="grid fluid padding10">
                                        <div class="row">
                                            <div class="span6">
                                                <label for="ddlTipoDocJuridica">Tipo de documento de identidad</label>
                                                <div class="input-control select fa-caret-down" data-role="input-control">
                                                    <select id="ddlTipoDocJuridica" name="ddlTipoDocJuridica">
                                                        <?php
                                                        for ($i=0; $i < $countRowDocIdentJur; $i++):
                                                            $selected = $rowDocIdentJur[$i]['tm_iddocident'] == $ddlTipoDocJuridica ? ' selected' : ''; 
                                                        ?>
                                                        <option value="<?php echo $rowDocIdentJur[$i]['tm_iddocident']; ?>">
                                                            <?php $translate->__($rowDocIdentJur[$i]['tm_descripcion']); ?>
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
                                                    <input id="txtRucEmpresa" name="txtRucEmpresa" type="text" value="<?php echo $txtRucEmpresa; ?>" maxlength="11" placeholder="<?php $translate->__('Ejemplo: 10450350261'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtRazonSocial">Raz&oacute;n Social</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtRazonSocial" name="txtRazonSocial" type="text" value="<?php echo $txtRazonSocial; ?>" placeholder="<?php $translate->__('Ejemplo: Gonzales S.A.'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="txtDireccionEmpresa">Direcci&oacute;n</label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtDireccionEmpresa" name="txtDireccionEmpresa" type="text" value="<?php echo $txtDireccionEmpresa; ?>" placeholder="<?php $translate->__('Ejemplo: Direcci&oacute;n #456 Urb. XYZ'); ?>">
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="span4">
                                                <label for="txtTelefonoEmpresa">Tel&eacute;fono</label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtTelefonoEmpresa" name="txtTelefonoEmpresa" type="text" value="<?php echo $txtTelefonoEmpresa; ?>" placeholder="<?php $translate->__('Ejemplo: +51979611547'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="span8">
                                                <label for="txtEmailEmpresa">Email</label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtEmailEmpresa" name="txtEmailEmpresa" type="text" value="<?php echo $txtEmailEmpresa; ?>" placeholder="<?php $translate->__('Ejemplo: tunombre@tudominio.com'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="span9">
                                                <label for="txtWebEmpresa">P&aacute;gina web</label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtWebEmpresa" name="txtWebEmpresa" type="text" value="<?php echo $txtWebEmpresa; ?>" placeholder="<?php $translate->__('Ejemplo: www.tudominio.com'); ?>">
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <div class="input-control checkbox" data-role="input-control">
                                                <label>
                                                    <input id="chkEsConstructora" name="chkEsConstructora" type="checkbox" value="1"<?php echo $chkEsConstructora == '1' ? ' checked' : ''; ?>>
                                                    <span class="check"></span>
                                                    Constructora
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="pnlInfoUbigeoEmpresa" data-idubigeo="<?php echo $hdIdUbigeoJuridico; ?>" class="panel-info without-foto" data-hint-position="top" title="Ubigeo">
                                                <div class="info">
                                                    <h3 class="descripcion"><?php echo $UbigeoJuridico; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
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
    <div id="modalEmail" class="modal-dialog modalseis modal-example-content without-footer">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Env&iacute;o de e-mail
            </h2>
        </div>
        <div class="modal-example-body">
            <iframe id="ifrEmail" scrolling="no" marginwidth="no" marginheight="no" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
    <div id="modalCondiciones" class="modal-dialog-x modalsiete modal-example-content">
        <div class="modal-example-header no-overflow">
            <h2 class="no-margin b-hide">
                <a id="btnCloseGenPDF" class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                <span>T&eacute;rminos y Condiciones de CINADSAC</span>
            </h2>
        </div>
        <div class="modal-example-body">
            <iframe src="media/pdf/privacy.pdf" marginwidth="0" marginheight="0" width="100%" height="100%" frameborder="0"></iframe>
        </div>
        <div class="modal-example-footer padding10">
            <div class="grid fluid">
                <div class="row">
                    <div class="span5 right">
                        <button id="btnAceptarTerminos" name="btnAceptarTerminos" type="submit" class="btn btn-success btn-large center-block">Acepto los t&eacute;rrminos y condiciones</a>
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
<script src="dist/js/app/admin/propietario-script.min.js"></script>