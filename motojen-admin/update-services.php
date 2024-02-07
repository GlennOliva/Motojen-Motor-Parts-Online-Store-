<?php
include('config/dbcon.php');

session_start();

//check if id is set or not
if(isset($_GET['id']))
{
    //get all the details
    $id = $_GET['id'];

    //sql query to get the selected Services
    $sql = "SELECT * FROM tbl_services WHERE id = $id";

    //execute the query
    $result = mysqli_query($conn,$sql);

    //get the value based on query executed
    $row = mysqli_fetch_assoc($result);

    //get the individuals values of selected Services
    $services_name = $row['services_name'];
    $services_price = $row['services_price'];
}
else
{
    //redirect to product.php
    echo '<script>
                    swal({
                        title: "Error",
                        text: "Services Failed to  Update",
                        icon: "error"
                    }).then(function() {
                        window.location = "services.php";
                    });
                </script>';

                exit;
}


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
                <a href="services.php" class="active">
                    <span class="material-icons-sharp">
                   home_repair_service
                    </span>
                    <h3>Services</h3>
                </a>
                <a href="adminacc.php">
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <h3>Admin Accounts</h3>
                    
                </a>

                <a href="productorder.php">
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
           <h1>Update Product</h1>

          


           <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">

      
     
         <div class="inputBox">
            <span>Update service name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="services_name" value="<?php echo $services_name;?>">
         </div>
         <div class="inputBox">
            <span>Update service price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price" value="<?php echo $services_price;?>">
         </div>
       


      </div>
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="submit" value="Update Services" class="btn" name="update_services">
   </form>


   <?php
   
            if(isset($_POST['update_services']))
            {
                //get all the details from form
                $id = $_POST['id'];
                $services_name = $_POST['services_name'];
                $services_price = $_POST['price'];

               

                //update the services in database
                $sql2 = "UPDATE tbl_services SET services_name = '$services_name'
                , services_price = $services_price  WHERE id = $id";

                //execute the sql query
                $result2 = mysqli_query($conn,$sql2);

                //check if the query is executed or not
                if($result2==true)
                {
                    //query executed and services updated successfully
                    echo '<script>
                    swal({
                        title: "Success",
                        text: "Service Successfully Update",
                        icon: "success"
                    }).then(function() {
                        window.location = "services.php";
                    });
                </script>';

                exit;


  
                }
                else
                {
                    //failed to update
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to update",
                        icon: "error"
                    }).then(function() {
                        window.location = "update-services.php";
                    });
                </script>';

                exit;

                   
                }
            }
   ?>


        </main>
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

                //count rows to check if we have Servicess or not in database
                $count2 = mysqli_num_rows($result2);

              

                if($count2>0)
                {
                    //we have Services
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
                                            text: "Services image not available",
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
</body>

</html>