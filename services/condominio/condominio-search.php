<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/condominio.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$tipopropietario = isset($_GET['tipopropietario']) ? $_GET['tipopropietario'] : 'NA';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '2016';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsProyecto();

if ($tipo == '1')
	$row = $objData->Listar($tipobusqueda, $id, $criterio, $pagina);
elseif ($tipo == 'asignacion')
	$row = $objData->ListarParaAsignacion($tipobusqueda, $criterio, $pagina);
elseif ($tipo == 'asignacionporcuenta')
	$row = $objData->ListarParaAsignacionCuenta($tipobusqueda, $criterio, $pagina);
elseif ($tipo == 'defecto')
	$row = $objData->RegistroPorDefecto($tipobusqueda);
elseif ($tipo == 'defectoporcuenta')
	$row = $objData->RegistroPorDefectoCuenta($tipobusqueda);
elseif ($tipo == 'defecto-sinproceso')
	$row = $objData->RegistroPorDefectoSinProceso($tipobusqueda);
elseif ($tipo == 'reporte-resumen')
	$row = $objData->ReporteSaldos($tipobusqueda, $id, $anho);
echo json_encode($row);
flush();
?>