<?php 
session_start();
$conn = mysqli_connect('localhost','root','','inventory');
/*---------------------------------------------------------User Area---------------------------------------------------------------- */
/* view user*/ 
if(isset($_POST['click_view_btn']))
{
    $id = $_POST['user_id'];
   
   $fetch_query = "SELECT * FROM users where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>User ID:  '.$row['ID'].'</h6>
            <h6>First Name:  '.$row['Fname'].'</h6>
            <h6>Last Name:  '.$row['Lname'].'</h6>
            <h6>Email:  '.$row['Email'].'</h6>
            <h6>Creation Date:  '.$row['Created'].'</h6>
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/*show record to update user*/
if(isset($_POST['click_edit_btn']))
{
    $id = $_POST['user_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM users where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}
/* update user*/ 
if(isset($_POST['updates_data']))
{
    $id = $_POST['id'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Email = $_POST['Email'];

    $update_query = "UPDATE users SET Fname='$Fname', Lname='$Lname', Email='$Email' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);

    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:UserManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:UserManagement.php");
    }
}

/* Delete user */
if(isset($_POST['click_delete_btn'])){
    $id = $_POST['user_id'];

    $delete_query = "DELETE FROM users WHERE id = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "data deleted successfully";
    }else{
        echo "problem occured; skill issue";
    }
}

/*---------------------------------------------------------Product Area---------------------------------------------------------------- */
/* view product*/
if(isset($_POST['click_viewprod_btn']))
{
    $IDs = $_SESSION['admin_ID'];
    $id = $_POST['prod_id'];
   
   $fetch_query = "SELECT * FROM products where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>Product ID:  '.$row['ID'].'</h6>
            <h6>Product Image:   </h6>
                <div class="text-center">
            <img src="images/' . $row['img'] . '" alt="Product Image" style="max-width: 300px; max-height: 500px;">
                </div>
            <h6>Product Name:  '.$row['Pname'].'</h6>
            <h6>Product Type:  '.$row['Ptype'].'</h6>
            <h6>Author Name:  '.$IDs.'</h6>
            <h6>Description:  '.$row['Description'].'</h6>
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 

/* Delete product */
if(isset($_POST['click_prod_delete_btn'])){
    $id = $_POST['prod_id'];
    // we should delete the product from the bridge table first before deleting it from product table
    //or else we get foreing key checks problem
    $delete_queryy = "DELETE FROM productswsuppliers WHERE product = '$id'";
    $delete_queryy_run = mysqli_query($conn,$delete_queryy);  
    
    $delete_query = "DELETE FROM products WHERE ID = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "product deleted successfully";
    }else{
        echo "problem occured, sounds like a skill issue to me bozo";
    }
}

/*show record to update product*/
if(isset($_POST['click_editprod_btn']))
{
    $id = $_POST['prod_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM products where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/* update product*/ 
if(isset($_POST['updates_product']))
{
    $id = $_POST['id'];
   
    $Pname = $_POST['Pname'];
    $Ptype = $_POST['Ptype'];
    $Price = $_POST['Price'];
    $Description = $_POST['Description'];
    if (!empty($_POST['img'])) {
        // If a new image is selected, update the image 
        $img = $_POST['img'];
    } else {
        // If no new image is selected, keep the existing image path
        
        $existingImagePathQuery = "SELECT img FROM products WHERE ID = '$id'";
        $existingImagePathResult = mysqli_query($conn, $existingImagePathQuery);
        $existingImagePathRow = mysqli_fetch_assoc($existingImagePathResult);
        $img = $existingImagePathRow['img'];
    }

    $update_query = "UPDATE products SET img='$img', Pname='$Pname', Price='$Price', Ptype='$Ptype', Description='$Description' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);
    
    //now we delete the supplier f prodwsupp table bach matjinash chi foreign key error
    $deleteAssociationsQuery = "DELETE FROM productswsuppliers WHERE product = '$id'";
    mysqli_query($conn, $deleteAssociationsQuery);
    // o hna we iterate between l values dyal suppliers li 3mrna f update form 
    foreach ($_POST['Suppliers'] as $supplierName) {
        $supplierIDQuery = "SELECT ID FROM supplier WHERE Sname = '$supplierName'";
        $supplierIDResult = mysqli_query($conn, $supplierIDQuery);

        if ($supplierIDResult && $row = mysqli_fetch_assoc($supplierIDResult)) {
            $supplierID = $row['ID'];

            // o hna we insert dok values f ProductWsuppliers table
            $bridgeQuery = "INSERT INTO productswsuppliers (supplier, product) VALUES ('$supplierID','$id')";
            mysqli_query($conn, $bridgeQuery);
        }
    
    }

    if($update_query_run){
        $_SESSION['status'] = 'product updated successfully';
        header("location:ProductManagement.php");
    }else{
        
        $_SESSION['status'] = 'product not updated successfully';
        header("location:ProductManagement.php");
    }
  
 
}

/*---------------------------------------------------------Supplier Area---------------------------------------------------------------- */

/* Delete supplier */
if(isset($_POST['click_Supp_delete_btn'])){
    $id = $_POST['supp_id'];
    // we should delete the supplier from the bridge table first before deleting it from supplier table
    //or else we get foreing key checks problem
    $delete_queryy = "DELETE FROM productswsuppliers WHERE supplier = '$id'";
    $delete_queryy_run = mysqli_query($conn,$delete_queryy);  
    
    $delete_query = "DELETE FROM supplier WHERE ID = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "supplier deleted successfully";
    }else{
        echo "problem occured, sounds like a skill issue to me bozo";
    }
}

/* view supplier */
if(isset($_POST['click_viewsupp_btn']))
{
    $id = $_POST['supp_id'];
   
   $fetch_query = "SELECT * FROM supplier where ID='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>Supplier name:  '.$row['Sname'].'</h6>
            <h6>Supplier location:  '.$row['Slocation'].'</h6>
            <h6>Supplier contact (Email):  '.$row['Email'].'</h6>
            <h6>Creation date:  '.$row['Created'].'</h6>
            
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 

/* show record to update supplier */
if(isset($_POST['click_editsupp_btn']))
{
    $id = $_POST['supp_id'];
    $arrayresult = [];
    $fetch_query = "SELECT * FROM supplier where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/* update supplier */ 
if(isset($_POST['updates_supplier']))
{
    $id = $_POST['id'];
    $Sname = $_POST['Sname'];
    $Slocation = $_POST['Slocation'];
    $Email = $_POST['Email'];

    $update_query = "UPDATE supplier SET Sname='$Sname', Slocation='$Slocation', Email='$Email' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);

    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:SupplierManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:SupplierManagement.php");
    }
 
}
/*--------------------------------------------------------- Order Area---------------------------------------------------------------- */

/* View order */
if(isset($_POST['click_vieworder_btn']))
{
    
    $id = $_POST['order_id'];
    

   $fetch_query = "SELECT * FROM product_supplier where ID='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>order ID:  '.$row['ID'].'</h6>
            <h6>Quantity Ordered:  '.$row['Quantity_ordered'].'</h6>
            <h6>Quantity received:  '.$row['Quantity_received'].'</h6>
            <h6>Quantity remaining:  '.$row['Quantity_remaining'].'</h6>
            <h6>Created by:  '.$row['Created_by'].'</h6>
            <h6>Creation date:  '.$row['Created'].'</h6>
            <h6>Status:  '.$row['Status'].'</h6>
            
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 


/* Delete order */
if(isset($_POST['click_order_delete_btn'])){
    $id = $_POST['order_id'];

    $delete_query = "DELETE FROM product_supplier WHERE id = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "data deleted successfully";
    }else{
        echo "problem occured; skill issue";
    }
}

/* Show record to update order */
if(isset($_POST['click_editorder_btn']))
{
    $id = $_POST['order_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM product_supplier where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/* update order*/ 
if(isset($_POST['updates_order']))
{
    $id = $_POST['id'];
   
    $Quantity_ordered = $_POST['Quantity_ordered'];
    $Quantity_received = $_POST['Quantity_received'];
    $Status = $_POST['Status'];

    //update the order 
    $update_query = "UPDATE product_supplier SET Quantity_ordered='$Quantity_ordered', Status='$Status', Quantity_received ='$Quantity_received' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);

    // update status ila kant quantity remaining = 0 to  Arrived
    $quantity_remaining_query = "SELECT Quantity_remaining FROM product_supplier WHERE ID = '$id'";
    $quantity_remaining_result = mysqli_query($conn, $quantity_remaining_query);
    $quantity_remaining = mysqli_fetch_assoc($quantity_remaining_result)['Quantity_remaining'];

    if ($quantity_remaining == 0) {
        
        $update_status_query = "UPDATE product_supplier SET Status='Arrived' WHERE ID = '$id'";
        mysqli_query($conn, $update_status_query);
    }else {
        $update_status_query = "UPDATE product_supplier SET Status='Pending' WHERE ID = '$id'";
        mysqli_query($conn, $update_status_query);}
        //here is the code to insert l history dyal stock stock id ghadi y3mr mn l function dyal add stock
    $selectpid_querry ="SELECT P_id FROM product_supplier WHERE ID = '$id'";
    $select_pid_result = mysqli_query($conn, $selectpid_querry);
    $prod_id = mysqli_fetch_array($select_pid_result)['P_id'];
    
    $selectStockID_query = "SELECT ID FROM stock WHERE P_id = '$prod_id'";
    $selectStockID_query_result = mysqli_query($conn, $selectStockID_query);
    $stock_ID = mysqli_fetch_array($selectStockID_query_result)['ID'];

    $select_querry = "SELECT * FROM product_supplier where ID = '$id'";
    $select_querry_run = mysqli_query($conn, $select_querry);
    $product = mysqli_fetch_assoc($select_querry_run)['P_id']; 
    
    $insert_history = "INSERT INTO history (Stock,Product, Quantity) VALUES ('$stock_ID','$product', '$Quantity_received')";
    $insert_history_run = mysqli_query($conn, $insert_history);
        // stop insert history 
    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:OrderManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:OrderManagement.php");
    }
   
  
 
}

/*--------------------------------------------------------- Stock Area---------------------------------------------------------------- */

/* View stock */
if(isset($_POST['click_viewstock_btn']))
{
    
    $id = $_POST['stock_id'];
    

    $fetch_query = "SELECT * FROM stock where ID='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>stock ID:  '.$row['ID'].'</h6>
            <h6>Product ID:  '.$row['P_id'].'</h6>
            <h6>Location ID:  '.$row['Location'].'</h6>
            
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 

/* Delete stock */
if(isset($_POST['click_stock_delete_btn'])){
    $id = $_POST['stock_id'];

    $delete_query = "DELETE FROM stock WHERE id = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "data deleted successfully";
    }else{
        echo "problem occured; sound like a skill issue to me";
    }
}


/* Show record to update stock */
if(isset($_POST['click_editstock_btn']))
{
    $id = $_POST['stock_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM stock where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}


/* update stock */ 
if(isset($_POST['updates_stock']))
{
    $id = $_POST['id'];
    $Location = $_POST['Location'];
    
    $getlocid = "SELECT ID FROM location WHERE Location = '$Location'";
    $getlocid_run = mysqli_query($conn,$getlocid);
    $locid = mysqli_fetch_assoc($getlocid_run)['ID'];

    $update_query = "UPDATE stock SET Location='$locid' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn, $update_query);

    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:StockManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:StockManagement.php");
    }
 
}


/* View history stock */
if(isset($_POST['click_viewHstock_btn']))
{
    
    $id = $_POST['stock_id'];
    

    $fetch_query = "SELECT * FROM history where Stock='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        $increment = 1;
        while($row = mysqli_fetch_array($fetch_query_run))
        {   
        
            echo '
            <h6>transaction number:  '.$increment.'</h6>
            <h6>Transaction ID:  '.$row['ID'].'</h6>
            <h6>Stock ID:  '.$row['Stock'].'</h6>
            <h6>Product ID:  '.$row['Product'].'</h6>
            <h6>Quantity:  '.$row['Quantity'].'</h6>
            <h6>Time:  '.$row['Time'].'</h6>
            <br>
            <br>
            <br>
            <br>
            
            
            
            
            
            ';
            $increment = $increment + 1;
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 











?>