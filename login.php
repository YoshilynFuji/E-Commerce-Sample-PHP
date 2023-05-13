<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);
      if($row['password'] == $pass){
         if($row['user_type'] == 'Admin'){
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
         }elseif($row['user_type'] == 'User'){
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }else{
         $message[] = '<div class="text-center"><p>Please re-enter your password.</p><p>The password you\'ve entered is incorrect.</p></div>';
      }
   }else{
      $message[] = '<div class="text-center"><p>Incorrect email</p><p>The email you entered isn\'t connected to an account.</p></div>';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>


   <script src="https://cdn.tailwindcss.com"></script>
  
  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="css/modal.css">

</head>
<body class="overflow-x-hidden">


   
<div class="flex flex-col w-screen" >

<div class="flex flex-col justify-center items-center w-full  py-10" id="adminpage ">
<img src="./images/Logo.png" alt="" class="w-40 h-40 my-6">
<div class="border border-b py-10 px-8 rounded-md">
   
<form action="" method="post">
   <h3 class="text-4xl font-bold py-10 ">Welcome Back!</h3>
   <div class="flex flex-col space-y-4 pb-10">
   <div class="flex justify-center">
      <div id="errorMessage" class="text-red-500 text-xs px-5"><?php if(isset($message)){ echo $message[0] . ' '; } ?></div>
   </div>
   <input type="email" name="email" placeholder="Email" required class="px-4 py-2 border border-b rounded-md text-lg w-80">
   <input type="password" name="password" placeholder="Password" required class="px-4 py-2 border border-b rounded-md text-lg">
   <input type="submit" name="submit" value="Login" class="bg-yellow-700 text-white font-semibold py-2 rounded-md text-xl cursor-pointer">
   </div>
   <p>Not Registered? <a href="register.php" class="text-blue-500 ">Create an Account.</a></p>

</form>

</div>
</div>


</div>









<script>
   
</script>
</body>

</html>