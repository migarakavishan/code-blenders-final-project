<?php
include 'config.php';

$sql = $conn->prepare("SELECT * FROM `orders` WHERE `order_id` = ?");
$sql->bind_param("s", $_POST['orderid']);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
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

    <title>SB Admin 2 - Other Utilities</title>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/qr.css">

</head>

<body id="page-top" onload="startScanner()">

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

                    <div id="content-wrapper" class="d-flex flex-column">
                        <div id="content2">

                            <h1 class="qrhead"><i class="bi bi-camera-fill"></i>QR CODE SCANNER <i class="bi bi-camera-fill"></i></h1>
                            <video id="preview"></video>

                            <?php
                            if (isset($order)) {
                            ?>
                                <div>
                                    
                                    <div class="orderdetails">
                                    <h2 class="o">Order Details</h2>
                                        <p>Placed on: <span><?= date('F j, Y, g:i a', strtotime($order['placed_on'])); ?></span></p>
                                        <p>Name: <span><?= $order['name']; ?></span></p>
                                        <p>Email: <span><?= $order['email']; ?></span></p>
                                        <p>Number: <span><?= $order['number']; ?></span></p>
                                        <p>Address: <span><?= $order['address']; ?></span></p>
                                        <p>Payment Method: <span><?= $order['method']; ?></span></p>
                                        <p>Your Orders: <span><?= $order['total_products']; ?></span></p>
                                        <p>Total Price: <span>RS. <?= $order['total_price']; ?>/-</span></p>
                                        <p>Payment Status: <span style="color:<?php if ($order['payment_status'] == 'pending') {
                                                                                    echo 'red';
                                                                                } else {
                                                                                    echo 'green';
                                                                                }; ?>"><?= $order['payment_status']; ?></span> </p>
                                    </div>
                                </div>
                            <?php
                            } else {
                                echo '<p class="scanqr"> Scan the QR Code.</p>';
                            }
                            ?>

                            <form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" id="orderid" name="orderid" value="orderid">
                            </form>
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

            <script>
                // Access the video element and create an instance of the scanner
                let videoElement = document.getElementById("preview");
                let scanner = new Instascan.Scanner({
                    video: videoElement
                });

                function callPHPFunction() {
                    document.getElementById('myForm').submit();
                }

                // Add an event listener to listen for scan results
                scanner.addListener("scan", function(content) {
                    // alert("QR Code content: " + content);
                    document.getElementById("orderid").value = content;
                    callPHPFunction();
                });

                // Function to start the scanner
                function startScanner() {

                    Instascan.Camera.getCameras()
                        .then(function(cameras) {
                            if (cameras.length > 0) {
                                scanner.start(cameras[0]);
                            } else {
                                console.error("No cameras found.");
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

</body>

</html>