<?php
    include("connect.php");

    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $imagedata = file_get_contents($_FILES['image']['tmp_name']);
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO imagesent (groupid, timesent, sender, imagedata) VALUES ('$groupid', '$date', '$username', ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $imagedata);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo 'Image data received and saved successfully.';
    } else {
        echo 'Error preparing SQL statement.';
    }
?>
