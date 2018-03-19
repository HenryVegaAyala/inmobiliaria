<?php
require '../../adata/Db.class.php';
require '../../bussiness/cobranza.php';

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
$idfacturacion = isset($_GET['idfacturacion']) ? $_GET['idfacturacion'] : '0';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '1';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '0';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '0';

$objData = new clsCobranza();

if ($tipo == 'LISTADO')
	$row = $objData->Listar($tipobusqueda, $idfacturacion, $criterio);
elseif ($tipo == 'COBRANZAS')
	$row = $objData->ListarCobranza($tipobusqueda, $idproyecto, $anho, $mes);
elseif ($tipo == 'LIQUIDACION')
	$row = $objData->CobranzaResumen_liquidacion($idproyecto, $anho, $mes);
elseif ($tipo == 'TOTAL')
	$row = $objData->ObtenerImporte_Proyecto($idproyecto, $anho, $mes);

echo json_encode($row);
flush();
?>