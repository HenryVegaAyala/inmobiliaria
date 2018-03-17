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

if ($_POST){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $validUsuario = $usuario->loginUsuario($username, $password);

  if (strlen($validUsuario['idusuario']) > 0){
    $sesion->set("idusuario", $validUsuario['idusuario']);
    $sesion->set("codigo", $validUsuario['codigo']);
    $sesion->set("login", $validUsuario['login']);
    $sesion->set("idperfil", $validUsuario['idperfil']);
    $sesion->set("nombreperfil", $validUsuario['nombreperfil']);
    $sesion->set("idpersona", $validUsuario['idpersona']);
    $sesion->set("idproyecto", $validUsuario['idproyecto']);
    $sesion->set("foto", $validUsuario['foto']);
    header("location: index.php");
  }
  else
    header("location: failed-login.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('common/header.php'); ?>
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <style>
    body {
      background: url('dist/img/bg-login.jpg') no-repeat center center fixed !important;
      -webkit-background-size: cover !important;
      -moz-background-size: cover !important;
      -o-background-size: cover !important;
      background-size: cover !important;
    }
    </style>
  </head>
  <body class="hold-transition login-page no-overflow">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php" class="white-text"><b>Cinadsac</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Inicia sesi&oacute;n para entrar al m&oacute;dulo de inmobiliaria</p>
        <form id="form1" name="form1" method="post" action="acceso.php">
          <input type="hidden" name="fromproviders" id="fromproviders" value="1">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="Usuario">
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          </div>
          <div class="row padding20">
            <!-- <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember" id="remember"> Remember Me
                </label>
              </div>
            </div>
            <div class="col-xs-4"> -->
              <button id="btnLogin" type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesi&oacute;n</button>
            <!-- </div> -->
          </div>
          <div class="row padding20">
            <a id="btnRegistro" href="registro.php" class="btn btn-primary white-text btn-block btn-flat">Registrate</a>
          </div>
        </form>

        <a href="#">Olvide mi contrase&ntilde;a</a><br>
        <!-- <a href="perfil-provider.php" class="text-center">Registrarme</a> -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <?php include('common/libraries-js.php'); ?>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        if (top != self)
          top.location.replace(document.location);

        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
