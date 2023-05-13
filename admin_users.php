<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/modal.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="px-48 py-10 flex flex-col justify-center ">

   <h1 class="text-4xl text-yellow-700" id="head"> User Accounts </h1>

   <div class="grid grid-cols-4 py-10 gap-10">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="border border-b py-4 px-4 space-y-2 rounded-md">
         <h1 class="font-bold text-lg">User Details</h1>
         <p> User id : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> Username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> Email Address : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> User Type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <br>
         <a href="#" class="text-white bg-red-700 rounded-md py-1 px-2 text-sm mr-2" onclick="openModal('<?php echo $fetch_users['id']; ?>')">Delete User</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>

<div id="modal" class="modal" style="display:none">
    <div class="modal-dialog">
        <h2>Delete User?</h2>
        <p>Are you sure you want to remove this user?</p>
        <button type = "button" onclick="deleteProduct()" class="text-white bg-gray-500 rounded-md py-1 px-2 ml-2" >Yes, Remove</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>


<script>
var userIdToDelete;
function openModal(userId) {
    userIdToDelete = userId;
    document.getElementById("modal").style.display = "flex";
}
function closeModal() {
    document.getElementById("modal").style.display = "none";
}
function deleteProduct() {
    window.location.href = "admin_users.php?delete=" + userIdToDelete;
}
</script>

</body>
</html>