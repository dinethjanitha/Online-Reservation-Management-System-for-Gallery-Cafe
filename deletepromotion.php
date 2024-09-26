<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["promotion_id"])) {

    $promotion_id = $_GET["promotion_id"];

    $query = "SELECT * FROM promotions WHERE promotion_id = '{$promotion_id}'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $promotion_img_path = $row['menu_img'];
            unlink($promotion_img_path);
        }
    }

    $query = "DELETE FROM promotions WHERE promotion_id = '{$promotion_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managepromotions.php?delete=true");
    } else {
        header("Location: managepromotions.php?delete=false");
    }
} else {
    header("Location: managepromotions.php?promotion_id=notfound");
}
