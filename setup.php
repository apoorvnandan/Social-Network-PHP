<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';
/*****DROP ALL CURRENT TABLES, PLEASE DO NOT DELETE********/
runthis('SET FOREIGN_KEY_CHECKS = 0');
$result = runthis('SELECT CONCAT("DROP TABLE IF EXISTS `", table_schema, "`.`", table_name, "`;")
  FROM   information_schema.tables
  WHERE  table_schema = "'.$dbname.'"');
while($row = $result->fetch_array(MYSQLI_NUM)) {
    runthis($row[0]);
}
runthis('SET FOREIGN_KEY_CHECKS = 1');
echo 'tables dropped<br>';
/***END OF DROP TABLES***/
    
/****ADDING TABLES TO DATABASE, FEEL FREE TO INSERT MORE******/
runthis('CREATE TABLE Owner (
    user_id    INT                      PRIMARY KEY  AUTO_INCREMENT,
    user_name    VARCHAR(20)              NOT NULL        UNIQUE,
    password    VARCHAR(32)       NOT NULL
)
');
runthis('CREATE TABLE Owner_Has_Dog (
    since        DATE,
    d_id        INT            PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(20)    NOT NULL,
    interest    VARCHAR(32),
    breed        VARCHAR(11)        NOT NULL,
    DOB        DATE            NOT NULL,
    gender        VARCHAR(11)        NOT NULL,
    user_id     INT                      NOT NULL,
            FOREIGN KEY (user_id) REFERENCES Owner (user_id)
                 ON DELETE CASCADE
)
');
/****INSERT MORE BELOW******/
    
/****DO NOT INSERT AFTER THIS******/    
echo 'tables created';
?>