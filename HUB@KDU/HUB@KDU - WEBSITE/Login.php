<?php 
//The initial page whr they have to login before using the functions of the website
	require("connection.php");
	$show_modal = false;
	if(isset($_POST['submit']))
	{
		$db = db_connect();
		if(!$db) 
			echo "failed";
		else
		{
			$user = $_POST['userID'];
			$pw = $_POST['password'];
			$query = "SELECT * FROM admincredential WHERE AdminId = '$user' AND  AdminPwd = '$pw'"; //queries whether input by user is registered in the database
			$result = mysqli_query($db,$query);
			if(mysqli_num_rows($result) == 1)
			{
				$_SESSION["login"] = "set";
				if($_SESSION['login'] = "set")
				{
					header("location:InformationModification.php");
				}
			}
			else
			{
				$header = "Invalid credentials";
				$footer = "Please try again";
				$show_modal = true;
			}
		}
	}
	if(isset($_GET['login']))
	{
		if($_GET['login'] = "not")
		{
			$header = "Not logged in";
			$footer = "Please login";
			$show_modal = true;
		}
	}
	if(isset($_GET['logout']))
	{
		if($_GET['logout'] = true)
		{
			$_SESSION['login'] = "unset";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<!--Main Css and Javascript for popup modal box -->
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
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
						<h4 class="modal-title"><?php echo $header;?></h4>
					</div>

					<div class="modal-body">
						<p><?php echo $footer; ?></p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
 <!-- Css link file for Login Form !-->
<link rel="stylesheet" type="text/css" href="css/Login.css">
	
</head>

<body id="LoginForm">

<!-- Main Login Form !-->
<div class="container">
	<h1 class="form-heading"><strong>KDU Penang University College</strong></h1>
	<div class="login-form">
		<div class="main-div">
			<div class="login-panel">
				<h2><b>Admin Login</b></h2>
				<br><br>
			</div>

			<form id="Login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-details"> 
					<label id="text-userID" for="inputUserID"><b>User ID</b></label>
					<input name="userID" type="text" class="form-control" id="inputUserID">
				</div>

				<div class="form-details">
					<label for="password"><b>Password</b></label>
					<input name="password" type="password" class="form-control" id="inputPassword">
				</div>
				<button type="submit" name="submit" id="button-login" class="btn btn-info btn-lg">Login</button>
			</form>
		</div>
	</div>
</div>

</body>
</html>
