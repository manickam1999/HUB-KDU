<?php
	//A method to deploy a specific student's invoice incase of mishaps or unusual scenarios
	include_once("connection.php");
	$show_modal = false;
	if(isset($_GET['exists']))
	{
		if($_GET['exists'] == "exists")
		{
			$show_modal = true;
		}
	}
if(isset($_SESSION['login']))
{
	if($_SESSION['login'] == "unset")
	{	
		header("location:Login.php?login=not");
	}
}
else
{
	header("location:Login.php?login=not");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Hub@KDU.html</title>

    <!-- Bootstrap core CSS & css link file for InvoiceSetting-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
     <link rel="stylesheet" type="text/css" href="css/DeployOne.css">

<!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<?php if($show_modal) { ?>
		<script type='text/javascript'> $(function(){$('#popup-Modal').modal();}); </script>
		<!-- Modal -->
		<div class="modal fade" id="popup-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Semester detected</h4>
					</div>

					<div class="modal-body">
						<p>The selected semester already exists for this student</p>
					</div>

					<div class="modal-footer">
						<button type="button" onclick="resubmitForm()" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

</head>

<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="refresh">
</form>

<?php include("Sidebar.php"); ?>

        <div id="mainPage-wrapper">
            <div class="container-fluid">
            	<p id="Menu" onclick="openNav()">&#9776;</p>
                <h1>HIT THE GROUND RUNNING</h1>
            </div>
        </div>
        <!-- /#mainPage-wrapper -->

    </div>
    <!-- /#wrapper -->
    <br>
	
	<div class="modal fade" id="date-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">No date detected</h4>
					</div>

					<div class="modal-body">
						<p>Please input a date</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
<div class="modal fade" id="input-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Inputs Empty</h4>
					</div>

					<div class="modal-body">
						<p>There are still some dropdowns not selected, please choose an option</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

<!--DropDown Boxes Control -->
<form action="DeploySemester.php" method="get" id="deployForm">
    <div class="main-div">
	  <div class="row">
        <div class="department-container">
  	      <label for="deptDropdown" id="test">Department:</label>
              <select class="form-control form-control-lg" name="Department" id="deptDropdown" onchange="changeCourseList()" required>
		           <option value="">Choose One</option>
                     <?php
			             $db = db_connect();
			             $departmentQuery = "SELECT * FROM department";
			             $departmentResult = mysqli_query($db,$departmentQuery);
			             while($row = mysqli_fetch_array($departmentResult))
			            {
				         echo "<option value='".$row['DeptId']."'>".$row['DepartmentName']."</option>";
			            }         
		             ?>
             </select>
         </div>
    <br>
    <br>

	<div class="course-container">
		<label for="courseDropdown">Course:</label>
		<select class="form-control form-control-lg" onchange="changeIntakeList()" id="courseDropdown" name="Course" required></select>
	</div>
	<br>
	<br>

	<div class="intake-container">
		<label for="intakeDropdown">Intake:</label>
		 <select class="form-control form-control-lg" onchange="changeStudentList()" id="intakeDropdown" name="Intake" required></select>
	</div>
	<br>
	<br>

	<div class="student-container">
		<label for="studentDropdown">Student Id :</label>
		 <select class="form-control form-control-lg" onchange="removeFirst('student')" id="studentDropdown" name="Student" required></select>
	</div>
	<br>
	<br>

	<div class="sem-container">
		<label for="semesterDropdown">Semester</label>
		<br>
		<select class="form-control form-control-lg" id="semDropdown" onchange="removeFirst('sem')" name="Semester" required>
			<?php 
				for($i = 0; $i < 11; $i++)
				{
					if($i == 0)
						echo "<option value=\"\" selected>Choose one</option>";
					else
						echo "<option value=\"".$i."\">".$i."</option>";
				}
			?>
		</select>
	</div>
	<br>
	<br>

	<div class="paystat-container">
		<label for="paystatDropdown">Payment Status : </label>
		<br>
		<select class="form-control form-control-lg" id="paystatDropdown" onchange="removeFirst('paystat')" name="paystat" required>
			<option value="">Choose One</option>
			<option value="PENDING">PENDING</option>
			<option value="PAID">PAID</option>
			<option value="LATE">LATE</option>
		</select>
	</div>
	<br>
	<br>

	<div class="retake-container">
		<label for="retakeDropdown">Retake :</label>
		<br>
		<select class="form-control form-control-lg" id="retakeDropdown" name="Retake" required>
			<option value="1"> Yes </option>
			<option value="0" selected> No </option>
		</select>
	</div>
	<br>
	<br>

	<div class="date-container">
		<label for="PayStartDate">Invoice Due Date :</label>
		<br>
		<input type="date" name="datePay" id="PayEndDate">
	</div>
	<br>
	
	<div class="date-container">
		<label for="SemStartDate">Semester Starting Date :</label>
		<br>
		<input type="date" name="dateStart" id="SemStartDate">
	</div>
	<br>
	
	<div class="date-container">
		<label for="SemEndDate">Semester Ending Date :</label>
		<br>
		<input type="date" name="dateEnd" id="SemEndDate">
	</div>
	<br>
</div>
<input type="submit" id="submitBtn" class="hide">

</form>
	
</div>

<div class="button-container">
       <input type="submit" value="Deploy" onclick="deployForm()" class="buttonConfirm">
    </div>
<!-- Menu Toggle Script -->
<script>
function openNav() {
    document.getElementById("sidebar-wrapper").style.width = "250px";
}

function closeNav() {
    document.getElementById("sidebar-wrapper").style.width = "0";
}
</script>
<script>
var deptsAndCourses = {};
var coursesAndIntakes = {};
<?php 
	$db = db_connect();
	$departmentQuery = "SELECT * FROM department";
	$departmentResult = mysqli_query($db,$departmentQuery);
	while($row = mysqli_fetch_array($departmentResult))
	{
		$courseQuery = "SELECT * FROM course WHERE DeptId=".$row['DeptId']; //load out all Department Course and Intake related data 
		$courseResult = mysqli_query($db,$courseQuery);
		echo "deptsAndCourses['".$row['DeptId']."']=[";
		while($courseRow = mysqli_fetch_array($courseResult))
		{
			echo "'".$courseRow['CourseName']."',";
		}
		echo "];
";
	}
	
	$courseQuery = "SELECT * FROM course";
	$courseResult = mysqli_query($db,$courseQuery);
	while($row = mysqli_fetch_array($courseResult))
	{
		$intakeQuery = "SELECT DISTINCT(IntakeDate) AS IntakeDate FROM students WHERE CourseId=".$row['CourseId']." ORDER BY IntakeDate";
		$intakeResult = mysqli_query($db,$intakeQuery);
		echo "coursesAndIntakes['".$row['CourseName']."']=[";
		while($intakeRow = mysqli_fetch_array($intakeResult))
		{
			echo "'".$intakeRow['IntakeDate']."',";
		}
		echo "];
";
	}
	
?>




function changeCourseList() 
{
    var deptList = document.getElementById("deptDropdown");
    var courseList = document.getElementById("courseDropdown");
	if(deptList.options[0].value == "")
	{
		deptList.remove(0);
	}
    var selDept = deptList.options[deptList.selectedIndex].value;
    while (courseList.options.length) {
        courseList.remove(0);
    }
    var courses = deptsAndCourses[selDept];
    if (courses) 
	{
		var first = new Option("Choose One", "");
		courseList.options.add(first);
        var i;
        for (i = 0; i < courses.length; i++) 
		{
			var course = new Option(courses[i], courses[i]);
            courseList.options.add(course);
        }
    }
}

function changeIntakeList() 
{
    var courseList = document.getElementById("courseDropdown");
    var intakeList = document.getElementById("intakeDropdown");
	if(courseList.options[0].value == "")
	{
		courseList.remove(0);
	}
    var selCourse = courseList.options[courseList.selectedIndex].value;
    while (intakeList.options.length) {
        intakeList.remove(0);
    }
    var intakes = coursesAndIntakes[selCourse];
    if (intakes) 
	{
		var first = new Option("Choose One", "");
		intakeList.options.add(first);
        var i;
        for (i = 0; i < intakes.length; i++) 
		{
			var intake = new Option(intakes[i], intakes[i]);
            intakeList.options.add(intake);
        }
    }
}

function changeStudentList()
{
	var courseList = document.getElementById("courseDropdown");
    var intakeList = document.getElementById("intakeDropdown");
	var studentList = document.getElementById("studentDropdown");
	if(intakeList.options[0].value == "")
	{
		intakeList.remove(0);
	}
	$.ajax({
            url:"loadStudents.php", //the page containing php script
            type: "get", //request type
            data: {course : courseList.options[courseList.selectedIndex].value, intake: intakeList.options[intakeList.selectedIndex].value},
			success : function(data)
			{
				while (studentList.options.length) {
					studentList.remove(0);
				}	
				var count = Object.keys(data).length;
				var i;
				var first = new Option("Choose One", "");
				studentList.options.add(first);
				for(i = 0;i < count;i++)
				{
					var id = new Option(data[i],data[i]);
					studentList.options.add(id);
				}
			}
         });
}

function removeFirst(drop)
{
	var list = document.getElementById(drop+"Dropdown");
	if(list.options[0].value == "")
	{
		list.remove(0);
	}
}

function resubmitForm()
{
	$("#refresh").submit();
}

function deployForm()
{
	if($("#PayEndDate").val() == "")
		$("#date-Modal").modal();
	else if($("#SemStartDate").val() == "")
		$("#date-Modal").modal();
	else if($("#SemEndDate").val() == "")
		$("#date-Modal").modal();
	else if($("#paystatDropdown").val() == "" || $("#semesterDropdown").val() == "")
		$("#input-Modal").modal();
	else
		$("#deployForm").submit();
}
	
</script>
</body>

</html>