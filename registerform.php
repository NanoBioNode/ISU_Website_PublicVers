<?php
include('OJLogin.php');
OJLogin::init();
$page="registerform";
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
	function retrieveUsername($fn, $ln){
		$dbo = OJLogin::getDBO();
//		try{$dbo->query("SELECT username FROM `oj_users` WHERE firstame = 'Mary' AND lastname = 'Cotton'");}catch(PDOException $dbo){ exit($dbo->getMessage()); }
		$result = $dbo->query("SELECT username FROM `oj_users` WHERE firstname='$fn' AND lastname='$ln'");
		$userName = $result->fetchColumn();
//		print 'retValue=' . $userName . '<br>';
		return $userName;
	}
	
// set the used variables to empty
$fnErr = $lnErr = $emailErr = $unErr = $passwdErr = $nameNotFound = "";
$firstname = $lastname = $email = $username = $password = $pass2 = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (empty($_POST["firstname"])) {
		$fnErr = "First name is required";
	} else {
		$firstname = test_input($_POST["firstname"]);
		// check if firstname only contains letters,',-
		if (!preg_match("/^[a-zA-Z\-\'\s]*$/",$firstname)) {
			$fnErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["lastname"])) {
		$lnErr = "Last name is required";
	} else {
		$lastname = test_input($_POST["lastname"]);
		// check if lastname only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z\-\'\s]*$/",$lastname)) {
			$lnErr = "Only letters and white space allowed";
		}
	}

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
     
	if (empty($_POST["username"])) {
		$unErr = "User name is required";
	} else {
		$username = test_input($_POST["username"]);
		// check if username only contains letters and numbers
		if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
			$unErr = "Only letters and numbers allowed";
		} else if( strlen($username) < 5){
			$unErr = "Username must be > 5 characters";
		}
	}

	if(empty($_POST["password"]) || empty($_POST["pass2"])) {
		$passwdErr = "Password is required";
	} else {
		$password = test_input($_POST["password"]);
		if(strlen($password) >= 6 && strlen($password) <= 10) {
			$pass2 = test_input($_POST["pass2"]);
			if($password != $pass2) {
				$passwdErr ="Your password fields do not match";
			}
		} else $passwdErr ="Your password must be 6 to 10 characters long";
	}

	if(($fnErr == '') && ($lnErr == '')) {
		$lines = file('classlist.csv');
//      var_dump($lines);
		$line_number = false;
		while (list($key, $line) = each($lines) and !$line_number) {
  		$line_number = ((stripos($line, $firstname) !== FALSE) && (stripos($line, $lastname) !== FALSE)); 
		}
		$nameNotFound = 'Entered name is not in the list';
		if($line_number){
			$data = str_getcsv($lines[$key-1]);
			$trimData = array_map('trim', $data);
//         var_dump($trimData);
			if( (strtolower($trimData[1]) == strtolower($firstname) ) && 
				(strtolower($trimData[2]) == strtolower($lastname) ) ) {
				$nameNotFound = '';	//clear error
				$_POST['section'] = $trimData[0];
				$_POST['STswitch'] = $trimData[4];
			}
		}
	}
}
?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
		<div class="container">
			<h4>Registration Form</h4>
			First Name:<br><input type="text" name="firstname" value="<?php echo $firstname;?>">
			<span class="error">* <?php echo $fnErr;?></span>
 	  	<br><br>
			Last Name:<br><input type="text" name="lastname" value="<?php echo $lastname;?>">
			<span class="error">* <?php echo $lnErr, ' ', $nameNotFound;?></span>
 	  	<br><br>
			E-mail:<br><input type="text" name="email" value="<?php echo $email;?>">
			<span class="error">* <?php echo $emailErr;?></span>
			<br><br>
			User Name:<br><input type="text" name="username" value="<?php echo $username;?>">
			<span class="error">* <?php echo $unErr;?></span>
 	  	<br><br>
			Create Password:<br><input type="password" name="password" value="<?php echo $password;?>">
			<span class="error">* <?php echo $passwdErr;?></span>
 	  	<br><br>
			Confirm Password:<br><input type="password" name="pass2" value="<?php echo $pass2;?>">
			<span class="error">* <?php echo $passwdErr;?></span>
 	  	<br><br>
			<input type="submit" name="submit" value="Submit"> 
<?php
	if($fnErr == '' && $lnErr == '' && $emailErr == '' && $unErr == '' && $passwdErr == '' && $nameNotFound == '' && $username != ''){
		$un = retrieveUsername($firstname, $lastname);
		if($un == NULL) {
			$_SESSION['post_data'] = $_POST;
			header('location: register.php');
		}
		else {
			echo 'User already registered';
	 		?><a href="https://db.nanobio.illinois.edu/">Back</a><?php
		}
	}
?>
		</div>
	</form>
