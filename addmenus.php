<?php session_start() ?>
<?php include("./inc/req_functions.php") ?>
<?php include_once("./inc/connection.php") ?>

<?php

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($_FILES['menuimage']);
    // echo "</pre>";
    $error = [];

    $menuname = $_POST['menuname'];
    $img_name = $_FILES['menuimage']['name'];
    $temp_path = $_FILES['menuimage']['tmp_name'];
    $img_size = $_FILES['menuimage']['size'];


    $check_field = ['menuname'];

    $error = array_merge($error, check_req_field($check_field));


    $min_len = ['menuname' => 5];

    $error = array_merge($error, min_len_check($min_len));

    if ($img_size <= 0) {
        $error[] = "Add Valid Image pls";
    }


    if (empty($error)) {
        $menuname = mysqli_real_escape_string($conn, $_POST['menuname']);
        $img_name = $_FILES['menuimage']['name'];
        $tmp_name = $_FILES['menuimage']['tmp_name'];
        // $img_size = mysqli_real_escape_string($conn, $_FILES['menuimage']['size']);

        $uniqueId = uniqid('', true);

        $path = "img_upload/";

        $img_path = $path . $uniqueId . $img_name;

        $query = "INSERT INTO menus(menu_name,menu_img) VALUES('{$menuname}','{$img_path}')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        move_uploaded_file($tmp_name, $path . $uniqueId . $img_name);
        $succ = "menu Added";

        header("refresh:2;url=managemenus.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menus</title>
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
        <div class="row">
            <h2>Add Menus Here</h2>
        </div>


        <?php
        if (isset($succ)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">";
            echo    "Food Catagory Added Successfull!";
            echo  "</div>";
        }
        ?>
        <form action="addmenus.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Menu Name</label>
                    <input type="text" class="form-control" name="menuname" id="exampleFormControlInput1" placeholder="Menu one">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Menu Image</label>
                    <input type="file" onchange="previewImage(this)" class="form-control" name="menuimage" id="exampleFormControlInput1" placeholder="name@example.com">
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
                $('#preview').attr('src', e.target.result);
                $('#preview').show(); // Show the image preview
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            // Handle browsers that don't support FileReader API
        }
    }
</script>

</html>