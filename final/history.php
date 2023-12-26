<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Document</title>
</head>

<body>

</body>
    <?php
        require_once("head.php");
    ?>

    <div class="container">
        <h1>Lịch sử đặt hàng</h1>
        <table class="table talbe-striped mt-5">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php
                 
                if(isset($_SESSION['user'])){
                    $email = $_SESSION['user'];
                }else{
                    header("Location: login.php");
                }

                $db = new Db();

                $sql = "select orders.id, orders.total, orders.status from orders join user on orders.user_id = user.id
                where user.email  = :email";
                $arr = array(":email"=>$email);
                $orderList = $db->select($sql,$arr);
                $index =1;
                foreach ($orderList as $order) {
                    // var_dump($order);
                    echo "<tr>";
                    echo "<td>".$index++."</td>";
                    $status = '';
                    if($order['status']=='create'){
                        $status = 'Đã đặt hàng';
                    }else if($order['status']=='done'){
                        $status = 'Hoàn thành';
                    }else{
                        $status = 'Đã hủy';
                    }
                    echo "<td>".$status."</td>";
                    echo "<td>".number_format($order['total'],0)." VNĐ</td>";
                    echo "<td><a href='order_detail_his.php?id=".$order['id']."'>Xem chi tiết hóa đơn</a></td>";
                    echo "<td><a href='#' onclick=confirmDone(".$order['id'].")>Đã nhận được hàng</a></td>";
                    echo "<td><a href='#' onclick=confirmCancel(".$order['id'].")>Hủy</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmCancel(id){
            if(confirm("Bạn có chắc muốn hủy đơn hàng chứ?")){
                window.location.href="cancel.php?id=" + id;
            }
        }
        function confirmDone(id){
            if(confirm("Bạn có chắc đã nhận được đơn hàng chứ?")){
                window.location.href="done.php?id=" + id;
            }
        }
    </script>
</html>