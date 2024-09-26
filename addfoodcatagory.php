<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!isset($_SESSION["first_name"])) {
    header("Location: signin.php?access=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_POST["submit"])) {
    $catagory_name = $_POST['catagory_name'];
    $catagory_description = $_POST['catagory_description'];


    //check user has filed or not req field
    $req_field = array("catagory_name", "catagory_description");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("catagory_name"  => 3, "catagory_description" => 5);

    $error = array_merge($error, min_len_check($min_len));



    $query = "SELECT * FROM categories WHERE catagory_name ='{$catagory_name}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "Catagory Already Exits!";
    }




    if (empty($error)) {
        $catagory_name = mysqli_real_escape_string($conn, $_POST['catagory_name']);
        $catagory_description = mysqli_real_escape_string($conn, $_POST['catagory_description']);

        $query = "INSERT INTO categories(catagory_name,catagory_description) 
                    VALUES('{$catagory_name}','{$catagory_description}')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "user Added";

        header("refresh:2;url=managefoodcatagories.php");
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
    <title>Add Food Catagory</title>
    <link rel="stylesheet" href="./style.css">
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

<body class="">
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
                    echo    "Food Catagory Added Successfull!";
                    echo  "</div>";
                }
                ?>
                <form action="addfoodcatagory.php" method="post">
                    <div class="mb-3">
                        <label for="catagory_name" class="form-label">Catagory Name</label>
                        <input type="catagory_name" class="form-control" <?php if (isset($catagory_name)) {
                                                                                echo "value=\"" . $catagory_name . "\"";
                                                                            } ?> id="catagory_name" name="catagory_name" placeholder="Special Food">
                    </div>
                    <div class="mb-3">
                        <label for="catagory_description" class="form-label">Catagory Description</label>
                        <input type="catagory_description" class="form-control" <?php if (isset($catagory_description)) {
                                                                                    echo "value=\"" . $catagory_description . "\"";
                                                                                } ?> id="catagory_description" name="catagory_description" placeholder="This is new and very Special food">
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