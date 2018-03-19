<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/condominio.php');
include('../../bussiness/propiedad.php');
include('../../bussiness/torre.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$counterDocIdentidad = 0;
$counterValidItems = 0;

$strListItems = '';
$rpta = '0';
$rptaProyecto = '0';
$rptaPropiedad = '0';
$rptaTorre = '0';
$titulomsje = '';
$contenidomsje = '';
$titulodetmsje = '';
$contenidodetmsje = '';
$urlLogo = '';

$objProyecto = new clsProyecto();
$objPropiedad = new clsPropiedad();
$objTorre = new clsTorre();

if ($_POST){
    if (isset($_POST['btnGuardar'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';        
        $hdIdConstructora = (isset($_POST['hdIdConstructora'])) ? $_POST['hdIdConstructora'] : '0';
        $hdIdLocalidad = isset($_POST['hdIdLocalidad']) ? $_POST['hdIdLocalidad'] : '0';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';
        $txtCodigoProyecto = isset($_POST['txtCodigoProyecto']) ? $_POST['txtCodigoProyecto'] : '';
        $txtNombreProyecto = isset($_POST['txtNombreProyecto']) ? $_POST['txtNombreProyecto'] : '';
        $txtDireccion = isset($_POST['txtDireccion']) ? $_POST['txtDireccion'] : '';
        $ddlTipoProyecto = isset($_POST['ddlTipoProyecto']) ? $_POST['ddlTipoProyecto'] : '0';
        $ddlTipoValoracion = isset($_POST['ddlTipoValoracion']) ? $_POST['ddlTipoValoracion'] : '0';
        $chkCobroDiferenciado = isset($_POST['chkCobroDiferenciado']) ? $_POST['chkCobroDiferenciado'] : '0';
        $chkDatoSimpleDuplex = isset($_POST['chkDatoSimpleDuplex']) ? $_POST['chkDatoSimpleDuplex'] : '0';
        $chkPorcjDuplex = isset($_POST['chkPorcjDuplex']) ? $_POST['chkPorcjDuplex'] : '0';
        $txtPorcjDuplex = isset($_POST['txtPorcjDuplex']) ? $_POST['txtPorcjDuplex'] : '0';
        $ddlBanco = isset($_POST['ddlBanco']) ? $_POST['ddlBanco'] : '0';
        $ddlCuentaBancaria = isset($_POST['ddlCuentaBancaria']) ? $_POST['ddlCuentaBancaria'] : '0';
        $txtDireccionPago = isset($_POST['txtDireccionPago']) ? $_POST['txtDireccionPago'] : '';
        $txtEmailPago = isset($_POST['txtEmailPago']) ? $_POST['txtEmailPago'] : '';
        $detalleConcepto = json_decode(stripslashes($_POST['detalleConcepto']));

        if (empty($_FILES['archivo']['name'])) {
            $urlLogo = $hdFoto;
        }
        else {
            $upload_folder  = '../../media/images/';
            $url_folder  = 'media/images/';

            $nombre_archivo = $_FILES['archivo']['name'];
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $nombre_archivo = trim($nombre_archivo);
            $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador)) {
                $urlLogo = $url_folder.$nombre_archivo;
            }
            else {
                $urlLogo = $hdFoto;
            }
        }

        $objProyecto->Registrar($hdIdProyecto, $txtCodigoProyecto, $txtNombreProyecto, $ddlTipoProyecto, $ddlTipoValoracion, $hdIdConstructora, $hdIdLocalidad, $txtDireccion, $chkCobroDiferenciado, $chkDatoSimpleDuplex, $chkPorcjDuplex, $txtPorcjDuplex, $urlLogo, $ddlBanco, $ddlCuentaBancaria, $txtDireccionPago, $txtEmailPago, $idusuario, $rptaProyecto, $titulomsje, $contenidomsje);

        if ($rptaProyecto != '0'){
            $objProyecto->EliminarConceptoProyecto($rptaProyecto, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

            if (is_array($detalleConcepto)){
                foreach ($detalleConcepto as $itemconcepto) {
                    $objProyecto->RegistrarConceptoProyecto($rptaProyecto,$itemconcepto->codigoconcepto, (strlen($itemconcepto->valorconcepto) == 0 ? 0 : $itemconcepto->valorconcepto), $itemconcepto->tiporesultado, $idusuario, $rpta, $titulomsje, $contenidomsje);
                }
            }
        }

        $rpta = $rptaProyecto;
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objProyecto->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    elseif (isset($_POST['btnEliminarItem'])) {
        $hdIdProyecto = $_POST['hdIdProyecto'];
        $rpta = $objProyecto->EliminarStepByStep($hdIdProyecto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnRelacionar'])) {
        $hdIdDepartamento = $_POST['hdIdDepartamento'];
        $hdIdPropiedad = $_POST['hdIdPropiedad'];
        $rpta = $objPropiedad->Relacionar($hdIdDepartamento, $hdIdPropiedad, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnBreakRelacion'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objPropiedad->RomperRelaciones($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    elseif (isset($_POST['btnPropiedadMasiva'])) {
        //sleep(10);
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $txtNombrePropiedad = (isset($_POST['txtNombrePropiedad'])) ? $_POST['txtNombrePropiedad'] : '0';
        $txtRatioPropiedad = (isset($_POST['txtRatioPropiedad'])) ? $_POST['txtRatioPropiedad'] : '0';
        $txtImporteFijoPropiedad = (isset($_POST['txtImporteFijoPropiedad'])) ? $_POST['txtImporteFijoPropiedad'] : '0';
        $txtSaldoInicial = (isset($_POST['txtSaldoInicial'])) ? $_POST['txtSaldoInicial'] : '0';
        $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';
        $hdIdTorre = (isset($_POST['hdIdTorre'])) ? $_POST['hdIdTorre'] : '0';
        $ddlTipoPropiedad = isset($_POST['ddlTipoPropiedad']) ? $_POST['ddlTipoPropiedad'] : '0';
        $chkIngresoTorre = isset($_POST['chkIngresoTorre']) ? $_POST['chkIngresoTorre'] : '0';
        $txtIngresoTorre = isset($_POST['txtIngresoTorre']) ? $_POST['txtIngresoTorre'] : '';
        $txtNroSuministro = isset($_POST['txtNroSuministro']) ? $_POST['txtNroSuministro'] : '';
        $txtAreaTechada = isset($_POST['txtAreaTechada']) ? $_POST['txtAreaTechada'] : '0';
        $txtAreaSinTechar = isset($_POST['txtAreaSinTechar']) ? $_POST['txtAreaSinTechar'] : '0';
        $txtAreaPropiedad = isset($_POST['txtAreaPropiedad']) ? $_POST['txtAreaPropiedad'] : '0';
        $ddlClasePropiedad = isset($_POST['ddlClasePropiedad']) ? $_POST['ddlClasePropiedad'] : '0';
        // $hdOrden = isset($_POST['hdOrden']) ? $_POST['hdOrden'] : '0';
        //$detalleConcepto = json_decode(stripslashes($_POST['detalleConcepto']));
        //$detalleConceptoFormula = json_decode(stripslashes($_POST['detalleConceptoFormula']));

        if ($chkIngresoTorre != '0'){
            $objTorre->Registrar($hdIdTorre, $txtIngresoTorre, $txtNroSuministro, $hdIdProyecto, $idusuario,  $rptaTorre, $titulomsje, $contenidomsje);
        }
        else {
            $rptaTorre = $hdIdTorre;
        }

        $objPropiedad->Registrar($hdIdPropiedad, $txtNombrePropiedad, $hdIdProyecto, $ddlTipoPropiedad, "", $rptaTorre, $txtAreaPropiedad, $txtAreaSinTechar, $txtAreaTechada, $txtRatioPropiedad, $txtImporteFijoPropiedad, $txtSaldoInicial, $ddlClasePropiedad, $idusuario, $rptaPropiedad, $titulomsje, $contenidomsje);

        //echo $rptaPropiedad;
        //echo $rptaPropiedad;

        /*if ($rptaPropiedad != '0'){
            //$countConcepto = count($detalleConcepto);
            //$countConceptoFormula = count($detalleConceptoFormula);

            //if ($countConcepto > 0 || $countConceptoFormula > 0){
                $objPropiedad->EliminarConceptoPropiedad($rptaPropiedad, $hdIdProyecto, $idusuario, $rpta, $titulomsje, $contenidomsje);
            //}

            //if ($countConcepto > 0) {
                foreach ($detalleConcepto as $itemconcepto) {
                    $objPropiedad->RegistrarConceptoPropiedad($rptaPropiedad, $hdIdProyecto, $itemconcepto->codigoconcepto, $itemconcepto->valorconcepto, $itemconcepto->tiporesultado, $idusuario, $rpta, $titulomsje, $contenidomsje);
                }
            //}

            //if ($countConceptoFormula > 0) {
                foreach ($detalleConceptoFormula as $itemformula) {
                    $objPropiedad->RegistrarConceptoPropiedad($rptaPropiedad, $hdIdProyecto, $itemformula->codigoconcepto, $itemformula->valorconcepto, $itemformula->tiporesultado, $idusuario, $rpta, $titulomsje, $contenidomsje);
                }
            //}
        }*/

        $rpta = $rptaPropiedad;
    }
    elseif (isset($_POST['btnEliminarPropiedad'])) {
        /*$chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $rpta = $objPropiedad->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }*/
        $hdIdPropiedad = $_POST['hdIdPropiedad'];
        $rpta = $objPropiedad->EliminarStepByStep($hdIdPropiedad, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnFijarProyecto'])) {
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';        
        
        $objProyecto->FijarProyecto($hdIdProyecto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}

?>