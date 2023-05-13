<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <script src="https://cdn.tailwindcss.com"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="css/modal.css">

</head>
<body class="overflow-x-hidden">

 
<div class="flex flex-col h-screen w-screen" >

<div class="flex flex-col justify-center items-center w-full py-12" id="adminpage ">
<img src="./images/Logo.png" alt="" class="w-40 h-40 my-6">
<div class="border border-b py-10 px-8 rounded-md">

<form action="" method="post">
    <h3 class="text-4xl font-bold py-10">Create an Account</h3>
    <div class="flex flex-col space-y-4 pb-10">
        <input type="text" name="name" placeholder="Name" required class="px-4 py-2 border border-b rounded-md text-lg w-80">
        <input type="email" name="email" placeholder="Email" required class="px-4 py-2 border border-b rounded-md text-lg w-80">
        <input type="password" name="password" placeholder="Password" required class="px-4 py-2 border border-b rounded-md text-lg w-80">
        <input type="password" name="cpassword" placeholder="Confirm Password" required class="px-4 py-2 border border-b rounded-md text-lg w-80">
        <input type="hidden" name="user_type" value="User">
        <input type="submit" name="submit" value="Create Account" class="bg-yellow-700 text-white font-semibold py-2 rounded-md text-xl cursor-pointer">
        <p>Already have an Account? <a href="login.php" class="text-blue-500">Login Now</a></p>
    </div>
</form>

   </div>
</div>

</div>


</body>
</html>