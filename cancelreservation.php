<?php include("./inc/req_functions.php") ?>
<?php
session_start();
include('./inc/connection.php');
if (!isset($_GET['reservation_id'])) {
    header("Location: userprofile.php?reservation_id=flase");
}
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php?session=false");
}
$reservation_id = $_GET['reservation_id'];
$userid = $_SESSION['userid'];

$query = "SELECT * FROM table_reservation WHERE userid='{$userid}' AND reservation_id='{$reservation_id}'";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) == 1) {
        $query = "UPDATE table_reservation SET reservation_status='canceled'";
        $result = mysqli_query($conn, $query);
        query_check($result);

        header("Location: userprofile.php?ordercancel=true");
    } else {
        header("Location: userprofile.php?unauth=true");
    }
} else {
    die(mysqli_errno($conn));
}
