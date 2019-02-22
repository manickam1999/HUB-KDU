<?php
	//this method draws out a row with the given data and is used to loop and draw out all row data possible when displaying the table
	function drawTable()
	{
		$db = db_connect();
		if(!$db)
			echo "failed db";
		else
		{
			if(isset($_GET['stID']) && $_GET['stID'] != "")
			{
				$studentQuery = "SELECT * FROM students INNER JOIN course ON students.CourseId = course.CourseId WHERE StudentId LIKE '".$_GET['stID']."%'";
			}
			else
			{
				$studentQuery = "SELECT * FROM students INNER JOIN course ON students.CourseId = course.CourseId";
			}
			$studentData = mysqli_query($db,$studentQuery);
			foreach($studentData as $student)
			{
				$currentSemQuery = "SELECT MAX(SemNo) AS curSem FROM semestercount WHERE StudentId='".$student['StudentId']."'";
				$currentSemData = mysqli_query($db,$currentSemQuery);
				$currentSem = mysqli_fetch_array($currentSemData);
				for($i = 1;$i <= $currentSem['curSem']; $i++)
				{
					$sem = $i;
					$semQuery = "SELECT * FROM semestercount WHERE StudentId = ".$student['StudentId']." AND SemNo = ".$sem;
					$semData = mysqli_query($db,$semQuery);
					$semResult = mysqli_fetch_array($semData);
					if($semResult)
					{
						if($semResult['Retake'] == 1)
							$retakeStatus = "Yes";
						else
							$retakeStatus = "No";
						$subQuery = "SELECT * FROM semester INNER JOIN subjects ON semester.SubId = subjects.SubId WHERE StudentId = ".$student['StudentId']." AND SemNo = ".$sem;
						$subResult = mysqli_query($db,$subQuery);
						$total = 650;
						foreach($subResult as $sub)
						{
							$total += $sub['SubPrice'];
						}
						echo '<tr>
							<td style="text-align: center; vertical-align: middle;">'.$student['StudentId'].'</td>
							<td style="text-align: center; vertical-align: middle;">'.$semResult['SemNo'].'</td>
							<td style="text-align: center; vertical-align: middle;">'.$student['StudentFirstName'].' '.$student['StudentMidName'].' '.$student['StudentLastName'].'</td>
							<td style="text-align: center; vertical-align: middle;">'.$student['CourseName'].'</td>
							<td style="text-align: center; vertical-align: middle;">'.$student['IntakeDate'].'</td>
							<td style="text-align: center; vertical-align: middle;">'.date("d-m-Y",strtotime($semResult['SemStartDate'])).' - '.date("d-m-Y",strtotime($semResult['SemEndDate'])).'</td>
							<td style="text-align: center; vertical-align: middle;">'.$retakeStatus.'</td>
							<td style="text-align: center; vertical-align: middle;">'.date("d-m-Y",strtotime($semResult['PayStartDate'])).'</td>
							<td style="text-align: center; vertical-align: middle;">'.date("d-m-Y",strtotime($semResult['PayEndDate'])).'</td>
							<td style="text-align: center; vertical-align: middle;">'.$total.'</td>
							<td style="text-align: center; vertical-align: middle;">'.$semResult['PaymentStatus'].'</td>
							<td style="text-align: center; vertical-align: middle;"><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" id="button-edit" onclick="editSem(\''.$student['StudentId'].'\','.$i.')" ><span class="glyphicon glyphicon-pencil"></span></button></p> </td>
							<td style="text-align: center; vertical-align: middle;"><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteSem(\''.$student['StudentId'].'\','.$i.')"><span class="glyphicon glyphicon-trash"></span></button></p></td>
							<td style="text-align: center; vertical-align: middle;"><p data-placement="top" data-toggle="tooltip" title="View"><button class="btn btn-primary btn-xs" data-title="View" data-toggle="modal" data-target="#view" ><span class="glyphicon glyphicon-eye-open" onclick="genPhp(\''.$student['StudentId'].'\','.$i.',\'view\')"></span></button></p></td>
							<td style="text-align: center; vertical-align: middle;"><p data-placement="top" data-toggle="tooltip" title="Download"><button class="btn btn-primary btn-xs" data-title="Download" data-toggle="modal" data-target="#download"><span class="glyphicon glyphicon-download" onclick="genPhp(\''.$student['StudentId'].'\','.$i.',\'download\')"></span></button></p></td> 
							</tr>';
					}
				}
			}
		}
		mysqli_close($db);
	}
?>