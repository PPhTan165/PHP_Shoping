<?php
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        table tr td {
            border: 2px solid;
        }

        label {
            width: 100px;
        }

        .input-info-user {
            padding: 5px;
            margin: 10px 0px
        }

        .note {
            height: 100px;


        }
    </style>
</head>

<body>
    <?php 
    require_once('head.php');
    $db = new Db();
    $sql = " select * from product";
    $products = $db->select($sql);

    $err = false;
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_GET['action'])) {
        function updateCart($add = false)
        {
            foreach ($_POST['quantity'] as $id => $quantity) {
                if ($add) {
                    if (!isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id] = 10;
                    } else {
                        $_SESSION['cart'][$id] += $quantity;
                    }
                } else {
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }

        function updateCartDetail($add = false){
            foreach ($_POST['quantity'] as $id => $quantity) {
                if ($add) {
                    if (!isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id] += $quantity;
                    }
                } else {
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }

        switch ($_GET['action']) {
            case 'add':
                updateCart(true);
                // header('Location: ./cart.php');
                break;
            case 'addDetail':

                updateCart(true);
                // header('Location: ./cart.php');exit;
                break;
            case 'delete':
                if (isset($_GET['id'])) {

                    unset($_SESSION['cart'][$_GET['id']]);
                }
                // header('Location: cart.php');
                // exit; 
                break;
            case 'submit':

                if (isset($_POST['update-click'])) {
                    updateCart();
                    // header('location: ./cart.php');
                } elseif (isset($_POST['order-click'])) {

                    if (empty($_POST['name'])) {
                        if (empty($_POST['quantity'])) {
                            $err = "Gio hang rong";
                        }else 
                        echo "<script>window.location.href='order_detail.php'</script>";
                    }

                }

                break;
        }
    }

    function totalOneProduct()
    {
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            $db = new Db();
            $cart = $_SESSION['cart'];

            foreach ($cart as $id => $quantity) {
                $query = "SELECT * FROM product WHERE id = :id";
                $arr = array(":id" => $id);

                $product = $db->select($query, $arr)[0];
                $total_one_product = $product['price'] * $quantity;

            }
            return $total += $total_one_product;
        }
    }

    function updateQuantity($productId)
    {
        if (isset($_POST['add_to_cart'])) {
            // Thêm sản phẩm vào giỏ hàng hoặc cập nhật số lượng
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]++;
            } else {
                $_SESSION['cart'][$productId] = 1;
            }
        }
    }

    if (!isset($_SESSION['user'])) {
        
        echo "<script>alert('Vui lòng đăng nhập để thanh toán.');</script>";
        
        echo "<script>window.location.href='login.php';</script>";
        
        exit;
    }




    //in san pham vao gio hang
    function cart()
    {
        $index = 1;
        if (!empty($_SESSION['cart'])) {
            $db = new Db();
            $cart = $_SESSION['cart'];


            foreach ($cart as $id => $quantity) {
                $query = "SELECT * FROM product WHERE id = :id";
                $arr = array(":id" => $id);

                $product = $db->select($query, $arr)[0];
                $total_one_product = $product['price'] * $quantity;

                echo "<tr>";
                echo "    <td class = 'text-center'>" . $index++ . "</td>";
                echo "    <td class = 'col-4'>" . $product['name'] . "</td>";
                echo "    <td class='col-2 text-center'><img src='img/" . $product['image'] . "' alt='Hinh tuong trung' height='100px'></td>";
                echo "    <td class='col-2 text-center'><input type='number' class='col-2 text-center' name='quantity[" . $product['id'] . "]' id='' min ='1' max ='" . $product['stocks'] . "' value = '" . $quantity . "'></td>";
                echo "    <td class ='text-center'>" . number_format($total_one_product, 0) . "</td>";
                echo "    <td class= 'text-center'> <a href='cart.php?action=delete&id=".$product['id']."' onclick=confirmDel(".$product['id'].") >DELETE</a></td>";
                echo "</tr>";
            }
        }
    }
    //tinh tong gia tien san pham
    function totalPrice()
    {
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            $db = new Db();
            $cart = $_SESSION['cart'];


            foreach ($cart as $id => $quantity) {
                $query = "SELECT * FROM product WHERE id = :id";
                $arr = array(":id" => $id);
                $product = $db->select($query, $arr)[0];
                $total += $product['price'] * $quantity;
            }
        }
        return $total;
    }

    ?>



    <div class="container">
        <?php if (!empty($err)) { ?>
            <div>
                <?= $err ?> <a href="javascript:history.back()">Quay lai gio hang</a>
            </div>
        <?php } else { ?>

            <h2>Giỏ hàng</h2>
            <div class="col">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <form action="cart.php?action=submit" method="post">
                            <table class="col-lg-12 ">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Ten san pham</th>
                                    <th>Hinh san pham</th>
                                    <th>So luong</th>
                                    <th>Gia</th>
                                    <th>Xoa</th>
                                </tr>
                                <?php
                                cart();
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tổng cộng</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class='text-center'>
                                        <?php if (totalPrice() > 0) {
                                            echo number_format(totalPrice());
                                        } else {
                                            echo totalPrice();
                                        } ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                    </div>
                </div>


                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-end">

                            <h4>Tổng cộng: <span style="color:red">
                                    <?= number_format(totalPrice()); ?> VND
                                </span> </h4>


                            <?php if (totalPrice() > 0): ?>
                                <input type="submit" class="btn" name="update-click" value="Cập nhật giỏ hàng">
                            <?php endif; ?>
                    
                            <input type="submit" class="btn " name="order-click" value="Thanh toán" />
                            

                        </div>
                    </div>
                </div>
            </div>
            </form>
        <?php } ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
            function confirmDel(id){
                if(confirm("Bạn có chắc muốn xóa đơn hàng?")){
                    window.location.href="cart.php?action=delete&id=" + id; 
                }
            }
        </script>
</body>

</html>