<?php
require_once 'functions.php';

if(isset($_SESSION['user']))
{
	session_destroy();
}

$response = $user = $pass = $pass1 = "";

if(isset($_POST['signuser']))
{
	$user = cleanup($_POST['signuser']);
	$pass = cleanup($_POST['signpass']);
	$pass1 = cleanup($_POST['signrepass']);
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

if(isset($_POST['loginuser']))
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
    <title>Facebark</title>
</head>
<body>
<div>Welcome to Facebark!</div>
<br><?php echo $response ?><br>
<br>Login<br>
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