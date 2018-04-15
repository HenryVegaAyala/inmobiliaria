<?php
if ($_POST) {
    header('Content-type: text/html; charset=utf-8');
    include '../../common/sesion.class.php';
    require '../../common/class.translation.php';

    set_time_limit(0);
    // ini_set('memory_limit', '64M');
    ini_set('display_errors', 1);

    $sesion = new sesion();
    $idusuario = $sesion->get('idusuario');
    $idperfil = $sesion->get('idperfil');

    $ddlTipoReporte = isset($_POST['ddlTipoReporte']) ? $_POST['ddlTipoReporte'] : '1';

    if ($ddlTipoReporte === '10') {
        include '../../adata/Db-OneConnect.class.php';
    } else {
        include '../../adata/Db.class.php';
    }
    include '../../common/functions.php';

    $IdEmpresa = 1;
    $IdCentro = 1;

    $meses = array(
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    );

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $directorioServer = '';
    $contentHTML = '';
    $contentBody = '';
    $estilos = '';
    $folderPDF = '';
    $right_align = '';
    $csstotal = '';
    $strcolumnas = '';
    $totalGasto = 0;
    $strfilas = '';
    $tituloreporte = '';
    $nombreproyecto = 'SIN PROYECTO';
    $logoproyecto = '';

    if (isset($_POST['btnGenerarReporte'])) {
        $hdIdProyecto = isset($_POST['hdIdProyecto']) ? $_POST['hdIdProyecto'] : '0';

        $ddlAnho = isset($_POST['ddlAnho']) ? $_POST['ddlAnho'] : '2015';
        $ddlMes = isset($_POST['ddlMes']) ? $_POST['ddlMes'] : '1';
        $ddlAnhoIni = isset($_POST['ddlAnhoIni']) ? $_POST['ddlAnhoIni'] : '2015';
        $ddlMesIni = isset($_POST['ddlMesIni']) ? $_POST['ddlMesIni'] : '1';
        $ddlAnhoFin = isset($_POST['ddlAnhoFin']) ? $_POST['ddlAnhoFin'] : '2015';
        $ddlMesFin = isset($_POST['ddlMesFin']) ? $_POST['ddlMesFin'] : '1';
        $hdTipoReporte = isset($_POST['hdTipoReporte']) ? $_POST['hdTipoReporte'] : '1';
        $hdTipoFormato = isset($_POST['hdTipoFormato']) ? $_POST['hdTipoFormato'] : '1';

        if (($_SERVER['SERVER_NAME'] === 'localhost') || ($_SERVER['SERVER_NAME'] === '127.0.0.1')) {
            $directorioServer = 'cinadsacv2';
        } else {
            $directorioServer = '';
        }

        if ($hdTipoFormato === 'PDF') {
            $folderPDF = $_SERVER['DOCUMENT_ROOT'] . '/media/pdf/';

            if ($ddlTipoReporte === '10') {
                $estilos = '.bg-erBlue { background-color: #00B0F0; }';
            } else {
                $estilos = '
		    	.bg-blue {
		        background-color: #244062;
		        }
		        .bg-yellow {
		        background-color: #FFFF00;
		        }
		        .bg-lightBlue {
		        background-color: #92CDDC;
		        }
		        .bg-erBlue {
		        background-color: #00B0F0;
		        }
		        .fg-white {
		        color: #fff;
		        }
		        .text-center {
		        text-align: center !important;
		        }
		        .text-justify {
		        text-align: justify !important;
		        }
		        .text-right {
		        text-align: right !important;
		        }
		        table {
		        border-collapse: collapse !important;
		        }
		        th,
		        td, {
		        font-size: 8pt;
		        border-style: solid !important;
		        border-collapse: collapse !important;
		        }
		        td {
		        border-color: #444 !important;
		        }
		        .csstotal {
		        font-size: 9pt !important;
		        font-weight: bold !important;
		        }';
            }
        } elseif ($hdTipoFormato === 'EXCEL') {
            $folderXLS = '../../media/xls/';

            require '../../common/PHPExcel.php';
            require '../../common/PHPExcel/Writer/Excel2007.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex();

            $objPHPExcel->getProperties()
                ->setCreator('Cinadsac')
                ->setLastModifiedBy('Cinadsac')
                ->setTitle('Reporte')
                ->setSubject('Reporte')
                ->setDescription('Reporte')
                ->setKeywords('Reporte')
                ->setCategory('Reporte');

            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);

            if (trim($hdTipoReporte) === 'RECAUDACION') {
                $objPHPExcel->getActiveSheet()->setTitle('Recaudación');
                $i = 2;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':' . 'H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                foreach (range('A', 'H') as $letra) {
                    if (in_array($letra, ['A', 'B', 'C'], true)) {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(12);
                    } elseif ('H' === $letra) {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(25);
                    } else {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(20);
                    }
                    $i++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFill()->getStartColor()->setRGB('244062');
            } else {
                $objPHPExcel->getActiveSheet()->setTitle('Pendientes');
                $i = 2;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':' . 'F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                foreach (range('A', 'F') as $letra) {
                    if (in_array($letra, ['A', 'B', 'C'], true)) {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(12);
                    } elseif ('F' === $letra) {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(25);
                    } else {
                        $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(20);
                    }
                    $i++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFill()->getStartColor()->setRGB('244062');
            }

        }

        if ($ddlTipoReporte === '04' || $ddlTipoReporte === '05' || $ddlTipoReporte === '07') {
            $tituloreporte .= 'REPORTE DE ' . $hdTipoReporte;

            $nombreFileReporte = 'REP' . $ddlTipoReporte . '_' . $hdIdProyecto;

            if ($hdTipoFormato === 'PDF') {
                $nombreFileReporte .= '.pdf';
            } elseif ($hdTipoFormato === 'EXCEL') {
                $nombreFileReporte .= '.xlsx';
            }

            if ($ddlTipoReporte === '04') {
                include '../../bussiness/propiedad.php';
                $objdata = new clsPropiedad();
                $row = $objdata->Reporte($hdIdProyecto);
            } elseif ($ddlTipoReporte === '05') {
                include '../../bussiness/propietario.php';
                $objdata = new clsPropietario();
                $row = $objdata->Reporte($hdIdProyecto);
            } elseif ($ddlTipoReporte === '07') {
                include '../../bussiness/propiedad.php';
                $objdata = new clsPropiedad();
                $row = $objdata->ReporteImporteRatio($hdIdProyecto);
            }
        } else {
            $nombreFileReporte = 'REP' . $ddlTipoReporte . '_' . $hdIdProyecto . $ddlAnho . $ddlMes;

            if ($hdTipoFormato === 'PDF') {
                $nombreFileReporte .= '.pdf';
            } elseif ($hdTipoFormato === 'EXCEL') {
                $nombreFileReporte .= '.xlsx';
            }

            if ($ddlTipoReporte === '06') {
                $tituloreporte .= 'REPORTE DE ' . $hdTipoReporte . ' DEL MES DE ' . strtoupper($meses[$ddlMesIni - 1]) . ' DEL AÑO ' . $ddlAnhoIni . ' AL MES DE ' . strtoupper($meses[$ddlMesFin - 1]) . ' DEL AÑO ' . $ddlAnhoFin;
            } else {
                if ($ddlTipoReporte === '03' || $ddlTipoReporte === '08' || $ddlTipoReporte === '09') {
                    $tituloreporte .= 'REPORTE DE ' . $hdTipoReporte . ' DEL MES DE ' . strtoupper($meses[$ddlMes - 1]) . ' DEL AÑO ' . $ddlAnho;
                } else {
                    $tituloreporte .= 'REPORTE DE ' . $hdTipoReporte . ' DEL MES DE ' . strtoupper($meses[$ddlMesIni - 1]) . ' DEL AÑO ' . $ddlAnhoIni . ' AL MES DE ' . strtoupper($meses[$ddlMesFin - 1]) . ' DEL AÑO ' . $ddlAnhoFin;
                }
            }

            if ($ddlTipoReporte === '00') {
                include '../../bussiness/presupuesto.php';
                $objdata = new clsPresupuesto();
                $row = $objdata->Reporte($ddlAnhoIni, $ddlMesIni, $ddlAnhoFin, $ddlMesFin, $hdIdProyecto);
            } elseif ($ddlTipoReporte === '01') {
                include '../../bussiness/cobranza.php';
                $objdata = new clsCobranza();
                $row = $objdata->ReporteLiquidacion($ddlAnhoIni, $ddlMesIni, $ddlAnhoFin, $ddlMesFin, $hdIdProyecto);
            } else {
                if ($ddlTipoReporte === '02') {
                    include '../../bussiness/gasto.php';
                    $objdata = new clsGasto();
                    $row = $objdata->Reporte($ddlAnhoIni, $ddlMesIni, $ddlAnhoFin, $ddlMesFin, $hdIdProyecto);
                } elseif ($ddlTipoReporte === '03') {
                    include '../../bussiness/facturacion.php';
                    $objdata = new clsFacturacion();
                    $row = $objdata->Reporte($ddlAnho, $ddlMes, $hdIdProyecto);
                } else {
                    if ($ddlTipoReporte === '06') {
                        include '../../bussiness/cobranza.php';
                        $objdata = new clsCobranza();
                        $row = $objdata->ReporteLiquidacion($ddlAnhoIni, $ddlMesIni, $ddlAnhoFin, $ddlMesFin,
                            $hdIdProyecto);
                    } else {
                        if ($ddlTipoReporte === '08') {
                            include '../../bussiness/cobranza.php';
                            $objdata = new clsCobranza();
                            $row = $objdata->ReporteRecaudacion($hdIdProyecto, $ddlAnho, $ddlMes);
                        } else {
                            if ($ddlTipoReporte === '09') {
                                include '../../bussiness/cobranza.php';
                                $objdata = new clsCobranza();
                                $row = $objdata->ReportePendiente($hdIdProyecto, $ddlAnho, $ddlMes);
                            }
                        }
                    }
                }
            }
        }

        if ($ddlTipoReporte === '10') {
            include '../../bussiness/estadoresultados.php';
            $objEstadoResultados = new clsEstadoResultados_oneconnect();
            $conectar = $objEstadoResultados->_conectar();

            $rsProyecto = $objEstadoResultados->ListarProyecto($conectar, '2', $hdIdProyecto, '', 0);

            if (count($rsProyecto) > 0) {
                $nombreproyecto = $rsProyecto[0]['nombreproyecto'];
                $logoproyecto = $rsProyecto[0]['logo'];
            }

            $rsGastoResumen = $objEstadoResultados->GastoResumen_liquidacion($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);

            $countRsGastoResumen = count($rsGastoResumen);

            $strfilas__gasto = '';

            for ($i = 0; $i < $countRsGastoResumen; $i++) {
                $rsGastoDetallado = $objEstadoResultados->ListarDetallado($conectar, $hdIdProyecto, $ddlAnho,
                    $rsGastoResumen[$i]['codtipogasto']);
                $countRsGastoDetallado = count($rsGastoDetallado);

                if ($countRsGastoDetallado > 0) {
                    $strfilas__gasto .= '<tr height="17" style="height:12.75pt;"><td class="xl80" height="17" colspan="4" style="height:12.75pt;mso-ignore:colspan;" x:str="x:str">' . $rsGastoResumen[$i]['tipogasto'] . '</td><td class="xl75"></td><td class="xl75"></td></tr>';

                    for ($j = 0; $j < $countRsGastoDetallado; $j++) {
                        $strfilas__gasto .= '<tr height="17" style="height:12.75pt;"><td class="xl76" height="17" style="height:12.75pt;"></td><td class="xl77" colspan="2" style="mso-ignore:colspan;">' . $rsGastoDetallado[$j]['descripciongasto'] . '</td><td class="xl75"></td><td class="xl84"></td><td class="xl84" align="right"><span style="mso-spacerun:yes;"></span>S/.<span> </span>' . $rsGastoDetallado[$j]['importe'] . '</td></tr>';

                    }
                }

                $totalGasto += $rsGastoResumen[$i]['importe'];
            }

            $totalEstimacion = $objEstadoResultados->ObtenerEstimacion_Proyecto($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);
            $cuentaEstimacion = $objEstadoResultados->ObtenerEstimacion_Proyecto__Count($conectar, $hdIdProyecto,
                $ddlAnho, $ddlMes);

            $totalRecaudado = $objEstadoResultados->ObtenerImporte_Proyecto($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);
            $cuentaRecaudado = $objEstadoResultados->ObtenerImporte_Proyecto__Count($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);

            $totalPendiente = $objEstadoResultados->Propiedades_Pendientes__Suma($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);
            $cuentaPendiente = $objEstadoResultados->Propiedades_Pendientes__Count($conectar, $hdIdProyecto, $ddlAnho,
                $ddlMes);

            $objEstadoResultados->_desconectar($conectar);

            $contenido = file_get_contents('../../media/templates/estadoresultados.html');

            $_mes = $meses[$ddlMes - 1];

            $contentBody = str_replace('[logocinadsac]', 'dist/img/logo-cinadsac.jpg', $contenido);
            $contentBody = str_replace('[logoproyecto]',
                ($logoproyecto === 'no-set' ? 'dist/img/logo-cinadsac.jpg' : $logoproyecto), $contentBody);
            $contentBody = str_replace('[nombreproyecto]', $nombreproyecto, $contentBody);
            $contentBody = str_replace('[contentgasto]', $strfilas__gasto, $contentBody);
            $contentBody = str_replace('[anho_proceso]', $ddlAnho, $contentBody);
            $contentBody = str_replace('[mes_proceso]', $_mes, $contentBody);

            $contentBody = str_replace('[totalestimacion]', $totalEstimacion, $contentBody);
            $contentBody = str_replace('[cantidad_depas]', $cuentaEstimacion, $contentBody);

            $contentBody = str_replace('[totalrecaudado]', $totalRecaudado, $contentBody);
            $contentBody = str_replace('[cantidad_depas_aldia]', $cuentaRecaudado, $contentBody);

            $contentBody = str_replace('[totalpendiente]', $totalPendiente, $contentBody);
            $contentBody = str_replace('[cantidad_depas_deudores]', $cuentaPendiente, $contentBody);

            $contentBody = str_replace('[totalgasto]', $totalGasto, $contentBody);
        } else {
            include '../../bussiness/condominio.php';

            $objProyecto = new clsProyecto();
            $rsProyecto = $objProyecto->Listar('2', $hdIdProyecto, '', 0);

            if (count($rsProyecto) > 0) {
                $nombreproyecto = $rsProyecto[0]['nombreproyecto'];
            }

            $countrow = count($row);
            if ($countrow > 0) {
                //print_r($row);

                if ($hdTipoFormato === 'PDF') {
                    $contentBody .= '<table border="1" cellspacing="0" cellpadding="1"><thead><tr>';
                } else {
//                    $objPHPExcel->getActiveSheet()->setCellValue('A1', $tituloreporte);
                }

                $columns = array_keys($row[0]);
                $counterColXLS = 0;
                foreach ($columns as $key => $value) {
                    if ($value !== 'idfacturacion') {
                        if ($value === 'propietario' && $ddlTipoReporte !== '05') {
                            continue;
                        }

                        if ($value === 'tipo_dato') {
                            break;
                        }

                        if ($hdTipoFormato === 'PDF') {
                            $strcolumnas .= '<th valign="middle" class="text-center" bordercolor="white" bgcolor="black" color="white">' . $value . '</th>';
                        } elseif ($hdTipoFormato === 'EXCEL') {
                            if (trim($hdTipoReporte) === 'RECAUDACION') {
                                $objPHPExcel->getActiveSheet()->getStyle('A' . 2 . ':' . 'H' . 2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($counterColXLS, 2,
                                    str_replace('_', ' ', strtoupper($value)));
                            } else {
                                $objPHPExcel->getActiveSheet()->getStyle('A' . 2 . ':' . 'F' . 2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($counterColXLS, 2,
                                    str_replace('_', ' ', strtoupper($value)));
                            }
                        }

                        ++$counterColXLS;
                    }
                }

                if ($hdTipoFormato === 'PDF') {
                    $contentBody .= $strcolumnas . '</tr></thead><tbody>';
                }

                $i = 0;
                $totalratio = 0;
                while ($i < $countrow) {
                    if ($hdTipoFormato === 'PDF') {
                        $strfilas .= '<tr>';
                    }

                    $counterColXLS = 0;

                    if ($hdTipoFormato === 'EXCEL') {
                        if (trim($hdTipoReporte) === 'RECAUDACION') {
                            $rows = ($i + 3);
                            $objPHPExcel->getActiveSheet()->getStyle('A' . $rows . ':' . 'H' . $rows)
                                ->getBorders()
                                ->getAllBorders()
                                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                            $objPHPExcel->getActiveSheet()->getStyle('A' . $rows . ':' . 'H' . $rows)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        } else {
                            $rows = ($i + 3);
                            $objPHPExcel->getActiveSheet()->getStyle('A' . $rows . ':' . 'F' . $rows)
                                ->getBorders()
                                ->getAllBorders()
                                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                            $objPHPExcel->getActiveSheet()->getStyle('A' . $rows . ':' . 'F' . $rows)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        }
                    }

                    foreach ($columns as $key => $value) {
                        if ($ddlTipoReporte === '06') {
                            if ($hdTipoFormato === 'PDF') {
                                $csstotal = $row[$i]['tipo_dato'] === '1' ? ' csstotal' : '';
                            }
                        } elseif ($ddlTipoReporte === '07') {
                            if ($value === 'ratio') {
                                $totalratio += $row[$i]['ratio'];
                            }
                        } else {
                            if ($hdTipoFormato === 'PDF') {
                                $csstotal = ($i + 1) === $countrow ? ' csstotal' : '';
                            }
                        }

                        if ($value !== 'idfacturacion') {
                            if ($value === 'propietario' && $ddlTipoReporte !== '05') {
                                continue;
                            }

                            if ($value !== 'tipo_dato') {
                                if ($hdTipoFormato === 'PDF') {
                                    $right_align = is_numeric($row[$i][$value]) ? 'text-right ' : '';

                                    $strfilas .= '<td class="' . $right_align . ' ' . $csstotal . '">' . $row[$i][$value] . '</td>';
                                } elseif ($hdTipoFormato === 'EXCEL') {
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($counterColXLS, $i + 3,
                                        $row[$i][$value]);
                                }
                            }

                            ++$counterColXLS;
                        }
                    }

                    if ($hdTipoFormato === 'PDF') {
                        $strfilas .= '</tr>';
                    }

                    ++$i;
                }

                if ($ddlTipoReporte === '07') {
                    $totalFormateado = number_format($totalratio, 10, '.', '');

                    if ($hdTipoFormato === 'PDF') {
                        $strfilas .= '<tr><td class="text-right csstotal">TOTALES</td><td class="text-right csstotal">' . $totalFormateado . '</td><td class="text-right csstotal"></td><td class="text-right csstotal"></td><td class="text-right csstotal"></td></tr>';
                    } elseif ($hdTipoFormato === 'EXCEL') {

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i + 1, $totalFormateado);
                    }
                }

                if ($hdTipoFormato === 'PDF') {
                    $contentBody .= $strfilas . '</tbody></table>';
                }
            }
        }

        if ($hdTipoFormato === 'PDF') {
            if ($ddlTipoReporte !== '10') {
                $contentBody = '<h1 class="text-center">' . $nombreproyecto . '</h1><h1 class="text-center">' . $tituloreporte . '</h1>' . $contentBody;
            }

            $contentHTML = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		    <html xmlns="http://www.w3.org/1999/xhtml">
		    <head>
		    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    	<title>' . $tituloreporte . ' </title>
		    	<link rel="stylesheet" type="text/css" href="../../dist/css/estilos-estadoresultados.css" />
		    	<style type="text/css">' . $estilos . '</style>
		    </head>
		    <body>' . $contentBody . '</body>
		    </html>';

            $fileReport = $folderPDF . $nombreFileReporte;

            require '../../common/tcpdf/tcpdf.php';
            $pdf = new TCPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);

            if ($ddlTipoReporte === '10') {
                $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT, true);
            } else {
                $pdf->SetMargins(5, 15, 5, true);
            }

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCellPadding(0);
            $pdf->AddPage();
            $pdf->writeHTML($contentHTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output($fileReport, 'F');

            $contenidomsje = 'media/pdf/' . $nombreFileReporte;
        } elseif ($hdTipoFormato === 'EXCEL') {
            require_once '../../common/PHPExcel/IOFactory.php';

            $fileReport = $folderXLS . $nombreFileReporte;

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($fileReport);

            $contenidomsje = 'media/xls/' . $nombreFileReporte;
        }

        $rpta = '1';
        $titulomsje = 'Exportaci&oacute;n completada';
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}