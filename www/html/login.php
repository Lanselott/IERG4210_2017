<?php
include_once('lib/csrf.php');
include_once('lib/auth.php');

if ($_SESSION['authtoken']){
	//header('Refresh:1; admin.php');
	//echo '<b>You are already logined</b> <br>Redirecting you to admin page in 1 second...';
	header('Location: admin_panel.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login Here</title>
</head>
<body>
<h1>Login Here</h1>
<fieldset>
	<legend>Login</legend>
	<form id="loginForm" method="POST" action="auth-process.php?action=<?php echo ($action = 'login'); ?>">
		<label for="email">Email:</label>
		<div>
		<input type="text" name="email" required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
		</div>
		<label for="pw">Password:</label>
		<div>
		<input type="password" name="pw" required="true" pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" />
		</div>
		<input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
		<input type="submit" value="Login" />
	</form>
	<a href="Main.php">I just want have a look :)</a>
	<a href="reset_pass.html"> = = Shit, i forgot the password = =</a>
</fieldset>
</body>
</html>
