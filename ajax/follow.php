<?php 
require_once "../functions.php";
$user1 = $_POST['user1'];
$user2 = $_POST['user2'];
$isFollowing = $_POST['isFollowing'];

if($isFollowing == 1)
{
	runthis("DELETE FROM follower WHERE user1='$user1' AND user2='$user2'");
}
else
{
	runthis("INSERT INTO follower VALUES('$user1', '$user2')");
}
echo "OK";
?>