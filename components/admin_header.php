<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span style="color:brown;">Panel</span></a>
      <img src="../images/LeDesa.ico" width="100" height="100"></a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Produk</a>
         <a href="placed_orders.php">Pesanan</a>
         <a href="admin_accounts.php">Admin</a>
         <a href="users_accounts.php">Pengguna</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Masuk</a>
            <a href="register_admin.php" class="option-btn">Daftar</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('Log Out Dari Website??');" class="delete-btn">Keluar</a>
      </div>

   </section>

</header>