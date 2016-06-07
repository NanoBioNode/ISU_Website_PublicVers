<?php
include('OJLogin.php');
OJLogin::init();
$page="uploadJPGpage";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {

	function drawSectionTable($semester,$section){ 

		$uploaddir = '/var/www/uploads/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		?>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
				</thead>
				<tbody>

				<form enctype="multipart/form-data" action="uploadJPGpage.php" method="POST">
						<div class="well well-sm">
					<!-- MAX_FILE_SIZE must precede the file input field -->
					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
					<!-- Name of input element determines name in $_FILES array -->
					<input class="btn btn-primary" name="userfile" type="file" />
					<p></p>
					<input class="btn btn-primary" type="submit" name="submitb" value="Save Latest Uploaded JPG Image File" />
					<p></p>
					<input class="btn btn-primary" type="submit" name="downb" value="Download File" formaction="downloadJPGpage.php" />
						</div>
				</form>				

				
				</tbody>
			</table>
		</div>
<?php

	if(OJLogin::hasRole("Teacher")){
		$dbo = OJLogin::getDBO();

			$teacher_section = OJLogin::getUserAttribute("section");
			$mysemester= OJLogin::getUserAttribute("semester");
			
			$teachst = " where (";			
			$ts_split = explode(',',$teacher_section);
			foreach ($ts_split as $subsection) {
				$teachst = $teachst."`section` = ".$subsection." or ";

			}
			$teachst = substr_replace($teachst,"",-3);
			$teachst = $teachst.")";


			$teachsem = " and (`semester` = '".$mysemester."') and";
		

		$prepst = "SELECT * from experimentresults g left join oj_users u on g.username = u.username".$teachst.$teachsem." experiment=? order by u.section, u.lastname";
		$geneinfostmtf = $dbo->prepare($prepst);
			
#		$geneinfostmtf = $dbo->prepare("SELECT * from experimentresults where experiment=?");
		$geneinfostmtf->execute([1]);
		$geneinfoarrfull = $geneinfostmtf->fetchAll();
		

		if (!isset($_POST['username']) and !isset($_SESSION['username-post-datax'])) {
			$_POST['username'] = $geneinfoarrfulla[0]['username'];
			$_SESSION['username-post-datax'] = $geneinfoarrfulla[0]['username'];
		}
		
		if (!isset($_POST['username']) and isset($_SESSION['username-post-datax'])) {
			$_POST['username'] = $_SESSION['username-post-datax'];
		}
		
		
		if (isset($_POST['username'])) {
			$_SESSION['username-post-datax'] = $_POST['username'] ;
		}

		if (isset($_SESSION['username-post-datax']) and ($_SESSION['redirect-expresults'] == 1)) {
			$_POST['username'] = $_SESSION['username-post-datax'];
			$_SESSION['redirect-expresults'] = 0;
		}
		
?>
		<form role="form" action="uploadJPGpage.php" method="post">
			<div class="form-group">
				<label for="username">Student Name</label>
				<br/>
				<select name="username" onChange="this.form.submit()">
				<?php 		
				$keycheck = 0;
				foreach ($geneinfoarrfull as $key => $geneinfo) {
					if ($geneinfo['username'] == $_POST['username']) {
				?>
					<option value="<?php echo $geneinfo['username'] ?>" selected="selected">Section: <?php echo $geneinfo['section'] ?>   Name: <?php echo $geneinfo['firstname']." ".$geneinfo['lastname'] ?></option>
				<?php
						$selectuser = $geneinfo['username'];
					} else {
				?>
					<option value="<?php echo $geneinfo['username'] ?>">Section: <?php echo $geneinfo['section'] ?>   Name: <?php echo $geneinfo['firstname']." ".$geneinfo['lastname'] ?></option>
				<?php
						if ($keycheck == 0) {
							$selectuser = $geneinfo['username'];
							$keycheck = 1;
						}
					}
				}
				?>
				</select>
			</div>		
		</form>

<?php
		if (!isset($_POST['username']) and (OJLogin::hasRole("Teacher"))) {
			$_POST['username'] = $selectuser;
		}

	}

	$dbo = OJLogin::getDBO();

	if ( isset($_POST['username']) ) {
		$getUser = $_POST['username'];						
	} else if (OJLogin::hasRole("Teacher")) {
		$getUser = $selectuser;
	} else {
		$getUser = OJLogin::getUsername();
	}
	
	


		$userFile = $uploaddir.$getUser.".jpg";

		if (isset($_POST["submitb"])) {
			if ($_FILES["userfile"]["type"] == "image/jpeg") {
# process the TMP file here			
				rename($_FILES['userfile']['tmp_name'], $userFile);
			} else {
				echo '<script language="javascript">';
				echo 'alert("Invalid File type attempted, must use a JPG or JPEG file")';
				echo '</script>';
			}
			
		}

		if ( file_exists($userFile) ) {

# display jpg
		$data64 = file_get_contents($userFile);

		echo '<img alt="My Image" src="data:image/jpeg;base64,'.base64_encode($data64).'" />';

		}		
		

	}
	if(OJLogin::hasRole("Student")){
?>

				
<?php
		drawSectionTable(OJLogin::getUserAttribute("semester"),OJLogin::getUserAttribute("section"));
	} else if (OJLogin::hasRole("Teacher")){
		$dbo = OJLogin::getDBO();
		$teacher_section = OJLogin::getUserAttribute("section");
		$mysemester = OJLogin::getUserAttribute("semester");
		drawSectionTable($mysemester,$teacher_section);



	}
}
OJLogin::drawFooter();
?>
