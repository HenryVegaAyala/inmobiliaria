<?php
require '../../adata/Db.class.php';
require '../../bussiness/proceso.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$criterio = isset($_GET['criterio']) ? $_GET['criterio'] : '';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '0';

$objData = new clsProceso();

if ($tipobusqueda == 'ANHO')
	$row = $objData->ListarAnho($idproyecto);
elseif ($tipobusqueda == 'LISTADO')
	$row = $objData->Listar($tipo, $id, $criterio);

echo json_encode($row);
flush();
?>