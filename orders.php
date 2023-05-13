<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<!-- Nag plain ditoy kase masadotakon uwuwuwu -->

<div class="px-48 py-10">
<section class="placed-orders">

<h1 class="text-3xl font-semibold pb-5">Track your Orders</h1>

<div class="flex flex-wrap space-x-5">

   <?php
      $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($order_query) > 0){
         while($fetch_orders = mysqli_fetch_assoc($order_query)){
   ?>
   <div class="border border-b px-4 py-2 rounded w-96">
      <p> Order Placed on : <span  class="font-semibold"> <?php echo $fetch_orders['placed_on']; ?></span> </p>
      <p> Name : <span  class="font-semibold"><?php echo $fetch_orders['name']; ?></span> </p>
      <p> Number : <span  class="font-semibold"b><?php echo $fetch_orders['number']; ?></span> </p>
      <p> Email Address : <span  class="font-semibold"><?php echo $fetch_orders['email']; ?></span> </p>
      <p> Address : <span  class="font-semibold"><?php echo $fetch_orders['address']; ?></span> </p>
      <p> Payment method : <span  class="font-semibold"><?php echo $fetch_orders['method']; ?></span> </p>
      <p> Ordered Items : <span  class="font-semibold"><?php echo $fetch_orders['total_products']; ?></span> </p>
      <p> Total price : <span  class="font-semibold">P<?php echo $fetch_orders['total_price']; ?></span> </p>
      <p> Payment Status : <span style="color:<?php if($fetch_orders['payment_status'] == 'Pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
      </div>
   <?php
    }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>
</div>

</section>

</div>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>