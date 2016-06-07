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
		
		if ($_POST['savey'] < $_POST['saver']) {
			$saverr = $_POST['saver'];
		} else {
			$saverr = $_POST['savey'];
		}
		
		for($count=1; $count<=$saverr; $count++){
			# for experimentResults
			$geneinfoexiststmt32 = $dbo->prepare("SELECT count(*) from experimentresults where username=? and experiment=?");
			$geneinfoexiststmt32->execute([$_POST['selectedUser'],$count]);

			if($geneinfoexiststmt32->fetchColumn() < 1){
				$geneinfostmt32 = $dbo->prepare("INSERT INTO experimentresults (`username`,`experiment`) VALUES (?,?)");
				$geneinfostmt32->execute([$_POST['selectedUser'],$count]);
			}

			# for experimentDesign
			$geneinfoexiststmt = $dbo->prepare("SELECT count(*) from experimentaldesign where username=? and experiment=?");
			$geneinfoexiststmt->execute([$_POST['selectedUser'],$count]);


			# check for variables that were actually never set
			$wasNotSet = 0;
			if ( !(isset($_POST['exp-knockout-'.$count]))) {
				$_POST['exp-knockout-'.$count] = '';
			}
			if ( !(isset($_POST['control-strain-'.$count]))) {
				$_POST['control-strain-'.$count] = '';
			}
			if ( !(isset($_POST['exp-plasmid-'.$count]))) {
				$_POST['exp-plasmid-'.$count] = '';
			}
			if ( !(isset($_POST['exp-plasmid2-'.$count]))) {
				$_POST['exp-plasmid2-'.$count] = '';
				$wasNotSet = 1;
			}
			
			if (($_POST['exp-plasmid2-'.$count] == '') and ($wasNotSet == 0)) {
			$geneinfostmt = $dbo->prepare("UPDATE experimentaldesign SET `exp-knockout`=?,`exp-plasmid`=?,`exp-plasmid2`=?,`exp-strain`=?, `control-strain`=?, `comments`=? WHERE username=? AND experiment=?");
			$geneinfostmt->execute([$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count],$_POST['control-strain-'.$count],$_POST['comments'.$count],$_POST['selectedUser'],$count]);
			} else {
			$geneinfostmt = $dbo->prepare("UPDATE experimentaldesign SET `exp-knockout`=?,`exp-plasmid`=?,`exp-plasmid2`=?,`exp-strain`=?, `control-strain`=?, `comments`=? WHERE username=? AND experiment=?");
			$geneinfostmt->execute([$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count]." + ".$_POST['exp-plasmid2-'.$count],$_POST['control-strain-'.$count],$_POST['comments'.$count],$_POST['selectedUser'],$count]);
			}

			
			
			
			if($geneinfoexiststmt->fetchColumn() < 1){
				if ($_POST['savey'] >= $count) {
					$geneinfostmt = $dbo->prepare("INSERT INTO experimentaldesign (`username`,`experiment`,`control-strain`) VALUES (?,?,?)");
					$geneinfostmt->execute([$_POST['selectedUser'],$count,$_POST['control-strain-'.$count]]);
					if (($_POST['exp-plasmid2-'.$count] == '') and ($wasNotSet == 0)) {
						$geneinfostmt = $dbo->prepare("UPDATE experimentaldesign SET `exp-knockout`=?,`exp-plasmid`=?,`exp-plasmid2`=?,`exp-strain`=?, `control-strain`=?, `comments`=? WHERE username=? AND experiment=?");
						$geneinfostmt->execute([$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count],$_POST['control-strain-'.$count],$_POST['comments'.$count],$_POST['selectedUser'],$count]);					
					} else {
						$geneinfostmt = $dbo->prepare("UPDATE experimentaldesign SET `exp-knockout`=?,`exp-plasmid`=?,`exp-plasmid2`=?,`exp-strain`=?, `control-strain`=?, `comments`=? WHERE username=? AND experiment=?");
						$geneinfostmt->execute([$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count]." + ".$_POST['exp-plasmid2-'.$count],$_POST['control-strain-'.$count],$_POST['comments'.$count],$_POST['selectedUser'],$count]);					
					}
				} else {
					if (($_POST['exp-plasmid2-'.$count] == '') and ($wasNotSet == 0)) {
						$geneinfostmt = $dbo->prepare("INSERT INTO experimentaldesign (`username`,`experiment`,`exp-knockout`,`exp-plasmid`,`exp-plasmid2`,`exp-strain`) VALUES (?,?,?,?,?,?)");
						$geneinfostmt->execute([$_POST['selectedUser'],$count,$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count]]);
					} else {
						$geneinfostmt = $dbo->prepare("INSERT INTO experimentaldesign (`username`,`experiment`,`exp-knockout`,`exp-plasmid`,`exp-plasmid2`,`exp-strain`) VALUES (?,?,?,?,?,?)");
						$geneinfostmt->execute([$_POST['selectedUser'],$count,$_POST['exp-knockout-'.$count],$_POST['exp-plasmid-'.$count],$_POST['exp-plasmid2-'.$count],$_POST['exp-knockout-'.$count]." + ".$_POST['exp-plasmid-'.$count]." + ".$_POST['exp-plasmid2-'.$count]]);
					}
				}

			}
			
		}	
		$_SESSION['post-data'] = $_POST;



		$geneinfostmt33 = $dbo->prepare("UPDATE experimentaldesign SET `tablesaved`=? WHERE username=? AND experiment=?");
		$geneinfostmt33->execute([$_POST["saver"],$_POST['selectedUser'],1]);

		$geneinfostmt43 = $dbo->prepare("UPDATE experimentaldesign SET `tablesavedy`=? WHERE username=? AND experiment=?");
		$geneinfostmt43->execute([$_POST["savey"],$_POST['selectedUser'],1]);


		OJLogin::setMessage('banner',new OJMessage('Info saved!',OJMessage::SUCCESS_TYPE));
		if (isset($_POST['saverExp'])) {
		$_SESSION['redirect-expdesign'] = 0;
		header('location: expdesign.php');

		} else {
		$_SESSION['username-post-data'] = $_POST['selectedUser'];
		$_SESSION['redirect-expdesign'] = 1;
		header('location: editexpdesign.php');
		}
}		
	?>
