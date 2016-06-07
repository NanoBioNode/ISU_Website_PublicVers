<h5>Log In</h5>
<?php
	$message = OJLogin::getMessage('login');
	unset($_SESSION['post-data']);
?>
<form role="form" <?php if($message)echo 'class="error" ';?>action="<?php echo $clearPath;?>login.php" method="post">
	<input type="text" name="username" placeholder="Username"/>
	<input type="password" name="password" placeholder="Password"/>
	<?php 
		if($message) 
			echo '<small>'.$message->message.'</small>'; 
	?>
	<input type="hidden" name="returnLoc" value="<?php echo $_SERVER['REQUEST_URI'];?>"/>
	<input type="submit" class="btn btn-primary" value="Log In"/>
	<p>Not a member? <a href="<?php echo $clearPath;?>registerform.php">Register now</a></p>
	<p>Forgot Username? <a href="<?php echo $clearPath;?>retrieveUserName.php">Retrieve username</a></p>
	<p>Reset Password? <a href="<?php echo $clearPath;?>resetPassword.php">Reset password</a></p>
</form>
<?php
	// Display message only once
	OJLogin::removeMessage('login');
?>