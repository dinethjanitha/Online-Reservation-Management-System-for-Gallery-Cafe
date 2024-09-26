<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $req_field = array("first_name", "last_name", "email", "password");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("first_name" => 3, "last_name" => 3, "email" => 5, "password" => 3);

    $error = array_merge($error, min_len_check($min_len));

    $error = array_merge($error, email_validation($email));

    $query = "SELECT * FROM users WHERE email ='{$email}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "Email Already Exits!";
    }




    if (empty($error)) {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $passwordhash = sha1($password);

        $query = "INSERT INTO users(first_name,last_name,email,password,usertype) VALUES('{$first_name}','{$last_name}','{$email}','{$passwordhash}','normaluser')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $loginsucc = "<div class=\"alert alert-success\" role=\"alert\"> Registration success! pls Login </div>";
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
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <title>Sign Up</title>
</head>

<body>
    <style>
        button a {
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
                    <div class="header-text mt-3 mb-0">
                        <h2 class="mt-3">Sign Up Here</h2>
                        <p>We are happy to have you back.</p>
                        <?php
                        if (isset($loginsucc)) {
                            echo $loginsucc;
                        }
                        ?>
                    </div>
                    <?php
                    if (isset($error) && !empty($error)) {
                        displayErrors($error);
                    }

                    ?>
                    <form action="signup.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="first_name" class="form-control form-control-lg bg-light fs-6" placeholder="First Name">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="last_name" class="form-control form-control-lg bg-light fs-6" placeholder="First Name">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                        </div>

                        <div class="input-group mb-2">
                            <button name="submit" class="btn btn-lg btn-primary w-100 fs-6">Sign Up</button>
                        </div>
                        <div class="input-group mb-2">
                            <button name="submit" class="btn btn-lg  w-100 fs-6">Already Have Account? <a href="signin.php">Sign In</a></button>
                        </div>
                    </form>
                    <div class="row">
                        <small></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>