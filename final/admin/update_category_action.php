<?php
// var_dump($_SERVER);exit;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create-category"])) {

    require "config/config.php";
    require ROOT . "/include/function.php";
    spl_autoload_register("loadClass");

    $categoriesName = $_POST["name"] ?? '';
    $id = $_POST['id'] ?? 0;
    $currentDirectory = __DIR__;
    $parentDirectory = dirname($currentDirectory);

    $db = new Db();

    $sql = 'select count(*) from categories where name=:name';
    $arr = array(":name" => $categoriesName);
    $result = $db->select($sql, $arr)[0];

    if ($result['count(*)'] > 1) {
        echo '<h1>Tên Sản phẩm đã tồn tại, vui lòng sửa tên sản phẩm khác</h1>';
        echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';
        exit();
    }

    $sql = "update categories set name = :name where id=:id";

    $arr = array(":name" => $categoriesName, ":id" => $id);

    $result = $db->update($sql, $arr);

    if ($result > 0) {
        echo "<h1>Sửa thành công</h1>";
    } else {
        echo '<h1>Sửa sản phẩm thất bại, xin hãy thử lại</h1>';
    }
}
echo '<a href="index.php">Nhấp vào đây để về lại trang chủ</a>';


?>