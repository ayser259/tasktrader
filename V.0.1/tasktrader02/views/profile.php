<?php
// Enable error logging: 
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
// mysqli connection via user-defined function
include ('../my_connect.php');
header("Cache-Control: no-cache");
$mysqli = get_mysqli_conn();
$photo = "";
			
//Update Skills in Profile 
if(isset($_POST['submit'])){

	//split skill keywords into an array and capitalize them
	$myArray = explode(',', strtoupper($_POST['tags']));
	
	//prepare Select Query to verify if skills are in skills table
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
				$allSkills[] = $value;
				if ($result < 1){
					$insertSkill[] = $value;
				}
			} else {
				printf("Errormessage: %s\n", $mysqli->error);
			}	
		}	
	}
	
	$stmt->free_result();	
	
	//prepare insert query to skills table
	$stmt2 = $mysqli->prepare("INSERT INTO Skill (skill_name) VALUES (?)");
	if ($stmt2){
		foreach ($insertSkill as $skill) {
			$stmt2->bind_param('s', $skill);				
			if($stmt2->execute()){
	
			} else {
				
			}
		}
	} else {
		
	}
	
	//close connection
	$stmt2->free_result();
	
	//add skills to skills_employee table
	$stmt4 = $mysqli->prepare("INSERT INTO Employee_Skills(employee_id, skills_id) SELECT 10, S.ID FROM Skill S WHERE S.skill_name = ? ");
	if ($stmt4){
		foreach ($allSkills as $added) {
			
			
			$stmt4->bind_param('s', $added);				
			if($stmt4->execute()){
					echo "<div class='update_message'>Skills Sucessfully Updated!</div>";
			} else {
				//echo "insert failed";
			}
		}
	} else {
		echo "Insert failed !";
	}
	
	$stmt2->free_result();
}

//prepare Select Query to show all skills of the user
$showSkills_sql = "SELECT DISTINCT S.skill_name FROM `Employee_Skills` E, `Skill` S WHERE E.skills_id = S.ID AND E.employee_id = 10";
$stmt3 = $mysqli->prepare($showSkills_sql);

if ($stmt3) {
	$stmt3->execute();	
	$stmt3->bind_result($skill_result);
}

while ($stmt3->fetch()) 
	{
	$show_skills[] = $skill_result;
	$outer_skills .= "<span class='show_result'>$skill_result,&nbsp;<br></span>";
	}

$stmt3->free_result();

// check if a file was submitted
if(isset($_FILES['userfile']))
{
    try {
    $message= upload($mysqli);  //this will upload your image
	echo $message;

	//header("Refresh:0");
    }
    catch(Exception $e) {
    echo $e->getMessage();
    echo 'Sorry, could not upload file';
    }
}

// uploading photo
// Referenced from vikasmahajan - July 7, 2010 

function upload($mysqli) {
    $maxsize = 10000000; //set to approx 10 MB
    //check associated error code
    if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['userfile']['size'] < $maxsize) {  
				
				//checks whether uploaded file is of image type
				//if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    
					
                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
					
					$picture_sql = "UPDATE Picture SET image = '{$imgData}', name = '{$_FILES['userfile']['name']}' WHERE account_id = 10";
						
                    $stmt5 = $mysqli->prepare($picture_sql);
					$stmt5->execute();
                    $message="<div class='update_message'>Image Sucessfully Updated!</div>";
					$stmt5->free_result();
                }
                else
                    $message="<p>Uploaded file is not an image.</p>";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $message='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].
                ' bytes</div><hr />';
                }
        }
        else
            $message="File not uploaded successfully.";
    }
    else {
        $message= picture_error($_FILES['userfile']['error']);
    }
    return $message;
}

//Return Error if we get it
function picture_error($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'File exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'File exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'File was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

function getPhoto($mysqli){
     // get the image from the db
     $get_picture_sql = "SELECT image FROM Picture WHERE account_id = 10";

	 $photo_stmt = $mysqli->prepare($get_picture_sql);
     // the result of the query
     $photo_stmt->execute();	
	 $photo_stmt->bind_result($result);

	 if ($photo_stmt->fetch()){
		//$photo = '<img src="data:image/jpeg;base64,'.base64_encode( $result ).'"/>';
		$photo2 = 'background: url(data:image/jpeg;base64,'.base64_encode( $result ).') no-repeat center center/cover !important;';
		return $photo2;
	 }
     
     $photo_stmt->free_result();
	}
	
	$photo2 = getPhoto($mysqli);		
	$mysqli->close();
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
  <script src="../static/tasktrader.js"></script>
 </head>
 <body>

<div class="wrapper">
	<?php
    require('nav.php');
	?>
  <section class="explore_page"> 
	<div class="heading">
		<h2>Hi Cindy!</h2>
	</div>
	<div class="row" style="margin-top: 15px">
		<div class="unedited_info thumbnail col-xs-6"><strong>Name:</strong>&nbsp;&nbsp;Cindy Klein</div>
		<div class="unedited_info thumbnail col-xs-6"><strong>Job Title: </strong>&nbsp;&nbsp;Programmer</div>
	</div>
	<div class="row">
		<div class="unedited_info thumbnail col-xs-6"><strong>Department:</strong>&nbsp;&nbsp;Software</div>
		<div class="unedited_info thumbnail col-xs-6"><strong>Location:</strong> &nbsp;&nbsp;San Franscisco</div>
	</div>
	<div class="profile_content">
	<div class="profile_picture profile_section" name="profile_pic_form" style="<?php echo $photo2; ?>">
	<i class="fa fa-cloud-upload" aria-hidden="true"></i>
	</div>
	<div class="profile_info">
	<div class="profile_section" name="resume_form"><label>Resume:</label>resume.pdf</div>
	<div class="profile_section" name="skills_form"><label> Skills: </label>
		<p>

		<?php echo $outer_skills; ?>
		</p>
	</div>
	</div>
	
	<div class="profile_info" id="skills_form">
	<form class="form-horizontal" method="POST">
		<h3>Update Skills</h3>
		<br>
		<div class="form-group">
			<label class="control-label col-sm-2" for="task_skills">Skills:</label>
			<div class="col-sm-10">
				<input name="tags" id="tag" value="
		<?php 
			foreach($show_skills as $res) {				
				echo "$res,&nbsp;";
			}?>
				" />
			</div>
		</div>
		<div class="form-group">
		<button type="submit" class="save_button" name="submit">Update Skills</button>
		</div>
	</form>
	</div>

	<div class="profile_info" id="resume_form">
		<form enctype="multipart/form-data" action="" method="post">
			<h3>Update Resume</h3>
			<br>		
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000" >
			<input name="userfile" type="file" >
			<input type="submit" value="Submit" >
		</form>
	</div>
	
	<!-- Update Profile Picture -->
	<div class="profile_info" id="profile_pic_form">	
		<form enctype="multipart/form-data" action="profile.php" method="post">
			<h3>Update Profile Picture</h3>
			<br>		
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000" >
			<input name="userfile" type="file" >
			<input type="submit" value="Submit" >
		</form>
	</div>
	
	</div>
	</div>
  </section>
 </div> 
 </body>
</html>

