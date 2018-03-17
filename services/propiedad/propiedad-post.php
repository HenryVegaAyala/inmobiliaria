<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../bussiness/propiedad.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$strListItems = '';

$objData = new clsPropiedad();

if ($_POST){
	if (isset($_POST['btnAsignarPropiedades'])){
        $listpropiedades = (isset($_POST['listpropiedades'])) ? $_POST['listpropiedades'] : '';
        $hdTipoPersona = (isset($_POST['hdTipoPersona'])) ? $_POST['hdTipoPersona'] : '';
        $hdIdPersona = (isset($_POST['hdIdPersona'])) ? $_POST['hdIdPersona'] : '0';

        $objData->AsignarPropiedad($listpropiedades, $hdTipoPersona, $hdIdPersona, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnSaveValuesPropiedades'])) {
    	$hdTipoValoracion = (isset($_POST['hdTipoValoracion'])) ? $_POST['hdTipoValoracion'] : '02';
        $detallePropiedad = json_decode(stripslashes($_POST['detallePropiedad']));

        if (is_array($detallePropiedad)){
            foreach ($detallePropiedad as $propiedad) {
                $objData->ActualizarValores($propiedad->idpropiedad, $hdTipoValoracion, (strlen($propiedad->valor) == 0 ? 0 : $propiedad->valor), $propiedad->saldoinicial, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    elseif (isset($_POST['btnGuardarValores'])) {
        $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
        $hdTipoValoracion = (isset($_POST['hdTipoValoracion'])) ? $_POST['hdTipoValoracion'] : '02';
        $txtValorFijo = (isset($_POST['txtValorFijo'])) ? $_POST['txtValorFijo'] : '0';

        $objData->AsignarValorMasivo($hdIdProyecto, $hdTipoValoracion, $txtValorFijo, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}
?>