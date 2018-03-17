<?php
header('Content-type: text/html; charset=utf-8');
require('common/class.translation.php');
include("common/sesion.class.php");

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$codigo = $sesion->get("codigo");
$login = $sesion->get("login");
$fotoUsuario = $sesion->get("foto") == 'no-set' ? 'images/user-nosetimg-233.jpg' : $sesion->get("foto");
$idperfil = $sesion->get("idperfil");
$idproyecto_sesion = $sesion->get("idproyecto");
$idpersona = $sesion->get("idpersona");
$nombreperfil = $sesion->get("nombreperfil");

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);

$pag = (isset($_GET['pag'])) ? $_GET['pag'] : 'inicio';
$subpag = (isset($_GET['subpag'])) ? $_GET['subpag'] : "";
$op = (isset($_GET['op'])) ? $_GET['op'] : "list";
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('common/header.php'); ?>
  </head>
<?php
if( $login )
    include("common/contents.php");
else
    echo "<script> location.replace('acceso.php'); </script>";
?>
</html>