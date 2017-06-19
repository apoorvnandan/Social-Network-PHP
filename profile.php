<?php

require_once "header.php";
$user = "";
$currentuser = "";
$otheruser = 0;
$isFollowing = 0;
if(isset($_GET['view'])) 
{
	$user = $_GET['view'];
	$currentuser = $_SESSION['user'];
	$otheruser = 1;
	$followstatus = runthis("SELECT * FROM follower WHERE user1='$currentuser' AND user2='$user'");
	if($followstatus->num_rows == 0) 
	{
		$isFollowing = 0;
	}
	else 
	{
		$isFollowing = 1;
	}
	
}
else
{
	$user = $_SESSION['user'];
	$otheruser = 0;
}
echo "<div class='profilecontainer'>";
echo "<div class='profiledescription'>";
if(file_exists("$user.jpg"))
{
	echo "<img class='profilepic' src='$user.jpg'>";
}
echo "<span>$user";
if($otheruser == 1)
{
	if($isFollowing == 0)
	{
		echo " <button id='followbutton' class='submitbutton' onclick='follow()'>Follow</button>";
	}
	else
	{
		echo " <button id='followbutton' class='submitbutton' onclick='follow()'>Unfollow</button>";
	}
}
echo "</span></div>";

if(isset($_FILES['profilepic']['name']))
{
	$detectedType = exif_imagetype($_FILES['profilepic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	if(in_array($detectedType, $allowedTypes))
	{
		move_uploaded_file($_FILES['profilepic']['tmp_name'], "$user.jpg");
	}
}

if(isset($_FILES['gallerypic']['name']))
{
	$detectedType = exif_imagetype($_FILES['gallerypic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	$result = runthis("SELECT * FROM photos WHERE user='$user'");
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$count = $row['count'];
	$count = $count + 1;
	$saveto = "pics/" . $user . "pic" . $count . ".jpg";
	if(in_array($detectedType, $allowedTypes))
	{
		move_uploaded_file($_FILES['gallerypic']['tmp_name'], $saveto);
		runthis("UPDATE photos SET count='$count' WHERE user = '$user'");
	}

}

?>
<!-- 
<form method='post' action='profile.php' enctype='multipart/form-data'>
	Profile picture: <input type='file' name='profilepic' size='14'><br>
	<input type='submit' value='Save'>
</form>
<form method='post' action='profile.php' enctype='multipart/form-data'>
	Add a picture: <input type='file' name='gallerypic' size='14'><br>
	<input type='submit' value="Save">
</form>
 -->


<?php

	$result = runthis("SELECT * FROM photos WHERE user='$user'");
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$num = $row['count'];
	for($j = 1; $j <= $num; $j = $j + 1)
	{
		$addr = "pics/" . $user . "pic" . $j . ".jpg";
		if($j % 3 != 0)
			echo "<img class='gridpic' src='$addr'>";
		else
			echo "<img class='gridpiclast' src='$addr'>";
	}

?>
</div>
</body>
<script>
let buttonUsed = 0;
function follow()
{
	buttonUsed = 1 - buttonUsed;
	let user1 = "<?php echo $currentuser ?>";
	let user2 = "<?php echo $user ?>";
	let isFollowing = <?php echo $isFollowing ?>;

	console.log(isFollowing);
	$.ajax({
		url: "ajax/follow.php",
		type: "post",
		data: {'user1': user1, 'user2': user2, 'isFollowing': isFollowing},
		success: function(data, status) {
			console.log(data);
			if(data == "OK")
			{
				
				if(isFollowing == 0)
				{
					$('#followbutton').html('Unfollow');
				}
				else
				{
					$('#followbutton').html('Follow');
				}
				if(buttonUsed == 1)
				{
					isFollowing = (1 - isFollowing);
				}
			}

		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + " Error: " + err);
		}
	});	
}
</script>
</html>
