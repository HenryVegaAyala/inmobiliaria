<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/cobranza.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$rptaCobranza = '0';
$titulodetmsje = '';
$contenidodetmsje = '';
$titulomsje = '';
$contenidomsje = '';
$urlLogo = '';

$objCobranza = new clsCobranza();

if ($_POST){
	if (isset($_POST['btnGuardar'])){
		$hdIdFacturacion = (isset($_POST['hdIdFacturacion'])) ? $_POST['hdIdFacturacion'] : '0';
        $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';
		$ddlAnhoCobranza = (isset($_POST['ddlAnhoCobranza'])) ? $_POST['ddlAnhoCobranza'] : date('Y');
        $ddlMesCobranza = (isset($_POST['ddlMesCobranza'])) ? $_POST['ddlMesCobranza'] : '1';
        $ddlTipoOperacion = (isset($_POST['ddlTipoOperacion'])) ? $_POST['ddlTipoOperacion'] : '0';
        $hdIdBanco = (isset($_POST['hdIdBanco'])) ? $_POST['hdIdBanco'] : '0';
        $hdIdCuentaBancaria = (isset($_POST['hdIdCuentaBancaria'])) ? $_POST['hdIdCuentaBancaria'] : '0';
        $txtFechaCobranza = (isset($_POST['txtFechaCobranza'])) ? fecha_mysql($_POST['txtFechaCobranza']) : date('Y-m-d');
        $txtAnteriorDeuda = (isset($_POST['txtAnteriorDeuda'])) ? $_POST['txtAnteriorDeuda'] : '0';
        $txtNroOperacion = (isset($_POST['txtNroOperacion'])) ? $_POST['txtNroOperacion'] : '0';
        $txtImporteCobranza = (isset($_POST['txtImporteCobranza'])) ? $_POST['txtImporteCobranza'] : '0';
        $txtImporteMora = (isset($_POST['txtImporteMora'])) ? $_POST['txtImporteMora'] : '0';
        $hdTieneFactura = (isset($_POST['hdTieneFactura'])) ? $_POST['hdTieneFactura'] : '0';
        $chkImporteDetallado = (isset($_POST['chkImporteDetallado'])) ? $_POST['chkImporteDetallado'] : '0';
        $detalleFacturas = json_decode(stripslashes($_POST['detalleFacturas']));

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
            $nombre_archivo = preg_replace("/[^a-zA-Z0-9.]/", "", $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador)) {
                $urlLogo = $url_folder.$nombre_archivo;
            }
            else {
                $urlLogo = $hdFoto;
            }
        }

        if ($hdTieneFactura == '1') {
            $contador_facturas = 1;
            $countFacturas = count($detalleFacturas);
            
            if ($countFacturas > 0) {
                if ($chkImporteDetallado == 0) {
                    if ($countFacturas > 1) {
                        $txtImporteCobranza = $txtImporteCobranza / $countFacturas;
                    }

                    // $txtImporteCobranza = $txtImporteCobranza - $txtImporteMora;

                    foreach ($detalleFacturas as $item) {
                        if ($contador_facturas == $countFacturas)
                            $txtImporteCobranza = $txtImporteCobranza - $txtImporteMora;

                        $objCobranza->Registrar($item->idfacturacion, $hdIdProyecto, $hdIdPropiedad, $hdIdConcepto, $txtFechaCobranza, $txtImporteCobranza, $txtImporteMora, $ddlTipoOperacion, $hdIdBanco, $hdIdCuentaBancaria, $txtNroOperacion, '00', $item->anho, $item->mes, $ddlAnho, $ddlMes, $urlLogo, $hdTieneFactura, $idusuario, $rptaCobranza, $titulomsje, $contenidomsje);
                        
                        $objCobranza->RegistraCobranzaFactura($item->idfacturacion, $rptaCobranza, $hdIdProyecto, $hdIdPropiedad, $txtImporteCobranza, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

                        ++$contador_facturas;
                    }
                }
                else {
                    

                    foreach ($detalleFacturas as $item) {
                        if ($contador_facturas == $countFacturas)
                            $txtImporteCobranza = $item->importe - $txtImporteMora;
                        else
                            $txtImporteCobranza = $item->importe;

                        $objCobranza->Registrar($item->idfacturacion, $hdIdProyecto, $hdIdPropiedad, $hdIdConcepto, $txtFechaCobranza, $txtImporteCobranza, $txtImporteMora, $ddlTipoOperacion, $hdIdBanco, $hdIdCuentaBancaria, $txtNroOperacion, '00', $item->anho, $item->mes, $ddlAnho, $ddlMes, $urlLogo, $hdTieneFactura, $idusuario, $rptaCobranza, $titulomsje, $contenidomsje);
                        
                        $objCobranza->RegistraCobranzaFactura($item->idfacturacion, $rptaCobranza, $hdIdProyecto, $hdIdPropiedad, $txtImporteCobranza, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

                        ++$contador_facturas;
                    }
                }
            }
        }
        else {
            // if (isset($_POST['ddlMesesCobranza'])) {
            //     $meses = $_POST['ddlMesesCobranza'];

                // foreach($meses as $mes) {
                    // if ($mes > 0) {
                        $objCobranza->Registrar(0, $hdIdProyecto, $hdIdPropiedad, $hdIdConcepto, $txtFechaCobranza, $txtImporteCobranza, $txtImporteMora, $ddlTipoOperacion, $hdIdBanco, $hdIdCuentaBancaria, $txtNroOperacion, '00', $ddlAnhoCobranza, $ddlMesCobranza, $ddlAnho, $ddlMes, $urlLogo, $hdTieneFactura, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    // }
                // }
            // }
                
            // $objCobranza->RegistraCobranzaFactura(0, $rptaCobranza, $hdIdProyecto, $txtImporteCobranza, $ddlAnho, $ddlMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);
        }

        $rpta = '1';
	}
    elseif (isset($_POST['btnSumarSaldo_OtroAnho'])) {
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : date('Y');
        $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';

        $titulomsje = $objCobranza->CobranzaFacturaSaldo__OtroAnho($hdIdProyecto, $ddlAnho, $hdIdPropiedad);
    }

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>