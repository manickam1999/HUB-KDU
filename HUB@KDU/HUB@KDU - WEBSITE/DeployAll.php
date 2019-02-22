<?php
	include_once("connection.php");
if(isset($_SESSION['login']))
{
	if($_SESSION['login'] == "unset") //checks if session expired or user is trying to directly access the page before logging in
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
     <link rel="stylesheet" type="text/css" href="css/DeployAll.css">

<!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	

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
						<h4 class="modal-title">Input Empty</h4>
					</div>

					<div class="modal-body">
						<p>There are still some dropdowns empty, Please choose an option</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="popup-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Subject already exists</h4>
					</div>

					<div class="modal-body">
						<p>Choose another subject</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="subject-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">That is not a valid subject</h4>
					</div>

					<div class="modal-body">
						<p>Choose another subject</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
<div class="modal fade" id="sub-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">No Subjects Chosen</h4>
					</div>

					<div class="modal-body">
						<p>Please add some subjects before deploying</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

<!--DropDown Boxes Control -->
<form action="DeployAllSemester.php" method="get" id="deployForm">
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
		<select class="form-control form-control-lg" onchange="removeFirst('intake'); changeSubjectList();" id="intakeDropdown" name="Intake" required></select>
	</div>

	<br>
	<br>

	<label>Current Subjects</label>
        <select id="subjectsNowList" class="form-control form-control-lg" size="6">
       </select> 
    <input type="button" value="Delete"  onclick="deleteSubject()" name="Delete" class="buttonConfirm">
    <br>
    <br>
	
	<label>Add Subject : </label>
         <select id="subjectDropdown" onchange="removeFirst('subject')" class="form-control form-control-lg">
         </select>
    <input type="button" value="Add" name="Add" onclick="addSubject()" class="buttonConfirm">
	<br>
	<br>

	<label>Payment Amount : </label>
         <label id="PaymentAmount">0</label>
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



<input type="hidden" value="" id="subject1" name="subject1">
<input type="hidden" value="" id="subject2" name="subject2">
<input type="hidden" value="" id="subject3" name="subject3">
<input type="hidden" value="" id="subject4" name="subject4"> <!-- holds the data in the form to be submitted later -->
<input type="hidden" value="" id="subject5" name="subject5">
<input type="hidden" value="" id="subject6" name="subject6">
<input type="hidden" value="" id="SubjectTotal" name="SubjectTotal">
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
var total = 0;
var deptsAndCourses = {};
var coursesAndIntakes = {};
<?php 
	$db = db_connect();
	$departmentQuery = "SELECT * FROM department";
	$departmentResult = mysqli_query($db,$departmentQuery);
	while($row = mysqli_fetch_array($departmentResult))
	{
		$courseQuery = "SELECT * FROM course WHERE DeptId=".$row['DeptId']; //loads out courses related to what departments
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
		$intakeQuery = "SELECT DISTINCT(IntakeDate) AS IntakeDate FROM students WHERE CourseId=".$row['CourseId']." ORDER BY IntakeDate"; //loads out all intakes in a certain course
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
    var deptList = document.getElementById("deptDropdown"); //changes the courses dropdown when a department is selected
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
    var courseList = document.getElementById("courseDropdown"); //changes the intake dropdown when a course is selected
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

function changeSubjectList()
{
	var courseList = document.getElementById("courseDropdown"); //changes the subjects once an intake is selected
	var subjectList = document.getElementById("subjectDropdown");
	var intakeList = document.getElementById("intakeDropdown");
	$.ajax({
            url:"loadSubjects.php", //the page containing php script
            type: "get", //request type
            data: {course : courseList.options[courseList.selectedIndex].value, intake: intakeList.options[intakeList.selectedIndex].value},
			success : function(arr)
			{
				while (subjectList.options.length) 
				{
					subjectList.remove(0);
				}
				var count = Object.keys(arr).length;
				var i;
				var first = new Option("Choose One", "");
				subjectList.options.add(first);
				for(i = 0; i < count; i++)
				{
					var subject = new Option(arr[i].SubCode +"-"+ arr[i].SubName +"-RM"+ arr[i].SubPrice, arr[i].SubId);
					subjectList.options.add(subject);
				}
			}
         });
}

function removeFirst(drop)
{
	var list = document.getElementById(drop+"Dropdown"); // used to remove the Choose One option
	if(list.options[0].value == "")
	{
		list.remove(0);
	}
}

function resubmitForm()
{
	$("#refresh").submit(); //resubmit the form when error msges popup
}

function deployForm()
{
	selectBox = document.getElementById("subjectsNowList");
	var no = 0;
	for (var i = 0; i < selectBox.options.length; i++) 
	{ 
		no++;
		$("#subject"+(i+1)).val(selectBox.options[i].value);
	}
	$("#SubjectTotal").val(no);
	if($("#PayEndDate").val() == "")
		$("#date-Modal").modal();
	else if($("#SemStartDate").val() == "")
		$("#date-Modal").modal();
	else if($("#SemEndDate").val() == "")
		$("#date-Modal").modal();
	else if($("#subject1").val() == "")
		$("#sub-Modal").modal();
	else if($("#intakeDropdown").val() == "")
		$("#input-Modal").modal();
	else
		$("#deployForm").submit();
}

function addSubject()
{	
	var val = $("#subjectDropdown").val();
	if($("#subjectsNowList option[value='"+val+"']").length > 0) //used to add a subject to the list
		$("#popup-Modal").modal();
	else
	{
		if(!val)
		{

			$("#subject-Modal").modal();
			return;
		}
		$("#subjectsNowList").append(new Option($("#subjectDropdown :selected").text(), $("#subjectDropdown").val()));
		var str = $("#subjectDropdown :selected").text();
		var priceArr = str.split("-RM");
		total += parseInt(priceArr[1]);
		$("#PaymentAmount").text(total);
	}	
}

function deleteSubject()
{
	var str = $("#subjectsNowList :selected").text();
	if(str == "")
	{
		return;
	} //vice versa delete a subject from list once selected 
	var priceArr = str.split("-RM");
	total -= parseInt(priceArr[1]);
	$("#PaymentAmount").text(total);
	var val = $("#subjectsNowList").val();
	$("#subjectsNowList option[value='"+val+"']").remove();
}
	









	
</script>
</body>

</html>