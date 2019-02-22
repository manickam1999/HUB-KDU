<?php
	include_once("connection.php");
	$db = db_connect(); //initialize connection
	$checksemquery = "SELECT COUNT(SemNo) AS SemNo FROM semestercount WHERE StudentId='".$_POST['StudentId']."'"; //finds how many invoices the student has
	$checkSemResult = mysqli_query($db,$checksemquery);
	$row = mysqli_fetch_array($checkSemResult);
	echo $row['SemNo']; //returns it to mobile app that is requesting this script
?>