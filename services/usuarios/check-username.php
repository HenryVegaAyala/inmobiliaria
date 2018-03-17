<?php
require '../../adata/Db.class.php';
require '../../bussiness/usuarios.php';
header('Content-type: application/json');

$valid = '';
$objUsuario = new clsUsuario();

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ( !isset($_REQUEST['txtEmail']) )
	exit;

$username = trim(strip_tags($_REQUEST['txtEmail'])); 
$username = preg_replace('/\s+/', ' ', $username);

$row = $objUsuario->checkUsername($username);
echo json_encode($row);
?>