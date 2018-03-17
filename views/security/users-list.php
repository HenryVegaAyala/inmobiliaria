<style>
    #gvDatos {
    height: 100%;
    overflow: auto;
    }
</style>
<?php
$IdUsuarioEdit =  '0';
$txtNombre =  '';
$txtNombres =  '';
$txtApellidos =  '';
$txtClave =  '';
$txtTelefono =  '';
$txtEmail =  '';
$ddlPerfil =  '0';
$hdIdPersona = '0';
$nombrePersona = 'Elegir persona...';
$hdIdProyecto = '0';
$nombreProyecto = 'Elegir proyecto...';
$imgFoto =  'dist/img/user-nosetimg-233.jpg';

$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : 'listado';

if ($screenmode == 'usuarios'){
    require 'bussiness/usuarios.php';
    $objData = new clsUsuario();

    $ocultar_lista = ' style="display: none;"';
    $mostrar_registro = ' block';

    $rowUsuario = $objData->Listar('2', $idusuario, '', 0);
    $countUsuario = count($rowUsuario);

    if ($countUsuario > 0) {
        
        $IdUsuarioEdit = $rowUsuario[0]['tm_idusuario'];
        $txtNombre = $rowUsuario[0]['tm_login'];
        $txtNombres = $rowUsuario[0]['tm_nombres'];
        $txtNumeroDoc = $rowUsuario[0]['tm_nrodni'];
        $txtApellidos = $rowUsuario[0]['tm_apellidos'];
        $txtClave = $rowUsuario[0]['tm_clave'];
        $txtTelefono = $rowUsuario[0]['tm_telefono'];
        $txtEmail = $rowUsuario[0]['tm_correousuario'];
        $ddlPerfil = $rowUsuario[0]['tm_idperfil'];
        $Foto = $rowUsuario[0]['tm_foto'];

        $hdIdPersona = $rowUsuario[0]['tm_idpersona'];
        $nombrePersona = $rowUsuario[0]['persona'];
        $hdIdProyecto = $rowUsuario[0]['tm_idproyecto'];
        $nombreProyecto = $rowUsuario[0]['proyecto'];

        $imgFoto = $Foto == 'no-set' ? 'dist/img/user-nosetimg-233.jpg' : $Foto;
    }
}
else {
    $ocultar_lista = '';
    $mostrar_registro = '';

    if ($idperfil == '61') {
        if (($idproyecto_sesion != '0') ||  ($idproyecto_sesion != '0')){
            $hdIdProyecto = $idproyecto_sesion;

            require 'bussiness/condominio.php';

            $objProyecto = new clsProyecto();
            $rsProyecto = $objProyecto->Listar('2', $idproyecto_sesion, '', 0);
            
            if (count($rsProyecto) > 0)
                $nombreproyecto = $rsProyecto[0]['nombreproyecto'];
        }
    }
}
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPagePersona" name="hdPagePersona" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="<?php echo $IdUsuarioEdit; ?>" />
    <input type="hidden" id="hdIdPerfil" name="hdIdPerfil" value="0" />
    <input type="hidden" id="hdTipoDataPersona" name="hdTipoDataPersona" value="00" />
    <input type="hidden" id="hdIdPerfilUsuario" name="hdIdPerfilUsuario" value="0" />
    <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="<?php echo $hdIdPersona; ?>" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="<?php echo $hdIdProyecto; ?>" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="<?php echo $imgFoto; ?>">
    <div id="pnlConfigMenu" class="generic-panel sectionInception"<?php echo $ocultar_lista; ?>>
        <div class="sectionHeader gp-header">
            <button class="btn btn-primary btn-success no-margin" type="button" data-target="#tab1"><?php $translate->__('Usuarios'); ?></button>
            <button class="btn btn-primary" type="button" data-target="#tab2"><?php $translate->__('Perfiles'); ?></button>
        </div>
        <div class="sectionContent gp-body">
            <section id="tab1">
                <div id="pnlUsuario" class="inner-page with-panel-search">
                    <div class="panel-search">
                        <table class="tabla-normal">
                            <tr>
                                <td>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                        <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                    </div>
                                </td>
                                <td style="width:45px;">
                                    <button id="btnFilter" type="button" title="<?php $translate->__('M&aacute;s filtros'); ?>" style="margin-left:10px; margin-bottom:0px;"><i class="icon-filter"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="grid filtro">
                    </div>
                    <div class="divload">
                        <div id="gvDatos">
                            <div class="items-area listview gridview"></div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tab2" style="display:none;">
                <div id="pnlPermisos" class="generic-panel gp-no-footer">
                    <div class="gp-header">
                        <div id="gvPerfil" class="tile-area fluid"></div>
                    </div>
                    <div class="gp-body">
                        <div style="padding: 10px; height: 100%;">
                            <div id="tableMenu" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="input-control checkbox" data-role="input-control">
                                                        <label>
                                                            <input id="chkAllMenu" type="checkbox" />
                                                            <span class="check"></span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>M&oacute;dulo / Ventana</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="ibody">
                                    <div class="ibody-content">
                                        <table style="font-size: 12pt;">
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="gp-footer">
            <div class="appbar">
                <button id="btnNuevoPerfil" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnEditarPerfil" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnEliminarPerfil" type="button" class="metro_button oculto float-left">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnActivarUsuarios" type="button" class="metro_button float-right oculto" title="Activar usuarios seleccionados">
                    <h2><i class="fa fa-check-square" aria-hidden="true"></i></h2>
                </button>
                <!-- <button id="btnReporte" type="button" class="metro_button float-right">
                    <h2><i class="icon-pencil"></i></h2>
                </button> -->
                <button id="btnAplicarPerfil" name="btnAplicarPerfil" type="button" class="metro_button oculto float-right">
                    <h2><i class="icon-checkmark"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right" title="Nuevo usuario">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left" title="Limpiar selección">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div id="pnlSearchPersona" class="top-panel" style="display: none;">
        <div id="pnlPersona" class="sectionInception">
            <div class="sectionHeader">
                <h1 class="title-window">
                    <a href="#" id="btnExitPersona" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
                    <?php $translate->__('Persona'); ?>
                </h1>
            </div>
            <div class="sectionContent">
                <div class="inner-page with-panel-search">
                    <div class="panel-search">
                        <div class="input-control text" data-role="input-control">
                            <input type="text" id="txtSearchPersona" name="txtSearchPersona" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                            <button id="btnSearchPersona" type="button" class="btn-search" tabindex="-1"></button>
                        </div>
                    </div>
                    <div id="precargaPer" class="divload">
                        <div id="gvPersona" style="height: 100%;">
                            <div class="items-area listview gridview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlSearchProyecto" class="top-panel with-title-window" style="display: none;">
        <div id="pnlProyecto" class="sectionInception">
            <div class="sectionHeader">
                <h1 class="title-window">
                    <a href="#" id="btnExitProyecto" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
                    <?php $translate->__('Proyectos'); ?>
                </h1>
            </div>
            <div class="sectionContent">
                <div class="inner-page with-panel-search">
                    <div class="panel-search">
                        <div class="input-control text" data-role="input-control">
                            <input type="text" id="txtSearchProyecto" name="txtSearchProyecto" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                            <button id="btnSearchProyecto" type="button" class="btn-search" tabindex="-1"></button>
                        </div>
                    </div>
                    <div id="precargaPer" class="divload">
                        <div id="gvProyecto" style="height: 100%;">
                            <div class="items-area listview gridview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalItemsError" class="modal-example-content" style="display:none;">
        <div class="modal-example-header">
            <a class="close" href="#" onclick="$.fn.custombox('close');">&times;</a>
            <h4><?php $translate->__('Informe de errores'); ?></h4>
        </div>
        <div class="modal-example-body">
            <div id="errorList" class="error-list">
            </div>
        </div>
    </div>
    <div id="modalUsuarioReg" class="modal-dialog-x modal-example-content modal-nomodal<?php echo $mostrar_registro; ?>">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="pnlForm" class="row all-height">
                <div class="col-md-3 text-center pos-rel">
                    <img src="<?php echo $imgFoto; ?>" alt="" id="imgFoto" data-src="dist/img/user-nosetimg-233.jpg" />
                    <input type="file" id="fileUploadImage">
                    <button id="btnResetImage" class="btn btn-danger compositor-cleansel-button oculto" type="button"><i class="icon-undo"></i></button>
                    <button class="btn btn-danger compositor-upload-button" type="button" data-hint-position="top" title="Cambiar imagen"><i class="icon-upload"></i></button>
                </div>
                <div class="col-md-9 all-height">
                    <div class="scrollbarra">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtNombre"><?php $translate->__('Usuario'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre de usuario" value="<?php echo $txtNombre; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                            <div class="col-md-6 <?php echo $screenmode == 'usuarios' ? 'hide' : ''; ?>">
                                <label for="txtClave"><?php $translate->__('Clave'); ?></label>
                                <div class="input-control password" data-role="input-control">
                                    <input id="txtClave" name="txtClave" type="password" placeholder="Ingrese clave" />
                                    <button class="btn-reveal"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row <?php echo $screenmode == 'usuarios' ? 'hide' : ''; ?>">
                            <div class="col-md-12">
                                <label for="ddlPerfil">Perfil</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlPerfil" name="ddlPerfil">
                                    <?php
                                    require 'bussiness/perfil.php';
                                    $objPerfil = new clsPerfil();
                                    $rsPerfil = $objPerfil->Listar('1', 0, '');
                                    $countRsPerfil = count($rsPerfil);
                                    if ($countRsPerfil > 0):
                                        for ($i=0; $i < $countRsPerfil; $i++):
                                    ?>
                                        <option<?php echo ($ddlPerfil == $rsPerfil[$i]['tm_idperfil'] ? ' selected' : '') ?> value="<?php echo $rsPerfil[$i]['tm_idperfil']; ?>"><?php echo $rsPerfil[$i]['tm_nombre']; ?></option>
                                    <?php
                                        endfor;
                                    else:
                                    ?>
                                        <option selected value="0">No hay perfiles registrados</option>
                                    <?php
                                    endif;
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="pnlInfoPersonal" data-idpersona="<?php echo $hdIdPersona; ?>" class="grid fluid no-padding no-margin <?php echo ($idperfil != '61' ? 'hide' : ''); ?>">
                                    <div class="row">
                                        <div class="span2 no-margin">
                                            <button class="borrar-persona hide"><i class="icon-paragraph-left"></i></button>
                                        </div>
                                        <div class="span10 no-margin">
                                            <h3 class="descripcion"><?php echo $nombrePersona; ?></h3>
                                            <div class="grid fluid">
                                                <!-- <div class="span4 detalle docidentidad"></div> -->
                                                <div class="span8 detalle direccion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtNumeroDoc"><?php $translate->__('N&uacute;mero de documento'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtNumeroDoc" name="txtNumeroDoc" type="text" placeholder="Ingrese nombre de usuario" value="<?php echo $txtNumeroDoc; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtNombres"><?php $translate->__('Nombres'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtNombres" name="txtNombres" type="text" placeholder="Ingrese nombres" value="<?php echo $txtNombres; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="txtApellidos"><?php $translate->__('Apellidos'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtApellidos" name="txtApellidos" type="text" placeholder="Ingrese apellidos" value="<?php echo $txtApellidos; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtEmail" name="txtEmail" type="text" placeholder="Ingrese email" value="<?php echo $txtEmail; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="txtTelefono"><?php $translate->__('Telefono/Celular'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtTelefono" name="txtTelefono" type="text" placeholder="Ingrese telefono" value="<?php echo $txtTelefono; ?>" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                        </div>

                        <div class="row <?php echo ($idperfil != '61' ? 'hide' : ''); ?>">
                            <div class="col-md-12">
                                <div id="pnlInfoProyecto__Usuario" data-idproyecto="<?php echo $hdIdProyecto; ?>" class="grid fluid no-padding no-margin">
                                    <div class="row">
                                        <div class="span2 no-margin">
                                            <button class="borrar-proyecto hide"><i class="icon-cancel"></i></button>
                                        </div>
                                        <div class="span10 no-margin">
                                            <h3 class="descripcion"><?php echo $nombreProyecto; ?></h3>
                                        </div>
                                    </div>
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
                    <div class="span4 right">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalPerfil" class="modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de perfil
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNombrePerfil"><?php $translate->__('Nombre'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombrePerfil" name="txtNombrePerfil" type="text" placeholder="Ingrese nombre de perfil" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtDescripcionPerfil"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea id="txtDescripcionPerfil" name="txtDescripcionPerfil"></textarea>
                    </div>
                </div>
                <div class="row">
                    <label for="txtAbreviaturaPerfil"><?php $translate->__('Abreviatura'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAbreviaturaPerfil" name="txtAbreviaturaPerfil" type="text" placeholder="Ingrese abreviatura de perfil" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarPerfil" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarPerfil" type="button" class="command-button mode-add default">Limpiar</button>
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
<script src="dist/js/app/settings/usuario-script.min.js"></script>