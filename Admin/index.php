<?php
session_start();

include 'config.php';

if (isset($_SESSION['adminLogin'])) {
  if ($_SESSION['adminLogin'] == true) {
    header('Location: home.php');
  }
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == "admin" && $password == "1234") {
    $_SESSION['adminLogin'] = true;

    header('Location: home.php');
  } else {
    $message = "Incorrect credentials.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/stylesheet.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center">Admin Login</h2>
    <form action="" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
      </div>
      <p><?php if(isset($message)){echo $message;}?></p>
      <button type="submit" name="submit" class="btn btn-primary" id="submit">Login</button>
    </form>
  </div>
</body>

</html>