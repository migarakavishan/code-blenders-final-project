<?php

include '../Admin/config.php';

session_start();

// $admin_id = $_SESSION['admin_id'];

// if (!isset($admin_id)) {
//     header('location:admin_login.php');
// }

if (isset($_POST['update_payment'])) {
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment->bind_param("si", $payment_status, $order_id);
    $update_payment->execute();
    $message[] = 'payment status updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->bind_param("i", $delete_id);
    $delete_order->execute();
    header('Location: placed_orders.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin product</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/product_style.css">
    <link rel="stylesheet" href="css/placed_order.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- side bar -->
        <?php
        include '../Admin/admin_components/sidebar.php';
        ?>
        <!-- side bar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- navbar -->
                <?php
                include '../Admin/admin_components/navbar.php';
                ?>
                <!-- side bar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Placed Orders</h1>
                        <a href="../Admin/Report Genarations/orderReport.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>
                    <div class="container">
                        <div class="box-container">

                            <?php
                            $sql = $conn->prepare("SELECT * FROM `orders` WHERE `user_id` = ?");
                            $sql->bind_param("s", $_SESSION['user_id']);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows > 0) {
                                while ($order = $result->fetch_assoc()) {
                            ?>
                                    <div class="box">
                                        <p> placed on : <span><?= $order['placed_on']; ?></span> </p>
                                        <p> name : <span><?= $order['name']; ?></span> </p>
                                        <p> number : <span><?= $order['number']; ?></span> </p>
                                        <p> address : <span><?= $order['address']; ?></span> </p>
                                        <p> total products : <span><?= $order['total_products']; ?></span> </p>
                                        <p> total price : <span>$<?= $order['total_price']; ?>/-</span> </p>
                                        <p> payment method : <span><?= $order['method']; ?></span> </p>
                                        <form action="" method="post">
                                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                            <select name="payment_status" class="select">
                                                <option selected disabled><?= $order['payment_status']; ?></option>
                                                <option value="pending">pending</option>
                                                <option value="completed">completed</option>
                                            </select>
                                            <div class="flex-btn">
                                                <input type="submit" value="update" class="option-btn" name="update_payment">
                                                <a href="placed_orders.php?delete=<?= $order['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                                            </div>
                                        </form>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<p class="empty">no orders placed yet!</p>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>