<?php
@include 'config.php';
if(isset($_GET['deleteID'])){
     $ID=$_GET['deleteID'];

     $sql="delete from `users` where ID=$ID";
     $result=mysqli_query($conn,$sql);
     if($result){
        header('location:ManageUsers.php');
     }else{
        die(mysqli_error($conn));
     }
}
?>