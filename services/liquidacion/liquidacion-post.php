<?php
require "../../common/sesion.class.php";
require '../../common/class.translation.php';
require '../../adata/Db.class.php';
require '../../bussiness/liquidacion.php';

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objLiquidacion = new clsLiquidacion();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdCierreLiquidacion = (isset($_POST['hdIdCierreLiquidacion'])) ? $_POST['hdIdCierreLiquidacion'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '0';
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '0';
        $txtSaldoInicial = (isset($_POST['txtSaldoInicial'])) ? $_POST['txtSaldoInicial'] : '0';

    	$objLiquidacion->LiquidacionInicial_Registrar($hdIdCierreLiquidacion, $hdIdProyecto, $hdMes, $hdAnho, $txtSaldoInicial, 0, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}