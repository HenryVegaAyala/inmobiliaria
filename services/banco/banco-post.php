<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/banco.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objBanco = new clsBanco();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtDescripcion = isset($_POST['txtDescripcion']) ? $_POST['txtDescripcion'] : '';
        $txtCodigoSunat = isset($_POST['txtCodigoSunat']) ? $_POST['txtCodigoSunat'] : '';

    	$objBanco->Registrar($hdIdPrimary, $txtDescripcion, $txtCodigoSunat, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $objBanco->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>