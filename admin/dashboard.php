<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link rel="icon" href="../images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
      .btn {background-color: #c19b34;}
      .btn:hover {background-color: #382818;}
   </style>

</head>
<body style="background-image: url('../images/ledesa-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;height: 100vh; width: 100%;">

<?php include '../components/admin_header.php' ?>

<!-- Dashboard Admin Start  -->

<section class="dashboard">

   <h1 class="heading" style="color:white;">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <h3>Nama Admin</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">Update Profile</a>
   </div>

   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_price'];
         }
      ?>
      <h3>Total Tertunda<h3>
      <p><span>Rp</span><?= number_format($total_pendings, 0, ',', '.') ?><span>,-</span></p>
      <a href="placed_orders.php" class="btn">Lihat Pesanan</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['completed']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['total_price'];
         }
      ?>
      <h3>Total Pesanan</h3>
      <p><span>Rp</span><?= number_format($total_completes, 0, ',', '.') ?><span>,-</span></p>
      <a href="placed_orders.php" class="btn">see orders</a>
   </div>

   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h3>Total Pesanan</h3>
      <p><?= $numbers_of_orders; ?></p>
      <a href="placed_orders.php" class="btn">see orders</a>
   </div>

   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h3>Total Produk</h3>
      <p><?= $numbers_of_products; ?></p>
      <a href="products.php" class="btn">Lihat Produk</a>
   </div>

   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h3>Total Akun</h3>
      <p><?= $numbers_of_users; ?></p>
      <a href="users_accounts.php" class="btn">Lihat Akun</a>
   </div>

   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <h3>Total Admin</h3>
      <p><?= $numbers_of_admins; ?></p>
      <a href="admin_accounts.php" class="btn">Lihat Admin</a>
   </div>


   </div>

</section>

<!-- Dashboard Admin End -->









<!-- Custom JS File  -->
<script src="../js/admin_script.js"></script>

</body>
</html>