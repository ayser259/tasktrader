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
			<h2>Dashboard</h2>
		</div>
		<div class="container">
			<div class="row">
				<!-- overview div begins here -->
				<h3>Overview</h3>
				<div class="border" id="topborder"></div>
				<div class="col-md-4 text-center" id="bluewhite" style="box-shadow: 1px 1px 3px grey">
					<h3>
					<!-- Query to fetch all unfilled tasks -->
						<?php
							// SQL statement
							$sql = "SELECT COUNT(*) FROM Task T WHERE T.status_id = 1 AND DATE_ADD(T.start_date, INTERVAL -7 DAY) > CURRENT_TIMESTAMP";
							// Prepared statement, stage 1: prepare
							$stmt = $mysqli->prepare($sql);
							// Prepared statement, stage 2: execute
							$stmt->execute();
							// Bind result variables 
							$stmt->bind_result($applications); 
							/* fetch values */ 
							while ($stmt->fetch()) 
								{
								print "$applications"; 
								}
							/* close statement and connection*/ 
							$stmt->close(); 
						?>
					</h3>
					<h4>unfilled tasks available.</h4>
				</div>
				<div class="col-md-4 text-center" id="lightblueblue" style="box-shadow: 1px 1px 3px grey">
					<h3>	
					<!-- Query to aggregate total applications applied to -->
						<?php
							// SQL statement
							$sql = "SELECT COUNT(*) FROM Applied_to_Task A WHERE A.employee_id = 10";
							// Prepared statement, stage 1: prepare
							$stmt = $mysqli->prepare($sql);
							// Prepared statement, stage 2: execute
							$stmt->execute();
							// Bind result variables 
							$stmt->bind_result($applications); 
							/* fetch values */ 
							while ($stmt->fetch()) 
								{
								print "$applications"; 
								}
							/* close statement and connection*/ 
							$stmt->close(); 
						?>
					</h3>
					<h4>tasks applied to, good for you.</h4>
				</div>
				<div class="col-md-4 text-center" id="greenwhite" style="box-shadow: 1px 1px 3px grey">
					<!-- Query to fetch all applicants to apply to tasks posted by employee -->
					<h3>	
						<?php
							// SQL statement
							$sql = "SELECT COUNT(*) FROM Applied_to_Task A WHERE A.task_id IN (SELECT P.task_id FROM Posted_Task P WHERE P.employee_id = 10)";
							// Prepared statement, stage 1: prepare
							$stmt = $mysqli->prepare($sql);
							// Prepared statement, stage 2: execute
							$stmt->execute();
							// Bind result variables 
							$stmt->bind_result($applications); 
							/* fetch values */ 
							while ($stmt->fetch()) 
								{
								print "$applications"; 
								}
							/* close statement and connection*/ 
							$stmt->close(); 
						?>
					</h3>
					<h4>people applied to your tasks, hooray!</h4>
				</div>
			</div>
			<div class="row">
				<h3>Applicants to our Postings</h3>
				<div class="border"></div>
				<div class="col-md-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Posting ID</th>
								<th>Task Title</th>
								<th>Applicant ID</th>
								<th>Applicant Name</th>
								<th>Applicant Title</th>
								<th>Department</th>
								<th>Location</th>
							</tr>
						</thead>
						<tbody>
						<!-- Analytics to fetch list of all applicants who applied to postings-->
							<?php
							// SQL statement
							$sql = "SELECT P.task_id, T.task_title, A.employee_id, E.first_name, E.last_name, E.job_title, D.department_name, L.campus_name FROM Posted_Task P LEFT JOIN Applied_to_Task A ON P.task_id = A.task_id LEFT JOIN Task T ON P.task_id = T.ID LEFT JOIN Employee E ON A.employee_id = E.ID LEFT JOIN Department D ON E.department_id = D.ID LEFT JOIN Location L ON E.location_id = L.ID WHERE P.employee_id = 10 ";
							// Prepared statement, stage 1: prepare
							$stmt = $mysqli->prepare($sql);
							// Prepared statement, stage 2: execute
							$stmt->execute();
							// Bind result variables 
							$stmt->bind_result($posting_id, $task_title, $applicant_id, $applicant_fname, $applicant_lname, $applicant_title, $applicant_dept, $applicant_campus); 

							/* fetch values */ 
							while ($stmt->fetch()) 
							{
							print "<tr><td>$posting_id</td><td><a class='td_link' href='taskresult.php?id=$posting_id'>$task_title</a></td><td>$applicant_id</td><td>$applicant_fname $applicant_lname</td><td>$applicant_title</td><td>$applicant_dept</td><td>$applicant_campus</td></tr>"; 
							}

							/* close statement and connection*/ 
							$stmt->close(); 
							?>
						</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<h3>Leaderboard!</h3>
			<div class="border"></div>
			<h5>Other employees of your supervisor with above average applications</h5>
			<br>
			<div class="col-md-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Job Title</th>
							<th>Location</th>
						</tr>
					</thead>
					<tbody>
					<!-- query to get an agggregate list of applicants who are over the average -->
						<?php
							// SQL statement
							$sql = "SELECT E.first_name, E.last_name, E.job_title, L.campus_name FROM Applied_to_Task A LEFT JOIN Employee E ON A.employee_id = E.ID LEFT JOIN Location L ON E.location_id = L.ID WHERE E.supervisor_id = 1 GROUP BY A.employee_id HAVING COUNT(*) > (SELECT COUNT(*)/COUNT(DISTINCT A.employee_id) AS avg_apps FROM Applied_to_Task A LEFT JOIN Employee E ON A.employee_id = E.ID WHERE E.supervisor_id = 1)";
							// Prepared statement, stage 1: prepare
							$stmt = $mysqli->prepare($sql);
							// Prepared statement, stage 2: execute
							$stmt->execute();
							// Bind result variables 
							$stmt->bind_result($fname, $lname, $title, $campus);

							/* fetch values */ 
							while ($stmt->fetch()) 
							{
							print "<tr><td>$fname $lname</td><td>$title</td><td>$campus</td></tr>"; 
							}

							/* close statement and connection*/ 
							$stmt->close(); 
							$mysqli->close();
						?>
					</tbody>
				</table>
			</div>
		</div>
  </section>
 </div>
 </body>
</html>