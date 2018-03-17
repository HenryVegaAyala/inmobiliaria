<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/proceso.php');
include('../../bussiness/condominio.php');
include('../../bussiness/propietario.php');
include('../../bussiness/cobranza.php');

$sesion = new sesion();
$objProceso = new clsProceso();
$objProyecto = new clsProyecto();
$objPropietario = new clsPropietario();
$objCobranza = new clsCobranza();

$idusuario = $sesion->get("idusuario");
$codigo = $sesion->get("codigo");
$login = $sesion->get("login");
$fotoUsuario = $sesion->get("foto") == 'no-set' ? 'images/user-nosetimg-233.jpg' : $sesion->get("foto");
$idperfil = $sesion->get("idperfil");
$idpersona = $idperfil == '61' ? '0' : $sesion->get("idpersona");
$nombreperfil = $sesion->get("nombreperfil");

$csstotal = '';
$strcolumnasProyecto = '';
$strfilasProyecto = '';

$strcolumnasPropietario = '';
$strfilasPropietario = '';

$idproyecto = '';
$nombreproyecto = '';
$anho = '2015';
$mes = '1';

$anhoini = '2015';
$mesini = '1';
$anhofin = '2015';
$mesfin = '1';

$selected = '';

/*$rowProyecto = $objProyecto->RegistroPorDefecto('1');
$countRowProyecto = count($rowProyecto);
*/


/*if ($countRowProyecto > 0){
	$idproyecto = $rowProyecto[0]['idproyecto'];
	$nombreproyecto = $rowProyecto[0]['nombreproyecto'];
	$anho = $rowProyecto[0]['anhoproceso'];
	$mes = $rowProyecto[0]['mesproceso'];
}*/

$idproyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : $anho;
$anhoini = (isset($_POST['ddlAnhoIni'])) ? $_POST['ddlAnhoIni'] : $anho;
$mesini = (isset($_POST['ddlMesIni'])) ? $_POST['ddlMesIni'] : $mes;
$anhofin = (isset($_POST['ddlAnhoFin'])) ? $_POST['ddlAnhoFin'] : $anho;
$mesfin = (isset($_POST['ddlMesFin'])) ? $_POST['ddlMesFin'] : $mes;

$rowAnhoProceso = $objProceso->ListarAnho($idproyecto);
$countRowAnhoProceso = count($rowAnhoProceso);

$rowProyectoCuenta = $objCobranza->EstadoCuentaProyecto($anhoini, $mesini, $anhofin, $mesfin, $idproyecto);
$countRowProyectoCuenta = count($rowProyectoCuenta);

$rowPropietarioCuenta = $objCobranza->EstadoCuentaPropietario($anhoini, $mesini, $anhofin, $mesfin, $idpersona);
$countRowPropietarioCuenta = count($rowPropietarioCuenta);

if ($countRowProyectoCuenta > 0) {
	$columns = array_keys($rowProyectoCuenta[0]);

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

			$strcolumnasProyecto .= '<th>' . $value . '</th>';
		}
	}

	$i = 0;
    while ($i < $countRowProyectoCuenta) {
    	$strfilasProyecto .= '<tr>';
    	foreach ($columns as $key => $value) {
    		if ($value != 'idfacturacion'){
    			if ($value == 'propietario')
    				continue;

				if (is_numeric($rowProyectoCuenta[$i][$value])) {
					$right_align = 'text-right ';
				}
				else {
					$right_align = '';
				}
    			
    			$strfilasProyecto .= '<td class="'.$right_align . ' '. $csstotal . '">' . $rowProyectoCuenta[$i][$value] . '</td>';
	    	}
	    }
	    $strfilasProyecto .= '</tr>';
    	++$i;
    }
}


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

			$strcolumnasPropietario .= '<th>' . $value . '</th>';
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
    			
    			$strfilasPropietario .= '<td class="'.$right_align . ' '. $csstotal . '">' . $rowPropietarioCuenta[$i][$value] . '</td>';
	    	}
	    }
	    $strfilasPropietario .= '</tr>';
    	++$i;
    }
}

$jsondata = array('strcolumnasProyecto' => $strcolumnasProyecto, 'strfilasProyecto' => $strfilasProyecto, 'strcolumnasPropietario' => $strcolumnasPropietario, 'strfilasPropietario' => $strfilasPropietario);
echo json_encode($jsondata);
?>