<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
   //  Mabalin mangipan message if item is already in cart pero kasla alert kuma pero idk
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      // likewise here if na add to cart lololol
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>


<section class="px-48 pb-24">
<div class="flex pb-20 gap-2">
<i class="bi bi-bag-fill text-4xl text-yellow-700"></i>
   <h1 class="text-4xl text-yellow-700 text-semibold">Latest products</h1>
</div>

   <div class="flex flex-wrap gap-7" data-aos="fade-up">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="h-48 w-48 rounded-md" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="text-lg font-semibold text-yellow-700"><?php echo $fetch_products['name']; ?></div>
      <div class="price">P<?php echo $fetch_products['price']; ?></div>
      <div class="flex justify-between">
      <input type="number" min="1" name="product_quantity" value="1" class="w-12 text-center border border-b rounded-md">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <div class="">
      <i class="bi bi-cart-plus absolute text-md pt-2 pl-2 text-white"></i>
      <input type="submit" value="Add to Cart" name="add_to_cart" class="bg-yellow-950 rounded-md py-2 pr-3 pl-7 text-white font-semibold cursor-pointer">
      </div>
      </div>
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>