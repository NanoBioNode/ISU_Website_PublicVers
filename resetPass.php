<?php
include('OJLogin.php');
OJLogin::init();
$page="resetPass";
OJLogin::drawHeader();
?>
<?php
	if(session_status() == PHP_SESSION_NONE) {
//		echo "jaml";
		session_start();
	}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	return $data;
}
	$firstname = $_SESSION['post_data']['firstname'];
	$lastname = $_SESSION['post_data']['lastname'];
	$username = $_SESSION['post_data']['username'];
//	echo $firstname;
//	echo '<br>';
//	echo $lastname;
//	echo '<br>';
//	echo $username;
//	echo '<br>';
//	var_dump($_POST);

// set the used variables to empty
$passwdErr = "";
$password = $pass2 = "";
$valueEntered = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
//	var_dump($_POST);

	if(empty($_POST["password"]) || empty($_POST["pass2"])) {
		$passwdErr = "Password is required";
	} else {
		$password = test_input($_POST["password"]);
		$pass2 = test_input($_POST["pass2"]);
		if($password != $pass2) {
			$passwdErr ="Your password fields do not match";
		} elseif(strlen($password) >= 6 && strlen($password) <= 10){
			$valueEntered = TRUE;
			} else $passwdErr ="Your password must be 6 to 10 characters long";
	}
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<div class="container">
		<h4>Enter your password...</h4>
		<br>
		Create New Password:<br><input type="password" name="password" value="<?php echo $password;?>">
		<span class="error">* <?php echo $passwdErr;?></span>
  		<br><br>
		Confirm New Password:<br><input type="password" name="pass2" value="<?php echo $pass2;?>">
		<span class="error">* <?php echo $passwdErr;?></span>
	  	<br><br>
		<input type="submit" name="submit" value="Submit"> 
<?php
	if($passwdErr == '' && $valueEntered == TRUE){
		// Connect to database
		$db = OJLogin::getDBO();
		$salt = hash('sha256',$username.time());
		$qPassword = hash('sha256',$password.$salt);
		$updatePass = $db->prepare("UPDATE `oj_users` SET `password`=?,`salt`=? WHERE `username`=?");
		$updatePass->execute(array($qPassword, $salt, $username));
		header('location: index.php');
	}
?>	</div>
</form>
