<?php
require '../../adata/Db.class.php';
require '../../bussiness/propiedad.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$idtipopropiedad = isset($_GET['idtipopropiedad']) ? $_GET['idtipopropiedad'] : '0';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '0';

$objData = new clsPropiedad();

$row = $objData->GetLastIndexPropiedad($idtipopropiedad, $idproyecto);

echo json_encode($row);
flush();
?>