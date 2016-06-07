<?php
include('OJLogin.php');
OJLogin::init();
$page="geneinfo";
OJLogin::drawHeader();

if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
?>
	<div class="well well-sm">
	Adding a Gene
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


			$teachsem = " and (`semester` = '".$mysemester."')";
			
						
			$prepst = "SELECT * from geneinfo g left join oj_users u on g.username = u.username".$teachst.$teachsem." group by u.username order by u.section, u.lastname" ;
			$geneinfostmtget = $dbo->prepare($prepst);
			$geneinfostmtget->execute();
			$geneinfoarrgetfull = $geneinfostmtget->fetchAll();
			if (isset($_SESSION['username-post-data']) and ($_SESSION['redirect-geneinfo'] == 1)) {
				$_POST['username'] = $_SESSION['username-post-data'];
				$_SESSION['redirect-geneinfo'] = 0;
			}
	?>
			<form role="form" action="addgeneinfo.php" method="post">
				<div class="form-group">
					<label for="username">Student Name</label>
					<br/>
					<select name="username" onChange="this.form.submit()">
					<?php 		
					$keycheck = 0;
					foreach ($geneinfoarrgetfull as $key => $geneinfo) {
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
		
		
		if (isset($_POST['genename'])){
			$geneinfostmt = $dbo->prepare("SELECT * from geneinfo where username=? and genename=?");
			$geneinfostmt->execute([$getUser, $_POST['genename']]);
			$geneinfoarr = $geneinfostmt->fetch();	
		} else {
			$geneinfostmt = $dbo->prepare("SELECT * from geneinfo where username=?");
			$geneinfostmt->execute([$getUser]);
			$geneinfoarr = $geneinfostmt->fetch();	
		}
		
		
		$geneinfostmtf = $dbo->prepare("SELECT * from geneinfo where username=?");
		$geneinfostmtf->execute([$getUser]);
		$geneinfoarrfull = $geneinfostmtf->fetchAll();
		?>
		

		<form role="form" action="savegeneinfo.php" method="post">

			<div class="form-group">
				<label for="genename">Gene Name</label>
				<input name="genename" class="form-control" type="text" value=""/>
			</div>	

			<div class="form-group">
				<label for="systematicname">Systematic Name</label>
				<input name="systematicname" class="form-control" type="text" value="" /> 
			</div>
			<div class="form-group">
				<label for="size">Size</label>
				<input name="size" class="form-control" type="text" value="" />
			</div>
			<div class="form-group">
				<label for="info">Function</label>
				<textarea name="info" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label for="function">General Function</label>
				<p>
				<select name="function">
								<option value="<?php echo $geneinfoarr['function'] ?>" selected="selected"><?php echo 'Selected: '.$geneinfoarr['function']  ?></option>
								<option value="Transcription Factor"><?php echo "Transcription Factor" ?></option>
								<option value="Protein Trafficking"><?php echo "Protein Trafficking" ?></option>
								<option value="Ubiquitin"><?php echo "Ubiquitin" ?></option>
								<option value="DNA Repair"><?php echo "DNA Repair" ?></option>
								<option value="mRNA Splicing/Export"><?php echo "mRNA Splicing/Export" ?></option>
								<option value="Cell-Division Cycle"><?php echo "Cell-Division Cycle" ?></option>
								<option value="Other-Metabolic Degradation"><?php echo "Other-Metabolic Degradation" ?></option>
				</select>			
				</p>
			</div>
			<div class="form-group">
				<label for="experimentalinfo">Lipid Phenotype from Knockout Strain</label><p>
				<select name="experimentalinfo">
								<option value="<?php echo $geneinfoarr['experimentalinfo'];?>" selected="selected"><?php echo "Selected: ".$geneinfoarr['experimentalinfo'];?></option>
								<option value="1. Negative Lipid Regulator"><?php echo "1. Negative Lipid Regulator" ?></option>
								<option value="2. Positive Lipid Regulator"><?php echo "2. Positive Lipid Regulator" ?></option>
								<option value="3. Unknown Lipid Function"><?php echo "3. Unknown Lipid Function" ?></option>
								<option value=" "><?php echo "4. Blank" ?></option>
				</select>		
			</div>
			<input type="hidden" name="selectedUser" value="<?php echo $getUser;?>"/>
			<button type="submit" name="updater" value="updated" class="btn btn-primary">Add</button>
			<button type="submit" name="updater" value="cancel" formaction="geneinfo.php" class="btn btn-primary">Cancel</button>

		</form>
<?php
}
OJLogin::drawFooter();
?>
