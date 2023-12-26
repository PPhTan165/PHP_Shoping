
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
require_once("head.php");
?>


<?php
$db = new Db();
if(isset($_GET)){
    $id = $_GET['id'];
    $sql ="update orders set status = 'done' where id = :id";
    $arr = array(":id"=>$id);
    $result = $db->select($sql,$arr);
    echo "<h1>Giao hàng thành công!!! </h1>";
    echo "<a href='history.php'>Quay lại lịch sử đặt hàng</a>";

}else{
    
}

?>
</body>
</html>
