<?php
require "condig/config.php";
require ROOT . "";
class Product extends Db
{
    public function getRand()
    {

        $sql = "select * from product";
        $products = $this->select($sql);
        foreach ($products as $product) {
            echo "<div class='col'>";
            echo "<div class='card' style='width: 18rem;'>";
            echo "<a herf='detail.com'><img src='img/" . $product['img'] . "' class='card-img-top' alt=''></a>";
            echo "<div class='card-body'><h5 class='card-title'>" . $product['name'] . "</h5>";
            echo "<p class='card-text'>" . $product['price'] . " VNĐ</p>";
            echo "<a href='#' class='btn '>Add to Cart</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }

    public function filterPage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // var_dump($_GET['url']);exit;
            $url = $_GET['url'] ?? null;

            if ($url == 'Ao') {
                $db = new Db();
                $sql = "select * from product";
                
                $productList = $db->select($sql);
                echo "    <table class='table'>";
                echo "<thead>";
                echo "    <tr>";
                echo "        <th>ID</th>";
                echo "        <th>Name</th>";
                echo "        <th>Price</th>";
                echo "        <th>Stocks</th>";
                echo "        <th>&nbsp;</th>";
                echo "         <th>&nbsp;</th>";
                echo "    </tr>";
                echo "</thead>";
                foreach ($productList as $product) {
                    echo '<tr>';
                    echo '<td>' . $product['id'] . '</td>';
                    echo '<td>' . $product['name'] . '</td>';
                    echo '<td>' . number_format($product['price'], 0) . '</td>';
                    echo '<td>' . $product['stocks'] . '</td>';
                    echo '<td><a href ="update_product.php?id=' . $product['id'] . '">Sửa</a><td>';
                    echo '<td><a href ="delete_product.php?id=' . $product['id'] . '">Xoá</a><td>';
                    echo '</tr>';
                }
                echo "</table>";
            }

            if ($url == 'Quan') {
                $db = new Db();
                $sql = "SELECT * from manufacturer";
                $manufacturerList = $db->select($sql);
                echo "    <table class='table'>";
                echo "<thead>";
                echo "    <tr>";
                echo "        <th>ID</th>";
                echo "        <th>Name</th>";
                echo "        <th>&nbsp;</th>";
                
                echo "    </tr>";
                echo "</thead>";
                foreach ($manufacturerList as $manufacturer) {
                    echo '<tr>';
                    echo '<td>' . $manufacturer['id'] . '</td>';
                    echo '<td>' . $manufacturer['name'] . '</td>';
                    echo '<td><a href ="update_manufacturer.php?id=' . $manufacturer['id'] . '">Sửa</a><td>';
                    
                    echo '</tr>';
                }
                echo "</table>";
            }


         
            }
        }
}
?>