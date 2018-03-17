<?php
require '../../adata/Db.class.php';
require '../../bussiness/propietario.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'LISTADO';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$tipopropietario = isset($_GET['tipopropietario']) ? $_GET['tipopropietario'] : 'NA';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '0';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '2016';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '1';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsPropietario();

if ($tipo == 'LISTADO')
	$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $id, $tipopropietario, $criterio, $pagina);
else
	$row = $objData->ReporteSaldos($tipobusqueda, $idproyecto, $id, $anho, $mes);
echo json_encode($row);
flush();
?>