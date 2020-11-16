<?php
session_start();
$dbhost = 'localhost';
$dbname = 'chatappdb';
$dbuser = 'root';
$dbpass = '';
$appname= 'CHATAPP';

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($connection->connect_error) die($connection->connect_error);


function runthis($query)
{
	global $connection;
	$result = $connection->query($query);
	if(!$result) die($connection->error);
	return $result;
}

// to make sure the string is safe to use in mysql
function cleanup($var)
{
	global $connection;
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return $connection->real_escape_string($var);
}

/** source: Afsar - https://stackoverflow.com/questions/14659992/load-a-csv-file-into-mysql-via-php **/

function loadData($fileName, $table) {
$query = <<<eof
    LOAD DATA LOCAL INFILE '$fileName'
     INTO TABLE $table
     FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
     LINES TERMINATED BY '\r\n'
eof;
runthis ($query);         
}
?>