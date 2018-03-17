<?php
require '../../adata/Db.class.php';
require '../../bussiness/usuarios.php';

$IdEmpresa = '1';
$IdCentro = '1';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$idusuario = isset($_GET['idusuario']) ? $_GET['idusuario'] : '0';

$objData = new clsUsuario();

$row = $objData->ObtenerPersona($idusuario);

if (isset($row))
	echo json_encode($row);
flush();
?>