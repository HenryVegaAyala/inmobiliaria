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


?>