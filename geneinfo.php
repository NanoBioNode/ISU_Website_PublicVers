<?php
include('OJLogin.php');
OJLogin::init();
$page="geneinfo";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
	function drawSectionTable($semester,$section){ 
		?>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<form name="sorttype<?php echo $section;?>" action="geneinfo.php" method="post">
						<?php
						if (isset($_SESSION["hx_data"]["hx".$section])) {
						?>
						<input type='hidden' id='hx<?php echo $section;?>' name='hx<?php echo $section;?>' value='<?php echo $_SESSION["hx_data"]["hx".$section] ;?>'>
						<?php
						} else {
						?>
						<input type='hidden' id='hx<?php echo $section;?>' name='hx<?php echo $section;?>' value=''>
						<?php
						}
						
						?>

						<?php if(OJLogin::hasRole("Teacher") or OJLogin::hasRole("Student")){ ?>
						<th><a href="javascript: submitform<?php echo $section;?>('u.lastname')">Student</a></th> 
						<?php } ?>
						<div>
						<th><a href="javascript: submitform<?php echo $section;?>('g.genename')">Gene Name</a></th>
						<th><a href="javascript: submitform<?php echo $section;?>('g.systematicname')">Systematic Name</a></th>
						<th><a href="javascript: submitform<?php echo $section;?>('g.size*1')">Size</a></th>
						<th><a href="javascript: submitform<?php echo $section;?>('g.info')">Function</a></th>
						<th><a href="javascript: submitform<?php echo $section;?>('g.function')">General Function</a></th>
						<th><a href="javascript: submitform<?php echo $section;?>('g.experimentalinfo')">Lipid Phenotype from Knockout Strain</a></th>

						</div>
						</form>
					</tr>
				</thead>
				<tbody>
					<?php
					$dbo = OJLogin::getDBO();
					
					if (OJLogin::hasRole("Teacher") or OJLogin::hasRole("Student") ) {
						$orderby = "u.lastname, g.genename";
						$extraconditions = "";
						$args = [$semester,$section];
					} else {
						$orderby = "g.genename";
						$extraconditions = " and u.username=?";
						$args = [$semester,$section,OJLogin::getUsername()];
					}

					if (isset($_POST['hx'.$section])) {
						$orderby = $_POST['hx'.$section];
						if ($_SESSION['ascdesc'] == "ASC") {
							$ascdesc = "DESC";
						} else {
							$ascdesc = "ASC";
						}
						$_SESSION['ascdesc'] = $ascdesc;
						if ($_POST['hx'.$section] != $_SESSION['hx_data']['hx'.$section]) {
							$ascdesc = "ASC";
							$_SESSION['ascdesc'] = $ascdesc;
						}
					} elseif (isset($_SESSION['hx_data']['hx'.$section])) {
						$orderby = $_SESSION['hx_data']['hx'.$section];
					}


					
					$geneinfostmt = $dbo->prepare("SELECT * from geneinfo g left join oj_users u on g.username=u.username where u.semester=? and u.section=?".$extraconditions." order by ".$orderby." ".$ascdesc);	
					$geneinfostmt->execute($args);
					$geneinfoarr = $geneinfostmt->fetchAll();



					foreach ($geneinfoarr as $key => $geneinfo) {
						$bgcolo = "";
						$bgcolo2 = "";					
						if ($geneinfo['function'] == "Transcription Factor") {
							$bgcolo2 = ' BGCOLOR="#C9D8C2" ';
						} elseif ($geneinfo['function'] == "Protein Trafficking") {
							$bgcolo2 = ' BGCOLOR="#F1E3FF" ';
						} elseif ($geneinfo['function'] == "Ubiquitin") {
							$bgcolo2 = ' BGCOLOR="#E6A9A9" ';
						} elseif ($geneinfo['function'] == "DNA Repair") {
							$bgcolo = 'info';
						} elseif ($geneinfo['function'] == "mRNA Splicing/Export") {
							$bgcolo2 = ' BGCOLOR="#7BBC7B" ';
						} elseif ($geneinfo['function'] == "Cell-Division Cycle") {
							$bgcolo2 = ' BGCOLOR="#CCFF99" ';
							##
						} elseif ($geneinfo['function'] == "Other-Metabolic Degradation") {
							$bgcolo2 = ' BGCOLOR="#AC8359" ';
						} else {
							$bgcolo = "";
						}
						
						echo '<tr class="'.$bgcolo.'">';
						echo (OJLogin::hasRole("Teacher")?'<td'.$bgcolo2.'>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
						echo (OJLogin::hasRole("Student")?'<td'.$bgcolo2.'>'.$geneinfo['firstname'].' '.$geneinfo['lastname'].'</td>':'');
						echo '<td'.$bgcolo2.'>'.$geneinfo['genename']."</td>";
						echo '<td'.$bgcolo2.'>'.$geneinfo['systematicname']."</td>";
						echo '<td'.$bgcolo2.'>'.$geneinfo['size']."</td>";
						echo '<td'.$bgcolo2.'>'.$geneinfo['info']."</td>";
						echo '<td'.$bgcolo2.'>'.$geneinfo['function']."</td>";
						echo '<td'.$bgcolo2.'>'.$geneinfo['experimentalinfo']."</td>";
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
		if ($_POST["hx".$section] != "") {
		$_SESSION['hx_data']['hx'.$section] = $_POST["hx".$section];
		}

		?>
		<div>
			<script type="text/javascript">
			function submitform<?php echo $section;?>(val)
			{
			  $("#hx<?php echo $section;?>").val(val);
			  document.sorttype<?php echo $section;?>.submit();
			}
			</script>
		</div>
		
		
		<?php
	}
	if(OJLogin::hasRole("Student")){
?>
		<div class="well well-sm">
			<a type="button" class="btn btn-primary" href="addgeneinfo.php">Add Gene</a> &nbsp; 
			<a type="button" class="btn btn-primary" href="editgeneinfo.php">Edit/Remove</a> &nbsp; Students, change your Gene Info here!
		</div>

<?php
		drawSectionTable(OJLogin::getUserAttribute("semester"),OJLogin::getUserAttribute("section"));
	} else if (OJLogin::hasRole("Teacher")){ ?>

	<div class="well well-sm">
		<a type="button" class="btn btn-primary" href="addgeneinfo.php">Add Gene</a> &nbsp; 
		<a type="button" class="btn btn-primary" href="editgeneinfo.php">Edit/Remove</a> &nbsp; Teachers, change your Gene Info here!
	</div>
		<?php
		$mysemester = OJLogin::getUserAttribute("semester");
		$dbo = OJLogin::getDBO();
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
