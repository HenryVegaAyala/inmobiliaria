<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
	if (isset($_POST['btnSubirDatos'])) {
	    if (!empty($_FILES['archivo']['name'])) {

	    	$upload_folder = '../../media/files/';
	        $url_folder  = 'media/files/';

	        $nombre_archivo = $_FILES['archivo']['name'];
	        $tipo_archivo = $_FILES['archivo']['type'];
	        $tamano_archivo = $_FILES['archivo']['size'];
	        $tmp_archivo = $_FILES['archivo']['tmp_name'];

	        $nombre_archivo = trim($nombre_archivo);
	        $nombre_archivo = str_replace(' ', '', $nombre_archivo);

	        $archivador = $upload_folder.$nombre_archivo;
			$ubicacionDocumento = $url_folder.$nombre_archivo;

	        if (move_uploaded_file($tmp_archivo, $archivador)) {
	        	require '../../common/sesion.class.php';
				
				$sesion = new sesion();
				$idusuario = $sesion->get("idusuario");

				require '../../adata/Db.class.php';
	        	require '../../bussiness/archivos.php';
	        	
	        	$objArchivo = new clsArchivo();

	        	$rpta = '';
	        	$titulomsje = '';
	        	$contenidomsje = '';

	        	$hdIdProceso = (isset($_POST['hdIdProceso'])) ? $_POST['hdIdProceso'] : '0';
	        	$hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';
			    $hdAnho = (isset($_POST['hdAnho'])) ? $_POST['hdAnho'] : date('Y');
			    $hdMes = (isset($_POST['hdMes'])) ? $_POST['hdMes'] : date('m');

	        	$objArchivo->Registrar('0', $hdIdProceso, $hdIdProyecto, $hdMes, $hdAnho, $ubicacionDocumento, $nombre_archivo, $idusuario, $rpta, $titulomsje, $contenidomsje);

	        	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
  				echo json_encode($jsondata);
	        }
	    }
	}
}
?>