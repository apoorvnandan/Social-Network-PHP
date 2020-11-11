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
		$result = runthis("SELECT * FROM Owner WHERE user_name = '$user'");
		if($result->num_rows)
		{
			$response = "Username already exists";
		}
		else
		{
			runthis("INSERT INTO Owner VALUES(null,'$user', '$pass')");
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
		$result = runthis("SELECT * FROM Owner WHERE user_name='$user' AND password='$pass'");
		if($result->num_rows == 0)
		{
			$response = 'Username or password is wrong';
		}
		else
		{
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user'] = $row['user_name'];
			    $_SESSION['pass'] = $row['password'];
            }
			
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