<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>
<?php session_start() ?>



<?php

if (isset($_POST['searchsubmit'])) {
    $searchval = $_POST['searchval'];
    $query = "SELECT * FROM meals
        INNER JOIN categories ON meals.catagory_id = categories.catagory_id
        INNER JOIN food_origin ON meals.origin_id = food_origin.origin_id
        WHERE origin_name LIKE '%{$searchval}%' OR meal_name LIKE '%{$searchval}%'
             OR description LIKE '%{$searchval}%' OR catagory_name LIKE '%{$searchval}%' AND catagory_name = 'Special'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $cards = "";

    if (mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {

            $cards .=           "<div class=\"card col-lg- col-md-4 mb-4\" style=\"width:22rem; \" >";
            $cards .=                "<div class=\"feature-img card-img\">";
            $cards .=                       "<img src=\"{$row['meal_img']}\" class=\"img-fluid p-1\" />";
            $cards .=                "</div>";
            $cards .=               "<div class=\"p-4\">";
            $cards .=                   "<h3>" . ucfirst($row['meal_name']) . " " . "<span class=\"badge text-bg-danger\">" . $row['catagory_name'] . "</span>" . "</h3>";
            $cards .=                   "<p>" . ucfirst($row['description']) . "</p>";
            $cards .=                   "<p class=\"price\">Rs.{$row['price']}.00</del></p>";
            $cards .=                   "<p class=\"origin\">This Food from " .  "<span class=\"badge bg-warning\">" . $row['origin_name'] . "</span>" . "</del></p>";
            $cards .=               "</div>";
            $cards .=           "</div>";
        }
    } else {
        header("Location: viewmeals.php?data=notfound");
    }
} else {
    $query = "SELECT * FROM meals
        INNER JOIN categories ON meals.catagory_id = categories.catagory_id
        INNER JOIN food_origin ON meals.origin_id = food_origin.origin_id
        WHERE catagory_name = 'Special'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $cards = "";

    while ($row = mysqli_fetch_assoc($result)) {

        $cards .=           "<div class=\"card col-lg- col-md-4 mb-4\" style=\"width:22rem; \" >";
        $cards .=                "<div class=\"feature-img card-img\">";
        $cards .=                       "<img src=\"{$row['meal_img']}\" class=\"img-fluid p-1\" />";
        $cards .=                "</div>";
        $cards .=               "<div class=\"p-4\">";
        $cards .=                   "<h3>" . ucfirst($row['meal_name']) . " " . "<span class=\"badge text-bg-danger\">" . $row['catagory_name'] . "</span>" . "</h3>";
        $cards .=                   "<p>" . ucfirst($row['description']) . "</p>";
        $cards .=                   "<p class=\"price\">Rs.{$row['price']}.00</del></p>";
        $cards .=                   "<p class=\"origin\">This Food from " .  "<span class=\"badge bg-warning\">" . $row['origin_name'] . "</span>" . "</del></p>";
        $cards .=               "</div>";
        $cards .=           "</div>";
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
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

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

    .meal-header {
        color: #ffa323;
        font-size: large;
    }

    .card {
        margin-left: 20px;
    }

    .origin {
        font-size: 18px;
    }
</style>

<body>
    <div class="container">



        <section id="feature">
            <div class="feature-section wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <h2>This Is Our Special Food Items</h2>
                                <span class="meal-header">Our Foods Items</span>
                            </div>
                        </div>
                    </div>
                    <form action="spmeals.php" method="post">
                        <div class="row mt-3">
                            <div class="col-5" style="color:red">
                                <?php if (isset($_GET['data'])) {
                                    if ($_GET['data'] == "notfound") {
                                        echo "Meals Not Fonud!";
                                    }
                                } ?>
                            </div>
                        </div>

                        <div class="d-flex search-bar flex-row  align-items-center mt-3 mb-3">

                            <div class="flex-grow-1">
                                <input type="text" class="form-control col-10" name="searchval" <?php if (isset($searchval)) {
                                                                                                    echo "value=\"" . $searchval . "\"";
                                                                                                } ?> placeholder="Search with Meal Name or Origin Name or Description">
                            </div>
                            <div class="bt">
                                <button type="submit" class="btn form-control" name="searchsubmit"> <i class="fas fa-search"></i></button>
                            </div>

                        </div>
                    </form>
                    <div class="row pt-5">

                        <?php if (isset($cards)) {
                            echo $cards;
                        } ?>
                    </div>

                </div>
            </div>
        </section>

    </div>
</body>

</html>