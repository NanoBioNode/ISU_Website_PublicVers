<?php
include('OJLogin.php');
OJLogin::init();

if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
?>
<?php
		$dbo = OJLogin::getDBO();
		$geneinfoexiststmt = $dbo->prepare("SELECT count(*) from geneinfo where username=?");
		$geneinfoexiststmt->execute([$_POST['selectedUser']]);
					
		
		if ( $_POST['genename'] != '') {
			if ($_POST['genename'] != $_POST['genename2']) {
				$geneinfostmt = $dbo->prepare("UPDATE geneinfo SET `genename`=? WHERE genename=? AND username=?");
				$geneinfostmt->execute([$_POST['genename'],$_POST['genename2'],$_POST['selectedUser']]);
			}
		}


		if ( $_POST['genename'] != '' ) {		
			$geneinfostmt = $dbo->prepare("INSERT INTO geneinfo (username,genename) VALUES (?,?)");
			$geneinfostmt->execute([$_POST['selectedUser'],$_POST['genename']]);

			$geneinfostmt = $dbo->prepare("UPDATE geneinfo SET `systematicname`=?,`size`=?,`info`=?,`experimentalinfo`=?,`function`=? WHERE genename=? AND username=?");
			$geneinfostmt->execute([$_POST['systematicname'],$_POST['size'],$_POST['info'],$_POST['experimentalinfo'],$_POST['function'],$_POST['genename'],$_POST['selectedUser']]);
		}

		if ( isset($_POST['updaterd']) ) {
			$geneinfostmtd = $dbo->prepare("DELETE FROM geneinfo WHERE genename=? AND username=?");
			$geneinfostmtd->execute([$_POST['genename'],$_POST['selectedUser']]);
		}
		
		OJLogin::setMessage('banner',new OJMessage('Info saved!',OJMessage::SUCCESS_TYPE));
		$_SESSION['redirect-geneinfo'] = 0;
		header('location: geneinfo.php');
}
?>
