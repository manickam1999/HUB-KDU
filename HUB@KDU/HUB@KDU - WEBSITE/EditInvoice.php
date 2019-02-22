<?php 
	//this sql here is to pull student data based on the student id and sem number given to load out
	//the whole php file in general is used to edit a certain invoice of a student
	include_once("connection.php");
	$db = db_connect();
	if(!$db)
		echo "failed";
	$studentId = $_GET['studentId'];
	$semNo = $_GET['semNo'];
	$studentQuery = "SELECT * FROM students INNER JOIN course ON students.CourseId=course.CourseId WHERE StudentId='".$studentId."'";
	$studentData = mysqli_query($db,$studentQuery);
	$student = mysqli_fetch_array($studentData);
	$semQuery = "SELECT * FROM semestercount WHERE StudentId = '".$studentId."' AND SemNo = ".$semNo;
	$semData = mysqli_query($db,$semQuery);
	$sem= mysqli_fetch_array($semData);
	$subQuery = "SELECT * FROM semester INNER JOIN subjects ON semester.SubId = subjects.SubId WHERE StudentId = '".$studentId."' AND SemNo = ".$semNo;
	$subResult = mysqli_query($db,$subQuery);
	$allSubQuery = "SELECT * FROM coursesubjects INNER JOIN subjects ON coursesubjects.SubId = subjects.SubId WHERE CourseId=".$student['CourseId']." OR CourseId=6";
	$allSubResult = mysqli_query($db,$allSubQuery);
	$total = 650;
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
<!-- Bootstrap core CSS & CSS link file for InformationModifcation-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="css/EditInvoice.css" >
	
    
<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


</head>

<div class="modal fade" id="popup-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Duplicate subject detected</h4>
					</div>

					<div class="modal-body">
						<p>This subject has already been added, add another subject!</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

<body>

    <?php include("Sidebar.php");?>

    

        
        <div id="mainPage-wrapper">
            <div class="container-fluid">
            	<p id="Menu" onclick="openNav()">&#9776;</p>
                <h1>HIT THE GROUND RUNNING</h1>
            </div>
        </div>
        <!-- /#mainPage-wrapper -->

    </div>
    <!-- /#wrapper -->

<!-- Edit Invoice Content !-->
    <div id="edit-invoice" class="tab-contents">
       <div class="container">
         <div class="row">
            <div class="col-md-4">
               <div class="create_form">
               	  <div class="main-div">
                  <h4 class="heading"><strong>Edit Invoice</strong></h4>
                    <div class="form">
                       <form action="editSQL.php" method="get" id="editForm" name="editForm">

                           <label>Student ID :</label>
						   <input type="hidden" value="<?php echo $student['StudentId'];?>" name="StudentId"/>
                           <label id="StudentID"><?php echo $student['StudentId'];?></label>
                           <br>
                           <br>

                           <label>Student Name :</label>
                           <label id="StudentName"><?php echo $student['StudentFirstName']." ".$student['StudentMidName']." ".$student['StudentLastName'];?></label>
                           <br>
                           <br>
						   <input type="hidden" value="<?php echo $semNo;?>" name="SemNo"/>
						   <label>Semester No : <?php echo $semNo;?></label>
						   <br>
						   <br>
                           <label>Invoice Date :</label>
                           <br>
                           <input type="date" id="InvoiceDate" name="InvoiceDate" value="<?php echo $sem['PayStartDate'];?>" class="txt">
                           <br>
                           <br>
                           <label>Programme :</label>
                           <label id="Programme"><?php echo $student['CourseName'];?></label>
                           <br>
                           <br>

                           <label>Intake :</label>
                           <label id="Intake"><?php echo $student['IntakeDate'];?></label>
                           <br>
                           <br>

                           <label>Semester Start</label>
                           <br>
                           <input type="date" name="SemesterStart" class="txt" value="<?php echo $sem['SemStartDate'];?>">
                           <br>
                           <br>

                           <label>Semester End</label>
                           <br>
                           <input type="date" name="SemesterEnd" class="txt" value="<?php echo $sem['SemEndDate'];?>">
                           <br>
                           <br>

                           <label>Payment Date</label>
                           <br>
                           <input type="date" name="PaymentDate" id="PaymentDate" class="txt" value="<?php echo $sem['PayEndDate'];?>">
                           <br>
                           <br>
                           <label>Current Subjects</label>
                           <select id="subjectsNow" class="form-control form-control-lg" size="6">
								<?php 
									while($row = mysqli_fetch_array($subResult))
									{
										$total += $row['SubPrice'];
										echo '<option value="'.$row['SubId'].'">'.$row['SubCode'].'-'.$row['SubName'].'-RM'.$row['SubPrice'].'</option>';
									}
								?>
                           </select> 
						   <input type="button" value="Delete" onclick="deleteSubject()" name="Delete" class="buttonConfirm">
						   <br>
						   <br>
						   <label>Add Subject : </label>
						   <select id="subjectAdd" class="form-control form-control-lg">
								<?php
									while($row = mysqli_fetch_array($allSubResult))
									{
										echo '<option value="'.$row['SubId'].'">'.$row['SubCode'].'-'.$row['SubName'].'-RM'.$row['SubPrice'].'</option>';
									}
								?>
						   </select>
                           <input type="button" value="Add" name="Add" onclick="addSubject()" class="buttonConfirm">
                           <br>
							<br>
							<label>Payment Amount : </label>
                           <label id="PaymentAmount"><?php echo $total;?></label>
						   <br>
						   <br>
                           <label>Payment Status : <?php echo $sem['PaymentStatus'];?></label>
						   <br>
                           <br>
						   <label>New Payment Status : </label>
						   <br>
                           <select class="form-control form-control-lg" name="PaymentStatus" required id="newPaymentStatus">
                                 <option value="PAID" <?php if($sem['PaymentStatus'] == "PAID") { echo "selected"; } ?>>Paid</option>
                                 <option value="PENDING" <?php if($sem['PaymentStatus'] == "PENDING") { echo "selected"; } ?>>Pending</option>
                                 <option value="LATE" <?php if($sem['PaymentStatus'] == "LATE") { echo "selected"; } ?>>Late</option>
                           </select>
						   <br>
						   <br>
						   <label>Retake Status : <?php if($sem['Retake'] == 1) { echo "Yes"; } else { echo "No";} ?></label>
						   <br>
						   <br>
						   <label>New Retake Status : </label>
						   <br>
						   <select name="RetakeStatus" class="form-control form-control-lg" name="RetakeStatus" id="newRetakeStatus" required>
								<option value="1"<?php if($sem['Retake'] == 1) { echo "selected"; }?>>Yes</option>
								<option value="1"<?php if($sem['Retake'] == 0) { echo "selected"; }?>>No</option>
							</select>
						   <br>
						   <br>
						   <input type="submit" value="Update" name="Update" onclick="updateData()" class="buttonConfirm">
						   <input type="hidden" value="" id="subject1" name="subject1">
						   <input type="hidden" value="" id="subject2" name="subject2">
						   <input type="hidden" value="" id="subject3" name="subject3">
						   <input type="hidden" value="" id="subject4" name="subject4">
						   <input type="hidden" value="" id="subject5" name="subject5">
						   <input type="hidden" value="" id="subject6" name="subject6">
						   <input type="hidden" value="" id="SubjectTotal" name="SubjectTotal">
                      </form>
                   </div>
               </div>
            </div>
         </div>
     </div>
  </div>
</div>

<br><br><br>

 <!-- Menu Toggle Script -->
<script>
var total = <?php echo $total;?>;
    function openNav() {
    document.getElementById("sidebar-wrapper").style.width = "250px";
    }

function closeNav() {
    document.getElementById("sidebar-wrapper").style.width = "0";
}

function addSubject()
{	
	var val = $("#subjectAdd").val();
	if($("#subjectsNow option[value='"+val+"']").length > 0)
		$("#popup-Modal").modal();
	else
	{
		$("#subjectsNow").append(new Option($("#subjectAdd :selected").text(), $("#subjectAdd").val()));
		var str = $("#subjectAdd :selected").text();
		var priceArr = str.split("-RM");
		total += parseInt(priceArr[1]);
		$("#PaymentAmount").text(total);
	}	
}

function deleteSubject()
{
	var str = $("#subjectsNow :selected").text();
	var priceArr = str.split("-RM");
	total -= parseInt(priceArr[1]);
	$("#PaymentAmount").text(total);
	var val = $("#subjectsNow").val();
	$("#subjectsNow option[value='"+val+"']").remove();
}

function updateData()
{
    selectBox = document.getElementById("subjectsNow");
	var no = 0;
	for (var i = 0; i < selectBox.options.length; i++) 
	{ 
		no++;
		 $("#subject"+(i+1)).val(selectBox.options[i].value);
	}
	$("#SubjectTotal").val(no);
	$("#editForm").submit();
}	
</script>
</body>
</html>