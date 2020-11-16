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
	if($msgreciever == "")
	{
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


?>

</body>
</html>