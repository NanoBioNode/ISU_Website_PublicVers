<?php
global $page;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yeast: Let's Mess it up!</title>
    <style>.error {color: #FF0000;} .jumbotron {margin-bottom: 0px}</style>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="jumbotron">
      <div class="container">
        <?php if(OJLogin::isLoggedIn()){?><div class="pull-right" style="margin-top:20px"><a class="btn" href="logout.php">Logout</a></div><?php }?>
        <h3>Yeast: Let's Mess it up!</h3>
      </div>
    </div>
    <div class="container">
      <?php if(OJLogin::isLoggedIn()){?>
      <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="<?php if($page=="pmrpage"){echo 'active';}?>"><a href="pmrpage.php">Preliminary<br>Data</a></li>
        <li class="<?php if($page=="geneinfo"){echo 'active';}?>"><a href="geneinfo.php">Genetic<br>Information</a></li>
        <li class="<?php if($page=="expdesign"){echo 'active';}?>"><a href="expdesign.php">Experimental<br>Design</a></li>
        <li class="<?php if($page=="expresults"){echo 'active';}?>"><a href="expresults.php">Transformation<br>Plate-Design</a></li>
        <li class="<?php if($page=="uploadpage"){echo 'active';}?>"><a href="uploadpage.php">Upload<br>CSV</a></li>
        <li class="<?php if($page=="uploadJPGpage"){echo 'active';}?>"><a href="uploadJPGpage.php">Upload<br>Image</a></li>
		<?php if(OJLogin::hasRole("Teacher")){ ?>
        <li class="<?php if($page=="TApage"){echo 'active';}?>"><a href="TApage.php">TA<br>Settings</a></li>
		<?php } ?>
      </ul>
      <?php } ?>
    </div>
  </body>
</html>
