<?php
include('OJLogin.php');
OJLogin::init();
$page="expdesign";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
	function drawSectionTable($semester,$section){ 
		?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="4" style="border-left: 2px solid #ddd">Experiment</th>
						<th style="border-left: 2px solid #ddd">Control</th>
						<th style="border-left: 2px solid #ddd"> </th>
					</tr>
					<tr>
						<?php if(OJLogin::hasRole("Teacher")){ echo '<th>Student</th>'; } ?>
						<th>Experiment #</th>
						<th style="border-left: 2px solid #ddd">Yeast Strain (Knockout)</th>
						<th>Plasmid Name</th>
						<th style="border-left: 2px solid #ddd">Experimental Strain Name (Knockout + Plasmid)</th>
						<th style="border-left: 2px solid #ddd">Control Strain</th>
						<th style="border-left: 2px solid #ddd">Comments</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$dbo = OJLogin::getDBO();

					if (OJLogin::hasRole("Teacher")) {
						$orderby = "u.lastname, e.experiment";
						$extraconditions = "";
						$args = [$semester,$section];
					} else {
						$orderby = "e.experiment";
						$extraconditions = " and u.username=?";
						$args = [$semester,$section,OJLogin::getUsername()];
					}


					$geneinfostmt = $dbo->prepare("SELECT * from experimentaldesign e left join oj_users u on e.username=u.username where u.semester=? and u.section=?".$extraconditions." ORDER BY ".$orderby);
					$geneinfostmt->execute($args);
					$geneinfoarr = $geneinfostmt->fetchAll();

					if (OJLogin::hasRole("Student")) {
					
						if ((isset($_SESSION['post-data']["saver"])) and ($_SESSION['post-data']["saver"] != 0)){
							$geneinfostmt23 = $dbo->prepare("UPDATE experimentaldesign SET `tablesaved`=? WHERE username=? AND experiment=?");
							$geneinfostmt23->execute([$_SESSION['post-data']["saver"],OJLogin::getUsername(),1]);
						} else {					
							foreach ($geneinfoarr as $key => $geneinfo2) {
								$_SESSION['post-data']["saver"] = $geneinfo2['tablesaved'];
								break;
							}
						}

						if ((isset($_SESSION['post-data']["savey"])) and ($_SESSION['post-data']["savey"] != 0)){
							$geneinfostmt23 = $dbo->prepare("UPDATE experimentaldesign SET `tablesavedy`=? WHERE username=? AND experiment=?");
							$geneinfostmt23->execute([$_SESSION['post-data']["savey"],OJLogin::getUsername(),1]);
						} else {					
							foreach ($geneinfoarr as $key => $geneinfo2) {
								$_SESSION['post-data']["savey"] = $geneinfo2['tablesavedy'];
								break;
							}
						}
					}
					
					foreach ($geneinfoarr as $key => $geneinfo) {
			
						if (OJLogin::hasRole("Teacher") and ($geneinfo['tablesaved'] > 0)) {
							$_SESSION['post-data']["saver"] = $geneinfo['tablesaved'];
						}
						
						if ($geneinfo['experiment'] <= $_SESSION['post-data']["saver"]) {
							echo '<tr'.($geneinfo['experiment']==1?' style="border-top: 2px solid #ddd"':'').'>';
							echo (OJLogin::hasRole("Teacher")?'<td>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
							echo '<td style="border-left: 2px solid #ddd">'.$geneinfo['experiment']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['exp-knockout']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['exp-plasmid']."<br>".$geneinfo['exp-plasmid2']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['exp-strain']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['control-strain']."</td>";
							echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['comments']."</td>";
							echo '</tr>';
						} else {
						
							if (OJLogin::hasRole("Teacher") and ($geneinfo['tablesavedy'] > 0)) {
									$_SESSION['post-data']["savey"] = $geneinfo2['tablesavedy'];
							}
							
							if ($geneinfo['experiment'] <= $_SESSION['post-data']["savey"]) {
								echo '<tr'.($geneinfo['experiment']==1?' style="border-top: 2px solid #ddd"':'').'>';
								echo (OJLogin::hasRole("Teacher")?'<td>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
								echo '<td style="border-left: 1px solid #ddd"></td>';
								echo '<td style="border-left: 1px solid #ddd"></td>';
								echo '<td style="border-left: 1px solid #ddd"></td>';
								echo '<td style="border-left: 1px solid #ddd"></td>';
								echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['control-strain']."</td>";
								echo '<td style="border-left: 1px solid #ddd">'.$geneinfo['comments']."</td>";
								echo '</tr>';
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}
	if(OJLogin::hasRole("Student")){
?>
		<div class="well well-sm">
			<a type="button" class="btn btn-primary" href="editexpdesign.php">Add/Edit</a> &nbsp; Students, enter your Experimental Design here!
		</div>
<?php
		drawSectionTable(OJLogin::getUserAttribute("semester"),OJLogin::getUserAttribute("section"));
	} else if (OJLogin::hasRole("Teacher")){
	
		?><div class="well well-sm">
			<a type="button" class="btn btn-primary" href="editexpdesign.php">Add/Edit</a> &nbsp; Teachers, enter your Experimental Design here!
		</div>	<?php
		$dbo = OJLogin::getDBO();
		$mysemester = OJLogin::getUserAttribute("semester");
		$sectionStmt = $dbo->prepare("SELECT DISTINCT(`section`) AS `section` FROM `oj_users` ORDER BY `section` ASC");
		$sectionStmt->execute([$mysemester]);	
		$sections = $sectionStmt->fetchAll();
		$teacher_section = OJLogin::getUserAttribute("section");

		$ts_split = explode(',',$teacher_section);
		foreach ($ts_split as $subsection) {
				echo "<h4>Section ".$subsection."</h4>";
				drawSectionTable($mysemester, $subsection);
		}
	}
}
OJLogin::drawFooter();
?>
