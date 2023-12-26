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
        body {
            background-color: white;
        }

        .container {
            margin-top: 200px;
            padding: 100px 20px;
            box-shadow: 0px 0px 50px 1px gray;
            border-radius: 12px;
            background-color: white;
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
        $db = new Db();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['submit'])) {

                $email = $_POST['email'];
                $password = $_POST['password'];

                $sql = 'select * from user where email = :email';
                $arr = array(":email" => $email);

                $userList = $db->select($sql, $arr);

                if (count($userList) > 0) {
                    $user = $userList[0];
                    $md5 = md5($password);

                    if ($md5 == $user['password']) {
                        session_start();
                        $_SESSION["user"] = $email;
                        $_SESSION["role"] = $user["role_id"];

                        if ($user["role_id"] == 1) {
                            header("Location: ./admin/index.php");
                        } else {
                            header("Location: index.php");
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Password is wrong</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email does not exist</div>";
                }


            }
        }

        ?>
    <div class="container  col-3">
        <h1 class="text-center">Đăng nhập tài khoản</h1>
        <form action="login.php" method="post">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Email </label>
                <input type="email" id="form2Example1" class="form-control col-4" name="email" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Mật khẩu</label>
                <input type="password" id="form2Example2" class="form-control" name="password" />
            </div>




            <!-- Submit button -->
            <button type="submit" class="btn btn-block mb-4 col-12" name="submit">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Bạn chưa có tài khoản? <a href="register.php">Hãy đăng ký tại đây.</a></p>


            </div>
        </form>
    </div>
</body>

</html>