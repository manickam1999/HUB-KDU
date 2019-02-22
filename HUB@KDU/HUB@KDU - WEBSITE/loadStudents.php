<?php
	//Used to load out student data and send back to requesting page using json 
	include_once("connection.php");
	$course = $_GET['course'];
	$intake = $_GET['intake'];
	$db = db_connect();
	$studentQuery = "SELECT StudentId FROM students 
	INNER JOIN course ON students.CourseId = course.CourseId 
	WHERE CourseName='".$course."' AND IntakeDate='".$intake."'
	ORDER BY StudentId"; 
	$studentResult = mysqli_query($db,$studentQuery);
	while($row = mysqli_fetch_array($studentResult))
	{
		$arr[] = $row['StudentId'];
	}
	$data = json_encode($arr);
	header("Content-Type: application/json");
	echo $data;
?>