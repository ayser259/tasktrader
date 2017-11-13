<?php
// Enable error logging: 
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
// mysqli connection via user-defined function
include ('../my_connect.php');
$mysqli = get_mysqli_conn();

//if there is no POST request, GET the default information (ALL TASKS)
if (empty($_POST)){
		
	// SQL statement
	$sql = "SELECT DISTINCT T.ID,`task_title`, `start_date`, D.department_name, L.campus_name , `weekly_time_commitment` FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID \n"
    . "WHERE T.status_id = 1 \n"
    . "ORDER BY T.ID ASC "
	. "LIMIT 500";
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);
	
	// Prepared statement, stage 2: execute
	$stmt->execute();
	
	// Bind result variables 
	$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
	
	/* fetch values */ 
	while ($stmt->fetch()) {
		$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
	}

	/* close statement and connection*/ 
	$stmt->close(); 
	$mysqli->close();
		
} else {


$location = $_POST['location'];
$tcommitment = $_POST['tcommitment'];
$department = $_POST['department'];

//Selecting only Location
if ((!$_POST['search_keyword']) && ($_POST['location_checked']) && (!$_POST['department_checked']) && (!$_POST['tcommitment_checked'])){

	//creating query
	$sql = "SELECT DISTINCT T.ID,`task_title`, `start_date`, D.department_name, L.campus_name , `weekly_time_commitment` FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID \n"
    . "WHERE T.status_id = 1 AND T.location_id = ? ORDER BY T.ID ASC";	
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);
	
	// Prepared statement, stage 2: execute
	$stmt->bind_param("i", $location);
	if($stmt->execute()) {

		$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
		
		/* fetch values */ 
		while ($stmt->fetch()) {
			$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
		}
		
	} else {
		echo "<br>Error <br>";
	};		
	
	$stmt->close();
	$mysqli->close();
}

//if there is just department
if ((!$_POST['search_keyword']) && (!$_POST['location_checked']) && ($_POST['department_checked']) && (!$_POST['tcommitment_checked'])){

$sql = "SELECT DISTINCT T.ID,`task_title`, `start_date`, D.department_name, L.campus_name , `weekly_time_commitment` "
	.  "FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id "
	.  "INNER JOIN `Location` AS L ON T.location_id = L.ID "
	.  "INNER JOIN `Department` As D ON T.department_id = D.ID \n"
    .  "WHERE T.status_id = 1 AND T.department_id = ? ORDER BY T.ID ASC";
		
		// Prepared statement, stage 1: prepare
		$stmt = $mysqli->prepare($sql);
		
		// Prepared statement, stage 2: execute
		$stmt->bind_param("i", $department);
		if($stmt->execute()) {

			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
			
		} else {
			echo "<br>Error <br>";
		};		

$stmt->close();
$mysqli->close();
}


//if there is just tcommmitment
if ((!$_POST['search_keyword']) && (!$_POST['location_checked']) && (!$_POST['department_checked']) && ($_POST['tcommitment_checked'])){

$sql = "SELECT DISTINCT T.ID,`task_title`, `start_date`, D.department_name, L.campus_name , `weekly_time_commitment` "
	.  "FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id "
	.  "INNER JOIN `Location` AS L ON T.location_id = L.ID "
	.  "INNER JOIN `Department` As D ON T.department_id = D.ID \n"
    .  "WHERE T.status_id = 1 AND T.weekly_time_commitment < ? ORDER BY T.ID ASC";
		
		// Prepared statement, stage 1: prepare
		$stmt = $mysqli->prepare($sql);
		
		// Prepared statement, stage 2: execute
		$stmt->bind_param("i", $tcommitment);
		if($stmt->execute()) {

			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
			
		} else {
			echo "<br>Error <br>";
		};		

$stmt->close();
$mysqli->close();
} 

//if there is just keywords location department
if ($_POST['search_keyword'] && ($_POST['location_checked']) && ($_POST['department_checked']) && (!$_POST['tcommitment_checked'])) {
	
	$search = $_POST['search_keyword'];
	//add in wildcard characters for query
	$search = '%'.$search.'%';
	echo $search; 
	
	//prepare select query
	$sql = "SELCT DISTINCT t1.ID, t1.task_title, t1.start_date, t1.department_name, t1.campus_name, t1.weekly_time_commitment FROM ( SELECT DISTINCT T.ID,`task_title`, `start_date`, `weekly_time_commitment`, D.department_name, L.campus_name, `status_id` FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID WHERE T.status_id = 1 AND T.location_id = ? AND T.department_id = ?) AS t1 WHERE t1.task_title LIKE ? OR t1.campus_name LIKE ? OR t1.department_name LIKE ?";
	echo $location;
	echo $department;
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);

	// Prepared statement, stage 2: execute
	$stmt->bind_param("iisss", $location, $department, $search, $search, $search);
	
	//if query is executed, bind results
	if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
	} else {
		echo "<br>Error <br>";
	};	

$stmt->close();
$mysqli->close();
}

//if there is location and department
if ((!$_POST['search_keyword']) && ($_POST['location_checked']) && ($_POST['department_checked']) && (!$_POST['tcommitment_checked'])){

$sql = "SELECT DISTINCT T.ID,`task_title`, `start_date`, D.department_name, L.campus_name , `weekly_time_commitment` "
	.  "FROM `Task` AS T "
	.  "INNER JOIN `Location` AS L ON T.location_id = L.ID "
	.  "INNER JOIN `Department` As D ON T.department_id = D.ID \n"
    .  "WHERE T.status_id = 1 AND T.location_id = ? AND T.department_id = ? ORDER BY T.ID ASC";
	
		// Prepared statement, stage 1: prepare
		$stmt = $mysqli->prepare($sql);
		
		// Prepared statement, stage 2: execute
		$stmt->bind_param("ii", $location, $department);
		if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
		} else {
			echo "<br>Error <br>";
		};	

$stmt->close();
$mysqli->close();
} 


//if they're keywords and location & tcommitment
if ($_POST['search_keyword'] && ($_POST['location_checked']) && (!$_POST['department_checked']) && ($_POST['tcommitment_checked'])) {
	
	$search = $_POST['search_keyword'];
	//add in wildcard characters for query
	$search = '%'.$search.'%';

	//prepare select query
	$sql = "SELECT DISTINCT t1.ID, t1.task_title, t1.start_date, t1.department_name, t1.campus_name, t1.weekly_time_commitment FROM ( SELECT DISTINCT T.ID,`task_title`, `start_date`, `weekly_time_commitment`, D.department_name, L.campus_name, `status_id` FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID WHERE T.status_id = 1 AND T.location_id = ? AND T.weekly_time_commitment < ?) AS t1 WHERE t1.task_title LIKE ? OR t1.campus_name LIKE ? OR t1.department_name LIKE ?";
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);

	// Prepared statement, stage 2: execute
	$stmt->bind_param("iisss", $location, $tcommitment, $search,$search,$search);
	
	//if query is executed, bind results
	if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
	} else {
		echo "<br>Error <br>";
	};	

$stmt->close();
$mysqli->close();
}


//if they're keywords and department & tcommitment
if ($_POST['search_keyword'] && (!$_POST['location_checked']) && ($_POST['department_checked']) && ($_POST['tcommitment_checked'])) {
	
	$search = $_POST['search_keyword'];
	//add in wildcard characters for query
	$search = '%'.$search.'%';

	//prepare select query
	$sql = "SELECT DISTINCT t1.ID, t1.task_title, t1.start_date, t1.department_name, t1.campus_name, t1.weekly_time_commitment FROM ( SELECT DISTINCT T.ID,`task_title`, `start_date`, `weekly_time_commitment`, D.department_name, L.campus_name, `status_id` FROM `Task` AS T INNER JOIN `Applied_to_Task` AS A ON T.ID = A.task_id INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID WHERE T.status_id = 1 AND T.department_id = ? AND T.weekly_time_commitment < ?) AS t1 WHERE t1.task_title LIKE ? OR t1.campus_name LIKE ? OR t1.department_name LIKE ?";
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);

	// Prepared statement, stage 2: execute
	$stmt->bind_param("iisss", $department, $tcommitment, $search,$search,$search);
	
	//if query is executed, bind results
	if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
	} else {
		echo "<br>Error <br>";
	};	

$stmt->close();
$mysqli->close();
}


//if they're keywords and ALL FILTERS
if ($_POST['search_keyword'] && ($_POST['location_checked']) && ($_POST['department_checked']) && ($_POST['tcommitment_checked'])) {
	
	$search = $_POST['search_keyword'];
	//add in wildcard characters for query
	$search = '%'.$search.'%';

	//prepare select query
	$sql = "SELECT DISTINCT t1.ID, t1.task_title, t1.start_date, t1.department_name, t1.campus_name, t1.weekly_time_commitment FROM ( SELECT DISTINCT T.ID,`task_title`, `start_date`, `weekly_time_commitment`, D.department_name, L.campus_name, `status_id` FROM `Task` AS T INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID WHERE T.status_id = 1 AND T.location_id = ? AND T.department_id = ? AND T.weekly_time_commitment < ?) AS t1 WHERE t1.task_title LIKE ? OR t1.campus_name LIKE ? OR t1.department_name LIKE ?";
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);

	// Prepared statement, stage 2: execute
	$stmt->bind_param("iiisss", $location, $department, $tcommitment, $search,$search,$search);
	
	//if query is executed, bind results
	if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
	} else {
		echo "<br>Error <br>";
	};	

$stmt->close();
$mysqli->close();
} 

//if they're keywords and NO FILTERS
if ($_POST['search_keyword'] && (!$_POST['location_checked']) && (!$_POST['department_checked']) && (!$_POST['tcommitment_checked'])) {
	
	$search = $_POST['search_keyword'];
	//add in wildcard characters for query
	$search = '%'.$search.'%';

	//prepare select query
	$sql = "SELECT DISTINCT t1.ID, t1.task_title, t1.start_date, t1.department_name, t1.campus_name, t1.weekly_time_commitment FROM ( SELECT DISTINCT T.ID,`task_title`, `start_date`, `weekly_time_commitment`, D.department_name, L.campus_name, `status_id` FROM `Task` AS T INNER JOIN `Location` AS L ON T.location_id = L.ID INNER JOIN `Department` As D ON T.department_id = D.ID WHERE T.status_id = 1) AS t1 WHERE t1.task_title LIKE ? OR t1.campus_name LIKE ? OR t1.department_name LIKE ?";
	
	// Prepared statement, stage 1: prepare
	$stmt = $mysqli->prepare($sql);

	// Prepared statement, stage 2: execute
	$stmt->bind_param("sss", $search,$search,$search);
	
	//if query is executed, bind results
	if($stmt->execute()) {
			$stmt->bind_result($id, $task_title, $start_date, $department_name, $campus_name, $timecom_result); 
			
			/* fetch values */ 
			while ($stmt->fetch()) {
				$message .= "<tr><td><a class='td_link' href='taskresult.php?id=$id'>$task_title</a></td><td>$start_date</td><td>$department_name</td><td>$campus_name</td><td>$timecom_result</td></tr>";
			}
	} else {
		echo "<br>Error <br>";
	};	

$stmt->close();
$mysqli->close();
} 

}
		
?>

<head>
  <title>Tasktrader | Tasks</title>
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
		<h2>Search Tasks</h2>
	  </div>
	  <div class="search_wrapper">
	   <!-- Search Form Begins Here -->
	   <form class="" action="tasks.php" method="POST">
		<div class="input-group col-xs-6">
			<!--Keyword Search Input Form -->
			<input type="text" name="search_keyword" class="form-control" id="search_task" placeholder="Search Keywords">
			<span class="input-group-btn">
				<!--Search Button to submit request -->
				<button type="submit" class="btn btn-default btn-inverse">Search</button>
			</span>
		</div>
		<br>
		<!-- Filter Dropdowns -->
		<label>Filter:</label>
		<br><br>
		<div class="row">
		<div class="form-group col-xs-4">
			<input type="checkbox" name="department_checked" class="department_checked" checked data-toggle="toggle" data-size="mini">
			<label for="department" class="control-label">Department:</label>
				<select class="form-control" name="department">
					<option value="1" >Executive Board</option>
					<option value="2" >Operations</option>
					<option value="3" >Corporate Strategy</option>
					<option value="4" >Research and Development</option>
					<option value="5" >Human Resources</option>
					<option value="6" >Marketing</option>
					<option value="7" >Advertising</option>
					<option value="8" >Product Development</option>
					<option value="9" >Accounting</option>
					<option value="10" >Business Intelligence</option>
					<option value="11" >Information Technology</option>
					<option value="12" >Information Solutions</option>
					<option value="13" >Instagram</option>
					<option value="14" >Oculus</option>
					<option value="14" >WhatsApp</option>
				</select>	
		</div>
		<div class="form-group col-xs-4">
			<input type="checkbox" name="location_checked" class="location_checked" checked data-toggle="toggle" data-size="mini">
			<label for="location" class="control-label">Location:</label>
				<select class="form-control filter_location" name="location">
					<option value="1" >HeadQuarters</option>
					<option value="2" >Mars Discovery District</option>
					<option value="3" >Roths Child Boulevard</option>
					<option value="4" >Internet City</option>
				</select>
		</div>
		<div class="form-group col-xs-4">
			<input type="checkbox" class="tcommitment_checked" name="tcommitment_checked" checked data-toggle="toggle" data-size="mini">
			<label for="tcommitment" class="control-label filter_commitment">Time Commitment:</label>
			<input class="form-control" name="tcommitment" type="number" min="1" max="20" step="1">
		</div>
		</div>
		</form>
	  </div>
	  <div>		
	  
	  <!-- Search Table Results -->
	  <table class="table table-striped">
	  <thead>
      <tr>
        <th>Title</th>
        <th>Deadline</th>
		<th>Time Commitment</th>
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