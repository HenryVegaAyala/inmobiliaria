<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/concepto.php');
include('../../common/functions.php');

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
        $chkSaldoAnterior = (isset($_POST['chkSaldoAnterior'])) ? $_POST['chkSaldoAnterior'] : '0';
        $chkConsumoAgua = (isset($_POST['chkConsumoAgua'])) ? $_POST['chkConsumoAgua'] : '0';
        $txtFormula = (isset($_POST['txtFormula'])) ? $_POST['txtFormula'] : '';
        $htmlFormula = (isset($_POST['htmlFormula'])) ? $_POST['htmlFormula'] : '';
        $textoNombreConcepto = (isset($_POST['txtNombreConcepto'])) ? $_POST['txtNombreConcepto'] : '';
        $txtTituloConcepto = (isset($_POST['txtTituloConcepto'])) ? $_POST['txtTituloConcepto'] : '';
        $ddlTipoValor = (isset($_POST['ddlTipoValor'])) ? $_POST['ddlTipoValor'] : '0';
        $txtCantidadCaracter = (isset($_POST['txtCantidadCaracter'])) ? $_POST['txtCantidadCaracter'] : '0';

        if ($ddlTipoValor == '00')
            $cantidadCaracter = $txtCantidadCaracter;
        else
            $cantidadDecimales = $txtCantidadCaracter;

        $txtNombreConcepto = str_replace('"', "", $textoNombreConcepto);
        $txtTituloConcepto = str_replace('"', "", $txtTituloConcepto);
        
        $txtNombreConcepto = replace_quotes($txtNombreConcepto);
        $txtTituloConcepto = replace_quotes($txtTituloConcepto);

        // $txtNombreConcepto = str_replace("'", "", $txtNombreConcepto);

        // $txtNombreConcepto = string_sanitize($txtNombreConcepto);

        // $txtNombreConcepto = str_replace(array('\'', '"'), '', $txtNombreConcepto);

        // $porfavor = serialize($texto);    # safe -- won't count the slash 
        // $txtNombreConcepto = addslashes($porfavor);

        // $special_quotes = array(chr(145),chr(146),chr(147),chr(148),chr(151));
        // $txtNombreConcepto = str_replace($special_quotes, "", $texto);

        // $txtNombreConcepto = str_replace(array("'", "\"", "&quot;"), "", htmlspecialchars($txtNombreConcepto));

        // $txtNombreConcepto = str_replace(chr(34), chr(39), $txtNombreConcepto);

    	$objConcepto->Registrar($hdIdPrimary, $hdIdProyecto, $txtNombreConcepto, $ddlTipoConcepto, $ddlSubTipoConcepto, $chkAscensor, $chkFormula, $txtFormula, $htmlFormula, $chkEscalonable, $txtTituloConcepto, $ddlTipoValor, $cantidadCaracter, $cantidadDecimales, $chkSaldoAnterior, $chkConsumoAgua, $idusuario, $rptaConcepto, $titulomsje, $contenidomsje);

        if ($rptaConcepto != '0'){
            if ($chkFormula == '1'){
                $chkItemConcepto = (isset($_POST['chkItemConcepto'])) ? $_POST['chkItemConcepto'] : '0';
                
                $objConcepto->RegistrarDetalle($rptaConcepto, $chkItemConcepto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
            }
            else {
                if ($chkEscalonable != '0'){
                    if (isset($_POST['detalleEscalonable'])) {

                        $detalleEscalonable = json_decode(stripslashes($_POST['detalleEscalonable']));

                        $objConcepto->EliminarEscalonables($rptaConcepto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

                        if (is_array($detalleEscalonable)) {
                            foreach ($detalleEscalonable as $item){
                                $objConcepto->RegistrarEscalonables($rptaConcepto, $item->valorinicial, $item->valorfinal, $item->valorescala, $item->textointervalo, $idusuario);
                            }
                        }
                    }
                }
            }
            
            $rpta = $rptaConcepto;
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

        $hdIdConcepto = $_POST['hdIdConcepto'];
        $rpta = $objConcepto->EliminarStepByStep($hdIdConcepto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminarConFactura'])) {
        $hdIdConcepto = $_POST['hdIdConcepto'];
        $rpta = $objConcepto->EliminarStepByStep_ConFactura($hdIdConcepto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>