<?php
/*
Copyright (c) 2013-2014 Joe Leigh

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in 
the Software without restriction, including without limitation the rights to 
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do 
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE 
SOFTWARE.
*/
class OJMessage {
	const INFO_TYPE = 0;
	const SUCCESS_TYPE = 1;
	const ERROR_TYPE = -1;

	public $message;
	public $type;

	function __construct($message,$readOnce=false,$type=OJMessage::INFO_TYPE){
		$this->message = $message;
		$this->type = $type;
	}
}

class OJLogin {
	// -----------------------
	// Database Object Functions
	// -----------------------
	private static $dbHost='localhost';
	private static $dbPort=3306;
	private static $dbName='dbName';
	private static $dbUser='root';
	private static $dbPass='encryptedpassword';

	public static $dbo=null;

	public static function getDBO($host=null,$port=null,$database=null,$username=null,$password=null){
		if(self::$dbo==null){
			if($host==null){
				$host=self::$dbHost;
				$port=self::$dbPort;
				$database=self::$dbName;
				$username=self::$dbUser;
				$password=self::$dbPass;
			}
			$dsn = "mysql:host=$host;port=$port;dbname=$database";

			self::$dbo = new PDO($dsn,$username,$password);
			self::$dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}

		return self::$dbo;
	}

	// -----------------------
	// Authentication Functions
	// -----------------------
	private static $logged_in = NULL;
	private static $username = '';
	private static $attributes = NULL;
	public static $roles = null;
	public static $canRead = null;
	public static $canWrite = null;

	public static function init(){
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		// Load user credentials
		if(!isset(OJLogin::$logged_in)){
			// Check session for username
			if(isset($_SESSION["oj_username"])){
				OJLogin::$logged_in = true;
				OJLogin::$username = $_SESSION['oj_username'];
			} else if(isset($_COOKIE["oj_username"])){
				OJLogin::$logged_in = true;
				OJLogin::$username = $_COOKIE['oj_username'];
			} else {
				OJLogin::$logged_in = false;
			}

			// Check for session timeout
			if(OJLogin::$logged_in){
				$dbo = OJLogin::getDBO();
				$timeDiff = $dbo->query("SELECT TIME_TO_SEC(TIMEDIFF(NOW(),last_access)) as timeDiff FROM oj_users WHERE username=".$dbo->quote(OJLogin::$username))->fetchObject()->timeDiff;
				$timeDiff /= 60;
				// Check if we have been idle too long
				if($timeDiff > 60*24){
					// Log user out
					OJLogin::$logged_in = false;
					OJLogin::logout();
					OJLogin::setMessage('banner',new OJMessage('You have been logged out due to inactivity'));
				} else {
					// Update last access
					$dbo->query("UPDATE `oj_users` SET `last_access`=NOW() WHERE username=".$dbo->quote(OJLogin::$username));
				}
			}

			// Pull user info
			if(OJLogin::$logged_in){
				// Get attributes
				$attrStmt = $dbo->query("SELECT * from `oj_users` where `username`=".$dbo->quote(OJLogin::$username));
				OJLogin::$attributes = $attrStmt->fetchObject();

				// Get roles
				$roleStmt = $dbo->query("SELECT `role` from `oj_hasRole` where `username`=".$dbo->quote(OJLogin::$username));
				OJLogin::$roles = array();
				while($result = $roleStmt->fetchObject()){
					OJLogin::$roles[] = $result->role;
				}

				if(count(OJLogin::$roles) > 0){
					// Get read permissions
					$mapFunc = function($val){
						$dbo = OJLogin::getDBO();
						return $dbo->quote($val);
					};
					$readQuery = "SELECT `asset` from `oj_canRead` where `role` IN(".implode(',',array_map($mapFunc,OJLogin::$roles)).")";
					$readStmt = $dbo->query($readQuery);
					OJLogin::$canRead = array();
					while($result = $readStmt->fetchObject()){
						OJLogin::$canRead[] = $result->asset;
					}

					// Get write permissions
					$writeStmt = $dbo->query("SELECT asset from oj_canWrite where role IN(".implode(',',array_map($mapFunc,OJLogin::$roles)).")");
					OJLogin::$canWrite = array();
					while($result = $writeStmt->fetchObject()){
						OJLogin::$canWrite[] = $result->asset;
					}
				}
			}
		}

		// Load messages
		if(!isset(OJLogin::$messages)){
			OJLogin::$messages = array();
			if(isset($_SESSION['oj_messages'])){
				$msgArr = $_SESSION['oj_messages'];
				$msgTypeArr = $_SESSION['oj_messagetypes'];
				foreach ($msgArr as $key => $value) {
					OJLogin::$messages[$key] = new OJMessage($msgArr[$key],$msgTypeArr[$key]);
				}
			}
		}
	}

	public static function isLoggedIn(){
		OJLogin::init();
		return OJLogin::$logged_in;
	}

	public static function getUsername(){
		if(OJLogin::isLoggedIn()){
			return OJLogin::$username;
		} else {
			return NULL;
		}
	}

	public static function getUserAttribute($key){
		if(OJLogin::isLoggedIn() && property_exists(OJLogin::$attributes, $key)){
			return OJLogin::$attributes->$key;
		} else {
			return NULL;
		}
	}

	public static function hasRole($role){
		if(OJLogin::isLoggedIn()){
			return in_array($role,OJLogin::$roles);
		} else {
			return false;
		}
	}

	public static function canRead($asset){
		if(OJLogin::isLoggedIn()){
			if(is_array($asset)){
				for($i=0;$i<count($asset);$i++){
					if(in_array($asset[$i],OJLogin::$canRead))
						return true;
				}
				return false;
			} else {
				return in_array($asset,OJLogin::$canRead);
			}
		} else {
			return false;
		}
	}

	public static function canWrite($asset){
		if(OJLogin::isLoggedIn()){
			if(is_array($asset)){
				for($i=0;$i<count($asset);$i++){
					if(in_array($asset[$i],OJLogin::$canWrite))
						return true;
				}
				return false;
			} else {
				return in_array($asset,OJLogin::$canWrite);
			}
		} else {
			return false;
		}
	}

	public static function login($username,$password){
		if(session_status() == PHP_SESSION_NONE)
			session_start();
		
		// Check to see if already logged in
		if(OJLogin::isLoggedIn())
			return true;

		// Connect to database
		$db = OJLogin::getDBO();

		// Check credentials
		$qUsername = $db->quote($username);
		// $qPassword = $db->quote(md5($password));
		$result = $db->query("SELECT * FROM `oj_users` WHERE username=$qUsername");

		$user = $result->fetchObject();

		// Handle migration of old users now
		if($user->salt == null || $user->salt == ''){
			// Using old, unsalted password
			$credentialsOK = ($user->password == md5($password));
			if($credentialsOK){
				// Update password now
				$salt = OJLogin::generateSalt($username);
				$passwdUpdStmt = $db->prepare("UPDATE oj_users SET `salt`=?,`password`=? WHERE `username`=?");
				$passwdUpdStmt->execute(array($salt,hash('akeygoeshere',$password.$salt),$username));
			}
		} else {
			// Up-to-date, check password.
			$credentialsOK = ($user->password == hash('akeygoeshere',$password.$user->salt));
		}

		// Log user in, if credentials correct
		if($credentialsOK){
			// Set session and cookie values
			$_SESSION["oj_username"] = $username;
			setcookie("oj_username", $username, time()+60*60*24*30);

			// Update last-access
			$db->query("UPDATE `oj_users` SET `last_access`=NOW() WHERE username=$qUsername");

			return true;
		} else {
			return false;
		}
	}

	public static function logout(){
		if(session_status() == PHP_SESSION_NONE)
			session_start();
		unset($_SESSION['oj_username']);
		setcookie("oj_username", "", time()-3600);
	}

	public static function register($STswitch,$username,$password,$email,$infoArr){
		// Connect to database
		$db = OJLogin::getDBO();

		// Prepare inputs
		$salt = OJLogin::generateSalt($username);
		$qPassword = hash('sha256',$password.$salt);

		// Prepare statement
		// TODO consider making this a generalized INSERT function
		$registerString = "INSERT INTO `oj_users` (`username`,`password`,`email`,`salt`";
		$pdoArr = array(":username"=>$username, ":password"=>$qPassword, ":email"=>$email, ":salt"=>$salt);
		$keyString = "";
		$valueString = "";
		foreach ($infoArr as $key => $value) {
			$keyString .= ",`$key`";
			$valueString .= ",:$key";
			$pdoArr[":$key"] = $value;
		}
		$registerString .= $keyString;
		$registerString .= ") VALUES (:username,:password,:email,:salt";
		$registerString .= $valueString;
		$registerString .= ")";
		$registerStmt = $db->prepare($registerString);

		// Execute statement
		$success = $registerStmt->execute($pdoArr);

		if($success){
			if ($STswitch == '123456789') {
			$addRoleString = 'INSERT INTO `oj_hasRole` (`username`,`role`) VALUES (?,"Teacher")';
			} else {
			$addRoleString = 'INSERT INTO `oj_hasRole` (`username`,`role`) VALUES (?,"Student")';
			}
			$addRoleStmt = $db->prepare($addRoleString);
			$success = $addRoleStmt->execute(array($username));
		}
		return $success;
	}

	private static function generateSalt($username){
		return hash('akeygoeshere',$username.time());
	}

	// -----------------------
	// Message Functions
	// -----------------------
	private static $messages = NULL;
	public static function setMessage($key,OJMessage $msg){
		if(session_status() == PHP_SESSION_NONE)
			session_start();
		$_SESSION['oj_messages'][$key] = $msg->message;
		$_SESSION['oj_messagetypes'][$key] = $msg->type;
	}

	public static function getMessage($key){
		if(!isset($messages))
			OJLogin::init();
		if(array_key_exists($key, OJLogin::$messages)) {
			OJLogin::removeMessage($key);
			return OJLogin::$messages[$key];
		} else
			return NULL;
	}

	public static function removeMessage($key){
		if(session_status() == PHP_SESSION_NONE)
			session_start();
		unset($_SESSION['oj_messages'][$key]);
		unset($_SESSION['oj_messagetypes'][$key]);
	}

	// -----------------------
	// Utility Functions
	// -----------------------
	public static function getRequestVar($key,$default=null){
		if(isset($_GET[$key])){
			return $_GET[$key];
		} else if(isset($_POST[$key])){
			return $_POST[$key];
		} else {
			return $default;
		}
	}

	// -----------------------
	// Drawing Functions
	// -----------------------
	public static function drawHeader($clearPath=''){
		include($clearPath.'snippets/header.php');
	}

	public static function drawFooter($clearPath=''){
		include($clearPath.'snippets/footer.php');
	}

	public static function drawLoginForm($clearPath=''){
		include($clearPath.'snippets/loginform.php');
	}

	public static function drawRegisterForm($clearPath=''){
		include($clearPath.'snippets/registerform.php');
	}
}
