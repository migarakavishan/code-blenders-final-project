<?php
include 'components/connect.php';

if (isset($_POST['delete'])) {
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE `id` = ?");
    $delete_cart_item->bind_param("s", $_POST['delete']);
    $delete_cart_item->execute();
    
    // Redirect to the current page to avoid resubmission of the form
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    echo $cart_id;

    // Update the quantity in the database
    $update_quantity = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE `id` = ?");
    $update_quantity->bind_param("is", $quantity, $cart_id);
    $update_quantity->execute();

    // Close the database connection
    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/cartStyle.css">

</head>

<body class="bg">
    <?php
    include 'components/navbar.php';
    ?>
    <br>
    <div class="container">
        <h1>Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr class="table-dark">
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

                // Fetch products from the database
                $sql = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
                $sql->bind_param("s", $_SESSION['user_id']);
                $sql->execute();
                $result = $sql->get_result();

                $total = 0;
                while ($row = mysqli_fetch_assoc($result)) {

                    $sql1 = "SELECT * FROM `products` WHERE `product_id`= ?";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->bind_param("s", $row['product_id']);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    $row1 = $result1->fetch_assoc();

                    $totalQty_price = $row['quantity'] *  $row1['price'];
                    $total += $totalQty_price;
                    echo '<tr> ';
                    // echo '<img class="img-thumbnail rounded image" src="./Admin/uploaded_img/' . $row1["image"] . '" alt="product-image">';
                    echo '<td>' . $row1['name'] . '</td>';

                    echo '<td class="price">Rs. ' . $row1['price'] . '</td>';
                    echo '<td><input type="number" min="1" max="99" class="form-control quantity" value="' . $row['quantity'] . '" id="quantity-' . $row1['product_id'] . '" onchange="updateQuantity(' . $row['id'] . ', this.value)"></td>';

                    echo '<td class="totalQtyPrice total-qty-price">RS.' . $totalQty_price . '</td>';
                    echo '<form method="post">
                            <td>
                                <button class="btn btn-danger" type="submit" name="delete" value="' . $row['id'] . '">Remove</button>
                            </td>
                            </form>';


                    echo '</tr>';
                }


                // Close the database connection
                mysqli_close($conn);
                ?>

            </tbody>
        </table>
        <div class="text-right">
            <h4>Total: <span class="total-price">Rs. <?php echo $total; ?></span></h4>
            <a class="btn btn-primary" href="checkout.php">Checkout</a>
        </div>

    </div>

    <?php
    include 'components/footer.php';
    ?>

    <script>
        // Update cart item count
        function updateCartItemNumber() {
            var cartItemNumber = <?php echo $_SESSION['cartItem_no']; ?>;
            document.getElementById('cartItemNumber').innerHTML = cartItemNumber;
        }

        updateCartItemNumber();

        function updateQuantity(cartId, quantity) {
            $.ajax({
                url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                type: 'POST',
                data: { cart_id: cartId, quantity: quantity },
                success: function(response) {
                }
            });
        }
    </script>
    <script src="js/calculateCartPrice.js"></script>
</body>

</html>
