<?php
require_once 'functions.php';
if(isset($_SESSION['user'])){
	$user = $_SESSION['user'];
}
else{
	//header("Location: index.php"); //commented our for testing
}
?>

<!DOCTYPE html>
		<html>
		<head>
            <link rel="icon" href="./icon/universedoge.jpg">
			<link rel="stylesheet" type="text/css" href="header.css">
			<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		</head>	
		<body>
		<div class="topbar">
		<img id="logo" src="./pics/doggo.png" alt="dog">
		<h1>Facebark</h1>
		<ul class='toolbar'>
			<div class='toolbar-li'>
			<li>
				<a href='timeline.php'><i class="material-icons">home</i>
				<span>Home</span>
				</a>
			</li>
			<li>
			<a href='index.php'><i class="material-icons">pets</i>
				<span>Log Out</span>
				</a>
			</li>
</div>
</div>
<div class="welcome-message fade-in centered">
<h1>Welcome back <?php echo $user?></h1>
</div>
</body>
</html>
<script src='js/jquery.min.js'></script>