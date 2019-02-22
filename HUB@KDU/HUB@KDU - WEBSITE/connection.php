<?php
// Database Variables
$dbhost = "localhost";
$dbuser = "saints";
$dbpass = "RDEFZxYLULPcsv8F"; 
$dbname = "saints";
session_start();
 
$MYSQL_ERRNO = "";
$MYSQL_ERROR = "";
 
// Connect To Database
function db_connect() {
  global $dbhost, $dbuser, $dbpass, $dbname;
  global $MYSQL_ERRNO, $MYSQL_ERROR;
 
  $link_id = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  return $link_id;
}
 
// Handle Errors
function sql_error() {
  global $MYSQL_ERRNO, $MYSQL_ERROR;
 
  if(empty($MYSQL_ERROR)) {
    $MYSQL_ERRNO = mysql_errno(); 
    $MYSQL_ERROR = mysql_error();
  }
  return "$MYSQL_ERRNO: $MYSQL_ERROR";
}
 
// Print Error Message
function error_message($msg) {
  printf("Error: %s", $msg);
  exit;
}
?>
