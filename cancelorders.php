<?php include("./inc/req_functions.php") ?>
<?php
session_start();
include('./inc/connection.php');

if (!isset($_GET['order_id'])) {
    header("Location: userprofile.php?order_id=flase");
}
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php?session=false");
}
$order_id = $_GET['order_id'];
$userid = $_SESSION['userid'];

$query = "SELECT * FROM preorders WHERE userid='{$userid}' AND order_id='{$order_id}'";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) == 1) {
        $query = "UPDATE preorders SET order_status='canceled'";
        $result = mysqli_query($conn, $query);
        query_check($result);

        header("Location: userprofile.php?ordercancel=true");
    } else {
        header("Location: userprofile.php?unauth=true");
    }
} else {
    die(mysqli_errno($conn));
}
