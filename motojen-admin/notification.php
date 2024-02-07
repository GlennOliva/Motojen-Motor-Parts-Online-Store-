<?php include('config/dbcon.php');

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_css/admin.css">
    <link rel="stylesheet" href="notif.css">
    <link rel="icon" href="images/motojenlogofinal.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin Dashboard</title>
</head>

<body>

<?php
if(!isset($_SESSION['admin_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "admin-login.php";
                                    });
                                </script>';
                                exit;
}

?>

    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                <img src="images/motojenlogofinal.png">
                  
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard.php">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="notification.php"  class="active">
                    <span class="material-icons-sharp">
                        notifications
                    </span>
                    <h3>Notification</h3>
                </a>
                <a href="users.php">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="product.php" >
                    <span class="material-icons-sharp">
                    inventory_2
                    </span>
                    <h3>Product</h3>
                </a>

                <a href="appointment.php" >
                    <span class="material-icons-sharp">
                    book_online
                    </span>
                    <h3>Product Appointment</h3>
                </a>

                <a href="services.php" >
                    <span class="material-icons-sharp">
                   home_repair_service
                    </span>
                    <h3>Services</h3>
                </a>
                <a href="service-income.php"  >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Service Income</h3>
                </a>
                <a href="index.php"  >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Income Analytics</h3>
                </a>
                <a href="adminacc.php">
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <h3>Admin Accounts</h3>
                    
                </a>

                <a href="productorder.php" >
                    <span class="material-icons-sharp">
                        shopping_cart
                    </span>
                    <h3>Product Orders</h3>
                </a>

                <a href="serviceappoint.php">
                    <span class="material-icons-sharp">
                        shopping_cart
                    </span>
                    <h3>Service Appoint</h3>
                </a>
           
                
                <a href="admin-logout.php" style="padding-top: 20%;">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <div class="container" >
      <header style="margin-top: 30%;">
        <div class="notif_box" style="margin: 0 auto;">
          <h2 class="title">Notifications</h2>
          <span id="notifes"></span>
        </div>
        <p id="mark_all">Mark all as read</p>
      </header>
      <?php
$sql = "SELECT * FROM tbl_appointment";
$res = mysqli_query($conn, $sql);

$count = mysqli_num_rows($res);

if ($count > 0) {
    ?>

    <main style="margin-top: 25%; ">
        <div class="notification-container">

            <?php
            while ($row = mysqli_fetch_assoc($res)) {
                $user_id = $row['user_id'];
                $appointment_started = $row['appointment_started'];
                $status = $row['status'];
                $hour = $row['hour'];
                $total_cost = $row['total_cost'];
                $appointment_ended = $row['appointment_ended'];
                $timestamp = strtotime($appointment_started); // Convert to a Unix timestamp
                ?>
                <div class="notif_card unread" style="margin: 3%;">
                    <div class="description">
                        <p class="user_activity">
                            <strong>User_id: <?php echo $user_id; ?></strong> appointment started at <?php echo $appointment_started; ?> and your appointment ended at
                            <?php echo $appointment_ended; ?> services per hour is: <?php echo $hour;?> and the total cost service per hour is: <?php echo $total_cost;?>
                            <br>
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

     

            




    <script src="notif.js"></script>
        
        <!-- End of Main Content -->

        <!-- Right Section -->
      <!-- Right Section -->
      <div class="right-section" >
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <?php
              

            if(isset($_SESSION['admin_id']))

            {
                $admin_id = $_SESSION['admin_id'];
               
            
               
                //sql query to get all data in database
                $sql2 = "SELECT * FROM tbl_admin WHERE id = $admin_id";

                //check if the query is executed or not
                $result2 = mysqli_query($conn,$sql2);

                //count rows to check if we have foods or not in database
                $count2 = mysqli_num_rows($result2);

              

                if($count2>0)
                {
                    //we have food
                    while($row1=mysqli_fetch_assoc($result2))
                    {
                        //GET THE VALUE FROM INDI COLS
                        $username = $row1['username'];
                        $image_name = $row1['image'];

                    ?>
                            <div class="profile">
                        <div class="info">
                            <p>Welcome Back: <b><?php echo $username;?></b></p>
                        </div>
                        <div class="profile-photo">
                        <?php
                                if($image_name=="")
                                {
                                    // we don't have image 
                                    echo '<script>
                                        swal({
                                            title: "Error",
                                            text: "Food image not available",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "product.php";
                                        });
                                    </script>';
                                    exit;
                                }
                                else
                                {

                                    //we have image
                                    ?>

                                        <img src="images/admin/<?php echo $image_name?>" >

                                    <?php
                                }

                                ?>
                        </div>
                        </div>

                        <?php

                                

                        
                    }

                   
                
                
                
                }
                else
                {
                     //we don't have admin
                   
                     echo '<script>
                     swal({
                         title: "Error",
                         text: "Admin not available",
                         icon: "error"
                     }).then(function() {
                         window.location = "adminacc.php";
                     });
                 </script>';
                 exit;
                }

            }

                        ?>

                    


            </div>
            <!-- End of Nav -->

           

            </div>

        </div>


    <script src="index.js"></script>
    <script src="js/message-custom.js"></script>
</body>

</html>