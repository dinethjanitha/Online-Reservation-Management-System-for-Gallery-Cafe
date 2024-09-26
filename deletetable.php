<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["table_id"])) {
    $table_id = $_GET["table_id"];

    $query = "UPDATE tables SET is_deleted= 1 WHERE table_id = '{$table_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managetables.php?delete=true");
    } else {
        header("Location: managetables.php?delete=false");
    }
} else {
    header("Location: managetables.php?table_id=notfound");
}
