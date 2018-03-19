<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/constructora.php');
include('../../bussiness/propietario.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$rptaPropietario = '0';
$titulomsje = '';
$contenidomsje = '';

$objConstructora = new clsConstructora();
$objPropietario = new clsPropietario();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $hdIdPropietario = (isset($_POST['hdIdPropietario'])) ? $_POST['hdIdPropietario'] : '0';
		$ddlTipoDocJuridica = (isset($_POST['ddlTipoDocJuridica'])) ? $_POST['ddlTipoDocJuridica'] : '0';
        $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
        $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
        $txtRepresentante = isset($_POST['txtRepresentante']) ? $_POST['txtRepresentante'] : '';
        $txtDireccionEmpresa = isset($_POST['txtDireccionEmpresa']) ? $_POST['txtDireccionEmpresa'] : '';
        $txtTelefonoEmpresa = isset($_POST['txtTelefonoEmpresa']) ? $_POST['txtTelefonoEmpresa'] : '';
        $txtEmailEmpresa = isset($_POST['txtEmailEmpresa']) ? $_POST['txtEmailEmpresa'] : '';
        $txtWebEmpresa = isset($_POST['txtWebEmpresa']) ? $_POST['txtWebEmpresa'] : '';
        $hdIdUbigeoJuridico = isset($_POST['hdIdUbigeoJuridico']) ? $_POST['hdIdUbigeoJuridico'] : '0';

    	$objPropietario->Registrar('JU', $hdIdPropietario, $IdEmpresa, $IdCentro, $ddlTipoDocJuridica, $txtRucEmpresa, $txtRazonSocial, $txtRepresentante, "", "", "", $txtDireccionEmpresa, $txtTelefonoEmpresa, '', $txtEmailEmpresa, "no-set", $txtWebEmpresa, $hdIdUbigeoJuridico, 1, $idusuario, $rptaPropietario, $titulomsje, $contenidomsje);

        if ($rptaPropietario != '0'){
	        $hdIdLocalidad = isset($_POST['hdIdLocalidad']) ? $_POST['hdIdLocalidad'] : '0';
	        $txtNombreConstructora = isset($_POST['txtNombreConstructora']) ? $_POST['txtNombreConstructora'] : '';
	        $ddlTipoConstructora = isset($_POST['ddlTipoConstructora']) ? $_POST['ddlTipoConstructora'] : '0';

	        $objConstructora->Registrar($hdIdPrimary, $ddlTipoConstructora, $txtNombreConstructora, $hdIdLocalidad, $rptaPropietario, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
    }
    elseif (isset($_POST['btnEliminar'])) {
        /*$chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objConstructora->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }*/

        $hdIdConstructora = $_POST['hdIdConstructora'];
        $rpta = $objConstructora->EliminarStepByStep($hdIdConstructora, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>