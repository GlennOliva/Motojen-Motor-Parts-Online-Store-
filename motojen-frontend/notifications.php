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
   <link rel="stylesheet" href="notif.css">

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
   <p><a href="home.php">home </a> <span> / Notifications</span></p>
</div>

<section class="contact">

   <div class="row">

   <div class="container">
      <header>
        <div class="notif_box">
          <h2 class="title">Notifications</h2>
          <span id="notifes"></span>
        </div>
        <p id="mark_all">Mark all as read</p>
      </header>
      <?php
$sql = "SELECT * FROM tbl_billing WHERE user_id = $user_id";
$res = mysqli_query($conn, $sql);

$count = mysqli_num_rows($res);

if ($count > 0) {
    ?>

    <main style="margin-top: 5%; ">
        <div class="notification-container">

            <?php
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $method = $row['method'];
                $order_status = $row['order_status'];
                $place_on= $row['place_on'];
                $timestamp = strtotime($place_on); // Convert to a Unix timestamp
                ?>
                <div class="notif_card unread" style="margin: 3%;">
                    <div class="description">
                        <p class="user_activity">
                            <strong>Order id: <?php echo $id; ?></strong> Order placed on at <?php echo $place_on; ?> payment_method is: <?php echo $method;?>
                            order status is: <?php echo $order_status;?>
                            <b class="time" data-timestamp="<?php echo date('Y-m-d H:i:s', $timestamp); ?>">0m ago</b>
                        </p>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </main>

<?php
}
?>
    </div>

  
   
               
          
   </div>

</section>


<script>
function updateTime() {
    var timeElements = document.getElementsByClassName("time");
    var now = new Date();

    for (var i = 0; i < timeElements.length; i++) {
        var timeElement = timeElements[i];
        var timestamp = new Date(timeElement.getAttribute("data-timestamp"));
        var timeDifference = now - timestamp;

        var hoursAgo = Math.floor(timeDifference / 3600000); // Convert milliseconds to hours
        var minutesAgo = Math.floor((timeDifference % 3600000) / 60000); // Convert remaining milliseconds to minutes

        var timeText = "";

        if (hoursAgo > 0) {
            timeText = hoursAgo + "h ago";
        } else {
            timeText = minutesAgo + "m ago";
        }

        // Update the time text
        timeElement.textContent = timeText;
    }

    // Update the time every 60 seconds
    setTimeout(updateTime, 60000);
}

// Call the updateTime function to start updating the time
updateTime();
</script>


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
<script src="notif.js"></script>

</body>
</html>