<?php
// Enable error logging: 
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
// mysqli connection via user-defined function
include ('../my_connect.php');
$mysqli = get_mysqli_conn();
	
	//If there is a post request and there is Id of Task
	if (!empty($_POST) && ($_POST['id'])){
	
	$task_id  = $_POST['id'];
	$stmt2 = $mysqli-> prepare("INSERT INTO Applied_to_Task(task_id, employee_id) VALUES (?,10)");
	
	$stmt2->bind_param('i', $task_id); 
	
	//if query executed, get the ID of the inserted row
	if($stmt2->execute()) {
		echo "<div class='update_message'>Congratz! you've applied to Task $task_id!</div>";
	} else {
		echo "error";
	}
	
	$stmt2->free_result();	
		
	} 
	
	$id = $_GET['id'];
	$view = $_GET['view'];

	//2 Select all the information about the specific task
	$sql = "SELECT *"
	. "FROM Task "
	. "WHERE ID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $id); 
	$stmt->execute();

	// Bind result variables 
	$stmt->bind_result($t_id, $t_title, $t_description, $t_startdate, $t_enddate, $t_commitment, $location_id, $department_id, $status_id); 
	$stmt->fetch();	
	$stmt->free_result();
		
	$mysqli->close();
	
	?>

<!DOCTYPE html>
<head>
  <title>Tasktrader | Dashboard</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../static/main.css">
  <link href="https://fonts.googleapis.com/css?family=Muli:200,300,300i,400,600,600i,700,800,900" rel="stylesheet">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 </head>
 <body>
 <div class="wrapper">
	<?php
    require('nav.php');
	?>
  <section class="explore_page"> 
	  <div class="heading">
		<h2>Task ID: <?php echo "$t_id"; ?> </h2>
	  </div>
	  <div>
	 <!-- <div class="thumbnail row"> -->
	  <label class="control-label col-sm-2" for="task_title">Task Title:</label>
	  <h5><?php echo "$t_title"; ?> </h5>
	 <!-- </div> -->
	  <div class="thumbnail row">
	  <label class="control-label col-sm-2" for="task_title">Task Description:</label>
	  <p class="col-sm-10"><?php echo "$t_description"; ?> </p>
	  </div>
	  <div class="thumbnail row">
	  <label class="control-label col-sm-2" for="task_title">Start Date</label>
	  <p class="col-sm-4"><?php echo "$t_startdate"; ?> </p>
	  <label class="control-label col-sm-2" for="task_title">End Date</label>
	  <p class="col-sm-4"><?php echo "$t_enddate"; ?> </p>
	  </div>
	  <div class="thumbnail row">
	  <label class="control-label col-sm-2" for="task_title">Location</label>
	  <p class="col-sm-4"><?php echo "$location_id"; ?> </p>
	  <label class="control-label col-sm-2" for="task_title">Department</label>
	  <p class="col-sm-4"><?php echo "$department_id"; ?> </p>
	  </div>
	  <div class="thumbnail row">
	  <label class="control-label col-sm-2" for="task_title">Weekly Time Commitment</label>
	  <p class="col-sm-4"><?php echo "$t_commitment"; ?> hrs/week</p>
	  <label class="control-label col-sm-2" for="task_title">Status Id</label>
	  <p class="col-sm-4"><?php echo "$status_id"; ?> </p>
	  </div>
	  <?php 
	  
	  if ($view == "applied") {
		echo "<form action='applied.php' method='post'><input type='hidden' name='id' value='$t_id'><input type='submit' name='cancel' class='save_button' value='Cancel Application'></form>";
	  
	  } else {
		echo "<form action='taskresult.php?id=$id&view=applied' method='post'><input type='hidden' name='id' value='$t_id'><input type='submit' class='save_button' name='apply' value='Apply To Task'></form>";
	  }
	  ?>
	  </div>
  </section>
 </div>
 </body>
</html>