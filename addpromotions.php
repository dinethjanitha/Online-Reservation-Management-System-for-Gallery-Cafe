<?php session_start() ?>
<?php include("./inc/req_functions.php") ?>
<?php include_once("./inc/connection.php") ?>

<?php

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($_FILES['promotion_img']);
    // echo "</pre>";
    $error = [];

    $promotion_name = $_POST['promotion_name'];
    $promotion_description = $_POST['promotion_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $img_name = $_FILES['promotion_img']['name'];
    $temp_path = $_FILES['promotion_img']['tmp_name'];
    $img_size = $_FILES['promotion_img']['size'];

    $check_field = ['promotion_name', 'promotion_description', 'start_date', 'end_date'];

    $error = array_merge($error, check_req_field($check_field));

    $min_len = ['promotion_name' => 5, 'promotion_description' => 5];

    $error = array_merge($error, min_len_check($min_len));

    if ($img_size <= 0) {
        $error[] = "Add Valid Image please";
    }

    if (empty($error)) {
        $promotion_name = mysqli_real_escape_string($conn, $promotion_name);
        $promotion_description = mysqli_real_escape_string($conn, $promotion_description);
        $start_date = mysqli_real_escape_string($conn, $start_date);
        $end_date = mysqli_real_escape_string($conn, $end_date);
        $img_name = $_FILES['promotion_img']['name'];
        $tmp_name = $_FILES['promotion_img']['tmp_name'];

        $uniqueId = uniqid('', true);

        $path = "promotion_imgs/";

        $img_path = $path . $uniqueId . $img_name;

        $query = "INSERT INTO promotions(promotion_name, promotion_description, promotion_img, start_date, end_date) VALUES('{$promotion_name}', '{$promotion_description}', '{$img_path}', '{$start_date}', '{$end_date}')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        move_uploaded_file($tmp_name, $path . $uniqueId . $img_name);
        $succ = "Promotion Added";

        header("refresh:2;url=managepromotions.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotions</title>
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
        <div class="row mt-2">
            <h2>Add Promotion Here</h2>
        </div>
        <div class="div">
            <?php if (isset($error) && !empty($error)) {
                echo "<h3>Errors</h3>";
                echo "<ul>";
                foreach ($error as $er) {
                    echo "<li>" . $er . "</li>";
                }
                echo "</ul>";
            } ?>
        </div>

        <?php
        if (isset($succ)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">";
            echo "Promotion Added Successfully!";
            echo "</div>";
        }
        ?>
        <form action="addpromotions.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3">
                    <label for="promotion_name" class="form-label">Promotion Name</label>
                    <input type="text" class="form-control" name="promotion_name" id="promotion_name" placeholder="Promotion one">
                </div>
                <div class="mb-3">
                    <label for="promotion_description" class="form-label">Promotion Description</label>
                    <input type="text" class="form-control" name="promotion_description" id="promotion_description" placeholder="Promotion Description">
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" id="start_date">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
                <div class="mb-3">
                    <label for="promotion_img" class="form-label">Promotion Image</label>
                    <input type="file" onchange="previewImage(this)" class="form-control" name="promotion_img" id="promotion_img">
                </div>
                <div class="mb-3">
                    <img id="preview" src="#" class="img-fluid" alt="Image Preview" style="display: none; width: 250px; height: 250px;">
                </div>
                <div class="mb-3">
                    <button type="submit" name="submit" class="btn bg-info">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('preview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>