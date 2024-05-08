<?php

@include 'config.php';

session_start();


if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}else $ID = $_SESSION['admin_ID'];

if(isset($_POST['submit'])){

    $Sname = $_POST['Sname'];
    $Slocation = $_POST['Slocation'];
    $Email = $_POST['Email'];
    $Created_by = $ID;
    
    $select = " SELECT * FROM supplier WHERE Email = '$Email' && Sname = '$Sname'";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'Supplier already exist!';
            
    }else{

          $insert = "INSERT INTO supplier (Sname, Slocation, Email, Created_by) VALUES('$Sname', '$Slocation',' $Email', '$Created_by')";
          mysqli_query($conn, $insert);
          header('location:SupplierManagement.php');
       
    }
 
 };


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
      <meta charset="utf-8">
      <title>SUPPLIER MANAGEMENT</title>
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
   <script>
    console.log('<?php echo $ID; ?> ');
    console.log('skrt7')
    </script>
      
      <br>
      <br>
      <br>

      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Suppliers</H3>

        <br>
      <p><kbd> Search for products </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

      <table class="table table-light table-hover table-striped table-bordered ">
  <thead>
    <tr>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Supplier Name</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Supplier Location</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Email</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Products</th>
      <th width="10%" scope="col" style="text-shadow: 5px 5px 10px orange;">Created By (id)</th>
      <th width="2%" scope="col" style="text-shadow: 5px 5px 10px orange;">Date od Creation</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">view</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>

    </tr>
  </thead>  
  <tbody id="myTable">
    <?php 
    @include 'config.php';
    $fetch_query = "SELECT * FROM supplier";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           /* echo $row['ID'];*/
            ?>
     <tr>
      
      <td class=" supp_id"><?php echo $row['ID']; ?></td>
      <td><b><?php echo $row['Sname']; ?></b></td>
      <td><?php echo $row['Slocation']; ?></td>
      <td><?php echo $row['Email']; ?></td>
      
      <!-- here i need to get the product for each supplier -->
      <td>
        <?php
    // just get the id of each row and put it in the query b7al haka
    $supplierID = $row['ID'];
    $productQuery = "SELECT Pname FROM products INNER JOIN productswsuppliers ON products.ID = productswsuppliers.product WHERE productswsuppliers.supplier = '$supplierID'";
    $productResult = mysqli_query($conn, $productQuery);

    $products = [];
    if ($productResult) {
        while ($productRow = mysqli_fetch_array($productResult)) {
            $products[] = $productRow['Pname'];
        }
    } else  echo "No products available";
     echo implode(', ', $products);
        ?>
      </td>

      <td><?php echo $row['Created_by']; ?></td>
      <td><?php echo $row['Created']; ?></td>
      <td>
        <a href="#" class="btn btn-link btn-sm view_supp_data">View Product</a>
      </td>
      <td>
        <a href="#" class="btn btn-link btn-sm edit_supp">Update Product</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm delete_Supplier">Delete Product</a>
      </td>

             </tr>

            <?php
        }

    }else{
        
    }
    ?>
    
  </tbody>
</table>
             








<!-- Add Supplier Modal -->
<div class="modal fade" id="AddSupplier" tabindex="-1" aria-labelledby="AddSupplierLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddSupplierLabel text-align:center">Add Supplier Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier name</label>
    <input type="text" name="Sname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier Location</label>
    <input type="text" name="Slocation" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier Contact</label>
    <input type="email" name="Email" class="form-control">
  </div>
  

  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Add Supplier</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add Supplier Modal -->

<!-- view Supplier Modal -->
<div class="modal fade" id="viewSuppliermodal" tabindex="-1" role="dialog" aria-labelledby="viewSuppliermodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewSuppliermodalLabel">Supplier Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">  
      </div>
      <div class="modal-body">
        <div class="view_supplier_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- view Supplier Modal -->

<!-- update supplier Modal -->
<div class="modal fade" id="editsupp" tabindex="-1" aria-labelledby="editsuppLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editsuppLabel text-align:center">Update Supplier Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="POST" action="code.php">
  <div class="col-md-12">
    
    <input type="hidden" class="form-control" id="supp_id" name="id">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier name</label>
    <input type="text" name="Sname" id="Sname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier Location</label>
    <input type="text" name="Slocation" id="Slocation" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Supplier Contact</label>
    <input type="Email" name="Email" id="Email" class="form-control">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="updates_supplier" class="btn btn-warning">Update changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- update supplier Modal -->

<!-- Button add Supplier under user table -->
<div style="text-align: center;">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddSupplier">
    Add a Supplier
  </button>
</div>


















   </body>

















   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

<!-- view supplier -->
  <script>
    $(document).ready(function () {
        $('.view_supp_data').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var supp_id = $(this).closest('tr').find('.supp_id').text();
            /*console.log(supp_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_viewsupp_btn':true,
                    'supp_id':supp_id,
                },
                
                success: function (response) {
                    /* console.log(response);*/

                    $('.view_supplier_data').html(response);
                    $('#viewSuppliermodal').modal('show')
                }
            });

        });
    });


    
  </script>

<!-- delete supplier -->
<script>
    $(document).ready(function () {
        $('.delete_Supplier').click(function (e) { 
            e.preventDefault();
          
          var supp_id =  $(this).closest('tr').find('.supp_id').text();
            /* console.log(supp_id)*/
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_Supp_delete_btn': true,
                    'supp_id': supp_id
                },
                
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                }
              });
        });
    });
</script>

<!-- update supplier -->
<script>
    $(document).ready(function () {
        $('.edit_supp').click(function (e) { 
            e.preventDefault();
           
            var supp_id = $(this).closest('tr').find('.supp_id').text();
            /* console.log(supp_id); */
    
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_editsupp_btn':true,
                    'supp_id':supp_id,
                },
                
                success: function (response) {
                   /* console.log(response);*/
                    $.each(response, function (key, value) {
                        
                        /*console.log(value['Lname']);*/
                        $('#supp_id').val(value['ID']);
                        $('#Sname').val(value['Sname']);
                        $('#Slocation').val(value['Slocation']);
                        $('#Email').val(value['Email']);
                        
                         
                    }); 


                    $('#editsupp').modal('show')
                }
            });

        });
    });


    
  </script>

<!-- Search info from table -->
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

