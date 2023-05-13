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
      
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
 

</head>
<body>
   
<?php include 'header.php'; ?>


<div id="carouselExampleIndicators" class="carousel slide" data-aos="fade-up">
  <div class="carousel-indicators ">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./images/2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./images/3.png" class="d-block w-100" alt="...">
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
<section class="px-48 pb-32">

   <h1 class="text-center py-10 text-6xl text-yellow-700 py-24" id="adminheader">Handwoven and Sustainable Textiles</h1>

   <div class="flex flex-wrap justify-between" data-aos="fade-up">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 5") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="rounded-md">
      <img class="h-48 w-48 rounded-md" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" >
      <div class="text-lg font-semibold text-yellow-700"><?php echo $fetch_products['name']; ?></div>
      <div class="price">P<?php echo $fetch_products['price']; ?></div>
      <div class="flex justify-between">
      <input type="number" min="1" name="product_quantity" value="1" class="w-12 text-center border border-b rounded-md">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <div class="">
      <i class="bi bi-cart-plus absolute text-md pt-2 pl-2 text-white"></i>
      <input type="submit" value="Add to Cart" name="add_to_cart" class="bg-yellow-950 rounded-md py-2 pr-3 pl-7 text-white font-semibold cursor-pointer active:bg-yellow-700">
      </div>
      </div>
     </form>
      <?php
         }
      }else{
         echo '<p class="text-center">No Products added yet!</p>';
      }
      ?>
   </div>
   
   <div class="py-10" data-aos="fade-up">
      <h1 class="text-center py-10 text-6xl text-yellow-700 pt-24" id="adminheader">About Us</h1>
      <p class="text-md px-60 text-yellow-700 text-center">Habiya is a sourcing platform & marketplace connecting designers to regenerative tropical textiles and artisan craft so they can design for sustainable consumer lifestyles.</p>
   </div>

      <div class="py-20 flex flex-col items-center space-y-4 bg-sky-50 rounded-md text-yellow-900 rounded-md"  data-aos="fade-up">
         <h1 class="text-3xl ">SUBSCRIBE TO OUR NEWSLETTER</h1>
         <p>Sign-up to get exclusive promotions, impact updates, and early access to new products!</p>
         <div class="flex gap-2">
         <input type="text" class="rounded-md px-4 py-2 w-96 border border-b" placeholder="Enter Email">
         <button class="text-white bg-yellow-700 px-4 py-1 rounded-md">SUBSCRIBE</button>
         </div>
      </div>
   </div>
   


</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>