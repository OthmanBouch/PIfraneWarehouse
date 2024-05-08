<div class="wrapper" style="position: fixed; top: 0; left: 0; z-index: 1000;">
    <input type="checkbox" id="btn" hidden>
    <label for="btn" class="menu-btn">
        <i class="fas fa-bars"></i>
        <i class="fas fa-times"></i>
    </label>
    <nav id="sidebar">
        <div class="title">
            <h3> <a href="user_page.php" style="color: black;">Ifrane<span style="color: brown;">Warehouse</span></a>
            </h3>
        </div>
        <ul class="list-items">
            <li><a href="admin_page.php"><i class="fas fa-home"></i>Home</a></li>
            
            <li><a href="ProductManagement.php"><i class="fas fa-book"></i>Manage Product</a></li>
            <li><a href="SupplierManagement.php"><i class="fas fa-home"></i>Manage Suppliers</a></li>
            <li><a href="OrderManagement.php"><i class="bi bi-receipt-cutoff"></i>Manage Orders</a></li>
            <li><a href="StockManagement.php"><i class="fas fa-user"></i>Manage Stocks</a></li>
            <li><a href="Personnal.php"><i class="fas fa-user"></i>Profile</a></li>
            <li><a href="About.php"><i class="fas fa-envelope"></i>About Us</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <h4><span style="color:goldenrod ;"><?php echo $_SESSION['User_type'] ?></span></h4>
        </ul>
    </nav>