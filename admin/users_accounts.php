<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Akun Kamar</title>
   <link rel="icon" href="../images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Start -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <style>
      .btn {background-color: #c19b34;}
      .btn:hover {background-color: #382818;}
   </style>
</head>
<body style="background-image: url('../images/ledesa-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;height: 100vh; width: 100%;">

<?php include '../components/admin_header.php' ?>

<!-- Akun Kamar Start -->

<section class="accounts">

   <h1 class="heading">Akun Kamar</h1>
   <!-- Add User -->

   <a href="user_register.php" class="btn">Tambahkan Kamar</a> <br>


   <div class="box-container">

   <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
<div class="box">
   <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
   <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
   <!--<a href="edit_user.php?id=<?= $fetch_accounts['id']; ?>" class="edit-btn">Edit</a>-->
   <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Hapus Akun Ini?');">Hapus</a>
</div>

   <?php
      }
   }else{
      echo '<p class="empty">Tidak Ada Akun Tersedia</p>';
   }
   ?>

   </div>

</section>

<!-- Akun Kamar End -->







<!-- JS File -->
<script src="../js/admin_script.js"></script>

</body>
</html>