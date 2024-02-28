<?php
    session_start();

    try{
    include("connect.php");
    $code = filter_input(INPUT_POST, "groupCode", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "SELECT groupid FROM chatgroup WHERE joincode = '$code'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $groupid = mysqli_fetch_assoc($result)["groupid"];
        $username = $_SESSION["username"];
        $sql = "INSERT INTO groups2users (groupid, user) VALUES ('$groupid', '$username')";
        mysqli_query($conn, $sql);
        echo "<script> location.href='studentGroups.php"."?groupid=".$groupid."'; </script>";
    }
    else{
        echo"invalid code";
    }
    }
    catch(mysqli_sql_exception){
        echo"invalid code";
    }

?>