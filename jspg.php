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

    <title>JS/AJAX/PHP attempt 1</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/teacher-create-test.css" rel="stylesheet">
	
<<<<<<< HEAD
   <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Custom Test Creation JavaScript --> 
	<script src="js/testCreation.js"></script>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

=======
	
	$shortAnswer = (isset($_POST['shortAnswer']) ? $_POST['shortAnswer'] : " ");
	
	$myFile = fopen("textFile.json", "w");
	while(!eof($myFile))
	{
		fwrite($myFile, $shortAnswer);
	}
	fclose($myFile);
>>>>>>> development
	
		<script>

		var answerArray = [ {"Answer" : "woof"}, {"Answer" : "oink"}];
		
		$(document).ready(function(){
		$("#ATABtn").click(function(){
				var question = $("#ata_question").val();
				var answer = $("#ata_answer1_tb").val();
				
			$.post("jspg.php",
			{
				var1:question,
				var2:answer
			}function(data)
				alert("meow " + data));
		});	
	});
	</script>
	
<<<<<<< HEAD
</head>


<body>

		<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#ATAModal" data-title="AllThatApply">
			<span class="glyphicon glyphicon-check"></span> All that Apply
		</button>
		
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
											<label for="recipient-name" class="control-label">Question:</label>
											<input type="text" class="form-control" id="ata_question" />
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label">Answer:</label>
											<br />
											<input type="checkbox" name="ata_answer" id="ata_answer1_cb" />
											<input type="text" id="ata_answer1_tb" class="ata_tb" />
										</div>
										<div class="form-group" id="ATA_AddAns">
											<div class="ata_margin">
												<input type="checkbox" name="ata_answer" id="ata_answer2_cb" />
												<input type="text" id="ata_answer2_tb" class="ata_tb" />
											</div>
										</div>
									</form>
									<button type="button" class="btn btn-default" aria-hidden="true" id="add_ATA">Add Item +</button>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" id="ATABtn">Create Question</button>
								</div>
							</div>
						</div>
					</div>
					<?php
						@$var1 = $_POST["var1"];
						@$var2 = $_POST["var2"];
						
						echo '<h1>'.$var1.'</h1>';
					
					?>
		
		
		
		

</body>





</html>
=======
	
	
	
?>
>>>>>>> development
