<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';
$tables = array ("Owner", "Owner_Has_Dog", "Dog_Has_Profile_Page", "Dog_Has_Personal_Note",
                "Matches", "Profile_Page_Contains_Post", "Post_Contains_Comment",
                "Group_Types","Owner_Manages_Group", "Premium_User", "Premium_Swags","Premium_Profile_Page", "Dog_Joins_Group",
                "Dog_Has_Highlights");
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
    user_id       INT                      PRIMARY KEY  AUTO_INCREMENT,
    user_name    VARCHAR(20)              NOT NULL        UNIQUE,
    password    VARCHAR(32)       NOT NULL
)
');
runthis('CREATE TABLE Owner_Has_Dog (
    since        DATE,
    d_id        VARCHAR(20)            PRIMARY KEY,
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
 runthis('CREATE TABLE Dog_Has_Profile_Page (
   since           DATE,
   introduction    TINYTEXT,
   profile_pics    BLOB,
   profile_id      INT           PRIMARY KEY AUTO_INCREMENT,
   d_id            VARCHAR(20)           NOT NULL,
   FOREIGN KEY(d_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE
 )
 ');

 runthis('CREATE TABLE Dog_Has_Personal_Note (
   d_id            VARCHAR(20)         NOT NULL,
   since           DATE        NOT NULL,
   sender_id       VARCHAR(20)         NOT NULL,
   content         VARCHAR(250)        NOT NULL,
   note_id         INT         PRIMARY KEY AUTO_INCREMENT,
   FOREIGN KEY(d_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE,
   FOREIGN KEY(sender_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE
 )
 ');

 runthis('CREATE TABLE Matches (
   d1_id       VARCHAR(20),
   d2_id       VARCHAR(20),
   start_date  DATE,
   PRIMARY KEY (d1_id, d2_id),
   FOREIGN KEY (d1_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE,
   FOREIGN KEY (d2_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE
 )
 ');

 runthis('CREATE TABLE Profile_Page_Contains_Post (
   post_id             INT       PRIMARY KEY AUTO_INCREMENT,
   image               BLOB,
   text                TINYTEXT,
   num_likes           INT,
   profile_id          INT       NOT NULL,
   FOREIGN KEY(profile_id) REFERENCES Dog_Has_Profile_Page(profile_id)
       ON DELETE CASCADE
 )
 ');

 runthis('CREATE TABLE Post_Contains_Comment (
   time_stamp        TIMESTAMP,
   poster_id         VARCHAR(20),
   text              TINYTEXT      NOT NULL,
   num_likes         INT,
   since             DATE,
   post_id           INT           NOT NULL,
   PRIMARY KEY(time_stamp, poster_id, post_id),
   FOREIGN KEY(post_id) REFERENCES Profile_Page_Contains_Post(post_id)
       ON DELETE CASCADE,
   FOREIGN KEY(poster_id) REFERENCES Owner_Has_Dog(d_id) 
       ON DELETE CASCADE
 )
 ');

runthis('CREATE TABLE Group_Types (
  group_type_id       INT             PRIMARY KEY AUTO_INCREMENT,
  group_type          VARCHAR(20)     NOT NULL
)
');

  runthis('CREATE TABLE Owner_Manages_Group (
    since                DATE,
    group_id             INT          PRIMARY KEY AUTO_INCREMENT,
    group_name          VARCHAR(30)   NOT NULL,
    group_description   TINYTEXT,
    num_members         INT,
    user_id             INT      NOT NULL,
    group_type_id       INT      NOT NULL,
    FOREIGN KEY (group_type_id) REFERENCES Group_Types(group_type_id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Owner(user_id)
        ON DELETE CASCADE
  )
  ');

 runthis('CREATE TABLE Premium_User (
   user_id         INT       PRIMARY KEY AUTO_INCREMENT,
   payment_info     VARCHAR(30)       NOT NULL,
   FOREIGN KEY(user_id) REFERENCES Owner(user_id)
      ON DELETE CASCADE
 )
 ');

  runthis('CREATE TABLE Dog_Joins_Group (
    d_id            VARCHAR(20),
    group_id        INT,
    since           DATE,
    PRIMARY KEY(d_id,group_id),
    FOREIGN KEY(group_id) REFERENCES Owner_Manages_Group(group_id)
        ON DELETE CASCADE,
    FOREIGN KEY (d_id) REFERENCES Owner_Has_Dog(d_id)
        ON DELETE CASCADE
  )
  ');

 runthis('CREATE TABLE Dog_Has_Highlights (
   highlight_id        INT           PRIMARY KEY AUTO_INCREMENT,
   image               BLOB          NOT NULL,
   start_time          TIMESTAMP     NOT NULL,
   numViews            INT,
   d_id                VARCHAR(20)           NOT NULL,
   FOREIGN KEY(d_id) REFERENCES Owner_Has_Dog(d_id)
       ON DELETE CASCADE
 )
 ');

 runthis('CREATE TABLE Premium_Swags (
  premium_swag_id       INT       PRIMARY KEY AUTO_INCREMENT,
  premium_swag_type     VARCHAR(20),
  premium_swag_content  BLOB
)
');

 runthis('CREATE TABLE Premium_Profile_Page (
   profile_id            INT         PRIMARY KEY AUTO_INCREMENT,
   premium_swag_id       INT         NOT NULL,
   FOREIGN KEY(profile_id) REFERENCES Dog_Has_Profile_Page(profile_id)
       ON DELETE CASCADE,
    FOREIGN KEY(premium_swag_id) REFERENCES Premium_Swags(premium_swag_id)
       ON DELETE CASCADE
 )
 ');

// /****CREATE TABLE MORE BELOW******/

    
// /****DO NOT CREATE TABLE AFTER THIS******/    
echo 'tables created';
echo '<br>';
/*****INSERT STATEMENTS***************/
for ($insert_id = 0; $insert_id < count($tables); $insert_id++) {
    $filename = './data/'.$tables[$insert_id].".csv";
    loadData($filename,$tables[$insert_id]);
    echo $tables[$insert_id]." loaded";
    echo "<br>";
}
echo 'data inserted';
?>