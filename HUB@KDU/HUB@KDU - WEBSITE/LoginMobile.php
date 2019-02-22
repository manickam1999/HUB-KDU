<?php 
//this page checks students logins on mobile and returns 1 or 0 based on whether it is correct or not
require "connection.php";
$con = db_connect();
$user_name = $_POST["username"];
$user_pass = $_POST["password"];
$mysql_qry = "select * from studentcredential where StudentId='".$user_name."' and StudentPwd='".$user_pass."'";
$result = mysqli_query($con ,$mysql_qry);
if(mysqli_num_rows($result) > 0) {
echo "1";
}
else {
echo "0";
}
 
?>
