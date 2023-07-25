<?php

@include 'config.php';

if (isset($_POST['add_supplier'])) {

    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];

    if (empty($supplier_name) || empty($supplier_email) || empty($supplier_phone)) {
        $message[] = 'please fill out all';
    } else {
        $insert = "INSERT INTO suppliers(name, email, phone) VALUES('$supplier_name', '$supplier_email', '$supplier_phone')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
};

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM suppliers WHERE id = $id");
    header('location:supplier.php');
};

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
                <!-- nav bar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Supplier</h1>
                        <a href="../Admin/Report Genarations/SupplireReport.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <?php

                    if (isset($message)) {
                        foreach ($message as $message) {
                            echo '<span class="message">' . $message . '</span>';
                        }
                    }

                    ?>

                    <div class="container">

                        <div class="admin-product-form-container">

                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                <h3>add a supplier</h3>
                                <input type="text" placeholder="Enter supplier name" name="supplier_name" class="box">
                                <input type="text" placeholder="Enter supplier email" name="supplier_email" class="box">
                                <input type="text" placeholder="Enter the number" name="supplier_phone" class="box">
                                <input type="submit" class="btnn" name="add_supplier" value="add supplier">
                            </form>

                        </div>

                        <?php

                        $select = mysqli_query($conn, "SELECT * FROM suppliers");

                        ?>
                        <div class="product-display">
                            <table class="product-display-table">
                                <thead>
                                    <tr>
                                        <th>Supplier ID</th>
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                                    <tr>
                                        <td><?php echo $row['supplier_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td>
                                            <a href="supplier_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Edit </a>
                                            <a href="supplier.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Delete </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
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