<?php 
	//php script used to pull all the semesters data of a student and then send it to the requesting mobile app using json
	$db = mysqli_connect("localhost","saints","RDEFZxYLULPcsv8F","saints");
	$studentId = $_POST['StudentId'];
	$getSemesterQuery = "SELECT * FROM semestercount WHERE StudentId='".$studentId."'";
	$getStudentQuery = "SELECT * FROM students INNER JOIN course ON students.CourseId = course.CourseId WHERE StudentId='".$studentId."'";
	$checkLateQuery = "UPDATE semestercount SET PaymentStatus = 'LATE' WHERE PayEndDate < CURDATE()";
	mysqli_query($db,$checkLateQuery);
	$semesterResult = mysqli_query($db,$getSemesterQuery);
	$studentResult = mysqli_query($db,$getStudentQuery);
	$student = mysqli_fetch_array($studentResult);
	$invoices = array();
	foreach($semesterResult as $semester)
	{
		$invoiceData = new \stdClass();
		$invoiceData->Name = $student['StudentFirstName']." ".$student['StudentMidName']." ".$student['StudentLastName'];
		$invoiceData->SemNo = $semester['SemNo'];
		$invoiceData->ID = $student['StudentId'];
		$invoiceData->SemStart = $semester['SemStartDate'];
		$invoiceData->SemEnd = $semester['SemEndDate'];
		$invoiceData->PayStart = $semester['PayStartDate'];
		$invoiceData->PayEnd = $semester['PayEndDate'];
		$invoiceData->PayStatus = $semester['PaymentStatus'];
		$invoiceData->CourseName = $student['CourseName'];
		$allSubData = array();
		$subQuery = "SELECT * FROM semester INNER JOIN subjects ON semester.SubId = subjects.SubId WHERE StudentId='".$studentId."' AND SemNo=".$semester['SemNo'];
		$subResult = mysqli_query($db,$subQuery);
		while($row = mysqli_fetch_array($subResult))
		{
			$subData = new \stdClass();
			$subData->SubCode = $row['SubCode'];
			$subData->SubName = $row['SubName'];
			$subData->SubPrice = $row['SubPrice'];
			$allSubData[] = $subData;
		}
		$invoiceData->AllSubData = $allSubData;
		$invoices[] = $invoiceData;
	}
	header("Content-Type: application/json");
	echo json_encode($invoices);
?>
		
	
