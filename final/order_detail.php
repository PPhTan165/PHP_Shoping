<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Hóa đơn</title>
    <style>
        table {
            border: 2px solid gray;
            text-align: center;
        }

        table tr:first-child {
            border: 1px solid gray;
        }
    </style>
</head>

<body>
    <?php require_once("head.php");

    function resultOrder(){
        $db = new Db();
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $sql = "select * from product where id = :id";
        $arr = array(':id' => $id);
        $products = $db->select($sql, $arr)[0];
        $total += $products['price'] * $quantity;
        // var_dump($products);
    
    }

    $sql_user = "SELECT * from user where email = :email";
    $arr_user = array(":email"=>$_SESSION['user']);
    $user = $db->select($sql_user, $arr_user)[0];



    $sql = "INSERT INTO `orders`( `total`, `status`, `user_id`) VALUES (:total,:status,:user_id)";
    $arr = array(
        ":total" => $total,
        ":status" => "create",
        ":user_id" => $user['id']
    );
    $result = $db->insert($sql, $arr);
   
    if ($result > 0) {
        $idInserted = $db->getInsertId();
        $_SESSION['order'] = $idInserted;
     
        foreach ($_SESSION['cart'] as $id => $quantity) {
    
            $sql_detail = "INSERT INTO `order_details`( `quantity`, `orders_id`, `product_id`) VALUES (:quantity,:order_id,:product_id)";
            $arr_detail = array(
                ":quantity" => $quantity,
                "order_id" => $idInserted,
                ":product_id" => $id
            );
            $result_detail = $db->insert($sql_detail, $arr_detail);
            if ($result_detail > 0) {

                $_SESSION['cart'] = [];
       
            } else {
                exit;
            }
        }
        echo "Đơn hàng thành công";
    } else {
        echo "Đơn hàng thất bại";
        exit;
    }
}
 
    ?>

    <div class="container  col-5">
        <h1 class="text-center mb-5"> <?php
            echo resultOrder();
        ?></h1>
       <p class="text-center"><a href="index.php" >Quay lại trang chủ tại đây</a>
</p>    </div>
</body>

</html>