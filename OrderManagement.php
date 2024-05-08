<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
} else {
    $ID = $_SESSION['admin_ID'];
}

if (isset($_POST['submit'])) {

    $Product = $_POST['Product'];
    $Quantity_ordered = $_POST['Quantity_ordered'];
    $Status = $_POST['Status'];

    // Fetching product id from the products table
    $product_query = "SELECT ID FROM products WHERE Pname = '$Product'";
    $product_result = mysqli_query($conn, $product_query);
    if (!$product_result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $productID = mysqli_fetch_array($product_result)['ID'];
    }

    // Fetching supplier id from the products table
    $supplier_query = "SELECT supplier FROM productswsuppliers WHERE product = '$productID'";
    $supplier_result = mysqli_query($conn, $supplier_query);
    if (!$supplier_result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $supplierID = mysqli_fetch_array($supplier_result)['supplier'];
    }

    $insert = "INSERT INTO product_supplier (P_id, Quantity_ordered, Quantity_remaining, S_id, Status, Created_by) VALUES ('$productID', '$Quantity_ordered','$Quantity_ordered', '$supplierID', '$Status', '$ID')";
    if (mysqli_query($conn, $insert)) {
        
        header('location:OrderManagement.php');
    } else {
        echo "Error: " . $insert . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Orders  Page</title>
      <link rel="stylesheet" href="css/style3.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
      <link rel="stylesheet" href="css/font-awesome-4.7.0/">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  
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
      
      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Orders</H3>

      <br>

      <p><kbd> Search for orders </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

    
      <table class="table table-light table-hover table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Product</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Quantity orderer</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Supplier</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Quantity received</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Quantity remaining</th>
      <th width="col" scope="col" style="text-shadow: 5px 5px 10px orange;">Status</th>
      <th width="col" scope="col" style="text-shadow: 5px 5px 10px orange;">Created by (id)</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Creation date</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">view</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>

    </tr>
  </thead>
  <tbody id="myTable">
    <?php 
    @include 'config.php';
    $fetch_query = "SELECT * FROM product_supplier";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           /* echo $row['ID'];*/
            ?>
     <tr>
      
      <td class="order_id"><?php echo $row['ID']; ?></td>
      <td>
                    <?php
                    // Fetching product name from the products table mn lproduct id
                    $productID = $row['P_id'];
                    $productQuery = "SELECT Pname FROM products WHERE ID = '$productID'";
                    $productResult = mysqli_query($conn, $productQuery);
                    $productName = mysqli_fetch_array($productResult)['Pname'];
                    echo $productName;
                    ?>
                </td>
      <td><?php echo $row['Quantity_ordered']; ?></td>
      <td>
    <?php
        // Fetching supplier name from the suppliers table
        $supplierID = $row['S_id'];
        $supplierQuery = "SELECT Sname FROM supplier WHERE ID = '$supplierID'";
        $supplierResult = mysqli_query($conn, $supplierQuery);
        $supplierName = mysqli_fetch_array($supplierResult)['Sname'];
        echo $supplierName;
    ?>
   </td>
      <td><?php echo $row['Quantity_received']; ?></td>
      <td><?php echo $row['Quantity_remaining']; ?></td>
      <td style="color: <?php echo ($row['Status'] == 'Pending') ? 'red' : (($row['Status'] == 'Arrived') ? 'green' : ''); ?>"><?php echo $row['Status']; ?></td>

      <td><?php echo $row['Created_by']; ?></td>
      <td><?php echo $row['Created']; ?></td>
      <!-- bach tl9a product id for any id -->
      <td>
        <a href="#" class="btn btn-link btn-sm view_orders_data">View order</a>
      </td>
      <td>
        <a href="#" class="btn btn-link btn-sm edit_order">Update order</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm delete_order">Delete order</a>
      </td>

             </tr>

            <?php
        }

    }else{
        
    }
    ?>
    
  </tbody>
</table>

<div style="text-align: center;">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddOrder">
    Add an order
  </button>
</div>










   </body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>







  <!-- Add order Modal -->
<div class="modal fade" id="AddOrder" tabindex="-1" aria-labelledby="AddOrderLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddOrderLabel text-align:center">Add order Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">

  <div class="col-12">
    <label for="inputState" class="form-label">Product</label>
    <select name="Product" class="form-control" id="inputState" multiple="">
      <option selected value="Not defined">Choose...</option>
      
      <?php 
       include 'config.php';
       $product_query = "SELECT Pname FROM products";
       $product_result = mysqli_query($conn, $product_query);
       if ($product_result) {
        
        while ($row = mysqli_fetch_assoc($product_result)) {
            $productName = $row['Pname'];
            echo '<option value="' . $productName . '">' . $productName . '</option>';
        }
      }else {
      
      echo '<option disabled>Error fetching products</option>';
            } 
       mysqli_close($conn);
  ?>
      
    </select>
  </div>

  <div class="col-md-6">
    <label for="inputtext" class="form-label">Quantity</label>
    <input type="text" name="Quantity_ordered" class="form-control">
  </div>

  <div class="col-md-6">
    <label for="inputState" class="form-label">Status</label>
    <select name="Status" class="form-control" id="inputState">
      <option selected value="Not defined">Choose...</option>
      <option value="Pending">Pending</option>
      <option value="Arrived">Arrived</option>
      </select>
  </div>

  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Add Order</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add order Modal -->


<!-- view order Modal -->
<div class="modal fade" id="viewordermodal" tabindex="-1" role="dialog" aria-labelledby="viewordermodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewordermodalLabel">order Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="view_order_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- view order Modal -->


<!-- update order Modal -->
<div class="modal fade" id="editorder" tabindex="-1" aria-labelledby="editorderLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editorderLabel text-align:center">Update Order Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="POST" action="code.php">
  <div class="col-md-12">
    
    <input type="hidden" class="form-control" id="order_id" name="id">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Quantity</label>
    <input type="text" name="Quantity_ordered" id="Quantity_ordered" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputtext" class="form-label">Quantity received</label>
    <input type="text" name="Quantity_received" id="Quantity_received" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputState" class="form-label">Status</label>
    <select name="Status" class="form-control" id="Status" >
      <option selected value="Not defined">Choose...</option>
      <option value="Pending">Pending</option>
      <option value="Arrived">Arrived</option>
      </select>
  </div>


  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="updates_order" class="btn btn-warning">Update changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- update order Modal -->







<!------------------------------------------------------------------Scripts -------------------------------------------------------->

<!-- delete order -->
<script>
    $(document).ready(function () {
        $('.delete_order').click(function (e) { 
            e.preventDefault();
          
          var order_id =  $(this).closest('tr').find('.order_id').text();
             console.log(order_id)
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_order_delete_btn': true,
                    'order_id': order_id
                },
                
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                }
              });
        });
    });
</script>


<!-- view order -->
<script>
    $(document).ready(function () {
        $('.view_orders_data').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var order_id = $(this).closest('tr').find('.order_id').text();
            /*console.log(order_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_vieworder_btn':true,
                    'order_id': order_id,
                },
                
                success: function (response) {
                    /* console.log(response);*/

                    $('.view_order_data').html(response);
                    $('#viewordermodal').modal('show')
                }
            });

        });
    });


    
  </script>


<!-- update order -->
<script>
    $(document).ready(function () {
        $('.edit_order').click(function (e) { 
            e.preventDefault();
           
            var order_id = $(this).closest('tr').find('.order_id').text();
            /*console.log(order_id);*/
          
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_editorder_btn':true,
                    'order_id':order_id,
                },
                
                success: function (response) {
                   /* console.log(response);*/
                    $.each(response, function (key, value) {
                        
                        /*console.log(value['Lname']);*/
                        $('#order_id').val(value['ID']);
                        $('#Quantity_ordered').val(value['Quantity_ordered']);
                        $('#Quantity_received').val(value['Quantity_received']);
                        $('#Status').val(value['Status']);
                        
                        
                         
                    }); 


                    $('#editorder').modal('show')
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
