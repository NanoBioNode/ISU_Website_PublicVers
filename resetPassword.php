<?php
include('OJLogin.php');
OJLogin::init();
$page="resetPassword";
OJLogin::drawHeader();
?>
<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	return $data;
}
// set the used variables to empty
$fnErr = $lnErr = $nameNotFound = "";
$firstname = $lastname = "";
$userFound = FALSE; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (empty($_POST["firstname"])) {
		$fnErr = "First name is required";
	} else {
		$firstname = test_input($_POST["firstname"]);
		// check if firstname only contains letters,',-
		if (!preg_match("/^[a-zA-Z\-\']*$/",$firstname)) {
			$fnErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["lastname"])) {
		$lnErr = "Last name is required";
	} else {
		$lastname = test_input($_POST["lastname"]);
		// check if lastname only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z\-\']*$/",$lastname)) {
			$lnErr = "Only letters and white space allowed";
		}
	}

	if(($fnErr == '') && ($lnErr == '')) {
		$lines = file('classlist.csv');
		$line_number = false;
		while (list($key, $line) = each($lines) and !$line_number) {
  		$line_number = ((stripos($line, $firstname) !== FALSE) && (stripos($line, $lastname) !== FALSE)); 
		}
		$nameNotFound = 'Entered name is not in the list';
		if($line_number){
			$data = str_getcsv($lines[$key-1]);
			$trimData = array_map('trim', $data);
			if( (strtolower($trimData[1]) == strtolower($firstname) ) && 
				(strtolower($trimData[2]) == strtolower($lastname) ) ) {
					$nameNotFound = '';	//clear error
					$userFound = TRUE;
				}

		}
	}

	function retrieveUserName($fn, $ln){
		$dbo = OJLogin::getDBO();
//		try{$dbo->query("SELECT username FROM `oj_users` WHERE firstame = 'Mary' AND lastname = 'Cotton'");}catch(PDOException $dbo){ exit($dbo->getMessage()); }
		$result = $dbo->query("SELECT username FROM `oj_users` WHERE firstname='$fn' AND lastname='$ln'");
		$userName = $result->fetchColumn();
//		print $userName;
		$_POST["username"] = $userName;
		return $userName;
	}

}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<div class="container">
		<h4>Enter first and lastname to reset your password...</h4>
		<br>
		First Name:<br><input type="text" name="firstname" value="<?php echo $firstname;?>">
		<span class="error">* <?php echo $fnErr;?></span>
  	<br><br>
		Last Name:<br><input type="text" name="lastname" value="<?php echo $lastname;?>">
		<span class="error">* <?php echo $lnErr, ' ', $nameNotFound;?></span>
  	<br><br>
		<input type="submit" name="submit" value="Submit"> 
<?php
	if($fnErr == '' && $lnErr == '' && $nameNotFound == ''){
		if($userFound == TRUE) {
			$un = retrieveUsername($firstname, $lastname);
			echo $un . '<br>';
			if($un != NULL) {
				$_SESSION['post_data'] = $_POST;
				header('location: resetPass.php');
			}
			else {
	 			echo "User not found in db ";
	 			?><a href="https://db.nanobio.illinois.edu/">Back</a><?php
			}
		}
	}
?>
	</div>
</form>
