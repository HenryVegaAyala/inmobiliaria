<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/presupuesto.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$rptaPresupuesto = '0';
$titulodetmsje = '';
$contenidodetmsje = '';
$titulomsje = '';
$contenidomsje = '';

$cantidadCaracter = '0';
$cantidadDecimales = '0';

$objPresupuesto = new clsPresupuesto();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';
        $txtImporteTotal = (isset($_POST['txtImporteTotal'])) ? $_POST['txtImporteTotal'] : '';
        $detalleRegistro = json_decode(stripslashes($_POST['detalleRegistro']));

    	$objPresupuesto->Registrar($hdIdPrimary, $hdIdProyecto, '0', 1, $ddlAnho, $ddlMes, $txtImporteTotal, $idusuario, $rptaPresupuesto, $titulomsje, $contenidomsje);

        if ($rptaPresupuesto != '0'){
            $objPresupuesto->EliminarConceptoPresupuesto($rptaPresupuesto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

            foreach ($detalleRegistro as $item) {
                $objPresupuesto->RegistrarConceptoPresupuesto($rptaPresupuesto, $hdIdProyecto, $item->idconcepto, $item->cantidad, $item->precio, $item->subtotal, $item->tiporesultado, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
            }

            $rpta = $rptaPresupuesto;
        }
    }
    elseif (isset($_POST['btnProyectarPresupuesto'])) {
        $hdIdPresupuesto = (isset($_POST['hdIdPresupuesto'])) ? $_POST['hdIdPresupuesto'] : '0';
        $txtNroMeses = (isset($_POST['txtNroMeses'])) ? $_POST['txtNroMeses'] : '0';

        $objPresupuesto->ProyectarPresupuesto($hdIdPresupuesto, $txtNroMeses, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        /*$chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objPresupuesto->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }*/
        $hdIdPresupuesto = $_POST['hdIdPresupuesto'];
        $rpta = $objPresupuesto->EliminarStepByStep($hdIdPresupuesto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>