<?php
require_once 'header.php';
$user = $_SESSION['user'];
$error = $msg = $msgreciever = "";
if(isset($_POST['msgreciever']))
{
	$msgreciever = $_POST['msgreciever'];
	$msg = $_POST['msg'];
	$msg = cleanup($msg);
	if($msgreciever == "" || $msg == "")
	{
		$error = "You forgot the message or its reciever.";
	}
	else
	{
		$checkuser = runthis("SELECT * FROM members WHERE user='$msgreciever'");
		if($checkuser->num_rows != 0)
		{
			runthis("INSERT INTO messages VALUES('$user', '$msgreciever', '$msg', 'date()')");
			$error = "Message sent.";
		}
		else
		{
			$error = "reciever does not exist.";
		}
	}
}
?>

<!-- <form method='post' action='messages.php'>
To: <input type='text' name='msgreciever'><br>
Message: <input type='text' name='msg'><br>
<input type='submit' value='Send'>
</form>
<br>
 -->
<div class='wrapper'>
<div class='chatnames'></div>
<div class='chatcontainer'></div>
</div>
<?php
// $result = runthis("SELECT * FROM messages WHERE reciever='$user' OR sender='$user'");

// $n = $result->num_rows;
// for($j = 0; $j < $n; $j = $j + 1)
// {
// 	$row = $result->fetch_array(MYSQLI_ASSOC);	 
// 	echo "<div class='msg'>" . $row['sender'] . ": " . $row['content'] . "<br><br></div>";
// }

?>

</body>
</html>