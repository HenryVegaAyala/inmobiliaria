<?php
require '../../adata/Db.class.php';
require '../../bussiness/gasto.php';

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
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '1';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '0';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '0';
$tipogasto = isset($_GET['tipogasto']) ? $_GET['tipogasto'] : '00';

$objData = new clsGasto();

if ($tipo == 'LISTADO')
	$row = $objData->Listar($tipobusqueda, $id, 0, 0, $pagina);
elseif ($tipo == 'DETALLE')
	$row = $objData->ListarConceptoGasto($tipobusqueda, $id);
elseif ($tipo == 'DETALLADO')
	$row = $objData->ListarDetallado($idproyecto, $anho, $tipogasto);
elseif ($tipo == 'GETDATA')
	$row = $objData->Obtener($id);
elseif ($tipo == 'LIQUIDACION')
	$row = $objData->GastoResumen_liquidacion($idproyecto, $anho, $mes);
elseif ($tipo == 'TOTAL')
	$row = $objData->ObtenerImporte_Proyecto($idproyecto, $anho, $mes);

echo json_encode($row);
flush();
?>