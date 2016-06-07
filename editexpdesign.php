<?php
include('OJLogin.php');
OJLogin::init();
$page="expdesign";
OJLogin::drawHeader();

if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {
		if(OJLogin::hasRole("Teacher")){
			?>
			<div class="well well-sm">
			Editing Exp Design, start a comment section with "  ***=  " to allow a 2nd plasmid
			</div>
			<?php

			$dbo = OJLogin::getDBO();
			
			$teacher_section = OJLogin::getUserAttribute("section");
			$mysemester= OJLogin::getUserAttribute("semester");
			
			$teachst = " and (";			
			$ts_split = explode(',',$teacher_section);
			foreach ($ts_split as $subsection) {
				$teachst = $teachst."`section` = ".$subsection." or ";

			}
			$teachst = substr_replace($teachst,"",-3);
			$teachst = $teachst.")";


			$teachsem = " and (`semester` = '".$mysemester."')";

			
			$prepst = "SELECT * from experimentaldesign g left join oj_users u on g.username = u.username where experiment=?".$teachst.$teachsem.'order by u.section, u.lastname';
			$geneinfostmtf = $dbo->prepare($prepst);
			$geneinfostmtf->execute([1]);
			$geneinfoarrfull = $geneinfostmtf->fetchAll();
			if (isset($_SESSION['username-post-data']) and ($_SESSION['redirect-expdesign'] == 1)) {
				$_POST['username'] = $_SESSION['username-post-data'];
				$_SESSION['redirect-expdesign'] = 0;
			}
	?>
			<form role="form" action="editexpdesign.php" method="post">
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
		
		} else { 
		
			?>
		<div class="well well-sm">
		Editing Exp Design
		</div>

		<?php
		}
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
		
		$drawer = 0;
		if ($todraw < $todraw2) {
			$drawer = $todraw2;
		} else {
			$drawer = $todraw;
		}
		$keycount = 0;
		for($counter = 0; $counter<$drawer; $counter++){
			$keycount = $keycount + 1;
			if ($geneinfoarr[$counter]['experiment'] == "") {
				$geneinfoarr[$counter]['experiment'] = $keycount;
			}		
		}
		$save_todraw2 = $todraw2
		
		?>
		<form role="form" action="saveexpdesign.php" method="post">
			<table class="table table-striped">
				<thead>
					<tr>
						<th> </th>
						<th colspan="3" style="border-left: 2px solid #ddd">Experiment</th>
						<th style="border-left: 2px solid #ddd">Control</th>
						<th style="border-left: 2px solid #ddd"> </th>
					</tr>
					<tr>
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
		
					for($count = 0; $count<$todraw; $count++){

					?>
					<tr>
						<td><?php echo $geneinfoarr[$count]["experiment"]; ?></td>

						<td style="border-left: 1px solid #ddd">
								<select name="exp-knockout-<?php echo $count+1;?>" />
								<option value="<?php echo $geneinfoarr[$count]['exp-knockout'] ?>" selected="selected"><?php echo '" '.$geneinfoarr[$count]['exp-knockout'].' "'  ?></option>
								<option value="dos2"><?php echo "dos2" ?></option>
								<option value="opi1"><?php echo "opi1" ?></option>
								<option value="hap3"><?php echo "hap3" ?></option>
								<option value="meh1"><?php echo "meh1" ?></option>
								<option value="gfd1"><?php echo "gfd1" ?></option>
								<option value="pex13"><?php echo "pex13" ?></option>
								<option value="par32"><?php echo "par32" ?></option>
								<option value="fyv6"><?php echo "fyv6" ?></option>
								<option value="csi1"><?php echo "csi1" ?></option>
								<option value="mgt1"><?php echo "mgt1" ?></option>
								<option value="isy1"><?php echo "isy1" ?></option>
								<option value="ino4"><?php echo "ino4" ?></option>
								<option value="ubc8"><?php echo "ubc8" ?></option>
								<option value="msc3"><?php echo "msc3" ?></option>
								<option value="elf1"><?php echo "elf1" ?></option>
								<option value="coa6"><?php echo "coa6" ?></option>
								<option value="bli1"><?php echo "bli1" ?></option>
								<option value="opy1"><?php echo "opy1" ?></option>
								<option value="yng1"><?php echo "yng1" ?></option>
								<option value="vps20"><?php echo "vps20" ?></option>
								<option value="igo1"><?php echo "igo1" ?></option>
								<option value="WT (BY4741)"><?php echo "WT (BY4741)" ?></option>
								<option value="tgl3::tgl4"><?php echo "tgl3::tgl4" ?></option>
						</td>
						<td>
								<select name="exp-plasmid-<?php echo $count+1;?>">
								<option value="<?php echo $geneinfoarr[$count]['exp-plasmid'] ?>" selected="selected"><?php echo '" '.$geneinfoarr[$count]['exp-plasmid'].' "'  ?></option>
								<option value="pDOS2-L"><?php echo "pDOS2-L" ?></option>
								<option value="pDOS2-H"><?php echo "pDOS2-H" ?></option>
								<option value="pOPI1-L"><?php echo "pOPI1-L" ?></option>
								<option value="pOPI1-H"><?php echo "pOPI1-H" ?></option>
								<option value="pHAP3-L"><?php echo "pHAP3-L" ?></option>
								<option value="pHAP3-H"><?php echo "pHAP3-H" ?></option>
								<option value="pMEH1-L"><?php echo "pMEH1-L" ?></option>
								<option value="pMEH1-H"><?php echo "pMEH1-H" ?></option>
								<option value="pGFD1-L"><?php echo "pGFD1-L" ?></option>
								<option value="pGFD1-H"><?php echo "pGFD1-H" ?></option>
								<option value="pPEX13-L"><?php echo "pPEX13-L" ?></option>
								<option value="pPEX13-H"><?php echo "pPEX13-H" ?></option>
								<option value="pPAR32-L"><?php echo "pPAR32-L" ?></option>
								<option value="pPAR32-H"><?php echo "pPAR32-H" ?></option>
								<option value="pFYV6-L"><?php echo "pFYV6-L" ?></option>
								<option value="pFYV6-H"><?php echo "pFYV6-H" ?></option>
								<option value="pCSI1-L"><?php echo "pCSI1-L" ?></option>
								<option value="pCSI1-H"><?php echo "pCSI1-H" ?></option>
								<option value="pMGT1-L"><?php echo "pMGT1-L" ?></option>
								<option value="pMGT1-H"><?php echo "pMGT1-H" ?></option>
								<option value="pISY1-L"><?php echo "pISY1-L" ?></option>
								<option value="pISY1-H"><?php echo "pISY1-H" ?></option>
								<option value="pINO4-L"><?php echo "pINO4-L" ?></option>
								<option value="pINO4-H"><?php echo "pINO4-H" ?></option>
								<option value="pUBC8-L"><?php echo "pUBC8-L" ?></option>
								<option value="pUBC8-H"><?php echo "pUBC8-H" ?></option>
								<option value="pMSC3-L"><?php echo "pMSC3-L" ?></option>
								<option value="pMSC3-H"><?php echo "pMSC3-H" ?></option>
								<option value="pELF1-L"><?php echo "pELF1-L" ?></option>
								<option value="pELF1-H"><?php echo "pELF1-H" ?></option>
								<option value="pCOA6-L"><?php echo "pCOA6-L" ?></option>
								<option value="pCOA6-H"><?php echo "pCOA6-H" ?></option>
								<option value="pBLI1-L"><?php echo "pBLI1-L" ?></option>
								<option value="pBLI1-H"><?php echo "pBLI1-H" ?></option>
								<option value="pOPY1-L"><?php echo "pOPY1-L" ?></option>
								<option value="pOPY1-H"><?php echo "pOPY1-H" ?></option>
								<option value="pYNG1-L"><?php echo "pYNG1-L" ?></option>
								<option value="pYNG1-H"><?php echo "pYNG1-H" ?></option>
								<option value="pVPS20-L"><?php echo "pVPS20-L" ?></option>
								<option value="pVPS20-H"><?php echo "pVPS20-H" ?></option>
								<option value="pIGO1-L"><?php echo "pIGO1-L" ?></option>
								<option value="pIGO1-H"><?php echo "pIGO1-H" ?></option>
								</select>
								
						<?php						
						if (explode('=',$geneinfoarr[$count]['comments'])[0] == '***') {  ?>
									<select name="exp-plasmid2-<?php echo $count+1;?>">
									<option value="<?php echo $geneinfoarr[$count]['exp-plasmid2'] ?>" selected="selected"><?php echo '" '.$geneinfoarr[$count]['exp-plasmid2'].' "'  ?></option>
									<option value=""><?php echo "Blank" ?></option>
									<option value="pDOS2-L"><?php echo "pDOS2-L" ?></option>
									<option value="pDOS2-H"><?php echo "pDOS2-H" ?></option>
									<option value="pOPI1-L"><?php echo "pOPI1-L" ?></option>
									<option value="pOPI1-H"><?php echo "pOPI1-H" ?></option>
									<option value="pHAP3-L"><?php echo "pHAP3-L" ?></option>
									<option value="pHAP3-H"><?php echo "pHAP3-H" ?></option>
									<option value="pMEH1-L"><?php echo "pMEH1-L" ?></option>
									<option value="pMEH1-H"><?php echo "pMEH1-H" ?></option>
									<option value="pGFD1-L"><?php echo "pGFD1-L" ?></option>
									<option value="pGFD1-H"><?php echo "pGFD1-H" ?></option>
									<option value="pPEX13-L"><?php echo "pPEX13-L" ?></option>
									<option value="pPEX13-H"><?php echo "pPEX13-H" ?></option>
									<option value="pPAR32-L"><?php echo "pPAR32-L" ?></option>
									<option value="pPAR32-H"><?php echo "pPAR32-H" ?></option>
									<option value="pFYV6-L"><?php echo "pFYV6-L" ?></option>
									<option value="pFYV6-H"><?php echo "pFYV6-H" ?></option>
									<option value="pCSI1-L"><?php echo "pCSI1-L" ?></option>
									<option value="pCSI1-H"><?php echo "pCSI1-H" ?></option>
									<option value="pMGT1-L"><?php echo "pMGT1-L" ?></option>
									<option value="pMGT1-H"><?php echo "pMGT1-H" ?></option>
									<option value="pISY1-L"><?php echo "pISY1-L" ?></option>
									<option value="pISY1-H"><?php echo "pISY1-H" ?></option>
									<option value="pINO4-L"><?php echo "pINO4-L" ?></option>
									<option value="pINO4-H"><?php echo "pINO4-H" ?></option>
									<option value="pUBC8-L"><?php echo "pUBC8-L" ?></option>
									<option value="pUBC8-H"><?php echo "pUBC8-H" ?></option>
									<option value="pMSC3-L"><?php echo "pMSC3-L" ?></option>
									<option value="pMSC3-H"><?php echo "pMSC3-H" ?></option>
									<option value="pELF1-L"><?php echo "pELF1-L" ?></option>
									<option value="pELF1-H"><?php echo "pELF1-H" ?></option>
									<option value="pCOA6-L"><?php echo "pCOA6-L" ?></option>
									<option value="pCOA6-H"><?php echo "pCOA6-H" ?></option>
									<option value="pBLI1-L"><?php echo "pBLI6-L" ?></option>
									<option value="pBLI1-H"><?php echo "pBLI6-H" ?></option>
									<option value="pOPY1-L"><?php echo "pOPY1-L" ?></option>
									<option value="pOPY1-H"><?php echo "pOPY1-H" ?></option>
									<option value="pYNG1-L"><?php echo "pYNG1-L" ?></option>
									<option value="pYNG1-H"><?php echo "pYNG1-H" ?></option>
									<option value="pVPS20-L"><?php echo "pVPS20-L" ?></option>
									<option value="pVPS20-H"><?php echo "pVPS20-H" ?></option>
									<option value="pIGO1-L"><?php echo "pIGO1-L" ?></option>
									<option value="pIGO1-H"><?php echo "pIGO1-H" ?></option>
									</select>
							<?php } else { ?>
							<input name="exp-plasmid2-<?php echo $count+1;?>" class="form-control" type="hidden" value="" />			
							<?php }?>									
						</td>
						<td style="border-left: 1px solid #ddd">
								<input name="exp-strain-<?php echo $count+1;?>" class="form-control" type="hidden" value="<?php echo $geneinfoarr[$count]['exp-knockout']." + ".$geneinfoarr[$count]['exp-plasmid'];?>" />			
						</td>
						
						<?php

						if ($todraw2 > 0) {
							$todraw2 = $todraw2 - 1; ?>			
							<td style="border-left: 1px solid #ddd">
								<select name="control-strain-<?php echo $count+1;?>" />
								<option value="<?php echo $geneinfoarr[$count]['control-strain'] ?>" selected="selected"><?php echo '" '.$geneinfoarr[$count]['control-strain'].' "'  ?></option>
								<option value="dos2-EmptyL"><?php echo "dos2-EmptyL" ?></option>
								<option value="dos2-EmptyH"><?php echo "dos2-EmptyH" ?></option>
								<option value="opi1-EmptyL"><?php echo "opi1-EmptyL" ?></option>
								<option value="opi1-EmptyH"><?php echo "opi1-EmptyH" ?></option>
								<option value="hap3-EmptyL"><?php echo "hap3-EmptyL" ?></option>
								<option value="hap3-EmptyH"><?php echo "hap3-EmptyH" ?></option>
								<option value="meh1-EmptyL"><?php echo "meh1-EmptyL" ?></option>
								<option value="meh1-EmptyH"><?php echo "meh1-EmptyH" ?></option>
								<option value="gfd1-EmptyL"><?php echo "gfd1-EmptyL" ?></option>
								<option value="gfd1-EmptyH"><?php echo "gfd1-EmptyH" ?></option>
								<option value="pex13-EmptyL"><?php echo "pex13-EmptyL" ?></option>
								<option value="pex13-EmptyH"><?php echo "pex13-EmptyH" ?></option>
								<option value="par32-EmptyL"><?php echo "par32-EmptyL" ?></option>
								<option value="par32-EmptyH"><?php echo "par32-EmptyH" ?></option>
								<option value="fyv6-EmptyL"><?php echo "fyv6-EmptyL" ?></option>
								<option value="fyv6-EmptyH"><?php echo "fyv6-EmptyH" ?></option>
								<option value="csi1-EmptyL"><?php echo "csi1-EmptyL" ?></option>
								<option value="csi1-EmptyH"><?php echo "csi1-EmptyH" ?></option>
								<option value="mgt1-EmptyL"><?php echo "mgt1-EmptyL" ?></option>
								<option value="mgt1-EmptyH"><?php echo "mgt1-EmptyH" ?></option>
								<option value="isy1-EmptyL"><?php echo "isy1-EmptyL" ?></option>
								<option value="isy1-EmptyH"><?php echo "isy1-EmptyH" ?></option>
								<option value="ino4-EmptyL"><?php echo "ino4-EmptyL" ?></option>
								<option value="ino4-EmptyH"><?php echo "ino4-EmptyH" ?></option>
								<option value="ubc8-EmptyL"><?php echo "ubc8-EmptyL" ?></option>
								<option value="ubc8-EmptyH"><?php echo "ubc8-EmptyH" ?></option>
								<option value="msc3-EmptyL"><?php echo "msc3-EmptyL" ?></option>
								<option value="msc3-EmptyH"><?php echo "msc3-EmptyH" ?></option>
								<option value="elf1-EmptyL"><?php echo "elf1-EmptyL" ?></option>
								<option value="elf1-EmptyH"><?php echo "elf1-EmptyH" ?></option>
								<option value="coa6-EmptyL"><?php echo "coa6-EmptyL" ?></option>
								<option value="coa6-EmptyH"><?php echo "coa6-EmptyH" ?></option>
								<option value="bli1-EmptyL"><?php echo "bli1-EmptyL" ?></option>
								<option value="bli1-EmptyH"><?php echo "bli1-EmptyH" ?></option>
								<option value="opy1-EmptyL"><?php echo "opy1-EmptyL" ?></option>
								<option value="opy1-EmptyH"><?php echo "opy1-EmptyH" ?></option>
								<option value="yng1-EmptyL"><?php echo "yng1-EmptyL" ?></option>
								<option value="yng1-EmptyH"><?php echo "yng1-EmptyH" ?></option>
								<option value="vps20-EmptyL"><?php echo "vps20-EmptyL" ?></option>
								<option value="vps20-EmptyH"><?php echo "vps20-EmptyH" ?></option>
								<option value="igo1-EmptyL"><?php echo "igo1-EmptyL" ?></option>
								<option value="igo1-EmptyH"><?php echo "igo1-EmptyH" ?></option>
								<option value="WT (BY4741)-EmptyL"><?php echo "WT (BY4741)-EmptyL" ?></option>
								<option value="WT (BY4741)-EmptyH"><?php echo "WT (BY4741)-EmptyH" ?></option>
								<option value="tgl3::tgl4-EmptyL"><?php echo "tgl3::tgl4-EmptyL" ?></option>
								<option value="tgl3::tgl4-EmptyH"><?php echo "tgl3::tgl4-EmptyH" ?></option>


							</td>

						<?php
						} 

						if ($count >= $save_todraw2) {
						?>
							<td></td>
						<?php
						}
						?>
						<td><textarea name="comments<?php echo $count+1;?>"><?php echo $geneinfoarr[$count]['comments'];?></textarea> </td>		

					</tr>
					
					<?php
					}
					while ($todraw2 > 0) { 

					?>
						<tr>
							<td style="border-left: 1px solid #ddd">
							</td>
							<td style="border-left: 1px solid #ddd">
							</td>
							<td style="border-left: 1px solid #ddd">
							</td>
							<td style="border-left: 1px solid #ddd">
							</td>		
							<td style="border-left: 1px solid #ddd">
							<select name="control-strain-<?php echo $count+1;?>" />
										<option value="<?php echo $geneinfoarr[$count]['control-strain'] ?>" selected="selected"><?php echo '" '.$geneinfoarr[$count]['control-strain'].' "'  ?></option>
										<option value="dos2-EmptyL"><?php echo "dos2-EmptyL" ?></option>
										<option value="dos2-EmptyH"><?php echo "dos2-EmptyH" ?></option>
										<option value="opi1-EmptyL"><?php echo "opi1-EmptyL" ?></option>
										<option value="opi1-EmptyH"><?php echo "opi1-EmptyH" ?></option>
										<option value="hap3-EmptyL"><?php echo "hap3-EmptyL" ?></option>
										<option value="hap3-EmptyH"><?php echo "hap3-EmptyH" ?></option>
										<option value="meh1-EmptyL"><?php echo "meh1-EmptyL" ?></option>
										<option value="meh1-EmptyH"><?php echo "meh1-EmptyH" ?></option>
										<option value="gfd1-EmptyL"><?php echo "gfd1-EmptyL" ?></option>
										<option value="gfd1-EmptyH"><?php echo "gfd1-EmptyH" ?></option>
										<option value="pex13-EmptyL"><?php echo "pex13-EmptyL" ?></option>
										<option value="pex13-EmptyH"><?php echo "pex13-EmptyH" ?></option>
										<option value="par32-EmptyL"><?php echo "par32-EmptyL" ?></option>
										<option value="par32-EmptyH"><?php echo "par32-EmptyH" ?></option>
										<option value="fyv6-EmptyL"><?php echo "fyv6-EmptyL" ?></option>
										<option value="fyv6-EmptyH"><?php echo "fyv6-EmptyH" ?></option>
										<option value="csi1-EmptyL"><?php echo "csi1-EmptyL" ?></option>
										<option value="csi1-EmptyH"><?php echo "csi1-EmptyH" ?></option>
										<option value="mgt1-EmptyL"><?php echo "mgt1-EmptyL" ?></option>
										<option value="mgt1-EmptyH"><?php echo "mgt1-EmptyH" ?></option>
										<option value="isy1-EmptyL"><?php echo "isy1-EmptyL" ?></option>
										<option value="isy1-EmptyH"><?php echo "isy1-EmptyH" ?></option>
										<option value="ino4-EmptyL"><?php echo "ino4-EmptyL" ?></option>
										<option value="ino4-EmptyH"><?php echo "ino4-EmptyH" ?></option>
										<option value="ubc8-EmptyL"><?php echo "ubc8-EmptyL" ?></option>
										<option value="ubc8-EmptyH"><?php echo "ubc8-EmptyH" ?></option>
										<option value="msc3-EmptyL"><?php echo "msc3-EmptyL" ?></option>
										<option value="msc3-EmptyH"><?php echo "msc3-EmptyH" ?></option>
										<option value="elf1-EmptyL"><?php echo "elf1-EmptyL" ?></option>
										<option value="elf1-EmptyH"><?php echo "elf1-EmptyH" ?></option>
										<option value="coa6-EmptyL"><?php echo "coa6-EmptyL" ?></option>
										<option value="coa6-EmptyH"><?php echo "coa6-EmptyH" ?></option>
										<option value="bli1-EmptyL"><?php echo "bli1-EmptyL" ?></option>
										<option value="bli1-EmptyH"><?php echo "bli1-EmptyH" ?></option>
										<option value="opy1-EmptyL"><?php echo "opy1-EmptyL" ?></option>
										<option value="opy1-EmptyH"><?php echo "opy1-EmptyH" ?></option>
										<option value="yng1-EmptyL"><?php echo "yng1-EmptyL" ?></option>
										<option value="yng1-EmptyH"><?php echo "yng1-EmptyH" ?></option>
										<option value="vps20-EmptyL"><?php echo "vps20-EmptyL" ?></option>
										<option value="vps20-EmptyH"><?php echo "vps20-EmptyH" ?></option>
										<option value="igo1-EmptyL"><?php echo "igo1-EmptyL" ?></option>
										<option value="igo1-EmptyH"><?php echo "igo1-EmptyH" ?></option>
										<option value="WT (BY4741)-EmptyL"><?php echo "WT (BY4741)-EmptyL" ?></option>
										<option value="WT (BY4741)-EmptyH"><?php echo "WT (BY4741)-EmptyH" ?></option>
										<option value="tgl3::tgl4-EmptyL"><?php echo "tgl3::tgl4-EmptyL" ?></option>
										<option value="tgl3::tgl4-EmptyH"><?php echo "tgl3::tgl4-EmptyH" ?></option>
									</td>
						
						<?php
						if ($todraw <= $save_todraw2) {						
						?>
						<td><textarea name="comments<?php echo $count+1;?>"><?php echo $geneinfoarr[$count]['comments'];?></textarea> </td>						
						<?php
						}
						?>
									
						</tr>
					<?php
						$todraw2 = $todraw2 - 1;
						$count = $count + 1;
					}
					?>
				</tbody>
			</table>

			<p style="color:red"> Warning: </p><p> Reducing Experiment/Control Size will permanently delete the entries removed from view! </p>
			<input type="hidden" name="count" value="<?php echo $count;?>"/>
			<input type="text" name="saver" value="<?php echo $_POST["saver"];?>"/>
			<button type="submit" name="updaterExp" value="updated" class="btn btn-primary">Update Number of Experiment Entries</button>
			<tr>
			<p>
			<input type="text" name="savey" value="<?php echo $_POST["savey"];?>"/>
			<input type="hidden" name="selectedUser" value="<?php echo $getUser;?>"/>
			<button type="submit" name="updaterEyp" value="updated" class="btn btn-primary">Update Number of Control Entries</button>
			</p>
			</tr>
			<p>
			<button type="submit" name="saverExp" value="saved" class="btn btn-primary">Save Design</button>
			</p>
		</form>
<?php
}
OJLogin::drawFooter();
?>
