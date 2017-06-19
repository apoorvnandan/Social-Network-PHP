<?php
require_once 'functions.php';

if(isset($_SESSION['user']))
{
	session_destroy();
}
?>
<!DOCTYPE html>
<html>
<body>
You have been logged out. Click <a href='index.php'>here</a> to log back in.
</body>
</html>