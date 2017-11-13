<?php
     $mysqli = get_mysqli_conn();
	 // get the image from the db
     $prof_sql = "SELECT image FROM Picture WHERE account_id = 10";

	 $prof_stmt = $mysqli->prepare($prof_sql);
     // the result of the query
     $prof_stmt->execute();	
	 $prof_stmt->bind_result($result);

	 //fetch the result and show the profile image in navigation bar
	 if ($prof_stmt->fetch()){
		$photo = 'background: url(data:image/jpeg;base64,'.base64_encode( $result ).') no-repeat center center/cover;';
	 }
     
	 // close the db link
     $prof_stmt->free_result();

	?>

	<!--navigation bar begins here -->
	<nav class="navbar navbar-inverse sidebar navbar-left" role="navigation">
 		<!-- profile section -->
 		<div class="css_triangle"></div>
 		<div class="navbar_profile">
 				<div class="profile_pic" style="<?php echo $photo; ?>"></div>
 				<p class="profile_name"><a href="profile.php" class="vcenter">Cindy Klein</a></p>
 		</div>
		<!-- navigation links -->
 		<div class="navbar_items">
 				<ul>
 					<li><a href="dashboard.php" class="vcenter">dashboard</a></li>
 					<li><a href="tasks.php" class="vcenter">task board</a></li>
 					<li><a href="create.php" class="vcenter">create task</a></li>
 					<li><a href="applied.php" class="vcenter">applied to</a></li>
 					<li><a href="explore.php" class="vcenter">explore</a></li>
 				</ul>	
 		</div>
  </nav>
  <!-- navigation bar ends here -->