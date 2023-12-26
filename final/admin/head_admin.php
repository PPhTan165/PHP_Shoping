<?php
    
    require "config/config.php";
    require ROOT . "/include/function.php";
    spl_autoload_register("loadClass");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Document</title>
    <style>
        nav.navbar.navbar-expand-lg.w-100 {
            box-shadow: 0px 0px 10px 1px black;
            margin-bottom: 50px;
            background-color: white;
            position: sticky;
            top: 0;
            z-index: 999;
        }



        .btn {
            border: 2px solid black;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>
    
       <nav class="navbar navbar-expand-lg w-100 ">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">ShopNhaLam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Quản lý sản phẩm</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="about.php">About</a></li> -->
                </ul>
                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <?php
                            $db = new Db();
                            $sql = "SELECT * from user where email = :email ";
                            $arr = array(":email"=>$_SESSION['user']);
                            $user = $db->select($sql,$arr)[0];
                            
                            ?>

                              <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $user['fullname'] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <li><a class="dropdown-item" href="../index.php">Đăng xuất</a></li>
                                </ul>
                            </li>

                        

                </div>
            </div>
        </div>
    </nav>


</body>


</html>