<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>
   
<?php include 'header.php'; ?>


<div class="px-48 pb-32" data-aos="fade-up">
  <section class="py-5 mt-10">
    <h1 class="text-center py-5 text-6xl text-yellow-900 pt-50">HABIYA</h1>
    <p class="text-md px-60 py-5 text-yellow-700 text-center pt-5" >is a sourcing platform & marketplace connecting designers to regenerative tropical textiles and artisan craft so they can design for sustainable consumer lifestyles.</p>
  </section>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-aos="fade-up">
  <div class="carousel-indicators ">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/5.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./images/6.png" class="d-block w-100" alt="...">
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
<div class="py-20 flex flex-col items-center space-y-4 bg-sky-50 rounded-md text-yellow-900 rounded-md"  data-aos="fade-up">
         <h1 class="text-3xl ">SUBSCRIBE TO OUR NEWSLETTER</h1>
         <p>Sign-up to get exclusive promotions, impact updates, and early access to new products!</p>
         <div class="flex gap-2">
         <input type="text" class="rounded-md px-4 py-2 w-96 border border-b" placeholder="Enter Email">
         <button class="text-white bg-yellow-700 px-4 py-1 rounded-md">SUBSCRIBE</button>
         </div>
      </div>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>

