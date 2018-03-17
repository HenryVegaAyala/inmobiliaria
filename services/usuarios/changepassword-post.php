<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
	require '../../bussiness/usuarios.php';
    require '../../common/functions.php';
	
    $sesion = new sesion();

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
	$translate = new Translator($lang);

	$objUsuario = new clsUsuario();
    $idusuario = $sesion->get("idusuario");

    $realIp = getRealIP();

    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    
    $objUsuario->CambiarClave('CON-LOGIN', $current_password, $new_password, $idusuario, $rpta, $titulomsje, $contenidomsje);

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>