<?php include(__DIR__ . '/../motojen-admin/config/dbcon.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact us</title>
   <link rel="icon" type="image/x-icon" href="images/motojenlogofinal.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
   <h3>MotoJen Services</h3>
   <p><a href="home.php">home </a> <span> / Services</span></p>
</div>

<section class="contact">

   <div class="row">

      
   <?php
// Assuming you have a database connection established earlier as $conn

// Query to select all product details
$selectitem = "SELECT services_name,  services_price FROM tbl_services";
$itemres = mysqli_query($conn, $selectitem);

// Check if there are any products
if (mysqli_num_rows($itemres) > 0) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <span>Services Name (required)</span>
                <select id="services_name" name="services_name">
                    <option value="">Select Product</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($itemres)) {
                        $services_name = $row['services_name'];
                        $services_price = $row['services_price'];
                        echo "<option value='$services_name'  data-price='$services_price'>$services_name</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Your other input fields go here -->

            <div class="inputBox">
                <span>Price (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Price" name="price" id="price">
            </div>

            <div class="inputBox">
    <label for="duration">Duration (hours)</label>
    <input type="text" class="box" name="hour" id="duration" readonly>
</div>


            <div class="inputBox">
  <label for="datetime">Date and Time Appointment (required)</label>
  <input type="datetime-local" class="box" required placeholder="Date and Time" name="datetime_appointment" id="datetime">
</div>

<div class="inputBox">
  <label for="datetime_ended">Date and Time Appointment Ended (required)</label>
  <input type="datetime-local" class="box" required placeholder="Date and Time" name="datetime_appointment_ended" id="datetime_ended">
</div>



<script>
  // Function to calculate the duration in hours
  function calculateDuration() {
    const startTime = document.getElementById("datetime").valueAsNumber;
    const endTime = document.getElementById("datetime_ended").valueAsNumber;

    if (!isNaN(startTime) && !isNaN(endTime)) {
      const durationInMilliseconds = endTime - startTime;
      const durationInHours = durationInMilliseconds / (1000 * 60 * 60); // Convert milliseconds to hours
      document.getElementById("duration").value = durationInHours.toFixed(2); // Display the duration in hours with two decimal places
    } else {
      document.getElementById("duration").value = ""; // Clear the duration field if either start or end time is not selected
    }
  }

  // Add event listeners to the date and time input fields to recalculate the duration when they change
  document.getElementById("datetime").addEventListener("change", calculateDuration);
  document.getElementById("datetime_ended").addEventListener("change", calculateDuration);
</script>




      
        </div>
        <input type="submit" value="Book Appointment" class="btn" name="appointment">
    </form>
    <script>
        // JavaScript to handle dropdown change event
        document.getElementById("services_name").addEventListener("change", function () {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById("price").value = selectedOption.getAttribute("data-price");
        });
    </script>
    <?php
} else {
    echo "No products found.";
}
?>

   </div>

</section>


<?php
if(isset($_POST['appointment']))
{
    $user_id = $_SESSION['user_id'] ?? ''; // Use null coalescing operator to set default value

    if (empty($user_id)) {
        // Redirect if user is not logged in
        echo '<script>
            swal({
                title: "Error",
                text: "You need to be logged first before you to appointment",
                icon: "error"
            }).then(function() {
                window.location = "login.php";
            });
        </script>';
        exit;
    } else {
    $hour = $_POST['hour'];
    $services_name = $_POST['services_name'];
    $services_price = $_POST['price'];
    $appointment_start = $_POST['datetime_appointment'];
    $appointment_ended = $_POST['datetime_appointment_ended'];
    $totalcost = $services_price * $hour;

    //sql query to insert data
    $sql = "INSERT INTO tbl_appointment (user_id, services_name, price, appointment_started, appointment_ended, hour, total_cost,  status)
        VALUES ($user_id, '$services_name', $services_price, '$appointment_start', '$appointment_ended', $hour, $totalcost,  'pending')";


    //check if the sql query executed or not
    $res = mysqli_query($conn,$sql);

    if($res==true)
    {
        //data inserted
        echo '<script>
            swal({
                title: "Success",
                text: "Appointment set successfully!",
                icon: "success"
            }).then(function() {
                window.location = "home.php";
            });
         </script>';
         exit;
    }
    else
    {
        //data not inserted
        echo '<script>
            swal({
                title: "Error",
                text: "Appointment Failed",
                icon: "error"
            }).then(function() {
                window.location = "contact.php";
            });
         </script>';
         exit;
    }
}
}
?>




<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Motojen</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/loadingmoto.gif" alt="">
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>


<script src="js/script.js"></script>

</body>
</html>