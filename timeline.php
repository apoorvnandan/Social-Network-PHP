<?php
require_once 'header.php';
$user = $_SESSION['user'];
$user_id = $_SESSION['user_id'];
echo "<div class='postcontainer'>";
echo "<div class='timelineform'>";
echo "<div style='display:inline;'><br>Welcome <strong>$user</strong>. Fill out the form below to create a profile for your dog:<br><br></div>";
$response = "";

if(isset($_POST['createprofile']))
{
	$name = cleanup($_POST['name']);
	$interests = cleanup($_POST['interests']);
	$breed = cleanup($_POST['breed']);
    $dob = cleanup($_POST['dob']);
    $gender = cleanup($_POST['gender']);
	if($name  == "" || $breed == "" || $dob == "" || $gender == "")
	{
		$response = "Not all required fields were entered";
	}
	else
	{
            $current_date = date("Y/m/d");
			runthis("INSERT INTO Owner_Has_Dog VALUES('$current_date',
                    null,
                    '$name', 
                    '$interests',
                    '$breed',
                    '$dob',
                    '$gender',
                    '$user_id')");
			$response = "Your dog <b>". $name."</b>'s profile is created on " .$current_date;
		
	}
}

?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="timeline.css">
<script src='js/jquery.min.js'></script>
<script type="text/javascript">
	$(document).ready(function() {
	$('.welcome-message').hide();
});
</script>
<body>
<form method='post' action='timeline.php' enctype='multipart/form-data'>

<div class='set'>
    <div >
    <label>Name<span class="required"> *</span></label>
    <input class='text_field' type='text' name='name' placeholder=''>
    </div>
    <div >
    <label>Breed<span class="required"> *</span></label>  
    <input class='text_field' type='text' name='breed' placeholder=''>
    </div>
</div>
<div class='set'>
    <div >
    <label>Date of birth<span class="required"> *</span></label>
    <input class='text_field' type='date' name='dob' placeholder=''>
</div>
<div>
    <label>Gender<span class="required"> *</span></label>
<select class='text_field' name='gender'>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
  <option value="Other" selected="selected">Other</option>
</select>
</div>
</div>
<div class='set'>
    <div>
    <label>Interests</label>
    <input class='text_field' type='text' name='interests' placeholder=''>  
</div>  
</div>
<br><br>
<input type="hidden" name="createprofile" value="createprofile"> 
<input class='submitbutton' type='submit' value='Create Dog Profile'>
</form>

<div> <?php echo $response ?></div>
<br>Here are your dogs' profiles:<br><br>
<table id="dog_profiles">
<tr>
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