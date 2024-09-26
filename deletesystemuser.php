<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["userid"])) {
    $userid = $_GET["userid"];

    $query = "UPDATE users SET is_deleted= 1 WHERE userid = '{$userid}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managesystemusers.php?delete=true");
    } else {
        header("Location: managesystemusers.php?delete=false");
    }
} else {
    header("Location: managesystemusers.php?userid=notfound");
}
