<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>


<?php
$query = "SELECT * FROM promotions";

$result = mysqli_query($conn, $query);

query_check($result);

$cards = "";

if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cards .= "<div class=\"col-md-4 col-12 mb-4\">";
        $cards .= "<div class=\"card\">";
        $cards .= "<img src=\"{$row['promotion_img']}\" class=\"card-img-top\" alt=\"{$row['promotion_name']}\">";
        $cards .= "<div class=\"card-body\">";
        $cards .= "<h5 class='card-title main-span'>" . ucfirst($row['promotion_name']) . "</h5>";
        $cards .= "<p class='card-text'>" . htmlspecialchars($row['promotion_description']) . "</p>";
        $cards .= "<p class='card-text'><small class='text-muted'>Start Date: " . date('F j, Y', strtotime($row['start_date'])) . "</small></p>";
        $cards .= "<p class='card-text'><small class='text-muted'>End Date: " . date('F j, Y', strtotime($row['end_date'])) . "</small></p>";
        $cards .= "</div>";
        $cards .= "</div>";
        $cards .= "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions</title>

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
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-img-top {
        height: 600px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        color: #555;
    }

    .text-muted {
        font-size: 0.875rem;
    }
</style>

<body>
    <div class="container">
        <div class="row pt-1">
            <?php if (isset($cards)) {
                echo $cards;
            } ?>
        </div>
    </div>

</body>

</html>