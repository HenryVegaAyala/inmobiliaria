<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/modelocarta.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objModeloCarta = new clsModeloCarta();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtNombreModelo = (isset($_POST['txtNombreModelo'])) ? $_POST['txtNombreModelo'] : '0';
        $txtEstructura = (isset($_POST['txtEstructura'])) ? $_POST['txtEstructura'] : '';

    	$objModeloCarta->Registrar($hdIdPrimary, $txtNombreModelo, $txtEstructura, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objModeloCarta->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}