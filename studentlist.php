<?php
include('OJDatabase.php');
OJDatabase::init();

?>
<!doctype html>
<html>
<body>
<?php
	$dbo = OJDatabase::getDBO();
	$studentsstmt = $dbo->prepare("");
?>
</body>
</html>
