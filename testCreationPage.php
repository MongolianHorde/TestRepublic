


<!DOCTYPE html>

<!-- 2/21 - Modals added by Victor Jereza -->
<!-- 2/23 - Added lots of JavaScript -->
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
    <link href="css/teacher-create-test.css" rel="stylesheet">
	
	   <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Custom Test Creation JavaScript --> 
	<script src="js/testCreation.js"></script>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

	
</head>
<?php
session_start();

// Include the constants used for the db connection
require("constants.php");

// Gets the class id appended to url from teacherMainPage.php
$id = $_SESSION['username']; // Just a random variable gotten from the URL
$classId = $_SESSION['classId'];
$sessionTestId = $_SESSION['testId'];

if($id == null)
    header('Location: login.html');
    
// The database variable holds the connection so you can access it
$database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);
@ $database->select_db(DATABASENAME);

// Teacher first and last name to display on top right of screen
$topRightQuery = "select first_name, last_name from teacher where teacher_id = ?";

// Class ID and description at the top of the page
$mainClassQuery = "select class_id, class_description from class where class_id = ?";
$mainClassStatement = $database->prepare($mainClassQuery);

// Generate a test id
$testIdQuery = "select max(test_id), saved, question_id from test
				left join question using(test_id)
				where class_id = ?";

// Create a test
$createTestQuery = "insert into test(test_id, class_id, teacher_id) values(?, ?, ?)";

global $newTestId;
global $multipleChoiceInputId;
$multipleChoiceInputId = 0;
global $multipleChoiceRadioId;

$multipleChoiceRadioId = 0;

?>
<body>
	<div id="wrapper2">
	 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a href="#menu-toggle" class="navbar-brand" id="menu-toggle">
					<div id="logo-area">
						<img src="images/logo4.png" alt="Our Logo" height="45" width="45">
						<span class="TestRepublic">Test Republic</span>
					</div>
				</a>
			</div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php // Added by David Hughen
																												// to display student's name in top right corner
																								if ($topRightStatement = $database->prepare($topRightQuery)) 
                                                                                                {
                                                                                                    $topRightStatement->bind_param("s", $id);
                                                                        
                                                                                                }
                                                                                                else {
                                                                                                    printf("Errormessage: %s\n", $database->error);
                                                                                                }							
                                                                                                $topRightStatement->bind_result($first_name, $last_name);
                                                                                                $topRightStatement->execute();
                                                                                                while($topRightStatement->fetch())
                                                                                                {
                                                                                                    echo $first_name . " " . $last_name;
                                                                                                }
                                            
+											$topRightStatement->close();?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <!-- /.navbar-collapse -->
        </nav>
	</div>	
	
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
		<!-- Keep page stuff under this div! -->
            <div class="container-fluid">
                <div class="row">
					<div class="col-md-12" id="course_section">
						<?php
                        $mainClassStatement->bind_param("s", $classId);
                        $mainClassStatement->bind_result($clid, $clde);
                        $mainClassStatement->execute();
                        while($mainClassStatement->fetch())
                        {
                            echo '<div class="course_header">

                        <div class="course_number">'
                            . $clid .
                        '</div>
                        
                        <div class="class_name">'
                            . $clde . 
                        '</div>
                        </div>'; 
                        }
                        $mainClassStatement->close();
                        ?>
					</div>
				</div>
				
				
				<div class="row" id="test_section">
				
					<div class="col-md-4" id="test_information">
				
						<div class="test-info-text">
							Test Information
						</div>
					
						<label class="blocklabel">Test Name:
							<input type="text" placeholder="Test #1" />
						</label>
						
						<label class="date_lbl">Start Date:
							<input type="date" />
						</label>
						
						<label class="time_lbl">Time:
							<input type="time" />
						</label>
						
						<label class="date_lbl">End Date:&nbsp;
							<input type="date" />
						</label>
						
						<label class="time_lbl">Time:
							<input type="time" />
						</label>
						
						<label class="time_limit_lbl">Time Limit:
							<input type="number" /> minutes
						</label>
						
						<br />
						
						<label class="instruction_lbl">Specific Instruction:</label>
						<br />
						<textarea class="form-control" rows="6">Don't cheat!</textarea>
						<p id="test"> Foo </p> 
					
						
						<label class="pledge_lbl">Test Pledge:</label>

						<textarea class="form-control" rows="6"></textarea>
						
						<div class="row" id="upperButtons">
							<div class="col-md-6">
								<button type="button" class="btn btn-danger btn-block" id="cancelTestBtn">Cancel</button>
							</div>
							
							<div class="col-md-6">	
								<button type="button" class="btn btn-primary btn-block" id="saveTestBtn">Save</button>
							</div>
						</div>
						
						<button type="button" class="btn btn-success btn-block" id="createTestBtn">Create and Publish</button>
					</div>
					
					<div class="col-md-8" id="create_questions">
						<div class="create-questions-text">
							Create Questions
						</div>
					
						<div id="button_sections">
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#MCModal" data-title="MultipleChoice">
								<span class="glyphicon glyphicon-record"></span> Multiple Choice
							</button>

							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#TFModal" data-title="TrueFalse">
								<span class="glyphicon glyphicon-ok"></span> True/False 
							</button>
							
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#ATAModal" data-title="AllThatApply">
								<span class="glyphicon glyphicon-check"></span> All that Apply
							</button>
							
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#MatchModal" data-title="Matching" >
								<span class="glyphicon glyphicon-th-large"></span> Matching
							</button>
							
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#SAModal" data-title="ShortAnswer">
								<span class="glyphicon glyphicon-minus"></span> Short Answer
							</button>
							
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#EssayModal" data-title="Essay">
								<span class="glyphicon glyphicon-pencil"></span> Essay
							</button>
						</div>
						
						<div class="container-fluid">
							<div class="list-group" id ="testList">
							
							</div>
						</div>
					</div>		
                </div>
				
				<?php 
				// New test id
				if($sessionTestId == null)
				{
					$testIdStatement = $database->prepare($testIdQuery);
					$testIdStatement->bind_param("s", $classId);
					$testIdStatement->bind_result($tid, $saved, $questionId);
					$testIdStatement->execute();
					while($testIdStatement->fetch())
					{
					
						// Create a session variable with the test id
						$newTestId = $tid + 1;
						$_SESSION['testId'] = $newTestId;
					}
					$testIdStatement->close();
				}
				else
				{
					$newTestId = $sessionTestId;
				}
					
				$testCreateStatement = $database->prepare($createTestQuery);
				$testCreateStatement->bind_param("sss", $newTestId, $classId, $id);
                $testCreateStatement->execute();
				$testCreateStatement->close();
				
				
				?>
				
				<!-- Short Answer Modal -->
					<div id="SAModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Short Answer</h4>
								</div>
								<div class="modal-body">
									<form name="shortAnswerForm" id="shortAnswerForm" action="testCreationPage.php" method="post">
										<div class="form-group">
											<label for="recipient-name" class="control-label">Point Value:</label>
											<input type="text" class="form-control" id="short_answer_point_value">
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="short_answer_question">
											<label for="recipient-name" class="control-label">Answer:</label>
											<input type="text" class="form-control" id="short_answer_answer">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary" data-dismiss="modal" id="SABtn" name="create" value="create" >Create Question</button>
								</div>
							</div>
						</div>
					</div>
					
				<!-- Essay Modal -->
					<div id="EssayModal" class="modal hide fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Essay</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="form-group">
											<label for="recipient-name" class="control-label">Point Value:</label>
											<input type="text" class="form-control" id="essay_point_value">
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="essay_question">
											<label for="recipient-name" class="control-label">Answer:</label>
											<input type="text" class="form-control" id="essay_answer">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="EBtn" onclick="">Create Question</button>
								</div>
							</div>
						</div>
					</div>
					
				<!-- T/F Modal-->
					<div id="TFModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">True/False</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="form-group">
											<label for="recipient-name" class="control-label">Point Value:</label>
											<input type="text" class="form-control" id="tf_question_point_value" />
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="tf_question" />
										</div>
										
										<div class="form-group">
											<div class="radio">
												<label><input type="radio" class="optradio" name="optradio" value="true" />True</label>
											</div>
											<div class="radio">
												<label><input type="radio" class="optradio" name="optradio" value="false" />False</label>
											</div>
										</div>
										
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
											<button type="button" class="btn btn-primary" data-dismiss="modal" id="TFBtn" onclick="">Create Question</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				<!-- Multiple Choice Modal-->
					<div id="MCModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Multiple Choice</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="form-group">
											<label for="recipient-name" class="control-label">Point Value:</label>
											<input type="text" class="form-control" id="mc_point_value" />
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="mc_question" />
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label">Answer:</label>
											<br />
											<div class="row">
												<div class="col-md-1">
													<input type="radio" name="mc_answer0" id="mc_answer0" value="multipleRadio0" class="multipleRadio" />
												</div>
												<div class="col-md-11">
													<input type="text" class="form-control multipleTextboxes" id="multipleText0" name="multipleText0" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<div id="MC_add_answers">
												<div class="row">
													<div class="col-md-1">
														<input type="radio" name="mc_answer0" id="mc_answer1" value="multipleRadio1" class="multipleRadio" />
													</div>
													<div class="col-md-11">
														<input type="text" class="form-control multipleTextboxes" id="multipleText1" name="multipleText1"/>
													</div>
												</div>
											</div>
										</div>
									</form>
									<button type="button" class="btn btn-default" aria-hidden="true" id="add_MC">Add Item +</button>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="MCBtn">Create Question</button>
								</div>
							</div>
						</div>
					</div>
					
				<!-- All that Apply Modal-->
					<div id="ATAModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">All that Apply</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="form-group">
											<label for="recipient-name" class="control-label">Point Value:</label>
											<input type="text" class="form-control" id="ata_point_value" />
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="ata_question" />
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label">Answer:</label>
											<br />
											<input type="checkbox" name="ata_answer" id="ata_answer_cb0" class="ata_cb" />
											<input type="text" id="ata_answer0" class="ata_tb" />
										</div>
										<div class="form-group" id="ATA_AddAns">
											<div class="ata_margin">
												<input type="checkbox" name="ata_answer" id="ata_answer_cb1" class="ata_cb"/>
												<input type="text" id="ata_answer1" class="ata_tb" />
											</div>
										</div>
									</form>
									<button type="button" class="btn btn-default" aria-hidden="true" id="add_ATA">Add Item +</button>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="ATABtn" onclick="">Create Question</button>
								</div>
							</div>
						</div>
					</div>
					
				<!-- Matching Modal-->
					<div id="MatchModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Matching</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="row">
											<div class="col-md-10" id="add_match_question">
												<div class="form-group">
													<label for="recipient-name" class="control-label">Question:</label>
													<input type="text" class="form-control" id="match_question_tb0" />
												</div>
											</div>
											<div class="col-md-2" id="add_match_question_letter">
												<div class="form-group">
													<label for="recipient-name" class="control-label">Match:</label>
													<input type="text" class="form-control" id="match_question_letter_tb0" />
												</div>
											</div>
										</div>
										
										<button type="button" class="btn btn-default" aria-hidden="true" id="add_match_question_btn">Add Item +</button>
										
										<div class="row">
											<div class="col-md-10" id="add_match_answer">
												<div class="form-group">
													<label for="recipient-name" class="control-label">Answer:</label>
													<input type="text" class="form-control" id="match_answer_tb0" />
												</div>
											</div>
											<div class="col-md-2" id="add_match_answer_letter">
												<div class="form-group">
													<label for="recipient-name" class="control-label">Letter:</label>
													<input type="text" class="form-control" id="match_answer_letter_tb0" />
												</div>
											</div>
										</div>
										
									<button type="button" class="btn btn-default" aria-hidden="true" id="add_match_answer_btn">Add Item +</button>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="MBtn" onclick="">Create Question</button>
								</div>
							</div>
						</div>
					</div>				
			</div>    				
			</div>	

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
	
	<script>
	$(document).ready(function()
	{
		$("#SABtn").click(function()
		{
			var shortAnswerQuestion = $("#short_answer_question").val();
			var shortAnswerAnswer   = $("#short_answer_anwer").val();
			
			
			
		});
	});
	</script>
	
	<!-- Add matching JS -->
	<script>
		$(document).ready(function()
		{
			var c = 0;
			var d = 0;
			var a = 0;
			var b = 0;
			$("#add_match_answer_btn").click(function()
			{
				// Add the text box for a matching answer
				cloned = $('#match_answer_tb' + c );
				$("#match_answer_tb" + c).clone().attr('id', 'match_answer_tb'+(++c )).insertAfter(cloned);
			
				$("#match_answer_tb" + c ).text('match_answer_tb' + c );
				
				// Add the Letter box for the answer
				cloned = $('#match_answer_letter_tb' + d );
				$("#match_answer_letter_tb" + d).clone().attr('id', 'match_answer_letter_tb'+(++d )).insertAfter(cloned);
			
				$("#match_answer_letter_tb" + d ).text('match_answer_letter_tb' + d );
				
				/*$("#add_match_answer").append('<div class="add_margin_match"><input type="text" class="form-control" id="match_answer_tb"></div>');
				$("#add_match_answer_letter").append('<div class="add_margin_match"><input type="text" class="form-control" id="match_answer_letter_tb"></div>');
				*/
			});
			
			$("#add_match_question_btn").click(function()
			{
				// Add the text box for a matching question
				cloned = $('#match_question_tb' + a );
				$("#match_question_tb" + a).clone().attr('id', 'match_question_tb'+(++a )).insertAfter(cloned);
			
				$("#match_question_tb" + a ).text('match_question_tb' + a );
				
				// Add the Match box for the question
				cloned = $('#match_question_letter_tb' + b );
				$("#match_question_letter_tb" + b).clone().attr('id', 'match_question_letter_tb'+(++b )).insertAfter(cloned);
			
				$("#match_question_letter_tb" + b ).text('match_question_letter_tb' + b );
			});
		});
	</script>
	
		<!-- All that Apply JS -->
	<script>
		$(document).ready(function()
		{
			$("#add_ATA").click(function()
			{
				// adds text boxes to ata modal
				cloned = $('#ata_answer' + c);
				$("#ata_answer" + c).clone().attr('id', 'ata_answer'+(++c)).insertAfter(cloned);
			
				$("#ata_answer" + c).text('ata_answer' + c);
				
				
				cloned = $('#ata_answer_cb' + d );
				$("#ata_answer_cb" + d).clone().attr('id', 'ata_answer_cb'+(++d )).insertAfter(cloned);
			
				$("#ata_answer_cb" + d ).text('ata_answer_cb' + d );
				
				/*$("#ATA_AddAns").append('<div class="ata_margin"><input type="checkbox" name="ata_answer" id="ata_answer2" /><input type="text" id="ata_addtn_answer" class="ata_tb" /><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button></div>'
				); */
			});
		});
	</script>
	
		<!-- Multiple Choice JS -->
		<!-- PROBLEM: in every append, how to generate a different value & id -->
		<!-- class add_margin_mc doesnt work! :'( -->
	<script>
	var MCAnsArray = [];
	var MCBtnArray = [];
	var MCCounter = 0;
	var c = 1;
	var cloned;
	var stuff = [];
	var d = 1;
	
		$(document).ready(function(){
		
			$("#add_MC").click(function(){
			<!-- MCCounter++; -->
			
				// adds radio buttons to mc modal
				cloned = $('#mc_answer' + c);
				$("#mc_answer" + c).clone().attr('id', 'mc_answer'+(++c)).insertAfter(cloned);
			
				$("#mc_answer" + c).text('mc_answer' + c);
				
				// adds text boxes to mc modal
				cloned = $('#multipleText' + d );
				$("#multipleText" + d).clone().attr('id', 'multipleText'+(++d )).insertAfter(cloned);
			
				$("#multipleText" + d ).text('multipleText' + d );
				
			//$("#MC_add_answers").append('<div class="add_margin_mc"><div class="col-md-1"><input type="radio" name="mc_answer" class="multipleRadio" value=""  /></div><div class="col-md-9"><input type="text" class="form-control" id=cloned /></div><div class="col-md-2"><button type="button" class="btn btn-default btn-md" aria-hidden="true" id="remove_MC"><span class="glyphicon glyphicon-trash"></span></button></div></div>');
			
			
		});
	});
	
		$(document).ready(function(){
				$("#remove_MC").click(function(){
				MCArray.push('<input type="text" class="form-control" id="Question">');
				MCBtnArray.push(' <button type="button" class="btn btn-default" aria-hidden="true" id="remove_MC">remove item</button>');
			$("#MC_AddAns").append(MCArray[MCCounter]);
			$("#MC_AddAns").append(MCBtnArray[MCCounter]);
		});
	});
	</script>

	
	<script>	
		var counter = 0;
		var testId = '<?php echo $newTestId; ?>';
		
		
		$(document).ready(function()
		{
			
			/***********************************************************/
			/* Short answer stuff                                      */
			/***********************************************************/
			$("#SABtn").click(function()
			{
				var pointValue = $("#short_anwer_point_value").val();
				var question = $("#short_answer_question").val();
				var answer = $("#short_answer_answer").val();
				counter++;
			
				$.post("TestQuestionScripts/essayAndShortAnswer.php",
				{
					pointValue:pointValue,
					question:question,
					answer:answer,
					testId:testId,
					questionType:"Short Answer"
				},
				function(data)
				{
					document.getElementById("test").innerHTML = data;
				});
				
				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">'+ sa_question +'</h4> <p class="list-group-item-text">List Group Item Text</p></a>'
				);

			});
			
			/***********************************************************/
			/* Matching stuff                                          */
			/***********************************************************/
			$("#MBtn").click(function()
			{

				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">Matching</h4> <p class="list-group-item-text">List Group Item Text</p></a>'
				);
				counter++;

			});

			/***********************************************************/
			/* Multiple choice stuff                                   */
			/***********************************************************/
			$("#MCBtn").click(function(){
				var pointValue = $("#mc_point_value").val();
				var question = $("#mc_question").val();
				var multipleChoiceArray = [];
				var multipleTextArray = [];
				
				<!-- check for multiple choice radios -->
				var i = 0;
				$('.multipleRadio').each(function() {
					
					// If true, assign
					if($(this).is(':checked'))
					{
						multipleChoiceArray[i] = 1;
					  	
					}
					// Else false, assign
					else
					{
						multipleChoiceArray[i] = 0;				
					}
					i++;		
				});
				
				// Get and store the possible answers from the multiple choice type
				for(i = 0; i <= c; i++)
				{
					multipleTextArray[i] = document.getElementById("multipleText" + i).value;
				}
				
				
				$.post("TestQuestionScripts/multipleChoiceTrueFalseAllThatApply.php",
				{
					pointValue:pointValue,
					questionType:"Multiple Choice",
					question:question,
					"parameters[]":multipleChoiceArray,
					"textBoxes[]":multipleTextArray,
					testId:testId
				},
				function(data)
				{
					document.getElementById("test").innerHTML = data;
				});
				
				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">Multiple Choice</h4> <p class="list-group-item-text">List Group Item Text</p></a>'
				);
				counter++;
			});
			
			/***********************************************************/
			/* All that apply stuff                                    */
			/***********************************************************/
			$("#ATABtn").click(function(){
				var pointValue = $("#ata_point_value").val();
				var question = $("#ata_question").val();
				var ataArray = [];
				var ataTextArray = [];
				
				<!-- check for all that apply checkboxes -->
				var i = 0;
				$('.ata_cb').each(function() {
					
					// If true, assign
					if($(this).is(':checked'))
					{
						ataArray[i] = 1;
					  	
					}
					// Else false, assign
					else
					{
						ataArray[i] = 0;				
					}
					i++;		
				});
				
				// Get and store the possible answers from the multiple choice type
				for(i = 0; i <= c; i++)
				{
					ataTextArray[i] = document.getElementById("ata_answer" + i).value;
				}
				
				
				$.post("TestQuestionScripts/multipleChoiceTrueFalseAllThatApply.php",
				{
					pointValue:pointValue,
					questionType:"All That Apply",
					question:question,
					"parameters[]":ataArray,
					"textBoxes[]":ataTextArray,
					testId:testId
				},
				function(data)
				{
					document.getElementById("test").innerHTML = data;
				});
				
				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">All That Apply</h4> <p class="list-group-item-text">List Group Item Text</p></a>'
				);
				counter++;
			});
			
			
			/***********************************************************/
			/* True/false stuff                                        */
			/***********************************************************/
			$("#TFBtn").click(function(){
				var pointValue = $("#tf_question_point_value").val();
				var question = $("#tf_question").val();
				var trueFalseArray = [];
				var answerText = ["true", "false"];
				
				<!-- check for true/false radios -->
				var i = 0;
				$('.optradio').each(function() {
						 		 
					if($(this).is(':checked'))
					{
						trueFalseArray[i] = 1;
					 
					}
					else
					{
						trueFalseArray[i] = 0;				
					}
					i++;		
				});
			
				  
				
				$.post("TestQuestionScripts/multipleChoiceTrueFalseAllThatApply.php",
				{
					
					questionType:"True/False",
					pointValue:pointValue,
					question:question,
					"parameters[]":trueFalseArray,
					"textBoxes[]":answerText,
					testId:testId
					
				},
				function(data)
				{
					document.getElementById("test").innerHTML = data;
				});
				
				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">True/False</h4> <p class="list-group-item-text">List Group Item Text</p></a>'
				);
				counter++;
			});
			
			/***********************************************************/
			/* Essay stuff                                             */
			/***********************************************************/
			$("#EBtn").click(function(){
					
				var pointValue = $("#essay_point_value").val();
				var question = $("#essay_question").val();
				var answer = $("#essay_answer").val();
				counter++;
				
				$.post("TestQuestionScripts/essayAndShortAnswer.php",
				{
					pointValue:pointValue,
					question:question,
					answer:answer,
					testId:testId,
					questionType:"Essay"
				},
				function(data)
				{
					document.getElementById("test").innerHTML = data;
				});
				
				$("#testList").append('<a href="#" class="list-group-item"> <h4 class="list-group-item-heading">' + question + '</h4> <p class="list-group-item-text">' + answer + '</p></a>'
				);
			
			});
		});
	</script>

</body>

</html>
