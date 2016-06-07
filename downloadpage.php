<?php 
include('OJLogin.php');
OJLogin::init();

	$uploaddir = '/var/www/uploads/';
	$userFile = $uploaddir.(OJLogin::getUsername()).".csv";
	
	header('Content-Type: text/csv');
	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename="'.basename($userFile).'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($userFile));
	readfile($userFile);	
	
?>
