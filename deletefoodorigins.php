<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["origin_id"])) {
    $origin_id = $_GET["origin_id"];

    $query = "UPDATE food_origin SET is_deleted= 1 WHERE origin_id = '{$origin_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managefoodorigins.php?delete=true");
    } else {
        header("Location: managefoodorigins.php?delete=false");
    }
} else {
    header("Location: managefoodorigins.php?origin_id=notfound");
}
