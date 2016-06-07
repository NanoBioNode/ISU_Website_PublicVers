<?php
include('OJLogin.php');
OJLogin::init();
$page="expresults";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {

	$dbo = OJLogin::getDBO();
	$geneinfostmtfa = $dbo->prepare("SELECT * from experimentresults where experiment=?");
	$geneinfostmtfa->execute([1]);
	$geneinfoarrfulla = $geneinfostmtfa->fetchAll();

	function drawTables($semester,$section){ 
	
	if(OJLogin::hasRole("Teacher")){
		$dbo = OJLogin::getDBO();

		$teacher_section = OJLogin::getUserAttribute("section");
		$mysemester= OJLogin::getUserAttribute("semester");
		$section = '';
		$teachst = " where (";			
		$ts_split = explode(',',$teacher_section);
		foreach ($ts_split as $subsection) {
			$teachst = $teachst."`section` = ".$subsection." or ";
			$section = $section."u.section=".$subsection." or ";
		}

		$section = substr_replace($section,"",-3);
		$teachst = substr_replace($teachst,"",-3);
		$teachst = $teachst.")";
		
		$teachsem = " and (`semester` = '".$mysemester."') and";		

		$prepst = "SELECT * from experimentresults g left join oj_users u on g.username = u.username".$teachst.$teachsem." experiment=? order by u.section, u.lastname";
		$geneinfostmtf = $dbo->prepare($prepst);
			
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
		<form role="form" action="expresults.php" method="post" style="display: inline-block;">
			<div class="form-group" style="float: left;">
				<label for="username">Student Name</label>
				<br/>
				<select name="username" onChange="this.form.submit()">
				<?php 		
				$keycheck = 0;
//				echo '<option value ="">Section: None   Name: Blank Test Entry</option>';
				foreach ($geneinfoarrfull as $key => $geneinfo) {
					if ($geneinfo['username'] == $_POST['username']) {
				?>
					<option value="<?php echo $geneinfo['username'] ?>" selected="selected">Section: <?php echo $geneinfo['section'] ?>   Name: <?php echo $geneinfo['firstname']." ".$geneinfo['lastname'] ?></option>
				<?php
						$selectuser = $geneinfo['username'];
        			    $keycheck = 1;
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

<?php
		if(OJLogin::hasRole("Teacher")){
//            $temp = $_POST['username'];
//            $temp1 = $_SESSION['selectuser'];
			if ( !isset($_POST['username']) || ($_POST['username'] != $_SESSION['selectuser']) ) {
            // grab the first user database assuming $selectuser is set
//				grabUserDataFromDB($dbo, $selectuser);
   			$geneinfostmt223 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
      		$geneinfostmt223->execute([$selectuser]);
         	$geneinfoarr223 = $geneinfostmt223->fetchAll();
            $cbirc_in = $geneinfoarr223[0]['cbirc'];
   			$commentsr_in = $geneinfoarr223[0]['commentsr'];
      		if ($commentsr_in == "") { 
         		$commentsr_in = "Place Comment to Administration Here";
            }
   			$_SESSION['selectuser'] = $selectuser;
      		$_SESSION['cbirc_in'] = $cbirc_in;
         	$_SESSION['commentsr_in'] = $commentsr_in;
         }
         else { // check if cbirc and comment
				$_SESSION['selectuser'] = $selectuser;
				$cbirc_in = $_POST['cbirc'];
				if ($cbirc == null) {
//				grabUserDataFromDB($dbo, $selectuser);
   			$geneinfostmt223 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
      		$geneinfostmt223->execute([$selectuser]);
         	$geneinfoarr223 = $geneinfostmt223->fetchAll();
            $cbirc_in = $geneinfoarr223[0]['cbirc'];
   			$commentsr_in = $geneinfoarr223[0]['commentsr'];
      		if ($commentsr_in == "") { 
         		$commentsr_in = "Place Comment to Administration Here";
            }
   			$_SESSION['selectuser'] = $selectuser;
      		$_SESSION['cbirc_in'] = $cbirc_in;
         	$_SESSION['commentsr_in'] = $commentsr_in;
           	}else {
              	if ($_POST['cbirc'] != $_SESSION['cbirc_in']) {
     					$geneinfostmt33 = $dbo->prepare("UPDATE experimentresults SET `cbirc`=? WHERE username=? AND experiment=?");
        				$geneinfostmt33->execute([$_POST['cbirc'], $selectuser,1]);
           			$cbirc_in = $_POST['cbirc'];
                 	// update the saved user info
                 	$_SESSION['cbirc_in'] = $cbirc_in;
              	}
              	$commentsr_in = $_POST['commentsr'];
              	if ($_POST['commentsr'] != $_SESSION['commentsr_in']) {
           			$geneinfostmt33 = $dbo->prepare("UPDATE experimentresults SET `commentsr`=? WHERE username=? AND experiment=?");
           			$geneinfostmt33->execute([$_POST['commentsr'], $selectuser,1]);
              		$commentsr_in = $_POST['commentsr'];
                  $_SESSION['commentsr_in'] = $commentsr_in;
  	            }
            }
         }
		}
?>
			<div class="form-group" style="float: left; padding-left: 10px;">
			
				<label for="cbirc">TA Comment to Administration</label>
				<br/>
				<select name="cbirc" onChange="this.form.submit()">

				<option value="<?php echo $cbirc_in;?>" selected="selected">Selected: <?php echo $cbirc_in;?></option>
				<option value="1. Contamination">1. Contamination</option>
				<option value="2. Keep Plate">2. Keep Plate</option>				
				<option value="3. Nice Colonies">3. Nice Colonies</option>		
				<option value="4. Few Colonies">4. Few Colonies</option>		
				<option value="5. Don't Trust">5. Don't Trust</option>					
				
				</select>

				<div style="padding-top: 10px" >
					<textarea name="commentsr"><?php echo $commentsr_in;?></textarea>
					<button type="submit" name="savecomment" value="saved" class="btn btn-primary" style="margin-bottom: 40px">Save Comment</button>
				</div>
			</div>		

		</form>

<?php
		if (!isset($_POST['username']) and (OJLogin::hasRole("Teacher"))) {
			$_POST['username'] = $selectuser;
		}

	}
	
		?>
			<TABLE CELLSPACING=1000 CELLPADDING=1000>
			<tr>
			<TD style="width: 54px; height: 40px;" BGCOLOR="white">&nbsp;&nbsp;</TD>
			<TD style="width: 40px; height: 40px;" BGCOLOR="white"><b>1</b></TD>
			<TD style="width: 40px; height: 40px;" BGCOLOR="white"><b>2</b></TD>
			<TD style="width: 40px; height: 40px;" BGCOLOR="white"><b>3</b></TD>
			<TD style="width: 42px; height: 40px;" BGCOLOR="white"><b>4</b></TD>
			<TD style="width: 42px; height: 40px;" BGCOLOR="white"><b>5</b></TD>
			<TD style="width: 42px; height: 40px;" BGCOLOR="white"><b>6</b></TD>
			</tr>
			</TABLE>

			<?php
			$minihexarray = [
						  array('#517745'),
						  array('#FF4D4D'),
						  array('#3E8763'),
						  array('#E68A00'),
						  array('#CC74CC'),
						  array('#1975A3'),
						  array('#A375FF'),
						  array('#6B6B47')						  
						];
			$minicolorKey = 0;
			?>
			
		<div class="table-responsive" style="display: table;">
			<table class="table">
				<thead>				
					<tr>
						<?php if(OJLogin::hasRole("Teacher")){ echo '<th>Student</th>'; } ?>
						<th style="width: 126px;">Experimental Strain Name (Knockout + Plasmid)</th>
						<th style="width: 126px;">Successful Transformation</th>
						<th style="width: 126px;">TA Comment</th>
						<th style="width: 126px;">Biological Replication</th>
						<th style="width: 126px;">Technical Replication</th>
						<th style="width: 96px;">Plate Region</th>
						<th style="width: 96px;">Failed Transformations</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$dbo = OJLogin::getDBO();
					$itemcount = 0;
					$boxarray = array();
					if ( isset($_POST['username']) ) {
						$getUser = $_POST['username'];						
					} else if (OJLogin::hasRole("Teacher")) {
						$getUser = $selectuser;
					} else {
						$getUser = OJLogin::getUsername();
					}
					
					$orderby = "e.experiment";
					$extraconditions = " and u.username=?";
					$args = [$semester,$getUser];
					


					$geneinfostmt = $dbo->prepare("SELECT * from experimentaldesign e left join oj_users u on e.username=u.username where u.semester=? and (".$section.")".$extraconditions." ORDER BY ".$orderby);
					$geneinfostmt->execute($args);
					$geneinfoarr = $geneinfostmt->fetchAll();

					$geneinfostmt2 = $dbo->prepare("SELECT from experimentaldesign where username=? and experiment=?");
					$geneinfostmt2->execute([$getUser,1]);
					$geneinfoarr2 = $geneinfostmt2->fetchAll();
					
					$geneinfostmt22 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
					$geneinfostmt22->execute([$getUser]);
					$geneinfoarr22 = $geneinfostmt22->fetchAll();
					

					if ((isset($_SESSION['post-data']["saver"])) and ($_SESSION['post-data']["saver"] != 0)){
						$geneinfostmt23 = $dbo->prepare("UPDATE experimentaldesign SET `tablesaved`=? WHERE username=? AND experiment=?");
						$geneinfostmt23->execute([$_SESSION['post-data']["saver"],$getUser,1]);
					} else {					
						foreach ($geneinfoarr as $key => $geneinfo2) {
							$_SESSION['post-data']["saver"] = $geneinfo2['tablesaved'];
							break;
						}
					}


					
					foreach ($geneinfoarr as $key => $geneinfo) {
						if ($geneinfo['experiment'] <= $_SESSION['post-data']["saver"]) {
							echo '<tr'.($geneinfo['experiment']==1?' style="border-top: 2px solid #ddd"':'').'>';
							echo (OJLogin::hasRole("Teacher")?'<td>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['exp-strain']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['successtrans']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['TAsuccesstrans']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['brep']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['trep']."</td>";


							$plate_check = $geneinfoarr22[$key]['plateregion'];
							$platelets = explode('-',$plate_check);
							$locitemc = 0;
							if ($plate_check != "") {
								if (strlen($plate_check) == 2) {
									if ((($plate_check[0] >= 'A') && ($plate_check[0] <= 'F')) && (($plate_check[1] <= 6) && ($plate_check[1] >= 1))) {
										$itemcount = $itemcount + 1;
										$locitemc = $locitemc + 1;
										$boxarray[] = array($geneinfoarr22[$key]['plateregion'], $geneinfoarr22[$key]['brep'], $geneinfoarr22[$key]['trep']) ;
									}
								} else if (strlen($plate_check) == 5) {
									if (((($platelets[0][0] >= 'A') && ($platelets[0][0] <= 'F')) && (($platelets[0][1] <= 6) && ($platelets[0][1] >= 1)))
									 && ((($platelets[1][0] >= 'A') && ($platelets[1][0] <= 'F')) && (($platelets[1][1] <= 6) && ($platelets[1][1] >= 1)))) {
										$itemcount = $itemcount + 1;
										$locitemc = $locitemc + 1;
										$boxarray[] = array($geneinfoarr22[$key]['plateregion'], $geneinfoarr22[$key]['brep'], $geneinfoarr22[$key]['trep']) ;
									}
								}
							}

							if ($locitemc > 0) {
							echo '<td style="color:white; border-left: 1px" BGCOLOR="'.$minihexarray[($minicolorKey % 8)][0].'">'.$geneinfoarr22[$key]['plateregion']."</td>";
							$minicolorKey = $minicolorKey + 1;
							} else {
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['plateregion']."</td>";
							}
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key]['fails']."</td>";



							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>
			<table class="table">
				<thead>
					<tr>
						<?php if(OJLogin::hasRole("Teacher")){ echo '<th>Student</th>'; } ?>
						<th style="width: 126px;">Control Strain Name</th>
						<th style="width: 126px;"></th>
						<th style="width: 126px;"></th>
						<th style="width: 126px;">Biological Replication</th>
						<th style="width: 126px;">Technical Replication</th>
						<th style="width: 96px;">Plate Region</th>
						<th style="width: 96px;">Failed Transformations</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$dbo = OJLogin::getDBO();
					
					if ( isset($_POST['username']) ) {
						$getUser = $_POST['username'];						
					} else if (OJLogin::hasRole("Teacher")) {
						$getUser = $selectuser;
					} else {
						$getUser = OJLogin::getUsername();
					}					
					
					$orderby = "e.experiment";
					$extraconditions = " and u.username=?";
					$args = [$semester,$getUser];					
					


					$geneinfostmt = $dbo->prepare("SELECT * from experimentaldesign e left join oj_users u on e.username=u.username where u.semester=? and (".$section.")".$extraconditions." ORDER BY ".$orderby);
					$geneinfostmt->execute($args);
					$geneinfoarr = $geneinfostmt->fetchAll();

					$geneinfostmt2 = $dbo->prepare("SELECT from experimentaldesign where username=? and experiment=?");
					$geneinfostmt2->execute([$getUser,1]);
					$geneinfoarr2 = $geneinfostmt2->fetchAll();
					
					$geneinfostmt22 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
					$geneinfostmt22->execute([$getUser]);
					$geneinfoarr22 = $geneinfostmt22->fetchAll();
					
					if ((isset($_SESSION['post-data']["savey"])) and ($_SESSION['post-data']["savey"] != 0)){
						$geneinfostmt23 = $dbo->prepare("UPDATE experimentaldesign SET `tablesavedy`=? WHERE username=? AND experiment=?");
						$geneinfostmt23->execute([$_SESSION['post-data']["savey"],$getUser,1]);
					} else {					
						foreach ($geneinfoarr as $key => $geneinfo2) {
							$_SESSION['post-data']["savey"] = $geneinfo2['tablesavedy'];
							break;
						}
					}
					
					
					$temp_saver = $_SESSION['post-data']["saver"];
					$first_control = 0;
					foreach ($geneinfoarr22 as $kwy => $geneinfo22) {
						if ($geneinfo22['experiment'] == 500001) {
							$first_control = $kwy;
							break;
							}
					}
					
					foreach ($geneinfoarr as $key => $geneinfo) {
						if ($geneinfo['experiment'] <= $_SESSION['post-data']["savey"]) {
							echo '<tr'.($geneinfo['experiment']==1?' style="border-top: 2px solid #ddd"':'').'>';
							echo (OJLogin::hasRole("Teacher")?'<td>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['control-strain']."</td>";
							echo '<td style="border-left: 1px solid #ddd"></td>';
							echo '<td style="border-left: 1px solid #ddd"></td>';
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key+$first_control]['brep']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key+$first_control]['trep']."</td>";

							$locitemc = 0;
							$plate_check = $geneinfoarr22[$key+$first_control]['plateregion'];
							$platelets = explode('-',$plate_check);
							if ($plate_check != "") {
								if (strlen($plate_check) == 2) {
									if ((($plate_check[0] >= 'A') && ($plate_check[0] <= 'F')) && ( ($plate_check[1] <= 6) && ($plate_check[1] >= 1) )) {
										$itemcount = $itemcount + 1;
										$locitemc = $locitemc + 1;
										$boxarray[] = array($geneinfoarr22[$key+$first_control]['plateregion'],$geneinfoarr22[$key+$first_control]['brep'],$geneinfoarr22[$key+$first_control]['trep']);
									}
								} else if (strlen($plate_check) == 5) {
									if (((($platelets[0][0] >= 'A') && ($platelets[0][0] <= 'F')) && (($platelets[0][1] <= 6) && ($platelets[0][1] >= 1)))
									 && ((($platelets[1][0] >= 'A') && ($platelets[1][0] <= 'F')) && (($platelets[1][1] <= 6) && ($platelets[1][1] >= 1)))) {
										$itemcount = $itemcount + 1;
										$locitemc = $locitemc + 1;
										$boxarray[] = array($geneinfoarr22[$key+$first_control]['plateregion'],$geneinfoarr22[$key+$first_control]['brep'],$geneinfoarr22[$key+$first_control]['trep']);
									}
								}
							}
							if ($locitemc > 0) {
							echo '<td style="color:white; border-left: 1px" BGCOLOR="'.$minihexarray[($minicolorKey % 8)][0].'">'.$geneinfoarr22[$key+$first_control]['plateregion']."</td>";
							$minicolorKey = $minicolorKey + 1;
							} else {
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfoarr22[$key+$first_control]['plateregion']."</td>";
							}
							
							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>




			
			

			

			<TABLE BORDER=3 CELLSPACING=1000 CELLPADDING=1000 style="display: table-header-group;">
			<?php
			$regionKey = 0;
			$entry = 0;
			$bioreps = $boxarray[$regionKey][1];
			$techreps = $boxarray[$regionKey][2];
			$techcounts = 0;
			$repscomp = 0;
			sort($boxarray);
			$hexarray = [
						  array('#517745','#659556','#84AA78','#B1C9A9','#D0DFCB','#E3ECE0'),
						  array('#FF4D4D','#FF7171','#FF9C9C','#FFBABA','#FFDCDC','#FFF1F1'),
						  array('#3E8763','#659F82','#84B29B','#A9C9B9','#C3D9CE','#E9F1EE'),
						  array('#E68A00','#EEAD4D','#F1BD71','#F4CA8D','#F7DAAF','#FAE9CF'),
						  array('#CC74CC','#FF91FF','#FFB2FF','#FFC9FF','#FFDFFF','#FFEFFF'),
						  array('#1975A3','#4791B5','#6CA7C4','#98C1D6','#C1DAE6','#E0ECF2'),
						  array('#A375FF','#B591FF','#C4A7FF','#D6C1FF','#E2D4FF','#F0EAFF'),
						  array('#6B6B47','#89896C','#A1A189','#BDBDAC','#D7D7CD','#E7E7E1')						  
						];

			
			for($count1 = 0; $count1<6; $count1++){ 
				$alpha = $itemcount;
				$letter .= chr(65 + $count1);
				$letter2 = $letter[$count1];
				?>
				<TR>
				<TD style="border:0px; width: 40px; height: 40px;" BGCOLOR="white"><b><?php echo $letter2?></b></TD>
				<?php

				for($count2 = 1; $count2<7; $count2++){ ?>
					<?php
					if (strlen($boxarray[$regionKey][0]) > 2) {
						$pieces = explode('-',$boxarray[$regionKey][0]);
						$currentKey = $pieces[0];
						if ($letter2.$count2 == $currentKey) {
							$entry = 1;
							}
						$endKey = $pieces[1];
						
					} else {
						$currentKey = $boxarray[$regionKey][0];
						$endKey = $boxarray[$regionKey][0];
					}
					if ($colorKey != $regionKey) { $repscomp = 0; }
					$colorKey = $regionKey;
					if ( ($letter2.$count2 == $currentKey) or ($entry == 1)) {
					
						if ($techcounts == $techreps) {
							$repscomp = $repscomp + 1;
							$techcounts = 0;

						}
						$techcounts = $techcounts + 1;					
					
						if ( $letter2.$count2 == $endKey ) { 
							$regionKey = $regionKey + 1;
							$bioreps = $boxarray[$regionKey][1];
							$techreps = $boxarray[$regionKey][2];
							$techcounts = 0;
							$entry = 0;
						}


						?>
						

						<TD style="width: 40px; height: 40px; "BGCOLOR="<?php echo $hexarray[($colorKey % 8)][$repscomp % 6] ?>"><?php ?></TD>
					<?php 
					} else {
					?>
						<TD style="width: 40px; height: 40px;" BGCOLOR="white">&nbsp;&nbsp;</TD>
					<?php 
					}
					?>
					
				<?php					
				} ?>
				</TR>
			<?php
			}
			?>
			</TABLE>
		</div>

		<?php
	}
	if(OJLogin::hasRole("Student")){
?>
		<div class="well well-sm">
			<a type="button" class="btn btn-primary" href="editexpresults.php">Add/Edit</a> &nbsp; Students, enter your Experimental Results here!
		</div>
<?php
		drawTables(OJLogin::getUserAttribute("semester"),OJLogin::getUserAttribute("section"));
	} else if (OJLogin::hasRole("Teacher")){
	?>
		<form role="form" action="editexpresults.php" method="post">
	<?php
		if (!isset($_POST['username'])) {
	?>
			<input type="hidden" name="selectedUser1" value="<?php echo $_SESSION['username-post-datax'];?>"/>
	<?php
		}	
		else {
	?>
			<input type="hidden" name="selectedUser1" value="<?php echo $_POST['username'];?>"/>
	<?php
		}
	?>
		<div class="well well-sm">
			<button type="submit" class="btn btn-primary">Add/Edit</button>&nbsp; Teachers, change your Experimental Results here!
		</div>
		</form>
	<?php
		$dbo = OJLogin::getDBO();
		$teacher_section = OJLogin::getUserAttribute("section");
		$mysemester = OJLogin::getUserAttribute("semester");
		drawTables($mysemester,$teacher_section);

	}
}
OJLogin::drawFooter();
?>
