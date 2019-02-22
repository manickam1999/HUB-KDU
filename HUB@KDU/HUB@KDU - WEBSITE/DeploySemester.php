<?php 
	//takes in a student's id, and all the given data for an invoice to manually add a semester 
	include_once("connection.php");
	$db = db_connect();
	$StudentId = $_GET['Student'];
	$SemNo = $_GET['Semester'];
	$semCheckQuery = "SELECT SemNo FROM semestercount WHERE StudentId =\"".$StudentId."\" AND SemNo =".$SemNo;
	$semCheckResult = mysqli_query($db,$semCheckQuery);
	if(mysqli_num_rows($semCheckResult) > 0)
	{
		header("location:DeployOne.php?exists=exists");
	}
	$RetakeStatus = $_GET['Retake'];
	$PayEndDate = $_GET['datePay'];
	$PayStartDate = date("Y-m-d");
	$SemStartDate = $_GET['dateStart'];
	$SemEndDate = $_GET['dateEnd'];
	$PaymentStatus = $_GET['paystat'];
	$addSemQuery = "INSERT INTO semestercount (StudentId,SemNo,SemStartDate,SemEndDate,PayStartDate,PayEndDate,Retake,PaymentStatus) 
					VALUES ('".$StudentId."',".$SemNo.",'".$SemStartDate."','".$SemEndDate."','".$PayStartDate."','".$PayEndDate."',".$RetakeStatus.",'".$PaymentStatus."')";
	if(mysqli_query($db,$addSemQuery))
	{
		header("location:InformationModification.php?updated=added");
	}
?>