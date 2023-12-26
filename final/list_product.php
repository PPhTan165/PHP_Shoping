<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        button.btn.btn-outline-dark.add-to-cart {
            border: 3px solid black;
            font-weight: 600;
        }

        strong.btn.btn-inline-dark {
            background-color: #0d4438;
            color: white;
        }
    </style>
</head>

<body>
    <?php

    $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $driver="mysql:host=". HOST."; dbname=". DB_NAME;
    $pdo = new PDO($driver, DB_USER, DB_PASS);
    $pdo->query("SET NAMES utf8");

    $sql = "SELECT COUNT(*) FROM product";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tongSoSach = $stmt->fetchColumn();
    $tongSoTrang = ceil($tongSoSach / $tongSo1Trang);


    $offSet = ($page - 1) * $tongSo1Trang;

    $sql = "SELECT * FROM product LIMIT " . $offSet . ", " . $tongSo1Trang;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "<div class='col card-item mt-5'>";
        echo "<div class='card' style='width: 18rem;'>";
        echo "<a href ='detail.php?id=" . $product['id'] . "'><img src='img/" . $product['image'] . "' class='card-img-top' alt='" . $product['name'] . " width='' height='300px' ></a>";
        echo "<div class='card-body'><h5 class='card-title'>" . $product['name'] . "</h5>";
        echo "<p class='card-text'>" . number_format($product['price'], 0) . " VNĐ</p>";
        echo "<form  id='add-to-cart-form' 
                            action='cart.php?action=add&id=" . $product['id'] . "' 
                            method='post'>
                            <input type='hidden' value='" . $product['id'] . "' name = 'add-to-cart' />
                            <input type='hidden' value='1' name = 'quantity[" . $product['id'] . "]'  />
                            <button class='btn btn-outline-dark add-to-cart' name='btn-add-to-cart' >Add to Cart</button>
                          </form> ";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <div>

        <?php
        if ($page) {
            $first_page = 1;
            echo "<a class = 'page-item num-page btn btn-outline-dark' href='?per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";
        }
        for ($i = 1; $i <= $tongSoTrang; $i++) {
            if ($i != $page) {
                if ($i > $page - 2 && $i < $page + 2) {
                    echo "<a class = 'page-item num-page btn btn-outline-dark' href='?per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";
                }
            } else {
                echo "<strong class ='current-page page-item btn btn-inline-dark'>$i </strong>";
            }
        }
        if ($page > $tongSoTrang - $page && $page != $tongSoTrang) {
            $last_page = $tongSoTrang;
            echo "<a class = 'page-item num-page btn btn-outline-dark' href='?per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";
        }
        ?>
    </div>

</body>

</html>