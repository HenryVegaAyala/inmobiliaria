<?php
require('common/class.translation.php');
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php include('common/header.php'); ?>
</head>
<body class="red metro">
    <div class="message-dialog bg-darkRed" style="padding-bottom:20px;">
        <h2 class="fg-white"><?php $translate->__('Error de inicio de sesi&oacute;n'); ?></h2>
        <p class="fg-white"><?php $translate->__('Los datos de usuario o clave proporcionados son incorrectos'); ?></p>
        <a href="acceso.php#login" class="btn btn-primary pull-right"><?php $translate->__('Iniciar sesi&oacute;n'); ?></a>
    </div>
    <?php include('common/libraries-js.php'); ?>
</body>
</html>