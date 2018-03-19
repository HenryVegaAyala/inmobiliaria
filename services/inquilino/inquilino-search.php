<?php
require '../../adata/Db.class.php';
require '../../bussiness/inquilino.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$tipoinquilino = isset($_GET['tipoinquilino']) ? $_GET['tipoinquilino'] : 'NA';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsInquilino();

$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $id, $tipoinquilino, $criterio, $pagina);

echo json_encode($row);
flush();
?>