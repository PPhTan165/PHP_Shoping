<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create-product"])) {

    $categoryName = $_POST["name"] ?? '';

    $currentDirectory = __DIR__;
    $parentDirectory = dirname($currentDirectory);


   
        $db = new Db();

        $sql = 'select count(*) from categories where name=:name';
        $arr = array(":name"=>$categoryName);
        $result = $db->select($sql, $arr)[0];


        if($result['count(*)'] != 0) {
            echo '<h1>Sản phẩm đã tồn tại, vui lòng tạo sản phẩm khác</h1>';
            echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';
            exit();
        }
        
        $sql_categories = "INSERT INTO `categories`(`name`) VALUES (:name)";
        
        $arr = array(":name"=>$categoryName);
        
        $result = $db->insert($sql_categories, $arr);
        // var_dump($result);exit;
        if($result > 0) {
            echo "<h1>Thêm thành công</h1>";
        }
        else {
            echo '<h1>Thêm loại thất bại, xin hãy thử lại</h1>';
        }
    }
    echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';





?>