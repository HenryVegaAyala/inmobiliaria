<?php
require '../../adata/Db.class.php';
require '../../bussiness/perfil.php';

$IdEmpresa = '1';
$IdCentro = '1';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipobusqueda = (isset($_GET['tipobusqueda'])) ? $_GET['tipobusqueda'] : '1';
$idperfil = (isset($_GET['idperfil'])) ? $_GET['idperfil'] : '0';
$idusuario = (isset($_GET['idusuario'])) ? $_GET['idusuario'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsPerfil();
if ($tipobusqueda == 'PERFILUSER')
	$row = $objData->PerfilUsuarioListar($tipobusqueda, $idperfil, $idusuario);
else
	$row = $objData->Listar($tipobusqueda, $idperfil, $criterio);

if (isset($row))
	echo json_encode($row);
flush();
?>