<?php   include('config/dbcon.php');
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
                <a href="service-income.php"  >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Service Income</h3>
                </a>
                <a href="index.php" >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Income Analytics</h3>
                </a>
                <a href="adminacc.php" class="active">
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <h3>Admin Accounts</h3>
                    
                </a>

                <a href="productorder.php">
                    <span class="material-icons-sharp">
                        shopping_cart
                    </span>
                    <h3> Product Orders</h3>
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


        <?php

                //1get the id 
                $id = $_GET['id'];

                //create sql querty

                $sql = "SELECT * FROM tbl_admin WHERE id=$id";

                //execute the query
                $result = mysqli_query($conn,$sql);

                //check if the query is executed or not!
                if($result == True)
                {
                    //check if the data is available or not
                    $count = mysqli_num_rows($result);

                    //ccheck if we have admin data or not
                    if($count==1)
                    {
                        //display the details
                        //echo "admin available"; 
                        $row = mysqli_fetch_assoc($result);

                        $username = $row['username'];
                        $email = $row['email'];
                        $address = $row['address'];
                        $age = $row['age'];
                        $current_image = $row['image'];

                      
                    }
                    else
                    {
                        header('Location: adminacc.php');
                        exit();
                    }
                }

            ?>

        <!-- Main Content -->
    <main>
           <h1>Update Admin</h1>




           <form action="" method="post" enctype="multipart/form-data">

           <div class="dummy-image" >
        <?php

  
    
            if($current_image == "")
            {
                //image not available
                echo '<script>
                swal({
                    title: "Error",
                    text: "Image not available",
                    icon: "error"
                }).then(function() {
                    window.location = "adminacc.php";
                });
            </script>';

            exit;

            }
            else
            {
                //image available
                ?>
                    <img src="images/admin/<?php echo $current_image;?>" style="width: 30%;">

                <?php
            }
        
        ?>
        

    
    </div>


    <div class="flex">
         <div class="inputBox">
            <span>Update Username (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter username" name="name" value="<?php echo $username;?>">
         </div>

         <div class="inputBox">
            <span>Update Email (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter email" name="email" value="<?php echo $email;?>">
         </div>

         <div class="inputBox">
            <span>Update image 01 (required)</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>



         <div class="inputBox">
    <span>Update Address (required)</span>
    <textarea name="address" placeholder="enter address" class="box" required maxlength="200" cols="20" rows="3"><?php echo $address; ?></textarea>
</div>

           <!---
         <div class="inputBox">
            <span>Update Password (required)</span>
            <input type="password" class="box" required maxlength="100" placeholder="enter password" name="new_password">
         </div>

         --->


        
         <div class="inputBox">
            <span>Update Age (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter age" onkeypress="if(this.value.length == 10) return false;" name="age" value="<?php echo $age;?>">
         </div>



      </div>
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
      <input type="submit" value="Update admin" class="btn" name="update_admin">
   </form>


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


    <?php
    
        //check whether the submit button is clicked or not
        if(isset($_POST['update_admin']))
        {
            $id = $_POST['id'];
            $username = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $address = $_POST['address'];
            $current_image = $_POST['current_image'];

            //check whether upload button is click or not
            if(isset($_FILES['image']['name']))
            {
                $image_name = $_FILES['image']['name']; //new image nname

                //check if the file is available or not
                if($image_name!="")
                {
                    //image is available

                    //rename the image
                    $ext = end(explode('.', $image_name));
                    $image_name = "Admin-Pic-".rand(0000, 9999).'.'.$ext;

                    //get the source path and destination
                    $src_path = $_FILES['image']['tmp_name'];
                    $destination_path = "images/admin/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($src_path,$destination_path);

                    //check if the image is uploaded or not
                    if($upload==false)
                    {
                        //failed to upload
                        echo '<script>
                        swal({
                            title: "Error",
                            text: "Failed to upload image",
                            icon: "error"
                        }).then(function() {
                            window.location = "adminacc.php";
                        });
                    </script>';

                    exit;

                                    
                    }
                    //remove the current image if available
                    if($current_image!="")
                    {
                        //current image is available
                        $remove_path = "images/admin/".$current_image;

                        $remove = unlink($remove_path);

                        //check whether the image is remove or not
                        if($remove==false)
                        {
                            //failed to remove current image
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to remove current image",
                                icon: "error"
                            }).then(function() {
                                window.location = "adminacc.php";
                            });
                        </script>';

                        exit;

                            
                        }
                    }
                }
            }
            else
            {
                $image_name = $current_image;
            }




            //create sql query update
            $sql = "UPDATE tbl_admin SET username = '$username' , email = '$email' , age = '$age', address = '$address', image = '$image_name'  WHERE id = '$id'";

            //execute the query
            $result = mysqli_query($conn,$sql);

            //check the query executed or not
            if($result == True)
            {
                //query update sucess
                echo '<script>
                swal({
                    title: "Success",
                    text: "Admin Successfully Update",
                    icon: "success"
                }).then(function() {
                    window.location = "adminacc.php";
                });
            </script>';
            
            exit; // Make sure to exit after performing the redirect
            }
            else{
                //failed to update
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Admin Failed to  Update",
                        icon: "error"
                    }).then(function() {
                        window.location = "update-admin.php";
                    });
                </script>';

                exit;
            }
        }
    ?>


    <script src="index.js"></script>
</body>

</html>


