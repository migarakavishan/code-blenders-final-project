<?php
include 'components/connect.php';
include 'components/navbar.php';



$query = "SELECT * FROM `users` WHERE email = '{$_SESSION['email']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
  <title>Customer Details</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/navStyle.css">
  <link rel="stylesheet" href="css/account.css">
</head>

<body>
  <div class="container">
    <form method="post" action="update_profile.php">
      <h1>Customer Details</h1>

      <table>
        <tr>
          <th>Name:</th>
          <td><input type="text" name="username" id="username" value="<?php echo $row['name']; ?>"><br></td>
        </tr>
        <tr>
          <th>Email:</th>
          <td><input type="email" class="email" name="email" id="email" value="<?php echo $row['email']; ?>" readonly></td>
        </tr>
        <tr>
          <th>Phone:</th>
          <td><input type="text" name="phone" maxlength="9" max="999999999" id="phone" value="<?php echo $row['number']; ?>"></td>
        </tr>

        <tr>
          <th>Address:</th>
          <td>
            <?php
            $sql = "SELECT * FROM `customer_address` WHERE user_id = '" . $_SESSION['user_id'] . "'";
            $result_address = mysqli_query($conn, $sql);
            $address_row = mysqli_fetch_assoc($result_address);

            if (mysqli_num_rows($result_address) > 0) {
            ?>

              <?php
              echo $address_row['apartment'], ', ', $address_row['street_address'], ', ', $address_row['city'], ', ', $address_row['state'], ', ', $address_row['postal_code'];

              ?>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#popUpWindow">Change address</button>

              <div class="modal fade" id="popUpWindow">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h3 class="modal-title">Address</h3>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <form role="form" method="POST" action="update_profile.php">
                        <div class="form-group">

                          <label for="street-address">Street Address</label>
                          <input type="text" class="form-control" id="street-address" name="street_address" placeholder="Street Address" value="<?php echo $address_row['street_address']; ?>" required />

                          <label for="apt-suite-unit">Apt, Suite, Unit No</label>
                          <input type="text" class="form-control" id="apt-suite-unit" name="apt_suite_unit" placeholder="Apt, Suite, Unit No" value="<?php echo $address_row['apartment']; ?>" required />

                          <label for="city">City</label>
                          <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $address_row['city']; ?>" required />

                          <label for="state">State</label>
                          <input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?php echo $address_row['state']; ?>" required />

                          <label for="postal-code">Postal Code</label>
                          <input type="text" class="form-control" id="postal-code" name="postal_code" placeholder="Postal Code" value="<?php echo $address_row['postal_code']; ?>" required />

                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-primary btn-block save-btn float-right" name="change_address">Save</button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div>



            <?php
            } else {
            ?>


              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#popUpWindow">Add address</button>

              <div class="modal fade" id="popUpWindow">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h3 class="modal-title">Add Address</h3>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <form role="form" method="POST" action="update_profile.php">
                        <div class="form-group">
                          <label for="street-address">Street Address</label>
                          <input type="text" class="form-control" id="street-address" name="street_address" placeholder="Street Address" required />

                          <label for="apt-suite-unit">Apt, Suite, Unit No</label>
                          <input type="text" class="form-control" id="apt-suite-unit" name="apt_suite_unit" placeholder="Apt, Suite, Unit No" required />

                          <label for="city">City</label>
                          <input type="text" class="form-control" id="city" name="city" placeholder="City" required />

                          <label for="state">State</label>
                          <input type="text" class="form-control" id="state" name="state" placeholder="State" required />

                          <label for="postal-code">Postal Code</label>
                          <input type="text" class="form-control" id="postal-code" name="postal_code" placeholder="Postal Code" required />

                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-primary btn-block save-btn float-right" name="add_address">Save</button>
                        </div>
                      </form>
                    </div>



                  </div>
                </div>
              </div>

  </div>

<?php
            }
?>
<br>
</td>
</tr>

<tr>
  <th>New Password:</th>
  <td><input type="password" name="password" id="password"><br></td>
</tr>

<tr>
  <th>Confirm Password:</th>
  <td><input type="password" name="Cpassword" id="Cpassword"><br></td>
</tr>

</table>

<?php
if (isset($_SESSION['update_status'])) {
  echo '<p id="status">' . $_SESSION['update_status'] . '</p>';
  unset($_SESSION['update_status']);
} else if (isset($_SESSION['err'])) {
  echo '<p id="status" class="text-danger">' . $_SESSION['err'] . '</p>';
  unset($_SESSION['err']);
}

?>

<input type="submit" name="zero" value="Save Changes" class="edit-btn">
</form>

</div>

<?php
include 'components/footer.php';
?>

<script>
  setTimeout(function() {
    var text = document.getElementById("status");
    text.style.opacity = 0;
    setTimeout(function() {
      text.style.display = "none";
    }, 1500); // fade out time is 2 seconds
  }, 2500);
</script>
</body>

</html>