<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/cuentacorriente.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objCuentaCorriente = new clsCuentaCorriente();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
		$hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
		$ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $detalleCuenta = json_decode(stripslashes($_POST['detalleCuenta']));

        $objCuentaCorriente->EliminarDetalle($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);

	    foreach ($detalleCuenta as $item) {
	    	$objCuentaCorriente->RegistrarDetalle($hdIdPrimary, '0', $ddlAnho, $item->mes, '0', $item->importefacturado, $item->importepagado, $item->importesaldo, $idusuario, $rpta, $titulomsje, $contenidomsje);
	    }
	}

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
	echo json_encode($jsondata);
}