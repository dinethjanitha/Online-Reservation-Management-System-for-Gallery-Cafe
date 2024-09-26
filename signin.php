<?php include_once("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>
<?php session_start() ?>
<?php
if (isset($_POST['submit'])) {
    $req_feild = array("email", "password");
    $errors = array();

    $error = array_merge($errors, check_req_field($req_feild));

    $min_len = array("email" => 5, "password" => 3);

    $error = array_merge($error, min_len_check($min_len));

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
        } else {
            $error[] = "Invalid Email Or Password";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Sign In</title>
</head>

<body>
    <style>
        .btn-light a {
            text-decoration: none;
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">


        <div class="row border rounded-5 p-3 bg-white shadow box-area">


            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #ffa323;">
                <div class="featured-image mb-3">
                    <img src="img/login.png" class="img-fluid" style="max-width: 750px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">The Gallery Cafe</p>
                <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Login Here to get Amazing cafe experience</small>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mt-5 mb-0">
                        <h2 class="mt-3">Hello,Again</h2>
                        <p>We are happy to have you back.</p>
                    </div>
                    <?php
                    if (isset($error) && !empty($error)) {
                        displayErrors($error);
                    }

                    ?>
                    <form action="signin.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                        </div>
                        <div class="input-group mb-5">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                        </div>

                        <div class="input-group mb-2">
                            <button name="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                    </form>

                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-light w-100 fs-6"><a href="signup.php">Don't have account? Sign Up</a></button>
                    </div>
                    <div class="row">
                        <small></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>