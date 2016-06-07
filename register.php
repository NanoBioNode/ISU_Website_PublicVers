<?php
	include_once("OJLogin.php");
//	echo "Hello";
	if(session_status() == PHP_SESSION_NONE) {
//		echo "jaml";
		session_start();
	}

	$_POST['firstname'] = $_SESSION['post_data']['firstname'];
	$_POST['lastname'] = $_SESSION['post_data']['lastname'];
	$_POST['username'] = $_SESSION['post_data']['username'];
	$_POST['password'] = $_SESSION['post_data']['password'];
	$_POST['email'] = $_SESSION['post_data']['email'];
//	$_POST['institution'] = $_SESSION['post_data']['institution'];
//	$_POST['position'] = $_SESSION['post_data']['position'];
	$_POST['last_access'] = '2015-03-16 00:00:00';
	$_POST['registerDate'] = date("Y-m-d H:i:s");
	$_POST['studentid'] = '12345678';
	$_POST['semester'] = 'spring2016';
	$_POST['section'] = $_SESSION['post_data']['section'];

	if( OJLogin::register($_SESSION['post_data']['STswitch'],$_POST['username'], $_POST['password'], $_POST['email'],
			array("firstname"=>$_POST['firstname'],
					"lastname"=>$_POST['lastname'],
					"last_access"=>$_POST['last_access'],
					"registerDate"=>$_POST['registerDate'],
					"studentid"=>$_POST['studentid'],
					"semester"=>$_POST['semester'],
					"section"=>$_POST['section']
//				"institution"=>$_POST['institution'],
//				"position"=>$_POST['position']
				  ) ) &&	OJLogin::login($_POST['username'],$_POST['password'])
	) {
		OJLogin::setMessage('banner',new OJMessage('You are now registered!',OJMessage::SUCCESS_TYPE));
		header('location: index.php');
//		echo "string1";
	} else {
		OJLogin::setMessage('banner',new OJMessage('An error occurred during registration.',OJMessage::ERROR_TYPE));
		header('location: registerform.php');
//		echo "string2";
	}
?>
