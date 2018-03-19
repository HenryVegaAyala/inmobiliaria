<?php
header('Cache-Control: no-cache, must-revalidate');
header('Cache-Control: max-age=0, must-revalidate');
header('Cache-Control: Cache-Control: no-store');

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$extensiones = array();
$a_json = array();
$a_json_row = array();

$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$tipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : 'media';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$dir = '../../media/users/' . $folder;

if (is_dir($dir)){
	require '../../common/functions.php';
	
	if ($tipo == 'media')
		$extensiones = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'pnga');
	elseif ($tipo == 'documents')
		$extensiones = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z', 'rtf', 'html', 'htm');
	
	if (!is_dir_empty($dir)) {
		$rep = glob($dir.'/*'.$criterio.'*');

		foreach ($rep as $file){
			if ($file != '..' && $file != '.' && $file != ''){
				$fileinfo = pathinfo($file);
	      		$extn = $fileinfo['extension'];

	      		if (in_array(strtolower($extn), $extensiones)) {

	      			$dirname = str_replace('../../', '', $fileinfo['dirname']);

					$a_json_row['path'] = $dirname.'/'.$fileinfo['basename'];
					$a_json_row['file'] = $fileinfo['basename'];
					$a_json_row['ext'] = $extn;

					array_push($a_json, $a_json_row);
	      		}
			}
		}
	}

	clearstatcache();
}

echo json_encode($a_json);
flush();
?>