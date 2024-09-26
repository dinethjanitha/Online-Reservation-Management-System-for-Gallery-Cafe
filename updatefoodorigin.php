<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!isset($_GET['origin_id']) && !isset($_POST['submit'])) {
    header("Location: managefoodcatagories.php?selectuser=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET['origin_id'])) {
    $origin_id = $_GET['origin_id'];

    $query = "SELECT * FROM food_origin WHERE origin_id='{$origin_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $origin_id = $row['origin_id'];
        $origin_name = $row['origin_name'];
        $origin_description = $row['origin_description'];
    }
}

if (isset($_POST["submit"])) {
    $origin_name = $_POST['origin_name'];
    $origin_description = $_POST['origin_description'];
    $origin_id = $_POST['origin_id'];


    //check user has filed or not req field
    $req_field = array("origin_name", "origin_description");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("origin_name"  => 3, "origin_description" => 5);

    $error = array_merge($error, min_len_check($min_len));



    $query = "SELECT * FROM food_origin WHERE origin_name ='{$origin_name}' AND origin_id != '{$origin_id}' ";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "origin Already Exits!";
    }

    if (empty($error)) {
        $origin_name = mysqli_real_escape_string($conn, $_POST['origin_name']);
        $origin_description = mysqli_real_escape_string($conn, $_POST['origin_description']);
        $origin_id = mysqli_real_escape_string($conn, $_POST['origin_id']);

        $query = "UPDATE food_origin SET origin_name='{$origin_name}' , origin_description='{$origin_description}'
                 WHERE origin_id = '{$origin_id}' ";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "origin Updated!";

        header("refresh:2;url=managefoodorigins.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meals</title>
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
    <div class="container">
        <form action="updatefoodorigin.php" method="post" enctype="multipart/form-data">
            <div>
                <?php
                if (isset($error)) {
                    displayErrors($error);
                }

                ?>
            </div>
            <?php
            if (isset($succ)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo    "Food Origin Updated Successfull!";
                echo  "</div>";
            }
            ?>
            <input type="hidden" name="origin_id" <?php if (isset($origin_id)) {
                                                        echo "value=\"" . $origin_id . "\"";
                                                    } ?>>
            <div class="mb-3">
                <label for="origin_name" class="form-label">origin Name</label>
                <input type="text" class="form-control" id="origin_name" <?php if (isset($origin_name)) {
                                                                                echo "value=\"" . $origin_name . "\"";
                                                                            } ?> name="origin_name" placeholder="Special">
            </div>
            <div class="mb-3">
                <label for="origin_description" class="form-label">origin Name</label>
                <input type="text" class="form-control" id="origin_description" <?php if (isset($origin_description)) {
                                                                                    echo "value=\"" . $origin_description . "\"";
                                                                                } ?> name="origin_description" placeholder="This is .......">
            </div>

            <div class="mb-3">
                <button type="submit" name="submit" class="btn bg-primary ">Submit</button>
            </div>

        </form>


    </div>
</body>

</html>