<?php
	//Update a semester to paid status when successful payment has been detected on mobile
	include("connection.php");
	$db = db_connect();
	$updateSemQuery = "UPDATE semestercount SET PaymentStatus='PAID' WHERE StudentId='".$_POST['StudentId']."' AND SemNo=".$_POST['SemNo'];
	mysqli_query($db,$updateSemQuery);
	echo mysqli_affected_rows($db);
?>