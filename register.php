<?php

$stat = " ";

include 'components/connect.php';
include 'components/navbar.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
   $email = $_POST['email'];
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
      $cpass = $_POST['Cpassword'];

      if ($password == $cpass) {

         $sql = "SELECT * FROM users WHERE email='$email'";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
            $stat = "*Username already exists, please choose a different username";
         } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`email`, `name`, `number`, `password`) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $email, $name, $phone, $hashed_password);

            if ($stmt->execute()) {
               error_reporting(E_ALL);
               ini_set('display_errors', 1);
               echo '<script>window.location.href = "login.php";</script>';
            }
         }
      } else {
         $stat = "*Both password must be same.";
      }
   } else {
      $stat = "*Invalid email address";
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Create Account</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/navStyle.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


</head>

<body class="RegBody">
   <section class="form-container-register">

      <form action="" method="post">
         <h3>register now</h3>
         <input type="name" name="name" placeholder="Enter your name" maxlength="50" pattern="[A-Za-z ]+" title="Enter only letters" class="box" required>
         <input type="email" name="email" placeholder="Enter your email" maxlength="70" type="email" class="box" required>
         <input type="password" name="password" required placeholder="Enter your password" maxlength="20" class="box">
         <input type="password" name="Cpassword" required placeholder="Confirm your password" maxlength="20" class="box">
         <input type="phone" name="phone" required placeholder="Enter your phone number" maxlength="50" class="box">
         <h5 class="stat"><?= $stat ?></h5>
         <input type="submit" value="Register now" class="btn-register" name="submit">
         <p class="redirect">Already have an account? <a href="login.php" class="option-btn">Login now</a></p>

      </form>

      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
         <div class="toast-body">
            Hello, world! This is a toast message.
         </div>
      </div>

   </section>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   <?php
   include 'components/footer.php';
   ?>
</body>

</html>