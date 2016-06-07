<?php
include("OJLogin.php");
OJLogin::init();

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 8; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}

$row = 1;
if (($handle = fopen("classlist.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $section = $data[0];
        $firstname = $data[1];
        $lastname = $data[2];
        $email = $data[3];
        $username = preg_replace("/(.*?)@(.*)/uis", "$1", $email);
        $semester = "spring2016";
        $password = RandomString();
        OJLogin::register($username,
			$password,
			$email,
			array("firstname"=>$firstname,
				"lastname"=>$lastname,
				"section"=>$section,
				"semester"=>$semester));
        echo "Username: ".$username." Password: ".$password."<br>";
    }
    fclose($handle);
}
?>
