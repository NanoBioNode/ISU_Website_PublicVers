<?php 
include_once('OJLogin.php');
$location = isset($_POST['returnLoc'])?$_POST['returnLoc']:'index.php';

if(isset($_POST['username']) && isset($_POST['password']) && OJLogin::login($_POST['username'],$_POST['password'])){
	// Set success messages, if any
} else {
	// Set failure messages, if any
	OJLogin::setMessage('login',new OJMessage('username/password is incorrect or not registered',OJMessage::ERROR_TYPE));
}
header('location: '.$location);
