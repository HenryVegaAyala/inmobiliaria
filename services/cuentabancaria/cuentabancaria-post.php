<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/cuentabancaria.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objCuentaBancaria = new clsCuentaBancaria();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $ddlBancoRegistro = isset($_POST['ddlBancoRegistro']) ? $_POST['ddlBancoRegistro'] : '';
        $txtDescripcion = isset($_POST['txtDescripcion']) ? $_POST['txtDescripcion'] : '';
        $ddlTipoDoc = isset($_POST['ddlTipoDoc']) ? $_POST['ddlTipoDoc'] : '';
        $txtNroDoc = isset($_POST['txtNroDoc']) ? $_POST['txtNroDoc'] : '';
        $txtNombreEmpresa = isset($_POST['txtNombreEmpresa']) ? $_POST['txtNombreEmpresa'] : '';
        $txtEmail = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';

    	$objCuentaBancaria->Registrar($hdIdPrimary, $txtDescripcion, '0', $ddlBancoRegistro, $ddlTipoDoc, $txtNroDoc, $txtNombreEmpresa, $txtEmail, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objCuentaBancaria->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>