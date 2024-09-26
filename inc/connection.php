<?php
$conn = mysqli_connect("localhost", "root", "", "gallerycafe");

if (!$conn) {
    die("Connection Faild!" . mysqli_connect_error());
}
