<?php
include('OJLogin.php');
OJLogin::init();
$page="uploadpage";
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

				<form enctype="multipart/form-data" action="uploadpage.php" method="POST">
						<div class="well well-sm">
					<!-- MAX_FILE_SIZE must precede the file input field -->
					<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
					<!-- Name of input element determines name in $_FILES array -->
					<input class="btn btn-primary" name="userfile" type="file" />
					<p></p>
					<input class="btn btn-primary" type="submit" name="submitb" value="Save Latest Uploaded CSV File" />
					<p></p>
					<input class="btn btn-primary" type="submit" name="downb" value="Download File" formaction="downloadpage.php" />
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
		<form role="form" action="uploadpage.php" method="post">
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
	
	


		$userFile = $uploaddir.$getUser.".csv";
		if (isset($_POST["submitb"])) {
			if (($_FILES["userfile"]["type"] == "text/csv") or ($_FILES["userfile"]["type"] == "application/vnd.ms-excel")) {

			
# process the TMP file here			
				$fpp = fopen($_FILES['userfile']['tmp_name'], "r");
				$gpp = fopen($userFile, "w");
				$countfile = 1;
				$countregions = 0;
				$letterC = 0;
				$addRegion = 0;

				while (($line = fgetcsv($fpp)) !== false) {

					foreach ($line as $cell) {
							if ($countfile == 1) {
								$saveRegion = htmlspecialchars($cell);
								$countRegions = $countRegions + 1;								
							}				
							
							if ($countfile == 12) {
								if ($countRegions == 1) {
								} else {
									$saveRegion = $saveRegion + $addRegion;
									if ($saveRegion%7 == 0) {
										 $letterC = $letterC + 1;
										 $addRegion = $addRegion + 1;
										 $saveRegion = $saveRegion + 1;
									}
									$letter = chr(65 + $letterC);
								}
								$countfile = 1;
							} else {
								$countfile = $countfile + 1;
							}							
					}
#					$saveline = implode(",",$line)."\n";
					if ($countRegions == 1) {
						$saveline = implode(",",$line)."Letter Region\n";
					} else {
						$sline = array();
						$count = 0;
						$saveCell = '';
						foreach ($line as $cell) {
							$saveCell = str_replace( ',', '', $cell );
							array_push($sline,$saveCell);
						}
						$saveline = implode(",",$sline).$letter.($saveRegion%7)."\n";
					}
					fwrite($gpp, $saveline);

				}
				fclose($f);
				fclose($g);							
			
			} else {
				echo '<script language="javascript">';
				echo 'alert("Invalid File type attempted, must use a CSV file")';
				echo '</script>';
			}
			
		}

		if ( file_exists($userFile) ) {
				$f = fopen($userFile, "r");
						echo '<table class="table table-striped">';
						echo '<thead>';
						echo '<tr>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '<th style="width: 126px;"></th>';
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						echo "<tr>";
						$countfile = 0;
						$countregions = 0;
						$letterC = 0;
						$addRegion = 0;
						$firstcount = 0;
						$headcount = 0;
						$savecell = "";
						$MRDArray = array();
						echo '<tr>';
						while (($line = fgetcsv($f)) !== false) {
										
							foreach ($line as $cell) {
							
									if ($countfile == 12) {
										$countfile = 1;
										echo '</tr><tr>';
										echo '<td style="width: 126px; border-left: 1px solid #ddd">' . htmlspecialchars($cell) . '</td>';
									} else {																		
										echo '<td style="width: 126px; border-left: 1px solid #ddd">' . htmlspecialchars($cell) . '</td>';									
										$countfile = $countfile + 1;
									}
									
							}

						}
						echo "</tr>\n";
						echo '</tbody>';
						echo "</TABLE>";

# read and save MRD values to DB
# unpack DB values, apply the MRD read as a list to the section of DB value


					$geneinfostmt22 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
					$geneinfostmt22->execute([$getUser]);
					$geneinfoarr22 = $geneinfostmt22->fetchAll();
					
					$PRegArray = array();

					foreach ($geneinfoarr22 as $kwy => $geneinfo22) {
						if (strlen($geneinfo22['plateregion']) > 2) {
							$pieces = explode('-',$geneinfo22['plateregion']);
							$currentKey = $pieces[0];
							$endKey = $pieces[1];
							$Letter = substr($pieces[0], 0, 1);
							$Number = substr($pieces[0], 1, 2);
							$NumberFromLetter = ord(strtolower($Letter)) - 97;
							$PlateNumber = 6*$NumberFromLetter + $Number;
							$Letter2 = substr($pieces[1], 0, 1);
							$Number2 = substr($pieces[1], 1, 2);							
							$NumberFromLetter2 = ord(strtolower($Letter2)) - 97;
							$PlateNumber2 = 6*$NumberFromLetter2 + $Number2;
							$MRDArrayList = '';
							$addP = $NumberFromLetter;
							$letterP = $NumberFromLetter;
							
							for($countP=$PlateNumber; $countP<$PlateNumber2; $countP++){
								$modP = ((($countP % 7) + $addP) % 7);
								if ($modP == 0) {
									$addP = $addP + 1;
									$letterP = $letterP + 1;
								}
								$modP = ((($countP % 7) + $addP) % 7) ;
								$rletter = chr(65 + $letterP).($modP);
								$MRDArrayList .= $rletter.": ".$MRDArray[$countP - 1]."\n";
							}
							
							$modP = ((($PlateNumber2 % 7) + $addP) % 7);
							if ($modP == 0) {
								$addP = $addP + 1;
								$letterP = $letterP + 1;
							}
							$modP = ((($countP % 7) + $addP) % 7);
							$rletter = chr(65 + $letterP).($modP);
							
							$MRDArrayList .= $rletter.": ".$MRDArray[$PlateNumber2-1];
							
							$PRegArray[] = array($PlateNumber.'-'.$PlateNumber2, $Letter.$Number.'-'.$Letter2.$Number2, $MRDArrayList);
							
						#unpack values into array (PlateRegion, MRD list)
						# MRD List: "A1: 200, A2: 300, A3: 400"


						
						} elseif (strlen($geneinfo22['plateregion']) == 2) {
							$Letter = substr($geneinfo22['plateregion'], 0, 1);
							$Number = substr($geneinfo22['plateregion'], 1, 2);
							$NumberFromLetter = ord(strtolower($Letter)) - 97;
							$PlateNumber = 6*$NumberFromLetter + $Number;
							$PRegArray[] = array($PlateNumber, $Letter.$Number, $MRDArray[$PlateNumber-1]);
							#$PRegArray[] = $Letter.$Number;
						#unpack values into array (PlateRegion, MRD list)
						}														
					
					}
					
						$countmrd = 0;
						foreach ($PRegArray as &$value) {
							$countmrd = $countmrd + 1;
#							echo $countmrd." PlateNum:".$value[0]." LetterNum:".$value[1]." MRD:".nl2br($value[2])."|";
							$geneinfostmt = $dbo->prepare("UPDATE experimentresults SET `meanrawdensity`=? WHERE (`username`=? AND `plateregion`=?)");
							$geneinfostmt->execute([$value[2],$getUser,$value[1]]);
						}						
						
						
				fclose($f);

		}
		
		

	}
	if(OJLogin::hasRole("Student")){
?>

				
<?php
		drawSectionTable(OJLogin::getUserAttribute("semester"),OJLogin::getUserAttribute("section"));
	} else if (OJLogin::hasRole("Teacher")){
		$dbo = OJLogin::getDBO();
		$mysemester = OJLogin::getUserAttribute("semester");
		$teacher_section = OJLogin::getUserAttribute("section");
		drawSectionTable($mysemester,$teacher_section);



	}
}
OJLogin::drawFooter();
?>
