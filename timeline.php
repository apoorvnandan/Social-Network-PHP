<?php
require_once 'header.php';
$user = $_SESSION['user'];
$user_id = $_SESSION['user_id'];
echo "<div class='postcontainer'>";
echo "<div class='timelineform'>";
echo "<br>Welcome <strong>$user</strong>. Fill out the form below to create a profile for your dog:<br><br>";
$response = "";

if(isset($_POST['createprofile']))
{
	$name = cleanup($_POST['name']);
    $d_id = cleanup($_POST['d_id']);
	$interests = cleanup($_POST['interests']);
	$breed = cleanup($_POST['breed']);
    $dob = cleanup($_POST['dob']);
    $gender = cleanup($_POST['gender']);
	if($d_id =="" || $name  == "" || $breed == "" || $dob == "" || $gender == "")
	{
		$response = "Not all required fields were entered";
	}
	else
	{  
        $result = runthis("SELECT * FROM Owner_Has_Dog WHERE d_id = '$d_id'");
		if($result->num_rows)
		{
			$response = "Dog's user name already exists";
		} else {
            global $connection;
            $current_date = date("Y/m/d");
            $introduction = "<div>Hello my name is <b>".$name.
            "</b>.<br>
            My interests are: ".$interests.
            ".<br>
            I am a ".$gender." ".$breed.
            ", who was born on ".$dob.
            ".<br>
            My user name is <b>".$d_id.
            "</b>.
            Match with me! <br>
            </div>";
			runthis("INSERT INTO Owner_Has_Dog VALUES('$current_date',
                    '$d_id',
                    '$name', 
                    '$interests',
                    '$breed',
                    '$dob',
                    '$gender',
                    '$user_id')");
            runthis("INSERT INTO Dog_Has_Profile_Page  VALUES('$current_date',
            '$introduction',
            null, 
            null,
            '$d_id')");
			$response = "Your dog <b>". $name."</b>'s profile is created on " .$current_date." with username <b>".$d_id."</b> assigned.";
        }
		
	}
}

?>

<form method='post' action='timeline.php' enctype='multipart/form-data'>

<label>Dog's user name<span class="required"> *</span></label><br><br>
<input class='text_field' type='text' name='d_id' placeholder=''><br><br>

<label>Name<span class="required"> *</span></label><br><br>
<input class='text_field' type='text' name='name' placeholder=''><br><br>

<label>Interests</label><br><br>
<input class='text_field' type='text' name='interests' placeholder=''><br><br>
<label>Breed<span class="required"> *</span></label><br><br>
<input class='text_field' type='text' name='breed' placeholder=''><br><br>

<label>Date of birth<span class="required"> *</span></label><br><br>
<input class='text_field' type='date' name='dob' placeholder=''><br><br>

<label>Gender<span class="required"> *</span></label><br><br>
<select class='text_field' name='gender'>
  <option value="Female">Female</option>
  <option value="Male">Male</option>
</select>
<br><br>

<input type="hidden" name="createprofile" value="createprofile"> 
<input class='submitbutton' type='submit' value='Create Dog Profile'>
</form>

<div> <?php echo $response ?></div>
<br>Here are your dogs' profiles:<br><br>
<table id="dog_profiles">
<tr>
   <th>User name</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Breed</th>
    <th>Date of birth</th>
    <th>Profile</th>
</tr>
<?php
$result = runthis("SELECT * FROM Owner_Has_Dog WHERE user_id ='$user_id'");
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<tr>";
    $d_id= $row["d_id"];
    $name = $row["name"];
    $gender = $row["gender"];
    $breed = $row["breed"];
    $dob = $row["DOB"];
    echo "<td>".$d_id."</td>";
    echo "<td>".$name."</td>";
    echo "<td>".$gender."</td>";
    echo "<td>".$breed."</td>";
    echo "<td>".$dob."</td>";
    echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>".$name."'s Profile Page</a></td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>