<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>



<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["catagory_id"])) {
    $catagory_id = $_GET["catagory_id"];

    $query = "UPDATE categories SET is_deleted= 1 WHERE catagory_id = '{$catagory_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managefoodcatagories.php?delete=true");
    } else {
        header("Location: managefoodcatagories.php?delete=false");
    }
} else {
    header("Location: managefoodcatagories.php?catagory_id=notfound");
}
