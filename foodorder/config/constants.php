<?php
  session_start();
 
  define('SITEURL','http://localhost/foodorder/');
  define('LOCALHOST','localhost');
  define('DB_USERNAME','root');
  define('DB_PASSCODE','');
  define('DB_NAME','foodorder');
  $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSCODE) or die(mysqli_error());
  $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());
?>