<?php
require '../../adata/Db.class.php';
require '../../bussiness/concepto.php';

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
$tipoconcepto = isset($_GET['tipoconcepto']) ? $_GET['tipoconcepto'] : '0';
$subtipoconcepto = isset($_GET['subtipoconcepto']) ? $_GET['subtipoconcepto'] : '0';
$esformula = isset($_GET['esformula']) ? $_GET['esformula'] : '0';
$escalonable = isset($_GET['escalonable']) ? $_GET['escalonable'] : '0';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '0';
$idpropiedad = isset($_GET['idpropiedad']) ? $_GET['idpropiedad'] : '0';

$objData = new clsConcepto();

if ($tipo == 'LISTADO')
	$row = $objData->Listar($tipobusqueda, $id, $criterio, $tipoconcepto, $esformula, $escalonable, $idproyecto, $pagina);
elseif ($tipo == 'ID')
	$row = $objData->ObtenerPorId($id);
elseif ($tipo == 'PROYECTO')
	$row = $objData->ListarConceptoProyecto($tipoconcepto, $subtipoconcepto, $idproyecto);
elseif ($tipo == 'PROPIEDAD')
	$row = $objData->ListarConceptoPropiedad($tipoconcepto, $subtipoconcepto, $idproyecto, $idpropiedad);
elseif ($tipo == 'ESCALONABLE')
	$row = $objData->ListarEscalonables($tipobusqueda, $id);

echo json_encode($row);
flush();
?>