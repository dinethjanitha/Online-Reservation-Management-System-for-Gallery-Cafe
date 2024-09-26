<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["menu_id"])) {

    $menu_id = $_GET["menu_id"];

    $query = "SELECT * FROM menus WHERE menu_id = '{$menu_id}'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $menu_img_path = $row['menu_img'];
            unlink($menu_img_path);
        }
    }

    $query = "DELETE FROM menus WHERE menu_id = '{$menu_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_affected_rows($conn)) {
        header("Location: managemenus.php?delete=true");
    } else {
        header("Location: managemenus.php?delete=false");
    }
} else {
    header("Location: managemenus.php?menu_id=notfound");
}
