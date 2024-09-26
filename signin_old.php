<?php include_once("./inc/connection.php") ?>
<?php include_once("./inc/check_field.php") ?>
<?php session_start() ?>

<?php

if (isset($_POST['submit'])) {
    $req_feild = array("email", "password");

    $errors = array();

    $error = array_merge($errors, check_req_field($req_feild));

    $min_len = array("email" => 5, "password" => 3);

    $error = array_merge($error, min_len_check($min_len));

    // echo "<pre>";
    // print_r($error);
    // echo "</pre>";

    if (empty($error)) {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $passwordhash = sha1($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='{$passwordhash}' LIMIT 1";

        $result = mysqli_query($conn, $query);

        query_check($result);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['usertype'] = $row['usertype'];
            $cookiename = "username";
            $cookievalue = $row["first_name"];

            header("Location: index.php?login=true");

            setcookie($cookiename, $cookievalue, time() + 3600);
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</head>

<body>

    <style>
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login {
            border: 1px solid black;
            padding: 20px 40px 20px 40px;
            border-radius: 10px;
        }
    </style>
    <div class="container">
        <div class="row col-12 d-flex justify-content-center ">

            <div class="login col-md-5">
                <h2 class="text-center">Sign In Here</h2>
                <div>
                    <?php
                    if (isset($error) && !empty($error)) {
                        displayErrors($error);
                    }

                    ?>
                </div>
                <form action="#" method="post">
                    <div class="mb-3 flex-grow">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="">
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" name="submit" class="btn bg-primary col-3">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>