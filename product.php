<?php
include 'components/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/productStyle.css">
    <link rel="stylesheet" href="css/navStyle.css">


    <!-- <input type="hidden" name="name" value="' . $row["name"] . '">
                            <input type="hidden" name="price" value="'. $row["price"] .'">
                            <input type="hidden" name="image" value="'. $row["image"] .'"> -->
</head>

<body>
    <?php
    include 'components/navbar.php';
    ?>
    <section>
        <?php

        include 'components/add_to_cart.php';

        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            echo '<section class="product-section">
            <div class="card-deck">
            ';

            while ($row = mysqli_fetch_assoc($result)) {

                echo '<form action="" method="post" class="col-lg-3 mt-4">
                        <div class="card rounded">
                            <input type="hidden" name="pid" value="' . $row["product_id"] . '">
                            
                            <img class="card-img object-fit-contain" src="./Admin/uploaded_img/' . $row["image"] . '" alt="product-image">
                            
                            <h1 class="product-name">' . $row["name"] . '</h1>

                            <div class="flex-row">
                                <p class="price">RS. <span>' . $row["price"] . '</span></p>
                                
                            </div>
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                               

                            <div class="btn-col">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="icon-link rounded">
                            </div>

                        </div>
                    </form>';
            }
            echo '</div>
                </section>';
        } else {
            echo "<P>No products found.</p>";
        }

        mysqli_close($conn);
        ?>
    </section>

    <?php
    include 'components/footer.php';
    ?>


</body>


</html>