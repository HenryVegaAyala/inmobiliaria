<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/liquidacion.php';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '1';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '0';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '0';

$objData = new clsLiquidacion();

$row = $objData->LiquidacionInicial_Listar($tipobusqueda, $id, $idproyecto, $anho, $mes);

echo json_encode($row);
flush();
?>