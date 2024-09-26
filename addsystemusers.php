<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}


if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    //check user has filed or not req field
    $req_field = array("first_name", "last_name", "email", "password");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("first_name" => 3, "last_name" => 3, "email" => 5, "password" => 3);

    $error = array_merge($error, min_len_check($min_len));

    if ($usertype == "empty") {
        $error[] = "Select UserType Please";
    }

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
        $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

        $passwordhash = sha1($password);

        $query = "INSERT INTO users(first_name,last_name,email,password,usertype) VALUES('{$first_name}','{$last_name}','{$email}','{$passwordhash}','{$usertype}')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "User Added";

        header("refresh:2;url=managesystemusers.php");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add System Users</title>
</head>


<?php
if ($_SESSION['usertype'] == "normaluser") {
    include("./inc/mainheader.php");
} else if ($_SESSION['usertype'] == "SystemAdmin") {
    include("./inc/adminheader.php");
} else if ($_SESSION['usertype'] == "operational") {
    include("./inc/opheader.php");
}

?>

<body>
    <div class="container mt-4">

        <div class="row align-items-center justify-content-center">

            <div class="col-md-8">
                <?php if (isset($error) && !empty($error)) {
                    echo "<h3>Errors</h3>";
                    echo "<ul>";
                    foreach ($error as $er) {
                        echo "<li>" . $er . "</li>";
                    }
                    echo "</ul>";
                } ?>

                <?php
                if (isset($succ)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">";
                    echo    "User Added Successfull!";
                    echo  "</div>";
                }
                ?>

                <form action="addsystemusers.php" method="post">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="first_name" class="form-control" <?php if (isset($first_name)) {
                                                                            echo "value=\"" . $first_name . "\"";
                                                                        } ?> id="first_name" name="first_name" placeholder="John">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="last_name" class="form-control" <?php if (isset($last_name)) {
                                                                            echo "value=\"" . $last_name . "\"";
                                                                        } ?> id="last_name" name="last_name" placeholder="Albert">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" <?php if (isset($email)) {
                                                                        echo "value=\"" . $email . "\"";
                                                                    } ?> id="email" name="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="********">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">User Type</label>
                        <select class="form-select" id="userrole" name="usertype" aria-label="Default select example">
                            <option value="empty" selected>Open this select menu</option>
                            <option id="SystemAdmin" value="SystemAdmin">Systen Admin</option>
                            <option id="operational" value="operational">Oparational Stuff</option>
                            <option id="normaluser" value="normaluser">Normal User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn bg-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>

<?php
if (isset($usertype)) {
    echo "<script>document.getElementById('{$usertype}').setAttribute('selected','');</script>";
}
?>

</html>