<?php
session_start();
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
    <style>
        body{
            background-color: white;
        }
        .container {
            margin-top: 150px;
            padding: 100px 20px;
            box-shadow: 0px 0px 50px 1px gray;
            background-color: white;
            border-radius: 12px;
        }

        .btn {
            border: 3px solid black;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            if (preg_match('/\s/', $email)) {
                echo "Email không được chứa khoảng trắng.";
            }
            $fullname = $_POST['full-name'];


            $password = trim($_POST['password']);


            $cfm_password = $_POST['confirm-password'];

            if (strpos($password, ' ') !== false) {
                echo "<script>alert('Mật khẩu không được chứa khoảng trắng')</script>";
                exit;
            }

            if ($password != $cfm_password) {
                echo "<script>alert('Mật khẩu và xác nhận mật khẩu không trùng khớp')</script>";
                exit;
            }
            $password_encrypt = md5($password);
            $db = new Db();
            $sql = " select count(id) from user where email = :email";
            $arr = array(":email" => $email);
            $count_user = $db->select($sql, $arr)[0];
            if ($count_user['count(id)'] > 0) {
                echo "<script>alert('Email đã tồn tại')</script>";

            } else {
                $insert_query = "INSERT INTO user (email, password, fullname, role_id) VALUES (:email, :password, :fullname, 2)";
                $insert_data = array(
                    ':email' => $email,
                    ':password' => $password_encrypt,
                    ':fullname' => $fullname
                );
                if (empty($email) || empty($fullname) || empty($password) || empty($cfm_password)) {
                    echo "<script>alert('Vui lòng điền đầy đủ thông tin.')</script>";
                } else {
                $insert_result = $db->insert($insert_query, $insert_data);
                if ($insert_result > 0) {
                    echo "<script>alert('Đăng kí thành công'); window.location.href='login.php'</script>";
                } else {
                    echo "<script>alert('Đăng kí thất bại')</script>";
                }
            }
            }
        }


    }



  

    // var_dump($_SESSION);exit;
    
    ?>
    <div class="container  col-3">
        <h1 class="text-center mb-5">Account Register</h1>
        <form action="register.php" method="post">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" id="email" class="form-control col-4" name="email" />
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="email">Full name</label>
                <input type="text" id="email" class="form-control col-4" name="full-name" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control" name="password" />
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="confirm-password">Confirm-Password</label>
                <input type="password" id="confirm-password" class="form-control" name="confirm-password" />
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-block mb-4 col-12" name='submit'>Sign up</button>
            <a href="login.php" class="text-center col-12">Đã có tài khoản.</a>
            <!-- Register buttons -->
            <div class="text-center">



            </div>
        </form>
    </div>
</body>

</html>