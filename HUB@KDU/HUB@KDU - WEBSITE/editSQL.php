<?php 
	//The php script called when Edit Invoice's form has been submitted to update a students invoice
	include_once("connection.php");
	$db = db_connect();
	$semNo = $_GET["SemNo"];
	$studentId = $_GET["StudentId"];
	$payStartDate = $_GET["InvoiceDate"];
	$payEndDate = $_GET["PaymentDate"];
	$semStartDate = $_GET["SemesterStart"];
	$semEndDate = $_GET["SemesterEnd"];
	$retakeStatus = $_GET["RetakeStatus"];
	$subjects = [];
	$PaymentStatus = $_GET["PaymentStatus"];
	for($i = 0; $i < $_GET['SubjectTotal']; $i++)
	{
		$subjects[] = $_GET['subject'.($i+1)];
	}
	$deleteSubQuery = "DELETE FROM semester WHERE StudentId='".$studentId."' AND SemNo=".$semNo;
	if(mysqli_query($db,$deleteSubQuery))
		echo "pass";
	for($i = 0; $i < count($subjects); $i++)
	{
		$addSubQuery = "INSERT INTO semester(StudentId, SubId, SemNo)
						VALUES ('".$studentId."',".$subjects[$i].",".$semNo.")";
						
		if(mysqli_query($db,$addSubQuery))
			echo "pass2";
	}
	
	$updateSemQuery = "UPDATE semestercount 
						SET StudentId='".$studentId."',SemNo=".$semNo.",SemStartDate='".$semStartDate."',SemEndDate='".$semEndDate.
						"',PayStartDate='".$payStartDate."',PayEndDate='".$payEndDate."',Retake=".$retakeStatus.",PaymentStatus='".$PaymentStatus."'
						WHERE StudentId='".$studentId."' AND SemNo=".$semNo;
	if(mysqli_query($db,$updateSemQuery))
		header("location:InformationModification.php?updated=updated");
?>