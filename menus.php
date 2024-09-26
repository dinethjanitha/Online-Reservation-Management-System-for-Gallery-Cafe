<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>



<?php
$query = "SELECT * FROM menus";

$result = mysqli_query($conn, $query);

query_check($result);

$cards = "";

if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cards .=                "<div class=\"col-md-4 col-12 mt-0  \">";
        $cards .=                       "<h4 class='main-span'>" . ucfirst($row['menu_name']) . "<h4>";
        $cards .=                       "<img src=\"{$row['menu_img']}\" class=\"img-fluid p-1\" />";
        $cards .=                "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meals</title>
    <link rel="stylesheet" href="./style.css">
</head>

<?php
if (isset($_SESSION["usertype"])) {
    if ($_SESSION['usertype'] == "normaluser") {
        include("./inc/mainheader.php");
    } else if ($_SESSION['usertype'] == "SystemAdmin") {
        include("./inc/adminheader.php");
    } else if ($_SESSION['usertype'] == "operational") {
        include("./inc/opheader.php");
    }
} else {
    include("./inc/outheader.php");
}

?>


<style>
    .text-bg-danger {
        background-color: brown;
        color: white;
    }
</style>

<body>
    <div class="container">
        <!-- Features Section -->


        <div class="row mt-1">

            <?php if (isset($cards)) {
                echo $cards;
            } ?>
        </div>

    </div>
</body>

</html>