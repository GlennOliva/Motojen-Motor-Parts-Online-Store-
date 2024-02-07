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
    <link rel="stylesheet" href="admin_css/product.css">
    <link rel="icon" href="images/motojenlogofinal.png" type="image/x-icon">
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
                <a href="notification.php">
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

                <a href="product.php"  >
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
                <a href="services.php">
                    <span class="material-icons-sharp">
                   home_repair_service
                    </span>
                    <h3>Services</h3>
                </a>
                <a href="adminacc.php" >
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <h3>Admin Accounts</h3>
                    
                </a>
               
        
                <a href="productorder.php" class="active">
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
        <main>
    <h1>Update Order</h1>
    <form action="" method="post">
        <div class="flex">

            <?php
            // SQL query to display the order status of user
            $id = $_GET['id'];

            $display_status = "SELECT * FROM tbl_appointment WHERE id = $id";

            // Check if the query is executed or not
            $statusres = mysqli_query($conn, $display_status);

            // Count the rows
            $statscount = mysqli_num_rows($statusres);

            if ($statscount > 0) {
                while ($statusrow = mysqli_fetch_assoc($statusres)) {
                    $order_id = $statusrow['id'];
                    $payment_status = $statusrow['status'];
                }
            }

            ?>

            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <select name="payment_status" class="select">
                    <option selected disabled></option>
                    <option value="Pending" <?php if ($payment_status === "pending") echo "selected"; ?>>Pending</option>
                    <option value="not_available" <?php if ($payment_status === "not_available") echo "selected"; ?>>Not Available</option>
                    <option value="ready_to_repair" <?php if ($payment_status === "ready_to_repair") echo "selected"; ?>>Ready to repare</option>
                    <option value="complete" <?php if ($payment_status === "complete") echo "selected"; ?>>Completed</option>
                </select>
                <input type="submit" value="Update Appointmentr Status" class="btn" name="update_appointment">
            </form>

        </div>
    </form>
</main>

<?php

if(isset($_POST['update_appointment']))
{
    $id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];

    //sql query for update
    $updatequery = "UPDATE tbl_appointment SET status = '$payment_status' WHERE id = $id";

    //check the query if executed or not
    $updateres = mysqli_query($conn,$updatequery);

    if($updateres==true)
    {
        //data update
        echo '<script>
        swal({
            title: "Success",
            text: "Appoinment status Updated",
            icon: "success"
        }).then(function() {
            window.location = "appointment.php";
        });
    </script>';

    exit;

    }
    else
    {
        //data failed to update
        echo '<script>
        swal({
            title: "Error",
            text: "Failed to update status",
            icon: "error"
        }).then(function() {
            window.location = "update-appointment.php";
        });
    </script>';

    exit;
    }
}

?>

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


    </div>


    <script src="index.js"></script>
</body>

</html>