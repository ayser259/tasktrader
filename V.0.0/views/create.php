<?php 
include('../my_connect.php');
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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
  <script src="../static/tasktrader.js"></script>
 </head>
 <body>
	 <div class="wrapper">
		<?php
		require('nav.php');
		?>
	  <section class="explore_page"> 
		 <div class="heading">
			<h2>Create Task</h2>
		 </div>
		 <div class="createForm">
		  <div class="row create_top">
			<div class="col-xs-6" style="margin-left: 35px"><label>Employee Poster: </label><span style='padding-left: 35px' class="task_disabled">Cindy Klein</span></div>
			
			<!-- FORM BEGINS HERE --> 
			<form action="insert_task.php" method="POST" class="create_task form-horizontal">
				<!-- Task Title -->
				<div class="form-group">
					<label class="control-label col-sm-2" for="task_title">Task Title:</label>
					<div class="col-sm-10"> 
						<input type="text" class="form-control" id="task_title" name="tname" requried>
					</div>
				</div>
				
				<!-- Task Description -->
				<div class="form-group">
					<label class="control-label col-sm-2" for="task_title">Task Description:</label>
					<div class="col-sm-10"> 
						<textarea name="tdescription" class="form-control" rows="5" required></textarea>
					</div>
				</div>
				
				<!-- Task Skills -->
				<div class="form-group">
					<label class="control-label col-sm-2" for="task_skills">Skills:</label>
					<div class="col-sm-10"> 
						<input name="task_tags" id="tags" value="SQL,accounting,excel" required>
					</div>
				</div>
				
				<!-- Task Time Commitment, Location, Department -->
				<div class="form-group row">
					<label class="control-label col-sm-2" for="department">Department</label>
					<div class="col-md-3">
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
					<label class="control-label col-sm-1" for="location">Location</label>
					<div class="col-md-2"> 
						<select class="form-control" name="location">
							<option value="1" >HeadQuarters</option>
							<option value="2" >Mars Discovery District</option>
							<option value="3" >Roths Child Boulevard</option>
							<option value="4" >Internet City</option>
						</select>
					</div>
					<label class="control-label col-sm-3" for="task_commitment">Time Commitment (hrs/week):</label>
					<div class="col-md-1"> 
						<input type="number" min="1" max="20" class="form-control" id="task_commitment" name="tcommitment" required>
					</div>				
				</div>
				
				<!-- Task Start/End Date -->
				<div class="form-group row">
					<label class="control-label col-sm-2" for="task_start_date">Start Date:</label>
					<div class="col-md-3"> 
						<input type="date" name="start_date" class="form-control" id="task_start_date">
					</div>
					<label class="control-label col-sm-1" for="task_end_date">End:</label>
					<div class="col-md-3"> 
						<input type="date" name="end_date" class="form-control" id="task_end_date">
					</div>
				</div>	
								
				<button type="submit" class="save_button save_later">Save and Post</button>
				<!-- <button class="save_button save_post">Save and Post</button> -->
			</form>
		  </div>
		 </div>
	  </section>
	 </div>
 </body>
</html>