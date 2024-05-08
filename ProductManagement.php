<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:Login.php');
}else $ID = $_SESSION['admin_ID'];



if(isset($_POST['submit'])){

    $img = $_POST['img'];
    $Pname = $_POST['Pname'];
    $Ptype = $_POST['Ptype'];
    $Description = $_POST['Description'];
    $Created_by = $ID;
    $Suppliers = $_POST['Suppliers'];
    $Price = $_POST['Price'];
    
 
    $select = " SELECT * FROM products WHERE Pname = '$Pname'&& Ptype = '$Ptype' && Description = '$Description'";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'product might already exist!';
 
    }else{
          $insert = "INSERT INTO products (img, Pname, Price, Ptype, Description, Created_by) VALUES('$img','$Pname', '$Price','$Ptype','$Description','$Created_by')";
          mysqli_query($conn, $insert);
          // find the last inserted items id
          $newProductID = mysqli_insert_id($conn);

          foreach ($Suppliers as $supplierName){
            $supplierIDQuery = "SELECT ID FROM supplier WHERE Sname = '$supplierName'";
            $supplierIDResult = mysqli_query($conn, $supplierIDQuery);

            if ($supplierIDResult && $row = mysqli_fetch_assoc($supplierIDResult)) {
              $supplierID = $row['ID'];
              
              // Insert into ProductWsuppliers table
              $bridgeQuery = "INSERT INTO productswsuppliers (supplier, product) VALUES ('$supplierID','$newProductID')";
              mysqli_query($conn, $bridgeQuery);
          }
            
          }
          header('location:ProductManagement.php');
       }
    }

 

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Product Management</title>
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
   <!-- important session on j-->
 <script>
    console.log('<?php echo $ID; ?> ');
    console.log('hello')
 </script>
  

    
      <br>
      <br>
      <br>
      
      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Products</H3>

      <br>

      <p><kbd> Search for products </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

    
      <table class="table table-light table-hover table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Image</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Pname</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Price</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Ptype</th>
      <th width="20%" scope="col" style="text-shadow: 5px 5px 10px orange;">Description</th>
      <th width="10%" scope="col" style="text-shadow: 5px 5px 10px orange;">Suppliers</th>
      <th width="2%" scope="col" style="text-shadow: 5px 5px 10px orange;">Created by (id)</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Creation date</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">view</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>

    </tr>
  </thead>
  <tbody id="myTable">
    <?php 
    @include 'config.php';
    $fetch_query = "SELECT * FROM products";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           /* echo $row['ID'];*/
            ?>
     <tr>
      
      <td class=" prod_id"><?php echo $row['ID']; ?></td>
      <td><img src="images/<?php echo $row['img']; ?>" alt="Product Image" style="max-width: 85px; max-height: 85 px;"></td>
      <td><b><?php echo $row['Pname']; ?></b></td>
      <td><b><?php echo $row['Price']; ?></b></td>
      <td><?php echo $row['Ptype']; ?></td>
      <td style="color: DarkGoldenRod;"><h16><?php echo $row['Description']; ?></h16></td>
      <!-- bach tl9a suppliors for any product -->
      <td><?php 
                    // Fetch and display suppliers for this product 3la 7sab l prod id 
                    $productID = $row['ID'];
                    $supplier_query = "SELECT Sname FROM supplier,productswsuppliers WHERE productswsuppliers.product = '$productID' AND productswsuppliers.supplier = supplier.id";
                    $supplier_result = mysqli_query($conn, $supplier_query);
                    $suppliers = [];

                    if ($supplier_result) {
                        while ($supplierRow = mysqli_fetch_assoc($supplier_result)) {
                            $suppliers[] = $supplierRow['Sname'];
                        }
                    }else echo "no supplier found";

                    echo implode(', ', $suppliers);
                ?></td>
      <td><?php echo $row['Created_by']; ?></td>
      <td><?php echo $row['Created']; ?></td>
      <td>
        <a href="#" class="btn btn-link btn-sm view_prod_data">View Product</a>
      </td>
      <td>
        <a href="#" class="btn btn-link btn-sm edit_prod">Update Product</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm delete_prod">Delete Product</a>
      </td>

             </tr>

            <?php
        }

    }else{
        
    }
    ?>
    
  </tbody>
</table>























<!-- Add product Modal -->
<div class="modal fade" id="AddProduct" tabindex="-1" aria-labelledby="AddProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddProductLabel text-align:center">Add Product Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">
  <div class="col-12">
    <label for="inputtext" class="form-label">Product Image</label>
    <input type="file" name="img" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Product name</label>
    <input type="text" name="Pname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Product price</label>
    <input type="text" name="Price" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputState" class="form-label">Product Type</label>
    <select name="Ptype" class="form-control" id="inputState">
      <option selected value="Not defined">Choose...</option>
      <option value="Office supplies">Office supplies</option>
      <option value="Machinery">Machinery</option>
      <option value="Road Signage">Road Signage</option>
      <option value="Building Materials">Building Materials</option>
      <option value="Safety Gear and Uniforms">Safety Gear and Uniforms</option>
      <option value="Computers and IT equipment">Computers and IT equipment</option>
      <option value="Cleaning Supplies">Cleaning Supplies</option>
      <option value="Parks and Recreation equipment">Parks and Recreation equipment</option>
      <option value="Street Lighting Components">Street Lighting Components</option>
      <option value="Public Event Supplies">Public Event Supplies</option>
      <option value="Emergency Response Equipment">Emergency Response Equipment</option>
      <option value="Water and Sewerage Maintenance Supplies">Water and Sewerage Maintenance Supplies</option>
      <option value="Street Cleaning Equipment">Street Cleaning Equipment</option>
      <option value="Cables">Cables</option>
      <option value="Medical Supplies">Medical Supplies</option>
      <option value="Vehicle Parts">Vehicle Parts</option>
      
      

    </select>
  </div>
  <!-- supplier work now -->
  <div class="col-md-6">
    <label for="inputState" class="form-label">Supplier</label>
    <select name="Suppliers[]" class="form-control" id="supplierSelect" multiple="">
      <option selected value="Not defined">Choose...</option>
      
      <?php 
       include 'config.php';
       $supplier_query = "SELECT Sname FROM supplier";
       $supplier_result = mysqli_query($conn, $supplier_query);
       if ($supplier_result) {
        
        while ($row = mysqli_fetch_assoc($supplier_result)) {
            $supplierName = $row['Sname'];
            echo '<option value="' . $supplierName . '">' . $supplierName . '</option>';
        }
      }else {
      
      echo '<option disabled>Error fetching suppliers</option>';
            } 
       mysqli_close($conn);
  ?>
      
    </select>
  </div>
  <div class="col-md-6">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea class="form-control" name="Description" id="exampleFormControlTextarea1" rows="7"></textarea>
  </div>
  

  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Add Product</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add product Modal -->


<!-- view product Modal -->
<div class="modal fade" id="viewproductmodal" tabindex="-1" role="dialog" aria-labelledby="viewproductmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewproductmodalLabel">Product Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            
         
        
      </div>
      <div class="modal-body">
        <div class="view_product_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- view product Modal -->



<!-- update product Modal -->
<div class="modal fade" id="editprod" tabindex="-1" aria-labelledby="editprodLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editprodLabel text-align:center">Update Product Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="POST" action="code.php">
  <div class="col-md-12">
    
    <input type="hidden" class="form-control" id="prod_id" name="id">
  </div>
    
<div class="col-12">
    <label for="inputtext" class="form-label">Product Image</label>
    <input type="file" name="img" id="img" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Product name</label>
    <input type="text" name="Pname" id="Pname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Product price</label>
    <input type="text" name="Price" id="Price" class="form-control">
  </div>
  <!-- #product type options --> 
  <div class="col-md-6">
    <label for="inputState" class="form-label">Product Type</label>
    <select name="Ptype" class="form-control" id="Ptype">
      <option selected>Choose...</option>
      <option value="Office supplies">Office supplies</option>
      <option value="Machinery">Machinery</option>
      <option value="Road Signage">Road Signage</option>
      <option value="Building Materials">Building Materials</option>
      <option value="Safety Gear and Uniforms">Safety Gear and Uniforms</option>
      <option value="Computers and IT equipment">Computers and IT equipment</option>
      <option value="Cleaning Supplies">Cleaning Supplies</option>
      <option value="Parks and Recreation equipment">Parks and Recreation equipment</option>
      <option value="Street Lighting Components">Street Lighting Components</option>
      <option value="Public Event Supplies">Public Event Supplies</option>
      <option value="Emergency Response Equipment">Emergency Response Equipment</option>
      <option value="Water and Sewerage Maintenance Supplies">Water and Sewerage Maintenance Supplies</option>
      <option value="Street Cleaning Equipment">Street Cleaning Equipment</option>
      <option value="Cables">Cables</option>
      <option value="Medical Supplies">Medical Supplies</option>
      <option value="Vehicle Parts">Vehicle Parts</option>
      
      

    </select>
  </div>
  
  <div class="col-md-6">
    <label for="inputState" class="form-label">Supplier</label>
    <select name="Suppliers[]" class="form-control" id="supplierSelect" multiple="">
      <option selected value="Not defined">Choose...</option>
      
      <?php 
       include 'config.php';
       $supplier_query = "SELECT Sname FROM supplier";
       $supplier_result = mysqli_query($conn, $supplier_query);
       if ($supplier_result) {
        
        while ($row = mysqli_fetch_assoc($supplier_result)) {
            $supplierName = $row['Sname'];
            echo '<option value="' . $supplierName . '">' . $supplierName . '</option>';
        }
      }else {
      
      echo '<option disabled>Error fetching suppliers</option>';
            } 
       mysqli_close($conn);
  ?>

    </select>
  </div>
  <div class="col-md-6">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea class="form-control" name="Description" id="Description" rows="7"></textarea>
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="updates_product" class="btn btn-warning">Update changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- update product Modal -->

























<!-- Button add product under user table -->
<div style="text-align: center;">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddProduct">
    Add a Product
  </button>
</div>


<?php 

if ($_SESSION['User_type'] == 'Admin') {
    include 'navbaradmin.php'; // Include admin navbar
} elseif ($_SESSION['User_type'] == 'User') {
    include 'navbaruser.php'; // Include user navbar
} ?>

   </body>





   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

<!-- view product -->
  <script>
    $(document).ready(function () {
        $('.view_prod_data').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var prod_id = $(this).closest('tr').find('.prod_id').text();
            /*console.log(prod_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_viewprod_btn':true,
                    'prod_id':prod_id,
                },
                
                success: function (response) {
                    /* console.log(response);*/

                    $('.view_product_data').html(response);
                    $('#viewproductmodal').modal('show')
                }
            });

        });
    });


    
  </script>

<!-- update product -->
<script>
    $(document).ready(function () {
        $('.edit_prod').click(function (e) { 
            e.preventDefault();
           
            var prod_id = $(this).closest('tr').find('.prod_id').text();
            /*console.log(prod_id);*/
          
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_editprod_btn':true,
                    'prod_id':prod_id,
                },
                
                success: function (response) {
                   /* console.log(response);*/
                    $.each(response, function (key, value) {
                        
                        /*console.log(value['Lname']);*/
                        $('#prod_id').val(value['ID']);
                        $('#Pname').val(value['Pname']);
                        $('#Price').val(value['Price']);
                        $('#Ptype').val(value['Ptype']);
                        $('#Description').val(value['Description']);
                        
                         
                    }); 


                    $('#editprod').modal('show')
                }
            });

        });
    });


    
  </script>

<!-- delete product -->
<script>
    $(document).ready(function () {
        $('.delete_prod').click(function (e) { 
            e.preventDefault();
          
          var prod_id =  $(this).closest('tr').find('.prod_id').text();
            /* console.log(prod_id)*/
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_prod_delete_btn': true,
                    'prod_id': prod_id
                },
                
                success: function (response) {
                    console.log(response);
                    window.location.reload();
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
</html>
