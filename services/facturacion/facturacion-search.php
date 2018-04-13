<?php
require '../../adata/Db.class.php';
require '../../bussiness/facturacion.php';

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
$idpropiedad = isset($_GET['idpropiedad']) ? $_GET['idpropiedad'] : '1';
$idconcepto = isset($_GET['idconcepto']) ? $_GET['idconcepto'] : '1';
$idtipopropiedad = isset($_GET['idtipopropiedad']) ? $_GET['idtipopropiedad'] : '1';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '0';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '0';
$mesini = isset($_GET['mesini']) ? $_GET['mesini'] : '0';
$mesfin = isset($_GET['mesfin']) ? $_GET['mesfin'] : '0';

$objData = new clsFacturacion();

if ($tipo == 'LISTADO')
	$row = $objData->Listar($tipobusqueda, $id, $criterio, $anho, $mes, $idtipopropiedad, $pagina);
elseif($tipo == 'ALLFIELDS')
	$row = $objData->ListarAllFields($tipobusqueda, $id, $criterio, $anho, $mes, $pagina);
elseif ($tipo == 'DETALLE')
	$row = $objData->ListarConceptoFacturacion($tipobusqueda, $id);
elseif ($tipo == 'PROPCONSUMO')
	$row = $objData->ListarPropiedadConsumo($tipobusqueda, $idproyecto, $anho, $mes, $idpropiedad);
elseif ($tipo == 'PROPCONSUMO_CONCEPTO')
	$row = $objData->ListarPropiedadConsumo_Concepto($tipobusqueda, $idproyecto, $anho, $mes, $idpropiedad, $idconcepto);
elseif ($tipo == 'CONSUMOAGUAMES')
	$row = $objData->ListarPropiedadConsumoPromedio($idproyecto, $mesini, $mesfin);
elseif ($tipo == 'FACTURACIONPROP')
	$row = $objData->ListarFacturacionPropiedad($idproyecto, $anho, $idpropiedad);
elseif ($tipo == 'FACTURACIONPROP__SUMADEUDA') {
	$row = $objData->ListarFacturacionPropiedad__SumaDeuda($idproyecto, $anho, $mes, $idpropiedad);
	$row = array('sumadeuda_mes' => $row);
}
elseif ($tipo == 'FACTURACIONPROP__SALDOMES'){
	$row = $objData->ListarFacturacionPropiedad__SaldoMes($idproyecto, $anho, $mes, $idpropiedad);
}
elseif ($tipo == 'TORRES')
	$row = $objData->ListarConsumoAscensor($tipobusqueda, $idproyecto, $anho, $mes);
elseif ($tipo == 'INCIDENCIAS')
	$row = $objData->ListarIncidenciaPropietario($idpropiedad, $idproyecto, $anho, $mes);

echo json_encode($row);
flush();
?>