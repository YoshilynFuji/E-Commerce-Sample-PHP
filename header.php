<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<script src="https://cdn.tailwindcss.com"></script>
<style>
   nav a.active {
    text-decoration: underline;
    text-decoration-thickness: 1px;
    text-underline-offset: 3px;
    color: #e79e18;
   }
   nav a:hover {
   text-decoration: underline;
   text-decoration-thickness: 1px;
   text-underline-offset: 3px;
   color: #a26f11;
   }
</style>

<header class="px-48 text-yellow-700">
   <div class="flex items-center justify-between py-10">
      <div class="header-1">
         <div class="flex">
            <div class="space-x-4 text-2xl">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
               <a href="#" class="fab fa-linkedin"></a>
            </div>
         </div>
      </div>
      <div class="flex flex-col ml-36">
         <div class="self-center">
            <img src="./images/Logo.png" alt="" class="h-36 w-36">
         </div>
         <div class="flex">
            <nav class="space-x-10">
               <a href="home.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'home.php') !== false) echo 'class="active"'; ?>>HOME</a>
               <a href="about.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'about.php') !== false) echo 'class="active"'; ?>>ABOUT</a>
               <a href="shop.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'shop.php') !== false) echo 'class="active"'; ?>>SHOP</a>
               <a href="orders.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'orders.php') !== false) echo 'class="active"'; ?>>ORDERS</a>
            </nav>
         </div>
      </div>
      <div class="flex items-center space-x-2">
         <?php
            $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $cart_rows_number = mysqli_num_rows($select_cart_number); 
         ?>
         <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span class="rounded-full font-bold">(<?php echo $cart_rows_number; ?>)</span> </a>
         <p>Welcome Back!, <span><?php echo $_SESSION['user_name']; ?></span></p>
         <a href="logout.php" class="bg-yellow-700 px-2 py-1 rounded text-white">Logout</a>
      </div>
   </div>
</header>
