<?php
require '../../adata/Db.class.php';
require '../../bussiness/constructora.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsConstructora();

if ($tipo == 'BUSQUEDA')
	$row = $objData->Listar($tipobusqueda, $criterio);
elseif ($tipo == 'ID')
	$row = $objData->ListarPorId($criterio);
elseif ($tipo == 'LISTADO')
	$row = $objData->ListarConLocalidad($tipobusqueda, $criterio);

echo json_encode($row);
flush();
?>