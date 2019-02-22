<?php
	//Load out subjects and return them in a json array back to requesting page
	include_once("connection.php");
	$db = db_connect();
	$course = $_GET['course'];
	$courseQuery = "SELECT CourseId FROM course WHERE CourseName='".$course."'";
	$courseResult = mysqli_query($db,$courseQuery);
	$row = mysqli_fetch_array($courseResult);
	$courseId = $row['CourseId'];
	$allSubQuery = "SELECT subjects.SubId,subjects.SubName,subjects.SubCode,subjects.SubPrice FROM coursesubjects INNER JOIN subjects ON coursesubjects.SubId = subjects.SubId WHERE CourseId=".$courseId." OR CourseId=6";
	$allSubResult = mysqli_query($db,$allSubQuery);
	$arr = array();
	foreach($allSubResult as $row)
	{
		$arr[] = $row;
	}
	header("Content-type:application/json");
	echo json_encode($arr);
?>
	