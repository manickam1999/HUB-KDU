<?php
	include_once("connection.php");
	$db = db_connect();
	if(isset($_POST['studentId']))
	{
		$stId = $_POST['studentId']; //pulls student id chosen
		$semNo = $_POST['semNo']; //pulls semester number chosen
		$deleteSemCountQuery = "DELETE FROM semestercount WHERE SemNo=".$semNo." AND StudentId='".$stId."'"; //sql query to delete chosen row from Invoice counts
		$deleteSemQuery = "DELETE FROM semester WHERE SemNo=".$semNo." AND StudentId='".$stId."'"; //delete all subjects related to the semester
		if(mysqli_query($db,$deleteSemCountQuery))
		{
			echo "1st del success";
		}
		if(mysqli_query($db,$deleteSemQuery))
		{
			echo json_encode(array("success"=>'successfuly registered')); //returns a message if both successful
		}
	}
?>
	
			