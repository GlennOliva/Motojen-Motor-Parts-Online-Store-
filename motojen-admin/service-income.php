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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" href="images/motojenlogofinal.png" type="image/x-icon">
    
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

                <a href="services.php">
                    <span class="material-icons-sharp">
                   home_repair_service
                    </span>
                    <h3>Services</h3>
                </a>

                <a href="service-income.php" class="active" >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Service Income</h3>
                </a>

                <a href="index.php">
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
        
        <main>
    
            <h1>Analytics</h1>
            <!-- Analyses -->

            <div class="print-btn-container">
    <form method="POST" class="dateform">
        <label for="from_date" class="from_date">From Date:</label>
        <input type="date" id="from_date" name="from_date">
        <label for="to_date" class="to_date">To Date:</label>
        <input type="date" id="to_date" name="to_date">
        <input type="submit" name="submit" value="Filter">
    </form>

    <button class="print-btn" onclick="window.print()"><i class="material-icons-sharp">print</i></button>
</div>

<table class="tbl-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>User_Id</th>
            <th>Service_Name</th>
            <th>Price</th>
            <th>Hour</th>
            <th>Total Cost</th>
            <th>Appointment_Started</th>
            <th>Appointment_Ended</th>
            <th></th>
            <th></th>
            <th></th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialize the date variables
        $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : null;
        $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : null;

        // Build the SQL query
        $income = "SELECT * FROM tbl_appointment WHERE status = 'paid'";
        if ($from_date && $to_date) {
            $income .= " AND appointment_started >= '$from_date' AND appointment_started <= '$to_date'";
        }

        // Execute the query
        $incomeres = mysqli_query($conn, $income);
        $totalSum = 0;

        // Count the rows
        $incomecount = mysqli_num_rows($incomeres);

        // Check the count greater than 0 
        if ($incomecount > 0) {
            $ids = 1;
            // Fetch the data
            while ($incomerow = mysqli_fetch_assoc($incomeres)) {
                // ... Fetch the data as before
                $id = $incomerow['id'];
                $user_id = $incomerow['user_id'];
                $services_name = $incomerow['services_name'];
                $services_price = $incomerow['price'];
                $appointment_started = $incomerow['appointment_started'];
                $appointment_ended = $incomerow['appointment_ended'];
                $payment_status = $incomerow['status'];
                $hour = $incomerow['hour'];
                $totalcost = $incomerow['total_cost'];
                $totalSum += $totalcost;

                ?>
                <tr>
                    <td><?php echo $ids++;?></td>
                    <td><?php echo $user_id;?></td>
                    <td><?php echo $services_name;?></td>
                    <td><?php echo $services_price;?></td>
                    <td><?php echo $hour;?></td>
                    <td><?php echo $totalcost;?></td>
                    <td><?php echo $appointment_started;?></td>
                    <td><?php echo $appointment_ended;?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $payment_status;?></td>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td colspan='6' class='rev'>This Month's Revenue Total:</td>
            <td><strong>₱ <?php echo $totalSum; ?> </strong></td>
            <td colspan='2'></td>
        </tr>
    </tbody>
</table>

            
            <!-- End of Analyses -->

            

        </main>

        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section" style="margin-right: 30%;">
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