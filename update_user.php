<?php
@include 'config.php';
session_start();
$id=$_GET['updateID'];
$_SESSION['update_id'] = $id;
header('location:ManageUsers.php');
echo $id;
?>

