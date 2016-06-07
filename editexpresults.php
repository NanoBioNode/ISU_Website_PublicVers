<?php
include('OJLogin.php');
OJLogin::init();
$page="editexpresults";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
?>
	<div class="well well-sm">
	Editing Exp Results
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
			$geneinfostmtf->execute([1]);
			$geneinfoarrfull = $geneinfostmtf->fetchAll();
			if (isset($_POST['selectedUser1'])) {
				$_POST['username'] = $_POST['selectedUser1'];
			}
	?>
			<form role="form" action="editexpresults.php" method="post">
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
		
		} ?>






		<?php
		$dbo = OJLogin::getDBO();
		
		if ( isset($_POST['username']) ) {
			$getUser = $_POST['username'];						
		} else if (OJLogin::hasRole("Teacher")) {
			$getUser = $selectuser;
		} else {
			$getUser = OJLogin::getUsername();
		}


		$geneinfosxy = $dbo->prepare("SELECT * from experimentaldesign where username=? and experiment=?");
		$geneinfosxy->execute([$getUser, 1]);
		$geneinfoxyf = $geneinfosxy->fetchAll();
		foreach ($geneinfoxyf as $key => $geneinfo2) {
			$_POST["saver"] = $geneinfo2['tablesaved'];
			$_POST["savey"] = $geneinfo2['tablesavedy'];
			break;
		}

		
		$geneinfostmt = $dbo->prepare("SELECT * from experimentaldesign where username=? order by experiment");
		$geneinfostmt->execute([$getUser]);
		$geneinfoarr = $geneinfostmt->fetchAll();
		

		$geneinfostmt22 = $dbo->prepare("SELECT * from experimentresults where username=? order by experiment");
		$geneinfostmt22->execute([$getUser]);
		$geneinfoarr22 = $geneinfostmt22->fetchAll();
		
		foreach ($geneinfoarr22 as $kwy => $geneinfo22) {
			if ($geneinfo22['experiment'] == "500001") {
				$first_control = $kwy;
				break;
				}
		}

		
		if ($_POST["saver"]=="") {
			$todraw = $_SESSION['post-data']["saver"];
		} else {
			$todraw = $_POST["saver"];
		}

		if ($_POST["savey"]=="") {
			$todraw2 = $_SESSION['post-data']["savey"];
		} else {
			$todraw2 = $_POST["savey"];
		}
		
		
		$drawer = $todraw;
		
		$keycount = 0;
		for($counter = 0; $counter<$drawer; $counter++){
			$keycount = $keycount + 1;
			if ($geneinfoarr[$counter]['experiment'] == "") {
				$geneinfoarr[$counter]['experiment'] = $keycount;
			}		
		}

		
		
		
		?>
		<form role="form" action="saveexpresults.php" method="post">
			<table class="table table-striped">
				<thead>
					<tr>

						<th>Yeast Strain (Knockout)</th>
						<th> Plasmid Name </th>
						<th>Experimental Strain Name (Knockout + Plasmid)</th>
						<th>Successful Transformation</th>
						<th>TA Comment</th>
						<th>Biological Rep</th>
						<th>Technical Rep</th>
						<th>Plate Region</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for($count = 0; $count<$todraw; $count++){

					?>
					<tr>
						<td><?php echo $geneinfoarr[$count]["exp-knockout"]; ?></td>
						<td><?php echo $geneinfoarr[$count]["exp-plasmid"]; ?></td>
						<td><?php echo $geneinfoarr[$count]["exp-strain"]; ?></td>
						<td style="border-left: 1px solid #ddd">
								<select name="successtrans-<?php echo $count+1;?>">
									<option value="<?php echo $geneinfoarr22[$count]['successtrans'];?>" selected="selected">Selected: <?php echo $geneinfoarr22[$count]['successtrans'];?></option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>				
									<option value="">Blank</option>				
								</select>
						</td>
						<?php if(OJLogin::hasRole("Teacher")){ ?>

						<td style="border-left: 1px solid #ddd">
							<select name="TAsuccesstrans-<?php echo $count+1;?>">
							<option value="<?php echo $geneinfoarr22[$count]['TAsuccesstrans'];?>" selected="selected">Selected: <?php echo $geneinfoarr22[$count]['TAsuccesstrans'];?></option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>				
							<option value="">Blank</option>				
							</select>
						</td>

						<?php } else { ?>

						<td style="border-left: 1px solid #ddd">
								<input name="TAsuccesstrans-<?php echo $count+1;?>" class="form-control" type="hidden" value="<?php echo $geneinfoarr22[$count]['TAsuccesstrans'];?>"/>
						</td>
						<?php }?>
						<td>
								<input name="brep-<?php echo $count+1;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count]['brep'];?>" /> 
						</td>
						<td>
								<input name="trep-<?php echo $count+1;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count]['trep'];?>" />
						</td>

						<td>
								<input name="plateregion-<?php echo $count+1;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count]['plateregion'];?>" />
						</td>
								<input name="fails-<?php echo $count+1;?>" class="form-control" type="hidden" value="<?php echo $geneinfoarr22[$count]['fails'];?>" />
						

					</tr>
					<?php
					}
					?>
					
					<?php
					for($count = 0; $count<$todraw2; $count++){

					?>
					<tr>
						<td><?php echo "Control"; ?></td>
						<td><?php echo "Strain" ?></td>
						<td><?php echo $geneinfoarr[$count]["control-strain"]; ?></td>
						<td style="border-left: 1px solid #ddd">
						</td>
						<td style="border-left: 1px solid #ddd">

						</td>

						<td>
								<input name="brep-<?php echo $count+1+500000;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count+$first_control]['brep'];?>" /> 
						</td>
						<td>
								<input name="trep-<?php echo $count+1+500000;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count+$first_control]['trep'];?>" />
						</td>
						<td>
								<input name="plateregion-<?php echo $count+1+500000;?>" class="form-control" type="text" value="<?php echo $geneinfoarr22[$count+$first_control]['plateregion'];?>" />
						</td>
						

					</tr>
					<?php
					}
					?>
					
					
				</tbody>
			</table>
			<input type="hidden" name="selectedUser" value="<?php echo $getUser;?>"/>
			<input type="hidden" name="count" value="<?php echo $count;?>"/>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>
<?php
}
OJLogin::drawFooter();
?>
