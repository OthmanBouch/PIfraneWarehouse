<?php

@include 'config.php';

session_start();


if(isset($_POST['submit'])){

  
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   

   $select = " SELECT * FROM users WHERE Email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'Admin' || $row['user_type'] == 'User' ){
         $_SESSION['User_type'] = $row['user_type'];
         $_SESSION['admin_ID'] = $row['ID'];
         $_SESSION['admin_name'] = $row['Fname'];
         header('location:admin_page.php');
         
      }
   }else{
      $error[] = 'incorrect email or password!';
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>IfraneWarehouse Log In</title>
   <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">

<div class="form-container">

   <form action="" method="post" >
      <h3>Login</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      
      <input type="submit" name="submit" value="login now" class="form-btn">
      
      <p><a href="#">Return to main page</a></p>
   </form>

</div>

</body>
</html>