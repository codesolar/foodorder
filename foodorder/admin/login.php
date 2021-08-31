<?php
   include('../config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login - Food order system</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="login">
    <h1 class="text-center">Login</h1>
    <br>

    <?php
      if(isset($_SESSION['login']))
      {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
      }
      if(isset($_SESSION['no-login-message']))
      {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
      }
    ?>
    <br>

    <form action="" method="POST" class="text-center">
      Username : <br>
      <input type="text" name="username" placeholder="Enter username">
      <br><br>
      Password: <br>
      <input type="password" name="password" placeholder="Enter password">
      <br><br>
      <input type="submit" name="submit" value="Login" class="btn-primary">
    </form>
  </div>
</body>
</html>

<?php
   if(isset($_POST['submit']))
   {
     $username=$_POST['username'];
     $password=md5($_POST['password']);
     $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
     $res=mysqli_query($conn,$sql);
     $count=mysqli_num_rows($res);
     
     if($count==1)
     {
      $_SESSION['login']="<div class='success' class='text-center'>Login successful</div>";
      $_SESSION['user']=$username;
      header("location:".SITEURL."admin/");
     }
     else
     {
      $_SESSION['login']="<div class='error' class='text-center'>Username or Password did not match</div>";
      header("location:".SITEURL."admin/login.php");
     }
   }
?>