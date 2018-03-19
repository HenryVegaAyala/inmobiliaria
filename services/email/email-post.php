<?php
header('Cache-Control: no-cache, must-revalidate');
header('Cache-Control: max-age=0, must-revalidate');
header('Cache-Control: Cache-Control: no-store');

set_time_limit(0);

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST) {
	$folder = $_POST['hdUsuario'];
	$txtDe = $_POST['txtDe'];
	$txtPara = $_POST['txtPara'];
	$txtAsunto = $_POST['txtAsunto'];
	$ddlPlantilla = $_POST['ddlPlantilla'];
	$txtEstructura = $_POST['txtEstructura'];
	$attachFiles = $_POST['attachFiles'];

	$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
	
	$de = trim(strip_tags($txtDe));
	$listPara = explode(';', $txtPara);
	
	require '../../adata/Db.class.php';
	require '../../common/functions.php';
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

	$mail->setFrom($de);

	foreach($listPara as $para) {
	    $para = trim(strip_tags($para));

	    if (preg_match($pattern, $para)){
	        if (validar_email($para)) {
	            $mail->addAddress($para);
	        }
	    }
	}

	if (is_array($attachFiles)) {
		$fileList = implode(',', $attachFiles);

		$dir = '../../media/users/' . $folder;
		$rep = glob($dir . '/{' . $fileList . '}', GLOB_BRACE);

		foreach ($rep as $file){
			if ($file != '..' && $file != '.' && $file != ''){
				$fileinfo = pathinfo($file);
	  			
	  			$_dirname = $fileinfo['dirname'];
	  			$_basename = $fileinfo['basename'];

				$filename = $_dirname . '/'. $_basename;

				$mail->addAttachment( $filename );
			}
		}
	}

	$mail->isHTML(true);

	$mail->Subject = $txtAsunto;
	$mail->Body    = $txtEstructura;

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

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
  	echo json_encode($jsondata);
}
?>