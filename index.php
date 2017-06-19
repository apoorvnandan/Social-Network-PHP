<?php
require_once 'functions.php';

// if(isset($_SESSION['user']))
// {
// 	die("You are logged in as " + $_SESSION['user'] + ". <a href='timeline.php'>Click here</a> to continue.");
// }

$error = $user = $pass = $pass1 = "";

if(isset($_POST['signuser']))
{
	$user = cleanup($_POST['signuser']);
	$pass = cleanup($_POST['signpass']);
	$pass1 = cleanup($_POST['signrepass']);
	if($user == "" || $pass == "" || $pass1 == "")
	{
		$error = "Not all fields were entered<br>";
	}
	else if ($pass != $pass1) 
	{
		$error = "passwords do not match<br>";
	}
	else
	{
		$result = runthis("SELECT * FROM members WHERE user = '$user'");
		if($result->num_rows)
		{
			$error = "username already exists";
		}
		else
		{
			runthis("INSERT INTO members VALUES('$user', '$pass')");
			die("Account created. Please <a href='index.php'>Log In</a>")	;
		}
	}
}

if(isset($_POST['loginuser']))
{
	$user = cleanup($_POST['loginuser']);
	$pass = cleanup($_POST['loginpass']);
	if($user == "" || $pass == "")
	{
		$error = "Not all fields were entered<br>";
	}
	else
	{
		$result = runthis("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
		if($result->num_rows == 0)
		{
			$error = 'username or password is wrong';
		}
		else
		{
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			die("You are now logged in. Please <a href='timeline.php'>click here</a> to continue.")	;
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP App</title>
</head>
<body>
Welcome to this website!<br>
Login<br>
<form method="post" action="index.php">
username: <input type="text" name="loginuser"><br>
password: <input type="password" name="loginpass"><br>
<input type="submit" value="Log In">
</form>

<br>
Sign Up<br>
<form method="post" action="index.php">
username: <input type="text" name="signuser"><br>
password: <input type="password" name="signpass"><br>
retype password: <input type="password" name="signrepass"><br>
<input type="submit" value="Sign Up">
</form>

</body>
</html>