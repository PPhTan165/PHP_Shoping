<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
session_start();

$productClass = new Product();

if (isset($_SESSION["role"])) {
    if($_SESSION['role'] != 1) {
        echo '<h1>Bạn không có quyền truy cập vào trang này</h1>';
        echo '<a href="../index.php">Nhấp vào đây để về lại trang chủ</a>';
        exit();
    }
} else {
    echo '<h1>Vui lòng đăng nhập bằng tài khoản admin</h1>';
    echo '<a href="../login.php">Nhấp vào đây để đến trang đăng nhập</a>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <style>
        .card-body{
            box-shadow: 1px 1px 20px gray;
            border-radius: 20px;
        }
        .btn{
            border: 1px solid black;
        }
        .btn:hover{
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Thêm sản phẩm</p>

                                    <form action="add_product_action.php" method="POST" class="mx-1 mx-md-4" enctype="multipart/form-data">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example1c">Tên sản phẩm</label>
                                                <input type="text" id="form3Example1c" class="form-control"
                                                    name="name" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c">Giá sản phẩm</label>
                                                <input type="text" id="form3Example3c" class="form-control"
                                                    name="price" />
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Số lượng trong
                                                    kho</label>
                                                <input type="text" id="form3Example4c" class="form-control"
                                                name="stocks" />
                                            </div>
                                        </div>

                                        

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Xưởng:</label><br>
                                                <select class="form-control col-7" id="areaSelect" name = "manufacturer">
                                                    <?php
                                                    $productClass->getAllManufacturersSelect();
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Loại:</label><br>
                                                <select class="form-control col-7" id="areaSelect" name="categories">
                                                    <?php
                                                    $productClass->getAllCategoriessSelect();
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class=" flex-fill mb-0">
                                                <label  for="form3Example4cd">Hình ảnh</label>
                                                <input type="file" id="form3Example4cd"
                                                    name="image" accept="image/png, image/jpeg, image/jpg" />
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-lg col-4"
                                                name="create-product">ADD</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>