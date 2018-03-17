<?php
require('common/class.translation.php');
require("common/sesion.class.php");
require("adata/Db.class.php");
require("bussiness/usuarios.php");

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);

$rpta = 0;
$sesion = new sesion();
$usuario = new clsUsuario();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('common/header.php'); ?>

    <style type="text/css">
    body {
      background: url('dist/img/bg-login.jpg') no-repeat center center fixed !important;
      -webkit-background-size: cover !important;
      -moz-background-size: cover !important;
      -o-background-size: cover !important;
      background-size: cover !important;
    }
    </style>
  </head>
  <body class="metro">
    <form id="form1" name="form1" method="post" action="services/usuarios/registro-post.php" class="transparent">
        <div id="modalGenPDF" class="modal-dialog-x modalsiete modal-example-content block">
            <div class="modal-example-header no-overflow">
                <h2 class="no-margin b-hide">
                    <span id="lblTitleGenPDF">Registro de usuario</span>
                </h2>
            </div>
            <div class="modal-example-body">
                <div id="pnlForm" class="row all-height">
                    <div class="col-md-4 all-height text-center pos-rel">
                        <img src="dist/img/user-nosetimg-233.jpg" alt="" id="imgFoto" data-src="dist/img/user-nosetimg-233.jpg" />
                        <input type="file" id="fileUploadImage">
                        <button id="btnResetImage" class="btn btn-danger compositor-cleansel-button oculto" type="button"><i class="icon-undo"></i></button>
                        <button class="btn btn-danger compositor-upload-button" type="button" data-hint-position="top" title="Cambiar imagen"><i class="icon-upload"></i></button>
                    </div>
                    <div class="col-md-8 all-height">
                        <div class="scrollbarra">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtNombre"><?php $translate->__('Usuario'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre de usuario" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="txtNumeroDoc"><?php $translate->__('N&uacute;mero de documento'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNumeroDoc" name="txtNumeroDoc" type="text" placeholder="Ingrese n&uacute;mero de documento" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="txtNombres"><?php $translate->__('Nombres'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNombres" name="txtNombres" type="text" placeholder="Ingrese nombres" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            <div>
                                <div class="col-md-12">
                                    <label for="txtApellidos"><?php $translate->__('Apellidos'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtApellidos" name="txtApellidos" type="text" placeholder="Ingrese apellidos" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtClave"><?php $translate->__('Clave'); ?></label>
                                    <div class="input-control password" data-role="input-control">
                                        <input id="txtClave" name="txtClave" type="password" placeholder="Ingrese clave" />
                                        <button class="btn-reveal"></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="txtConfirmClave"><?php $translate->__('Confirmar clave'); ?></label>
                                    <div class="input-control password" data-role="input-control">
                                        <input id="txtConfirmClave" name="txtConfirmClave" type="password" placeholder="Confirme clave" />
                                        <button class="btn-reveal"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtEmail" name="txtEmail" type="text" placeholder="Ingrese email" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="txtTelefono"><?php $translate->__('Telefono/Celular'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtTelefono" name="txtTelefono" type="text" placeholder="Ingrese telefono" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-example-footer padding10">
                <div class="grid fluid">
                    <div class="row">
                        <div class="span3 right">
                            <button id="btnGuardar" name="btnGuardar" type="submit" class="btn btn-success btn-large center-block">Registrarse</a>
                        </div>
                        <div class="span4 right">
                            <a href="acceso.php" class="btn btn-primary btn-large white-text center-block">Loguearse</a>
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
    <script src="dist/js/app/security/registro.js"></script>
  </body>
</html>
