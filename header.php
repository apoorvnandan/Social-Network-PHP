<?php
require_once 'functions.php';

if(!isset($_SESSION['user']))
{
	//header("Location: index.php"); //commented our for testing
}
?>

<!DOCTYPE html>
		<html>
		<head>
            <link rel="icon" href="./icon/universedoge.jpg">
			<link rel="stylesheet" type="text/css" href="header-style.css">
		</head>	
		<body>
		<div class="topbar">
		<img id="logo" src="./pics/doggo.png" alt="dog">
		<h1>Facebark</h1>
		<ul class='toolbar'>
			<div class='toolbar-li'>
			<li>
				<a href='timeline.php'><img src="./pics/house.png" style="width:50px;height:50px;"/> 
				<span>Home</span>
				</a>
			</li>
			<li>
				<a href='index.php'><img src="./pics/paw.png" style="width:50px;height:50px;"/> 
				<span>Log Out</span>
				</a>
			</li>
</div>
</div>
<script src='js/jquery.min.js'></script>