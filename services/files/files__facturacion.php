<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
	require '../../common/functions.php';

	// $hdAction = (isset($_POST['hdAction'])) ? $_POST['hdAction'] : '';
	$hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
	$hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : '2015';
	$hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : '1';

	$folderPDF = '../../media/pdf/'.$hdIdProyecto.$hdAnho.$hdMes.'/';

	// echo $_SERVER['DOCUMENT_ROOT'] . $folderPDF;
	$rpta = '0';
	$titulomsje = '';
	$contenidomsje = '';

	// if ($hdAction == 'VERIF') {
	// 	if (is_dir($folderPDF)){
	// 		$rpta = '1';
	// 		$titulomsje = 'Existe facturación generada para este proyecto';
	// 		$contenidomsje = '¿Qué desea hacer?';
	// 	}
	// }
	// else {
		if (is_dir($folderPDF)){
	    	deleteDir($folderPDF);
		}

		// $folderPDF = $directorioServer.'/media/pdf/'.$hdIdProyecto.$ddlAnho.$ddlMes.'/';

	    if (!is_dir($folderPDF))
	        mkdir($folderPDF);

    	$rpta = '1';
		$titulomsje = 'Recibos anteriores eliminados';
		$contenidomsje = 'Operación realizada correctamente';

	// }

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
	echo json_encode($jsondata);
}
?>