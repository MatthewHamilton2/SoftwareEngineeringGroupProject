<?php
    include("connect.php");
    //make sure to incldue a check if the user is an educator or not for security reasons; use session variables
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email, type) VALUES ('$username', '$hashedpassword', '$email', 'student')";
    mysqli_query($conn, $sql);
    echo"account created";
?>