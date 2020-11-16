<?php
require_once 'header.php';
$user = $_SESSION['user'];
$msg =
$msgreciever = ""; 

if(isset($_POST['msgreciever']))
{
	$msgreciever = $_POST['msgreciever'];
	$msg = $_POST['msg'];
	$msg = cleanup($msg);
	if($msgreciever == "" || $msg == "")
	{
<<<<<<< HEAD
		$error = "You forgot the message or its reciever.";
	}
	else
	{
		$checkuser = runthis("SELECT * FROM members WHERE user='$msgreciever'");
		if($checkuser->num_rows != 0)
		{
			runthis("INSERT INTO messages VALUES('$user', '$msgreciever', '$msg', 'date()')");
			$error = "Message sent.";
=======
		echo "The reciever box cannot be empty";
	}
	 else if ($msg == "")
	{
		 echo "The message box cannot be empty";
	}
	else
	{
		$checkuser = runthis("SELECT * FROM Owner_Has_Dog WHERE d_id='$msgreciever'");
		if($checkuser->num_rows != 0)
		{
			$today = date("Y-m-d");
			runthis("INSERT INTO Dog_Has_Personal_Note VALUES('$msgreciever', '$today', '$user' , '$msg', DEFAULT)");
			echo "Message sent!";
>>>>>>> 8445209... updated messages + added content to notes table
		}
		else
		{
			echo "Dog $msgreciever does not exist";
		}
	}
}
?>

 <form method='post' action='messages.php'>
To: <input type='text' name='msgreciever'><br>
Message: <input type='text' name='msg'><br>
<input type='submit' value='Send'>
</form>
<br>
 
<div class='wrapper'>
<div class='chatnames'></div>
<div class='chatcontainer'></div>
</div>
<?php
<<<<<<< HEAD
 $result = runthis("SELECT * FROM messages WHERE reciever='$user' OR sender='$user'");

 $n = $result->num_rows;
 for($j = 0; $j < $n; $j = $j + 1)
 {
 	$row = $result->fetch_array(MYSQLI_ASSOC);	 
 	echo "<div class='msg'>" . $row['sender'] . ": " . $row['content'] . "<br><br></div>";
 }
=======
	 echo "Your Messages:<br><br></div>" ;

	  $result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE d_id='$user'");

      $n = $result->num_rows;
      for($j = 0; $j < $n; $j = $j + 1)
      {
      	$row = $result->fetch_array(MYSQLI_ASSOC);	 
      	echo "<div class='msg'>" . "From: " . $row['sender_id'] . "<br>" . " Message: " . $row['content'] . "<br><br></div>";
	  }
	  
	  echo "Sent Messages:<br><br></div>" ;

	  $result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE sender_id='$user'");

      $n = $result->num_rows;
      for($j = 0; $j < $n; $j = $j + 1)
      {
      	$row = $result->fetch_array(MYSQLI_ASSOC);	 
      	echo "<div class='msg'>" . "To: " . $row['d_id'] . "<br>" . " Message: " . $row['content'] . "<br><br></div>";
	  }

>>>>>>> 8445209... updated messages + added content to notes table

?>

</body>
</html>