<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit(); // Add exit after redirecting to prevent further execution
} else {
    $ID = $_SESSION['admin_ID'];
}

if (isset($_POST['submit'])) {
    $updates = array();
    
    // Check if each field has been provided with a new value
    if (!empty($_POST['img'])) {
        $updates[] = "img = '" . $_POST['img'] . "'";
    }
    if (!empty($_POST['Fname'])) {
        $updates[] = "Fname = '" . $_POST['Fname'] . "'";
    }
    if (!empty($_POST['Lname'])) {
        $updates[] = "Lname = '" . $_POST['Lname'] . "'";
    }
    if (!empty($_POST['email'])) {
        $updates[] = "Email = '" . $_POST['email'] . "'";
    }
    if (!empty($_POST['Phone'])) {
        $updates[] = "Phone = '" . $_POST['Phone'] . "'";
    }
    if (!empty($_POST['address'])) {
        $updates[] = "Adress = '" . $_POST['address'] . "'";
    }
    if (!empty($_POST['description'])) {
        $updates[] = "Description = '" . $_POST['description'] . "'";
    }
    if (!empty($_POST['Zip'])) {
        $updates[] = "Zip = '" . $_POST['Zip'] . "'";
    }
    if (!empty($_POST['password']) && !empty($_POST['cpassword'])) {
        if ($_POST['password'] === $_POST['cpassword']) {
            $updates[] = "Password = '" . md5($_POST['password']) . "'";
        } else {
            $error[] = 'Password not matched!';
        }
    }

    // Construct the SQL query dynamically
    if (!empty($updates)) {
        $query = "UPDATE users SET " . implode(", ", $updates) . " WHERE ID = '$ID'";
        
        // Execute the query
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: Personnal.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>User Page</title>
    <link rel="stylesheet" href="css/style3.css">

    <link rel="stylesheet" href="css/stylepersonnal.css">
    <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    /* Define flex container */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Set background color of container */
    .content-container {
    backdrop-filter: blur(10px); /* Adjust the blur radius as needed */
    background-color: rgba(255, 255, 255, 0.5); /* Adjust the transparency (0.5 means 50% transparent white) */
    padding: 20px;
    border-radius: 10px;
}

</style>

<body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">

       
    <div class="container">
        <div class="content-container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                    
                    <div class="my-4">
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                
                            </li>
                        </ul>
             <form method="post" action="">
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                        <img src="images/<?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Image = mysqli_fetch_assoc($result)['img'];
                                                        }
                                                        echo $User_Image;
                        ?>" alt="User Image"  >
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                
                                <h4 class="mb-1">
                                    <?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Fname = mysqli_fetch_assoc($result)['Fname'];
                                                        }
                                                        $queryselect1 = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result1 = mysqli_query($conn, $queryselect1);
                                                        if ($result1) { 
                                                            $User_Lname = mysqli_fetch_assoc($result1)['Lname'];
                                                        }

                                                        echo $User_Fname . " " . $User_Lname;

                                                         ?></h4>
                                <p class="small mb-3"><span class="badge badge-dark">User ID: <?php echo $ID ?></span></p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <p class="text-muted">
                                    <?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Description = mysqli_fetch_assoc($result)['Description'];
                                                        }
                                                        echo $User_Description;
                                                         ?>
                                    
                                </p>
                            </div>
                            <div class="col">
                                <p class="small mb-0 text-muted">IfraneWarehouse user</p>
                                <p class="small mb-0 text-muted"><?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Adress = mysqli_fetch_assoc($result)['Adress'];
                                                        }
                                                        echo $User_Adress;
                                                         
                                ?></p>
                                <p class="small mb-0 text-muted">
                                    <?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Phone = mysqli_fetch_assoc($result)['Phone'];
                                                        }
                                                        echo "<b>".$User_Phone ."<b>";
                                                         ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">Firstname</label>
                        <input type="text" name="Fname" id="firstname" class="form-control" placeholder="<?php echo $User_Fname ?>" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="Lname" id="lastname" class="form-control" placeholder="<?php echo $User_Lname ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputtext" class="form-label">Picture</label>
                    <input style="min-height: 45px; " type="file" name="img" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="<?php
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Email = mysqli_fetch_assoc($result)['Email'];
                                                        }
                                                        echo $User_Email;
                    ?>" />
                </div>
                <div class="form-group">
                    <label for="inputAddress6">Address</label>
                    <input type="text" name="address" class="form-control" id="inputAddress5" placeholder="<?php echo $User_Adress ?>" />
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="inputCompany5">Company</label>
                        <input type="text" class="form-control" id="inputCompany5" placeholder="IfraneWarehouse" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputZip5">Zip</label>
                        <input type="text" name="Zip" class="form-control" id="inputZip5" placeholder="<?php  
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Zip = mysqli_fetch_assoc($result)['Zip'];
                                                        }
                                                        echo $User_Zip;
                        ?>" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputZip5">Phone-number</label>
                        <input type="text" name="Phone" class="form-control" id="inputZip5" placeholder="<?php  
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Phone = mysqli_fetch_assoc($result)['Phone'];
                                                        }
                                                        echo $User_Phone;
                        ?>" />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea  name="description" class="form-control" id="inputAddress5" placeholder=" <?php 
                                                        $queryselect = "SELECT * FROM users WHERE ID = '$ID'";
                                                        $result = mysqli_query($conn, $queryselect);
                                                        if ($result) { 
                                                            $User_Description = mysqli_fetch_assoc($result)['Description'];
                                                        }
                                                        echo $User_Description;
                                                         ?>"></textarea>
                    </div>

                   
                </div>
                <hr class="my-4" />
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPassword4">Old Password</label>
                            <input type="password" class="form-control" id="inputPassword5" placeholder="********"
                             disabled/>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword5">New Password</label>
                            <input type="password" class="form-control" name="password" id="inputPassword5" />
                        </div>
                        <div class="form-group">
                            <label for="inputPassword6">Confirm Password</label>
                            <input type="password" class="form-control" name="cpassword" id="inputPassword6" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">Password requirements</p>
                        <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li>Minimum 8 character</li>
                            <li>At least one special character</li>
                            <li>At least one number</li>
                            <li>Can’t be the same as a previous password</li>
                        </ul>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 

if ($_SESSION['User_type'] == 'Admin') {
    include 'navbaradmin.php'; // Include admin navbar
} elseif ($_SESSION['User_type'] == 'User') {
    include 'navbaruser.php'; // Include user navbar
} ?>
</body>

</html>
