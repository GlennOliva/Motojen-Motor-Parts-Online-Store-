<?php include(__DIR__ . '/../motojen-admin/config/dbcon.php');


session_start();


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>my orders</title>
   <link rel="icon" type="image/x-icon" href="images/motojenlogofinal.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

      <!---Aos animation link-->

      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>
<body>
   
<header class="header">

   <section class="flex">

   <img  src="images/motojenlogofinal.png" class="logo" alt="" >

   <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="menu.php">Product</a>
         <a href="orders.php">Orders</a>
         <a href="contact.php">Services</a>
         <a href="notifications.php">Notifications</a>
      </nav>

      <div class="icons">
    <?php
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        //sql query for cart
        $countcartsql = "SELECT * FROM tbl_cart WHERE user_id = $user_id";

        //check the query is executed or not
        $cartres = mysqli_query($conn, $countcartsql);

        $countcarts = mysqli_num_rows($cartres);

        echo '<a href="search.php"><i class="fas fa-search"></i></a>';
        echo '<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(' . $countcarts . ')</span></a>';
    } else {
        echo '<a href="search.php"><i class="fas fa-search"></i></a>';
        echo '<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(0)</span></a>';
    }
    ?>
    <div id="user-btn" class="fas fa-user"></div>
    <div id="menu-btn" class="fas fa-bars"></div>
</div>



      <div class="profile">
    <?php

    $name = ''; // Initialize the variable to an empty string

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Assuming you have established the $conn variable for database connection

        // Your existing code to fetch user data
        $userquery = "SELECT * FROM tbl_user WHERE id = $user_id";
        $userresult = mysqli_query($conn, $userquery);
        $usercount = mysqli_num_rows($userresult);

        if ($usercount > 0) {
            while ($userow = mysqli_fetch_assoc($userresult)) {
                $name = $userow['name'];
                // You can process other data here if needed
            }
        } else {
            echo '<script>
                 swal({
                     title: "Error",
                     text: "User not available",
                     icon: "error"
                 }).then(function() {
                     window.location = "login.php";
                 });
             </script>';
            exit;
        }
    } else {
        $name = ''; // Set name to empty if user is not logged in
    }
    ?>
    <?php if ($name !== '') { ?>
    <p class="name"><?php echo $name; ?></p>
    <?php } ?>
    <div class="flex">
        <a href="profile.php" class="btn">profile</a>
        <a href="user-logut.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>
    </div>
    <p class="account"><a href="login.php">login</a> or <a href="register.php">register</a></p>
</div>   



   </section>

</header>

<div class="heading">
   <h3>your orders</h3>
   <p><a href="home.php">home </a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">placed orders</h1>

   <div class="box-container">

   <?php
// SQL query to select food orders for a specific user using prepared statement
$sql = "SELECT * FROM tbl_billing WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $res = mysqli_stmt_get_result($stmt);

    // Count the rows
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Your code to display order details
            $id = $row['id']; // Get the order ID
            $name = $row['name'];
            $number = $row['number'];
            $place_on = $row['place_on'];
            $address = $row['address'];
            $total_products = $row['total_products'];
            $total_price = $row['total_price'];
            $payment_method = $row['method'];
            $payment_status = $row['order_status'];
        
            $payment_status_class = '';
            if ($payment_status == 'complete') {
                $payment_status_class = 'green-text';
            } elseif ($payment_status == 'cancelled') {
                $payment_status_class = 'red-text';
            } elseif ($payment_status == 'pending') {
                $payment_status_class = 'brown-text';
            } 
      
            ?>
        
            <div class="box">
                <p> placed on : <span><?php echo $place_on; ?></span> </p>
                <p> name : <span><?php echo $name; ?></span> </p>
                <p> number : <span><?php echo $number; ?></span> </p>
                <p> address : <span><?php echo $address; ?></span> </p>
                <p> your orders : <span><?php echo $total_products; ?></span> </p>
                <p> total price : ₱<span><?php echo $total_price; ?></span> </p>
                <p> payment method : <span><?php echo $payment_method; ?></span> </p>
                <p> payment status : <span class="<?php echo $payment_status_class; ?>"><?php echo $payment_status; ?></span> </p>
                <p><a href="print.php?id=<?php echo $id; ?>">Click here to print your receipt</a></p>
            </div>


            <?php
        }
    } else {
        echo "No orders found.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing the SQL statement.";
}

// Close the database connection
mysqli_close($conn);
?>


      

      

   </div>

</section>











<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Motojen</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/loadingmoto.gif" alt="">
</div>

<script src="js/script.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>

</body>
</html>