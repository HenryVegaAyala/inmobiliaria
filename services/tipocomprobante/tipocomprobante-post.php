<?php
include("../../common/sesion.class.php");
include('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/tipocomprobante.php');

$objData = new clsTipoComprobante();

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$strListItems = '';
$strListDelete = '';
$strListValids = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

if ($_POST){
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = $_POST['hdIdPrimary'];
        $txtNombre = $_POST['txtNombre'];
        $txtDescripcion = $_POST['txtDescripcion'];
        $txtCodigoSunat = $_POST['txtCodigoSunat'];
        $txtAbreviatura = $_POST['txtAbreviatura'];

        $objData->Registrar($hdIdPrimary, $txtNombre, $txtDescripcion, $txtCodigoSunat, $txtAbreviatura, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif ($_POST['btnEliminar']) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $countCheckItems = count($chkItem);
                $strListItems = implode(',', $chkItem);
                $rpta = $objData->MultiDelete($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>