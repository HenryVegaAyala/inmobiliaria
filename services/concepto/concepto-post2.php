<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/concepto.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$rptaConcepto = '0';
$titulodetmsje = '';
$contenidodetmsje = '';
$titulomsje = '';
$contenidomsje = '';

$cantidadCaracter = '0';
$cantidadDecimales = '0';

$objConcepto = new clsConcepto();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlTipoConcepto = (isset($_POST['ddlTipoConcepto'])) ? $_POST['ddlTipoConcepto'] : '0';
        $ddlSubTipoConcepto = (isset($_POST['ddlSubTipoConcepto'])) ? $_POST['ddlSubTipoConcepto'] : '0';
        $chkAscensor = (isset($_POST['chkAscensor'])) ? $_POST['chkAscensor'] : '0';
        $chkFormula = (isset($_POST['chkFormula'])) ? $_POST['chkFormula'] : '0';
        $chkEscalonable = (isset($_POST['chkEscalonable'])) ? $_POST['chkEscalonable'] : '0';
        $txtFormula = (isset($_POST['txtFormula'])) ? $_POST['txtFormula'] : '';
        $htmlFormula = (isset($_POST['htmlFormula'])) ? $_POST['htmlFormula'] : '';
        $txtNombreConcepto = (isset($_POST['txtNombreConcepto'])) ? $_POST['txtNombreConcepto'] : '';
        $txtTituloConcepto = (isset($_POST['txtTituloConcepto'])) ? $_POST['txtTituloConcepto'] : '';
        $ddlTipoValor = (isset($_POST['ddlTipoValor'])) ? $_POST['ddlTipoValor'] : '0';
        $txtCantidadCaracter = (isset($_POST['txtCantidadCaracter'])) ? $_POST['txtCantidadCaracter'] : '0';
        $detalleEscalonable = json_decode(stripslashes($_POST['detalleEscalonable']));

        if ($ddlTipoValor == '00')
            $cantidadCaracter = $txtCantidadCaracter;
        else
            $cantidadDecimales = $txtCantidadCaracter;

    	$objConcepto->Registrar($hdIdPrimary, $hdIdProyecto, $txtNombreConcepto, $ddlTipoConcepto, $ddlSubTipoConcepto, $chkAscensor, $chkFormula, $txtFormula, $htmlFormula, $chkEscalonable, $txtTituloConcepto, $ddlTipoValor, $cantidadCaracter, $cantidadDecimales, $idusuario, $rptaConcepto, $titulomsje, $contenidomsje);

        if ($rptaConcepto != '0'){
            if ($chkFormula == '1'){
                $chkItemConcepto = (isset($_POST['chkItemConcepto'])) ? $_POST['chkItemConcepto'] : '0';
                
                $objConcepto->RegistrarDetalle($rptaConcepto, $chkItemConcepto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
            }
            else {
                if ($chkEscalonable != '0'){
                    $objConcepto->EliminarEscalonables($rptaConcepto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
                    
                    foreach ($detalleEscalonable as $item){
                        $objConcepto->RegistrarEscalonables($rptaConcepto, $item->valorinicial, $item->valorfinal, $item->valorescala, $item->textointervalo, $idusuario);
                    }
                }
            }
            
            $rpta = $rptaConcepto;
        }
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objConstructora->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>