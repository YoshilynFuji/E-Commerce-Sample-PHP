<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'House No. '. $_POST['house'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['zip_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
     
   }else{
      if(mysqli_num_rows($order_query) > 0){
       
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="px-48 flex py-10">
   
<div class="flex flex-col justify-center  items-center w-1/2 h-1/2">
 <div class="w-96 px-10  flex flex-col justify-center border border-b h-full rounded-md py-10">
   <h1 class="text-3xl font-bold ">Cart Summary</h1>
   <div class="cart-total">
   <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){ 
               ?>
               <div class="flex justify-between">
               <div class=""><?php echo $fetch_cart['name']; ?></div>
               <div class=""><?php echo $fetch_cart['quantity']; ?> Pcs</div>
               </div>
   <?php       }
         }else{
            echo '<p class="empty">your cart is empty</p>';
         }  
      ?>
   
   </div>
</div>

<div id="carouselExampleIndicators" class="carousel slide rounded-md py-5">
  <div class="carousel-indicators ">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/1.png" class="d-block w-100 rounded-md" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./images/2.png" class="d-block w-100 rounded-md" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./images/3.png" class="d-block w-100 rounded-md" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon text-yellow-700" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
 </div>

<div class="flex justify-center w-1/2 h-1/2">
<section class=" border border-b rounded-md px-10 py-10  ">

<form action="" method="post">
   <h3 class="text-3xl font-bold pb-2">Place your order</h3>
   <div class="flex flex-col space-y-4">
      <div class="flex justify-between items-center">
         <span class="font-semibold">Recepient Name: </span>
         <input type="text" name="name" required placeholder="Enter your name" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Recepient's Number: </span>
         <input type="number" name="number" required placeholder="Enter your number" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Email Address:</span>
         <input type="email" name="email" required placeholder="Enter your email" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Payment method :</span>
         <select name="method" class="px-2 py-1 border border-b rounded-md">
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Credit card">Credit card</option>
            <option value="Paypal">Paypal</option>
            <option value="Gcash">GCash</option>
         </select>
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">House No.:</span>
         <input type="number" min="0" name="house" required placeholder="House/Street No." class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Barangay:</span>
         <input type="text" name="street" required placeholder="Barangay/Sitio" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">City :</span>
         <input type="text" name="city" required placeholder="Ex. Laoag City" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Province :</span>
         <input type="text" name="state" required placeholder="Ex. Ilocos Norte" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Country :</span>
         <input type="text" name="country" required placeholder="Ex. Philippines" class="px-2 py-1 border border-b rounded-md">
      </div>
      <div class="flex justify-between items-center">
         <span class="font-semibold">Zip Code:</span>
         <input type="number" min="0" name="zip_code" required placeholder="Ex. 2900" class="px-2 py-1 border border-b rounded-md">
      </div>
   </div>
   <input type="submit" value="Confirm Order" class="cursor-pointer bg-green-900 text-white px-4 py-2 my-4 rounded-md w-full" name="order_btn">
</form>

</section>
</div>
</div>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>