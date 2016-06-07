<?php
include('OJLogin.php');
OJLogin::init();
$page="TApage";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {

	if(OJLogin::hasRole("Teacher")){
		$dbo = OJLogin::getDBO();

		$teacher_sec = OJLogin::getUserAttribute("section");
		$teacher_sem = OJLogin::getUserAttribute("semester");
		$getTAUser = OJLogin::getUsername();


		#special case for selecting all sections:
		if ($_POST['secnum'] == -1) {
			foreach (range(1,10) as $i) {
				$_POST['set_'.$i] = 1;
				$_POST['set_99'] = 1;
			}
		}		
		$_POST['secnum'] = '';
		
		foreach (range(1,10) as $i) {
			if (isset($_POST['set_'.$i])) {
				$_POST['secnum'] = $_POST['secnum'].$i.',';
			}
		}
		if (isset($_POST['set_99'])) {
			$_POST['secnum'] = $_POST['secnum'].'99,';
		}
		$_POST['secnum'] = rtrim($_POST['secnum'],',');
		
		
		if (($_POST['semnum'] != $teacher_sem) and ($_POST['semnum'] != NULL)){
			$geneinfostmt = $dbo->prepare("UPDATE `oj_users` SET `semester`=? WHERE `username`=?");
			$geneinfostmt->execute([$_POST['semnum'],$getTAUser]);					
			$teacher_sem = $_POST['semnum'];

		}		
		if (($_POST['secnum'] != $teacher_sec) and ($_POST['secnum'] != '')) {
			$geneinfostmt = $dbo->prepare("UPDATE `oj_users` SET `section`=? WHERE `username`=?");
			$geneinfostmt->execute([$_POST['secnum'],$getTAUser]);								
			$teacher_sec = $_POST['secnum'];
		}	



		foreach (range(0,10) as $j) {
			${'set_'.$j} = '';
		}
		
		$ts_split = explode(',',$teacher_sec);		
		foreach ($ts_split as $item) {
			foreach (range(0,10) as $j) {
				if ($item == $j) {
					${'set_'.$j} = "checked";
				}
				if ($item == 99) {
					$set_99 = "checked";
				}
			}			
		}
?>
		<form role="form" action="TApage.php" method="post">
			<div class="form-group">
				<label for="semnum">Set this account's Semester</label>
				<br/>
				<select name="semnum" onChange="this.form.submit()">
				<option value="<?php echo $teacher_sem?>" selected="selected">Selected: <?php echo $teacher_sem?></option>
				<option value="spring2015">spring2015</option>
				<option value="fall2015">fall2015</option>				
				<option value="spring2016">spring2016</option>				
				</select>
			</div>		
		</form>
		<form role="form" action="TApage.php" method="post">
			<div class="form-group">
				<label for="secnum">Set this account's Section Number(s)</label>
				<br/>
				<select name="secnum" onChange="this.form.submit()">
				<option value="<?php echo $teacher_sec?>" selected="selected">Selected: <?php echo $teacher_sec?></option>
				<option value="-1">0 - All Sections</option>
				</select>
			</div>	

		<?php foreach (range(1,10) as $i) { ?>
			<td style="border-left: 1px solid #ddd">
				<?php echo "<br/>Section ".$i." <input type='checkbox' name=".'set_'.$i." value='1' ".${'set_'.$i}."/><br>";?>
			</td>
		<?php 
		}
		?>
			<td style="border-left: 1px solid #ddd">
				<?php echo "<br/>Section 99 <input type='checkbox' name='set_99' value='1' ".$set_99."/><br>";?>
			</td>
			<p><button type="submit" name="saver" value="saved" class="btn btn-primary">Save</button></p>
		</form>

<?php
	}
}
OJLogin::drawFooter();
?>
