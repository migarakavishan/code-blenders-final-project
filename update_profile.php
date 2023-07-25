<?php
session_start();

include 'components/connect.php';

if (isset($_POST['change_address'])) {
  $streetAddress = $_POST['street_address'];
  $aptSuiteUnit = $_POST['apt_suite_unit'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $postalCode = $_POST['postal_code'];

  // Prepare the update statement
  $updateQuery = "UPDATE `customer_address` SET street_address = ?, apartment = ?, city = ?, state = ?, postal_code = ? WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $updateQuery);
  mysqli_stmt_bind_param($stmt, 'ssssss', $streetAddress, $aptSuiteUnit, $city, $state, $postalCode, $_SESSION['user_id']);

  // Execute the update statement
  $updateResult = mysqli_stmt_execute($stmt);

  if ($updateResult) {
    $_SESSION['update_status'] = "Address updated successfully.";
  } else {
    $_SESSION['err'] = "Failed to update address.";
  }

  mysqli_stmt_close($stmt);
  header("Location: customerDetails.php");
  exit();
}

if (isset($_POST['add_address'])) {
  // Retrieve the address data from the form
  $streetAddress = $_POST['street_address'];
  $aptSuiteUnit = $_POST['apt_suite_unit'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $postalCode = $_POST['postal_code'];

  // Prepare the insert statement
  $insertQuery = "INSERT INTO `customer_address`(`user_id`, `street_address`, `apartment`, `city`, `state`, `postal_code`) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $insertQuery);
  mysqli_stmt_bind_param($stmt, 'ssssss', $_SESSION['user_id'], $streetAddress, $aptSuiteUnit, $city, $state, $postalCode);

  // Execute the insert statement
  $insertResult = mysqli_stmt_execute($stmt);

  if ($insertResult) {
    $_SESSION['update_status'] = "Address added successfully.";
  } else {
    $_SESSION['err'] = "Failed to add the address.";
  }

  mysqli_stmt_close($stmt);
  header("Location: customerDetails.php");
  exit();
}

if (isset($_POST['zero'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $number = $_POST['phone'];
  $password = $_POST['password'];
  $confirm_password = $_POST['Cpassword'];

  if ($password === $confirm_password) {
    $query = "UPDATE users SET name = ?, number = ?";

    $params = array($username, $number);

    if (!empty($password)) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $query .= ", password = ?";
      $params[] = $hashed_password;
    }

    $query .= " WHERE email = ?";
    $params[] = $email;

    $stmt = mysqli_prepare($conn, $query);
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $_SESSION['update_status'] = "Profile updated successfully.";
      header("Location: customerDetails.php");
      exit();
    } else {
      $_SESSION['err'] = "Failed to update the profile.";
      header("Location: customerDetails.php");
      exit();
    }
  } else {
    $_SESSION['err'] = "Both passwords must be the same.";
    header("Location: customerDetails.php");
    exit();
  }
}
