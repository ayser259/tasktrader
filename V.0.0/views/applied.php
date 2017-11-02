<?php 
include ('../my_connect.php');
$mysqli = get_mysqli_conn();

//If there is a post request
if (!empty($_POST)){

	//prepare query for deleting application
	$id = $_POST['id'];
	$delete_sql = "DELETE "
				. "FROM Applied_to_Task "
				. "WHERE employee_id = 10 AND task_id = ?";
	
	$delete_stmt = $mysqli->prepare($delete_sql);
	$delete_stmt->bind_param('i', $id);	
	
	//if query executed, return a success message
	if($delete_stmt->execute()){
		echo "<div class='update_message'>Application for Task $id has been deleted.</div>";
	}
	
	//free result
	$delete_stmt->free_result();
}

//If it's just a get request, show all applied tasks
$sql = "SELECT T.ID,`task_title`, `start_date`, L.campus_name , `status_id`\n"
    . "FROM `Task` AS T \n"
    . "INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id\n"
    . "INNER JOIN `Location` AS L ON T.location_id = L.ID\n"
    . "WHERE A.employee_id = 10";
			
		// Prepared statement, stage 1: prepare
		$stmt = $mysqli->prepare($sql);
		
		// Prepared statement, stage 2: execute
		$stmt->execute();
		
		// Bind result variables 
		$stmt->bind_result($id, $task_title, $start_date, $location, $status_id); 
		
		/* fetch values */ 
		while ($stmt->fetch()) {
			$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id&view=applied'>$task_title</a></td><td>$start_date</td><td>$location</td><td>$status_id</td><td><form action='applied.php' method='post'><input type='hidden' name ='id' value='$id'><button type='submit'>cancel</button></form></td></tr>";
		}

		/* close statement and connection*/ 
		$stmt->close(); 
		$mysqli->close();
?>

<!DOCTYPE html>
<head>
  <title>Tasktrader | Applied To</title>
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
  <script src="../static/tasktrader.js"></script>
 </head>
 <body>
 <div class="wrapper">
	<?php
    require('nav.php');
	?>
  <section class="explore_page"> 
	  <div class="heading">
		<h2>Applied To</h2>
	  </div>
	  <div class="search_wrapper">
	  </div>
	  <div>	
	  <!--applied_to table -->
	  <table class="table table-striped">
	  <thead>
      <tr>
        <th>Title</th>
        <th>Deadline</th>
		<th>Location</th>
		<th>Status</th>
		<th>Action</th>
		</tr>
    </thead>
    <tbody>
	<?php echo $message; ?> 
    </tbody>
  </table>
	  </div>
  </section>
 </div>
 </body>
 </html>