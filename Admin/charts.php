<?php

$total=0;
$dataPoints = array(
    array("label" => "a", "y" => 41),
    array("label" => "b", "y" => 35, "indexLabel" => "Lowest"),
    array("label" => "c", "y" => 50),
    array("label" => "d", "y" => 45),
    array("label" => "e", "y" => 52),
    array("label" => "f", "y" => 68),
    array("label" => "g", "y" => 38),
    array("label" => "h", "y" => 71, "indexLabel" => "Highest"),
    array("label" => "i", "y" => 52),
    array("label" => "j", "y" => 60),
    array("label" => "k", "y" => 36),
    array("label" => "l", "y" => 49),
    array("label" => "m", "y" => 41)
);

@include 'config.php';

$test = array();

$count = 0;
$res = mysqli_query($conn, "SELECT * FROM `orders`;");
while ($row = mysqli_fetch_array($res)) {
    $test[$count]["y"] = $row["total_price"];
    $test[$count]["label"] = $row["placed_on"];
    $total += $row['total_price'];
    $count = $count + 1;

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

    <title>SB Admin 2 - Charts</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Sales"
                },
                axisY: {
                    title: "Price"
                },
                data: [{
                    type: "column",
                    yValueFormatsString: "#,##0.##",
                    dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
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

                    

                    <!-- Content Row -->
                    <div class="row">

                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>

                </div>
                <!-- /.container-fluid -->

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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>