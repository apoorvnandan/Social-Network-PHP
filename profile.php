<?php

require_once "header.php";
$d_id = null;
$profile_result = "";
$introduction = "";
$since = "";
$profile_id = null;

// Set profile page based on d_id
if(isset($_GET['d_id'])) 
{
	$d_id = $_GET['d_id'];
	$profile_result = runthis("SELECT * FROM Dog_Has_Profile_Page WHERE d_id='$d_id'");
    if($profile_result->num_rows == 0)
    {
        header("Location: timeline.php");
    }
    else
    {
            $row = $profile_result->fetch_array(MYSQLI_ASSOC);
            $introduction = $row['introduction'];
            $since = $row['since'];
            $profile_id = $row['profile_id'];
    }
	
}
else
{
	header("Location: timeline.php");
}

// Set Profile picture
if(isset($_FILES['profilepic']['name']) && $_FILES['profilepic']['name'] != "")
{
	$detectedType = exif_imagetype($_FILES['profilepic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	if(in_array($detectedType, $allowedTypes))
	{
		move_uploaded_file($_FILES['profilepic']['tmp_name'], "./profilepic/$d_id.jpg");
	}
} else {
    if(isset($_POST['deleteprofilepic']) && $_POST['deleteprofilepic'] == 'doit') {
        if(file_exists("./profilepic/$d_id.jpg"))
        {  
            unlink("./profilepic/$d_id.jpg");
        }
    }
    
}

// Set posts
if(isset($_FILES['gallerypic']['name']) && $_FILES['gallerypic']['tmp_name'] != '')
{
	$detectedType = exif_imagetype($_FILES['gallerypic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	if(in_array($detectedType, $allowedTypes))
	{
        $text = '';
        if(isset($_POST['caption'])) {
            $text = $_POST['caption'];
        }
        runthis("INSERT INTO Profile_Page_Contains_Post  VALUES(null,
        null,
        '$text', 
        0,
        '$profile_id')");
        $post_id = mysqli_insert_id($connection);
        $saveto = "pics/" . $post_id.".jpg";
		move_uploaded_file($_FILES['gallerypic']['tmp_name'], $saveto);

	}

}

echo "<div class='profilecontainer'>";
$date = new DateTime();
if(file_exists("./profilepic/$d_id.jpg"))
{   
	echo "<img class='profilepic' src='./profilepic/$d_id.jpg?".$date->getTimestamp()."'><br>";
} else {
    echo "<img class='profilepic' src='./profilepic/default.jpg'><br>";
}
echo "<form method='post' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'>
    <img id='changepicbutton' class='profilepicbutton' src='./img/camera.png'>
    <img id='droppicbutton' class='profilepicbutton' src='./img/x.png'>
    
    <input id='deleteprofilepic' type='text' name='deleteprofilepic' value='' style='display:none;'>
    <input id='inputprofilepic' type='file' name='profilepic' style='display:none;'>
	<input id='submitprofilepic' type='submit' style='display:none;' value='Save'>
</form>";
echo $introduction;
echo " <hr><br>
 <br>
 <div id='postdiv'>
<form method='post' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'>
	Add a picture: <input type='file' name='gallerypic' size='14'>
    <br>
    <br>
    <input class='text_field' type='text' name='caption' placeholder='Write your caption here...'><br><br>
	<input type='submit' value='POST'>
</form></div>";
echo "<br>";
echo "<br>";
echo "<div style='width: 400px; margin: 0px auto; text-align: left;'>My posts: </div>";
// Display posts
$posts_result = runthis("SELECT * FROM Profile_Page_Contains_Post WHERE profile_id='$profile_id'");
if($posts_result->num_rows == 0)
{
    echo"<div style='color:gray;'>Your profile has no post. Add some!</div>";
}
while($row = $posts_result->fetch_array(MYSQLI_ASSOC)) {
    $date = new DateTime();
    echo "<div class='post'>";
    $post_id= $row["post_id"];
    $caption = $row["text"];
    $num_likes = $row["num_likes"];
    echo "<img class='postpic' src='./pics/$post_id.jpg?".$date->getTimestamp()."'><br><br>";
    echo "<div style='width: 400px; margin: 0px 10px; text-align: left;'>";
    echo "<i id='like_button' class='fa fa-paw' aria-hidden='true'></i>";
    echo "<div>".$num_likes." likes </div><br>Caption: ".$caption. "</div>";
    echo "</div>";
}
echo "</div><br><br>";
echo "<div style='position:relative; height:100%;'><div id='footer'>Profile created since ".$since."</div></div>";
?>
</body>
<script>
$("#changepicbutton").click(function () {
    $("#inputprofilepic").click();
});
    
$("#droppicbutton").click(function () {
    $("#deleteprofilepic").val("doit");
    $("#submitprofilepic").click();
});
    
$('#inputprofilepic').on("change", function(){  $("#submitprofilepic").click(); });

</script>
</html>
