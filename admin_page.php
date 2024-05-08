<?php
@include 'config.php';

session_start();



// hna ghanakhdo ch7al dyal items li pending o ch7al li arrived
$query = "SELECT Status, COUNT(*) AS count FROM product_supplier GROUP BY Status";
$result = mysqli_query($conn, $query);

$arrivedCount = 0;
$pendingCount = 0;

// o hna ghadi nsetiw ghir status as a hover m3a numbers of items 
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Status'] === 'Arrived') {
        $arrivedCount = $row['count'];
    } elseif ($row['Status'] === 'Pending') {
        $pendingCount = $row['count'];
    }
}




mysqli_close($conn);
?>
<?php
@include 'config.php';



if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit(); // Add exit after redirecting to prevent further execution
}

// Fetch product names and prices from the products table
$query1 = "SELECT Pname, Price FROM products";
$result1 = mysqli_query($conn, $query1);

$productNamess = [];
$productPrices = [];

// Store product names and prices in separate arrays
while ($row = mysqli_fetch_assoc($result1)) {
    $productNamess[] = $row['Pname'];
    $productPrices[] = $row['Price'];
}
//
// Close the database connection
mysqli_close($conn);
?>
<?php
@include 'config.php';

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit(); 
}

// Fetch stock information including product prices
$queryy = "SELECT ps.ID, ps.P_id, ps.Quantity_ordered, p.Price, p.Pname FROM product_supplier ps INNER JOIN products p ON ps.P_id = p.ID";

$resulty = mysqli_query($conn, $queryy);


if (!$resulty) {
    // If there is an error in the query, print the error and exit
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
$stockTotalPrice = [];


// Calculate total price for each stock
while ($row = mysqli_fetch_assoc($resulty)) {
    $stockID = $row['ID'];
    $productName = $row['Pname'];
    $productPrice = $row['Price'];
    $quantityOrdered = $row['Quantity_ordered'];
    $totalPrice = $productPrice * $quantityOrdered;
    
    // Store total price for each stock
    $stockTotalPrice[$stockID] = $totalPrice;
    $productNames[$stockID] = $productName;
}

mysqli_close($conn);
?>
<?php
// Include configuration file
@include 'config.php';

// Check if the admin is logged in

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit(); 
}

// Fetch product names and quantities from the database
$query3 = "SELECT Pname, Quantity_ordered FROM product_supplier ps INNER JOIN products p ON ps.P_id = p.ID";
$result3 = mysqli_query($conn, $query3);

$productNames = [];
$productQuantities = [];

// Store product names and quantities in separate arrays
while ($row = mysqli_fetch_assoc($result3)) {
    $productNames[] = $row['Pname'];
    $productQuantities[] = $row['Quantity_ordered'];
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>User Page</title>
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
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* Define flex container */
    .container {
        display: flex;
        justify-content: center; /* Center items horizontally */
        align-items: center;
        height: 100vh; /* Full height of viewport */
    }

    /* Style for the chart container */
    .chart-container {
        padding: 20px; /* Adjust padding as needed */
        background-color: #f2f2f2; /* Grey background color */
        border-radius: 10px; /* Rounded corners */
        text-align: center;
        margin-right: 20px; /* Add margin between charts */
    }
</style>

</head>
<body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">

<br>
<H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">Dashboard</H3>

<div class="container">
    <div id="pieChartContainer" class="chart-container">
        <h6>Pending Orders VS Arrived Orders</h6>
        <!-- Add a canvas element for the pie chart -->
        <canvas id="pieChart" width="400" height="400"></canvas>
    </div>
    
    <div id="productPriceChartContainer" class="chart-container">
        <h6>Products and Their Prices</h6>
        <!-- Add a canvas element for the bar chart -->
        <canvas id="productPriceChart" width="400" height="400"></canvas>
    </div>

    <div id="productStockChartContainer" class="chart-container">
        <h6>Stock of Products Based on Prices</h6>
        <!-- Add a canvas element for the line chart -->
        <canvas id="productStockChart" width="400" height="400"></canvas>
    </div>

    <div id="productQuantityChartContainer" class="chart-container">
        <h6>Product Quantity</h6>
        <!-- Add a canvas element for the line chart -->
        <canvas id="productQuantityChart" width="400" height="400"></canvas>
    </div>
</div>
</div>

<script>
    // Get the canvas element for pie chart
    var ctxPieChart = document.getElementById('pieChart').getContext('2d');

    // Create the pie chart
    var pieChart = new Chart(ctxPieChart, {
        type: 'pie',
        data: {
            labels: ['Arrived', 'Pending'],
            datasets: [{
                label: 'Status',
                data: [<?php echo $arrivedCount; ?>, <?php echo $pendingCount; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            // Add any options you want here
        }
    });
    </script>


<script>
    // Get the canvas element
    var ctx = document.getElementById('productPriceChart').getContext('2d');

    // Create the bar chart
    var productPriceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($productNamess); ?>,
            datasets: [{
                label: 'Price',
                data: <?php echo json_encode($productPrices); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    // Get canvas element
    var ctx = document.getElementById('productStockChart').getContext('2d');

// Create labels and data arrays for chart
var data = <?php echo json_encode(array_values($stockTotalPrice)); ?>;

// Create the bar chart
var stockPriceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($productNames); ?>,
        datasets: [{
            label: 'Stock Total Price',
            data: data,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
    // Get the canvas element for the pie chart
    var ctxPieChart = document.getElementById('productQuantityChart').getContext('2d');

    // Create the pie chart
    var productQuantityChart = new Chart(ctxPieChart, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($productNames); ?>,
            datasets: [{
                label: 'Quantity',
                data: <?php echo json_encode($productQuantities); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)', // Add more colors as needed
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)', // Add more colors as needed
                ],
                borderWidth: 1
            }]
        },
        options: {
            // Add any options you want here
        }
    });
</script>

<?php 

if ($_SESSION['User_type'] == 'Admin') {
    include 'navbaradmin.php'; // Include admin navbar
} elseif ($_SESSION['User_type'] == 'User') {
    include 'navbaruser.php'; // Include user navbar
} ?>
</body>
</html>
