
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//code.highcharts.com/highcharts.js"></script>
<?php
include('OJLogin.php');
OJLogin::init();
$page="pmrpage";
OJLogin::drawHeader();
if(!OJLogin::isLoggedIn()){
	OJLogin::drawLoginForm();
} else {

	echo '<br></br><br></br>';	
		if ( file_exists("snippets/idimage.jpg") ) {

# display jpg
		$data64 = file_get_contents("snippets/idimage.jpg");

		echo '<td></td><img alt="My Image0" src="data:image/jpg;base64,'.base64_encode($data64).'" />';
		}

		if ( file_exists("snippets/pmr_image11.jpg") ) {

# display jpg
		$data64 = file_get_contents("snippets/pmr_image11.jpg");

		echo '<td></td><img alt="My Image" src="data:image/jpg;base64,'.base64_encode($data64).'" />';

		}
		if ( file_exists("snippets/pmr_image22.jpg") ) {

# display jpg
		$data64 = file_get_contents("snippets/pmr_image22.jpg");

		echo '<td></td><img alt="My Image2" src="data:image/jpg;base64,'.base64_encode($data64).'" />';
		
		}
		echo '<br></br><a href=" http://www.metnetdb.org/PMR/experiments/?expid=195">PMR Database Page</a><br></br>';
		echo 'PMR Login:    genetic<br></br>';
		echo 'PMR Password: genetic<br></br>';		
		
# display jpg
		if ( file_exists("snippets/pmr_image01.jpg") ) {
			$data64 = file_get_contents("snippets/pmr_image01.jpg");
			echo '<td></td><img alt="My Image01" src="data:image/jpg;base64,'.base64_encode($data64).'" />';
		}

		
}
OJLogin::drawFooter();
?>
