<?php
	//Will take in Intake,Course and Subjecct data to mass deploy invoices
	include_once("connection.php");
	$db = db_connect();
	$intake = $_GET['Intake']; 
	$semCheckQuery = "SELECT MAX(SemNo) AS CurrentSem FROM semestercount 
						INNER JOIN students ON semestercount.StudentId = students.StudentId 
						INNER JOIN course ON students.CourseId = course.CourseId 
						WHERE students.IntakeDate ='".$intake."' AND course.CourseName='".$_GET['Course']."'";
	$semCheckResult = mysqli_query($db,$semCheckQuery);
	$row = mysqli_fetch_array($semCheckResult);
	$currentSem = $row['CurrentSem'];
	$nextSem = (int)$currentSem + 1;
	$PayEndDate = $_GET['datePay'];
	$Course = $_GET['Course'];
	$PayStartDate = date("Y-m-d");
	$SemStartDate = $_GET['dateStart'];
	$SemEndDate = $_GET['dateEnd'];
	$Subjects = array($_GET['subject1'],$_GET['subject2'],$_GET['subject3'],$_GET['subject4'],$_GET['subject5'],$_GET['subject6']);
	$CourseIdQuery = "SELECT CourseId FROM course WHERE CourseName='".$Course."'";
	$CourseIdResult = mysqli_query($db,$CourseIdQuery);
	$courseRow = mysqli_fetch_array($CourseIdResult);
	$CourseId = $courseRow['CourseId'];
	$studentIntakeQuery = "SELECT StudentId FROM students WHERE IntakeDate='".$intake."' AND CourseId=".$CourseId;
	$studentIntakeResult=mysqli_query($db,$studentIntakeQuery);
	while($student = mysqli_fetch_array($studentIntakeResult))
	{
		$addSemQuery = "INSERT INTO semestercount (StudentId,SemNo,SemStartDate,SemEndDate,PayStartDate,PayEndDate,Retake,PaymentStatus) 
					VALUES ('".$student['StudentId']."',".$nextSem.",'".$SemStartDate."','".$SemEndDate."','".$PayStartDate."','".$PayEndDate."',0,'PENDING')";
		mysqli_query($db,$addSemQuery);
		foreach($Subjects as $sub)
		{
			if($sub != "")
			{
				$addSubQuery = "INSERT INTO semester (StudentId,SemNo,SubId)
							VALUES ('".$student['StudentId']."',".$nextSem.",".$sub.")";
				mysqli_query($db,$addSubQuery);
			}
		}
	}
	header("location:InformationModification.php?updated=addedAll");
?>