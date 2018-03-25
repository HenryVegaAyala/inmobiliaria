<?php
set_time_limit(0);
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/propiedad.php');
include('../../bussiness/facturacion.php');
include('../../bussiness/cobranza.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';
$folderPDF = '';

$strcolumnasPropietario = '';
$strfilasPropietario = '';

$lecturaanterior = '0';
$lecturaactual = '0';
$consumo = '0';

$rpta = '0';
$rptaFacturacion = '0';
$titulodetmsje = '';
$contenidodetmsje = '';
$titulomsje = '';
$contenidomsje = '';

$cantidadCaracter = '0';
$cantidadDecimales = '0';

$objFacturacion = new clsFacturacion();
$objCobranza = new clsCobranza();
$objPropiedad = new clsPropiedad();

if ($_POST){
    if (isset($_POST['btnGenerar'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : date('Y');
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : date('m');
        $txtFechaVencimiento = (isset($_POST['txtFechaVencimiento'])) ? fecha_mysql($_POST['txtFechaVencimiento']) : date('Y-m-d');
        $txtFechaTope = (isset($_POST['txtFechaTope'])) ? fecha_mysql($_POST['txtFechaTope']) : date('Y-m-d');

        $objFacturacion->GenerarFacturacion($hdIdProyecto, 1, '0', $hdAnho, $hdMes, $txtFechaVencimiento, $txtFechaTope, '0', 1, $idusuario, $rpta, $titulomsje, $contenidomsje);


        // $rpta = '1';
        // $titulomsje = 'Generado correctamente';
        // $contenidomsje = "PRUEBA DE ARCHIVOS";

        // $folderPDF = $directorioServer.'../../media/pdf/'.$hdIdProyecto.$ddlAnho.$ddlMes.'/';

        // // echo $_SERVER['DOCUMENT_ROOT'] . $folderPDF;

        // if (is_dir($folderPDF))
        //     deleteDir($folderPDF);

    }
    elseif (isset($_POST['btnEliminarFacturacionPrevia'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '0';
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '0';

        $objFacturacion->EliminarFacturacionPrevia($hdIdProyecto, $hdAnho, $hdMes, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnRegenerar'])){
        $hdTipoFacturacion = (isset($_POST['hdTipoFacturacion'])) ? $_POST['hdTipoFacturacion'] : '1';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '0';
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '0';
        $txtFechaVencimiento = (isset($_POST['txtFechaVencimiento'])) ? fecha_mysql($_POST['txtFechaVencimiento']) : date('Y-m-d');
        $txtFechaTope = (isset($_POST['txtFechaTope'])) ? fecha_mysql($_POST['txtFechaTope']) : date('Y-m-d');

        $objFacturacion->GenerarFacturacion($hdIdProyecto, $hdTipoFacturacion, $hdIdPropiedad, $hdAnho, $hdMes, $txtFechaVencimiento, $txtFechaTope, '0', 1, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnSumarAgua'])) {
        $aguames = 0;
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '0';
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '0';

        // $objFacturacion->SumarAguaMes($hdIdProyecto, $hdAnho, $hdMes, $rpta, $aguames);

        $titulomsje = $objFacturacion->SumarAguaMes($hdIdProyecto, $hdAnho, $hdMes);
    }
    elseif (isset($_POST['btnCalcularConsumo'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : date('Y');
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : date('m');
        $detallePropiedad = json_decode(stripslashes($_POST['detallePropiedad']));

        $objFacturacion->EliminarConsumoEscalonable($hdIdProyecto, $hdAnho, $hdMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

        // if (isset($_POST['consumo'])) {
        //     foreach ($_POST['consumo'] as $consumo) {
        //         $objFacturacion->RegistrarConsumoEscalonable('0', $hdIdProyecto, $consumo['idpropiedad'], $hdAnho, $hdMes, 'CN00000099', $consumo['lecturaanterior'], $consumo['lecturaactual'], $consumo['consumo'], fecha_mysql($consumo['fechaini']), fecha_mysql($consumo['fechafin']), $idusuario, $rpta, $titulomsje, $contenidomsje);
        //     }
        // }
        foreach ($detallePropiedad as $item) {
            $objFacturacion->RegistrarConsumoEscalonable('0', $hdIdProyecto, $item->idpropiedad, $hdAnho, $hdMes, 'CN00000099', $item->lecturaanterior, $item->lecturaactual, $item->consumo, fecha_mysql($item->fechaini), fecha_mysql($item->fechafin), $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
    }
    elseif (isset($_POST['btnCalcularConsumo_Concepto'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';

        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : date('Y');
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : date('m');
        $detallePropiedad = json_decode(stripslashes($_POST['detallePropiedad']));

        $objFacturacion->EliminarConsumoConcepto($hdIdProyecto, $hdIdConcepto, $hdAnho, $hdMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

        foreach ($detallePropiedad as $item) {
            $objFacturacion->RegistrarConceptoVariable('0', $hdIdProyecto, $item->idpropiedad, $hdAnho, $hdMes, $hdIdConcepto, $item->importe, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }

        // if (isset($_POST['conceptovariable'])) {
        //     foreach ($_POST['conceptovariable'] as $conceptovariable) {
        //         $objFacturacion->RegistrarConceptoVariable('0', $hdIdProyecto, $conceptovariable['idpropiedad'], $hdAnho, $hdMes, $hdIdConcepto, $conceptovariable['importe'], $idusuario, $rpta, $titulomsje, $contenidomsje);
        //     }
        // }
    }
    elseif (isset($_POST['btnGenerarConceptoVariable'])) {
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : date('Y');
        $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : date('m');
        $txtImporteSaldo = (isset($_POST['txtImporteSaldo'])) ? $_POST['txtImporteSaldo'] : '0';
        $hdTotalConsumo_Gen = (isset($_POST['hdTotalConsumo_Gen'])) ? $_POST['hdTotalConsumo_Gen'] : '0';

        $rowCount = 0;

        $hdIdConcepto = $objFacturacion->ConceptoAgua($hdIdProyecto);

        if ($hdIdConcepto == '0') {
            $rpta = '0';
            $titulomsje = 'No se puede generar concepto variable por no haber un concepto de consumo de agua';
            $contenidomsje = 'La operación no pudo completarse';
        }
        else {
            $rsPropiedad = $objFacturacion->ListarPropiedadConsumo_Concepto('2', $hdIdProyecto, $hdAnho, $hdMes, 0, $hdIdConcepto);
            $countRsPropiedad =  count($rsPropiedad);

            if ($countRsPropiedad > 0) {
                $importe = ($txtImporteSaldo - $hdTotalConsumo_Gen) / $countRsPropiedad;

                $objFacturacion->EliminarConsumoConcepto($hdIdProyecto, $hdIdConcepto, $hdAnho, $hdMes, $idusuario, $rpta, $titulodetmsje, $contenidodetmsje);

                while($rowCount < $countRsPropiedad){
                    $objFacturacion->RegistrarConceptoVariable('0', $hdIdProyecto, $rsPropiedad[$rowCount]['tm_idpropiedad'], $hdAnho, $hdMes, $hdIdConcepto, $importe, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    ++$rowCount;
                }
            }
            else {
                $rpta = '0';
                $titulomsje = 'No se puede generar concepto variable por no existir propiedades para este proyecto';
                $contenidomsje = 'La operación no pudo completarse';
            }
        }
    }
    elseif (isset($_POST['btnRegistrarAscensor'])){
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';
        $detalleTorre = json_decode(stripslashes($_POST['detalleTorre']));

        foreach ($detalleTorre as $item) {
            $objFacturacion->RegistrarConsumoAscensor($item->iditem, $hdIdProyecto, $item->idtorre, $ddlMes, $ddlAnho, $item->nrosuministro, $item->importe, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
    }
    elseif (isset($_POST['btnGuardarConcepto'])){
        $hdIdFacturacion = (isset($_POST['hdIdFacturacion'])) ? $_POST['hdIdFacturacion'] : '0';
        $txtTotalImporte = (isset($_POST['txtTotalImporte'])) ? $_POST['txtTotalImporte'] : '0';
        $detalleConcepto = json_decode(stripslashes($_POST['detalleConcepto']));

        foreach ($detalleConcepto as $item) {
            $objFacturacion->RegistrarConceptoTrans($item->iditem, $item->valorconcepto, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }

        $objFacturacion->ActualizarImporteFacturacion($hdIdFacturacion, $txtTotalImporte, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnDividirFactura'])){
        $hdIdFacturacion = (isset($_POST['hdIdFacturacion'])) ? $_POST['hdIdFacturacion'] : '0';
        $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';
        $detallePropietario = json_decode(stripslashes($_POST['detallePropietario']));

        //objFacturacion->Eliminar($hdIdFacturacion, $idusuario, $rpta, $titulomsje, $contenidomsje);

        foreach ($detallePropietario as $item) {
            $objFacturacion->RegistrarIncidencias($item->iditem, $hdIdProyecto, $ddlAnho, $ddlMes, $hdIdPropiedad, $item->idpropietario, $item->diasincidencia, '000', 1, 1, 0, $idusuario, $rpta, $titulomsje, $contenidomsje);
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
        $hdIdFacturacion = $_POST['hdIdFacturacion'];
        $rpta = $objFacturacion->EliminarStepByStep($hdIdFacturacion, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnGenerarPDF']) || isset($_POST['btnExportar'])) {
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '2015';
        $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '1';
        $directorioServer = '';

        if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1'))
            $directorioServer = 'cinadsacv2';
        else
            $directorioServer = 'http://cinadsacenter.com';

        $folderPDF = $directorioServer.'/media/pdf/'.$hdIdProyecto.$ddlAnho.$ddlMes.'/';

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . $folderPDF))
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $folderPDF, 0777);

        if (isset($_POST['btnGenerarPDF'])) {
            require '../../bussiness/condominio.php';

            $objProyecto = new clsProyecto();

            $de = (isset($_POST['de'])) ? $_POST['de'] : $email_Default;
            $asunto = (isset($_POST['asunto'])) ? $_POST['asunto'] : '';
            $tipoGen = (isset($_POST['tipoGen'])) ? $_POST['tipoGen'] : 'EXPORTACION';
            $hdIdFacturacion = (isset($_POST['hdIdFacturacion'])) ? $_POST['hdIdFacturacion'] : '0';
            $hdIdPropietario = (isset($_POST['hdIdPropietario'])) ? $_POST['hdIdPropietario'] : '0';
            $hdIdPropiedad = (isset($_POST['hdIdPropiedad'])) ? $_POST['hdIdPropiedad'] : '0';
            $txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : '0';
            $txtFechaEmision =  (isset($_POST['txtFechaEmision'])) ? $_POST['txtFechaEmision'] : '';
            $txtFechaVencimiento =  (isset($_POST['txtFechaVencimiento'])) ? $_POST['txtFechaVencimiento'] : '0';
            $txtFechaTope =  (isset($_POST['txtFechaTope'])) ? $_POST['txtFechaTope'] : '0';
            $txtRatio =  (isset($_POST['txtRatio'])) ? $_POST['txtRatio'] : '0';
            $txtSimboloMoneda =  (isset($_POST['txtSimboloMoneda'])) ? $_POST['txtSimboloMoneda'] : '';
            $txtTotalImporte = (isset($_POST['txtTotalImporte'])) ? $_POST['txtTotalImporte'] : '0';

            $detalleLog = '';
            $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
            $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            $body = '';
            $strdetallePropietario = '';
            $strdetallePropiedadDPT = '';
            $strdetallePropiedadEST = '';
            $strdetallePropiedadDEP = '';
            $strdetalleConcepto = '';
            $strdetalleConsumo = '';

            // $ddlMesAnterior = $ddlMes - 1;

            // if ($ddlMesAnterior == 0){
            //     $ddlAnho = $ddlAnho - 1;
            //     $ddlMes = 12;
            // }

            /*$rowPropietarioCuenta = $objCobranza->EstadoCuentaPropietario($ddlAnho, $ddlMesAnterior, $ddlAnho, $ddlMesAnterior, $hdIdPropietario);
            $countRowPropietarioCuenta = count($rowPropietarioCuenta);

            if ($countRowPropietarioCuenta > 0) {
                $columns = array_keys($rowPropietarioCuenta[0]);

                foreach ($columns as $key => $value) {
                    if ($value != 'idfacturacion'){
                        if ($value == 'propietario')
                            continue;

                        if ($value == 'anno'){
                            $value = 'A&Ntilde;O';
                        }
                        elseif ($value == 'nombre_mes') {
                            $value = 'MES';
                        }
                        else {
                            $value = strtoupper($value);
                        }

                        $strcolumnasPropietario .= '<td class="text-center bg-blue"><strong class="fg-white">' . $value . '</strong></td>';
                    }
                }

                $i = 0;
                while ($i < $countRowPropietarioCuenta) {
                    $strfilasPropietario .= '<tr>';
                    foreach ($columns as $key => $value) {
                        if ($value != 'idfacturacion'){
                            if ($value == 'propietario')
                                continue;

                            if (is_numeric($rowPropietarioCuenta[$i][$value])) {
                                $right_align = 'text-right ';
                            }
                            else {
                                $right_align = '';
                            }

                            $strfilasPropietario .= '<td class="'.$right_align . '">' . $rowPropietarioCuenta[$i][$value] . '</td>';
                        }
                    }
                    $strfilasPropietario .= '</tr>';
                    ++$i;
                }
            }*/

            $rowProyecto = $objProyecto->ProyectoFacturar('1', $hdIdProyecto);
            $countProyecto = count($rowProyecto);

            $rowConcepto = $objFacturacion->ListarConceptoFacturacion('1', $hdIdFacturacion);
            $countConcepto = count($rowConcepto);

            $rowPropietario = $objFacturacion->ListarPropietarioPorFactura($hdIdPropiedad);
            $countPropietario = count($rowPropietario);

            $rowPropiedadDPT = $objPropiedad->ListarSimpleId($hdIdPropiedad);
            $countPropiedadDPT = count($rowPropiedadDPT);

            // // $rowPropiedadEST = $objFacturacion->ListarPropiedadPorFactura($hdIdFacturacion,  'EST', $hdIdPropietario);
            // $rowPropiedadEST = $objFacturacion->ListarPropiedad_RelacionadaProyecto($hdIdProyecto, $hdIdPropiedad, 'EST');
            // $countPropiedadEST = count($rowPropiedadEST);

            // // $rowPropiedadDEP = $objFacturacion->ListarPropiedadPorFactura($hdIdFacturacion,  'DEP', $hdIdPropietario);
            // $rowPropiedadDEP = $objFacturacion->ListarPropiedad_RelacionadaProyecto($hdIdProyecto, $hdIdPropiedad, 'DEP');
            // $countPropiedadDEP = count($rowPropiedadDEP);

            if ($countPropiedadDPT > 0) {
                // echo $rowPropiedadDPT[0]['tm_idtipopropiedad'];
                if ($rowPropiedadDPT[0]['tm_idtipopropiedad'] == 'DPT') {
                    $rowPropiedadEST = $objFacturacion->ListarPropiedad_RelacionadaProyecto($hdIdProyecto, $hdIdPropiedad, 'EST');
                    $rowPropiedadDEP = $objFacturacion->ListarPropiedad_RelacionadaProyecto($hdIdProyecto, $hdIdPropiedad, 'DEP');

                    $countPropiedadEST = count($rowPropiedadEST);
                    $countPropiedadDEP = count($rowPropiedadDEP);
                }
                else {
                    if ($rowPropiedadDPT[0]['tm_idtipopropiedad'] == 'EST') {
                        $rowPropiedadEST = $objPropiedad->ListarSimpleId($hdIdPropiedad);
                        $countPropiedadEST = count($rowPropiedadEST);
                    }
                    elseif ($rowPropiedadDPT[0]['tm_idtipopropiedad'] == 'DEP') {
                        $rowPropiedadDEP = $objPropiedad->ListarSimpleId($hdIdPropiedad);
                        $countPropiedadDEP = count($rowPropiedadDEP);
                    }

                    $rowPropiedadDPT = $objPropiedad->ListarPropiedad_Maestra($hdIdProyecto, $hdIdPropiedad);
                    $countPropiedadDPT = count($rowPropiedadDPT);
                }
            }

            $rowConsumo = $objFacturacion->ListarPropiedadConsumo('3', $hdIdProyecto, $ddlAnho, $ddlMes, $hdIdPropiedad);
            $countConsumo = count($rowConsumo);


            $rowConsumoBarra = $objFacturacion->ConsumoBarras($hdIdPropiedad, $ddlAnho, $ddlMes);
            $countConsumoBarra = count($rowConsumoBarra);

            $rowConsumoBarraMax = $objFacturacion->ConsumoMinMax($hdIdPropiedad, $ddlAnho, $ddlMes);
            $countConsumoBarraMax = count($rowConsumoBarraMax);


            $CodigoPropiedad = '';

            $estilo_content = '<link rel="stylesheet" type="text/css" href="http://cinadsacenter.com/dist/css/estilos-factura.css" />';

            if ($countPropietario > 0) {
                $strdetallePropietario = htmlentities($rowPropietario[0]['descripcion']);
                // for ($counterPropietario=0; $counterPropietario < $countPropietario; $counterPropietario++) {
                //     $strdetallePropietario .= $rowPropietario[$counterPropietario]['descripcion'] . '<br />';
                // }
            }

            if ($countPropiedadDPT > 0) {
                $CodigoPropiedad = $rowPropiedadDPT[0]['tm_descripcionpropiedad'];

                for ($counterPropiedadDPT=0; $counterPropiedadDPT < $countPropiedadDPT; $counterPropiedadDPT++) {
                    if (strlen($strdetallePropiedadDPT) > 0)
                        $strdetallePropiedadDPT .= '-';
                    $strdetallePropiedadDPT .= $rowPropiedadDPT[$counterPropiedadDPT]['tm_descripcionpropiedad'];
                }
            }
            else {
                $strdetallePropiedadDPT = '-';
            }

            if ($countPropiedadEST > 0) {
                for ($counterPropiedadEST=0; $counterPropiedadEST < $countPropiedadEST; $counterPropiedadEST++) {
                    if (strlen($strdetallePropiedadEST) > 0)
                        $strdetallePropiedadEST .= '-';
                    $strdetallePropiedadEST .= $rowPropiedadEST[$counterPropiedadEST]['tm_descripcionpropiedad'];
                }
            }
            else {
                $strdetallePropiedadEST = '-';
            }

            if ($countPropiedadDEP > 0) {
                for ($counterPropiedadDEP=0; $counterPropiedadDEP < $countPropiedadDEP; $counterPropiedadDEP++) {
                    if (strlen($strdetallePropiedadDEP) > 0)
                        $strdetallePropiedadDEP .= '-';
                    $strdetallePropiedadDEP .= $rowPropiedadDEP[$counterPropiedadDEP]['tm_descripcionpropiedad'];
                }
            }
            else {
                $strdetallePropiedadDEP = '-';
            }

            if ($countConsumo > 0){
                $lecturaanterior = $rowConsumo[0]['td_lecturaanterior'];
                $lecturaactual = $rowConsumo[0]['td_lecturaactual'];
                $consumo = $rowConsumo[0]['td_consumoperiodo'];
                $fechaini_lectura = fecha_normal($rowConsumo[0]['fechaini']);
                $fechafin_lectura = fecha_normal($rowConsumo[0]['fechafin']);
            }

            $consumo_maximo = $rowConsumoBarraMax[0]['consumo_max'];
            // $consumo_maximo = $consumo_maximo < 1 ? 1 : $consumo_maximo;

            // echo $hdIdPropiedad . '<br />';
            // echo $ddlAnho . '<br />';
            // echo $consumo_maximo . '<br />';


            $consumo_barra = '';
            $valor_consumo_barra = 0;

            if ($countConsumoBarra > 0) {
                //

                for ($counterConsumoBarra=0; $counterConsumoBarra < $countConsumoBarra; $counterConsumoBarra++) {


                    if ($consumo_maximo > 0) {
                        $valor_consumo_barra = $rowConsumoBarra[$counterConsumoBarra]['consumo'];
                        // $valor_consumo_barra = $valor_consumo_barra < 1 ? 1 : $valor_consumo_barra;

                        $porcj_valor_consumo_barra = (100 * $valor_consumo_barra) / $consumo_maximo;

                        $ancho_barra_blanca = 100 - $porcj_valor_consumo_barra;
                        $porcj_valor_consumo_barra = $porcj_valor_consumo_barra < 1 ? 1 : $porcj_valor_consumo_barra;

                        $ancho_barra_blanca = $ancho_barra_blanca < 1 ? 1 : $ancho_barra_blanca;
                    }
                    else {
                        $porcj_valor_consumo_barra = 1;
                        $ancho_barra_blanca = 99;
                    }

                    $consumo_barra .= '<tr height="10px"><td height="10px"><strong>'.$rowConsumoBarra[$counterConsumoBarra]['mes'].'</strong></td><td><table width="100%"><tr><td class="barra_azul" width="'.$porcj_valor_consumo_barra.'%"></td><td width="' .$ancho_barra_blanca.'%"></td></tr></table></td></tr>';

                    // echo 'valor_consumo_barra = ' . $valor_consumo_barra . '<br />';
                    // echo 'porcj_valor_consumo_barra = ' . $porcj_valor_consumo_barra . '<br />';
                    // echo 'ancho_barra_blanca = ' . $ancho_barra_blanca . '<br />';
                }

            }

            $saldoAnterior = $objCobranza->SaldoAnteriorPropietario($hdIdPropietario, $ddlAnho, $ddlMes);

            $strdetalleConcepto .= '<tr><td class="text-left" width="85%"><strong>SALDO ANTERIOR</strong></td><td align="right" width="15%"><strong>0</strong></td></tr>';

            $heightrow = '';
            $alto_fila = 20;
            $altodetalle = 345;
            $altoConceptos = $countConcepto * $alto_fila;

            for ($counterConcepto=0; $counterConcepto < $countConcepto; $counterConcepto++) {

                if ($counterConcepto == ($countConcepto - 1)) {
                    if ($countConcepto <= 23) {
                        $heightrow = ' height="' . ($altodetalle - $altoConceptos) . 'px"';
                    }
                }

                $strdetalleConcepto .= '<tr><td class="text-left"' . $heightrow . '><strong>' . $rowConcepto[$counterConcepto]['nombreconcepto'] . '</strong></td><td align="right"><strong>' . $rowConcepto[$counterConcepto]['td_valorconcepto'] . '</strong></td></tr>';
            }

            $contenido = file_get_contents('../../media/templates/factura.html');

            $content = str_replace('[nombreproyecto]', $rowProyecto[0]['nombreproyecto'], $contenido);
            $content = str_replace('[logoproyecto]', ($rowProyecto[0]['logo'] == 'no-set' ? 'dist/img/logo-cinadsac.jpg' : $rowProyecto[0]['logo']), $content);
            $content = str_replace('[direccionproyecto]', $rowProyecto[0]['direccionproyecto'], $content);
            $content = str_replace('[propietario/inquilino]', $strdetallePropietario, $content);
            $content = str_replace('[anho]', $ddlAnho, $content);
            $content = str_replace('[mes]', $meses[$ddlMes - 1], $content);
            // $content = str_replace('[mes]', $ddlMes, $content);
            $content = str_replace('[idpropiedad]', $CodigoPropiedad, $content);
            $content = str_replace('[correlativo]', $txtCodigo, $content);
            $content = str_replace('[departamentos]', $strdetallePropiedadDPT, $content);
            $content = str_replace('[estacionamientos]', $strdetallePropiedadEST, $content);
            $content = str_replace('[depositos]', $strdetallePropiedadDEP, $content);
            $content = str_replace('[saldoanterior_columnas]', $strcolumnasPropietario, $content);
            $content = str_replace('[saldoanterior_filas]', $strfilasPropietario, $content);
            $content = str_replace('[lecturaanterior]', $lecturaanterior, $content);
            $content = str_replace('[lecturaactual]', $lecturaactual, $content);
            $content = str_replace('[consumo]', $consumo, $content);
            $content = str_replace('[consumo_barra]', $consumo_barra, $content);
            $content = str_replace('[fechaini_lectura]', $fechaini_lectura, $content);
            $content = str_replace('[fechafin_lectura]', $fechafin_lectura, $content);
            $content = str_replace('[detalleconcepto]', $strdetalleConcepto, $content);
            $content = str_replace('[simbolomoneda]', $txtSimboloMoneda, $content);
            $content = str_replace('[importetotal]', number_format(RedondeoMagico($txtTotalImporte), 2, '.', ''), $content);
            $content = str_replace('[fechaemision]', fecha_normal($txtFechaEmision), $content);
            $content = str_replace('[fechavencimiento]', fecha_normal($txtFechaVencimiento), $content);
            $content = str_replace('[fechatope]', fecha_normal($txtFechaTope), $content);
            $content = str_replace('[nombrebanco]', $rowProyecto[0]['nombrebanco'], $content);
            $content = str_replace('[descripcioncuenta]', $rowProyecto[0]['descripcioncuenta'], $content);
            $content = str_replace('[razonsocialcuenta]', $rowProyecto[0]['razonsocial'], $content);
            $content = str_replace('[direccionpago]', $rowProyecto[0]['direccionpago'], $content);
            $content = str_replace('[emailpago]', $rowProyecto[0]['emailpago'], $content);

            $aviso = '';

            if ($hdIdProyecto == 'CD00000011')
                $aviso = '1). Se les pide indicar siempre la REFERENCIA en ventanilla. 2). Se cobrara mora de un s/.1.00 diario después de la fecha de vencimiento. 3). A partir del día 07 de no haber cancelado,  se publicará como moroso. 4). Realice sus pagos a tiempo EVITE EL CORTE DE AGUA HASTA EL DIA 05. 5). Recuerde que estar al día en los mantenimientos ayuda a una mejor gestión. LA JUNTA DE PROPIETARIOS';
            else
                $aviso = '1). Después de haber cancelado presentar su voucher en administración, portería o enviar por correo: ' . $rowProyecto[0]['emailpago'] . '. 2). En caso de no haber cancelado o acreditado su pago dentro de la fecha, será publicado como moroso 3).';

            $content = str_replace('[aviso]', $aviso, $content);

            $fileFactura =  $folderPDF . $hdIdFacturacion . '.pdf';

            require('../../common/tcpdf/tcpdf.php');

            if ($tipoGen == 'EMAIL'){
                $tamanho = 'A4';
                $orientacion = 'P';
            }
            else {
                $tamanho = 'A3';
                $orientacion = 'L';
                $content = '<table border="0" width="100%" algin="center" cellspacing="5" cellpadding="0">
                <tr>
                    <td width="48%" align="center">' . $content . '</td>
                    <td width="4%"></td>
                    <td width="48%" align="center">' . $content . '</td>
                </tr>
                <tr>
                    <td align="right" class="text-right"><h2 class="text-right">USUARIO</h2></td>
                    <td></td>
                    <td align="right" class="text-right"><h2 class="text-right">EMISOR</h2></td>
                </tr>
            </table>';
            }

            $contentHTML = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            '.$estilo_content.'
        </head>
        <body>' . $content . '</body>
        </html>';

            $pdf = new TCPDF($orientacion, PDF_UNIT, $tamanho, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetMargins(PDF_MARGIN_LEFT, 6, PDF_MARGIN_RIGHT, true);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCellPadding(0);
            $pdf->AddPage();
            $pdf->writeHTML($contentHTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output($fileFactura, 'F');
            //$pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/media/pdf/'.$hdIdProyecto.$ddlAnho.$ddlMes.'.pdf', 'F');

            if ($tipoGen == 'EMAIL'){
                //$para = 'ismael.limo@gmail.com';

                $destinatario = $rowPropietario[0]['tm_email'];
                // $destinatario = 'ismael.limo@gmail.com;cobranzas@cinadsac.pe';

                if (!empty($destinatario)) {
                    if ($destinatario != '') {
                        $de = trim(strip_tags($de));

                        require '../../bussiness/modelocarta.php';
                        require '../../common/config-mail.php';
                        require '../../common/PHPMailerAutoload.php';

                        $mail = new PHPMailer();

                        $mail->isSMTP();

                        $mail->Host = $email_Host;
                        $mail->SMTPAuth = true;
                        $mail->Host = $email_Host;
                        $mail->Port = $email_Port;
                        $mail->Username = $email_Username;
                        $mail->Password = $email_Password;
                        $mail->SMTPSecure = 'tls';

                        // $mail->Host = 'mail.inmobili.net';
                        // $mail->SMTPAuth = true;
                        // $mail->Host = 'mail.inmobili.net';
                        // $mail->Port = 25;
                        // $mail->Username = 'info@inmobili.net';
                        // $mail->Password = 'Admin2016';
                        // $mail->SMTPSecure = 'tls';

                        $mail->setFrom($de);

                        // for ($counterPropietario=0; $counterPropietario < $countPropietario; $counterPropietario++) {
                        $listPara = explode(';', $destinatario);

                        foreach($listPara as $para) {
                            $para = trim(strip_tags($para));

                            if (preg_match($pattern, $para)){
                                if (validar_email($para)) {
                                    $mail->addAddress($para);
                                }
                            }
                        }
                        // }

                        $mail->addAttachment( $_SERVER['DOCUMENT_ROOT'] . '/' . $fileFactura, $hdIdFacturacion . '.pdf' );
                        $mail->isHTML(true);

                        $objModelo = new clsModeloCarta();
                        $rowModelo = $objModelo->Listar('4', 0, '', 1);
                        $countModelo = count($rowModelo);

                        if ($countModelo > 0) {
                            $modeloMensaje = $rowModelo[0]['contenido'];

                            $modeloMensaje = str_replace(':Propiedad:', $strdetallePropiedadDPT, $modeloMensaje);
                            $modeloMensaje = str_replace(':ApeNom:', $strdetallePropietario, $modeloMensaje);
                            $modeloMensaje = str_replace(':FechaHoy:', date('d/m/Y'), $modeloMensaje);
                            $modeloMensaje = str_replace(':MesProyecto:', $meses[$ddlMes - 1], $modeloMensaje);
                            $modeloMensaje = str_replace(':FechaEmision:', fecha_normal($txtFechaEmision), $modeloMensaje);
                        }
                        else
                            $modeloMensaje = 'Estimado propietario/inquilino: ' . $strdetallePropietario . ', \neste documento se está enviando para informarle de la facturación del mes indicado en el asunto.\nAtentamente, CINADSAC.';

                        $mail->Subject = '=?UTF-8?B?'.base64_encode('CINADSAC LE INFORMA: FACTURACION DEL MES DE '.strtoupper($meses[$ddlMes - 1]).' DEL AÑO '.$ddlAnho).'?=';
                        $mail->Body    = $modeloMensaje;

                        if (!$mail->send()) {
                            $rpta = '0';
                            $titulomsje = 'Error en el envio';
                            $contenidomsje = $mail->ErrorInfo;
                        }
                        else {
                            $rpta = '1';
                            $titulomsje = 'Enviado correctamente';
                            $contenidomsje = 'La operación se completó satisfatoriamente';
                        }

                        $mail->smtpClose();
                    }
                    else {
                        $rpta = '1';
                        $titulomsje = 'Enviado correctamente';
                        $contenidomsje = 'La operación se completó satisfatoriamente';
                    }
                }
                else {
                    $rpta = '1';
                    $titulomsje = 'Enviado correctamente';
                    $contenidomsje = 'La operación se completó satisfatoriamente';
                }
            }
            else {
                $titulomsje = 'Generado correctamente';
                $contenidomsje = 'La operación se completó satisfatoriamente';
            }
        }
        elseif (isset($_POST['btnExportar'])) {
            include("../../common/pdfconcat.php");

            $arrayFilesPDF = array();
            $rep = glob($_SERVER['DOCUMENT_ROOT'] . $folderPDF . '*');

            foreach ($rep as $file){
                if ($file != '..' && $file != '.' && $file != ''){
                    $fileinfo = pathinfo($file);

                    array_push($arrayFilesPDF, $_SERVER['DOCUMENT_ROOT'] . '/' . $folderPDF . $fileinfo['basename']);
                }
            }
            clearstatcache();

            if (file_exists('../../media/pdf/' . $hdIdProyecto.$ddlAnho.$ddlMes . '.pdf'))
                unlink('../../media/pdf/' . $hdIdProyecto.$ddlAnho.$ddlMes . '.pdf');

            $pdf = new concat_pdf();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT, true);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCellPadding(0);
            $pdf->setFiles($arrayFilesPDF);
            $pdf->concat();
            $pdf->Output($directorioServer . '/media/pdf/' . $hdIdProyecto.$ddlAnho.$ddlMes . '.pdf', 'F');

            $rpta = '1';
            $titulomsje = 'Generado correctamente';
            $contenidomsje = 'media/pdf/' . $hdIdProyecto.$ddlAnho.$ddlMes . '.pdf';
        }
    }
    elseif (isset($_POST['btnExportarPropiedad']) || isset($_POST['btnExportarPropiedad_Concepto']) || isset($_POST['btnExportarFacturasExcel']) || isset($_POST['btnExportarTotalesFacturaExcel'])) {
        require('../../common/PHPExcel.php');
        require('../../common/PHPExcel/Writer/Excel2007.php');

        // Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number

        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';

        $nameFileExport = '../../media/xls/'.$hdIdProyecto;

        if (isset($_POST['btnExportarPropiedad'])) {
            $rowCount = 0;
            // $objFacturacion = new clsPropiedad();

            $hdTipoConsultaExport = (isset($_POST['hdTipoConsultaExport'])) ? $_POST['hdTipoConsultaExport'] : '1';
            $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
            $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';

            // Execute the database query
            $rsPropiedad = $objFacturacion->ListarPropiedadConsumo($hdTipoConsultaExport, $hdIdProyecto, $ddlAnho, $ddlMes, '');
            $countRsPropiedad =  count($rsPropiedad);

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CODIGO PROYECTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CODIGO PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NRO PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'LEC. ANTERIOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'LEC. ACTUAL');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CONSUMO');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'IMPORTE CONSUMO');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'FECHA INICIAL');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'FECHA FINAL');

            if ($countRsPropiedad > 0) {
                while($rowCount < $countRsPropiedad){
                    $urut = $rowCount + 2;

                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$urut, $hdIdProyecto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$urut, $rsPropiedad[$rowCount]['tm_idpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$urut, $rsPropiedad[$rowCount]['tm_descripcionpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$urut, $rsPropiedad[$rowCount]['td_lecturaanterior']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$urut, $rsPropiedad[$rowCount]['td_lecturaactual']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$urut, $rsPropiedad[$rowCount]['td_consumoperiodo']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$urut, $rsPropiedad[$rowCount]['consumoimporte']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$urut, fecha_normal($rsPropiedad[$rowCount]['fechaini']));
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$urut, fecha_normal($rsPropiedad[$rowCount]['fechafin']));
                    ++$rowCount;
                }
            }

            $nameFileExport .= '.xlsx';
        }
        elseif (isset($_POST['btnExportarPropiedad_Concepto'])) {
            $hdTipoConsultaExport = (isset($_POST['hdTipoConsultaExport'])) ? $_POST['hdTipoConsultaExport'] : '1';
            $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';
            $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '2015';
            $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '1';

            $rowCount = 0;

            // $rsPropiedad = $objPropiedad->ExportarPropiedades_Concepto($hdIdProyecto, $hdIdConcepto);

            $rsPropiedad = $objFacturacion->ListarPropiedadConsumo_Concepto($hdTipoConsultaExport, $hdIdProyecto, $hdAnho, $hdMes, 0, $hdIdConcepto);
            $countRsPropiedad =  count($rsPropiedad);

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CODIGO PROYECTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CODIGO PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NRO PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CODIGO CONCEPTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'IMPORTE');

            if ($countRsPropiedad > 0) {
                while($rowCount < $countRsPropiedad){
                    $urut = $rowCount + 2;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$urut, $hdIdProyecto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$urut, $rsPropiedad[$rowCount]['tm_idpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$urut, $rsPropiedad[$rowCount]['tm_descripcionpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$urut, $hdIdConcepto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$urut, $rsPropiedad[$rowCount]['td_importe']);
                    ++$rowCount;
                }
            }

            $nameFileExport .= '.xlsx';
        }
        elseif (isset($_POST['btnExportarFacturasExcel'])) {
            $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
            $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';

            $rowCount = 0;
            // Execute the database query
            $rsFacturacion = $objFacturacion->ListarDetalleFacturacion($hdIdProyecto, $ddlAnho, $ddlMes);
            $countRsFacturacion = count($rsFacturacion);

            // Iterate through each result from the SQL query in turn
            // We fetch each database result row into $row in turn

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'COD. DETALLE FACTURA');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'COD. FACTURA');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NRO. FACTURA');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'COD. PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NRO. PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'COD. CONCEPTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'CONCEPTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'VALOR CONCEPTO');

            if ($countRsFacturacion > 0) {
                while($rowCount < $countRsFacturacion){
                    $urut = $rowCount + 2;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$urut, $rsFacturacion[$rowCount]['idconceptofacturacion']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$urut, $rsFacturacion[$rowCount]['idfacturacion']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$urut, $rsFacturacion[$rowCount]['codigofactura']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$urut, $rsFacturacion[$rowCount]['idpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$urut, $rsFacturacion[$rowCount]['descripcionpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$urut, $rsFacturacion[$rowCount]['idconcepto']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$urut, $rsFacturacion[$rowCount]['descripcionconcepto']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$urut, $rsFacturacion[$rowCount]['valorconcepto']);
                    ++$rowCount;
                }
            }

            $nameFileExport .= '_'.$ddlAnho.'_'.$ddlMes.'.xlsx';
        }
        elseif (isset($_POST['btnExportarTotalesFacturaExcel'])) {
            $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
            $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';

            $rowCount = 0;
            // Execute the database query
            $rsFacturacion = $objFacturacion->ListarAllFields('1', $hdIdProyecto, '', $ddlAnho, $ddlMes, 0);
            $countRsFacturacion = count($rsFacturacion);

            // Iterate through each result from the SQL query in turn
            // We fetch each database result row into $row in turn

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'NRO. PROPIEDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'IMPORTE FACTURADO');

            $totalfacturado = 0;

            if ($countRsFacturacion > 0) {
                while($rowCount < $countRsFacturacion){
                    $urut = $rowCount + 2;
                    $importefacturado = RedondeoMagico($rsFacturacion[$rowCount]['tm_importefacturado']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$urut, $rsFacturacion[$rowCount]['descripcionpropiedad']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$urut, number_format($importefacturado, 2, '.', ''));
                    $totalfacturado += $importefacturado;
                    ++$rowCount;
                }
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.($urut + 2), 'IMPORTE TOTAL');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.($urut + 2), $totalfacturado);

            $nameFileExport .= '_'.$ddlAnho.'_'.$ddlMes.'_TF.xlsx';
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        require_once '../../common/PHPExcel/IOFactory.php';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        $objWriter->save($nameFileExport);
    }
    elseif (isset($_POST['btnSubirDatos'])) {
        if (!empty($_FILES['archivo']['name'])) {
            $hdTipoImportacion = (isset($_POST['hdTipoImportacion'])) ? $_POST['hdTipoImportacion'] : '0';
            $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
            $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';
            $hdConceptoEscalonable = (isset($_POST['hdConceptoEscalonable'])) ? $_POST['hdConceptoEscalonable'] : '0';
            $ddlAnhoImport = (isset($_POST['ddlAnhoImport'])) ? $_POST['ddlAnhoImport'] : '0';
            $ddlMesImport = (isset($_POST['ddlMesImport'])) ? $_POST['ddlMesImport'] : '0';

            $upload_folder  = '../../media/xls/';

            $nombre_archivo = $_FILES['archivo']['name'];
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $nombre_archivo = trim($nombre_archivo);
            $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador)) {
                require('../../common/PHPExcel.php');
                require('../../common/PHPExcel/Reader/Excel2007.php');

                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($archivador);
                //$objFecha = new PHPExcel_Shared_Date();

                $objPHPExcel->setActiveSheetIndex(0);
                $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();

                if ($hdTipoImportacion == '00') {
                    $rptadet = '0';

                    $objFacturacion->EliminarConsumoEscalonable($hdIdProyecto, $ddlAnhoImport, $ddlMesImport, $idusuario, $rptadet, $titulodetmsje, $contenidodetmsje);

                    for ($i = 2; $i <= $countRowsExcel; $i++){
                        $CodigoPropiedad = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

                        $lecturaanterior = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
                        $lecturaactual = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
                        $consumo = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                        $consumoimporte = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());

                        // echo trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()) . 's1';
                        // echo trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()) . 's2';

                        // $fechaini = fecha_mysql(trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()));
                        // $fechafinal = fecha_mysql(trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()));

                        // echo $fechaini;
                        // echo $fechafinal;

                        // $fechaini = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $fechaini);
                        // $fechafinal = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $fechafinal);

                        $_cellDate_ini = $objPHPExcel->getActiveSheet()->getCell('H'.$i);
                        // $_fechaini = $_cellDate_ini->getValue();

                        if (PHPExcel_Shared_Date::isDateTime($_cellDate_ini))
                            $fechaini = gmdate('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($_cellDate_ini->getCalculatedValue()));
                        else
                            $fechaini = fecha_mysql(trim($_cellDate_ini->getValue()));

                        $_cellDate_final = $objPHPExcel->getActiveSheet()->getCell('I'.$i);
                        // $_fechafinal = $_cellDate_final->getValue();

                        if (PHPExcel_Shared_Date::isDateTime($_cellDate_final))
                            $fechafinal = gmdate('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($_cellDate_final->getCalculatedValue()));
                        else
                            $fechafinal = fecha_mysql(trim($_cellDate_final->getValue()));

                        // echo $fechaini;
                        // echo $fechafinal;

                        $rpta = $objFacturacion->RegistrarConsumoEscalonable('0', $hdIdProyecto, $CodigoPropiedad, $ddlAnhoImport, $ddlMesImport, $hdIdConcepto, $lecturaanterior, $lecturaactual, $consumo, $fechaini, $fechafinal, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    }
                }
                elseif ($hdTipoImportacion == '01') {
                    // $hdIdConcepto = (isset($_POST['hdIdConcepto'])) ? $_POST['hdIdConcepto'] : '0';

                    $rptadet = '0';

                    $objFacturacion->EliminarConsumoConcepto($hdIdProyecto, $hdIdConcepto, $ddlAnhoImport, $ddlMesImport, $idusuario, $rptadet, $titulodetmsje, $contenidodetmsje);

                    for ($i = 2; $i <= $countRowsExcel; $i++){
                        $CodigoPropiedad = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
                        $importe = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());

                        $rpta = $objFacturacion->RegistrarConceptoVariable('0', $hdIdProyecto, $CodigoPropiedad, $ddlAnhoImport, $ddlMesImport, $hdIdConcepto, $importe, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    }
                }
                else {
                    for ($i = 2; $i <= $countRowsExcel; $i++){
                        $idconceptofacturacion = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
                        $valorconcepto = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                        $rpta = $objFacturacion->ActualizarDetalleFacturacion($idconceptofacturacion, $valorconcepto, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    }
                }
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
