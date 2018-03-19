<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/proceso.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objProceso = new clsProceso();

if ($_POST){
	$hdIdProceso = (isset($_POST['hdIdProceso'])) ? $_POST['hdIdProceso'] : '0';
	
	if (isset($_POST['btnGuardar'])){
		$hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
		$ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';

        $objProceso->Registrar($hdIdProceso, $hdIdProyecto, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulomsje, $contenidomsje);
	}
	elseif (isset($_POST['btnReaperturar']))
		$objProceso->Reaperturar($hdIdProceso, $idusuario, $rpta, $titulomsje, $contenidomsje);
	elseif (isset($_POST['btnEliminar']))
		$objProceso->EliminarStepByStep($hdIdProceso, $idusuario, $rpta, $titulomsje, $contenidomsje);

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>