<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:ManageUsers.php');
}



if(isset($_POST['submit'])){

    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Email = $_POST['Email'];
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
          header('location:UserManagement.php');
       }
    }
 
 };

 

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>User page</title>
      <link rel="stylesheet" href="css/style3.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     
  
   </head>
   
   <body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">
    
      <br>
      <br>
      <br>
      
      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Users</H3>

      <br>

      <p><kbd> Search for user </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

    
      <table class="table table-light table-hover table-striped table-bordered table-danger ">
      <caption>List of users</caption>
  <thead">
    <tr >
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">First name</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Last name</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Email</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Creation date</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">view</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>

    </tr>
  </thead>
  <tbody id="myTable">
    <?php 
    @include 'config.php';
    $fetch_query = "SELECT * FROM users";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           /* echo $row['ID'];*/
            ?>
     <tr class="table-warning">
      
      <td class=" user_id"><?php echo $row['ID']; ?></td>
      <td><?php echo $row['Fname']; ?></td>
      <td><?php echo $row['Lname']; ?></td>
      <td><?php echo $row['Email']; ?></td>
      <td><?php echo $row['Created']; ?></td>
      <td>
        <a href="#" class="btn btn-link btn-sm view_data">View User</a>
      </td>
      <td>
        <a href="#" class="btn btn-link btn-sm edit_data">Update User</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm delete_btn">Delete User</a>
      </td>

             </tr>

            <?php
        }

    }else{

    }
    ?>
    
  </tbody>
</table>























<!-- Add user Modal -->
<div class="modal fade" id="AddUser" tabindex="-1" aria-labelledby="AddUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddUserLabel text-align:center">Add User Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">
  <div class="col-md-6">
    <label for="inputtext" class="form-label">First Name</label>
    <input type="text" name="Fname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Last Name</label>
    <input type="text" name="Lname" class="form-control" >
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Email</label>
    <input type="email" name="Email" class="form-control"  placeholder="Email">
  </div>
  <div class="col-md-6">
    <label for="inputAddress2" class="form-label">Password</label>
    <input type="password" name="password" class="form-control"  placeholder="Password">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Confirm password</label>
    <input type="password" name="cpassword" class="form-control"  placeholder="Password">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Save changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add user Modal -->


<!-- view user Modal -->
<div class="modal fade" id="viewusermodal" tabindex="-1" role="dialog" aria-labelledby="viewusermodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewusermodalLabel">User Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">  
      </div>
      <div class="modal-body">
        <div class="view_user_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- view user Modal -->



<!-- update user Modal -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editdataLabel text-align:center">Update User Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="POST" action="code.php">
    
  <div class="col-md-12">
    
    <input type="hidden" class="form-control" id="user_id" name="id">
  </div>

  <div class="col-md-6">
    <label for="inputtext" class="form-label">First Name</label>
    <input type="text" name="Fname" id="Fname"  class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Last Name</label>
    <input type="text" name="Lname" id="Lname" class="form-control" >
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Email</label>
    <input type="email" name="Email" id="Email" class="form-control"  placeholder="Email">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="updates_data" class="btn btn-warning">Update changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- update user Modal -->

























<!-- Button add user under user table -->
<div style="text-align: center;">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddUser">
    Add a User
  </button>
</div>




   </body>





   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

<!-- view data -->
  <script>
    $(document).ready(function () {
        $('.view_data').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var user_id = $(this).closest('tr').find('.user_id').text();
            /*console.log(user_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_view_btn':true,
                    'user_id':user_id,
                },
                
                success: function (response) {
                    /*console.log(response);*/

                    $('.view_user_data').html(response);
                    $('#viewusermodal').modal('show')
                }
            });

        });
    });


    
  </script>
<!-- update data -->
<script>
    $(document).ready(function () {
        $('.edit_data').click(function (e) { 
            e.preventDefault();
           
            var user_id = $(this).closest('tr').find('.user_id').text();
            console.log(user_id);
          
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_edit_btn':true,
                    'user_id':user_id,
                },
                
                success: function (response) {
                   /* console.log(response);*/
                    $.each(response, function (key, value) {
                        
                        /*console.log(value['Lname']);*/
                        $('#user_id').val(value['ID']);
                        $('#Fname').val(value['Fname']);
                        $('#Lname').val(value['Lname']);
                        $('#Email').val(value['Email']);

                         
                    }); 


                    $('#editdata').modal('show')
                }
            });

        });
    });


    
  </script>

<!-- delete data -->
<script>
    $(document).ready(function () {
        $('.delete_btn').click(function (e) { 
            e.preventDefault();
          
          var user_id =  $(this).closest('tr').find('.user_id').text();
              /*console.log(user_id)*/
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_delete_btn': true,
                    'user_id': user_id
                },
                
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                }
              });
        });
    });
</script>

<script>
  $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?php 
if ($_SESSION['User_type'] == 'Admin') {
    include 'navbaradmin.php'; // Include admin navbar
} elseif ($_SESSION['User_type'] == 'User') {
    include 'navbaruser.php'; // Include user navbar
} ?>
</html>