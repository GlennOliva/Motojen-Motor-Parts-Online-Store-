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
   <title>update profile</title>
   <link rel="icon" type="image/x-icon" href="images/motojenlogofinal.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

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

<section class="form-container">

<?php
// Your database connection and user_id retrieval code here

// Fetch user data from the database
$sql = "SELECT * FROM tbl_user WHERE id = $user_id";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $email = $row['email'];
    $number = $row['number'];
    $address = $row['address'];
}
?>

<form action="" method="POST">
    <h3>Update profile</h3>
    <input type="text" required maxlength="20" name="name" placeholder="Enter your name" value="<?php echo $name; ?>" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="email" required maxlength="50" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="number" min="0" max="9999999999" value="<?php echo $number; ?>" onkeypress="if(this.value.length == 10) return false;" placeholder="Enter your number" required class="box" name="number">
    <input type="password" maxlength="20" name="old_pass" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" maxlength="20" name="new_pass" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" maxlength="20" name="confirm_pass" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="Update now" class="btn" name="submit">
</form>

<?php
if (isset($_POST['submit'])) {
    // Update user data based on form input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $old_pass = $_POST['old_pass'];
    $confirm_pass = md5($_POST['confirm_pass']);
    $new_pass = $_POST['new_pass'];

    // SQL query to update user data
    $update = "UPDATE tbl_user SET name = '$name', email = '$email', number = $number, password = '$confirm_pass' WHERE id = $user_id";

    // Execute the query
    $upres = mysqli_query($conn, $update);

    if ($upres === true) {
        // Update success
        echo '<script>
        swal({
            title: "Success",
            text: "User Account Updated Success",
            icon: "success"
        }).then(function() {
            window.location = "profile.php";
        });
        </script>';
        exit;
    } else {
        // Error message
        echo '<script>
        swal({
            title: "Error",
            text: "User Account Failed to update",
            icon: "error"
        }).then(function() {
            window.location = "update_profile.php";
        });
        </script>';
        exit;
    }
}
?>

   

</section>


<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Motojen</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/loadingmoto.gif" alt="">
</div>

<script src="js/script.js"></script>

</body>
</html>