<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_POST["submit"])) {
    $origin_name = $_POST['origin_name'];

    $origin_description = $_POST['origin_description'];
    //check user has filed or not req field
    $req_field = array("origin_name", "origin_description");

    $error = array();

    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("origin_name"  => 3, "origin_description" => 5);

    $error = array_merge($error, min_len_check($min_len));

    $query = "SELECT * FROM food_origin WHERE origin_name ='{$origin_name}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "origin Already Exits!";
    }




    if (empty($error)) {
        $origin_name = mysqli_real_escape_string($conn, $_POST['origin_name']);
        $origin_description = mysqli_real_escape_string($conn, $_POST['origin_description']);

        $query = "INSERT INTO food_origin(origin_name,origin_description) 
                    VALUES('{$origin_name}','{$origin_description}')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "Origin Added!";

        header("refresh:2;url=managefoodorigins.php");
    }

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";


    // echo "<pre>";
    // print_r($error);
    // echo "</pre>";
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food origin</title>
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
                    echo    "Food Origin Added Successfull!";
                    echo  "</div>";
                }
                ?>
                <form action="addfoodorigin.php" method="post">
                    <div class="mb-3">
                        <label for="origin_name" class="form-label">Origin Name</label>
                        <input type="origin_name" class="form-control" <?php if (isset($origin_name)) {
                                                                            echo "value=\"" . $origin_name . "\"";
                                                                        } ?> id="origin_name" name="origin_name" placeholder="Sri Lanka">
                    </div>
                    <div class="mb-3">
                        <label for="origin_description" class="form-label">origin Description</label>
                        <input type="origin_description" class="form-control" <?php if (isset($origin_description)) {
                                                                                    echo "value=\"" . $origin_description . "\"";
                                                                                } ?> id="origin_description" name="origin_description" placeholder="This is Sri lankan southern discric favourite food">
                    </div>


                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn bg-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>



</html>