<?php
	// Enable error logging: 
	//error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	// mysqli connection via user-defined function
	include ('../my_connect.php');
	$mysqli = get_mysqli_conn();
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
 </head>
 
<body>
<div class="wrapper">
	<?php
    require('nav.php');
	?>
	<section class="explore_page"> 
		<div class="heading">
			<h2>Explore</h2>
		</div>
		<div class="create_apply_wrapper">
			<a href="create.php">
				<div class="ca_wrapper">
					<div class="ca_content">
						<span>POST</span><br> a task
					</div>
				</div>
			</a>
			<a href="tasks.php">
				<div class="ca_wrapper">
					<div class="ca_content">
							<span>Apply</span><br> to tasks
					</div> 
				</div>
			</a>
		</div>
	  <div class="new_wrapper">
		<h4>Closing Soon</h4>
		<!-- Query to get the first four tasks that are closing soon -->
	  	<div class="border"></div>
	  	<div class="new_inner_wrapper" style="">
			<?php
			// SQL statement
			$sql = "SELECT T.ID, T.task_title, DATE_ADD(T.start_date, INTERVAL -7 DAY) AS deadline, COUNT(A.employee_id) AS applications, T.start_date FROM Task T LEFT JOIN Applied_to_Task A ON T.ID = A.task_id WHERE T.status_id = 1 AND DATE_ADD(T.start_date, INTERVAL -7 DAY) > CURRENT_TIMESTAMP GROUP BY T.id ORDER BY T.start_date ASC LIMIT 4";
			// Prepared statement, stage 1: prepare
			$stmt = $mysqli->prepare($sql);
			// Prepared statement, stage 2: execute
			$stmt->execute();
			// Bind result variables 
			$stmt->bind_result($t_id, $task_title, $deadline, $applications, $start_date); 
			/* fetch values */ 
			while ($stmt->fetch()) 
			{
			print "<div class='new_box'>
					<div class='box_icon' id='info'><a href='taskresult.php?id=$t_id' style='color: initial; text-decoration:none'><i class='fa fa-info' aria-hidden='true'></a></i></div>
					<div class='box_icon' id='shortlist'><i class='fa fa-heart-o' aria-hidden='true'></i></div>
					<div class='upper_box'>
						<span class='box_text'><h4>$task_title</h4></span>
					</div>
					<div class='lower_box'>
						<span class='box_desc'>Deadline: $deadline</br># of Applications: $applications</span>
					</div>
				</div>"; 
			}
			/* close statement and connection*/ 
			$stmt->close(); 
			?>
	  	</div>
	</div>
		<div class="new_wrapper">
			<h4>Recommended For You</h4>
			<div class="border"></div>
			<div class="new_inner_wrapper" style="">
				<?php
				// SQL statement
				$sql = "SELECT M.task_title,
						DATE_ADD(M.start_date, INTERVAL -7 DAY) AS deadline,
						FLOOR((M.skill_match*100/R.required_skill_ct)) AS match_out,
						COUNT(A.employee_id) AS applications
						FROM (SELECT T.ID, T.task_title, T.start_date, T.status_id, COUNT(skill_id) AS skill_match FROM Task T LEFT JOIN Task_Skills TS on T.id = TS.task_id INNER JOIN Employee_Skills ES ON TS.skill_id = ES.skills_id WHERE ES.employee_id = 10 GROUP BY ID) M
						LEFT JOIN (SELECT T.ID, COUNT(TS.skill_id) AS required_skill_ct FROM Task T LEFT JOIN Task_Skills TS on T.id = TS.task_id GROUP BY T.ID) R
						ON M.ID = R.ID
						LEFT JOIN Applied_to_Task A ON M.ID = A.task_id
						WHERE M.status_id = 1 AND DATE_ADD(M.start_date, INTERVAL -7 DAY) > CURRENT_TIMESTAMP GROUP BY M.ID ORDER BY (M.skill_match/R.required_skill_ct) DESC, M.start_date ASC LIMIT 4";
				// Prepared statement, stage 1: prepare
				$stmt = $mysqli->prepare($sql);
				// Prepared statement, stage 2: execute
				$stmt->execute();
				// Bind result variables 
				$stmt->bind_result($task_title, $deadline, $match, $applications); 
				/* fetch values */ 
				while ($stmt->fetch()) 
				{
				print "<div class='new_box'>
						<div class='box_icon' id='info'><a href='taskresult.php?id=$t_id' style='color: initial; text-decoration:none'><i class='fa fa-info' aria-hidden='true'></i></a></div>
						<div class='box_icon' id='shortlist'><i class='fa fa-heart-o' aria-hidden='true'></i></div>
						<div class='upper_box'>
							<span class='box_text'><h4>$task_title</h4></span>
						</div>
						<div class='lower_box'>
							<span class='box_desc'>Deadline: $deadline</br># of Applications: $applications</br>Skills Match: $match%</span>
						</div>
					</div>"; 
				}

				/* close statement and connection*/ 
				$stmt->close(); 
				?>
			</div>
		</div>
		<div class="new_wrapper">
			<h4>At Your Location</h4>
			<div class="border"></div>
			<div class="new_inner_wrapper" style="">
				<?php
				// SQL statement
				$sql = "SELECT T.ID, T.task_title, DATE_ADD(T.start_date, INTERVAL -7 DAY) AS deadline, COUNT(A.employee_id) AS applications, T.start_date FROM Task T LEFT JOIN Applied_to_Task A ON T.ID = A.task_id WHERE T.status_id = 1 AND DATE_ADD(T.start_date, INTERVAL -7 DAY) > CURRENT_TIMESTAMP AND T.location_id = 1 GROUP BY T.id ORDER BY T.start_date ASC LIMIT 4";
				// Prepared statement, stage 1: prepare
				$stmt = $mysqli->prepare($sql);
				// Prepared statement, stage 2: execute
				$stmt->execute();
				// Bind result variables 
				$stmt->bind_result($t_id, $task_title, $deadline, $applications, $start_date); 
				/* fetch values */ 
				while ($stmt->fetch()) 
				{
				print "<div class='new_box'>
						<div class='box_icon' id='info'><a href='taskresult.php?id=$t_id' style='color: initial; text-decoration:none'><i class='fa fa-info' aria-hidden='true'></a></i></div>
						<div class='box_icon' id='shortlist'><i class='fa fa-heart-o' aria-hidden='true'></i></div>
						<div class='upper_box'>
							<span class='box_text'><h4>$task_title</h4></span>
						</div>
						<div class='lower_box'>
							<span class='box_desc'>Deadline: $deadline</br># of Applications: $applications</span>
						</div>
					</div>"; 
				}

				/* close statement and connection*/ 
				$stmt->close(); 
				$mysqli->close();
				?>
			</div>
	  </div>
	</section>
</div>
</body>
</html>