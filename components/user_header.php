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

<header class="header" style="background: linear-gradient(to right, #392918, #392918); display: flex; justify-content: center; align-items: center; height: 100px;position: static;">
<img src="images/LeDesa.ico" alt="Yum-Yum Logo" width="135px" height="50px" style="object-fit: cover;padding-left: 10px;">   

   <section class="flex">

      <div class="icons" style="display:none;">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span class="cart">(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user" style="display:none;"></div>
         <div id="menu-btn" class="fas fa-bars" style="display:none;"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('Log Out Dari Website?');" class="delete-btn">Logout</a>
         </div>
         <p class="account">
            <a href="login.php">Login</a> or
            <a href="register.php">Daftar</a>
         </p> 
         <?php
            }else{
         ?>
            <p class="name">Harap Login Terlebih Dahulu!</p>
            <a href="login.php" class="btn">Login</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

