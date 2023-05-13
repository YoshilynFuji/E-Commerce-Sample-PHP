<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/modal.css">

</head>
<body>
   
<?php include 'header.php'; ?>



<section class="px-48 pb-16">
   <h1 class="text-4xl text-yellow-700 pb-8">Products added</h1>
   <a href="#" class="bg-yellow-950 hover:bg-red-700 text-white py-2 px-4 rounded-md my-10 text-center <?php echo ($grand_total <= 1) ? 'disabled' : ''; ?>" onclick="opendeleteAllModal()"><i class="bi bi-cart-x mr-2"></i> Remove All From Cart</a>
<div class=" flex justify-between">
    
<div class="py-10">
   <div class="flex flex-col space-y-5">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="flex gap-2">

         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="h-48 w-48 rounded-md">
         <div class="flex flex-col space-y-3 justify-center">
         <div class="font-semibold text-2xl"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">P<?php echo $fetch_cart['price']; ?></div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
           <div class="flex items-center"> 
           <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" class="w-8 text-center border border-b rounded-md">
            <p>Pcs</p>
           </div>
           <div class="flex space-x-4 py-2">
           <input type="submit" name="update_cart" value="Update" class="cursor-pointer bg-yellow-400 text-white px-2 py-1 rounded-md">
            <a href="#" class="text-white bg-red-700 rounded-md py-1 px-2" onclick="openModal('<?php echo $fetch_cart['id']; ?>')">Remove Item</a>
           </div>
         </form>
         <div class=""> SUBTOTAL:  <span class="font-bold">P<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>.00</span> </div>
         </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
   </div>
   </div>

 <div class="flex justify-center  w-1/2 h-1/2">
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
            echo '<p class="empty">Your cart is empty</p>';
         }  
      ?>
   
      <p class="font-bold text-lg py-6">Total : <span>P<?php echo $grand_total; ?></span></p>
      <div class="flex flex-col space-y-2">

         <a href="shop.php" class="bg-yellow-700 text-white px-4 py-2 rounded-md text-center"><i class="bi bi-cart-plus"></i> Continue Shopping</a>
         <a href="checkout.php" class="bg-green-900 text-white px-4 py-2 rounded-md text-center <?php echo ($grand_total > 0)?'':'disabled'; ?>"><i class="bi bi-cart-check"></i> Proceed to Checkout</a>
      </div>
   </div>
  

</div>
 </div>

</div>
</section>

<!--Delete all items modal -->
<div id="deleteAllModal" class="modal" style="display:none">
<div class="modal-dialog">
   <h2>Remove All Items?</h2>
   <p>Are you sure you want to remove all items from the cart?</p>
   <button type = "button" onclick="deleteAllCart()" class="text-white bg-gray-500 rounded-md py-1 px-2 ml-2" >Yes, Remove</button>
   <button onclick="closedeleteAllModal()">Cancel</button>
</div>
</div>

<!--Delete item modal -->
<div id="modal" class="modal" style="display:none">
<div class="modal-dialog">
   <h2>Remove Item?</h2>
   <p>Are you sure you want to remove this item from the cart?</p>
   <button type = "button" onclick="deleteCart()" class="text-white bg-gray-500 rounded-md py-1 px-2 ml-2" >Yes, Remove</button>
   <button onclick="closeModal()">Cancel</button>
</div>
</div>


<?php include 'footer.php'; ?>s

<!-- script to toggle delete all item button -->
<script>
function opendeleteAllModal() {
   if(<?php echo $grand_total ?> > 0){
        var modal = document.getElementById('deleteAllModal').style.display = "flex";
    }
}

function closedeleteAllModal() {
    var modal = document.getElementById('deleteAllModal').style.display = "none";
}

function deleteAllCart(){
   window.location.href ="cart.php?delete_all"
}
</script>

<!-- script to toggle delete button-->
<script>
var cartIdToDelete;
function openModal(cartId) {
    cartIdToDelete = cartId;
    document.getElementById("modal").style.display = "flex";
}
function closeModal() {
    document.getElementById("modal").style.display = "none";
}
function deleteCart() {
    window.location.href = "cart.php?delete=" + cartIdToDelete;
}
</script>


<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
function updateCart(input) {
   var cart_id = input.form.elements['cart_id'].value;
   var cart_quantity = input.value;
   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'update_cart.php', true);
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   xhr.onload = function() {
      if (xhr.status === 200 && xhr.responseText !== 'error') {
         location.reload();
      }
   };
   xhr.send('cart_id=' + cart_id + '&cart_quantity=' + cart_quantity);
}
</script>


</body>
</html>