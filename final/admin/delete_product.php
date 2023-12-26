<?php
 if(isset($_GET)) {
    $id = $_GET['id'];
    require "config/config.php";
    require ROOT . "/include/function.php";
    spl_autoload_register("loadClass");
    $db = new Db();

    $sql = 'delete from product where id=:id';
    $arr = array(":id"=>$id);
    $result = $db->delete($sql, $arr);
    
    if($result > 0) {
        echo '<h1>Xoá sản phẩm thành công</h1>';
        echo '<a href="index.php">Nhấp vào đây để về trang chủ</a>';
    } else {
        echo '<h1>Xoá sản phẩm thất bại</h1>';
        echo '<a href="index.php">Nhấp vào đây để về trang chủ</a>';
    }

   }
?>