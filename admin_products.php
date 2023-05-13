<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

      if($add_product_query){
         if($image_size > 20000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
   <link rel="stylesheet" href="css/modal.css">

   <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- Add Product na part -->

<div class="px-48 py-10">
   <h1 class="text-4xl text-yellow-700" id="head">Products Dashboard</h1>
<div class="flex  py-10">
   
   <section class="border border-b rounded-md px-4 py-6 h-80" data-aos="fade-up">
   
   
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="text-xl font-semibold text-yellow-700">Add a Product</h3>
      <div class="flex flex-col space-y-4">
      <input type="text" name="name" class="border border-b rounded-md my-2 px-4 py-2 focus:border-yellow-700" placeholder="Product Name" required>
      <input type="number" min="0" name="price" class="border border-b rounded-md my-2 px-4 py-2 focus:border-yellow-700" placeholder="Product Price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="border border-b rounded-md my-2 px-4 py-2 w-60" required>
      <input type="submit" value="Add Product" name="add_product" class="text-white font-semibold bg-yellow-700 rounded-md px-4 py-2 cursor-pointer">
      </div>
   </form>
   
   </section>
   
 <!-- Shows product with option mag remove -->
   
   <section class="px-4" data-aos="fade-down">
   
   <div class="grid md:grid-cols-2 xl:grid-cols-3 flex-wrap gap-5">
   
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="sm:w-15 sm:h-16 xl:w-48 xl:h-48 bg-fit rounded-md">
         <div class="text-lg py-1 font-semibold"><?php echo $fetch_products['name']; ?></div>
         <div class="py-1">P<?php echo $fetch_products['price']; ?></div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="text-white bg-yellow-500 rounded-md py-1 px-2 text-sm mr-2">Update</a>
         <a href="#" class="text-white bg-red-700 rounded-md py-1 px-2 text-sm mr-2" onclick="openModal('<?php echo $fetch_products['id']; ?>')">Delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </section>

<!-- Shows update section -->
<section class="float-right" data-aos="fade-up">

<?php
   if(isset($_GET['update'])){
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
      if(mysqli_num_rows($update_query) > 0){
         while($fetch_update = mysqli_fetch_assoc($update_query)){
?>
<form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image"  value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="" class="w-24 h-24 bg-cover mb-4">
      <label class="text-sm">Product Name:</label><br>
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="border border-b rounded-md my-2 px-3 py-1 focus:border-yellow-700 text-sm"  required placeholder="Enter product name"><br>
      <label class="text-sm">Product Price:</label><br>
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="border border-b rounded-md my-2 px-3 py-1 focus:border-yellow-700 text-sm"  required placeholder="Enter product price"><br>
      <input type="file" class="box mt-1 text-sm" name="update_image" accept="image/jpg, image/jpeg, image/png"><br><br>
      <div class="flex justify-left">
      <input type="submit" value="Update" name="update_product" class="text-white bg-yellow-500 rounded-md py-1 px-2 text-sm mr-2">
      <button type="button" onclick="closeSection()" class="text-white bg-gray-500 rounded-md py-1 px-2 text-sm">Cancel</button>
</form>
<?php
      }
   }
   }else{
      
   }
?>


</section>
</div>
</div>

<!--Delete Modal-->
<div id="modal" class="modal" style="display:none">
    <div class="modal-dialog">
        <h2>Delete Product?</h2>
        <p>Are you sure you want to delete this product?</p>
        <button type = "button" onclick="deleteProduct()" class="text-white bg-gray-500 rounded-md py-1 px-2 ml-2" >Yes, Delete</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<!-- script for the cancel button -->
<script>
function closeSection() {
   var section = document.querySelector('section.float-right');
   section.style.display = 'none';
}
</script>

<!-- script to toggle delete button-->
<script>
var productIdToDelete;
function openModal(productId) {
    productIdToDelete = productId;
    document.getElementById("modal").style.display = "flex";
}
function closeModal() {
    document.getElementById("modal").style.display = "none";
}
function deleteProduct() {
    window.location.href = "admin_products.php?delete=" + productIdToDelete;
}
</script>


<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

<script>
   const menuToggle = document.getElementById('menu-toggle');
   const menu = document.getElementById('menu');
   menuToggle.addEventListener('click', () => {
      menu.classList.toggle('hidden');
   });
</script>

</body>
</html>