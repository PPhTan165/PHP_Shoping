<?php

class Product extends Db

{

    public function getRand()

    {

        $sql = "select * from product order by rand() limit 0,8";

        $products = $this->select($sql);



        foreach ($products as $product) {

            echo '<div class="col mb-5">';

            echo '<div class="card h-100">';

            echo '<div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>';

            echo '<img class="card-img-top" src=img/' . $product['image'] . ' alt="..." width = "350px" height = "120px"/>';

            echo '<div class="card-body p-4">';

            echo '<div class="text-center">';

            echo '<h5 class="fw-bolder">' . $product['name'] . '</h5>';

            echo '<div class="d-flex justify-content-center small text-warning mb-2">';



            for ($i = 0; $i < $product['review']; $i++) {

                echo '<div class="bi-star-fill"></div>';

            }



            echo '</div>';

            echo '<span class="text-muted text-decoration-line-through">$' . number_format($product['price'] + 300, 2) . '</span>';

            echo '$' . number_format($product['price'], 2);

            echo '</div>';

            echo '</div>';

            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

            <form action="index.php" method="GET">

                <input type="hidden" name="product_id" value="' . $product['id'] . '"> 

                <div class="text-center">

                    <button type="submit" class="btn btn-outline-dark mt-auto" name="add_to_cart">Add to cart</button>

                </div>

            </form>

        </div>';

            echo '</div>';

            echo '</div>';

        }



    }



    public function getAllManufacturersSelect($arr = [])

    {

        $sql = "select * from manufacturer";

        $manufacturers = $this->select($sql);



        foreach ($manufacturers as $key => $value) {

            if ($arr != null) {

                if ($value['id'] == $arr['manufacturer_id']) {

                    echo '<option value="' . $value['id'] . '" selected>' . $value['name'] . '</option>';

                } else {

                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

                }

            } else {

                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

            }

        }

    }



    public function getAllCategoriessSelect($arr = [])

    {

        $sql = "select * from categories";

        $categories = $this->select($sql);



        foreach ($categories as $key => $value) {

            if ($arr != null) {

                if ($value['id'] == $arr['categories_id']) {

                    echo '<option value="' . $value['id'] . '" selected>' . $value['name'] . '</option>';

                } else {

                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

                }

            } else {

                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

            }

        }

    }



    public function getAllCategories()

    {

        $sql = "select * from categories";

        $categories = $this->select($sql);



        foreach ($categories as $value) {

            $sql = "select sum(stocks) from product where categories_id = :categoryId";

            $arr = array(":categoryId" => $value['id']);

            $sum = $this->select($sql, $arr);



            echo '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">

            <a data-category="' . $value['id'] . '" id = "categories" onclick = "handleTitleClick(event)">' . $value['name'] . '</a> <span class="badge badge-primary badge-pill">' . $sum[0]['sum(stocks)'] . '</span></li>';

        }

    }



    public function pagination()

    {

        $manufacturerId = $_GET['manufacturer'] ?? null;

        $categoriesId = $_GET['category'] ?? null;



        $sql = "SELECT * FROM product WHERE 1 = 1";

        $arr = array();



        if ($manufacturerId !== null) {

            $sql .= " AND manufacturer_id = :manufacturerId";

            $arr[':manufacturerId'] = $manufacturerId;

        }



        if ($categoriesId !== null) {

            $sql .= " AND categories_id = :categoriesId";

            $arr[':categoriesId'] = $categoriesId;

        }



        $allProducts = $this->select($sql, $arr);

        $totalProduct = $this->getRowCount();



        $page = 1;

        $pageSize = 6;





        if (isset($_GET['page'])) {

            $page = $_GET['page'];

        }



        $totalPage = ceil($totalProduct / $pageSize);

        $start = ($page - 1) * $pageSize;

        $sql .= " LIMIT " . $start . "," . $pageSize;



        $products = $this->select($sql, $arr);



        foreach ($products as $key => $value) {

            echo '<div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1">

           <div class="card"> <img class="card-img-top" src="img/' . $value['image'] . '" height = 200>

           <div class="card-body">

               <h6 class="font-weight-bold pt-1">';

            echo $value['name'] . '</h6>

            <div class="text-muted description">' . '123456789' . '</div>

            <div class="d-flex align-items-center product">';

            for ($i = 0; $i < $value['review']; $i++) {

                echo '<div class="bi-star-fill"></div>';

            }

            echo '</div><div class="d-flex align-items-center justify-content-between pt-3">

                <div class="d-flex flex-column">

                    <div class="h6 font-weight-bold">' . $value['price'] . ' USD</div>

                    <div class="text-muted rebate">';

            echo '</div>

            </div>

            <form action="show_all_product.php" method="GET">

                <input type="hidden" name="product_id" value="' . $value['id'] . '"> 

                <div class="text-center">

                    <button type="submit" name="add_to_cart">Add to cart</button>

                </div>

            </form></div></div></div></div>';

        }



        return $totalPage;

    }



    public function productCart()

    {

        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $listProductId = $_SESSION['product_id'] ?? null;



            if ($listProductId != null) {



                foreach ($listProductId as $productId) {

                    $sql = "select * from product where id = :productId";

                    $arr = array(":productId" => $productId);



                    $allProduct = $this->select($sql, $arr);

                    $product = $allProduct[0];



                    $sql = "SELECT categories.name FROM categories join product on product.categories_id = categories.id where product.id = :productId";

                    $allCategories = $this->select($sql, $arr);

                    $category = $allCategories[0];



                    echo '<div class="row border-top border-bottom">

                    <div class="row main align-items-center">

                        <div class="col-2"><img class="img-fluid" src="img/';

                    echo $product['image'] . '"></div>';

                    echo '<div class="col">

                    <div class="row text-muted">' . $category['name'] . '</div>';

                    echo '<div class="row">' . $product['name'] . '</div></div>';

                    echo '<div class="col"><input type="number" class="quantityValue" value="1" min="1" max="' . $product['stocks'] . '" name="' . $productId . '"></div>';

                    echo '<div class="col">$' . $product['price'] . '<a href = ?id=' . $productId . ' name = "delete" class="close">&#10005;</a></div></div></div>';

                }

            }

        }

    }



    public function filterPage()

    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {



            $url = $_GET['url'] ?? "product";

 

            //List product

            if ($url == 'product') {

                echo "    <h1> Sản phẩm</h1>";


                echo "    <table class='table mt-3'>";

                echo "<thead>";

                echo "    <tr>";

                echo "        <th>ID</th>";

                echo "        <th>Tên sản phẩm</th>";

                echo "        <th>Giá</th>";

                echo "        <th>Số lượng</th>";
                echo "        <th>Loại</th>";
                echo "        <th>Xưởng</th>";

                echo "        <th>&nbsp;</th>";

                echo "         <th>&nbsp;</th>";

                echo "    </tr>";

                echo "</thead>";



                $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 10;

                $page = !empty($_GET['page']) ? $_GET['page'] : 1;





                $db = new Db();

                $sql = "SELECT COUNT(*) FROM product";



                $result = $db->select($sql)[0];

                $totalItem = $result['COUNT(*)'];

                // var_dump($totalItem);

                // $tongSoTrang = ceil($totalItem / $tongSo1Trang);

                $offSet = ($page - 1) * $tongSo1Trang;



                $sql_product = "SELECT product.id, product.name, product.stocks, product.price,
                categories.name as categories,
                manufacturer.name as manufacturer 
                FROM product 
                JOIN manufacturer on product.manufacturer_id = manufacturer.id
                JOIN categories on product.categories_id = categories.id
                order by id 
                limit " . $offSet . "," . $tongSo1Trang;


                $productList = $db->select($sql_product);

                // var_dump($productList);


                echo "<tbody>";
                foreach ($productList as $product) {

                    // var_dump($product);


                    
                    echo '<tr>';

                    echo '<td>' . $product['id'] . '</td>';

                    echo '<td>' . $product['name'] . '</td>';

                    echo '<td>' . number_format($product['price'], 0) . '</td>';

                    echo '<td>' . $product['stocks'] . '</td>';
                    echo '<td>' . $product['categories'] . '</td>';
                    echo '<td>' . $product['manufacturer'] . '</td>';


                    echo '<td><a href ="update_product.php?id=' . $product['id'] . '">Sửa</a><td>';

                    echo '<td><a href ="delete_product.php?id=' . $product['id'] . '">Xoá</a><td>';

                    echo '</tr>';

                }
                echo "</tbody>";
                echo "</table>";



                echo "<div>";

                $tongSoTrang = ceil($totalItem / $tongSo1Trang);

                // First page

                if ($page) {

                    $first_page = 1;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";

                }

                //pages

                for ($i = 1; $i <= $tongSoTrang; $i++) {

                    if ($i != $page) {

                        if ($i > $page - 2 && $i < $page + 2) {

                            echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";

                        }

                    } else {

                        echo "<strong class ='current-page page-item btn'>$i </strong>";

                    }

                }

                //Last Page

                if ($page == $tongSoTrang - $page) {

                    $last_page = $tongSoTrang;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";

                }

                echo "</div>";

            }



            // List Manufacturer

            if ($url == 'manufacturer') {

                echo "    <h1>Xưởng</h1>";


                echo "    <table class='table mt-3'>";

                echo "<thead>";

                echo "    <tr>";

                echo "        <th>ID</th>";

                echo "        <th>Tên xưởng</th>";

                echo "        <th>&nbsp;</th>";



                echo "    </tr>";

                echo "</thead>";

                $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 10;

                $page = !empty($_GET['page']) ? $_GET['page'] : 1;



                $db = new Db();



                $sql = "SELECT COUNT(*) FROM manufacturer";



                $result = $db->select($sql)[0];

                

                $totalItem = $result['COUNT(*)'];

                // $tongSoTrang = ceil($totalItem / $tongSo1Trang);

                $offSet = ($page - 1) * $tongSo1Trang;

                $sql_manufacturer = "SELECT * from manufacturer limit " . $offSet . "," . $tongSo1Trang;

                $manufacturerList = $db->select($sql_manufacturer);

                echo "<tbody>";

                foreach ($manufacturerList as $manufacturer) {

                    echo '<tr>';

                    echo '<td>' . $manufacturer['id'] . '</td>';

                    echo '<td>' . $manufacturer['name'] . '</td>';

                    echo '<td><a href ="update_manufacturer.php?id=' . $manufacturer['id'] . '">Sửa</a><td>';



                    echo '</tr>';

                }
                echo "</tbody>";

                echo "</table>";



                echo "<div>";

                $tongSoTrang = ceil($totalItem / $tongSo1Trang);



                if ($page) {

                    $first_page = 1;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";

                }

                for ($i = 1; $i <= $tongSoTrang; $i++) {

                    if ($i != $page) {

                        if ($i > $page - 2 && $i < $page + 2) {

                            echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";

                        }

                    } else {

                        echo "<strong class ='current-page page-item btn'>$i </strong>";

                    }

                }

                if ($page > $tongSoTrang - $page && $page != $tongSoTrang) {

                    $last_page = $tongSoTrang;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";

                }

                echo "</div>";

            }



            //List CateGories

            if ($url == 'categories') {

                echo "    <h1>Loại sản phẩm</h1>";
                echo "    <table class='table mt-3'>";

                echo "<thead>";

                echo "    <tr>";

                echo "        <th>ID</th>";

                echo "        <th>Tên loại</th>";

                echo "        <th>Số lượng sản phẩm</th>";

                echo "    </tr>";

                echo "</thead>";
                echo "<tbody>";

                $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 10;

                $page = !empty($_GET['page']) ? $_GET['page'] : 1;



                

                $db = new Db();

                $sql = "SELECT COUNT(*) FROM categories";

                $result = $db->select($sql)[0];

                $totalItem = $result['COUNT(*)'];

                $offSet = ($page - 1) * $tongSo1Trang;



                $sql_count = "SELECT categories.id as id, categories.name as name, COUNT(product.id) as total 
                from categories 
                LEFT JOIN product on categories.id = product.categories_id
                GROUP BY categories.id, categories.name

                limit " . $offSet . "," . $tongSo1Trang."";


                $categoryList = $db->select($sql_count);

                

                foreach ($categoryList as $category) {

                    // var_dump($category);

                    echo '<tr>';

                    echo '<td>' . $category['id'] . '</td>';

                    echo '<td>' . $category['name'] . '</td>';

                    echo '<td>' . $category['total'] . '</td>';

                    echo '</tr>';

                }
                echo "</tbody>";

                echo "</table>";



                echo "<div>";

                $tongSoTrang = ceil($totalItem / $tongSo1Trang);

                    if($tongSoTrang != 1)

            {    if ($page) {

                    $first_page = 1;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";

                }

                for ($i = 1; $i <= $tongSoTrang; $i++) {

                    if ($i != $page) {

                        if ($i > $page - 2 && $i < $page + 2) {

                            echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";

                        }

                    } else {

                        echo "<strong class ='current-page page-item btn'>$i </strong>";

                    }

                }

                if ($page > $tongSoTrang - $page && $page != $tongSoTrang) {

                    $last_page = $tongSoTrang;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";

                }}

                

                echo "</div>";

            }

            //List Order

            if ($url == 'order') {

                $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 10;

                $page = !empty($_GET['page']) ? $_GET['page'] : 1;

                $db = new Db();





                $sql = "SELECT COUNT(*) FROM orders";

                $result = $db->select($sql)[0];

                $totalItem = $result["COUNT(*)"];

                $offSet = ($page - 1) * $tongSo1Trang;



                $sql_order = "SELECT orders.id,user.fullname,orders.total,orders.status,product.id as masp FROM `orders`
                join order_details on orders.id = order_details.orders_id
                JOIN product on order_details.product_id = product.id
                join user on user_id = user.id
                limit " . $offSet . "," . $tongSo1Trang;

                $orderList = $db->select($sql_order);

                $index =1;
                echo "    <h1>Hóa đơn</h1>";


                echo "    <table class='table mt-3'>";

                echo "  <thead>";

                echo "    <tr>";

                echo "        <th>ID</th>";

                echo "        <th>Tên người dùng</th>";

                echo "        <th>Tổng tiền</th>";

                echo "         <th>Trạng thái đơn hàng</th>";

                echo "         <th>Mã sản phẩm</th>";

                echo "    </tr>";

                echo "  </thead>";

                foreach ($orderList as $order) {

                    
                    echo '<tr>';

                    echo '<td>' . $index++ . '</td>';

                    echo '<td>' . $order['fullname'] . '</td>';

                    echo '<td>' . number_format($order['total'], 0) . '</td>';

                    echo '<td>' . $order['status'] . '</td>';

                    echo '<td>'.$order['masp'].'</td>';

                    echo '</tr>';

                }

                echo "</table>";

                echo "<div>";

                $tongSoTrang = ceil($totalItem / $tongSo1Trang);

                if($tongSoTrang != 1)

               { if ($page) {

                    $first_page = 1;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";

                }

                for ($i = 1; $i <= $tongSoTrang; $i++) {

                    if ($i != $page) {

                        if ($i > $page - 2 && $i < $page + 2) {

                            echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";

                        }

                    } else {

                        echo "<strong class ='current-page page-item btn'>$i </strong>";

                    }

                }

                if ($page > $tongSoTrang - $page && $page != $tongSoTrang) {

                    $last_page = $tongSoTrang;

                    echo "<a class = 'page-item num-page' href='index.php?url=".$url."&per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";

                }}

                echo "</div>";

            }

        }



    }





    public function paginationAdmin()

    {

        $tongSo1Trang = !empty($_GET['per_page']) ? $_GET['per_page'] : 10;

        $page = !empty($_GET['page']) ? $_GET['page'] : 1;

        $driver = "mysql:host=" . HOST . "; dbname=" . DB_NAME;

        $pdo = new PDO($driver, DB_USER, DB_PASS);

        $pdo->query("SET NAMES utf8");



        $sql = "SELECT COUNT(*) FROM product";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $totalItem = $stmt->fetchColumn();

        $tongSoTrang = ceil($totalItem / $tongSo1Trang);





        $offSet = ($page - 1) * $tongSo1Trang;

        $db = new Db();

        $sql = "SELECT * FROM product LIMIT :offset,:tongSo1Trang";

        $arr = array(

            ":offset" => $offSet,

            ":tongSo1Trang" => $tongSo1Trang

        );

        $product = $db->select($sql, $arr);













        if ($page) {

            $first_page = 1;

            echo "<a class = 'page-item num-page' href='?per_page=" . $tongSo1Trang . "&page=" . $first_page . "'>  First  </a> ";

        }

        for ($i = 1; $i <= $tongSoTrang; $i++) {

            if ($i != $page) {

                if ($i > $page - 2 && $i < $page + 2) {

                    echo "<a class = 'page-item num-page' href='?per_page=" . $tongSo1Trang . "&page=" . $i . "'>" . $i . "</a> ";

                }

            } else {

                echo "<strong class ='current-page page-item btn'>$i </strong>";

            }

        }

        if ($page > $tongSoTrang - $page && $page != $tongSoTrang) {

            $last_page = $tongSoTrang;

            echo "<a class = 'page-item num-page' href='?per_page=" . $tongSo1Trang . "&page=" . $last_page . "'>  Last  </a> ";

        }

    }

}









?>