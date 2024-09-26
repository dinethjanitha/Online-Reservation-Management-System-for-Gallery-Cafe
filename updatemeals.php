<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

?>
<?php
if (!isset($_GET['meal_id']) && !isset($_POST['submit'])) {
    header("Location: managemeals.php?selectuser=false");
}

?>

<script>
    let catagories = {};
    let origins = {};
</script>

<?php


$query = "SELECT * from categories";

$result = mysqli_query($conn, $query);

query_check($result);

if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<script>";
        echo "catagories[{$row['catagory_id']}] = '{$row['catagory_name']}' ";
        echo "</script>";
    }
}

$query = "SELECT * from food_origin";

$result = mysqli_query($conn, $query);

query_check($result);

if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<script>";
        echo "origins[{$row['origin_id']}] = '{$row['origin_name']}' ";
        echo "</script>";
    }
}

?>




<?php
if (isset($_GET['meal_id'])) {
    $meal_id = $_GET['meal_id'];

    $query = "SELECT * FROM meals
        INNER JOIN categories ON meals.catagory_id = categories.catagory_id
        INNER JOIN food_origin ON meals.origin_id = food_origin.origin_id
        WHERE mealid = '{$meal_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $meal_id = $row["mealid"];
        $meal_name = $row["meal_name"];
        $meal_description = $row["description"];
        $meal_price = $row["price"];
        $catagory_id = $row["catagory_id"];
        $catagory_name = $row["catagory_name"];
        $origin_id = $row["origin_id"];
        $meal_img = $row["meal_img"];
    }
}

if (isset($_POST['submit'])) {
    $meal_id = $_POST['meal_id'];
    $meal_name = $_POST['meal_name'];
    $meal_description = $_POST['meal_description'];
    $meal_price = $_POST['meal_price'];
    $catagory_id = $_POST['catagory_id'];
    $origin_id = $_POST['origin_id'];


    $req_feild = array("meal_name", "meal_description");

    $error = array();

    $error = array_merge($error, check_req_field($req_feild));

    $min_len = array("meal_name" => 3, "meal_description" => 3);

    $error = array_merge($error, min_len_check($min_len));
    if ($meal_price < 10) {
        $error[] = "Enter Valid Price";
    }

    if ($origin_id == 'empty') {
        $error[] = "Catagory couldn't be empty";
    }

    if ($catagory_id == 'empty') {
        $error[] = "Catagory couldn't be empty";
    }

    if (empty($error)) {
        $meal_name = mysqli_real_escape_string($conn, $_POST['meal_name']);
        $meal_id = mysqli_real_escape_string($conn, $_POST['meal_id']);
        $meal_img = mysqli_real_escape_string($conn, $_POST['meal_img']);
        $meal_description = mysqli_real_escape_string($conn, $_POST['meal_description']);
        $catagory_id = mysqli_real_escape_string($conn, $_POST['catagory_id']);
        $origin_id = mysqli_real_escape_string($conn, $_POST['origin_id']);
        $meal_price = mysqli_real_escape_string($conn, $_POST['meal_price']);

        if (!$_FILES["meal_img"]["size"] < 1) {
            $path = "img_upload/";
            $img_name = $_FILES['meal_img']['name'];
            $tmp_name = $_FILES['meal_img']['tmp_name'];

            $uniqueId = uniqid('', true);

            unlink($meal_img);

            $img_path = $path . $uniqueId . $img_name;

            $query = "UPDATE meals SET meal_img ='{$img_path}' WHERE mealid='{$meal_id}'";

            $result = mysqli_query($conn, $query);

            query_check($result);

            $file_uploaded = move_uploaded_file($tmp_name, $path . $uniqueId . $img_name);
        }

        $query = "UPDATE meals SET meal_name = '{$meal_name}' , description='{$meal_description}' , price='{$meal_price}' ,
                  catagory_id ='{$catagory_id}' , origin_id='{$origin_id}' WHERE mealid='{$meal_id}'";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ =  "Meal Updated!";

        header("refresh:2;url=managemeals.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meals</title>
</head>


<?php
if ($_SESSION['usertype'] == "normaluser") {
    include("./inc/mainheader.php");
} else if ($_SESSION['usertype'] == "SystemAdmin") {
    include("./inc/adminheader.php");
} else if ($_SESSION['usertype'] == "operational") {
    include("./inc/opheader.php");
}

?>

<body>
    <div class="container">
        <form action="updatemeals.php" method="post" enctype="multipart/form-data">
            <div>
                <?php
                if (isset($error)) {
                    displayErrors($error);
                }

                ?>
            </div>
            <?php
            if (isset($succ)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo    "Meal Updated Successfull!";
                echo  "</div>";
            }
            ?>
            <input type="hidden" class="form-control" id="meal_id" <?php if (isset($meal_id)) {
                                                                        echo "value=\"" . $meal_id . "\"";
                                                                    } ?> name="meal_id">
            <input type="hidden" name="meal_img" <?php if (isset($meal_img)) {
                                                        echo "value=\"" . $meal_img . "\"";
                                                    } ?>>
            <div class="mb-3">
                <label for="meal_name" class="form-label">Meal Name</label>
                <input type="text" class="form-control" id="meal_name" <?php if (isset($meal_name)) {
                                                                            echo "value=\"" . $meal_name . "\"";
                                                                        } ?> name="meal_name" placeholder="Pizza">
            </div>


            <div class="mb-3">
                <label for="meal_description" class="form-label">Meal Description</label>
                <input type="text" class="form-control" id="meal_description" <?php if (isset($meal_description)) {
                                                                                    echo "value=\"" . $meal_description . "\"";
                                                                                } ?> name="meal_description" placeholder="About food .....">
            </div>

            <div class="mb-3">
                <label for="meal_price" class="form-label">Meal Price</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rs. </span>
                    <input type="text" id="meal_price" name="meal_price" class="form-control" <?php if (isset($meal_price)) {
                                                                                                    echo "value=\"" . $meal_price . "\"";
                                                                                                } ?> placeholder="150" aria-label="Amount (to the nearest dollar)">
                    <span class="input-group-text">.00</span>
                </div>
            </div>

            <div class="mb-3">
                <label for="meal_img" class="form-label">Meal Catagory</label>
                <select class="form-select" id="catagory-select" name="catagory_id" aria-label="Default select example">
                    <option selected value="empty">Open this select menu</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="meal_img" class="form-label">Origin Catagory</label>
                <select class="form-select" id="origin-select" name="origin_id" aria-label="Default select example">
                    <option selected value="empty">Open this select menu</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="meal_img" class="form-label">Meal Name</label>
                <input type="file" class="form-control" id="meal_img" onchange="previewImage(this)" name="meal_img" placeholder="Albert">
            </div>
            <div class="mb-3">
                <img id="preview" src="#" class="img-fluid" alt="Image Preview" style="display: none; width: 250px; height: 250px;">
            </div>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn bg-primary ">Submit</button>
            </div>

        </form>


    </div>
</body>
</body>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').show(); // Show the image preview
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            // Handle browsers that don't support FileReader API
        }
    }

    $(document).ready(() => {
        if (Object.keys(catagories).length >= 1) {
            Object.keys(catagories).forEach((key) => {
                $("#catagory-select").append("<option id=\"" + catagories[key] + "\" value=\"" + key + "\">" + catagories[key] + "</option>")
            });
        } else {
            $("#catagory-select").append("<option value='empty'>Items not found</option>");
        }

        if (Object.keys(origins).length >= 1) {
            Object.keys(origins).forEach((key) => {
                $("#origin-select").append("<option class=\"" + key + "\" value=\"" + key + "\">" + origins[key] + "</option>")
            });
        } else {
            $("#origin-select").append("<option value='empty'>Items not found</option>");
        }

        <?php if (isset($catagory_id)) { ?>
            $("#catagory-select").val("<?php echo $catagory_id; ?>");
        <?php } ?>

        <?php if (isset($origin_id)) { ?>
            $("#origin-select").val("<?php echo $origin_id; ?>");
        <?php } ?>
    });
</script>








</html>