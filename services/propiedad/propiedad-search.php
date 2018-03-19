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

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$idtipopropiedad = isset($_GET['idtipopropiedad']) ? $_GET['idtipopropiedad'] : '';
$idproyecto = isset($_GET['idproyecto']) ? $_GET['idproyecto'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$codigoproyecto = isset($_GET['codigoproyecto']) ? $_GET['codigoproyecto'] : '';
$anho = isset($_GET['anho']) ? $_GET['anho'] : '';
$meses = isset($_GET['meses']) ? $_GET['meses'] : '';
$idpropietario = isset($_GET['idpropietario']) ? $_GET['idpropietario'] : '';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsPropiedad();

if ($tipobusqueda == 'propietario')
	$row = $objData->ListarPropiedadByPropietario($idtipopropiedad, $id);
else if ($tipobusqueda == 'inquilino')
	$row = $objData->ListarPropiedadByInquilino($idtipopropiedad, $id);
else if ($tipobusqueda == 'propfacturacion')
	$row = $objData->ListarPropiedadFacturacion($codigoproyecto, $anho, $meses, $idpropietario, $idtipopropiedad, $criterio, $pagina);
else if ($tipobusqueda == 'allfields')
	$row = $objData->Listar('4', $id, 'DPT', $criterio, 0);
else if ($tipobusqueda == 'relacionadas')
	$row = $objData->ListarRelacionadas($idproyecto, $id, $criterio, $pagina);
else
	$row = $objData->Listar($tipobusqueda, $id, $idtipopropiedad, $criterio, $pagina);

echo json_encode($row);
flush();
?>