<?php
// Enable error logging: 
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
// mysqli connection via user-defined function
include('../my_connect.php');
$mysqli = get_mysqli_conn();

//1 CAPITALIZE EVERYTHING
if (!empty($_POST)){

$myString = $_POST['task_tags'];
$myArray = explode(',', strtoupper($myString));

//2 CHECK THAT SKILLS is in the skills Table
	$verifySkill_sql = "SELECT Count(*)"
	. "FROM Skill "
	. "WHERE skill_name = ?";
	$stmt = $mysqli->prepare($verifySkill_sql);

	//iterate through each keyword to check if they are in skill table
	foreach ($myArray as $value) {
		
		if ($stmt) { 	
			$stmt->bind_param('s', $value);	
			$stmt->execute();	
			$stmt->bind_result($result);

			//if we do not have skills, add it to the insertSkill array
			if($stmt->fetch()){
				if ($result < 1){
					$insertSkill[] = $value;
				}
			} else {
				printf("Errormessage: %s\n", $mysqli->error);
			}	
		}	
	}
	
	$stmt->free_result();	
	
	//Insert any Skills that aren't added
	$stmt2 = $mysqli->prepare("INSERT INTO Skill (skill_name) VALUES (?)");
	if ($stmt2){
		foreach ($insertSkill as $skill) {
			$stmt2->bind_param('s', $skill);				
			if(!$stmt2->execute()){
				echo "insert failed";
			} 
		}
	} else {
		echo "Insert failed !";
	}
	
	//close connection
	$stmt2->free_result();	

	
	//Insert Task into Tasks Table
	$stmt3 = $mysqli-> prepare("INSERT INTO Task(task_title, task_description, start_date, end_date, weekly_time_commitment, location_id, department_id, status_id) VALUES (?,?,?,?,?,?,?,1) ");
	
	$tname = $_POST['tname'];
	$tdescription = $_POST['tdescription'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$weekly_time_commitment = $_POST['tcommitment'];
	$location_id = $_POST['location'];
	$department_id = $_POST['department'];
	
	$stmt3->bind_param('ssssiii', $tname, $tdescription, $start_date, $end_date, $weekly_time_commitment, $location_id, $department_id); 
	
	//if query executed, get the ID of the inserted row
	if($stmt3->execute()) {
	
		$id = $mysqli->insert_id;
	} else {
		echo "error";
	}
	
	$stmt3->free_result();	
	
	//insert to Task_Skills table	
	$stmt4 = $mysqli->prepare("INSERT INTO Task_Skills(task_id, skill_id) SELECT ? , S.ID FROM Skill S WHERE S.skill_name = ? ");
	
	//if insert statment is true
	if ($stmt4){
		foreach ($myArray as $added) {
			$stmt4->bind_param('is', $id, $added);				
			if($stmt4->execute()){
					echo "<div class='update_message'>Task Sucessfully Created!</div>";
			} else {
				echo "insert failed<br>";
			}
				
		}
	
	} else {
		echo "Insert failed !";
	}
	
	//close connection
	$stmt4->free_result();
	$mysqli->close();
}
?>

<!DOCTYPE html>
<head>
  <title>Tasktrader | Profile</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../static/main.css">
  <link href="https://fonts.googleapis.com/css?family=Muli:200,300,300i,400,600,600i,700,800,900" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
 </head>
 <body>
 <div class="wrapper">
	<?php
    require('nav.php');
	?>
  <section class="explore_page">
  </section>
 </div>
 </body>
</html>
