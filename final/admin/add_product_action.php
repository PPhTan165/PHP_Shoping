<?php



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create-product"])) {

    $productName = $_POST["name"] ?? '';
    $productPrice = $_POST["price"] ?? '';
    $productStocks = $_POST["stocks"] ?? '';
    $productImage = $_FILES["image"] ?? null;
    $manufacturer = $_POST["manufacturer"] ?? '';
    $category = $_POST["categories"] ?? '';
    $description = $_POST["description"] ?? '';

    $currentDirectory = __DIR__;
    $parentDirectory = dirname($currentDirectory);

    $targetDir = $parentDirectory . '/img/';
    $targetPath = $targetDir . basename($productImage['name']);

    if (!move_uploaded_file($productImage["tmp_name"], $targetPath)) {
        echo "Có lỗi xảy ra khi lưu trữ file. Xin hãy thử lại";
    } else {
        
        require "config/config.php";
        require ROOT . "/include/function.php";
        spl_autoload_register("loadClass");
        $db = new Db();

        $sql = 'select count(*) from product where name=:name';
        $arr = array(":name"=>$productName);
        $result = $db->select($sql, $arr)[0];

        if($result['count(*)'] != 0) {
            echo '<h1>Sản phẩm đã tồn tại, vui lòng tạo sản phẩm khác</h1>';
            echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';
            exit();
        }
        
        $sql = "insert into product(name, price, stocks, review, manufacturer_id, categories_id, image)
        values (:name, :price, :stocks, :review, :manufacturer_id, :categories_id, :image )";
        
        $arr = array(":name"=>$productName, ":price"=>$productPrice, ":stocks"=>$productStocks,
        ":review"=>0,":manufacturer_id"=>$manufacturer, ":categories_id"=>$category, ":image"=>$productImage['name']);
        
        $result = $db->insert($sql, $arr);
        
        if($result > 0) {
            echo "<h1>Thêm thành công</h1>";
        }
        else {
            echo '<h1>Tạo sản phẩm thất bại, xin hãy thử lại</h1>';
        }
    }
    echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';



}

?>