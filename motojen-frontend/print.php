
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inato's Food Ordering Receipt</title>
    <link rel="icon" type="image/x-icon" href="images/motojenlogofinal.png">
    <link rel="stylesheet" href="print.css" />
  </head>
  <body>
    <div class="buttons-container">
      <button id="save">Save</button>
      <button id="print">Print</button>
      <button id="back" style="background-color: red;">Back</button>
    </div>
    <a id="save_to_image">
      <div class="invoice-container">
        <table cellpadding="0" cellspacing="0">
          <tr class="top">
            <td colspan="2">
              <table>
                <tr>
                  <td class="title">
                    <img
                      src="images/motojenlogofinal.png"
                      style="width: 100%; max-width: 200px"
                    />
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr class="information">
            <td colspan="2">
              <table>
                <tr>
                  <td>
                    MotoJen motor parts & services<br />
                    Manila<br />
                  </td>
                  
                </tr>
              </table>
            </td>
          </tr>

          <?php     
            $order_id = $_GET['id'];
            $sql = "SELECT * FROM tbl_billing WHERE id = $order_id";
            //check the query if executed or not
            $res = mysqli_query($conn,$sql);

            //count the row
            $count = mysqli_num_rows($res);

            if($count> 0)
            {
              while($row = mysqli_fetch_assoc($res))
              {
                $id = $row['id'];
                $user_id = $row['user_id'];
                $name = $row['name'];
                $number = $row['number'];
                $method = $row['method'];
                $address = $row['address'];
                $total_products = $row['total_products'];
                $total_price = $row['total_price'];
                $place_on1 = $row['place_on'];
                $payment_status = $row['order_status'];
              }
            }
          
          
          ?>

            <tr class="heading">
            <td>Customer Name</td>
            <td>User #</td>
          </tr>
          <tr class="details">
            <td><?php echo $name?></td>
            <td><?php echo $user_id;?></td>
          </tr>
          
          <tr class="heading">
            <td>Payment Method</td>
            <td>Order #</td>
          </tr>
          <tr class="details">
            <td><?php echo $method?></td>
            <td><?php echo $id;?></td>
          </tr>
          <tr class="heading">
            <td>Products</td>
            <td>Total Price</td>
          </tr>
          <tr class="item">
            <td><?php echo $total_products?></td>
             <td><?php echo $total_price?></td>
          </tr>
          
          
        </table>
      </div>
    </a>
    <script src="html2canvas.js"></script>
    <script src="print.js"></script>
  </body>
</html>
