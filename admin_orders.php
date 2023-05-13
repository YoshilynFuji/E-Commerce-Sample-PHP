<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){
   $order_update_id = $_POST['order_id'];
   if(isset($_POST['update_payment'])){
      $update_payment = $_POST['update_payment'];
      mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
      $message[] = 'Payment status has been updated!';
   } else {
      $message[] = 'Payment status has been updated!';
   }
}

if(isset($message)){
   echo '
   <script>
      window.onload = function() {
         var modal = document.getElementById("modal");
         var message = document.getElementById("modalMessage");
         message.innerHTML = "' . $message[0] . '";
         modal.style.display = "flex";
         window.onclick = function(event) {
            if (event.target == modal) {
               modal.style.display = "none";
            }
         }
      }

      function closeModal() {
         var modal = document.getElementById("modal");
         modal.style.display = "none";
      }
   </script>

   <div id="modal" class="modal" style="display:none">
      <div class="modal-dialog">
         <p id="modalMessage"></p>
         <button onclick="closeModal()">Close</button>
      </div>
   </div>
   ';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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
   
   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
   <link rel="stylesheet" href="css/modal.css">

</head>
<body>
<?php include 'admin_header.php'; ?>

<section id="head"class="px-48 py-10 flex flex-col justify-center ">

   <h1 class="text-4xl text-yellow-700" id="head">Placed Orders</h1>

   <div class="grid grid-cols-3 py-10 gap-10" data-aos="fade-up">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="border border-b py-4 px-4 space-y-1 rounded-md">
         <h1 class="text-lg font-bold">Order Summary</h1>
         <p> Order Placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Recepient Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Contact Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email Address : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Address : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Total Products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total Price : <span class="font-bold">P<?php echo $fetch_orders['total_price']; ?></span> </p>
         <p> Payment Method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment" class="border border-b my-4 px-2 py-1 rounded-md cursor-pointer">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="Pending">Pending</option>
               <option value="Completed">Completed</option>
         </select>
            <input type="submit" value="Update" name="update_order" class="text-white bg-yellow-500 rounded-md py-1 px-2 text-sm mr-2">
            <!--<a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="text-white bg-red-700 rounded-md py-1 px-2">Delete</a>-->
            <a href="#" class="text-white bg-red-700 rounded-md py-1 px-2 text-sm mr-2" onclick="openModal('<?php echo $fetch_orders['id']; ?>')">Delete</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="text-center text-xl">There are No Orders</p>';
      }
      ?>
   </div>

</section>

<!-- Delete Modal -->
<div id="modal" class="modal" style="display:none">
    <div class="modal-dialog">
        <h2>Delete Order?</h2>
        <p>Are you sure you want to delete this order?</p>
        <button type = "button" onclick="deleteOrder()" class="text-white bg-gray-500 rounded-md py-1 px-2 ml-2" >Yes, Delete</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>
var orderIdToDelete;
function openModal(orderId) {
    orderIdToDelete = orderId;
    document.getElementById("modal").style.display = "flex";
}
function closeModal() {
    document.getElementById("modal").style.display = "none";
}
function deleteOrder() {
    window.location.href = "admin_orders.php?delete=" + orderIdToDelete;
}
</script>



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>