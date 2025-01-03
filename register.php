<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if(empty($address)){
      $message[] = 'Address cannot be empty!';
   }
   
   if($select_user->rowCount() > 0){
      $message[] = 'email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password, address) VALUES(?,?,?,?)");
$insert_user->execute([$name, $email, $pass, $address]);

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Daftar Pengguna</title>
   <link rel="icon" href="images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="background-color:white;">
   
<!-- Header -->
<?php include 'components/user_header.php'; ?>

<section class="form-container" style="background-color: white;">

   <form action="" method="post">
      <h3>Daftar Sekarang</h3>
      <input type="text" name="name" required placeholder="Masukkan Nomor Kamar" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="Masukkan Kode Email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="address" required placeholder="Masukkan Nomor Kamar" class="box" maxlength="255">
      <input type="password" name="pass" required placeholder="Masukkan Password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Konfirmasi Password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Daftar Sekarang" name="submit" class="btn">
      <p>Sudah Punya Akun? <a href="login.php">Login Sekarang</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- JS File -->
<script src="js/script.js"></script>

</body>
</html>