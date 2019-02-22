<?php 
//A buffer page for admins to select what deployment method they want
include_once("connection.php");
$show_modal = false;
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
	<link rel="stylesheet" href="css/DeployInvoice.css" >
	
    
<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Modal -->
</head>

<body>

    <?php include("Sidebar.php"); ?>
	
	

    

        
	<div id="mainPage-wrapper">
		<div class="container-fluid">
			<p id="Menu" onclick="openNav()">&#9776;</p>
			<h1>HIT THE GROUND RUNNING</h1>
		</div>
	</div>
	<!-- /#mainPage-wrapper -->

</div>
<!-- /#wrapper -->

<form method="get" action="DeployOne.php">
		<input type="submit" class="buttonCheck" value="Deploy One Student">
	</form> 
	
	<form method="get" action="DeployAll.php">
		<input type="submit" class="buttonCheck" value="Deploy Many Students">
	</form>





 <!-- Menu Toggle Script -->
<script>
function openNav() {
    document.getElementById("sidebar-wrapper").style.width = "250px";
}

function closeNav() {
    document.getElementById("sidebar-wrapper").style.width = "0";
}



</script>
</body>

</html>
