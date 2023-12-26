<?php

require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create-product"])) {

    $manufacturerName = $_POST["name"] ?? '';

    $currentDirectory = __DIR__;
    $parentDirectory = dirname($currentDirectory);


   
        $db = new Db();

        $sql = 'select count(*) from manufacturer where name=:name';
        $arr = array(":name"=>$manufacturerName);
        $result = $db->select($sql, $arr)[0];

        if($result['count(*)'] != 0) {
            echo '<h1>Sản phẩm đã tồn tại, vui lòng tạo sản phẩm khác</h1>';
            echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';
            exit();
        }
        
        $sql = "INSERT INTO manufacturer(name) VALUES (:name)";
        
        $arr = array(":name"=>$manufacturerName);
        
        $result = $db->insert($sql, $arr);
        
        if($result > 0) {
            echo "<h1>Thêm thành công</h1>";
        }
        else {
            echo '<h1>Thêm xưởng thất bại, xin hãy thử lại</h1>';
        }
    }
    echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';





?>