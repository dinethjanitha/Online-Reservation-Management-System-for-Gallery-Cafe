<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["order_id"])) {

    $order_id = $_GET["order_id"];

    $query = "SELECT * FROM preorders WHERE order_id='{$order_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['order_id'];
        $userid = $row['userid'];
    }

    $query = "DELETE FROM order_meals WHERE order_id = '{$order_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $query = "DELETE FROM preorders WHERE order_id = '{$order_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    echo "Deleted Successfull!";

    header("Location: manageorders.php?deleted=true");
}
