<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin</title>

   <script src="https://cdn.tailwindcss.com"></script>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="./css/styles.css">

   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section id="robot"class="px-48 py-10 flex flex-col justify-center ">

   <h1 class="text-4xl text-yellow-700" id="">Dashboard</h1>

   <div class="grid grid-cols-2 gap-5 py-5 " data-aos="fade-up">
   <div class="">
      
      <h1 class="font-bold py-2">Manage Payments and Others</h1>
      <div class="flex space-x-4">
         
      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
      <i class="bi bi-cash-coin text-yellow-700"></i>
      <p class="font-semibold">Pending Payments</p>
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            if(mysqli_num_rows($select_pending) > 0){
               while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                  $total_price = $fetch_pendings['total_price'];
                  $total_pendings += $total_price;
               };
            };
         ?>
         <h3>P <?php echo $total_pendings; ?></h3>
         
      </div>

      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
         ?>
         <i class="bi bi-wallet2 text-yellow-700"></i>
         <p class="font-semibold">Received Payments</p>
         <h3>P<?php echo $total_completed; ?></h3>
         
      </div>
      </div>
   </div>

     <div class="">
      <h1 class="py-2 font-bold">Track Number of Orders</h1>
      <div class="flex space-x-4">
     <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <i class="bi bi-box-seam text-yellow-700" id="logo"></i>
         <p class="font-semibold">Pending Orders</p>
         <h3><?php echo $number_of_orders; ?></h3>
         
      </div>

      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <i class="bi bi-box-seam text-yellow-700" id="logo"></i>
         <p class="font-semibold">Completed Orders</p>
         <h3><?php echo $number_of_orders; ?></h3>
         
      </div>
     </div>
         </div>

      <div class="">
         <h1 class="py-2 font-bold">Manage Proucts</h1>
      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <i class="bi bi-cart4 text-yellow-700" id="logo"></i>
         <p class="font-semibold">Number of Products</p>
         <h3><?php echo $number_of_products; ?></h3>
         
      </div>
      </div>

     <div class="">
      <h1 class="py-2 font-bold">Accounts and Users</h1>
     <div class="flex space-x-4">
     <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <i class="bi bi-person text-yellow-700" id="logo"></i>
         <p class="font-semibold">Users</p>
         <h3><?php echo $number_of_users; ?></h3>
         
      </div>

      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
         <i class="bi bi-person-lock text-yellow-700" id="logo"></i>
         <p class="font-semibold">Admin Users</p>
         <h3><?php echo $number_of_admins; ?></h3>
         
      </div>

      <div class="px-4 py-2 w-48 h-32 border border-b rounded-md">
         <?php 
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <i class="bi bi-person-rolodex text-yellow-700" id="logo"></i>
         <p class="font-semibold">Total Accounts</p>
         <h3><?php echo $number_of_account; ?></h3>
         
      </div>
     </div>
     </div>

      
   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>