<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';

runthis('CREATE TABLE members(user VARCHAR(16), pass VARCHAR(16))');
runthis('CREATE TABLE posts(author VARCHAR(16), content VARCHAR(256), upvotes INT, ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID))');

runthis('CREATE TABLE messages(sender VARCHAR(16), reciever VARCHAR(16), content VARCHAR(256), sendtime DATETIME)');

runthis("CREATE TABLE follower(user1 VARCHAR(16), user2 VARCHAR(16))");

echo 'tables created';

?>