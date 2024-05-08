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
    $Location = $_POST['Location'];

    // Fetching product id from the products table
    $product_query = "SELECT ID FROM products WHERE Pname = '$Product'";
    $product_result = mysqli_query($conn, $product_query);
    if (!$product_result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $productID = mysqli_fetch_array($product_result)['ID'];
    }
    // Fetching location ID from the location table
    $location_query = "SELECT ID FROM location WHERE Location = '$Location'";
    $location_result = mysqli_query($conn, $location_query);
    if (!$location_result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $locationID = mysqli_fetch_array($location_result)['ID'];
    }
    // insert query
    $insert = "INSERT INTO stock (P_id, Location) VALUES ('$productID', '$locationID')";
    if (mysqli_query($conn, $insert)) {
        $insert_history_query = "INSERT INS";
        header('location:StockManagement.php');
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
      
      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Stocks</H3>

      <br>

      <p><kbd> Search for Stocks </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

    
      <table class="table table-light table-hover table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Product</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Stock Price</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Location</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Item Count</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Stock Price</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">View</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">History</th>

    </tr>
  </thead>
  <tbody id="myTable">
    <?php 
    @include 'config.php';
    $fetch_query = "SELECT * FROM stock";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           /* echo $row['ID'];*/
            ?>
     <tr>
      
      <td class="stock_id"><?php echo $row['ID']; ?></td>
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
      <td>
        <?php
        // Fetching product price from the products table mn lproduct id
        $productID = $row['P_id'];
        $productQuery = "SELECT Price FROM products WHERE ID = '$productID'";
        $productResult = mysqli_query($conn, $productQuery);
        $productPrice = mysqli_fetch_array($productResult)['Price'];
        echo $productPrice;
        ?></td>
      
      <td><?php
        // Fetching supplier name from the suppliers table
        $locationID = $row['Location'];
        $locationQuery = "SELECT Location FROM location WHERE ID = '$locationID'";
        $locationResult = mysqli_query($conn, $locationQuery);
        $locationName = mysqli_fetch_array($locationResult)['Location'];
        echo $locationName;
    ?></td>

  <td><?php 
     @include 'config.php';
     $productID = $row['P_id']; 
     $query = "SELECT SUM(Quantity_received) AS Total_Quantity_Received FROM product_supplier WHERE P_id = '$productID'";
     $result = mysqli_query($conn, $query);
     if ($result) {
          $row = mysqli_fetch_assoc($result);
          echo $row['Total_Quantity_Received'];
      } else {
          echo "Error: " . mysqli_error($conn);
     }
    ?></td>
  <td><?php 
      @include 'config.php';
      
      $query = "SELECT SUM(Quantity_received) AS Total_Quantity_Received FROM product_supplier WHERE P_id = '$productID'";
      $result = mysqli_query($conn, $query);
      if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Total_Quantity_Received'] * $productPrice;
        } else {
            echo "Error: " . mysqli_error($conn);
      }
      ?></td>
  ?></td>
      <!-- bach tl9a product id for any id -->
      <td>
        <a href="#" class="btn btn-link btn-sm view_stocks_data">View Stock</a>
      </td>
      
      <td>
        <a href="#" class="btn btn-link btn-sm edit_stock">Update Stock</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm delete_stock">Delete Stock</a>
      </td>
      <td>
        <a href="#" class="btn btn-warning btn-sm history_stock">Stock History</a>
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
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddStock">
    Add a Stock from existing products
  </button>
</div>










   </body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>




<!------------------------------------------------------------------ Modals -------------------------------------------------------->


  <!-- Add stock Modal -->
<div class="modal fade" id="AddStock" tabindex="-1" aria-labelledby="AddStockLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddStockLabel text-align:center">Add Stock Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">

  <div class="col-12">
    <label for="inputState" class="form-label">Product :</label>
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

  <div class="col-12">
    <label for="inputState" class="form-label">Location :</label>
    <select name="Location" class="form-control" id="inputState" multiple="">
      <option selected value="Not defined">Choose...</option>
      
      <?php 
       include 'config.php';
       $location_query = "SELECT Location FROM location";
       $location_result = mysqli_query($conn, $location_query);
       if ($location_result) {
        
        while ($row = mysqli_fetch_assoc($location_result)) {
            $locationName = $row['Location'];
            echo '<option value="' . $locationName . '">' . $locationName . '</option>';
        }
      }else {
      
      echo '<option disabled>Error fetching locations</option>';
            } 
       mysqli_close($conn);
  ?>
      
    </select>
  </div>



  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Add Stock</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add stock Modal -->


<!-- view stock Modal -->
<div class="modal fade" id="viewstockmodal" tabindex="-1" role="dialog" aria-labelledby="viewstockmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewstockmodalLabel">stock Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="view_stock_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- view stock Modal -->


<!-- update stock Modal -->
<div class="modal fade" id="editstock" tabindex="-1" aria-labelledby="editstockLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editstockLabel text-align:center">Update stock Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="POST" action="code.php">
  <div class="col-md-12">
     <!-- id  -->
    <input type="hidden" class="form-control" id="stock_id" name="id">
  </div>
  <div class="col-12">
    <label for="inputState" class="form-label">Location :</label>
    <select name="Location" class="form-control" id="inputState" multiple="">
      <option selected value="Not defined">Choose...</option>
      
      <?php 
       include 'config.php';
       $location_query = "SELECT Location FROM location";
       $location_result = mysqli_query($conn, $location_query);
       if ($location_result) {
        
        while ($row = mysqli_fetch_assoc($location_result)) {
            $locationName = $row['Location'];
            echo '<option value="' . $locationName . '">' . $locationName . '</option>';
        }
      }else {
      
      echo '<option disabled>Error fetching locations</option>';
            } 
       mysqli_close($conn);
  ?>
      
    </select>
  </div>


  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="updates_stock" class="btn btn-warning">Update changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- update stock Modal -->

<!-- history stock Modal -->
<div class="modal fade" id="viewHstockmodal" tabindex="-1" role="dialog" aria-labelledby="viewHstockmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewHstockmodalLabel">History stock Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="view_Hstock_data">

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- history stock Modal -->





<!------------------------------------------------------------------Scripts -------------------------------------------------------->

<!-- delete stock -->
<script>
    $(document).ready(function () {
        $('.delete_stock').click(function (e) { 
            e.preventDefault();
          
          var stock_id =  $(this).closest('tr').find('.stock_id').text();
             console.log(stock_id)
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_stock_delete_btn': true,
                    'stock_id': stock_id


                },  
                
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                }
              });
        });
    });
</script>


<!-- view stock -->
<script>
    $(document).ready(function () {
        $('.view_stocks_data').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var stock_id = $(this).closest('tr').find('.stock_id').text();
            /*console.log(stock_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_viewstock_btn':true,
                    'stock_id': stock_id,
                },
                
                success: function (response) {
                    /* console.log(response);*/

                    $('.view_stock_data').html(response);
                    $('#viewstockmodal').modal('show')
                }
            });

        });
    });


    
  </script>


<!-- update stock -->
<script>
    $(document).ready(function () {
        $('.edit_stock').click(function (e) { 
            e.preventDefault();
           
            var stock_id = $(this).closest('tr').find('.stock_id').text();
           /* console.log(stock_id);*/
          
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_editstock_btn':true,
                    'stock_id':stock_id,
                },
                
                success: function (response) {
                   /* console.log(response);*/
                    $.each(response, function (key, value) {
                        
                        /*console.log(value['Lname']);*/
                        $('#stock_id').val(value['ID']);
                        $('#Location').val(value['Location']);
                        
                        
                         
                    }); 


                    $('#editstock').modal('show')
                }
            });

        });
    });


    
  </script>


<!-- view history stock -->
<script>
    $(document).ready(function () {
        $('.history_stock').click(function (e) { 
            e.preventDefault();
            /*console.log('help');*/
            var stock_id = $(this).closest('tr').find('.stock_id').text();
            /*console.log(stock_id);*/
            
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_viewHstock_btn':true,
                    'stock_id': stock_id,
                },
                
                success: function (response) {
                    /* console.log(response);*/

                    $('.view_Hstock_data').html(response);
                    $('#viewHstockmodal').modal('show')
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
