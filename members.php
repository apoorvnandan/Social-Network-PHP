<?php
require_once "header/php";

if(isset($_GET['view']))
{
	echo "<div class='proflecontainer'>";
	echo "<div class='profiledescription'>";
	$view = cleanup($_GET['view']);
	if(file_exists())
	{
		echo "<img src='$view.jpg" class='profilepic'>";
	}
	echo "<span>$view</span>";
	echo "</div>";
	
}
?>