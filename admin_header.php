<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/modal.css">
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

<header class="px-48  text-yellow-700">

   <div class="flex justify-between items-center py-4 ml-52" id="">
      <div class="flex-none"></div>
      <div class="flex flex-col items-center flex-1">
         <div class="">
            <img src="./images/Logo.png" class="w-36 h-36 my-4"alt="">
         </div>
         <nav class="space-x-10">
         <a href="admin_page.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'admin_page.php') !== false) echo 'class="active"'; ?>>HOME</a>
         <a href="admin_products.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'admin_products.php') !== false) echo 'class="active"'; ?>>PRODUCTS</a>
         <a href="admin_orders.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'admin_orders.php') !== false) echo 'class="active"'; ?>>ORDERS</a>
         <a href="admin_users.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'admin_users.php') !== false) echo 'class="active"'; ?>>USERS</a>
         
      </nav>
      </div>

      <div class="flex items-center space-x-4 flex-none">
        
         <a href="logout.php" class="px-2 py-1 bg-yellow-700 text-white rounded-md">Log Out</a>
      </div>

   </div>

</header>