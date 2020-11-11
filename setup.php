<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';
/*****DROP ALL CURRENT TABLES, PLEASE DO NOT DELETE********/
$result = runthis('SELECT CONCAT("DROP TABLE IF EXISTS `", table_schema, "`.`", table_name, "`cascade;")
  FROM   information_schema.tables
  WHERE  table_schema = "'.$dbname.'"');
while($row = $result->fetch_array(MYSQLI_NUM)) {
    runthis($row[0]);
}

echo 'tables dropped<br>';
/***END OF DROP TABLES***/
    
/****ADDING TABLES TO DATABASE, FEEL FREE TO CHANGE EXISTING AND INSERT MORE******/
runthis('CREATE TABLE members(user VARCHAR(16), pass VARCHAR(16))');
runthis('CREATE TABLE posts(author VARCHAR(16), content VARCHAR(256), upvotes INT, ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID))');

runthis('CREATE TABLE messages(sender VARCHAR(16), reciever VARCHAR(16), content VARCHAR(256), sendtime DATETIME)');

runthis("CREATE TABLE follower(user1 VARCHAR(16), user2 VARCHAR(16))");
/****INSERT MORE BELOW******/
    
/****DO NOT INSERT AFTER THIS******/    
echo 'tables created';
?>