<?php
include(__DIR__ . '/../motojen-admin/config/dbcon.php');
session_start();

if(isset($_POST['delete_cartbtn']))
{
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];


    // Create SQL query for delete message
    $cartql = "DELETE FROM tbl_cart WHERE id = $cart_id";

    // Execute the delete query
    $msgresult = mysqli_query($conn, $cartql);

    if ($msgresult) {
        // Check if any rows were affected by the delete query
        if (mysqli_affected_rows($conn) > 0) {
            echo 200; // Success
        } else {
            echo 500; // Failed (no rows affected)
        }
    } else {
        echo 500; // Failed (query execution error)
    }
}
else if(isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['qty']; // Use 'qty' here

    // Prepare the SQL update statement
    $qtyupdatesql = "UPDATE tbl_cart SET quantity = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $qtyupdatesql);

    if ($stmt === false) {
        // Handle the SQL statement preparation error
        echo 600;
    } else {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ii", $quantity, $cart_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result === true) {
            // Update success
            echo 300;
            echo '<script>window.location.href = "cart.php";</script>';
        } else {
            // Failed to update
            echo 600;
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}



else if(isset($_POST['deleteall-btn']))
{
    $user_id = $_SESSION['user_id'];

    // Create SQL query for delete message
    $cartsql = "DELETE FROM tbl_cart WHERE user_id = $user_id";

    // Execute the delete query
    $cartresult = mysqli_query($conn, $cartsql);

    if ($cartresult) {
        // Check if any rows were affected by the delete query
        if (mysqli_affected_rows($conn) > 0) {
            echo 400; // Success
        } else {
            echo 800; // Failed (no rows affected)
        }
    } else {
        echo 800; // Failed (query execution error)
    }
}


?>