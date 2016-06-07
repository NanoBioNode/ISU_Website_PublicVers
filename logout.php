<?php 
include_once('OJLogin.php');
$location = isset($_POST['returnLoc'])?$_POST['returnLoc']:'index.php';

OJLogin::logout();
header('location: '.$location);
