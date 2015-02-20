<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	   <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<?php

session_start();

// Include the constants used for the db connection
require("constants.php");

$id = $_SESSION['username'];



if($id == null)
    header('Location: login.html');
    
// The database variable holds the connection so you can access it
$database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);
@ $database->select_db(DATABASENAME);

if (mysqli_connect_errno())
{
   echo "<h1>Connection error</h1>";
}

// Query to populate the first table on the screen
$firstTableQuery = "select test_name, avg(test_score) from test_list
join test using(test_id)
where class_id = ?
group by(test_name)";

// Teacher first and last name to display on top right of screen
$topRightQuery = "select first_name, last_name from teacher where teacher_id = ?";


$firstTableStatement = $database->prepare($firstTableQuery);


?>

<body>
	<div id="wrapper2"
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php  // Added by David Hughen
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
																												$topRightStatement->close(); ?><b class="caret"></b></a>
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
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <!-- /.navbar-collapse -->
        </nav>
	</div>	
	
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
				<li>
                    <a href="#" id="student-summary">Summary</a>
                </li>
                <li class="sidebar-brand">
                    Select a Class:
                </li>
                <li>
                    <a href="#">
						<h1><?php echo $_GET['id'];?></h1>
						<div class="subject-name">New Testament Survey</div>
					</a>
                </li>
                <li>
                    <a href="#">
						CS 130-2
						<div class="subject-name">Intro to Computers</div>
					</a>
                </li>
                <li>
                    <a href="#">
						CS 202
						<div class="subject-name">Intro to Programming</div>
					</a>
                </li>
                <li>
                    <a href="#">
						EN 121-5
						<div class="subject-name">English Grammar & Comp.</div>
					</a>
                </li>
				<li>
                    <a href="#">
						HI 101-5
						<div class="subject-name">History of Civilization</div>
					</a>
                </li>
			
            </ul>
        </div>
		
        <!-- /#sidebar-wrapper -->
		<div class="course_header">
			<div class="course_number">
				CS 130-2
			</div>
			
			<div class="class_name">
				Introduction to Computers
			</div>
		</div>
		
        <!-- Page Content -->
        <div id="page-content-wrapper">
		<!-- Keep page stuff under this div! -->
            <div class="container-fluid">
                <div class="row">
				
					<div class="students_num_text">
						No of Students:
						<span class="students_number">30</span>
					</div>
					
					<button type="button" class="create_test_button">Create Test</button>
					
					<div class="test_list_text">
						Test List
					</div>
					
					<table class="test_list">
						<colgroup>
							<col class="test_name" />
							<col class="test_average" />
							<col class="view_button_col" />
						</colgroup>
					
						<thead>
						<tr>
							<th>Test Name</th>
							<th>Average</th>
							<th>View Test</th>
						</tr>
						</thead>
						
						<tbody>
						<tr>
							<td>Test #1</td>
							<td>78</td>
							<td><button type="button" class="view_test_button">View</button></td>
						</tr>
						<tr>
							<td>Test #2</td>
							<td>80</td>
							<td><button type="button" class="view_test_button">View</button></td>
						</tr>
						<tr>
							<td>Midterm Exam</td>
							<td>85</td>
							<td><button type="button" class="view_test_button">View</button></td>
						</tr>
						
						</tbody>
					
					</table>
					
					<div class="student_list_text">
						Student List
					</div>
					
					<table class="student_list">			
						<tr class="student_list_header">
							<td>First Name</td>
							<td>Last Name</td>
							<td>Test #1</td>
							<td>Test #2</td>
							<td>Midterm Exam</td>
							<td>Average Grade</td>
						</tr>
						
						<tr class="odd_row">
							<td>Anna</td>
							<td>Smith</td>
							<td>78</td>
							<td>70</td>
							<td>80</td>
							<td>...</td>
						</tr>
						<tr>
							<td>Bob</td>
							<td>Jones</td>
							<td>80</td>
							<td>70</td>
							<td><button type="button" class="grade_test_button">Grade</button></td>
							<td>75</td>
						</tr>
						<tr class="odd_row">
							<td>Carol</td>
							<td>Lie</td>
							<td>85.5</td>
							<td class="failing_grade">59</td> <!-- If grade=='F', it should be red -->
							<td>Not taken</td>
							<td>...</td>
						</tr>
						<tr>
							<td>Daniel</td>
							<td>Jones</td>
							<td>80</td>
							<td>65</td>
							<td><button type="button" class="grade_test_button">Grade</button></td>
							<td>72.5</td>
						</tr>
					
					</table>
					
					
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

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
