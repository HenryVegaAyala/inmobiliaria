<?php
require '../../adata/Db.class.php';
require '../../bussiness/cuentacorriente.php';

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
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '1';
$idpropietario = isset($_GET['idpropietario']) ? $_GET['idpropietario'] : '0';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '0';

$objData = new clsCuentaCorriente();

if ($tipobusqueda == '1')
	$row = $objData->ListarDetalle($idpropietario, $idproyecto, $anho);
elseif ($tipobusqueda == '2')
	$row = $objData->ListarResumenCuenta($idproyecto, $idpropietario);

echo json_encode($row);
flush();
?>