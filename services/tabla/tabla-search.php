<?php

require '../../adata/Db.class.php';
require '../../bussiness/tabla.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors', 1);

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '';
$campo = isset($_GET['campo']) ? $_GET['campo'] : '';
$valorexcluido = isset($_GET['valorexcluido']) ? $_GET['valorexcluido'] : '';
$codigoreferencia = isset($_GET['codigoreferencia']) ? $_GET['codigoreferencia'] : '0';

$objData = new clsTabla();

if ($tipobusqueda === 'REFERENCIA') {
    $row = $objData->ValorReferencia($campo, $codigoreferencia);
}

echo json_encode($row);
flush();
