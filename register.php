<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
   $Lname = mysqli_real_escape_string($conn, $_POST['Lname']);
   $Email = mysqli_real_escape_string($conn, $_POST['Email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   

   $select = " SELECT * FROM users WHERE Email = '$Email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO users (Fname, Lname, Email, password) VALUES('$Fname','$Lname','$Email','$pass')";
         mysqli_query($conn, $insert);
         header('location:login.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
</head>
<body style="background: url(Image1.jpg);background-repeat: no-repeat;background-size: 100%;">
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>

      <input type="text" name="Fname" required placeholder="enter your name">
      
      <input type="text" name="Lname" required placeholder="Enter the last name">
      <input type="email" name="Email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login.php">login now</a></p>
      <p><a href="#">Return to main page</a></p>
   </form>

</div>

</body>
</html>