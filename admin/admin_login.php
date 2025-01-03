<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Admin</title>
   <link rel="icon" href="../images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body  style="background-image: url('../images/ledesa-bg.jpg'); backdrop-filter: blur(10px); background-size: cover; background-position: center; background-repeat: no-repeat;">

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

<!-- Admin Login Main Start  -->

<section class="form-container" style="border-radius: 15px; padding: 20px; width: 300px; margin: auto; text-align: center;">

   <form action="" method="POST">
      <h3 style="color: #000000;">Login Admin</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Masukkan Username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Masukkan Password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login" name="submit" class="btn" style="background-color: #392918; color: #fff; border: none; padding: 10px 15px; cursor: pointer;">
   </form>

</section>


<!-- Admin Login Main End -->











</body>
</html>