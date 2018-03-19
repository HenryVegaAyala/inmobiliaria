<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require "../../common/sesion.class.php";
require '../../common/class.translation.php';
require '../../adata/Db.class.php';
require '../../bussiness/gasto.php';
require '../../common/functions.php';

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$rptaGasto = '0';
$titulodetmsje = '';
$contenidodetmsje = '';
$titulomsje = '';
$contenidomsje = '';

$cantidadCaracter = '0';
$cantidadDecimales = '0';

$objGasto = new clsGasto();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';

        $ddlTipoGasto = (isset($_POST['ddlTipoGasto'])) ? $_POST['ddlTipoGasto'] : '0';
        $ddlTipoDesembolso = (isset($_POST['ddlTipoDesembolso'])) ? $_POST['ddlTipoDesembolso'] : '0';
        $ddlTipoAfectacion = (isset($_POST['ddlTipoAfectacion'])) ? $_POST['ddlTipoAfectacion'] : '0';
        $hdIdProveedor = (isset($_POST['hdIdProveedor'])) ? $_POST['hdIdProveedor'] : '0';
        $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';
        $hdIdPropietario = (isset($_POST['hdIdPropietario'])) ? $_POST['hdIdPropietario'] : '0';
        $txtFecha = (isset($_POST['txtFecha'])) ? fecha_mysql($_POST['txtFecha']) : date('Y-m-d');
        $txtNroSuministro = (isset($_POST['txtNroSuministro'])) ? $_POST['txtNroSuministro'] : '';
        $ddlTipoDocumento = (isset($_POST['ddlTipoDocumento'])) ? $_POST['ddlTipoDocumento'] : '0';
        $txtSerieDocumento = (isset($_POST['txtSerieDocumento'])) ? $_POST['txtSerieDocumento'] : '';
        $txtNroDocumento = (isset($_POST['txtNroDocumento'])) ? $_POST['txtNroDocumento'] : '';

        $txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : '';

        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';
        $txtImporte = (isset($_POST['txtImporte'])) ? $_POST['txtImporte'] : '0';
        // $detalleRegistro = json_decode(stripslashes($_POST['detalleRegistro']));

        $objGasto->Registrar($hdIdPrimary, $hdIdProyecto, $ddlTipoGasto, $ddlTipoDesembolso, $hdIdConcepto, $txtNroSuministro, $txtDescripcion, $ddlMes, $ddlAnho, 1, 1, $hdIdProveedor, $ddlTipoDocumento, $txtSerieDocumento, $txtNroDocumento, $txtFecha, $txtImporte, $ddlTipoAfectacion, $hdIdPropietario, 0, $txtFecha, $idusuario, $rpta, $titulomsje, $contenidomsje);

    	// $objGasto->Registrar($hdIdPrimary, $hdIdProyecto, '0', 1, $ddlAnho, $ddlMes, $txtImporteTotal, $idusuario, $rptaGasto, $titulomsje, $contenidomsje);

        // if ($rptaGasto != '0'){
        //     $objGasto->EliminarConceptoGasto($rptaGasto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

        //     foreach ($detalleRegistro as $item) {
        //         $objGasto->RegistrarConceptoGasto($rptaGasto, $hdIdProyecto, $item->idconcepto, $item->cantidad, $item->precio, $item->subtotal, $item->tiporesultado, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
        //     }

        //     $rpta = $rptaGasto;
        // }
    }
    elseif (isset($_POST['btnEliminar'])) {
        /*$chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objGasto->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }*/
        $hdIdGasto = $_POST['hdIdGasto'];
        $rpta = $objGasto->EliminarStepByStep($hdIdGasto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>