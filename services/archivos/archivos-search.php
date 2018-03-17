<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/archivos.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$criterio = isset($_GET['criterio']) ? $_GET['criterio'] : '';
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$anho = isset($_GET['anho']) ? $_GET['anho'] : date('Y');
$idproceso = isset($_GET['idproceso']) ? $_GET['idproceso'] : '0';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '0';
$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsArchivo();

$row = $objData->Listar($tipo, $id, $mes, $anho, $idproceso, $idproyecto, $criterio);

echo json_encode($row);
flush();
?>