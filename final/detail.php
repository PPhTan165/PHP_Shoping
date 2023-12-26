<?php



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Detail Product</title>
</head>

<body>
    <?php


       
    ?>
    <div class="header">
        <?php  require_once("head.php"); 
            $db = new Db();
            $sql = "SELECT * FROM product WHERE id = :id";
            $arr = array(":id" =>$_GET['id']);
            $product = $db->select($sql,$arr)[0];
        ?>
    </div>
    <section class="py-5">
        <div class="container">
            <h2>Thong tin chi tiet</h2>
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">

                        <img style="max-width: 100%; height: 300px; margin: auto;" class="rounded-4 fit" src="img/<?php echo $product['image'] ?>" />

                    </div>

                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            <?php echo $product['name'] ?> <br />
                            Loai:
                            <?php
                            $sql_categori = "SELECT categories.name FROM `product`join categories 
                            ON product.categories_id = categories.id 
                            WHERE product.id= :id";
                            $arr = array(":id"=>$product['id']);
                            $result_categori = $db->select($sql_categori,$arr)[0];
                       
                            echo $result_categori['name'];
                            ?>
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i><?= $product['stocks'] ?></span>
                            <span class="text-success ms-2">In stock</span>
                        </div>
                        <div class="rate">
                          <strong><?=$product['review']?></strong>
                          <span class="text-success ms-2">Lượt đánh giá</span> 
                        </div>
                        <div class="mb-3">
                            <span class="h5"><?= number_format($product['price'], 2) ?></span>
                            <span class="text-muted">VNĐ</span>
                        </div>

                        <hr />


                        <!-- col.// -->
                        <form id="add-to-cart-form" action="cart.php?action=addDetail" method="post">
                        <div class="col-md-4 col-6 mb-3">
                            <label class="mb-2 d-block">Nhap so luong</label>
                            <div class="input-group mb-3" style="width: 80px;">
                                <input type="number" min="1" max="<?=$product['stocks']?>" 
                                class="form-control text-center border border-secondary"  
                                value="1"
                                name="quantity[<?= $product['id']?>]" />
                            </div>
                            <input type="submit" 
                            class="btn btn-outline-dark shadow-0 " 
                            value=" Add to cart"/>
                        </div>
                        </form>
                    </div>
            
                    <!-- <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Save </a> -->
               
                </div>
            </main>
        </div>
        </div>
    </section>
</body>

</html>