<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>
<?php session_start() ?>

<?php


if (!$_SESSION["usertype"] == "SystemAdmin" || !$_SESSION["usertype"] == "operational" || !$_SESSION["usertype"] == "normaluser") {
    header("Location: signin.php?access=false");
}

?>

<script>
    const meals = [];
    var addmeal = {};
</script>

<?php
$query = "SELECT * FROM meals
        INNER JOIN categories ON meals.catagory_id = categories.catagory_id;";

$result = mysqli_query($conn, $query);

query_check($result);

if (mysqli_num_rows($result) >= 1) {
    // echo "items founded!";
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<script>";
        // echo "console.log(\"added\");";
        echo "addmeal = { 
                meal_id:{$row['mealid']}, 
                meal_name:\"{$row['meal_name']}\",
                meal_img:\"{$row["meal_img"]}\", 
                meal_price:{$row["price"]} 
            };";

        echo "meals.push(addmeal);";
        echo "addmeal = {};";
        echo "</script>";
    }
    echo "<script>";
    echo "localStorage.setItem('meals', JSON.stringify(meals))";
    echo "</script>";
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pre Order</title>
    <link rel="stylesheet" href="style.css" />
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
}

?>


<body class="">
    <div class="container">
        <header class="main">
            <div class="title">PRODUCT LIST</div>
            <div class="icon-cart">
                <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                </svg>
                <span class="totle-item">0</span>
            </div>
        </header>

        <div class="list-product">

        </div>
    </div>

    <div class="cart-tab bg-secondary">
        <h1>Shipping Cart</h1>
        <div class="list-cart">
        </div>
        <div class="btn-n">
            <button class="close">Close</button>
            <input type="hidden" name="">
            <button class="check-out" type="submit">Check Out</button>
        </div>
    </div>



</body>

<script src="./js/script.js"></script>

</html>