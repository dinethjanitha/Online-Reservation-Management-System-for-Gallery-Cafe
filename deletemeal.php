<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>
<?php session_start() ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["meal_id"])) {
    $meal_id = $_GET["meal_id"];

    $query = "DELETE FROM meals WHERE mealid = '{$meal_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managemeals.php?delete=true");
    } else {
        header("Location: managemeals.php?delete=false");
    }
} else {
    header("Location: managemeals.php?meal_id=notfound");
}
