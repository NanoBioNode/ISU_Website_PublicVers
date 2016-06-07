<?php
include('OJLogin.php');
OJLogin::init();

if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
?>
<?php
		$dbo = OJLogin::getDBO();
		
		if (($_POST['saver'] == "") and ($_SESSION['post-data']['saver'] != "")) {
			$_POST['saver'] = $_SESSION['post-data']['saver'];
		}
		if (($_POST['savey'] == "") and ($_SESSION['post-data']['savey'] != "")) {
			$_POST['savey'] = $_SESSION['post-data']['savey'];
		}
		
		$saverr = $_POST['saver'];
		$savery = $_POST['savey'];

		
		for($count=1; $count<=$saverr; $count++){
			$geneinfoexiststmt = $dbo->prepare("SELECT count(*) from experimentresults where username=? and experiment=?");
			$geneinfoexiststmt->execute([$_POST['selectedUser'],$count]);

			if($geneinfoexiststmt->fetchColumn() < 1){
				$geneinfostmt = $dbo->prepare("INSERT INTO experimentresults (`username`,`experiment`) VALUES (?,?)");
				$geneinfostmt->execute([$_POST['selectedUser'],$count]);
			}

			if ($_POST['successtrans-'.$count] == "No") {
				$_POST['brep-'.$count] = 0;
				$_POST['trep-'.$count] = 0;
				$_POST['fails-'.$count] = $_POST['fails-'.$count] + 1;
				$_POST['plateregion-'.$count] = " ";
			}
			
			$geneinfostmt = $dbo->prepare("UPDATE experimentresults SET `successtrans`=?,`TAsuccesstrans`=?,`brep`=?,`trep`=?,`fails`=?, `plateregion`=? WHERE username=? AND experiment=?");
			$geneinfostmt->execute([$_POST['successtrans-'.$count],$_POST['TAsuccesstrans-'.$count],$_POST['brep-'.$count],$_POST['trep-'.$count],$_POST['fails-'.$count],$_POST['plateregion-'.$count],$_POST['selectedUser'],$count]);

		}
		
		for($count=1; $count<=$savery; $count++){
			$geneinfoexiststmt = $dbo->prepare("SELECT count(*) from experimentresults where username=? and experiment=?");
			$geneinfoexiststmt->execute([$_POST['selectedUser'],$count+500000]);

			if($geneinfoexiststmt->fetchColumn() < 1){
				$geneinfostmt = $dbo->prepare("INSERT INTO experimentresults (`username`,`experiment`) VALUES (?,?)");
				$geneinfostmt->execute([$_POST['selectedUser'],$count+500000]);
			}

			$geneinfostmt = $dbo->prepare("UPDATE experimentresults SET `brep`=?,`trep`=?,`plateregion`=? WHERE username=? AND experiment=?");
			$geneinfostmt->execute([$_POST['brep-'.($count+500000)],$_POST['trep-'.($count+500000)],$_POST['plateregion-'.($count+500000)],$_POST['selectedUser'],$count+500000]);
			
		}
		
		$_SESSION['post-data'] = $_POST;
		$_SESSION['username-post-datax'] = $_POST['selectedUser'];
		$_SESSION['redirect-expresults'] = 1;
		
		OJLogin::setMessage('banner',new OJMessage('Info saved!',OJMessage::SUCCESS_TYPE));
		header('location: expresults.php');
}		
?>
