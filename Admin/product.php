<?php

@include 'config.php';

if (isset($_POST['add_product'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'please fill out all';
    } else {
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
};

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:product.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Products</h1>
                        <a href="../Admin/Report Genarations/productDetails.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
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
                                <h3>add a new product</h3>
                                <input type="text" placeholder="Enter product name" name="product_name" class="box">
                                <input type="number" placeholder="Enter product price" name="product_price" class="box">
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                                <input type="submit" class="btnn" name="add_product" value="add product">
                            </form>

                        </div>

                        <?php

                        $select = mysqli_query($conn, "SELECT * FROM products");

                        ?>
                        <div class="product-display">
                            <table class="product-display-table">
                                <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                                    <tr>
                                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td>Rs:<?php echo $row['price']; ?>/-</td>
                                        <td>
                                            <a href="product_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                                            <a href="product.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
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