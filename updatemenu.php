<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

?>

<?php

if (!isset($_GET['menu_id']) && !isset($_POST['submit'])) {
    header("Location: managemenus.php?selectuser=false");
}


?>


<?php

if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];

    $query = "SELECT * FROM menus WHERE menu_id = '{$menu_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $menu_id = $row["menu_id"];
        $menu_name = $row["menu_name"];
        $menu_img = $row["menu_img"];

        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
    }
}

if (isset($_POST['submit'])) {
    $menu_id = $_POST['menu_id'];
    $menu_name = $_POST['menu_name'];

    $req_feild = array("menu_name");

    $error = array();

    $error = array_merge($error, check_req_field($req_feild));

    $min_len = array("menu_name" => 3);

    $error = array_merge($error, min_len_check($min_len));

    if (empty($error)) {
        $menu_name = mysqli_real_escape_string($conn, $_POST['menu_name']);
        $menu_id = mysqli_real_escape_string($conn, $_POST['menu_id']);
        $menu_img = mysqli_real_escape_string($conn, $_POST['menu_img']);

        if (!$_FILES["menu_img"]["size"] < 1) {
            $path = "img_upload/";
            $img_name = $_FILES['menu_img']['name'];
            $tmp_name = $_FILES['menu_img']['tmp_name'];

            $uniqueId = uniqid('', true);

            $unlink = unlink($menu_img);

            $img_path = $path . $uniqueId . $img_name;

            $query = "UPDATE menus SET menu_img ='{$img_path}' WHERE menu_id='{$menu_id}'";

            $result = mysqli_query($conn, $query);

            query_check($result);

            $file_uploaded = move_uploaded_file($tmp_name, $path . $uniqueId . $img_name);
        }

        $query = "UPDATE menus SET menu_name = '{$menu_name}' WHERE menu_id='{$menu_id}'";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "Meal Updated!";

        header("refresh:2;url=managemenus.php");
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
        <form action="updatemenu.php" method="post" enctype="multipart/form-data">
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
                echo    "Menu Updated Successfull!";
                echo  "</div>";
            }
            ?>
            <input type="hidden" class="form-control" id="mean_id" <?php if (isset($menu_id)) {
                                                                        echo "value=\"" . $menu_id . "\"";
                                                                    } ?> name="menu_id">
            <input type="hidden" name="menu_img" <?php if (isset($menu_img)) {
                                                        echo "value=\"" . $menu_img . "\"";
                                                    } ?>>

            <div class="mb-3">
                <label for="menu_img" class="form-label">Menu Image</label>
                <input type="text" class="form-control" id="menu_img" name="menu_name" placeholder="Albert" <?php if (isset($menu_img)) {
                                                                                                                echo "value=\"" . $menu_name . "\"";
                                                                                                            } ?>>
            </div>

            <div class="mb-3">
                <label for="menu_img" class="form-label">Menu Image</label>
                <input type="file" class="form-control" id="menu_img" onchange="previewImage(this)" name="menu_img" placeholder="Albert">
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
</script>








</html>