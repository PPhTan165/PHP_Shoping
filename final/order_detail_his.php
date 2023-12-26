<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Chi tiết hóa đơn</title>
</head>
<body>
    <?php require_once("head.php") ?>
    <div class="container">
        <h1>Chi tiết hóa đơn</h1>
        <table class="table mt-5">
            <thead>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Loại</th>
                <th>Nhà sản xuất</th>
            </thead>

            <tbody>
                <?php 
                $db = new Db();
                if(isset($_GET)){
                    $id = $_GET['id'];
                    $sql = "SELECT order_details.id , product.name , order_details.quantity ,
                    manufacturer.name as manufacturer,
                    categories.name as categories,
                    product.price as price 
                    FROM `order_details`
                    JOIN product on order_details.product_id = product.id
                    join manufacturer on product.manufacturer_id = manufacturer.id
                    JOIN categories on product.categories_id = categories.id
                    WHERE order_details.orders_id = :ordersID";
                    $arr = array(":ordersID"=>$id);
                    $orderDetailList = $db->select($sql,$arr);
                    // var_dump($orderDetailList);
                    $index = 1;
                    
                    foreach ($orderDetailList as $orderDetail) {
                        echo "<tr>";
                        echo "<td>".$index++."</td>";
                        echo "<td>".$orderDetail['name']."</td>";
                        echo "<td>".$orderDetail['quantity']."</td>";
                        echo "<td>".number_format(($orderDetail['price']*$orderDetail['quantity']),0)."</td>";
                        echo "<td>".$orderDetail['manufacturer']."</td>";
                        echo "<td>".$orderDetail['categories']."</td>";
                        echo "</tr>";
                    }
                }else{
                
                }
                
                ?>
            </tbody>
        </table>
        <button class="btn" onclick="goBack()">Quay lại</button>
    </div>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
</body>
</html>