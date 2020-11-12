<?php
require_once 'functions.php';

if(isset($_SESSION['user']))
{
	session_destroy();
}

$response = $user = $pass = $pass1 = ""; //$response = message user get when logged in

if(isset($_POST['signuser'])) //sign up, using POST method
{
	$user = cleanup($_POST['signuser']); //$user = username
	$pass = cleanup($_POST['signpass']); //$pass = password field
	$pass1 = cleanup($_POST['signrepass']);//$pass1 = re-entered password
	if($user == "" || $pass == "" || $pass1 == "")
	{
		$response = "Not all fields were entered";
	}
	else if ($pass != $pass1) 
	{
		$response = "Passwords do not match";
	}
	else
	{
		$result = runthis("SELECT * FROM members WHERE user = '$user'");
		if($result->num_rows)
		{
			$response = "Username already exists";
		}
		else
		{
			runthis("INSERT INTO members VALUES('$user', '$pass')");
			$response = "Account created. Please log in"	;
		}
	}
}

if(isset($_POST['loginuser'])) //login, using POST method
{
	$user = cleanup($_POST['loginuser']);
	$pass = cleanup($_POST['loginpass']);
	if($user == "" || $pass == "")
	{
		$response = "Not all fields were entered";
	}
	else
	{
		$result = runthis("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
		if($result->num_rows == 0)
		{
			$response = 'Username or password is wrong';
		}
		else
		{
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			header("Location: timeline.php");
		}
	}
}
?>


<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./icon/universedoge.jpg">
	
	<link rel="stylesheet" type="text/css", href="login.css">
	<title>Facebark</title>
</head>
<script src='js/jquery.min.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#loginform').hide();

    $('.message1').click(function(){ 
        $('#loginform').show(); 
		$('#signupform').hide(); 
    });
    $('.message2').click(function(){ 
        $('#signupform').show(); 
		$('#loginform').hide();
    });
});
</script>
<body>
<div class="container">
<h1>Welcome to Facebark!</h1>
<br><?php echo $response ?><br>
<div class="form">
<form id="loginform" method="post" action="index.php">
<input type="text" name="loginuser" placeholder="Username"><br>
<input type="password" name="loginpass" placeholder="Password"><br>
<input type="submit" value="Log In">
<div>
        Not registered?
        <a class="message2" href="#">Create an account</a>
</div>
</form>
<form id="signupform" method="post" action="index.php">
<input type="text" name="signuser" placeholder="Username"><br>
<input type="password" name="signpass" placeholder="Password"><br>
<input type="password" name="signrepass" placeholder="Confirm password"><br>
<input type="submit" value="Sign Up">
<div>      Already registered?
        <a class="message1" href="#">Log In</a>
</div>
</form>
</div>
</div>
</body>
</html>