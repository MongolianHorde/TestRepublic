<?php
    // Authors: Jake Stevens
	// Date Created: 3/31/15
	// Last Modified: 3/31/15
	// This php script handles the db stuff for submitting a test for grading
	require("../constants.php");
    
    $database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);
	@$database->select_db(DATABASENAME);
    
    $submitQuery = "update test_list set graded = 1, test_score = 0 where student_id = ? and test_id = ?";
    
    $submitStatement = $database->prepare($submitQuery);
    
    @$id = $_POST['id'];
    @$testId = $_POST['testId'];
    
    $submitStatement->bind_param("ss", $id, $testId);
	$submitStatement->execute();
	$submitStatement->close();
	
	//header('Location: pledgePage.php');
	
?>