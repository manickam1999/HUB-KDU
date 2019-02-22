<?php 
//The main page where all the student data is displayed with functions like delete, edit, view 
include_once("connection.php");
include_once("drawTable.php");
$show_modal = false;
if(isset($_GET['updated']))
{
	if($_GET['updated'] == "updated")
	{
		$show_modal = true;
		$header = "Invoice update";
		$msg = "Invoice has been successfully updated";
	}
	else if($_GET['updated'] == "added")
	{
		$show_modal = true;
		$header = "Invoice added";
		$msg = "Invoice has been successfully added, proceed to add subjects manually";
	}
	else if($_GET['updated'] == "addedAll")
	{
		$show_modal = true;
		$header = "Mass Invoice Deploy";
		$msg = "Invoices successfully deployed!";
	}
}
if(isset($_SESSION['login']))
{
	if($_SESSION['login'] == "unset")
	{	
		header("location:Login.php?login=not");
	}
}
else
{
	header("location:Login.php?login=not");
}

	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <title>Hub@KDU.html</title>

<!-- Bootstrap core CSS & CSS link file for InformationModifcation-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="css/InformationModification.css" >
	
    
<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<?php if($show_modal) { ?>
		<script type='text/javascript'> $(function(){$('#popup-Modal').modal();}); </script>
		<!-- Modal -->
		<div class="modal fade" id="popup-Modal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?php echo $header; ?></h4>
					</div>

					<div class="modal-body">
						<p><?php echo $msg; ?></p>
					</div>

					<div class="modal-footer">
						<button type="button" onclick="resubmitForm()" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

</head>

<body>

    <?php include("Sidebar.php");?>

    

        
        <div id="mainPage-wrapper">
            <div class="container-fluid">
            	<p id="Menu" onclick="openNav()">&#9776;</p>
                <h1>HIT THE GROUND RUNNING</h1>
            </div>
        </div>
        <!-- /#mainPage-wrapper -->

    </div>
    <!-- /#wrapper -->
 

    <form method="get" id="resubmit" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    	<input type="text" id="stID" name="stID" placeholder="Enter Student ID or Nothing to Load All">
		<br>
		<input type="submit" value="check" class="buttonCheck">
	</form>

	
	<br>

	<!-- Table -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table id="tablemodify" class="table table-bordered table-striped">
                   
						<thead>
							<th style="text-align: center; vertical-align: middle; color: white;">Student ID</th>
							<th style="text-align: center; vertical-align: middle;color: white;">Semester No</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Student Name</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Programme Name</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Intake</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Semester Duration</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Retake Status</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Invoice Date</th> 
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Payment Due Date</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Payment Amount</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto">Payment Status</th>
							<th style="text-align: center; vertical-align: middle;color: white;" width="auto" colspan="4">Action</th>
						</thead>
						<tbody>
							<?php
								drawTable();
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<form id="edit" action="EditInvoice.php" method="get">
		<input id="studentIdEdit" type="hidden" name="studentId" value=""/>
		<input id="semNoEdit" type="hidden" name="semNo" value=""/>
	</form>
	<form id="pdf" target="_blank" action="invoice-db.php" method="get">
		<input id="studentIdPhp" type="hidden" name="studentId" value="" />
		<input id="semNoPhp" type="hidden" name="semNo" value=""/>
		<input id="phpType" type="hidden" name="phpType" value=""/>
	</form> 


 <!-- Menu Toggle Script -->
<script>
function openNav() {
    document.getElementById("sidebar-wrapper").style.width = "250px";
}

function closeNav() {
    document.getElementById("sidebar-wrapper").style.width = "0";
}

function deleteSem(studentId,semNo) //deleting a semester
{	
	$.ajax({
            url:"deleteSem.php", //the page containing php script
            type: "post", //request type
            data: {studentId : studentId, semNo : semNo},
			success : function()
			{
				document.location.reload(true);
			}
         });
}

function editSem(studentId,semNo) //forward to editing a semester
{
    $('input#studentIdEdit').val(studentId);
	$('input#semNoEdit').val(semNo);
	$('#edit').submit();
}

function genPhp(studentId,semNo, type) //to generate the pdf 
{
    $('input#studentIdPhp').val(studentId);
	$('input#semNoPhp').val(semNo);
	$('input#phpType').val(type);
	$('#pdf').submit();
}

function resubmitForm()
{
	$("#resubmit").submit();
}
</script>
</body>

</html>
