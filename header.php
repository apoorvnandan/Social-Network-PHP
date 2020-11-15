<?php
require_once 'functions.php';

if(isset($_SESSION['user']))
{
	echo <<<_END
		<!DOCTYPE html>
		<html>
		<head>
            <link rel="icon" href="./icon/universedoge.jpg">
			<link rel="stylesheet" type="text/css" href="style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <title>Facebark</title>
		</head>	
		<body>
		<ul class='topbar'>
			<li><a href='timeline.php'>Home</a></li>
			<li><a href='index.php'>Log Out</a></li>
		</ul>
_END;
}
else
{
	header("Location: index.php");
}

?>
<script src='js/jquery.min.js'></script>