<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Test Republic</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	   <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

<?php

session_start();

// Include the constants used for the db connection
require("constants.php");

// The database variable holds the connection so you can access it
$database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);

if (mysqli_connect_errno())
{
   echo "<h1>Connection error</h1>";
}

// Query for the list of classes offered
$listClassQuery = "select class_id, class_description from class";

// Query to assign a student an id
$newStudentIdQuery = "select max(student_id) from student"; // We add one to this with each insert

// Insert a student into the student table
$insertStudentQuery = "insert into student values(?, ?, ?, ?, ?)";

// Insert the classes a student is taking into enrollment
$insertEnrollmentQuery = "insert into enrollment values(?, ?)";

$insertTestQuery = "insert into test_list(student_id, test_id) values (?, ?)";

$selectTestIdQuery = "select test_id from test where class_id = ?";


@ $database->select_db(DATABASENAME);


// Check to see if anything was entered, if not assign and empty string
$firstName = (isset($_POST['firstName']) ? $_POST['firstName'] : " ");
$lastName  = (isset($_POST['lastName']) ? $_POST['lastName'] : " ");
$email     = (isset($_POST['email']) ? $_POST['email'] : " ");
$password  = (isset($_POST['password']) ? $_POST['password'] : " ");
$classes  = (isset($_POST['classes']) ? $_POST['classes'] : " ");

?>
		


	

<form name="signUpForm" id="signUpForm" action="signUp.php" method="post">
<div id="sidebar-wrapper">

					
					<a href="logout.php">
					<!-- Button with a link wrapped around it to go back to the login page -->
					<button class="btn btn-block btn-primary" type="button" id="signUpButton" onclick="signUp.php">
						<i class="glyphicon glyphicon-log-in"></i>Back to Login
					</button></a>
            <ul class="sidebar-nav">
				<li>
                    <a href="#" id="student-summary">Summary</a>
                </li>
                <li class="sidebar-brand"><!-- VIC AND ANDREA, I'D LIKE FOR THIS TO "SELECT A CLASS TO ADD:" (formatting needed) -->
                    Select a Class:
                </li>
               
				<?php 
				
				// List of classes for the user to select from...we'll need to keep track of what class is selected for the db
				if ($classList = $database->prepare($listClassQuery)) 
				{
					// nothing to bind
				}
				else {
					printf("Errormessage: %s\n", $database->error);
				}	
				$classList->bind_result($clid, $clde);
				$classList->execute();
				
				$courseCounter = 1;
				$classCounter = 1; 
				while($classList->fetch())
				{	
					echo '<li><a href="#"><div class="subject-name">' . $courseCounter++ . ". " . $clde . '</div></a><input type="checkbox" name="classes[]" value="' . $clid . '"></li>';
					
				}
				$classList->close(); 
				

				?>
            </ul>
				
				
        </div>

	<div id="signUpDiv">
		<h1>Welcome!</h1>
			<h2>Please enter your information.</h2>
			<label class="survey_style">First Name:
				<input type="text" name="firstName" id="firstName" />
			</label><br />
			<label class="survey_style">Last Name:
				<input type="text" name="lastName" id="lastName" />
			</label><br />
			<label class="survey_style">Email:
				<input type="text" name="email" id="email" />
			</label><br />
			<label class="survey_style">Password:
				<input type="text" name="password" id="password" />
			</label><br />
			<input class="myButton" type="submit" value="Create Account" />

		</form>	

	
			
		<table class="signUpTable">
					<tr><td><?php echo $firstName ?></td></tr>
					<tr><td><?php echo $lastName ?></td></tr>
					<tr><td><?php echo $email ?></td></tr>
					<tr><td><?php echo $password ?></td></tr>
					
					<?php 
					if(is_array($classes))
					{
						// Assign an id
						if ($idStatement = $database->prepare($newStudentIdQuery)) 
						{
						}
						else {
							printf("Errormessage: %s\n", $database->error);
						}	
						
						$idStatement->bind_result($sid);
						$idStatement->execute();
						while($idStatement->fetch())
						{	
							$newId = $sid + 1;
						}
						$idStatement->close();
						
						foreach($classes as $a)
						{
							$testCounter = 0;
							
							echo '<h1 margin-left: 50px;>' . $a . '</h1></br />';
							if($insertEnrollmentStatement = $database->prepare($insertEnrollmentQuery))
							{
							}
							else {
							printf("Errormessage: %s\n", $database->error);
							}
							$insertEnrollmentStatement->bind_param("ss", $newId, $a);
							$insertEnrollmentStatement->execute();
							$insertEnrollmentStatement->close();
							
							// Select id for the test
							if($selectTestIdStatement = $database->prepare($selectTestIdQuery))
							{
								
							}
							else 
							{
								printf("Errormessage: %s\n", $database->error);
							}
							
							$selectTestIdStatement->bind_param("s", $a);
							$selectTestIdStatement->bind_result($tid);
							$selectTestIdStatement->execute();
							while($selectTestIdStatement->fetch())
							{	
								$testIdArray[$testCounter++] = $tid;
							}
							$selectTestIdStatement->close();
							
							foreach($testIdArray as $t)
							{
								$insertTestStatement = $database->prepare($insertTestQuery);
								$insertTestStatement->bind_param("ss", $newId, $t);
								$insertTestStatement->execute();
								$insertTestStatement->close();
							}
							
							
							
						}
						
						if ($insertStudentStatement = $database->prepare($insertStudentQuery))
						{
						}
						else{
							printf("Errormessage: %s\n", $database->error);
						}
						$insertStudentStatement->bind_param("sssss", $newId, $firstName, $lastName, $password, $email);
						$insertStudentStatement->execute();
						$insertStudentStatement->close();
				
				
				echo '<h1>' . $newId . '</h1>';
					}
					else
						echo '<h1>Yo</h1>';
					
					?>
					
		</table>
	</div>


	<?php

		
	?>



    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>