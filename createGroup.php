<?php
    session_start();
    include("connect.php");
    //this creates an 8 character long, random alphaneumeric string. 
    //it does this by getting an 8 character substring of the current time hashed.
    $code = substr(sha1(time()), 0, 8);
    $groupname = filter_input(INPUT_POST, "groupName", FILTER_SANITIZE_SPECIAL_CHARS);
    $user = $_SESSION["username"];
    $sql = "INSERT INTO chatgroup (groupname, creatorname, joincode) VALUES ('$groupname', '$user', '$code')";
    mysqli_query($conn, $sql);
    $sql = "SELECT groupid FROM chatgroup WHERE joincode = '$code'";
    $result = mysqli_query($conn, $sql);
    $groupid = mysqli_fetch_assoc($result)["groupid"];
    $sql="INSERT INTO groups2users (user, groupid) VALUES ('$user', '$groupid')";
    mysqli_query($conn, $sql);
    echo "<script> location.href='studentGroups.php"."?groupid=".$groupid."'; </script>";
?>